$(document).ready(function(){
    /**Comenzamos a realizar la validación de los datos */
    /*validator = $("#update-member").validate({
        rules : {
            
        },
        messages : {
            
        },
        submitHandler : function(form,event){
            event.preventDefault();
            let url = form.action;
            updateMember(url);
        }

    });*/

    $("#update-member").submit(function(e){
        e.preventDefault();
        let url = this.action;
        updateMember(url);
    });

});

function updateMember(url){
    Swal.fire({
        title: 'Advertencia',
        text: "¿La información ingresada es correcta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No, revisar'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: "Espera",
                html: "Se esta guardando la información de la integrante",// add html attribute if you want or remove
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            let form = new FormData($("#update-member")[0]);

            axios({
                method: "POST",
                url: url,
                data : form,
                responseType: 'json'
            })
            .then(function (response) {
                console.log(response);
                if(response.data.res){
                    Swal.fire({
                        title: "Bien",
                        html: "Se ha actualizado la información de la integrante correctamente",
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
        
                    setTimeout(function(){
                        window.location.href = response.data.url;
                    },3000);
                }else{
                    Swal.fire({
                        icon : "warning",
                        title: "Atención",
                        html: "Ha existido un error al actualizar la información de la integrante, intentalo nuevamente",
                        allowOutsideClick: false,
                    });
                }
            })
            .catch(function (error) {
                console.log(error);
                console.log(error.response);
                if(error.response.status == 422){
                    /**Hay un error en la validacion de los datos */
                    $('.error').remove();
                    showValidateErrors(error.response.data.errors);
                }else{
                    Swal.fire({
                        icon : "error",
                        title: "Error",
                        html: "Ha ocurrido un error al actualizar a la integrante, intentalo más tarde",
                    });
                }
            });
        }
    })
}

function showValidateErrors(errors){
    let loop = 1;
    let focus_element = null;
    $.each(errors,function(index,value){
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