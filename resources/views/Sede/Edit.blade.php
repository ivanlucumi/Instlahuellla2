@extends('layouts.Administracion')

@section('title', 'Editar Sede')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Sede: {{ $sede->nombre_sede }}</h6>
            
            <form action="{{ route('admin.sede.update', $sede->id) }}" 
                  method="POST">
                @csrf
                @method('PUT')
                @include('Sede._form')
            </form>
        </div>
    </div>
</div>

@endsection
