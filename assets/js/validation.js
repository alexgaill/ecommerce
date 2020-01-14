/**
 * Event change sur les boutons radio de choix de livraison
 * Remove ou add la class d-none pour l'affichage des tarifs de livraison, 
 * si le client choisit de se faire livrer
 */

$("input[name=livraison]").change(function(){
    if ($(this).val() == "livraison") {
        $("#tarifLivraison").removeClass("d-none");
        $("#recapLivraison").text($("#selectTarif").val());
        $("#totalFinal").text(parseFloat($("#recapLivraison").text()) + parseFloat($("#recapPanier").text()));

    }else{
        $("#tarifLivraison").addClass("d-none");
        $("#recapLivraison").text("0.00");
        $("#totalFinal").text(parseFloat($("#recapLivraison").text()) + parseFloat($("#recapPanier").text()));

    }
});

$("#selectTarif").change(function(){
    $("#recapLivraison").text($("#selectTarif").val());
    $("#totalFinal").text(parseFloat($("#recapLivraison").text()) + parseFloat($("#recapPanier").text()));
})