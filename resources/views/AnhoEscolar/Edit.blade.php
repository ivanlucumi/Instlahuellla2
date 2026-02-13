@extends('layouts.Administracion')

@section('title', 'Editar Año Escolar')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Año Escolar: {{ $anhoEscolar->nombre_anho_escolar }}</h6>
            <form action="{{ route('admin.anhoescolar.update', $anhoEscolar->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('AnhoEscolar._form')
            </form>
        </div>
    </div>
</div>

@endsection
