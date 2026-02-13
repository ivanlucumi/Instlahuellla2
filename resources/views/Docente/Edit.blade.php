@extends('layouts.Administracion')

@section('title', 'Editar Docente')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Docente: {{ $docente->user->name ?? 'N/A' }}</h6>
            
            <form action="{{ route('admin.docente.update', $docente->id) }}" 
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('Docente._form')
            </form>
        </div>
    </div>
</div>

@endsection
