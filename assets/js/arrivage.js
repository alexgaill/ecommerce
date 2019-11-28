let i = 1;

function getCards(datas, elem) {
    for ( let data of datas) {
        elem.append('<option>' + data.name +' - '+ data.setCode+ '</option>')
    }
}

$("#addMore").click(function(){
    $("tbody").append("<tr class='ajout "+ i +"'></tr>")
    $("."+ i).append('<td class="cardName"><input list="cardName'+ i +'" name="cardName"><datalist id="cardName'+ i +'"></datalist></td>')
    $("."+ i).append('<td><input type="text" name="typeEntry" class="typeEntry col-lg-auto"></td>')
    $("."+ i).append('<td><input type="number" name="new" class="new col-lg-auto"></td>')
    $("."+ i).append('<td><input type="number" name="correct" class="correct col-sm-auto"></td>')
    $("."+ i).append('<td><input type="number" name="occasion" class="occasion col-xl"></td>')
    $("."+ i).append('<td><input type="number" name="abimee" class="abimee col-xl"></td>')
    $("."+ i).append('<td class="total"></td>')

    let selectCardName = $("."+ i + " .cardName datalist")
    let selectSetCode = $("." + i + " .setId")

    $.ajax({
        url:"./getCards",
        method:"GET",
        dataType:"json",
    })
    .done(function(datas){
        getCards(datas, selectCardName)
    })

    return i ++
})