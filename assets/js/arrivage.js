let i = 1;

function getCards(datas, element) {
    datas.forEach(data => {
        element.append('<option value="' + data.id + '">' + data.name + '</option>')
    });
}

$("#addMore").click(function(){
    $("tbody").append("<tr class='ajout"+ i +"'></tr>")
    $(".ajout"+ i).append('<td class="cardName"><select name="cardName"></select></td>')
    $(".ajout"+ i).append('<td><select name="setId" class="setId"></select></td>')
    $(".ajout"+ i).append('<td><input type="text" name="typeEntry" class="typeEntry"></td>')
    $(".ajout"+ i).append('<td><input type="number" name="new" class="new"></td>')
    $(".ajout"+ i).append('<td><input type="number" name="correct" class="correct"></td>')
    $(".ajout"+ i).append('<td><input type="number" name="occasion" class="occasion"></td>')
    $(".ajout"+ i).append('<td><input type="number" name="abimee" class="abimee"></td>')
    $(".ajout"+ i).append('<td class="total"></td>')

    $.ajax({})
    $(".ajout"+ i + " .className select")

    return i ++
})