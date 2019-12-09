let i = 1;

function getCards(datas, elem) {
    for ( let data of datas) {
        elem.append('<option value="'+ data.setCode +'">' + data.name +' - '+ data.setCode+ '</option>')
    }
}

function totalPrice(cost, newCard, correct, occasion, abimee){
    let totalNew = cost * newCard
    let totalCorrect = cost * correct * 0.9
    let totalOccasion = cost * occasion * 0.8
    let totalAbimee = cost * abimee * 0.6

    return totalNew + totalCorrect + totalOccasion + totalAbimee
}

$("#sellerId").change(function(){
    $.ajax({
        url: "./getSeller/" + $(this).val(),
        method:"GET",
        dataType: 'json'
    })
    .done(function (data) {
        $("#nomClient").val(data.nom)
        $("#prenomClient").val(data.prenom)
        $("#telephone").val(data.telephone)
        $("#mail").val(data.email)
        $("#adresse").val(data.adresse)
        $("#codePostal").val(data.code_postal)
        $("#ville").val(data.ville)
    })
})

$("#addMore").click(function(){
    $("tbody").append("<tr class='ajout "+ i +"'></tr>")
    $("."+ i).append('<td class="cardName"><input list="cardName'+ i +'" name="cardName"><datalist id="cardName'+ i +'"></datalist></td>')
    $("."+ i).append('<td><input type="text" name="typeEntry" class="typeEntry col-lg-auto"></td>')
    $("."+ i).append('<td><input type="text" name="new" class="new col-lg-auto"></td>')
    $("."+ i).append('<td><input type="text" name="correct" class="correct col-lg-auto"></td>')
    $("."+ i).append('<td><input type="text" name="occasion" class="occasion col-lg-auto"></td>')
    $("."+ i).append('<td><input type="text" name="abimee" class="abimee col-lg-auto"></td>')
    $("."+ i).append('<td><input type="text" name="prixAchat" class="prixAchat col-lg-auto"></td>')
    $("."+ i).append('<td class="total"></td>')

    let selectCardNameDatalist = $("."+ i + " .cardName datalist")
    let selectCardNameInput = $("."+ i + " .cardName input")
    let selectCostPrice = $("." + i + " .prixAchat")

    $.ajax({
        url:"./getCards",
        method:"GET",
        dataType:"json"
    })
    .done(function(datas){
        getCards(datas, selectCardNameDatalist)
        selectCardNameInput.change(function(){
            $.ajax({
                url:"./getCost/" + $(this).val(),
                method:"GET",
                dataType:"json"
            })
            .done(function(datas){
                selectCostPrice.val(datas.cost)
                $(this).parent().children('.new').change(function(){
                    console.log('ok')
                })
            })
        })
    })

    return i ++
})