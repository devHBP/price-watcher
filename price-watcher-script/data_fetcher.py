from db_connection import get_db_connection
from parsers import parsers
from config import get_chrome_options, get_chrome_service
from bs4 import BeautifulSoup
from selenium import webdriver
from datetime import datetime
import time
import requests


def scrape_with_requests(url, parser, parser_designation, parser_prix, parser_badge_rupture):
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.137 Safari/537.36'
    }
    response = requests.get(url, headers=headers)
    soup = BeautifulSoup(response.text, 'html.parser')
    designation, prix, is_out_of_stock = parser(soup, parser_designation, parser_prix, parser_badge_rupture)
    return designation, prix, is_out_of_stock


def log_scrapped_product(designation, prix, position, total):
    connection = get_db_connection()
    cursors = connection.cursor()

    query = """
        INSERT INTO scraped_products (designation, prix, position, total, created_at)
        VALUES (%s, %s, %s, %s, %s)
    """
    cursors.execute(query, (designation, prix, position, total, datetime.now()))
    connection.commit()

    cursors.close()
    connection.close()


def clear_scraped_products():
    connection = get_db_connection()
    cursor = connection.cursor()

    query = "DELETE FROM scraped_products"
    cursor.execute(query)
    connection.commit()
    cursor.close()
    connection.close()


def fetch_product_data():
    connection = get_db_connection()
    cursors = connection.cursor(dictionary=True)

    query = """
        SELECT pc.url_produit, pc.css_pick_designation, pc.css_pick_prix, pc.css_pick_badge_rupture, pc.id, cuc.url_complement as categorie_url, c.url as concurrent_url
        FROM produits_concurrents pc
        JOIN categories_url_concurrents cuc ON pc.categorie_url_concurrent_id = cuc.id
        JOIN concurrents c ON pc.concurrent_id = c.id
    """
    cursors.execute(query)
    products = cursors.fetchall()

    cursors.close()
    connection.close()

    return products


def compose_full_url(concurrent_url, categorie_url, url_produit):
    if not concurrent_url.endswith('/'):
        concurrent_url += '/'

    return f"{concurrent_url}{categorie_url}{url_produit}"


def update_product_data(id_produit, prix, designation, is_out_of_stock):
    connection = get_db_connection()
    cursors = connection.cursor()

    query = """
        UPDATE produits_concurrents
        SET prix_concurrent = %s, designation_concurrent = %s, updated_at = %s, is_out_of_stock = %s
        WHERE id = %s
    """

    cursors.execute(query, (prix, designation, datetime.now(), is_out_of_stock, id_produit))
    connection.commit()

    cursors.close()
    connection.close()


def update_designation(id_produit, designation):
    connection = get_db_connection()
    cursors = connection.cursor()        
    query = """
        UPDATE produits_concurrents
        SET designation_concurrent = %s
        WHERE id = %s
    """

    cursors.execute(query, (designation, id_produit))
    connection.commit()

    cursors.close()
    connection.close()


def main():
    chrome_options = get_chrome_options()
    driver = webdriver.Chrome(service=get_chrome_service(), options=chrome_options)
    driver.execute_script("Object.defineProperty(navigator, 'webdriver', {get: () => undefined})")

    products = fetch_product_data()
    total_products = len(products)

    for index, product in enumerate(products, start=1):
        # Adaptation des parsers on se base sur la base url du concurrent
        base_url = product['concurrent_url']

        parser = parsers.get(base_url)
        if not parser:
            print(f"Pas de parser disponible pour cet URL {base_url}")
            continue

        full_url = compose_full_url(product['concurrent_url'], product['categorie_url'], product['url_produit'])
        parser_designation = product['css_pick_designation']
        parser_prix = product['css_pick_prix']
        parser_badge_rupture = product['css_pick_badge_rupture']

        if 'raquette-padel.com' in base_url or 'sportlet.store' in base_url:
            try:
                time.sleep(2)
                designation, prix, is_out_of_stock = scrape_with_requests(full_url, parser, parser_designation, parser_prix, parser_badge_rupture)
                update_product_data(product['id'], prix, designation, is_out_of_stock)
                log_scrapped_product(designation, prix, index, total_products)
                print("Passage dans le scrapping basique")
                print(designation, prix, is_out_of_stock)
            except Exception as error:
                print(f"Erreur lors du traitement de {full_url} avec requests: {str(error)}")
        else:
            try:
                driver.get(full_url)
                time.sleep(4)
                
                page_source = driver.page_source
                soup = BeautifulSoup(page_source, 'html.parser')
                designation, prix , is_out_of_stock= parser(soup, parser_designation, parser_prix, parser_badge_rupture)
                update_product_data(product['id'], prix, designation, is_out_of_stock)
                log_scrapped_product(designation, prix, index, total_products)
                print(designation, prix, is_out_of_stock)
            except Exception as error:
                print(f"Erreur lors du traitement de {full_url}: {str(error)}")

    driver.quit()
    clear_scraped_products()

    try:
        response = requests.post('https://concurrence.h-bp.fr/services/controle-prix')
        if response.status_code == 200:
            print('Analyse des tarifs terminée.')
        else:
            print(f"Erreur HTTP: {response.status_code} - {response.text}")
    except requests.exceptions.RequestException as e:
        print(f"Erreur lors de l'appel de la route post : {e}")
    except Exception as error:
        print(f'Erreur : {error}')

if __name__ == "__main__":
    main()