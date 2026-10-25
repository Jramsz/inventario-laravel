<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    private const CATEGORIAS = ['Electrónica', 'Hogar', 'Oficina', 'Ropa', 'Alimentos', 'Herramientas'];

    public function index(Request $request)
    {
        $buscar = trim((string) $request->query('q', ''));
        $categoria = $request->query('categoria');

        $productos = Producto::query()
            ->when($buscar !== '', fn ($q) => $q->where(function ($w) use ($buscar) {
                $w->where('nombre', 'like', "%{$buscar}%")->orWhere('sku', 'like', "%{$buscar}%");
            }))
            ->when($categoria, fn ($q) => $q->where('categoria', $categoria))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        $resumen = [
            'total' => Producto::count(),
            'unidades' => (int) Producto::sum('stock'),
            'valor' => (float) Producto::selectRaw('COALESCE(SUM(precio * stock), 0) AS v')->value('v'),
            'agotados' => Producto::where('stock', 0)->count(),
        ];

        return view('productos.index', [
            'productos' => $productos,
            'resumen' => $resumen,
            'buscar' => $buscar,
            'categoria' => $categoria,
            'categorias' => self::CATEGORIAS,
        ]);
    }

    public function create()
    {
        return view('productos.form', ['producto' => new Producto(), 'categorias' => self::CATEGORIAS]);
    }

    public function store(Request $request)
    {
        $producto = Producto::create($this->validar($request));

        return redirect()->route('productos.show', $producto)->with('ok', 'Producto creado.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', ['producto' => $producto]);
    }

    public function edit(Producto $producto)
    {
        return view('productos.form', ['producto' => $producto, 'categorias' => self::CATEGORIAS]);
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($this->validar($request, $producto));

        return redirect()->route('productos.show', $producto)->with('ok', 'Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('ok', "Producto {$producto->sku} eliminado.");
    }

    private function validar(Request $request, ?Producto $producto = null): array
    {
        return $request->validate([
            'sku' => ['required', 'string', 'max:30', Rule::unique('productos', 'sku')->ignore($producto?->id)],
            'nombre' => ['required', 'string', 'max:120'],
            'categoria' => ['required', Rule::in(self::CATEGORIAS)],
            'precio' => ['required', 'numeric', 'min:0', 'max:999999'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
