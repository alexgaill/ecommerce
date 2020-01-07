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

    return totalNew + totalCorrect + totalOccasion + totalAbimee;
}

function createLine (key){
    $("tbody").append("<tr class='ajout "+ key +"'></tr>");
        $("."+ key).append('<td class="cardName"><input list="cardName'+ key +'" name="cardName"><datalist id="cardName'+ key +'"></datalist></td>');
        $("."+ key).append('<td><input type="text" name="typeEntry" class="typeEntry col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="new" class="new col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="correct" class="correct col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="occasion" class="occasion col-lg-auto"></td>');
        $("."+ key).append('<td><input type="text" name="abimee" class="abimee col-lg-auto"></td>');
        $("."+ key).append('<td class="prixAchat col-lg-auto"></td>');
        $("."+ key).append('<td class="total"></td>');
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
                selectCostPrice.textContent = datas.cost;

                newQty.change(function(){ 
                    let totalPrice = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.textContent = totalPrice.toFixed(2);
                })
                correctQty.change(function(){ 
                    let totalPrice = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.textContent = totalPrice.toFixed(2);       
                })
                occasionQty.change(function(){      
                    let totalPrice = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.textContent = totalPrice.toFixed(2);  
                })
                abimeeQty.change(function(){      
                    let totalPrice = totalPrice(datas.cost, newQty.val(), correctQty.val(), occasionQty.val(), abimeeQty.val());
                    total.textContent = totalPrice.toFixed(2);  
                })
            })
        })
        return i ++
    })

})