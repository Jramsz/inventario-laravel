@extends('layout')

@section('titulo', $producto->exists ? 'Editar producto' : 'Nuevo producto')

@section('contenido')
    <div class="tarjeta">
        <h2 style="margin-top:0">{{ $producto->exists ? 'Editar ' . $producto->nombre : 'Nuevo producto' }}</h2>

        <form method="POST" action="{{ $producto->exists ? route('productos.update', $producto) : route('productos.store') }}">
            @csrf
            @if ($producto->exists)
                @method('PUT')
            @endif

            <div class="campos">
                <div>
                    <label for="sku">SKU</label>
                    <input id="sku" name="sku" value="{{ old('sku', $producto->sku) }}" required maxlength="30">
                    @error('sku')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required maxlength="120">
                    @error('nombre')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria" required>
                        @foreach ($categorias as $c)
                            <option value="{{ $c }}" @selected(old('categoria', $producto->categoria) === $c)>{{ $c }}</option>
                        @endforeach
                    </select>
                    @error('categoria')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="precio">Precio (USD)</label>
                    <input id="precio" name="precio" type="number" step="0.01" min="0" value="{{ old('precio', $producto->precio) }}" required>
                    @error('precio')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="stock">Stock</label>
                    <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $producto->stock ?? 0) }}" required>
                    @error('stock')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3" maxlength="1000">{{ old('descripcion', $producto->descripcion) }}</textarea>
            @error('descripcion')<div class="error">{{ $message }}</div>@enderror

            <p class="barra" style="margin-top:16px">
                <button class="btn primario" type="submit">Guardar</button>
                <a class="btn" href="{{ $producto->exists ? route('productos.show', $producto) : route('productos.index') }}">Cancelar</a>
            </p>
        </form>
    </div>
@endsection
