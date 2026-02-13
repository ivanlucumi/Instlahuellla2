@extends('layouts.Administracion')

@section('title', 'Crear Nuevo Docente')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nuevo Docente</h6>
            
            <form action="{{ route('admin.docente.store') }}" 
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @include('Docente._form')
            </form>
        </div>
    </div>
</div>

@endsection
