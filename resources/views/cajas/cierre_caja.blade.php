
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reporte Cierre Caja</title>
        <style>
            table, th, td {
                width: 100%;
                border: 0px solid black;
            }
            @page { size: 30rem 100rem; font-size: 28px;}
		</style>
    </head>
    <body>

        <table>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                                <th></th>
                                <td align="center" style="font-size:18px">CIERRE CAJA # {{ $detalle_caja->id }}</td>
                                <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th align="center">{{$caja->title}} - {{$sucursal->name}}</th>
                            <th></th>
                        </tr> <br>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b> Nº Venta Inicial: </b>{{$detalle_caja->venta_inicio}}
                            </td>
                            <td>
                                <b> Nº Venta Final: </b>{{$detalle_caja->venta_final}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Fecha Apertura</b></td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td><b>Fecha Cierre</b></td>
                            <td>: {{$detalle_caja->created_at}}</td>
                        </tr>

                    </table>

                </td>


            </tr>


            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th></th>
                           <th align="center" style="font-size:15px">INGRESOS</th>
                           <th></th>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">

                    <table width="100%">


                        <tr>
                            <th>Cantidad</th>
                            <th>Detalle</th>
                            <th></th>
                            <th align="right">Total</th><br>

                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_efectivo}}</th>
                            <th>Ventas en Efectivo</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_efectivo}}</th>
                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_banipay}}</th>
                            <th>Ventas con BANIPAY</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_banipay}}</th>
                        </tr>
                        <tr>
                            <th>{{$detalle_caja->cantidad_tarjeta}}</th>
                            <th>Ventas con Tarjeta</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_tarjeta}}</th>
                        </tr>
                         <tr>
                            <th>{{$detalle_caja->cantidad_qr}}</th>
                            <th>Ventas por QR</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_qr}}</th>
                        </tr>
                        {{-- <tr>
                            <th>{{$detalle_caja->cantidad_transferencia}}</th>
                            <th>Ventas por Transferencia</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_transferencia}}</th>
                        </tr>

                        <tr>
                            <th>{{$detalle_caja->cantidad_tigomoney}}</th>
                            <th>Ventas por TigoMoney</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->venta_tigomoney}}</th>
                        </tr><br><br><br><br> --}}
                        {{-- <tr>
                            <td colspan="3" align="right"><b>TOTAL VENTAS EN EFECTIVO Bs.</b></td>
                            <td align="right"><b>{{$detalle_caja->venta_efectivo}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>INGRESOS EFECTIVO Bs.</b></td>
                            <td align="right"><b>{{$detalle_caja->ingreso_efectivo}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>INGRESOS CON BANIPAY Bs.</b></td>
                            <td align="right"><b>{{$detalle_caja->ingreso_linea}}</b></td>
                        </tr> --}}
                        <tr>
                            {{-- <th>{{$detalle_caja->ingreso_efectivo}}</th> --}}
                            <th></th>
                            <th>Ingresos en Efectivo</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->ingreso_efectivo}}</th>
                        </tr>
                        <tr>
                            {{-- <th>{{$detalle_caja->ingreso_linea}}</th> --}}
                            <th></th>
                            <th>Ingresos con Banipay o Línea</th>
                            <th></th>
                            <th align="right">{{$detalle_caja->ingreso_linea}}</th>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b></b></td>
                            <td align="right"><b><hr></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>TOTAL INGRESOS Bs.</b></td>
                            <td align="right"><b>{{$detalle_caja->venta_efectivo+$detalle_caja->ingreso_efectivo+$detalle_caja->ingreso_linea+$detalle_caja->venta_tarjeta+$detalle_caja->venta_qr}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th></th>
                           <th align="center" style="font-size:15px">EGRESOS</th>
                           <th></th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">

                        <tr>
                            <th></th>
                            <th>
                                EGRESOS EN EFECTIVO:
                            </th>
                            <th> {{$detalle_caja->egreso_efectivo}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>
                                EGRESO EN LÍNEA
                            </th>
                            <th>{{$detalle_caja->egreso_linea}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th><hr></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>TOTAL EGRESOS</th>
                            <th>{{$detalle_caja->egresos}}</th>
                        </tr>
                    </table>

                </td>

            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th style="font-size:15px" align="left">DETALLE EFECTIVO</th>
                        </tr><br>
                        <tr>
                            <th>IMPORTE INICIAL</th>
                            <th>{{$detalle_caja->importe_inicial}}</th>
                        </tr>
                        <tr>
                            <th>VENTAS EN EFECTIVO</th>
                            <th>{{$detalle_caja->venta_efectivo}}</th>
                        </tr>
                        <tr>
                            <th>INGRESOS EN EFECTIVO</th>
                            <th>{{$detalle_caja->ingreso_efectivo}}</th>
                        </tr>

                        <tr>
                            <th>EGRESOS EN EFECTIVO</th>
                            <th>{{$detalle_caja->egreso_efectivo}}</th>
                        </tr><br>
                        <tr>
                            <th>TOTAL ENTREGADO</th>
                            <th>{{$detalle_caja->efectivo_entregado}}</th>
                        </tr>
                        <tr>
                            <th>TOTAL EN SISTEMA</th>
                            <th>{{$detalle_caja->venta_efectivo+$detalle_caja->ingreso_efectivo+$detalle_caja->importe_inicial-$detalle_caja->egreso_efectivo}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><hr></th>
                        </tr>
                        <tr>
                            <th>DIFERENCIA</th>
                            <th>{{$detalle_caja->efectivo_entregado-($detalle_caja->venta_efectivo+$detalle_caja->ingreso_efectivo+$detalle_caja->importe_inicial-$detalle_caja->egreso_efectivo)}}</th>
                        </tr>

                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th style="font-size:15px" align="left">DETALLE EN LÍNEA</th>
                        </tr><br>
                        <tr>
                            <th>VENTAS CON BANIPAY</th>
                            <th>{{$detalle_caja->venta_banipay}}</th>
                        </tr>
                        <tr>
                            <th>VENTAS CON TARJETA</th>
                            <th>{{$detalle_caja->venta_tarjeta}}</th>
                        </tr>
                         <tr>
                            <th>VENTAS POR QR</th>
                            <th>{{$detalle_caja->venta_qr}}</th>
                        </tr>
                        {{-- <tr>
                            <th>VENTAS POR TRANSFERENCIA</th>
                            <th>{{$detalle_caja->venta_transferencia}}</th>
                        </tr>
                        <tr>
                            <th>VENTAS POR TIGOMONEY</th>
                            <th>{{$detalle_caja->venta_tigomoney}}</th>
                        </tr> --}}
                        <tr>
                            <th>INGRESOS CON BANIPAY</th>
                            <th>{{$detalle_caja->ingreso_linea}}</th>
                        </tr>
                        <tr>
                            <th>EGRESOS EN LÍNEA</th>
                            <th>{{$detalle_caja->egreso_linea}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><hr></th>
                        </tr>
                        {{-- <tr>
                            <th>TOTAL EN LÍNEA</th>
                            <th>{{$detalle_caja->venta_tarjeta+$detalle_caja->venta_transferencia+$detalle_caja->venta_qr+$detalle_caja->venta_tigomoney+$detalle_caja->ingreso_linea-$detalle_caja->egreso_linea}}</th>
                        </tr> --}}
                        <tr>
                            <th>TOTAL EN LÍNEA</th>
                            <th>{{$detalle_caja->venta_banipay+$detalle_caja->ingreso_linea+$detalle_caja->venta_tarjeta+$detalle_caja->venta_qr-$detalle_caja->egreso_linea}}</th>
                        </tr>

                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <th>
                                {{setting('empresa.mensaje_caja')}}
                            </th>
                        </tr>

                    </table>

                </td>
            </tr>

            <tr>
                <td colspan="2"><hr></td>
            </tr><br><br><br>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>

                            <th><hr></th>

                        </tr>
                        <tr>
                            <th align="center">Cajero(a): {{$cajero->name}}</th>
                        </tr><br><br><br>

                        <tr>


                            <th align="center"><hr></th>

                        </tr>
                        <tr>
                            <th align="center">Administrador(a): </th>
                        </tr>

                    </table>

                </td>
            </tr>


        </table>

        <script>
            window.print();
            setTimeout(function(){
                window.close();
            }, 10000);
        </script>
    </body>
</html>
