$(document).ready(function(){
    validator = $("#complete-project").validate({
        rules : {
            
        },
        messages : {
            
        },
        submitHandler : function(form,event){
            event.preventDefault();
            let url = form.action;
            sendProject(url);
        }

    });
});

function sendProject(url){
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
                html: "Se esta guardando la información",// add html attribute if you want or remove
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            axios({
                method: "POST",
                url: url,
                data : $("#complete-project").serialize(),
                responseType: 'json'
            })
            .then(function (response) {
                if(response.data.res){
                    Swal.fire({
                        title: "Bien",
                        html: response.data.msg,
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
                        html: response.data.msg,
                        allowOutsideClick: false,
                    });
                }
            })
            .catch(function (error) {
                console.log(error);
                console.log(error.response);
                if(error.response.status == 422){
                    /**Hay un error en la validacion de los datos */
                    showValidateErrors(error.response.data.errors);
                }else{
                    Swal.fire({
                        icon : "error",
                        title: "Error",
                        html: "Ha ocurrido un error al procesar tu registro, intentalo más tarde",
                    });
                }
            });
        }
    })
}