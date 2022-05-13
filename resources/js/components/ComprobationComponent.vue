<template>
<div>
    <div class="comprobation-cards mb-3">
        <div class="row">
            <!-- Monto aprobado -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        MONTO APROBADO
                    </div>
                    <div class="card-body">
                        <p class="card-text font-weight-bold">$ {{formatPrice(amountApproved)}}</p>
                    </div>
                </div>
            </div>
            <!-- Monto comprobado -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        MONTO COMPROBADO
                    </div>
                    <div class="card-body">
                        <p class="card-text font-weight-bold">$ {{calculateAmountChecked(amountChecked + amountNewChecked)}}</p>
                    </div>
                </div>
            </div>
            <!-- Monto restante -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        MONTO NO COMPROBADO
                    </div>
                    <div class="card-body">
                        <p class="card-text font-weight-bold">$ {{calculateAmountUnchecked(amountApproved,(amountChecked + amountNewChecked))}}</p>
                    </div>
                </div>
            </div>
            <!-- Monto exedente -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-white" :class="priority.classTxt">
                        NO. DE PRIORIDAD
                    </div>
                    <div class="card-body">
                        <p v-if="priority.type === 0" class="card-text font-weight-bold">Sin prioridad asignada</p>
                        <p v-if="priority.type === 1" class="card-text font-weight-bold">Prioridad 1</p>
                        <p v-if="priority.type === 2" class="card-text font-weight-bold">Prioridad 2</p>
                        <p v-if="priority.type === 3" class="card-text font-weight-bold">Prioridad 3</p>
                        <p v-if="priority.type === 4" class="card-text font-weight-bold">El proyecto ha comprobado el 95% o mas</p>
                        <p v-if="priority.type === 5" class="card-text font-weight-bold">El proyecto ha comprobado el 100%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="new-invoves">
                <table class="table table-stripped table-bordered">
                    <thead class="bg-white text-dark">
                        <tr>
                            <th>
                            </th>
                            <th>No.</th>
                            <th>Documento Comprobatorio</th>
                            <th>No. de Folio</th>
                            <th>Monto</th>
                            <th>Registrado por</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-dark">
                        <!-- DB  -->
                        <tr v-for="(comprobation,index) in comprobationList" :key="comprobation.id">
                            <td class="delete-button-container">
                                <i @click="deleteComprobation(comprobation.id)" class="fa fa-minus-circle" aria-hidden="true" title="Eliminar factura"></i>
                            </td>
                            <td>
                                {{index + 1}}
                            </td>
                            <td>
                                <p v-if="comprobation.support_document_id == 5">{{ comprobation.document.name }} - {{comprobation.support_document_txt}}</p>
                                <p v-else>{{comprobation.document.name}}</p>
                            </td>
                            <td>
                                {{comprobation.folio_number}}
                            </td>
                            <td>$ {{formatPrice(comprobation.amount)}}</td>
                            <td>
                                {{comprobation.user.name}} <br>
                                El día {{formatDate(comprobation.created_at)}}
                            </td>
                        </tr>
                        <!-- DINAMIC -->
                        <tr v-for="(invoice,index) in invoices" :key="invoice.id">
                            <td class="delete-button-container">
                                <i @click="removeNewInvoice(index)" class="fa fa-minus-circle" aria-hidden="true" title="Eliminar factura"></i>
                            </td>
                            <td></td>
                            <td>
                                <select v-model="invoice.support_document_id" class="form-control">
                                    <option v-for="doc in supportDocuments" :key="doc.id" :value="doc.id">
                                        {{doc.name}}
                                    </option>
                                </select>
                                <input v-model.trim="invoice.support_document_txt" v-if="invoice.support_document_id === 5" type="text" class="form-control mt-1" placeholder="Especifique el documento comprobatorio">
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model.trim="invoice.folio_number" required="required">
                            </td>
                            <td>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text bg-light">$</div>
                                        </div>
                                        <input @keyup="calculate" type="text" class="form-control" id="inlineFormInputGroup" placeholder="123.45" v-model.trim="invoice.amount" required="required">
                                    </div>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-white text-dark">
                        <tr>
                            <td colspan="3" class="text-center">
                                <button class="btn btn-warning" @click="addNewInvoice">Agregar factura</button>
                            </td>
                            <td colspan="4" class="text-center">
                                <button @click="saveInvoices" :disabled="invoices.length <= 0" class="btn btn-success">Guardas facturas</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</template>
<script>

import Datepicker from 'vuejs-datepicker'
import {en, es} from 'vuejs-datepicker/dist/locale'
import moment from 'moment';
import Swal from 'sweetalert2'
import shortid from 'shortid'

import InvoiceInputsComponent from './InvoiceInputsComponent'

export default {
    mounted () {
        this.setPriority();
    },
    components: {
        InvoiceInputsComponent,
        Datepicker
    },
    data() {
        return {
            es:es,
            invoices : [],
            timeout: null,
            amountNewChecked : 0,
            excessAmount : 0,
            consecutive : 0,
            priority : {
                type : 0,
                classTxt : ''
            }
        }
    },
    props: {
        amountApproved: {
            type: Number,
            default: 0
        },
        amountChecked :{
            type : Number,
            default : 0
        },
        saveRoute : {
            type : String,
            default : ''
        },
        deleteRoute : {
            type : String,
            default : ''
        },
        comprobationList : {
            default : []
        },
        supportDocuments : {
            default : []
        }
    },
    methods: {
        addNewInvoice(){
            this.invoices.push({
                id : shortid.generate(),
                support_document_id : null,
                support_document_txt : '',
                folio_number : '',
                amount : '',
            })
        },
        formatPrice(value) {
            let val = (value/1).toFixed(2)
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        calculateAmountUnchecked(total, totalComprobation){
            if(totalComprobation > 0){
                if(totalComprobation >= total){
                    if(totalComprobation > total){
                        this.excessAmount = (totalComprobation - total)
                    }
                    return this.formatPrice(0)
                }else{
                    return this.formatPrice(total - totalComprobation)
                }
            }else{
                return this.formatPrice(total)
            }
        },
        calculateAmountChecked(total){
            return this.formatPrice(total)
        },
        removeNewInvoice(index){
            this.invoices.splice(index,1);
        },
        saveInvoices(){
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
                        html: "Se esta guardando la información de comprobación",// add html attribute if you want or remove
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    axios({
                        method: "POST",
                        url: this.saveRoute,
                        data : this.invoices,
                        responseType: 'json'
                    })
                    .then(response => {
                        this.invoices.splice(0);
                        this.reloadPage("Bien","Se ha guardado correctamente las comprobaciones, recargando la pagina")
                    })
                    .catch(function (error) {
                        if(error.response.status == 422){
                            /**Hay un error en la validacion de los datos */
                            let errors = '';
                            for (var [key, value] of Object.entries(error.response.data.errors)) {
                                errors += ('*' + value + '<br>');
                            }

                            Swal.fire({
                                icon : 'warning',
                                title : 'Datos incorrectos',
                                html : errors
                            });

                        }else{
                            Swal.fire({
                                icon : 'danger',
                                html : 'Ha ocurrido un error inesperado, intentalo más tarde'
                            });
                        }
                    });
                }
            })
        },
        calculate: function() {
            // clear timeout variable
            clearTimeout(this.timeout);
            
            const self = this;
            this.timeout = setTimeout(response => {
                let total = 0;
                let ok = true;
                for (let index = 0; index < this.invoices.length; index++) {
                    let amount = parseFloat(this.invoices[index]['amount']);
                    if(isNaN(amount) === false){
                        total += amount
                    }else{
                        ok = false;
                        break;
                    }
                }

                if(ok){
                    this.amountNewChecked = total;
                }else{
                    this.amountNewChecked = 0;
                }

            },150)
        },
        formatDate(date){
            return moment(date).format('YYYY-MM-DD hh:mm:ss');
        },
        deleteComprobation(id){
            Swal.fire({
                title: 'Advertencia',
                text: "¿Estas segur@ de querer eliminar esta comprobación, una vez eliminada ya no podras recuperarla?",
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
                        html: "Se esta guardando la información de comprobación",// add html attribute if you want or remove
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    axios({
                        method: "POST",
                        url: this.deleteRoute,
                        data : {id : id},
                        responseType: 'json'
                    })
                    .then(response => {
                        this.reloadPage("Bien","Se ha eliminado correctamente la comprobación, recargando la pagina")
                    })
                    .catch(function (error) {
                        Swal.fire({
                            icon : 'error',
                            html : 'Ha ocurrido un error inesperado, intentalo más tarde'
                        });
                    });
                }
            })
        },
        reloadPage(title,content){
            Swal.fire({
                title: title,
                html: content,// add html attribute if you want or remove
                allowOutsideClick: false,
                allowEscapeKey: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            setTimeout(function(){
                location.reload();
            },1500)
        },
        setPriority(){
            const approved_percentage = 95;
            const amount_percentage = (this.amountApproved * approved_percentage) / 100;
            let only_invoice_amount = 0;
            let other_documents_amount = 0;
            for (let index = 0; index < this.comprobationList.length; index++) {
                if(this.comprobationList[index].support_document_id === 1 || this.comprobationList[index].support_document_id === 6){
                    only_invoice_amount += this.comprobationList[index].amount;
                }else{
                    other_documents_amount += this.comprobationList[index].amount;
                }
            }

            let total_all_documents = only_invoice_amount + other_documents_amount;
            if(total_all_documents <= 0){
                this.priority.type = 0;
                this.priority.classTxt = 'bg-dark'
            }else if(only_invoice_amount >= this.amountApproved){
                this.priority.type = 5;
                this.priority.classTxt = 'bg-success'
                //return "El proyecto ha comprobado el 100%"
            }else if(only_invoice_amount >= amount_percentage){
                this.priority.type = 4;
                this.priority.classTxt = 'bg-success'
                //return "El proyecto ha comprobado el 95% o mas"
            }else if(other_documents_amount === 0 && (only_invoice_amount < amount_percentage)){
                //return "Prioridad 3"
                this.priority.type = 3;
                this.priority.classTxt = 'bg-orange'
            }else if(total_all_documents >= amount_percentage){
                //return "Prioridad 2";
                this.priority.type = 2;
                this.priority.classTxt = 'bg-warning'
            }else{
                //return "Prioridad 1";
                this.priority.type = 1;
                this.priority.classTxt = 'bg-danger'
            }

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

    .new-invoves table{
        margin-bottom: 50px;
    }

    .new-invoves table tr td{
        padding: 0.3rem;
    }

    .delete-button-container i:hover{
        cursor: pointer;
    }

    .btn[disabled]:hover{
        cursor: not-allowed;
    }

    .bg-orange {
        background-color: #ff6523;
    }
</style>
