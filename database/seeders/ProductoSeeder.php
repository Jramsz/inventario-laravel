<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        if (Producto::exists()) {
            return;
        }

        $productos = [
            ['ELE-001', 'Monitor 24 pulgadas', 'Electrónica', 159.90, 18],
            ['ELE-002', 'Teclado mecánico', 'Electrónica', 54.50, 40],
            ['ELE-003', 'Mouse inalámbrico', 'Electrónica', 19.99, 75],
            ['ELE-004', 'Audífonos con micrófono', 'Electrónica', 34.00, 0],
            ['OFI-001', 'Silla ergonómica', 'Oficina', 210.00, 6],
            ['OFI-002', 'Resma de papel carta', 'Oficina', 4.75, 320],
            ['OFI-003', 'Lámpara de escritorio LED', 'Oficina', 27.30, 22],
            ['HOG-001', 'Cafetera de goteo', 'Hogar', 39.90, 12],
            ['HOG-002', 'Juego de sartenes', 'Hogar', 68.00, 9],
            ['HER-001', 'Taladro percutor', 'Herramientas', 89.99, 14],
            ['HER-002', 'Juego de destornilladores', 'Herramientas', 15.25, 50],
            ['ROP-001', 'Camisa polo', 'Ropa', 17.50, 64],
            ['ALI-001', 'Café molido 500 g', 'Alimentos', 6.40, 140],
        ];

        foreach ($productos as [$sku, $nombre, $categoria, $precio, $stock]) {
            Producto::create(compact('sku', 'nombre', 'categoria', 'precio', 'stock'));
        }
    }
}
