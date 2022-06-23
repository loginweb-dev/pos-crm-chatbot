
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>Proforma</title>
        <style type="text/css">
            /* @charset "utf-8"; */
            table, th, td {
                width: 100%;
                border: 0px solid black;
            }
            @page {
                size: {{setting('impresion.size')}} 
                font-size: {{ setting('impresion.text_principal') }} 
            }
            body{

            }
           
       
        </style>
       
       
    </head>
    <body>
        <table>
            <tr>
                <td colspan="3" align="center">
                    <img src="{{ url('storage').'/'.setting('empresa.logo') }}" alt="loginweb" width="300px"><br>
                    <b>De: {{ setting('empresa.propietario') }}</b><br>
                    <b>{{ strtoupper($sucursal->name) }}</b><br>
                    <b>{{ setting('empresa.direccion') }}<b><br>
                    <b>Cel: {{ setting('empresa.celular') }}</b><br>
                    <b>{{ setting('empresa.ciudad') }}</b>
                </td>
            </tr>
            <tr>
                <!-- consulta para saber si es factura o recibo -->
                <td colspan="3" align="center">
                    <h2>
                        PROFORMA # {{ $ventas->proforma }} <br>
                        ID # {{ $ventas->id }}<br>
                    </h2>
                    
                </td>
            </tr>
            {{-- // Cliente --}}
            <tr>
                <td><b>Razón social:</b></td>
                <td colspan="2"><strong>{{$cliente->display}}</strong></td>
            </tr>
            <tr>
                <td><b>NIT/CI:</b></td>
                <td colspan="2"><b> {{$cliente->ci_nit}}</b></td>
            </tr>
            <tr>
                <td><b>Fecha:</b></td>
                <td colspan="2"><strong>{{ strftime("%A, %d de %B de %Y",  strtotime($ventas->created_at)) }}</strong></td>
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            {{-- //carrito --}}
            <tr>
                <td colspan="3" align="center">
                    <table>
                        <tr>
                            <td><strong>PRODUCTO</strong></td>
                            <td><strong>DETALLE</strong></td>
                            {{-- <td><strong>OBS</strong></td> --}}
                            <th><strong>CANT</strong></th>
                            <td><strong>PRECIO</strong></td>
                            <td><strong>TOTAL</strong></td>
                         </tr>
                         @foreach ($detalle_ventas as $item)
                             @php
                                 $miproduct = App\Producto::find($item->producto_id);
                                 $totalunit=($item->cantidad)*($item->precio);
                             @endphp
                             <tr>
                                 <td><b>{{ $miproduct->name }} <br> </b><div style="font-size: {{ setting('impresion.text_secundario') }}">{!! $item->extra_name !!}</div></td>
                                 <td><b> {{$item->description}} </b><br>{{$item->observacion}}  </td>
                                 {{-- <td><b>{{ $item->observacion }}</b></td> --}}
                                 <td align="center"><b>{{ $item->cantidad }}</b></td>
                                 <td align="center"><b>{{ $item->precio }}</b></td>
                                 <td align="center"><b>{{ $totalunit }}</b></td>
                             </tr>
                         @endforeach
                         <tr>
                            <td colspan="4" align="right"><b>SUB TOTAL :</b></td>
                            <td align="center"><b>{{$ventas->subtotal}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right"><b>ADICIONAL :</b></td>
                            <td align="center"><b>{{$ventas->adicional}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right"><b>DESCUENTO :</b></td>
                            <td align="center"><b>{{$ventas->descuento}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right"><b>TOTAL :</b></td>
                            <td align="center"><b>{{$ventas->total}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3"> <strong> Son: {{ $literal }} </strong></td>
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>

            <tr>
                <td colspan="2"><b>Atendido por : </b> {{ Auth::user()->name }} </td>
                <td><b>Hora : {{ date('H:i:s') }}</b></td>
            </tr>
            {{-- <tr>
                <td colspan="2"><b>Venta : <b> {{$ventas->id}} </b></td></td>
            </tr> --}}
            <tr>
                <td colspan="3"><b>Proforma Válida por {{ setting('ventas.proforma_validez') }} días.</b></td>
            </tr>
            <tr>
                <td colspan="3">Gracias por su preferencia, vuelva pronto.</td>
            </tr>
        </table>


       
        <script type="text/javascript">
            try {
                this.print();
            }
            catch(e) {
                window.onload = window.print;
            }
        </script>
    </body>
</html>
