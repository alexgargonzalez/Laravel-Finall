@extends('app.bootstrap.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Crear Nuevo Paquete Vacacional</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('vacacion.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input class="form-control" required id="titulo" name="titulo" placeholder="Ej: Escapada a París" value="{{ old('titulo') }}" type="text">
                        @error('titulo') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipo_id" class="form-label">Tipo de Vacación</label>
                        <select name="tipo_id" id="tipo_id" required class="form-select">
                            <option value="" disabled selected>Selecciona tipo...</option>
                            @foreach($tipos as $id => $nombre)
                                <option value="{{ $id }}" @if(old('tipo_id') == $id) selected @endif>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" required id="descripcion" name="descripcion" placeholder="Detalles del viaje..." rows="5">{{ old('descripcion') }}</textarea>
                        @error('descripcion') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio_pp" class="form-label">Precio por Persona (€)</label>
                            <input class="form-control" step="0.01" min="0" required id="precio_pp" name="precio_pp" placeholder="0.00" value="{{ old('precio_pp') }}" type="number">
                            @error('precio_pp') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pais" class="form-label">País / Destino</label>
                            <input class="form-control" required id="pais" name="pais" placeholder="Ej: Francia" value="{{ old('pais') }}" type="text">
                            @error('pais') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fotos" class="form-label">Imagen Principal</label>
                        <input class="form-control" id="fotos" name="fotos" type="file" accept="image/*">
                        @error('fotos') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <input class="btn btn-primary btn-lg" value="Crear Paquete" type="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection