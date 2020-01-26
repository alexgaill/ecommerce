function calculSomme (sommes){
    let total = 0;

    for (let somme of sommes) {
        total += parseFloat(somme.textContent);
    }
    return total
}
function formatedPrice(price){
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price);
}

function calculTotal (price, quantity){
    if (quantity != 0) {
        return (parseFloat(price) * parseInt(quantity)).toFixed(2);
    } else {
        return "0.00"
    }
}

function affichage(){
    $("#totalTTCCarte").text(formatedPrice(calculSomme($(".totalCarte"))).toFixed(2));
    $("#totalHT").text(formatedPrice(calculSomme($(".totalCarte")).toFixed(2)));
    $("#TVA").text("0.00")
    // $("#totalHT").text(formatedPrice(parseFloat(calculSomme($(".totalCarte")))/1.2));
    // $("#TVA").text(formatedPrice(parseFloat(calculSomme($(".totalCarte"))) - parseFloat(calculSomme($(".totalCarte")))/1.2));

}


$("#quantityNew").change( function(){
    $("#totalNew").text(calculTotal($("#priceNew").text(), $("#quantityNew").val()));
    affichage();
});
$("#quantityCorrect").change( function(){
    $("#totalCorrect").text(calculTotal($("#priceCorrect").text(), $("#quantityCorrect").val()));
    affichage();
});
$("#quantityOccasion").change( function(){
    $("#totalOccasion").text(calculTotal($("#priceOccasion").text(), $("#quantityOccasion").val()));
    affichage();
});
$("#quantityAbimee").change( function(){
    $("#totalAbimee").text(calculTotal($("#priceAbimee").text(), $("#quantityAbimee").val()));
    affichage();
});

// $("#totalPanier").text(calculSomme(document.querySelectorAll(".total-col h4")));