<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Venta;
use App\DetalleVenta;
use App\Option;
use TCG\Voyager\Models\User;
use App\Imports\UsersImport;
use App\Imports\ClienteImport;
use App\Imports\ProductsImport;
use App\Imports\VentaImport;
use App\DetalleCaja;
use App\Caja;
use App\Categoria;
use Maatwebsite\Excel\Facades\Excel;

use App\Cliente;
use App\Sucursale;
use App\Asiento;
use App\Dosificacione;
use NumerosEnLetras;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;

// use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class PosController extends Controller
{

    // PARA IMPRIMIR RECIBO
	public function imprimir($id){
        $ventas = Venta::find($id);
        $detalle_ventas = DetalleVenta::where('venta_id',$id)->get();
        $cliente = Cliente::find($ventas->cliente_id);
        $sucursal=Sucursale::find($ventas->sucursal_id);
        $option=Option::find($ventas->option_id);
        $literal = NumerosEnLetras::convertir($ventas->total,'Bolivianos',true);

        //logica para direccionar a recibo, factura, o proforma
        if ($ventas->factura == 'Recibo') {
            $vista = view('ventas.recibo', compact('ventas' ,'detalle_ventas', 'cliente','sucursal','option', 'literal'));
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($vista)->setPaper('legal');
            return $pdf->stream();
        } 
        else if($ventas->factura == 'Factura') {
            $dosificacion=Dosificacione::where('activa',1)->first();

            //QR
            // $texto_qr="texto";
            $texto_qr = setting('empresa.nit').'|'.$ventas->nro_factura.'|'.$dosificacion->nro_autorizacion.'|'.$ventas->created_at.'|'.number_format($ventas->total, 2, '.', '').'|'.number_format($ventas->total, 2, '.', '').'|'.$ventas->codigo_control.'|'.$cliente->ci_nit.'|0.00|0.00|0.00|0.00';

            $codigoQR = QrCode::format('png')->size(250)->generate($texto_qr);
            $vista = view('ventas.factura', compact('ventas' ,'detalle_ventas', 'cliente','sucursal','option', 'literal', 'codigoQR', 'dosificacion'));
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($vista)->setPaper('legal');
            return $pdf->stream();
        }
        else {
            $vista = view('ventas.proforma', compact('ventas' ,'detalle_ventas', 'cliente','sucursal','option', 'literal'));
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($vista)->setPaper('legal');
            return $pdf->stream();
        }
    }

    //Imprimir Platos por Tipo de Venta (option_id)
    public function imprimirOpcion($data){
        $midata2=json_decode($data);
        $ventas=[];
        if ($midata2->option_id==4) {
            $ventas=Venta::where('sucursal_id',$midata2->sucursal_id)->where('caja_status', false)->get();
            $opcion_condicion=4;
        }
        else{
            $ventas=Venta::where('sucursal_id',$midata2->sucursal_id)->where('option_id',$midata2->option_id)->where('caja_status', false)->get();
            $opcion_condicion=0;
        }
        $option=Option::find($midata2->option_id);
        $categoria_id=setting('productos.categoria_grupo');
        $categoria=Categoria::find($categoria_id);
        $vista = view('ventas.opciones', compact('ventas','option','categoria','opcion_condicion'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('legal');
        return $pdf->stream();
        // echo('Hola');
    }

       // PARA IMPRIMIR CIERRE CAJA
	public function cierre_caja($id){
        $detalle_caja=DetalleCaja::find($id);
        $caja=Caja::find($detalle_caja->caja_id);
        $sucursal=Sucursale::find($caja->sucursal_id);
        $asiento=Asiento::where('caja_id',$detalle_caja->caja_id)->get();
        $cajero=User::find($detalle_caja->editor_id);
        //$venta=Venta::find($detalla_caja->venta_id);
        $vista = view('cajas.cierre_caja', compact('detalle_caja','caja','sucursal','asiento','cajero'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('legal');
        return $pdf->stream();
    }

    public function catalogo_enviar($id){

    }


    public function import_users(){
        Excel::import(new UsersImport, 'imports/users.xlsx');
        return redirect('/admin/users')->with('success', 'All good!');

    }
    public function import_clientes(){
        Excel::import(new ClienteImport, 'imports/clientes.xlsx');
        return redirect('/admin/clientes')->with('success', 'All good!');
    }
    public function producto_detalle(){
        $vista = view('productos.detalle');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('legal');
        return $pdf->stream();
    }
    public function import_products(){
        Excel::import(new ProductsImport, 'imports/products.xlsx');
        return redirect('/admin/productos')->with('success', 'All good!');
    }
    public function import_ventas(){
        Excel::import(new VentaImport, 'imports/ventas.xlsx');
        return redirect('/admin/ventas')->with('success', 'All good!');

    }

    public function venta_public($id){
        $venta = Venta::find($id);
        return view('ventas.public', compact('venta'));

    }

}
