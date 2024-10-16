
# Parsing basique la décompo est simple est basique 
# Concerne esprit padel, french padel, padel xp, extrem padel, avantage padel
def parse_universel(soup, designation, prix, badge):
    product_title = soup.select_one(designation)
    product_price = soup.select_one(prix)
    product_badge_rupture = soup.select_one(badge)
    if product_title:
        product_title = product_title.text
    else:
        product_title = "Produit introuvable ou retiré."
    if product_price:
        product_price = product_price.text.replace('\xa0', '').replace('€', '')
        product_price = product_price.replace(',', '.')
        product_price = float(product_price)
    else:
        product_price = float(0)
    # Ternaire en python qui pique les yeux
    is_out_of_stock = 1 if product_badge_rupture else 0
    return product_title, product_price, is_out_of_stock

# OK
def parse_padel_reference(soup, designation, prix, badge):
    product_title = soup.select_one(designation)
    product_price = soup.select_one(prix)
    product_badge_rupture = soup.select_one(badge)
    # Nettoyage de la chaine de caractère "Raquette de padel\n                                                                NOX AT10 Pro Cup Genius 2024" Oo"
    if product_title:
        title = " ".join(product_title.text.split())
        product_title.string.replace_with(title)
        product_title = product_title.text
    else:
        product_title = "Produit introuvable ou retiré."
    if product_price:
        product_price = product_price.text.replace('\xa0', '').replace('€', '')
        product_price = product_price.strip()
        product_price = product_price.replace(',', '.')
        product_price = float(product_price)
    else:
        product_price = float(0)
    is_out_of_stock = 1 if product_badge_rupture else 0

    return product_title, product_price, is_out_of_stock

"""
    Chez padel_par_4 le prix est contenu dans une span qui contient une autre span ex :
    <span class="price">
        <span> "Prix de vente" </span>
    "XXX,XX€"
    </span>
    Pour contourner ça, on récupère le text complet, on nettoit les espaces inutile
    et on fait une recherche dans la string à l'aide de la regex.  
"""
def parse_padel_par_4(soup, designation, prix, badge):
    product_title = soup.select_one(designation)
    product_price = soup.select_one(prix)
    product_badge_rupture = soup.select_one(badge)
    if product_title:
        product_title = product_title.text
    else:
        product_title = "Produit introuvable ou retiré."
    
    if product_price:
        full_text = product_price.get_text(separator=' ', strip=True)

        import re
        match = re.search(r"\d{1,3},\d{2}€", full_text)

        if match:
            product_price = match.group()
            product_price = product_price.replace('€', '')
            product_price = product_price.replace(',', '.')
            product_price = float(product_price)
        else:
            print(f"Erreur sur le traitement du prix..")
    else:
        product_price = float(0)

    is_out_of_stock = 1 if product_badge_rupture else 0
    return product_title, product_price, is_out_of_stock

def parse_padel_kiwi(soup, designation, prix, badge):
    product_title = soup.select_one(designation)
    product_price = soup.select_one(prix)
    product_badge_rupture = soup.select_one(badge)
    if product_title:
        product_title = product_title.text
    else:
        product_title = "Produit introuvable ou retiré."

    if product_price is None:
        product_price = soup.select_one("div.price-area.product-detail__gap-sm>div.price.theme-money")
    else:
        product_price = float(0)

    if product_price:
        product_price = product_price.text.replace('\xa0', '').replace('€', '')
        product_price = product_price.replace(',', '.')
        product_price = float(product_price)
    else:
        product_price = float(0)

    is_out_of_stock = 1 if product_badge_rupture else 0
    return product_title, product_price, is_out_of_stock


parsers = {
    "https://esprit-padel-shop.com/" : parse_universel,
    "https://www.frenchpadelshop.com/": parse_universel,
    "https://www.padelxp.com/": parse_universel,
    "https://www.padelreference.com/fr/": parse_padel_reference,
    "https://www.extreme-padel.fr/": parse_universel,
    "https://www.raquette-padel.com/": parse_universel,
    "https://colizey.fr/": parse_universel,
    "https://padel-par4.com/": parse_padel_par_4,
    "https://www.padelnuestro.com/": parse_universel,
    "https://www.padelkiwi.com/fr-fr/": parse_padel_kiwi,
    "https://sportlet.store/": parse_universel,
}