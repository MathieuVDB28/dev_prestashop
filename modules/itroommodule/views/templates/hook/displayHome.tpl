{if $isLogged === true}
    <h2>Bonjour, veuillez trouver les dernières informations du site.</h2>
    <p>Nombre total de produits : {$totalProducts}</p>
    <p>Coût moyen du panier : {$averageCart}€</p>
    <p>Produit le plus vendu : <a href="{{$mostOrderedProduct['url']}}">{$mostOrderedProduct['name']}</a></p>
{else}
    <h2>Bonjour, veuillez vous connecter pour accéder aux informations du site.</h2>
{/if}