@extends('layout')

@section('titulo', 'Productos')

@section('contenido')
    <div class="resumen">
        <div><b>{{ $resumen['total'] }}</b><span>productos</span></div>
        <div><b>{{ number_format($resumen['unidades']) }}</b><span>unidades en stock</span></div>
        <div><b>${{ number_format($resumen['valor'], 2) }}</b><span>valor del inventario</span></div>
        <div><b>{{ $resumen['agotados'] }}</b><span>agotados</span></div>
    </div>

    <div class="tarjeta">
        <form class="barra" method="GET" action="{{ route('productos.index') }}">
            <input type="search" name="q" value="{{ $buscar }}" placeholder="Buscar por nombre o SKU">
            <select name="categoria">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $c)
                    <option value="{{ $c }}" @selected($categoria === $c)>{{ $c }}</option>
                @endforeach
            </select>
            <button class="btn" type="submit">Filtrar</button>
            <a class="btn primario" href="{{ route('productos.create') }}" style="margin-left:auto">Nuevo producto</a>
        </form>

        <table>
            <thead>
            <tr>
                <th>SKU</th><th>Nombre</th><th>Categoría</th>
                <th class="num">Precio</th><th class="num">Stock</th><th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($productos as $p)
                <tr>
                    <td>{{ $p->sku }}</td>
                    <td><a href="{{ route('productos.show', $p) }}">{{ $p->nombre }}</a></td>
                    <td><span class="etiqueta">{{ $p->categoria }}</span></td>
                    <td class="num">${{ number_format($p->precio, 2) }}</td>
                    <td class="num">
                        @if ($p->stock === 0)
                            <span class="etiqueta agotado">agotado</span>
                        @else
                            {{ $p->stock }}
                        @endif
                    </td>
                    <td class="num">
                        <a class="btn" href="{{ route('productos.edit', $p) }}">Editar</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No hay productos que coincidan.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $productos->links('pagination::simple-default') }}
    </div>
@endsection
