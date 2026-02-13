@extends('layouts.Administracion')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Nuevo Registro Histórico</h6>
                <form action="{{ route('admin.notas-definitivas.store') }}" method="POST">
                    @csrf
                    @include('NotasDefinitivas._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
