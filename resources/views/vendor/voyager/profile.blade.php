@extends('voyager::master')

@section('css')
    <style>
        .user-email {
            font-size: .85rem;
            margin-bottom: 1.5em;
        }
    </style>
@stop

@section('content')
    <div style="background-size:cover; background-image: url({{ Voyager::image( Voyager::setting('admin.bg_image'), voyager_asset('/images/bg.jpg')) }}); background-position: center center;position:absolute; top:0; left:0; width:100%; height:300px;"></div>
    <div style="height:160px; display:block; width:100%"></div>
    <div style="position:relative; z-index:9; text-align:center;">
        <img src="@if( !filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL)){{ Voyager::image( Auth::user()->avatar ) }}@else{{ Auth::user()->avatar }}@endif"
             class="avatar"
             style="border-radius:50%; width:150px; height:150px; border:5px solid #fff;"
             alt="{{ Auth::user()->name }} avatar">
        <h4>{{ ucwords(Auth::user()->name) }}</h4>
        <div class="user-email text-muted">{{ ucwords(Auth::user()->email) }}</div>
        <p>{{ Auth::user()->bio }}</p>
        @if ($route != '')
            <a href="{{ $route }}" class="btn btn-primary">{{ __('voyager::profile.edit') }}</a>
        @endif
    </div>

    <hr>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                
                <div class="panel panel-primary">
                    <div class="panel-heading">MODULO DE VENTAS</div>
                        <div class="panel-body">
                            <p>Funciones</p>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Sucursales & Almacenes</td>
                                </tr>
                                <tr>
                                    <td>Pasarela de Pago & Facturacion</td>
                                </tr>
                                <tr>
                                    <th>Productos & Inventario</th>
                                </tr>
                                <tr>
                                    <th>TPV - Terminal Punto de Venta</th>
                                </tr>
                                <tr>
                                    <th>Visor en Cocina</th>
                                </tr>
                                <tr>
                                    <th>Visor para Pedidos en Cola</th>
                                </tr>
                            </tbody>
                        </table>
                </div>
                
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">MODULO DE PRODUCCION</div>
                        <div class="panel-body">
                            <p>Funciones</p>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Gestion de Insumos</td>
                                </tr>
                                <tr>
                                    <td> Gestion de Precios </td>
                                </tr>
                                <tr>
                                    <td> Proveedores & Produccion </td>
                                </tr>
                                <tr>
                                    <td> Logistica & Tiempos </td>
                                </tr>
                                <tr>
                                    <td> Personal & Objetivos </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">MODULO CHATBOT</div>
                        <div class="panel-body">
                            <p>Funciones</p>
                        </div>
                        <table class="table">
                            <tr>
                                    <th>Automatizacion de Ventas</th>
                                </tr>
                                <tr>
                                    <th>Respuestas Automaticas</th>
                                </tr>
                                <tr>
                                    <td>Notificaciones</td>
                                </tr>
                                <tr>
                                    <td>
                                        Conexion con:
                                        <br>
                                        - Whatsapp
                                        <br>
                                        - Telegram
                                        <br>
                                        - Correo Corporativo
                                        <br>
                                        - SMS - Entel
                                        <br>
                                        - Messenger - Facebook
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">MODULO DE COMPRAS</div>
                        <div class="panel-body">
                            <p>Funciones</p>
                        </div>
                        {{-- <table class="table">
                            <tbody>
                                <tr>
                                    <td>Gestion de Insumos</td>
                                </tr>
                                <tr>
                                    <td> Gestion de Precios </td>
                                </tr>
                                <tr>
                                    <td> Proveedores & Produccion </td>
                                </tr>
                                <tr>
                                    <td> Logistica & Tiempos </td>
                                </tr>
                                <tr>
                                    <td> Personal & Objetivos </td>
                                </tr>
                            </tbody>
                        </table> --}}
                </div>
            </div>
            

        </div>
    </div>
    

@stop
