<template>
    <div class="card mb-3">
        <div class="card-header" :class="classProjectStatus(projectStatus)">
            <div class="card-title">
                Folio : CRECE-2022-{{folio}}
            </div>
        </div>
        <a v-if="backToProject !== ''" id="back-to-project" class="btn btn-light btn-sm" v-bind:href="backToProject">Regresar al proyecto</a>
        <div class="card-body">
            <div class="project-status">
                <span class="font-weight-bold">Estatus : </span> {{this.projectStatusString}} |
                <span class="font-weight-bold">Tipo de proyecto : </span> {{this.getTypeString}} |
               
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        projectType: {
            type: Number,
            default: 0
        },
        folio:{
            type : String,
            default : '0000'
        },
        projectStatus: {
            type : Number,
            default : 0
        },
        typeString : {
            type : String,
            default : 'NOT-TYPE'
        },
        giro : {
            type : String,
            default : 'NOT-GIRO'
        },
        backToProject : {
            type : String,
            default : ''
        }
    },
    methods: {
        classProjectStatus : function (status){
            switch (status) {
                case 1:
                case 3:
                    return 'bg-success text-white'
                    break;
                case 2:
                    return 'bg-danger text-white'
                    break;
                /*case 3:
                    return 'bg-info text-white'
                    break;*/
            
                default:
                    return ''
                    break;
            }
        }
    },
    computed: {
        getTypeString(){
            return this.typeString
        },
        projectTypeString() {
            if(this.projectType > 0){
                return (this.projectType == 1) ? 'N' : 'F'
            }else{
                return 'project-type-not-defined'
            }
        },
        projectStatusString(){
            switch (this.projectStatus) {
                case 1:
                    return 'Aprobado'
                    break;
                case 2:
                    return 'Cancelado'
                    break;
                case 3:
                    return 'Reasignado'
                    break;
            
                default:
                    return 'No aprobado'
                    break;
            }
        }
    },
}
</script>

<style scoped>
    .page-header{
        border-radius: .25rem;
        margin-bottom: 20px;
    }

    .card-title{
        margin-bottom: 0px;
    }

    #back-to-project{
        position: absolute;
        right: 10px;
        top: 8px;
    }
</style>
