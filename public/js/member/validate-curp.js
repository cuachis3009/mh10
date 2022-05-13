const btn_validate_curp = document.getElementById('btn-validate-curp');
const txt_curp = document.getElementById('txt-curp');
const txt_name = document.getElementById('name');
const txt_p_surname = document.getElementById('p_surname');
const txt_m_surname = document.getElementById('m_surname');
const txt_sluf = document.getElementById("p-slug");

btn_validate_curp.addEventListener('click',function(){

    let curp = cleanCurp(txt_curp.value);
    let slug = txt_sluf.value; 

    validateCurp(curp,slug);
});

function validateCurp(curp,slug){
    
    if(curp === ''){
        Swal.fire('¡Atención!','Por favor ingresa una CURP','warning');
    }else if(curp.length !== 18){
        Swal.fire('¡Atención!','Por favor ingresa todos los caracteres que conforman tu CURP','warning');
    }else{

        /**Mostramos una pantalla de carga */

        Swal.fire({
            title: 'Espera',
            html : 'Estamos validando el curp',
            allowEscapeKey: false,
            allowOutsideClick: false,
            onOpen: () => {
                Swal.showLoading();
            }
        });


        //var url = '{{env('APP_URL')}}';
        //HUOE920123HMSRLD00
        axios.post('/member/validate-curp', {
        //axios.post(url+'/member/validate-curp', {
            curp : curp,
            slug : slug,
            timeout: 5000
        })
        .then(function (response) {
            if(response.status === 200){
                if(response.data.error === false){
                    Swal.close();
                    txt_name.value = response.data.curp.nombre;
                    txt_p_surname.value = response.data.curp.apellidoPaterno;
                    txt_m_surname.value = response.data.curp.apellidoMaterno;
                    txt_curp.setAttribute('readonly','readonly');
                    btn_validate_curp.setAttribute('disabled','disabled');
                }else{
                    Swal.fire('¡Atención!',response.data.msg,'warning');
                }
            }else{
                Swal.fire('¡Atención!','Ha existido un error al obtener la curp, por favor intentalo nuevamente','error');
            }
        })
        .catch(function (error) {
            console.log(error);
            Swal.fire('¡Atención!','Ha existido un error al obtener la curp, por favor intentalo mas tarde','error');
        });


    }

}

function cleanCurp(curp){
    curp = curp.replace(/\s/g,"");
    curp = curp.toUpperCase();
    return curp;
}

$(function () {
    $('[data-toggle="popover"]').popover()
})