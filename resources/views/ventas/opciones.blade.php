
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Platos por Opciones</title>
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

                    <h2 >Platos  {{$option->title}}</h2>
                </td>
            </tr>
            <br>

            @php
                $index=0;
                $prod=[];
                $producto=[];
            @endphp

                @foreach ($ventas as $item)
                    @php
                        $detalle=App\DetalleVenta::where('venta_id',$item->id)->get();
                    @endphp
                    @foreach ($detalle as $item2)
                        @php
                            $producto[$index]=$item2->producto_id;
                            $prod[$index]=$item2;
                            $index+=1;
                        @endphp
                    @endforeach
                @endforeach

            @php
                $cant=array_count_values($producto);
                $i=0;
                $aux=0;
            @endphp
            @foreach ($cant as $item)
                @foreach ($prod as $item2)

                    @if (($prod[$i]->producto_id)==($item2->producto_id))
                        @php
                            $aux+=$item2->cantidad;
                        @endphp
                    @endif

                @endforeach
                {{-- Espacio Para Imprimir el resultado --}}
                <tr>
                    <td colspan="3" align="center">
                        <table>
                            <tr>
                                <td><b>{{$aux}} {{$prod[$i]->name}}</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                @php
                    $i+=1;
                    $aux=0;

                @endphp

            @endforeach


                <br>
            <tr>
                <td colspan="2"><b>Generado por : </b> {{ Auth::user()->name }} </b></td>

            </tr>
            <tr>
                <td colspan="1"><b>Hora : {{ date('H:i:s') }}</b></td>
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
