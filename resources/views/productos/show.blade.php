@extends('layout')

@section('titulo', $producto->nombre)

@section('contenido')
    <div class="tarjeta">
        <p><a href="{{ route('productos.index') }}">← Volver al inventario</a></p>
        <h2>{{ $producto->nombre }}</h2>
        <table>
            <tr><th>SKU</th><td>{{ $producto->sku }}</td></tr>
            <tr><th>Categoría</th><td>{{ $producto->categoria }}</td></tr>
            <tr><th>Precio</th><td>${{ number_format($producto->precio, 2) }}</td></tr>
            <tr><th>Stock</th><td>{{ $producto->stock }}</td></tr>
            <tr><th>Valor en inventario</th><td>${{ number_format($producto->valor_inventario, 2) }}</td></tr>
            <tr><th>Descripción</th><td>{{ $producto->descripcion ?: '—' }}</td></tr>
            <tr><th>Actualizado</th><td>{{ $producto->updated_at?->format('d/m/Y H:i') }}</td></tr>
        </table>
        <div class="barra" style="margin-top:16px">
            <a class="btn primario" href="{{ route('productos.edit', $producto) }}">Editar</a>
            <form method="POST" action="{{ route('productos.destroy', $producto) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                @csrf
                @method('DELETE')
                <button class="btn peligro" type="submit">Eliminar</button>
            </form>
        </div>
    </div>
@endsection
