@extends('layouts.Administracion')

@section('title', 'Crear Nueva Sede')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nueva Sede</h6>
            
            <form action="{{ route('admin.sede.store') }}" 
                  method="POST">
                @csrf
                @include('Sede._form')
            </form>
        </div>
    </div>
</div>

@endsection
