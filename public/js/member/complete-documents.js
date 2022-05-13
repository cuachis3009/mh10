$(document).ready(function(){
    /**Comenzamos a realizar la validación de los datos */
    validator = $("#complete-documents").validate({
        submitHandler : function(form,event){
            event.preventDefault();
            let url = form.action;
            sendDocument(url);
        }

    });
});

function sendDocument(url){
    Swal.fire({
        title: 'Advertencia',
        html: "¿La documentación ingresa es correcta? <br> Recuerda que una vez guardada la información ya no podras editarla",
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
                html: "Guardando documentación",// add html attribute if you want or remove
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            let form = new FormData($("#complete-documents")[0]);

            axios({
                method: "POST",
                url: url,
                data : form,
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
                Swal.fire({
                    icon : "error",
                    title: "Error",
                    html: "Ha ocurrido un error al procesar tu registro, intentalo más tarde",
                });
            });
        }
    })
}