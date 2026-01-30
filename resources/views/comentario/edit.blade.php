@extends('app.bootstrap.template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">Editar Comentario</div>
                <div class="card-body">
                    <form action="{{ route('comentario.update', $comentario->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="texto" class="form-label">Tu comentario</label>
                            <textarea class="form-control" name="texto" id="texto" rows="4" required>{{ old('texto', $comentario->texto) }}</textarea>
                            @error('texto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection