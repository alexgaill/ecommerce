let i = 1;

/**
 * Créé un elmt dans la datalist pour chaque produit présent dans la bdd
 * @param {array} datas 
 * @param {object} elem 
 */
function getCards(datas, elem) {
    for ( let data of datas) {
        elem.append('<option value="'+ data.setCode +'">' + data.name +' - '+ data.setCode+ '</option>');
    }
}
/**
 * Calcul le coût total d'achat d'une ligne de produit
 * @param {float} cost 
 * @param {int} newCard 
 * @param {int} correct 
 * @param {int} occasion 
 * @param {int} abimee 
 * @return {float}
 */
function totalPrice(cost, newCard, correct, occasion, abimee){
    let totalNew = cost * newCard;
    let totalCorrect = cost * correct * 0.9;
    let totalOccasion = cost * occasion * 0.8;
    let totalAbimee = cost * abimee * 0.6;

    return (totalNew + totalCorrect + totalOccasion + totalAbimee).toFixed(2);
}
/**
 * Créé une ligne d'ajout de carte à acheter
 * @param {int} key 
 */
function createLine (key){
    $("tbody").append("<tr class='ajout "+ key +"'></tr>");
        $("."+ key).append('<td class="cardName"><input list="cardName" name="cardName"><datalist id="cardName"></datalist></td>');
        $("."+ key).append('<td><input type="text" name="typeEntry" class="typeEntry col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="new" class="new col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="correct" class="correct col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="occasion" class="occasion col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="abimee" class="abimee col-lg-auto"></td>');
        $("."+ key).append('<td class="prixAchat col-lg-auto"></td>');
        $("."+ key).append('<td class="total"></td>');
}

/**
 * Calcul le montant total d'achat des différentes lignes et l'affiche
 */
function montantTotal(){
    let totalHT = 0;
    for (const line of $(".total")) {
        totalHT += parseFloat(line.textContent);
    }
    $("#totalHT").text(totalHT.toFixed(2));
    $("#totalTTC").text(totalHT.toFixed(2));
}

/**
 * Affiche les coordonnées du vendeur
 */
$("#sellerId").change(function(){
    $.ajax({
        url: "./getSeller/" + $(this).val(),
        method:"GET",
        dataType: 'json'
    })
    .done(function (data) {
        $("#nomClient").val(data.nom);
        $("#prenomClient").val(data.prenom);
        $("#telephone").val(data.telephone);
        $("#mail").val(data.email);
        $("#adresse").val(data.adresse);
        $("#codePostal").val(data.code_postal);
        $("#ville").val(data.ville);
    })
})
/**
 * Charge les produits pour la datalist
 */
$.ajax({
        url:"./getCards",
        method:"GET",
        dataType:"json"
})
.done(function(datas){

    /**
     * Créé une nouvelle ligne au click
     */
    $("#addMore").click(function(){
        
        createLine(i);

        let selectCardNameDatalist = $("."+ i + " .cardName datalist");
        let selectCardNameInput = $("."+ i + " .cardName input");
        let selectCostPrice = $("." + i + " .prixAchat");
        let total = $("." + i + " .total");
        let newQty = $("." + i + " .new");
        let correctQty = $("." + i + " .correct");
        let occasionQty = $("." + i + " .occasion");
        let abimeeQty = $("." + i + " .abimee");

        getCards(datas, selectCardNameDatalist);

        /**
         * Au choix du produit, récupère son prix d'achat
         */
        selectCardNameInput.change(function(){
            $.ajax({
                url:"./getCost/" + $(this).val(),
                method:"GET",
                dataType:"json"
            })
            .done(function(datas){

                /**
                 * Au changement d'une quantité, calcul et affiche le prix d'achat de la ligne.
                 */
                selectCostPrice.text(datas.cost);

                newQty.change(function(){ 
                    let price = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.html(price);
                    montantTotal();
                })
                correctQty.change(function(){ 
                    let price = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.html(price);
                    montantTotal();
                })
                occasionQty.change(function(){      
                    let price = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.html(price);
                    montantTotal();          
                })
                abimeeQty.change(function(){      
                    let price = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.html(price);
                    montantTotal();  
                })
            })
        })
        return i ++
    })
    /**
     * Jsonifie les données pour les envoyer dans le back.
     */
    $("#enregistrer").click(function(){

        let cartes = [];
        for (let j = 1; j <= i; j++) {            
            cartes.push({
                setCode: $("."+ j + " .cardName input").val(),
                type: $("."+ j + " .typeEntry").val(),
                new: $("."+ j + " .new").val(),
                correct: $("."+ j + " .correct").val(),
                occasion: $("."+ j + " .occasion").val(),
                abimee: $("."+ j + " .abimee").val(),
                totalHT: $("."+ j + " .total").html()
            })
        }
        $.ajax({
            url:"./saveArrivage",
            method:"POST",
            dataType:"json",
            data:{
                nomArrivage: $("#nomArrivage").val(),
                client:{
                    id: $("#sellerId").val(),
                    nom: $("#nomClient").val(),
                    prenom: $("#prenomClient").val(),
                    telephone: $("#telephone").val(),
                    mail: $("#mail").val(),
                    adresse: $("#adresse").val(),
                    codePostal: $("#codePostal").val(),
                    ville: $("#ville").val()
                },
                cartes:cartes
            }
        })
        .done(function(datas){
            document.location = "./basket/";
        })
    })

})