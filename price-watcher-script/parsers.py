def parse_start_distrib(soup):
    product_title = soup.find("h2", class_="product-title")
    product_price = soup.select("div.elementor-element.elementor-element-e5b4008.elementor-product-price-block-yes.elementor-widget.elementor-widget-woocommerce-product-price div.elementor-widget-container p.price span.woocommerce-Price-amount.amount")
    if product_price:
        product_price = product_price[0].text.replace('\xa0', '')
    return product_title, product_price

# OK
def parse_esprit_paddel_shop(soup, designation, prix):
    product_title = soup.select_one(designation)
    product_price = soup.select_one(prix)
    if product_title:
        product_title = product_title.text
    if product_price:
        product_price = product_price.text.replace('€', '')
        product_price = product_price.replace(',', '.')
        product_price = float(product_price)
    return product_title, product_price

# OK
def parse_french_padel_shop(soup, designation, prix):
    product_title = soup.select_one(designation)
    product_price = soup.select_one(prix)
    if product_title:
        product_title = product_title.text
    if product_price:
        product_price = product_price.text.replace('\xa0', '').replace('€', '')
        product_price = product_price.replace(',', '.')
        product_price = float(product_price)
    return product_title, product_price

# OK
def parse_padel_xp(soup, designation, prix):
    product_title = soup.select_one(designation)
    product_price = soup.select_one(prix)
    if product_title:
        product_title = product_title.text
    if product_price:
        product_price = product_price.text.replace('\xa0', '').replace('€', '')
        product_price = product_price.replace(',', '.')
        product_price = float(product_price)

    return product_title, product_price

"""
    Encore des joyeusetée, ici chez padel reference toute la structure et similaire je me retrouve 
    avec des prix délirants, qui sont en fait les premiers prix trouvé 17.90 le pack de balle si on ajoute une 
    raquette au panier, donc en isolant je tombe sur le 8eme index de ce que je récupère dans product_price
    donc, le prix de la raquette se trouve en product_price[7], attention surveiller en cas de prix trop déconnant, en fonction du nombre de produit accessoire 
    qu'il peut y avoir, l'index peut entierement changer.
"""
def parse_padel_reference(soup, designation, prix):
    product_title = soup.select_one(designation)
    product_price = soup.select(prix)
    print(product_price)
    # Nettoyage de la chaine de caractère "Raquette de padel\n                                                                NOX AT10 Pro Cup Genius 2024" Oo"
    if product_title:
        title = " ".join(product_title.text.split())
        # Pour éviter de modifier de nouveau le comportement, j'intervertis la property de product_title.text plutot que de renvoyer une chaine de caractere brut
        product_title.string.replace_with(title)
        product_title = product_title.text
    if product_price:
        product_price = product_price[7].text.replace('\xa0', '').replace('€', '')
        product_price = product_price.strip()
        product_price = product_price.replace(',', '.')
        product_price = float(product_price)
    return product_title, product_price

def parse_extreme_padel(soup):
    product_title = soup.find("h1", class_="product-title")
    product_price = soup.find("span", class_="price")
    if product_price:
        product_price = product_price.text.replace('\xa0', '')
        product_price = product_price.strip()
    return product_title, product_price

def parse_avantage_padel(soup):
    product_title = soup.find("h1")
    product_price = soup.find(id="our_price_display")
    return product_title, product_price.text

"""
    Chez padel_par_4 le prix est contenu dans une span qui contient une autre span ex :
    <span class="price">
        <span> "Prix de vente" </span>
    "XXX,XX€"
    </span>
    Pour contourner ça, on récupère le text complet, on nettoit les espaces inutile
    et on fait une recherche dans la string à l'ai de de la regex.  
"""
def parse_padel_par_4(soup):
    product_title = soup.find("h1", class_="product-meta__title heading h3")
    product_price = soup.find("span", class_="price price--highlight price--large")
    if product_price:
        full_text = product_price.get_text(separator=' ', strip=True)

        import re
        match = re.search(r"\d{1,3},\d{2}€", full_text)

        if match:
            product_price = match.group()
        else:
            print(f"Erreur sur le traitement du prix..")
            
    return product_title, product_price

parsers = {
    "https://www.start-distrib.com/": parse_start_distrib,
    "https://esprit-padel-shop.com/" : parse_esprit_paddel_shop,
    "https://www.frenchpadelshop.com/": parse_french_padel_shop,
    "https://www.padelxp.com/": parse_padel_xp,
    "https://www.padelreference.com/fr/": parse_padel_reference,
    "https://www.extreme-padel.fr/": parse_extreme_padel,
    "https://www.raquette-padel.com/": parse_avantage_padel,
    "https://padel-par4.com/": parse_padel_par_4
}