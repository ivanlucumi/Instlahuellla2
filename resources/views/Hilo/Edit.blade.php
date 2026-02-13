@extends('layouts.Administracion')

@section('title', 'Editar Hilo')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Hilo: {{ $hilo->nombre_hilo }}</h6>
            
            <form action="{{ route('admin.hilo.update', $hilo->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('Hilo._form')
            </form>
        </div>
    </div>
</div>

@endsection
