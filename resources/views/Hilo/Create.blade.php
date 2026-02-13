@extends('layouts.Administracion')

@section('title', 'Crear Nuevo Hilo')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nuevo Hilo</h6>
            
            <form action="{{ route('admin.hilo.store') }}" method="POST">
                @csrf
                @include('Hilo._form')
            </form>
        </div>
    </div>
</div>

@endsection
