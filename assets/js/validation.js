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
    $("#nomUser").html("<input type='text' id='inputNom' class='inputUser' value='"+ nomUser +"'>");
    $("#prenomUser").html("<input type='text' id='inputPrenom' class='inputUser' value='"+ prenomUser +"'>");
    $("#telephoneUser").html("<input type='text' id='inputTelephone' class='inputUser' value='"+ telephoneUser +"'>");
    $("#emailUser").html("<input type='text' id='inputEmail' class='inputUser' value='"+ emailUser +"'>");
    $("#adresseUser").html("<input type='text' id='inputAdresse' class='inputUser' value='"+ adresseUser +"'>");
    $("#villeUser").html("<input type='text' id='inputVille' class='inputUser' value='"+ villeUser +"'>");
    $("#codePostalUser").html("<input type='text' id='inputCodePostal' class='inputUser' value='"+ codePostalUser +"'>");
    $("#modifierUser").hide();
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
$("#commander").click(function(){
    if ($(".inputUser").length == 7){
        user = {
            'nom': $("#inputNom").val(),
            'prenom': $("#inputPrenom").val(),
            'telephone': $("#inputTelephone").val(),
            'mail': $("#inputEmail").val(),
            'adresse': $("#inputAdresse").val(),
            'ville': $("#inputVille").val(),
            'codePostal': $("#inputCodePostal").val()
        }
    }else{
        user = null
    }
    let livraison = $("input:checked").val();

    if (livraison == "livraison") {
        tarifValue=$("#selectTarif").val();
        tarif = tarifValue.split('/')[1];
        typeLivraison = tarifValue.split('/')[0];
    }else{
        tarif=0.00;
        typeLivraison = null;
    }

    let paiement = $("#typePaiement").val();

    let data = {
        user,
        livraison,
        typeLivraison,
        tarif,
        paiement
    }

    $.ajax({
        url:"./saveCommande",
        method:"POST",
        dataType:"json",
        data
    })
    .done(function(){
        document.location = "./thanks";
    })
})