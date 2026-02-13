@extends('layouts.Administracion')

@section('title', 'Editar Acudiente')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Acudiente: {{ $acudiente->user->name ?? '' }}</h6>
            
            <form action="{{ route('admin.acudiente.update', $acudiente->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('Acudiente._form')
            </form>
        </div>
    </div>
</div>

@endsection
