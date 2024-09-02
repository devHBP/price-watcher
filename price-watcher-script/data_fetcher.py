from db_connection import get_db_connection
from parsers import parsers
from config import get_chrome_options, get_chrome_service
from bs4 import BeautifulSoup
from selenium import webdriver
import time

def fetch_product_data():
    connection = get_db_connection()
    cursors = connection.cursor(dictionary=True)

    query = """
        SELECT pc.url_produit, pc.css_pick_designation, pc.css_pick_prix, pc.id, cuc.url_complement as categorie_url, c.url as concurrent_url
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

def update_product_data(id_produit, prix, designation):
    connection = get_db_connection()
    cursors = connection.cursor()

    query = """
        UPDATE produits_concurrents
        SET prix_concurrent = %s, designation_concurrent = %s
        WHERE id = %s
    """

    cursors.execute(query, (prix, designation, id_produit))
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

    for product in products:
        # Adaptation des parsers on se base sur la base url du concurrent
        base_url = product['concurrent_url']
        parser = parsers.get(base_url)
        if not parser:
            print(f"Pas de parser disponible pour cet URL {base_url}")
            continue

        full_url = compose_full_url(product['concurrent_url'], product['categorie_url'], product['url_produit'])
        parser_designation = product['css_pick_designation']
        parser_prix = product['css_pick_prix']
        #print(f"URL complète: {full_url}")
        #print(f"Parsing désignation : {parser_designation}, Parser prix : {parser_prix}")
        try:
            driver.get(full_url)
            time.sleep(4)
            page_source = driver.page_source
            soup = BeautifulSoup(page_source, 'html.parser')
            designation, prix = parser(soup, parser_designation, parser_prix)
            update_product_data(product['id'], prix, designation)
            print(designation, prix)
        except Exception as error:
            print(f"Erreur lors du traitement de {full_url}: {str(error)}")

    driver.quit()

if __name__ == "__main__":
    main()