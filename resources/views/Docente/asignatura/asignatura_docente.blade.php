@extends('layouts.Administracion')

@section('title', 'Gestión de Docentes')

@section('content')

<h2>Mis asignaturas</h2>

@if($asignaturas->isEmpty())
    <p>No tienes asignaturas asignadas.</p>
@else
    <ul>
        @foreach ($asignaturas as $asignatura)
            <li>{{ $asignatura->nombre_asignatura }}</li>
        @endforeach
    </ul>
@endif

@endsection
