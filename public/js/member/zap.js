//const municipio_is_ind = document.getElementById("municipio_is_ind");
const municipio = document.getElementById("municipio-zap");
//const localidad = document.getElementById("localidad-zap");
//const colonia = document.getElementById("colonia-zap");
const loc_col = document.getElementById("loc_col-zap");


/*municipio_is_ind.addEventListener("change",function(event){    
    let clave = this.options[this.selectedIndex].getAttribute('value');
    console.log(clave);
    cleanOptions(municipio);
    cleanOptions(localidad);
    cleanOptions(colonia);
    if(clave == "" || clave == null){
        return false;
    }else{
        loadZapOptions("municipio",clave);
    }
});
*/
municipio.addEventListener("change",function(event){
    //let clave = event.target.value;
    let clave = this.options[this.selectedIndex].getAttribute('zap-code');
    cleanOptions(loc_col);  
    if(clave == "" || clave == null){
        return false;
    }else{
        //loadZapOptions("localidad",clave);
        loadZapOptions("loc_col",clave);

    }
});

function loadZapOptions(type,clave){
    /**Realizamos la llamada por axios */
    axios.post('/2022/member/getZap/' + type , {
        clave: clave
    }).then(function (response) {
       if(type == "loc_col"){
            load_loc_col(loc_col,response.data);
        }
    }).catch(function (error) {
        console.log(error);
    });
}


function load_loc_col(element,options){
    loadDefaultOption(element,"Selecciona tu localidad o colonia");
    options.forEach(function(item, i){
        let opt = document.createElement("option");
        opt.appendChild( document.createTextNode(item["loc_col"]));
        //opt.setAttribute("zap-code",item["clave_municipio"] + "-" + item["clave_localidad"]);
        opt.value = item["id"];
        element.appendChild(opt);
    });
}




/*
localidad.addEventListener("change",function(event){
    let localidad = this.options[this.selectedIndex].getAttribute('zap-code');
    cleanOptions(colonia);    
    if(localidad == "" || localidad == null){
        return false;
    }else{
        loadZapOptions("colonia",localidad);
    }
});
*/


function loadMunicipios(element,options){   
    loadDefaultOption(element,"Selecciona tu colonia");
    options.forEach(function(item, i){
        let opt = document.createElement("option");
        opt.appendChild( document.createTextNode(item["municipio"]));
        opt.setAttribute("zap-code",item["clave_numero"]);
        opt.value = item["id"];
        element.appendChild(opt);
    });
}

function loadColonia(element,options){
    loadDefaultOption(element,"Selecciona tu colonia");
    options.forEach(function(item, i){
        let opt = document.createElement("option");
        opt.appendChild( document.createTextNode(item["colonia"]));
        opt.value = item["id"];
        element.appendChild(opt);
    });
}

function loadLocalidad(element,options){
    loadDefaultOption(element,"Selecciona tu localidad");
    options.forEach(function(item, i){
        let opt = document.createElement("option");
        opt.appendChild( document.createTextNode(item["localidad"]));
        opt.setAttribute("zap-code",item["clave_municipio"] + "-" + item["clave_localidad"]);
        opt.value = item["id"];
        element.appendChild(opt);
    });
}

function loadDefaultOption(element,text){
    let option_default = document.createElement("option");
    option_default.appendChild( document.createTextNode(text));
    option_default.value = "";
    element.appendChild(option_default);
}

function cleanOptions(element){
    var l = element.options.length;
    while(element.firstChild){
        element.removeChild(element.firstChild);
    }
}