<?php

namespace App\Exports;

use App\Venta;
use App\Dosificacione;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class VentasExport implements FromView
{
    private $var1;
    private $var2;

    public function __construct(string $var1, string $var2)
    {
        $this->var1 = $var1;
        $this->var2 = $var2;
    }

    public function view(): View
    {
        return view('ventas.excel', [
            'dosificacion' => Dosificacione::where('activa', 1)->first(),
            'ventas' => Venta::whereBetween('created_at', [$this->var1, $this->var2])->where('factura', 'Factura')->with('cliente')->get()
        ]);
    }
}
