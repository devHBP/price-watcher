from selenium import webdriver
from bs4 import BeautifulSoup
from sites import sites, sd_prices
from parsers import parsers
from config import get_chrome_options, get_chrome_service
from datetime import datetime
import json
import time

today_date = datetime.now().strftime("%Y-%m-%d")
file_name = f"results_{today_date}.json"

def main():
    chrome_options = get_chrome_options()
    driver = webdriver.Chrome(service=get_chrome_service(), options=chrome_options)
    driver.execute_script("Object.defineProperty(navigator, 'webdriver', {get: () => undefined})")

    # Ici on va venir charger nos prix de produits dans un autre tableau
    home_prices = {}
    for base_url, products in sd_prices.items():
        parser = parsers.get(base_url)
        home_prices[base_url] = []
        id = 0
        if not parser:
            print(f"Pas de parser disponible pour cet URL {base_url}")
            continue
        for product in products:
            full_url = base_url + product
            try:
                driver.get(full_url)
                time.sleep(2)
                page_source = driver.page_source
                # with open("page_source.html", "w", encoding="utf-8") as file:
                #     file.write(page_source)
                soup = BeautifulSoup(page_source, 'html.parser')
                product_title, product_price = parser(soup)
                if product_title and product_price:
                    home_prices[base_url].append({
                        "id": id,
                        "product": product_title.text.strip(),
                        "price": product_price
                    })
                    id += 1
                else:
                    print(f"Informations non trouvées pour {full_url}")
            except Exception as error:
                print(f"Erreur lors du traitement de {full_url}: {str(error)}")
        print(home_prices[base_url])


    results = {}
    # Variable du compteur
    total_items = sum(len(products) for products in sites.values())
    processed_items = 0

    for base_url, products in sites.items():
        parser = parsers.get(base_url)
        if not parser:
                print(f"Pas de parser disponible pour cet URL {base_url}")
                continue
        
        # Initialisation d'une liste pour chaque URL
        results[base_url] = []

        # Init de l'ID
        id = 0

        for product in products:
            full_url = base_url + product
            try:
                driver.get(full_url)
                # Ici on attends que tout le contenu JS soit chargé
                time.sleep(4)
                page_source = driver.page_source

                # On récup le contenu de la page via BS
                soup = BeautifulSoup(page_source, 'html.parser')

                # On appel la fonction de parsing
                product_title, product_price = parser(soup)

                if product_title and product_price:
                    results[base_url].append({
                        "product": product_title.text.strip(),
                        "price": product_price,
                        "start-distrib-price": home_prices["https://www.start-distrib.com/"][id]["price"]
                    })
                else:
                    print(f"Informations non trouvées pour {full_url}")
                id += 1

            except Exception as error:
                print(f"Erreur lors du traitement de {full_url}: {str(error)}")

            processed_items += 1
            print(f"Traitement de : {processed_items}/{total_items}")

    driver.quit()

    view_array = {}
    
    products_title = [
        "RAQUETTE DE PADEL NOX AT10 GENIUS 18K BY AGUSTIN TAPIA 2024",
        "RAQUETTE DE PADEL NOX AT GENIUS ATTACK 18K 2024",
        "RAQUETTE DE PADEL NOX AT10 GENIUS 12K BY AGUSTÌN TAPIA 2024",
        "RAQUETTE DE PADEL NOX ML10 BAHIA LUXURY SERIES 2024",
        "RAQUETTE DE PADEL NOX AT PRO CUP GENIUS 2024"
    ]
    # Tentative de réarragement de la sortie JSON
    for site, products in results.items():
        id = 0
        for product_info in products:
            product_title = products_title[id]
            price = product_info["price"]
            start_distrib_price = home_prices["https://www.start-distrib.com/"][id]["price"]
            if product_title not in view_array:
                view_array[product_title] = {
                    "pvp" : start_distrib_price,
                    site : price
                }
            else:
                view_array[product_title][site] = price
            # Le compteur dois s'incrémenter ici
            id += 1

    json_output = json.dumps(view_array, indent=4, ensure_ascii=False)
    with open(f"./json/{file_name}", "w", encoding="utf-8") as json_file:
        json_file.write(json_output)

if __name__ == "__main__":
    main()