function writeParam(paramValue, paramName){
    if (location.search == ""){
        document.location = document.location + "?" + paramName +"=" + paramValue
    }else {
        let params = location.search.split("?");
        let arrayParams = params[1].split('&');
        let paramExist = false;
        let newParams = "?";

        for (const param of arrayParams) {
            if (param.split('=')[0] == paramName ){
                param = param.split('=')[0] + "=" + paramValue;
                paramExist = true;
            }
            newParams += param + "&";
        }
        if (!paramExist) {
            newParams += paramName + "=" + paramValue + "&";
        }
        location.search =  newParams.slice(0,-1);
    }
}

function checkParam(checkbox, paramName){
    if(location.search != ""){

        let params = location.search.split("?");
        let arrayParams = params[1].split('&');

        for (const param of arrayParams) {
            if (param.split('=')[0] == paramName ){

                let useParams = param.split('=')[1];
                let activeParam = useParams.split(',');

                for (const input of checkbox) {
                    for (const eachParam of activeParam){
                        console.log(activeParam)
                        if (input.getAttribute("data-etat") != null &&
                            input.getAttribute("data-etat") != ""){
                            if (input.dataset.etat == eachParam){
                                input.checked = true;
                            }
                        }
                        if (input.getAttribute("data-type") != null &&
                            input.getAttribute("data-type") != ""){
                            if (input.dataset.type == eachParam){
                                input.checked = true;
                            }
                        }
                    }
                }
            }
        }       
    }
}
                
checkParam($("input[name=etat]"), "etat")
checkParam($("input[name=type]"), "type")

$(".code").click(function(){
    let setCodeValue = $(this).text().split(' ')[1];

    writeParam(setCodeValue, "setCode");
})

$("input[name=etat]").change(function(){
    let stateParam = "";
    for (const input of $("input[name=etat]")) {
        if (input.checked) {
            stateParam += input.dataset.etat + ',';
        }
    }
    writeParam(stateParam.slice(0,-1), 'etat');
})

$("input[name=type]").change(function(){
    let typeParam = "";
    for (const input of $("input[name=type]")) {
        if (input.checked) {
            typeParam += input.dataset.type + ',';
        }
    }
    writeParam(typeParam.slice(0,-1), 'type');
})