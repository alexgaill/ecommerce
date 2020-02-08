$(".code").click(function(){
    // console.log($(this).text());
    let setCodeValue = $(this).text().split(' ')[1];

    if (location.search == ""){
        document.location = document.location + "?setCode=" + setCodeValue
    }else {
        let params = location.search.split("?");
        let arrayParams = params[1].split('&');

        for (const param of arrayParams) {
            if (param.split('=')[0] == 'setCode' ){
                param.split('=')[1] = setCodeValue;
            }
            
        }
    }
})