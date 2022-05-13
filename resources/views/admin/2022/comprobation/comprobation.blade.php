@extends('admin.template.admin')

@section('content')
    <project-basic-info 
        :project-type="{{$project->project_type_id}}" 
        folio="{{$project->zeroFolio}}" 
        :project-status="{{$project->status}}"
        type-string="{{Str::ucfirst($project->type->name)}}"
       
        back-to-project="{{route('admin.2022.show',['slug' => $project->slug])}}"
    ></project-basic-info>

    <comprobation-component 
        save-route="{{route("admin.2022.comprobation.save",['slug' => $project->slug])}}"
        delete-route="{{route("admin.2022.comprobation.destroy")}}"
        :amount-approved="{{$project->amount_approved}}" 
        :amount-checked="{{$project->comprobation->sum('amount')}}"
        :comprobation-list="{{$project->comprobation}}"
        :support-documents="{{$suppport_document}}"
    >
    </comprobation-component>
@endsection