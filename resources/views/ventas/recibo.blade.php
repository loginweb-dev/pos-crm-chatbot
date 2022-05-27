
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Recibo de venta</title>
        <style>
            table, th, td {
                width: 100%;
                border: 0px solid black;
            }
            @page { size: {{setting('impresion.size')}} font-size: {{ setting('impresion.text_principal') }} }
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
                    <h2>TICKET # {{ $ventas->ticket }}<br>
                     <span style="padding:2px 2px; background-color:black;color:white;font-weight:bold;">{{ strtoupper($option->title) }}</span>
                    </h2>
                    <hr>
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
                            <td><strong>SABORES</strong></td>
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
                                 <td><b>{{ $miproduct->name }} <br> </b><div style="font-size: {{ setting('impresion.text_secundario') }}">{{ $item->extra_name }}</div></td>
                                 <td><b>{{$item->observacion}} <br> {{$item->description}} </b></td>
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
                <td colspan="2"><b>Atendido por : </b> {{ Auth::user()->name }} - <b>TICKET# {{$ventas->ticket}}</b></td>
                <td><b>Hora : {{ date('H:i:s') }}</b></td>
            </tr>
            <tr>
                <td colspan="3">Gracias por su preferencia, vuelva pronto.</td>
            </tr>
        </table>

        <div class="saltopagina" style="display:block; page-break-before:always;"></div>

        @if(setting('ventas.cocina'))
            <table>
                <tr>
                    <td colspan="3" align="center">
                        <h2>
                            VENTA #{{$ventas->id}} <br>
                            TICKET #{{$ventas->ticket}}<br>
                            {{date('d/m/Y H:i:s')}}<br>
                            <span style="padding:2px 20px;background-color:black;color:white;font-weight:bold;">{{ strtoupper($option->title) }}</span>
                        </h2><hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <tr>
                                <td><strong>PRODUCTO</strong></td>
                                <td><strong>SABORES</strong></td>
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
                                    <td><b>{{ $miproduct->name }} <br> </b><div style="font-size: {{ setting('impresion.text_secundario') }}">{{ $item->extra_name }}</div></td>

                                    <td><b>{{$item->observacion}} <br> {{$item->description}} </b></td>
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
                    <td colspan="3"><hr></td>
                </tr>
                <tr>
                    <td colspan="3"><h3>Cliente: {{$cliente->display}}.</h3> </td>
                </tr>
            </table>
        @endif
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
