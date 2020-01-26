/**
 * Event click sur le lien Modifier...
 * Remplace les informations par des input pour modifier les informations de l'utilisateur avant sa commande.
 */
$("#modifierUser").click(function(e){
    e.preventDefault();
    const nomUser = $("#nomUser").html();
    const prenomUser = $("#prenomUser").html();
    const telephoneUser = $("#telephoneUser").html();
    const emailUser = $("#emailUser").html();
    const adresseUser = $("#adresseUser").html();
    const villeUser = $("#villeUser").html();
    const codePostalUser = $("#codePostalUser").html();
    $("#nomUser").html("<input type='text' id='inputNom' value='"+ nomUser +"'>");
    $("#prenomUser").html("<input type='text' id='inputPrenom' value='"+ prenomUser +"'>");
    $("#telephoneUser").html("<input type='text' id='inputTelephone' value='"+ telephoneUser +"'>");
    $("#emailUser").html("<input type='text' id='inputEmail' value='"+ emailUser +"'>");
    $("#adresseUser").html("<input type='text' id='inputAdresse' value='"+ adresseUser +"'>");
    $("#villeUser").html("<input type='text' id='inputVille' value='"+ villeUser +"'>");
    $("#codePostalUser").html("<input type='text' id='inputCodePostal' value='"+ codePostalUser +"'>");

})

/**
 * Event change sur les boutons radio de choix de livraison
 * Remove ou add la class d-none pour l'affichage des tarifs de livraison, 
 * si le client choisit de se faire livrer
 */

$("input[name=livraison]").change(function(){
    if ($(this).val() == "livraison") {
        $("#tarifLivraison").removeClass("d-none");
        $("#recapLivraison").text($("#selectTarif").val());
        $("#totalFinal").text((parseFloat($("#recapLivraison").text()) + parseFloat($("#recapPanier").text())).toFixed(2));

    }else{
        $("#tarifLivraison").addClass("d-none");
        $("#recapLivraison").text("0.00");
        $("#totalFinal").text((parseFloat($("#recapLivraison").text()) + parseFloat($("#recapPanier").text())).toFixed(2));

    }
});

/**
 * Modifie tarif panier en fonction du type de livraison choisi
 */
$("#selectTarif").change(function(){
    $("#recapLivraison").text($("#selectTarif").val());
    $("#totalFinal").text((parseFloat($("#recapLivraison").text()) + parseFloat($("#recapPanier").text())).toFixed(2));
})

/**
 * Affiche ou non lien paypal pour règlement.
 */
$("#typePaiement").change(function(){
    if ($(this).val() == "Paypal") {
        $("#lienPaypal").removeClass("d-none");
    } else {
        $("#lienPaypal").addClass("d-none");

    }
})

/**
 * Récupération de la commande et sauvegarde de celle-ci.
 */

$("#commander").click()