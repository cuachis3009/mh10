function randomString(length) {

    if(typeof length == "undefined"){
        length = 5;
    }

    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function createOptionsSelect(list_options,option_default,id,campo){
    options = '';

    if(typeof option_default !== 'undefined' && option_default !== null){
        options += option_default;
    }

    if(typeof id == 'undefined'){
        id = 'id';
    }

    if(typeof campo == 'undefined'){
        campo = 'name';
    }

    if(typeof list_options !== 'undefined'){
        if(list_options.length > 0){
            list_options.forEach(function(value,index){
                options += '<option value="'+value[id]+'">'+value[campo]+'</option>'
            });
        }
    }

    return options;
}

function showValidateErrors(errors){
    let loop = 1;
    let focus_element = null;
    $.each(errors,function(index,value){
        console.log(index);
        //<label id="name-error" class="error" for="name">Ingresa tu nombre(s)</label>
        if(loop == 1){
            focus_element = $("#" + index);
        }
        $("#" + index).after('<label id="'+ index +'-error" class="error" for="'+index+'">'+value[0]+'</label>');
        loop++;
    });

    Swal.fire({
        icon : "warning",
        title: "Atención",
        html: "Por favor valida los datos antes de guardar",
        onAfterClose: function(){
            focus_element.focus();
        },
    });
    
}