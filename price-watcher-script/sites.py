"""
    Pour le moment respecter cet ordre de produits:
    0 : AT10 GENIUS 18K par Agustin Tapia 2024
    1 : AT GENIUS ATTACK 18k 2024
    2 : AT10 GENIUS 12K par Agustin Tapia 2024
    3 : ML10 BAHIA 2024
    4 : AT PRO CUP GENIUS 2024
"""

# Array des produits à récupérer
sites = {
    "https://esprit-padel-shop.com/": [
        "products/raquette-de-padel-nox-at10-genius-18k-by-agustin-tapia-2024",
        "products/raquette-de-padel-nox-at-genius-attack-18k-2024",
        "products/raquette-de-padel-nox-at10-genius-12k-by-agustin-tapia-2024",
        "products/raquette-de-padel-nox-ml10-bahia-2024",
        "products/raquette-de-padel-nox-at-pro-cup-genius-2024"
    ],
    "https://www.frenchpadelshop.com/": [
        "raquettes-homme/2585-raquette-de-padel-nox-at10-genius-18k-alum-2024-8436603195836.html",
        "raquettes-homme/2583-raquette-de-padel-nox-at-genius-attack-18k-alum-2024-8436603195829.html",
        "raquettes-homme/2586-raquette-de-padel-nox-at10-genius-12k-2024-8436603195843.html",
        "raquettes-homme/2588-raquette-de-padel-nox-ml10-luxury-bahia-12k-2024-8436603195867.html",
        "raquettes-homme/2590-raquette-de-padel-nox-at-pro-cup-coorp-2024-8436603195911.html"
    ],
    "https://www.padelxp.com/" : [
        "raquettes-de-padel/2585-raquette-de-padel-nox-at10-genius-18k-alum-2024-8436603195836.html",
        "raquettes-de-padel/2583-raquette-de-padel-nox-at-genius-attack-18k-alum-2024-8436603195829.html",
        "raquettes-de-padel/2586-raquette-de-padel-nox-at10-genius-12k-2024-8436603195843.html",
        "raquettes-de-padel/2588-raquette-de-padel-nox-ml10-luxury-bahia-12k-2024-8436603195867.html",
        "raquettes-de-padel/2590-raquette-de-padel-nox-at-pro-cup-coorp-2024-8436603195911.html"
    ],
    "https://www.padelreference.com/fr/": [
        "raquettes-de-padel/p/nox-at10-genius-18k-by-agustin-tapia-2024",
        "raquettes-de-padel/p/nox-at-genius-attack-18k-agustin-tapia-2024",
        "raquettes-de-padel/p/nox-at10-genius-12k-by-agustin-tapia-2024",
        "raquettes-de-padel/p/nox-ml10-bahia-luxury-series-12k-2024",
        "raquettes-de-padel/p/nox-at10-pro-cup-genius-2024"
    ],
    "https://www.extreme-padel.fr/": [
        "raquettes-de-padel-nox/18181-raquette-nox-at10-genius-18k-2024.html",
        "raquettes-de-padel-nox/18183-raquette-nox-at-genius-attack-18k-2024.html",
        "raquettes-de-padel-nox/18177-raquette-nox-at10-genius-12k-2024.html",
        "raquettes-de-padel-nox/18185-raquette-nox-ml10-bahia-12k-luxury-2024.html",
        "raquettes-de-padel-nox/18188-raquette-nox-at-pro-cup-genius-2024.html"
    ],
    "https://www.raquette-padel.com/": [
        "achat-vente-raquettes-padel-paddle/3947-raquette-de-padel-at10-luxury-genius-18k-alum-2024-par-agustin-tapia-8436603195836.html",
        "achat-vente-raquettes-padel-paddle/3950-raquette-de-padel-at-genius-attack-18k-8436603195829.html",
        "achat-vente-raquettes-padel-paddle/3949-raquette-de-padel-at10-luxury-genius-12k-2024-by-agustin-tapia-8436603195843.html",
        "achat-vente-raquettes-padel-paddle/4050-raquette-de-padel-ml10-bahia-12k-luxury-series-24-8436603195867.html",
        "achat-vente-raquettes-padel-paddle/3948-raquette-de-padel-at10-pro-cup-coorp-2024-8436603195911.html"
    ],
    "https://padel-par4.com/": [
        "products/nox-raquette-de-padel-at10-genius-18k-by-agustin-tapia-2024",
        "products/nox-raquette-de-padel-at10-genius-attack-18k",
        "products/nox-raquette-de-padel-at10-genius-12k-by-agustin-tapia-2024",
        "products/nox-raquette-de-padel-ml10-bahia-luxury-series-2024",
        "products/nox-raquette-de-padel-at-pro-cup-genius-2024"
    ]
}
sd_prices = {
    "https://www.start-distrib.com/": [
    "produit/at10-genius-18k-racket-by-agustin-tapia/",
    "produit/at-genius-attack-18k-racket/",
    "produit/at10-genius-12k-racket-by-agustin-tapia/",
    "produit/ml10-bahia-12k-luxury-series-racket/",
    "produit/at-pro-cup-coorp-racket/"
    ],
}