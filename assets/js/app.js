/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
    import '../css/animate.css';
    import '../css/app.css';
    import '../css/bootstrap.min.css';
    import '../css/flaticon.css';
    // import '../css/font-awesome.min.css';
    // import '../css/jquery-ui.min.css';
    // import '../css/owl.carousel.min.css';
    import '../css/slicknav.min.css';
    import '../css/style.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
//  require('jquery');
    const $ = require('jquery');
    global.$ = global.jQuery = $;

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
            return parseFloat(price) * parseInt(quantity);
        } else {
            return "0.00"
        }
    }

    function affichage(){
        $("#totalTTCCarte").text(formatedPrice(calculSomme($(".totalCarte"))));
        $("#totalHT").text(formatedPrice(parseFloat(calculSomme($(".totalCarte")))/1.2));
        $("#TVA").text(formatedPrice(parseFloat(calculSomme($(".totalCarte"))) - parseFloat(calculSomme($(".totalCarte")))/1.2));

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

    $("#totalPanier").text(calculSomme(document.querySelectorAll(".total-col h4")));