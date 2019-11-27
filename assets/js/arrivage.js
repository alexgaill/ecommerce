let i = 1;

function getCards(datas, elem) {
    console.log(elem)
    for ( let data of datas) {
        // elem.append('<option value="' + data.id + '">' + data.name + '</option>')
    }
}

$("#addMore").click(function(){
    $("tbody").append("<tr class='ajout "+ i +"'></tr>")
    $("."+ i).append('<td class="cardName"><select name="cardName"></select></td>')
    $("."+ i).append('<td><select name="setId" class="setId"></select></td>')
    $("."+ i).append('<td><input type="text" name="typeEntry" class="typeEntry"></td>')
    $("."+ i).append('<td><input type="number" name="new" class="new"></td>')
    $("."+ i).append('<td><input type="number" name="correct" class="correct"></td>')
    $("."+ i).append('<td><input type="number" name="occasion" class="occasion"></td>')
    $("."+ i).append('<td><input type="number" name="abimee" class="abimee"></td>')
    $("."+ i).append('<td class="total"></td>')

    $.ajax({
        url:"./getCards",
        method:"GET",
        dataType:"json",
    })
    .done(function(datas){
        getCards(datas, $("."+ i + " .cardName select"))
    })

    return i ++
})