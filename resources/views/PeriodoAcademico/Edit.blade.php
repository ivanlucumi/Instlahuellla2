@extends('layouts.Administracion')

@section('title', 'Editar Periodo Académico')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Periodo Académico: {{ $periodoAcademico->nombre_periodo }}</h6>
            <form action="{{ route('admin.periodoacademico.update', $periodoAcademico->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('PeriodoAcademico._form')
            </form>
        </div>
    </div>
</div>

@endsection
