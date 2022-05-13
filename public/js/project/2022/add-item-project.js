document.getElementById('add-item-project').addEventListener('click', function () { addNewItem(); });
var items = [];
var num_item = 0;

/*document.getElementById('chk-1').addEventListener('click', function () { activaTime(this); });
document.getElementById('chk-2').addEventListener('click', function () { activaTime(this); });
document.getElementById('chk-3').addEventListener('click', function () { activaTime(this); });
document.getElementById('chk-4').addEventListener('click', function () { activaTime(this); });
document.getElementById('chk-5').addEventListener('click', function () { activaTime(this); });
document.getElementById('chk-6').addEventListener('click', function () { activaTime(this); });
document.getElementById('chk-7').addEventListener('click', function () { activaTime(this); });
*/

function addNewItem() {
    let id = randomString();
    let name_fields = [
        'item-name-' + id,
        'item-unit-' + id,
        'item-quantity-' + id,
        'item-price-' + id,
        'item-total-cost-' + id
    ];

    $('.items-project-container').append(
        '<tr id="' + id + '">' +
        '<input type="hidden" name="item-ids[]" id="item-id-' + id + '" value="' + id + '">' +
        '<td class="column-delete-dependent">' +
        '<i class="fa fa-trash-o delete-dependent" id="delete-item-' + id + '" data-item="' + id + '" aria-hidden="true"></i>' +
        '</td>' +
        '<td class="align-middle">' +
        '<input type="text" class="form-control" id="' + name_fields[0] + '" name="' + name_fields[0] + '" required>' +
        '</td>' +
        '<td class="align-middle">' +
        '<input type="text" class="form-control" id="' + name_fields[1] + '" name="' + name_fields[1] + '" required>' +
        '<td class="align-middle">' +
        '<input type="number" min="1" value="0" class="form-control" id="' + name_fields[2] + '" name="' + name_fields[2] + '"  onkeyup="calculoTotalItem(\'' + id + '\');" required>' +
        '</td>' +
        '</td>' +
        '<td class="align-middle">' +
        '<div class="my-1">' +
        '<label class="sr-only" for="inlineFormInputGroupUsername">Price</label>' +
        '<div class="input-group">' +
        '<div class="input-group-prepend">' +
        '<div class="input-group-text">$</div>' +
        '</div>' +
        '<input type="number" min="1" value="0" class="form-control" id="' + name_fields[3] + '" name="' + name_fields[3] + '" onkeyup="calculoTotalItem(\'' + id + '\');" required>' +
        '<div class="input-group-prepend">' +
        '<div class="input-group-text">.00</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</td>' +
        '<td class="align-middle">' +
        '<div class="my-1">' +
        '<label class="sr-only" for="inlineFormInputGroupUsername">total_cost</label>' +
        '<div class="input-group">' +
        '<div class="input-group-prepend">' +
        '<div class="input-group-text">$</div>' +
        '</div>' +
        '<input type="number" readonly="true" value="0"  class="form-control" id="' + name_fields[4] + '" name="item-total-cost[]" required>' +
        '<div class="input-group-prepend">' +
        '<div class="input-group-text">.00</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</td>' +
        '</tr>'
    );

    let delete_dependent = document.getElementById('delete-item-' + id);

    delete_dependent.addEventListener('click', function () {
        let id_dependent = this.dataset.item;
        document.getElementById(id_dependent).remove();
    });
}

/*function activaTime(chk) {
    var array = chk.id.split('-');
    if (chk.checked) {
        timeA = document.getElementById('timeA-' + array[1]);
        timeC = document.getElementById('timeC-' + array[1]);
        timeA.disabled = false;
        timeC.disabled = false;
    }
    else {
        timeA = document.getElementById('timeA-' + array[1]);
        timeC = document.getElementById('timeC-' + array[1]);
        timeA.value = "";
        timeC.value = "";
        timeA.disabled = true;
        timeC.disabled = true;
    }
    return "";
}*/

function calculoTotalItem(id) {
    var quantity = document.getElementById('item-quantity-' + id);
    var price = document.getElementById('item-price-' + id);
    var total_cost = document.getElementById('item-total-cost-' + id);
    total_cost.value = quantity.value * price.value;
    totalItems();
    return "";
}

function totalItems() {
    var total_cost = document.getElementsByName("item-total-cost[]");
    var arraylength = total_cost.length;
    var total =parseFloat(0);
    for (k = 0; k < arraylength; k++) {      
        total= total + parseFloat(total_cost[k].value);        
    }
    document.getElementById('totalGeneral').innerHTML=total;
    return "";
}