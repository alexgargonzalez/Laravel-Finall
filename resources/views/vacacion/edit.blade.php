@extends('app.bootstrap.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar Paquete Vacacional</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('vacacion.update', $vacacion->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input class="form-control" required id="titulo" name="titulo" value="{{ old('titulo', $vacacion->titulo) }}" type="text">
                        @error('titulo') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipo_id" class="form-label">Tipo de Vacación</label>
                        <select name="tipo_id" id="tipo_id" required class="form-select">
                            @foreach($tipos as $id => $nombre)
                                <option value="{{ $id }}" @if(old('tipo_id', $vacacion->tipo_id) == $id) selected @endif>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" required id="descripcion" name="descripcion" rows="5">{{ old('descripcion', $vacacion->descripcion) }}</textarea>
                        @error('descripcion') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio_pp" class="form-label">Precio por Persona (€)</label>
                            <input class="form-control" step="0.01" min="0" required id="precio_pp" name="precio_pp" value="{{ old('precio_pp', $vacacion->precio_pp) }}" type="number">
                            @error('precio_pp') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pais" class="form-label">País / Destino</label>
                            <input class="form-control" required id="pais" name="pais" value="{{ old('pais', $vacacion->pais) }}" type="text">
                            @error('pais') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fotos" class="form-label">Imagen Principal</label>
                        @if($vacacion->fotos)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $vacacion->fotos) }}" alt="Current Image" width="100" class="img-thumbnail">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="deleteImage" value="true" id="deleteImage">
                                    <label class="form-check-label" for="deleteImage">
                                        Eliminar imagen actual
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input class="form-control" id="fotos" name="fotos" type="file" accept="image/*">
                        @error('fotos') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <input class="btn btn-warning btn-lg" value="Guardar Cambios" type="submit">
                        <a href="{{ route('vacacion.show', $vacacion->id) }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection