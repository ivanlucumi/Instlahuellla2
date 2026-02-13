@extends('layouts.Administracion')

@section('title', 'Crear Periodo Académico')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Registrar Nuevo Periodo Académico</h6>
            <form action="{{ route('admin.periodoacademico.store') }}" method="POST">
                @csrf
                @include('PeriodoAcademico._form')
            </form>
        </div>
    </div>
</div>

@endsection
