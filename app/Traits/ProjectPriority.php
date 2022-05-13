<?php 

namespace App\Traits;

trait ProjectPriority{

    public $approved_percentage = 95;

    public function getPriority($amount_approved,$comprobation){
        $amount_percentage = ( $amount_approved * $this->approved_percentage ) / 100;
        $only_invoice_amount = 0;
        $other_documents_amount = 0;

        foreach ($comprobation as $document) {
            if($document->support_document_id === 1 || $document->support_document_id === 6){
                $only_invoice_amount += $document->amount;
            }else{
                $other_documents_amount += $document->amount;
            }
        }

        $total_all_documents = $only_invoice_amount + $other_documents_amount;

        if($total_all_documents <= 0){
            return "Sin prioridad asignada";
        }elseif($only_invoice_amount >= $amount_approved){
            return "Comprobación al 100%";
        }elseif($only_invoice_amount >= $amount_percentage){
            return "Comprobación al 95%";
        }elseif($other_documents_amount === 0 && ($only_invoice_amount < $amount_percentage)){
            return "Prioridad 3";
        }elseif($total_all_documents >= $amount_percentage){
            return "Prioridad 2";
        }else{
            return "Prioridad 1";
        }
    }

}

?>