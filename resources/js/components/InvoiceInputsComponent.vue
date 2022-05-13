<template>
    <tr>
        <td class="delete-button-container">
            <i class="fa fa-minus-circle" aria-hidden="true" title="Eliminar factura"></i>
        </td>
        <td>
            <input type="text" class="form-control">
        </td>
        <td>
            <input type="text" class="form-control">
        </td>
        <td>
            <div class="col-auto">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text bg-light">$</div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="123.45">
                </div>
            </div>
        </td>
        <td>
            <datepicker :language="es" :required="true" input-class="form-control"></datepicker>
        </td>
        <td></td>
    </tr>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import {en, es} from 'vuejs-datepicker/dist/locale'

export default {
    components: {
        Datepicker,
    },
    data() {
        return {
            es: es
        }
    },
}
</script>

<style scoped>
    .delete-button-container {
        text-align: center;
        color: #f50000;
        font-size: 20px !important;
    }
</style>