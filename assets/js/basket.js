/**
 * Calcul la somme des prix des produits que l'on souhaite ajouter dans le panier
 * @param {array} sommes 
 * @return {Float}
 */
function calculSomme (sommes){
    let total = 0;

    for (let somme of sommes) {
        total += parseFloat(somme.textContent);
    }
    return total.toFixed(2);
}

/**
 * Formate le total en monnaie européenne
 * @param {float} price
 * @return {float} 
 */
function formatedPrice(price){
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price);
}
/**
 * Calcul le prix de la ligne de produit en fonction de la quantité
 * @param {float} price 
 * @param {float} quantity 
 * @return {float}
 */
function calculTotal (price, quantity){
    if (quantity != 0) {
        return (parseFloat(price) * parseInt(quantity)).toFixed(2);
    } else {
        return 0.00;
    }
}
/**
 * Affiche les différents montant des produits que l'utilisateur souhaite ajouter au panier
 */
function affichage(){
    $("#totalTTCCarte").text(formatedPrice(calculSomme($(".totalCarte"))));
    $("#totalHT").text(formatedPrice(calculSomme($(".totalCarte"))));
    // $("#TVA").text("0.00");
    // $("#totalHT").text(formatedPrice(parseFloat(calculSomme($(".totalCarte")))/1.2));
    // $("#TVA").text(formatedPrice(parseFloat(calculSomme($(".totalCarte"))) - parseFloat(calculSomme($(".totalCarte")))/1.2));

}

/**
 * Modifie la valeur de la ligne en fonction de la quantité
 */
$(".quantity").change(function () {
    let total = $(this).closest('tr').find('.price').text() * $(this).val();
    $(this).closest('tr').find('.totalCarte').text(total);
    affichage();
})