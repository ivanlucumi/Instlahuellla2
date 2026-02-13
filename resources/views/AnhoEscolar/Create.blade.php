@extends('layouts.Administracion')

@section('title', 'Crear Año Escolar')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nuevo Año Escolar</h6>
            <form action="{{ route('admin.anhoescolar.store') }}" method="POST">
                @csrf
                @include('AnhoEscolar._form')
            </form>
        </div>
    </div>
</div>

@endsection
