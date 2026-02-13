@extends('layouts.Administracion')
<!--ponerle titulo a la paginga-->


@section('title', 'Institución Educativa Técnica Agropecuaria La Huella')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Editar Institución</h6>
            <form action="{{ route('admin.institucion.update', $institucion->id) }}" 
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('Institucion._form')
            </form>
        </div>
    </div>
</div>
@endsection