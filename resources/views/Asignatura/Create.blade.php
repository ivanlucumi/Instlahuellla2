@extends('layouts.Administracion')

@section('title', 'Crear Nueva Asignatura')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nueva Asignatura</h6>
            
            <form action="{{ route('admin.asignatura.store') }}" method="POST">
                @csrf
                @include('Asignatura._form')
            </form>
        </div>
    </div>
</div>

@endsection
