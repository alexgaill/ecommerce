let i = 1;

function getCards(datas, elem) {
    for ( let data of datas) {
        elem.append('<option value="'+ data.setCode +'">' + data.name +' - '+ data.setCode+ '</option>');
    }
}

function totalPrice(cost, newCard, correct, occasion, abimee){
    let totalNew = cost * newCard;
    let totalCorrect = cost * correct * 0.9;
    let totalOccasion = cost * occasion * 0.8;
    let totalAbimee = cost * abimee * 0.6;

    return (totalNew + totalCorrect + totalOccasion + totalAbimee).toFixed(2);
}

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

function montantTotal(){
    let totalHT = 0;
    for (const line of $(".total")) {
        totalHT += parseFloat(line.textContent);
    }
    $("#totalHT").text(totalHT.toFixed(2));
    $("#totalTTC").text(totalHT.toFixed(2));
}

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

$.ajax({
        url:"./getCards",
        method:"GET",
        dataType:"json"
})
.done(function(datas){
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

        selectCardNameInput.change(function(){
            $.ajax({
                url:"./getCost/" + $(this).val(),
                method:"GET",
                dataType:"json"
            })
            .done(function(datas){

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
        console.log(cartes);
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
            console.log(datas);
        })
    })

})