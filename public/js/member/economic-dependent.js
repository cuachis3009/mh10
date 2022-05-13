const add_dependents = document.getElementById('add-economic-dependent');
var economic_dependents = [];
var num_dependent = 0;
const NUM_MAX_DEPENDENT = 10;

add_dependents.addEventListener('click',function(){
    addNewEconomicDependent();
});

function addNewEconomicDependent(){

    if(num_dependent >= NUM_MAX_DEPENDENT){
        Swal.fire('Atención','No puedes agregar a mas de ' + num_dependent + ' dependientes','warning');
        return false;
    }

    let id = randomString();
    let name_fields = [
        'relationship-dependent-' + id,
        'name-dependent-' + id,
        'age-old-dependent-' + id,
        'disability-dependent-' + id,  
        'student-dependent-' + id
    ];

    let relationship_options = createOptionsSelect(relationship,null,'id','name');
    let newborn_options = createOptionsSelect([{'id' : 0,'name' : 'No'},{'id' : 1,'name' : 'Si'}]);
    /*let disabilities_options = createOptionsSelect(disabilities,null,'id_cat_tipo_discapacidad','discapacidad');*/
    let older_options = createOptionsSelect([{'id' : 0,'name' : 'No'},{'id' : 1,'name' : 'Si'}]);
    
    $('.economic-dependents-container').append(
        '<tr id="'+id+'">'+
            '<input type="hidden" name="dependent-ids[]" id="dependent-id-'+id+'" value="'+id+'">' +
            '<td class="column-delete-dependent">'+
                '<i class="fa fa-trash-o delete-dependent" id="delete-dependent-'+id+'" data-dependent="'+id+'" aria-hidden="true"></i>'+
            '</td>'+
            '<td class="align-middle">'+
            '<select name="'+name_fields[0]+'" id="'+name_fields[0]+'" class="form-control">'+relationship_options+'</select>'+
            '</td>'+
            '<td class="align-middle">'+
                '<input type="text" class="form-control" id="'+name_fields[1]+'" name="'+name_fields[1]+'" required>'+
            '</td>'+
            '<td class="align-middle">'+
                '<input type="number" min="0" class="form-control" id="'+name_fields[2]+'" name="'+name_fields[2]+'" required>'+
            '</td>'+
            '<td class="align-middle">'+
                '<select name="'+name_fields[3]+'" id="'+name_fields[3]+'" dependent-id="'+id+'" class="form-control"><option value="0">No</option><option value="1">Si</option></select>'+
            '</td>'+
            '<td class="align-middle">'+
                '<select name="'+name_fields[4]+'" id="'+name_fields[4]+'" class="form-control">'+older_options+'</select>'+
            '</td>'+           
        '</tr>'
    );

    let delete_dependent = document.getElementById('delete-dependent-' + id);
    let dependent_has_disability = $("disability-dependent-" + id);
    
    delete_dependent.addEventListener('click',function(){
        let id_dependent = this.dataset.dependent;
        document.getElementById(id_dependent).remove();
        num_dependent--;
    });

    $(".economic-dependents-container").on("change","#disability-dependent-" + id,function(){
        let has_disability = $(this).val();
        if(has_disability == 1){
            $(this).after('<input type="text" name="specify-disability-'+id+'" id="specify-disability-'+id+'" class="form-control mt-2" placeholder="Especifique" required>');
        }else{
            $("#specify-disability-" + id).remove();
        }
    });

    /*dependent_has_disability.addEventListener('change',function(event){
        let has_disability = event.target.value;
        this.insertAdjacentElement('afterend', element);
    });*/
    
    /**Agregamos las validaciones con jquery validate */

    /**Sumamos un dependiente */
    num_dependent++;
}