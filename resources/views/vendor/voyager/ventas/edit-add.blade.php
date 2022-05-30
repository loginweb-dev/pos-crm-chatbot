@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp
@extends('voyager::master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@php
    $miuser = TCG\Voyager\Models\User::find(Auth::user()->id);
    $micajas = App\Caja::all();
@endphp

@section('page_header')
    <br>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <h4 class="">
            <i class="{{ $dataType->icon }}"></i>
            {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
        </h4>
    </div>

        {{-- <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
        </a>

        <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
        </a> --}}
        {{-- <div class="col-sm-6 col-md-6 col-lg-6"> --}}

        {{-- </div> --}}
    @if ($edit)
        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <i class="glyphicon glyphicon-list"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
        </a>
    @else
        <div class="col-sm-6 col-md-6 col-lg-6" id="mitop">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-danger" data-toggle="modal" onclick="get_total()" data-target="#cerrar_caja">Cerrar</button>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#venta_caja" onclick="venta_caja()">Ventas</button>
                <button onclick="micliente()" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_cliente">Cliente</button>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_asientos" onclick="cargar_asientos()">Asientos</button>
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_save_venta" onclick="get_cambio()">Vender</button> --}}
                <a href="#mitop" type="button" class="btn btn-primary"  onclick="saveventas()">Vender</a>

            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div id="info_caja"></div>
        </div>
    @endif

@stop
@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                            method="POST" enctype="multipart/form-data">
                        @if($edit)
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                            @php
                                $miuser = TCG\Voyager\Models\User::find(Auth::user()->id);
                                $micajas = App\Caja::all();
                                $categorias = App\Categoria::where('id', '!=', 9 )->where('id', '!=', 7 )->orderBy('order', 'asc')->get();
                            @endphp

                            @if ($edit)
                                @php
                                    $venta = App\Venta::find($dataTypeContent->getKey());
                                    $clientes = App\Cliente::orderBy('created_at', 'desc')->get();
                                    $pasarelas = App\Pago::orderBy('created_at', 'desc')->get();
                                    $opciones = App\Option::orderBy('created_at', 'desc')->get();
                                    $cupones = App\Cupone::orderBy('created_at', 'desc')->get();
                                    $mensajeros = App\Mensajero::orderBy('created_at', 'desc')->get();
                                    $sucursales = App\Sucursale::orderBy('created_at', 'desc')->get();
                                    $cajas = App\Caja::orderBy('created_at', 'desc')->get();
                                    $estados = App\Estado::orderBy('created_at', 'desc')->get();
                                    $locationes = App\Location::orderBy('created_at', 'desc')->get();
                                @endphp
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="cliente_id">Cliente</label>
                                            <select name="cliente_id" id="cliente_id" class="form-control js-example-basic-single">
                                                @foreach ($clientes as $item)
                                                    <option value="{{ $item->id }}" @if($venta->cliente_id == $item->id)selected @endif>{{ $item->display }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="cliente_id">Pasarela</label>
                                            <select name="pago_id" id="pago_id" class="form-control js-example-basic-single">
                                                @foreach ($pasarelas as $item)
                                                    <option value="{{ $item->id }}" @if($venta->pago_id == $item->id)selected @endif>{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="option_id">Opciones</label>
                                            <select name="option_id" id="option_id" class="form-control js-example-basic-single">
                                                @foreach ($opciones as $item)
                                                    <option value="{{ $item->id }}" @if($venta->option_id == $item->id)selected @endif>{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="cupon_id">Cupones</label>
                                            <select name="cupon_id" id="cupon_id" class="form-control js-example-basic-single">
                                                @foreach ($cupones as $item)
                                                    <option value="{{ $item->id }}" @if($venta->cupon_id == $item->id)selected @endif>{{ $item->title.' - Bs '.$item->valor }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="option_id">Sucursales</label>
                                            <select name="sucursal_id" id="sucursal_id" class="form-control">
                                                @foreach ($sucursales as $item)
                                                    <option value="{{ $item->id }}"@if($venta->sucursal_id == $item->id)selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="delivery_id">Delivery</label>
                                            <select name="delivery_id" id="delivery_id" class="form-control js-example-basic-single">
                                                @foreach ($mensajeros as $item)
                                                    <option value="{{ $item->id }}"@if($venta->delivery_id == $item->id)selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="caja_id">Cajas</label>
                                            <select name="caja_id" id="caja_id" class="form-control js-example-basic-single">
                                                @foreach ($cajas as $item)
                                                    <option value="{{ $item->id }}"@if($venta->caja_id == $item->id)selected @endif>{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="status_id">Estados</label>
                                            <select name="status_id" id="status_id" class="form-control js-example-basic-single">
                                                @foreach ($estados as $item)
                                                    <option value="{{ $item->id }}"@if($venta->status_id == $item->id)selected @endif>{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="location">Ubicaciones</label>
                                            <select name="location" id="location" class="form-control js-example-basic-single">
                                                @foreach ($locationes as $item)
                                                    <option value="{{ $item->id }}"@if($venta->location == $item->id)selected @endif>{{ $item->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Ticket</label>
                                            <input class="form-control" type="text" name="ticket" id="ticket" value="{{ $venta->ticket }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Mensaje</label>
                                            <input class="form-control" type="text" name="observacion" id="observacion" value="{{ $venta->observacion }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Descuento</label>
                                            <input class="form-control" type="number" name="descuento" id="descuento" value="{{ $venta->descuento }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Adicional</label>
                                            <input class="form-control" type="number" name="adicional" id="adicional" value="{{ $venta->adicional }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Cantidad de Productos</label>
                                            <input class="form-control" type="number" name="cantidad" id="cantidad" value="{{ $venta->cantidad }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Dinero Recibido</label>
                                            <input class="form-control" type="number" name="recibido" id="recibido" value="{{ $venta->recibido }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Dinero Cambio</label>
                                            <input class="form-control" type="number" name="cambio" id="cambio" value="{{ $venta->cambio }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Sub Total</label> <small>{{ $venta->subtotal }}</small>
                                            <input class="form-control" type="subtotal" name="subtotal" id="subtotal" value="{{ $venta->subtotal }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Total</label> <small>{{ $venta->total }}</small>
                                            <input class="form-control" type="number" name="total" id="total" value="{{ $venta->total }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Estado de Credito (al fio)</label>
                                            <input class="form-control" type="number" name="status_credito" id="status_credito" value="{{ $venta->status_credito }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Impuesto</label>(Factura o Recibo)
                                            <input class="form-control" type="text" name="factura" id="factura" value="{{ $venta->factura }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Editor</label>
                                            <input class="form-control" type="text" name="register_id" id="register_id" value="{{ Auth::user()->id; }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Credito</label>(Contado o Credito)
                                            <input class="form-control" type="text" name="credito" id="credito" value="{{ $venta->credito }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Chofer</label>
                                            <input class="form-control" type="text" name="chofer_id" id="chofer_id" value="{{ $venta->chofer_id }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Contabilidad</label>
                                            <input class="form-control" type="text" name="caja_status" id="caja_status" value="{{ $venta->caja_status }}">
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="form-group col-lg-9 col-md-8 col-sm-12">
                                    {{-- <strong> en el criterio de busqueda, NO ingresar caracteres especiales como ser: #, %</strong> --}}
                                    <input type="search" id="misearch" class="form-control" placeholder="Ingresa un criterio de busqueda, QR o codigo de barra">
                                    <div>
                                    <div id="miresult" class="table-responsive" hidden>
                                        <table class="table" id="mitableresult">
                                            <thead>
                                                <tr>
                                                    <th>Accion</th>
                                                    <th>Categoria</th>
                                                    <th>N. Comercial</th>
                                                    <th>N. Genérico</th>
                                                    <th>Etiqueta</th>
                                                    <th>Stock</th>
                                                    <th>Vencimiento</th>
                                                    <th>Precio</th>
                                                    <th>Laboratorio</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <a onclick="return $('#miresult').attr('hidden', true)" class="btn btn-sm btn-default">Cerrar</a>
                                        <a href="#" data-toggle="modal" data-target="#modal_producto" class="btn btn-sm btn-dark">Crear nuevo producto</a>
                                    </div>
                                        @if(setting("empresa.type_negocio")=="Restaurante")
                                            <div style="cursor: pointer;">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    @foreach($categorias as $item)
                                                        <li role="presentation"><a href="#{{ $item->id }}" aria-controls="home" role="tab" data-toggle="tab">{{ $item->name}}</a></li>
                                                    @endforeach
                                                    <li role="presentation"><a href="#vacio" aria-controls="home" role="tab" data-toggle="tab">Vacio</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    @foreach($categorias as $item)
                                                        <div role="tabpanel" class="tab-pane" id="{{ $item->id }}">
                                                            @php
                                                                $products = App\Producto::where('categoria_id', $item->id )->orderBy('name', 'desc')->get();
                                                            @endphp
                                                            <div class="row">
                                                                @foreach($products as $item)
                                                                    <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                                                        <a href="#micart" onclick="addproduct('{{$item->id}}')" class="thumbnail">
                                                                            @php
                                                                                $miimage =$item->image ? $item->image :  setting('productos.imagen_default') ;
                                                                                $stock = $item->stock ? $item->stock : " ";
                                                                            @endphp
                                                                            <img src="{{setting('admin.url')}}storage/{{ $miimage }}">
                                                                        </a>
                                                                        @if(setting('ventas.stock'))
                                                                            <strong>{{ $item->name }} - {{$stock}}</strong>
                                                                        @else
                                                                            <strong>{{ $item->name }}</strong>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div role="tabpanel" class="tab-pane" id="vacio">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div hidden>
                                        <div id="search-input" >
                                            <div class="input-group col-sm-6" >
                                                <select class="form-control js-example-basic-single" id="category"></select>
                                            </div>
                                            <div class="input-group col-sm-6">
                                                <select class="form-control js-example-basic-single" id="s"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div  id="mixtos" hidden>
                                        <div class="form-group">
                                            <select class="form-control js-example-basic-single" id="mixta1" style="width: 300px"></select>
                                            <select class="form-control js-example-basic-single" id="mixta2" style="width: 300px"></select>
                                            <a onclick="addmixta()" class="btn btn-sm btn-primary">Agregar</a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-inverse" id="micart">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Producto</th>
                                                    <th>Observación</th>
                                                    <th>Extra</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Total</th>
                                                    <th>Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-4 text-center">
                                    <form class="form-horizontal" role="form">
                                        <label class="radio-inline"> <input type="radio" name="season" id="" value="imprimir" checked> Imprimir </label>
                                        <label class="radio-inline"> <input type="radio" name="season" id="" value="seguir"> Seguir </label>
                                    </form>
                                </div>
                                <div class="form-group col-lg-3 col-md-4">


                                    @foreach($dataTypeRows as $row)
                                        <!-- GET THE DISPLAY OPTIONS -->
                                        @php
                                            $display_options = $row->details->display ?? NULL;
                                            if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                            }
                                        @endphp

                                        @if (isset($row->details->legend) && isset($row->details->legend->text))
                                            <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                        @endif

                                        <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if (isset($row->details->view))
                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                            @elseif ($row->type == 'relationship')
                                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                            @if ($errors->has($row->field))
                                                @foreach ($errors->get($row->field) as $error)
                                                    <span class="help-block">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="form-group col-md-12">
                                        <strong>Cliente</strong>
                                        <select class="form-control js-example-basic-single" id="micliente"> </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <strong>Pasarela</strong>
                                        <select class="form-control js-example-basic-single" id="mipagos"> </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <strong>Tipo</strong>
                                        <select class="form-control js-example-basic-single" id="venta_type"> </select>
                                    </div>
                                    @if(setting('empresa.type_negocio')=="Restaurante")
                                        <div class="form-group col-sm-12">
                                            <strong>Pensionado</strong>
                                            <select class="form-control js-example-basic-single" id="mipensionado"> </select>
                                        </div>
                                    @endif

                                    <div class="form-group col-md-12">
                                        <strong>Cupon</strong>
                                        <select class="form-control js-example-basic-single" id="micupon"> </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <strong>Delivery</strong>
                                        <select class="form-control js-example-basic-single" id="midelivery"> </select>
                                    </div>
                                    <div class="form-group col-md-12" align="center">
                                        {!! QrCode::size(200)->generate('LoginWeb @2022') !!}
                                    </div>
                                </div>

                            @endif
                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @if($edit)
                                @section('submit-buttons')
                                    <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                @stop
                                @yield('submit-buttons')
                            @endif

                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- End Delete File Modal -->
    <div class="modal fade modal-primary" id="micaja">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="voyager-info"></i> Debes de abrir una caja para empezar a vender</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Estado</th>
                                <th>Sucursal</th>
                                <th>Cajeros</th>
                                <th>Importe</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($micajas as $caja)
                                @php
                                    $tienda = App\Sucursale::find($caja->sucursal_id);
                                    $cajeros =  App\CajaUser::where('caja_id' ,$caja->id)->get();
                                    $mipermiso = false;
                                    foreach ($cajeros as $value) {
                                        if ($value->user_id == Auth::user()->id) {
                                            $mipermiso = true;
                                            break;
                                        }
                                    }
                                @endphp
                                @if( $mipermiso )
                                    <tr>
                                        <td>
                                            # {{ $caja->id }}
                                            <br>
                                            {{ $caja->title }}
                                        </td>
                                        <td>{{ $caja->estado }}</td>

                                        <td>
                                            {{ $tienda->name }}
                                            <br>
                                            {{ $caja->sucursal_id }}
                                        </td>
                                        <td>
                                            @foreach ($cajeros as $item)
                                                @php
                                                    $miuser = TCG\Voyager\Models\User::find($item->user_id);
                                                @endphp
                                                {{ $miuser->name }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" value="0" name="" id="importe_{{$caja->id }}">
                                        </td>
                                        <td> <button onclick="abrir_caja('{{ $caja->id }}', '{{ $caja->title }}', '{{ $tienda->name }}', '{{ $caja->sucursal_id }}' )" class="btn btn-sm btn-dark"> Abrir </button> </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="/admin/ventas" type="button" class="btn btn-dark">{{ __('voyager::generic.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-primary" id="venta_caja">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                <h4>Ventas de la Caja</h4>
                </div>
                <div class="modal-body">

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#miventas" aria-controls="miventas" role="tab" data-toggle="tab">Mis Ventas</a></li>
                        <li role="presentation"><a href="#deliverys" aria-controls="deliverys" role="tab" data-toggle="tab">Deliverys</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="miventas">
                            <table class="table table-striped table-inverse table-responsive" id="productos_caja">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Productos</th>
                                        <th>Ticket</th>
                                        <th>Pasarela</th>
                                        <th>Cliente</th>
                                        <th>Delivery</th>
                                        <th>Chofer</th>
                                        <th>Tipo</th>
                                        <th>Total</th>
                                        <th>Creado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="deliverys">
                            <input id="venta_id" type="hidden" class="form-control" hidden>
                            <select id="mideliverys" class="form-control"></select>
                            <a href="#" class="btn btn-sm btn-primary" onclick="save_set_chofer()">Asignar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-primary" id="cerrar_caja">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                <h4>¿Estás seguro de cerrar?</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive" hidden>
                    <thead>
                        <tr>
                            <th>INGRESOS</th>
                            <th>EGRESOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Total Ventas Bs.
                                <br>
                                <input type="number" class="form-control" id="total_ventas" value="0" readonly>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Importe Inicial Bs.
                                <br>
                                <input type="number" class="form-control" id="importe_inicial" value="0" readonly>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Asientos - Ingresos Bs.
                                <br>
                                <input type="number" class="form-control" id="ingresos" value="0" readonly>
                            </td>
                            <td>
                                Asientos - Egresos Bs.<br>
                                <input type="number" class="form-control" id="egresos" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Venta en Efectivo
                                <input type="number" class="form-control" id="venta_efectivo" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Cantidad en Efectivo
                                <input type="number" class="form-control" id="cantidad_efectivo" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Venta Efectivo
                                <input type="number" class="form-control" id="ingreso_efectivo" value="0" readonly>
                            </td>
                            <td>
                                Venta En Linea
                                <input type="number" class="form-control" id="ingreso_linea" value="0" readonly>
                            </td>
                            <td>
                                Egreso Efectivo
                                <input type="number" class="form-control" id="egreso_efectivo" value="0" readonly>
                            </td>
                            <td>
                                Egreso En Linea
                                <input type="number" class="form-control" id="egreso_linea" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Venta con BaniPay
                                <input type="number" class="form-control" id="venta_banipay" value="0" readonly>
                            </td>
                            <td>
                                Cantidad por BaniPay
                                <input type="number" class="form-control" id="cantidad_banipay" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Venta con Tarjeta
                                <input type="number" class="form-control" id="venta_tarjeta" value="0" readonly>
                            </td>
                            <td>
                                Cantidad por Tarjeta
                                <input type="number" class="form-control" id="cantidad_tarjeta" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Venta con QR
                                <input type="number" class="form-control" id="venta_qr" value="0" readonly>
                            </td>
                            <td>
                                Cantidad por QR
                                <input type="number" class="form-control" id="cantidad_qr" value="0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Total Caja Bs.</label>
                                <input type="number" class="form-control col-6" id="_total" value="0" readonly>
                            </td>
                            <td>
                                CORTES
                                <input type="text" class="form-control" id="cortes" readonly>
                            </td>
                                <td>
                                    <label for="">Cantidad de Ventas</label>
                                    <input type="number" class="form-control" id="cant_ventas" value="0" readonly>
                                </td>
                        </tr>
                    </tbody>
                    </table>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Corte</th>
                                <th>Cantidad</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="lista_cortes"></tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="">Observaciones</label>
                            <textarea name="" id="description" class="form-control"></textarea>
                        </div>
                        <div class="col-sm-6">
                            Monto Entregado
                            <input type="number" class="form-control" id="efectivo_entregado" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="" onclick="cerrar_caja()">SI</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal-lista_extras" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="voyager-list-add"></i> Lista de extras</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="producto_extra_id" id="producto_extra_id" hidden>
                    <input type="text" name="tr_producto" id="tr_producto" hidden>

                    <table class="table table-bordered table-hover" id="table-extras">
                        <thead>
                            <tr>
                                {{-- <th>Imagen</th> --}}
                                <th>ID</th>
                                <th>Extra</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    {{-- <td style="text-align: right">
                        <input style="text-align:right" readonly min="0" type="number" name="total_extra" id="total_extra">
                    </td> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-right" onclick="calcular_total_extra()" data-dismiss="modal">Añadir</button>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-primary" id="modal_cliente">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-info"></i> Clientes </h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Nuevo</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Buscar</a></li>

                    </ul>
                    <div class="tab-content">
                        {{-- <h4>al ingresar los datos del nuevo cliente, NO ingresar caracteres espieciales como ser: #, %</h4> --}}
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="form-group col-sm-6">
                                <label for="">Nombres</label>
                                <input class="form-control" type="text" placeholder="Nombres" id="first_name">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Apellidos</label>
                                <input class="form-control" type="text" placeholder="Apellidos" id="last_name">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Telefono</label>
                                <input class="form-control" type="text" placeholder="Telefono" id="phone" value="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">NIT</label>
                                    <input class="form-control" type="text" placeholder="Carnet o NIT" id="nit" value="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Display</label>
                                <input class="form-control" type="text" placeholder="Display" id="display">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Correo</label>
                                <input class="form-control" type="text" placeholder="Email" id="email">
                            </div>
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-3">
                                <button type="button" class="btn btn-sm btn-dark" onclick="savecliente()" >Enviar</button>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <input type="text" class="form-control" placeholder="Criterio de Busquedas.." id="cliente_busqueda">
                            <br>
                            <table class="table" id="cliente_list">
                                <thead>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>CI - NIT</th>
                                    <th>Telefono</th>
                                    <th>Asignar</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-primary" id="modal_save_venta">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-primary" id="modal_asientos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4>Ingresos & Egresos</h4>
                </div>
                <div class="modal-body">

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home1" aria-controls="home1" role="tab" data-toggle="tab">Registrar</a></li>
                        <li role="presentation"><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab">Historial</a></li>

                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home1">
                            <div class="form-group col-sm-4">
                                    <label for="">Tipo</label>
                                <select class="form-control" name="" id="type">
                                    <option value="Egresos" selected>Egresos</option>
                                    <option value="Ingresos">Ingresos</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Monto</label>
                                <input type="number" class="form-control" id="monto" value="0">
                            </div>
                            <div class="form-group col-sm-4"><br>
                                <label class="radio-inline"> <input type="radio" name="pago" id="pago" value="0"> Bany Pay </label> <br>
                                <label class="radio-inline"> <input type="radio" name="pago" id="pago" value="1" checked> En Efectivo </label>
                            </div>
                            <div class="form-group col-sm-9">
                                <label for="">Concepto</label>
                                <textarea class="form-control" name="" id="concepto"></textarea>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="">Accion</label>
                                <button type="button" class="btn btn-dark" onclick="save_asiento()">Enviar</button>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile1">
                            <table class="table" id="asiento_list">
                                <thead>
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Pago</th>
                                    <th>Monto</th>
                                    <th>Concepto</th>
                                    <th>Creado</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-primary" id="modal_producto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4>Nuevo Producto</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-sm-6">
                        <label for="">Nombre Principal</label>
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="">Precio</label>
                        <input class="form-control" type="text" name="name" id="precio">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="">Stock</label>
                        <input class="form-control" type="text" name="name" id="stock">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="">Categoria</label>
                        @php
                            $categorias = App\Categoria::all();
                        @endphp
                        <select name="" class="form-control" id="categoria_id">
                            @foreach ($categorias as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" onclick="saveproducto()" class="btn btn-sm btn-dark">Enviar</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>
    <script>
        var params = {};
        var $file;
        const socket = io('https://socket.loginweb.dev')

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.js-example-basic-single').select2();
            $('.toggleswitch').bootstrapToggle();
            socket.on("{{ setting('notificaciones.monitor') }}", (msg) =>{
                //location.reload()
                toastr.success("El Pedido "+msg+" ya está listo.")
            })
            //socket.emit("tatu_cocina", "Venta Realizada")

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });
                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();

            $('.js-example-basic-single').select2();
        $('input[name="register_id"]').val('{{ Auth::user()->id }}');
        $('input[name="chofer_id"]').val("{{setting('ventas.chofer')}}");
        $("input[name='status_credito']").val(0);

        if (localStorage.getItem('micaja')) {
            var micaja = JSON.parse(localStorage.getItem('micaja'));
            $("input[name='caja_id']").val(micaja.caja_id);
            $('input[name="sucursal_id"]').val(micaja.sucursal_id);
            $("#info_caja").html("<h4>"+micaja.title+" - "+micaja.sucursal+" - "+micaja.importe+" Bs. - <a onclick='reset()'>Reset</a></h4>");
        }else{
            $("#micaja").modal();
        }

        Categorias()
        Deliverys()
        Cliente()
        Cupones()
        Pasarelas()
        Estados()
        Opciones()
        Pensionados()
        //DesactivarPensionados();
        if (localStorage.getItem('micart')) {
            micart();
        } else {
            localStorage.setItem('micart', JSON.stringify([]));
        }
        });

    function CalculoDiasRestantes(fecha_final){
        if(fecha_final!=null){
            var today=new Date();
            var fechaInicio =   today.toISOString().split('T')[0];
            var fechaFin    = fecha_final;
            var fi=fechaInicio.toString();
            var ff=fechaFin.toString();
            var fechai = new Date(fi).getTime();
            var fechaf    = new Date(ff).getTime();
            var diff = fechaf - fechai;
            return (diff/(1000*60*60*24));
        }
        else{
            return null;
        }
    }

    async function micliente() {
        var miphone = Math.floor(Math.random() * 1000000000);
        $('#phone').val(miphone)
    }

    async function DesactivarPensionados(){
        var table=await axios.get("{{ setting('admin.url') }}api/pos/pensionados");
        for(let index=0;index < table.data.length;index++){
            var aux= parseInt(CalculoDiasRestantes(table.data[index].fecha_final));
            if(aux<0){
            var actualizar= await axios("{{ setting('admin.url') }}api/pos/pensionados/actualizar/"+table.data[index].id);
            }
            Pensionados();
        }
    }

    async function Categorias() {
        $('#category').find('option').remove().end();

        var table = await axios.get("{{ setting('admin.url') }}api/pos/categorias");
        $('#category').append($('<option>', {
            value: 0,
            text: 'Elige una Categoria'
        }));
        for (let index = 0; index < table.data.length; index++) {
            const element = table.data[index];
            $('#category').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].name
            }));
        }
    }

    async function Deliverys(){
        $('#midelivery').find('option').remove().end();

        var table= await axios.get("{{ setting('admin.url') }}api/pos/deliverys");

        for (let index = 0; index < table.data.length; index++) {
            if (table.data[index].id == 1) {
                $('#midelivery').append($('<option>', {
                selected: true,
                value: table.data[index].id,
                text: table.data[index].name
            }));
            $("input[name='delivery_id']").val(table.data[index].id);
            } else {
                $('#midelivery').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].name
            }));
            }
        }
    }

    async function Cupones(){
        $('#micupon').find('option').remove().end();

        var table= await axios.get("{{ setting('admin.url') }}api/pos/cupones");
        for (let index = 0; index < table.data.length; index++) {
            if (table.data[index].id == 1) {
                $('#micupon').append($('<option>', {
                selected: true,
                value: table.data[index].id,
                text: table.data[index].title
            }));
            $("input[name='cupon_id']").val(table.data[index].id);
            } else {
                $('#micupon').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].title
            }));
            }
        }
    }

    async function Pasarelas() {
        $('#mipagos').find('option').remove().end();

        var table= await axios.get("{{ setting('admin.url') }}api/pos/pagos");

        for (let index = 0; index < table.data.length; index++) {
            if (table.data[index].id == 1) {
                $('#mipagos').append($('<option>', {
                selected: true,
                value: table.data[index].id,
                text: table.data[index].title
            }));
            $("input[name='pago_id']").val(table.data[index].id);
            } else {
                $('#mipagos').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].title
            }));
            }
        }

    }

    async function Estados() {
        $('#miestado').find('option').remove().end();

        var table= await axios.get("{{ setting('admin.url') }}api/pos/estados");

        for (let index = 0; index < table.data.length; index++) {
            if (table.data[index].id == 1) {
                $('#miestado').append($('<option>', {
                selected: true,
                value: table.data[index].id,
                text: table.data[index].title
            }));
            $("input[name='status_id']").val(table.data[index].id);
            } else {
                $('#miestado').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].title
            }));
            }
        }
    }

    async function Opciones() {
        $('#venta_type').find('option').remove().end();
        var table= await axios.get("{{ setting('admin.url') }}api/pos/options");
        for (let index = 0; index < table.data.length; index++) {
            if (table.data[index].id == 1) {
                $('#venta_type').append($('<option>', {
                selected: true,
                value: table.data[index].id,
                text: table.data[index].title
            }));
            $("input[name='option_id']").val(table.data[index].id);
            } else {
                $('#venta_type').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].title
            }));
            }
        }
    }

    async function Pensionados(){
        $('#mipensionado').find('option').remove().end();
        var table= await axios.get("{{setting('admin.url')}}api/pos/pensionados");
        $('#mipensionado').append($('<option>', {
            value: 0,
            text: 'Elige un Pensionado'
        }));
        $('input[name="pensionado_id"]').val(0);
        if(table.data.length>0){
            for (let index = 0; index < table.data.length; index++) {
                const element = table.data[index];
                $('#mipensionado').append($('<option>', {
                    value: table.data[index].id,
                    text: table.data[index].id+' - '+table.data[index].cliente.display+' - '+table.data[index].cliente.phone
                }));
            }
        }
    }

    $('#misearch').keypress(async function(event) {
        if ( event.which == 13 ) {
            event.preventDefault();

            toastr.info('Buscando.. '+this.value)
            var micaja = JSON.parse(localStorage.getItem('micaja'));
            var midata = {
                criterio: this.value,
                sucursal_id: micaja.sucursal_id
            }
            var miresult = await axios.post("{{setting('admin.url')}}api/producto/search", midata)
            $("#mitableresult tbody tr").remove()
            $("#miresult").attr("hidden", false)
            for(let index=0; index < miresult.data.length; index++){
                var img = miresult.data[index].image ? miresult.data[index].image : "{{ setting('productos.imagen_default') }}"
                var nombre_genérico= miresult.data[index].title ? miresult.data[index].title : " "
                var vencimiento = miresult.data[index].vencimiento ? miresult.data[index].vencimiento : " "
                var laboratorio= miresult.data[index].laboratorio_id ? miresult.data[index].laboratorio.name : " "
                $('#mitableresult').append("<tr><td><a class='btn btn-sm btn-dark' onclick='addproduct("+miresult.data[index].id+")'>Agregar</a></td><td>"+miresult.data[index].categoria.name+"</td><td>"+miresult.data[index].name+"</td><td>"+nombre_genérico+"</td><td>"+miresult.data[index].etiqueta+"</td><td>"+miresult.data[index].stock+"</td><td>"+vencimiento+"</td><td>"+miresult.data[index].precio+"</td><td>"+laboratorio+"</td></tr>")
            }
        }
    });

    $('#mipensionado').on('change', function() {
        if($('#mipensionado').val()==0){
            $('#micliente').find('option').remove().end();
            Cliente();
        }
        else{
            ClientePorPensionado($('#mipensionado').val());
        }

        $('input[name="pensionado_id"]').val(this.value)
        toastr.success('Cambio de Pensionado')

        if(( $('input[name="pensionado_id"]').val(this.value))!=0){
            $("input[name='total']").val(0)
        }
    });



    async function ClientePorPensionado(id){
        var table = await axios.get("{{setting('admin.url')}}api/pos/cliente/pensionado/"+id);
        $('#micliente').find('option').remove().end();
        for (let index = 0; index < table.data.length; index++) {
            $('#micliente').append($('<option>', {
                value: table.data[index].cliente_id,
                text: table.data[index].cliente.display
            }));
            $("input[name='cliente_id']").val($('#micliente').val());
        }
    }

    async function Cliente(){
        $('#micliente').find('option').remove().end();
        var table= await axios("{{ setting('admin.url') }}api/pos/cliente/default/get");
        $("input[name='cliente_id']").val(table.data.id);
        $('#micliente').append($('<option>', {
            value: table.data.id,
            text: table.data.display+' - '+table.data.ci_nit+' - '+table.data.phone,
            selected: true
        }));
        var tabla= await axios.get("{{ setting('admin.url') }}api/pos/clientes");
        for (let index = 0; index < tabla.data.length; index++) {
            if(tabla.data[index].default==0){
                $('#micliente').append($('<option>', {
                value: tabla.data[index].id,
                text: tabla.data[index].display+' - '+tabla.data[index].ci_nit +' - '+tabla.data[index].phone
                }));
            }
        }
        if($('#mipensionado').val()==0){
            mitotal()
        }

    }
    // Extras
    async function addextra(extras , producto_id, code) {
        $("#table-extras tbody tr").remove();
        $("#producto_extra_id").val(producto_id);
        $("#tr_producto").val(code);
        console.log(extras)
        var mitable="";
        var extrasp=  await axios.get("{{ setting('admin.url') }}api/pos/producto/extra/"+extras);
        for(let index=0; index < extrasp.data.length; index++){
            // var image = extrasp.data[index].image ? extrasp.data[index].image : "{{ setting('productos.imagen_default') }}"
            // mitable = mitable + "<tr><td> <img class='img-thumbnail img-sm img-responsive' height=40 width=40 src='{{setting('admin.url')}}storage/"+image+"'></td><td>"+extrasp.data[index].id+"</td><td><input class='form-control extra-name' readonly value='"+extrasp.data[index].name+"'></td><td><input class='form-control extra-precio' readonly  value='"+extrasp.data[index].precio+" Bs."+"'></td><td><input class='form-control extra-cantidad' style='width:100px' type='number' min='0' value='0'  id='extra_"+extrasp.data[index].id+"'></td></tr>";
            mitable = mitable + "<tr><td>"+extrasp.data[index].id+"</td><td><input class='form-control extra-name' readonly value='"+extrasp.data[index].name+"'></td><td><input class='form-control extra-precio' readonly  value='"+extrasp.data[index].precio+" Bs."+"'></td><td><input class='form-control extra-cantidad' style='width:100px' type='number' min='0' value='0'  id='extra_"+extrasp.data[index].id+"'></td></tr>";

        }
        $('#table-extras').append(mitable);
    }

    async function updatecantextra( name_extra, precio_extra, producto_id, code){
        var miprice = $("#precio_"+code).val()
        var nuevoprecio = parseFloat(precio_extra)+ parseFloat(miprice);
        var nuevototal = parseFloat(nuevoprecio).toFixed(2)*parseFloat($("#cant_"+code).val());
        var milist = JSON.parse(localStorage.getItem('micart'));
        var newlist = [];
        for (let index = 0; index < milist.length; index++) {
            if (milist[index].code == code) {
                    var miprice = milist[index].precio_inicial;
                    var nuevoprecio = parseFloat(precio_extra)+ parseFloat(miprice);
                    var nuevototal = parseFloat(nuevoprecio).toFixed(2)*parseFloat($("#cant_"+code).val());

                    var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': nuevoprecio ,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant, 'total':nuevototal, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name': name_extra, 'observacion':milist[index].observacion};
                    newlist.push(temp);
            }
            else{
                    var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio , 'precio_inicial': milist[index].precio_inicial ,'cant': milist[index].cant, 'total': milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                    newlist.push(temp);
            }
        }
        localStorage.setItem('micart', JSON.stringify(newlist));
        micart();
    }

    async function calcular_total_extra(){
        var cantidad=[];
        var name=[];
        var precio=[];
        var subtotal=0;
        var index_cantidad=0;
        var index_name_aux=0;
        var index_precio_aux=0;
        var index_cantidad_aux=0;
        var precio_extras=0;
        var nombre_extras="";

       $('.extra-cantidad').each(function(){
           if($(this).val()>0){
                cantidad[index_cantidad_aux]=parseFloat($(this).val());
                index_cantidad_aux+=1;
                var index_name=0;
                $('.extra-name').each(function(){
                    if(index_name==index_cantidad){
                        name[index_name_aux]=$(this).val();
                        index_name_aux+=1;
                    }
                    index_name+=1;
                });

                var index_precio=0;
                $('.extra-precio').each(function(){
                    if(index_precio==index_cantidad){
                        precio[index_precio_aux]=parseFloat($(this).val());
                        index_precio_aux+=1;
                    }
                    index_precio+=1;
                });

           }
           index_cantidad+=1;
       });

       for(let index=0;index<precio.length;index++){
        nombre_extras+=cantidad[index]+' '+name[index]+' ';
        //console.log(nombre_extras)
        precio_extras+=parseFloat(cantidad[index])*parseFloat(precio[index]);
       }
    //    console.log(cantidad);
    //    console.log(precio);
    //    console.log(name);
    //    console.log(nombre_extras);
    //    console.log(precio_extras);
       var producto_id=$("#producto_extra_id").val();
       var code=$("#tr_producto").val();
       var name_extra=nombre_extras;
       var precio_extra=precio_extras;
       updatecantextra(name_extra, precio_extra, producto_id, code);
    }

    //Agregar Observacion al Carrito
    async function updateobservacion(id,code){
        var observacion= ($("#observacion_"+code).val()).toUpperCase()
        //console.log(id)
        var milist = JSON.parse(localStorage.getItem('micart'));
        var newlist = [];
        for (let index = 0; index < milist.length; index++) {
            if (milist[index].code == code) {
                    var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio ,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant, 'total':milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name': milist[index].extra_name, 'observacion':observacion};
                    newlist.push(temp);
            }
            else{
                    var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio , 'cant': milist[index].cant, 'total': milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                    newlist.push(temp);
            }
        }
        localStorage.setItem('micart', JSON.stringify(newlist));
        micart();
    }

    //reset session
    function reset() {
        localStorage.removeItem('micaja');
        localStorage.setItem('micart', JSON.stringify([]));
        location.reload();
    }

    //Asignacion de Cortes
    let cortes = new Array('0.5', '1', '2', '5', '10', '20', '50', '100', '200');
    cortes.map(function(value){
    $('#lista_cortes').append(`<tr>
                    <td><h4><img src="{{url('billetes/${value}.jpg')}}" alt="${value} Bs." width="80px"> ${value} Bs. </h4></td>
                    <td><input type="number" min="0" step="1" style="width:100px" data-value="${value}" class="form-control input-corte" value="0" required></td>
                    <td><label id="label-${value.replace('.', '')}">0.00 Bs.</label><input type="hidden" class="input-subtotal" id="input-${value.replace('.', '')}"></td>
                </tr>`)
    });

    $('.input-corte').keyup(function(){
        let corte = $(this).data('value');
        let cantidad = $(this).val() ? $(this).val() : 0;
        calcular_subtottal(corte, cantidad);
    });

    $('.input-corte').change(function(){
        let corte = $(this).data('value');
        let cantidad = $(this).val() ? $(this).val() : 0;
        calcular_subtottal(corte, cantidad);
    });

    function calcular_subtottal(corte, cantidad){
        let total = (parseFloat(corte)*parseFloat(cantidad)).toFixed(2);
        $('#label-'+corte.toString().replace('.', '')).text(total+' Bs.');
        $('#input-'+corte.toString().replace('.', '')).val(total);
        let total_corte = 0;
        $(".input-subtotal").each(function(){
            total_corte += $(this).val() ? parseFloat($(this).val()) : 0;
        });
        $('#efectivo_entregado').val(total_corte);

        var cortes = JSON.stringify({corte: '0.5', cantidad: 10, valor: 5});
    }

    //get totales
    function get_total() {
        var micaja = JSON.parse(localStorage.getItem('micaja'));
        var editor_id = '{{ Auth::user()->id; }}';
        var midata = JSON.stringify({caja_id: micaja.caja_id, editor_id: editor_id});
        $.ajax({
            url: "{{ setting('admin.url') }}api/pos/caja/get_total/"+midata,
            dataType: "json",
            success: function (response) {
                $('#cant_ventas').val(response.cantidad);
                $('#total_ventas').val(response.total);
                $('#importe_inicial').val(micaja.importe);
                $('#ingresos').val(response.ingresos);
                $('#egresos').val(response.egresos);
                $('#venta_efectivo').val(response.total_efectivo);
                $('#venta_tarjeta').val(response.total_tarjeta);
                $('#venta_qr').val(response.total_qr);
                $('#venta_banipay').val(response.total_banipay);
                $('#cantidad_efectivo').val(response.cantidad_efectivo);
                $('#cantidad_tarjeta').val(response.cantidad_tarjeta);
                $('#cantidad_qr').val(response.cantidad_qr);
                $('#cantidad_banipay').val(response.cantidad_banipay);
                $('#ingreso_efectivo').val(response.ingreso_efectivo);
                $('#ingreso_linea').val(response.ingreso_linea);
                $('#egreso_efectivo').val(response.egreso_efectivo);
                $('#egreso_linea').val(response.egreso_linea);
                var total = (response.total + parseFloat(micaja.importe) + response.ingresos) - response.egresos;
                $('#_total').val(total);
            }
        });
    }

    // cargar asientos
    function cargar_asientos() {
        $("#asiento_list tbody tr").remove();
        var mitable = "";
        var editor = '{{ Auth::user()->id; }}';
        var total_banipay_ingresos=0;
        var total_banipay_egresos=0;
        var total_efectivo_ingresos=0;
        var total_efectivo_egreso=0;
        var total_efectivo_egresos=0;
        var micaja = JSON.parse(localStorage.getItem('micaja'));
        var midata = JSON.stringify({caja_id: micaja.caja_id, editor_id: editor});
        var urli = "{{ setting('admin.url') }}api/pos/asientos/caja/editor/"+midata;
        $.ajax({
            url: urli,
            dataType: "json",
            success: function (response) {
                if (response.length == 0 ) {
                    toastr.error('Sin Resultados.');
                } else {
                    for (let index = 0; index < response.length; index++) {
                        if (response[index].pago == 0) {
                            var pagotext="En Linea";
                            if(response[index].type=="Ingresos"){
                                total_banipay_ingresos+=response[index].monto;
                            }
                            else{
                                total_banipay_egresos+=response[index].monto;
                            }
                        }
                        if (response[index].pago == 1){
                            var pagotext="En Efectivo";
                            if(response[index].type=="Ingresos"){
                                total_efectivo_ingresos+=response[index].monto;
                            }
                            else{
                                total_efectivo_egresos+=response[index].monto;

                            }
                        }
                        mitable = mitable + "<tr><td>"+response[index].id+"</td><td>"+response[index].type+"</td><td>"+pagotext+"</td><td>"+response[index].monto+"</td><td>"+response[index].concepto+"</td><td>"+response[index].created_at+"</td></tr>";
                    }
                    $('#asiento_list').append(mitable);
                    if('{{setting('ventas.fila_totales')}}'){
                        $('#asiento_list').append("<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
                        $('#asiento_list').append("<tr><td></td><td><h4>Total Efectivo: <h4></td><td><h4>"+(total_efectivo_ingresos-total_efectivo_egresos)+"</h4></td><td></td><td><h4>Total Banipay: </h4></td><td><h4>"+(total_banipay_ingresos-total_banipay_egresos)+"</h4></td></tr>");
                    }
                }
            }
        });
    }

    //SAVE ASIENTOS
    function save_asiento() {
        if ($("input[name='pago']:checked").val() == '0') {
            var pagotext="En Linea";
        }
        if ($("input[name='pago']:checked").val() == '1'){
            var pagotext="En Efectivo";
        }
        var pago=$("input[name='pago']:checked").val();
        var micaja = JSON.parse(localStorage.getItem('micaja'));
        var concepto = $('#concepto').val();
        // var minew = micart[index].name
        var micon = concepto.replace('#', '')
        micon = micon.replace('%', '')
        var monto = $('#monto').val();
        var type = $('#type option:selected').val();
        var caja_id = micaja.caja_id;
        var editor_id = '{{ Auth::user()->id }}';

        var newconcepto = concepto
        newconcepto = newconcepto.replace('#', '')
        newconcepto = newconcepto.replace('%', '')

        var midata = JSON.stringify({caja_id: caja_id, type: type, monto: monto, editor_id: editor_id, concepto: newconcepto, pago:pago});
        console.log(midata);
        $.ajax({
            url: miurl,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                toastr.success('Asiento registrado como: '+response.type);
                $('#modal_asientos').modal('hide');
            }
        });
    }

    // GET CAMBIO
    $("input[name='recibido']").keyup(function (e) {
        e.preventDefault();

        var cambio = $("input[name='recibido']").val() - $("input[name='total']").val();
        $("input[name='cambio']").val(cambio);

        if (e.keyCode == 13) {
            saveventas()
        }

    });

     // CAMBIO TPV
    function get_cambio() {
        var micart = JSON.parse(localStorage.getItem('micart'));
        if (micart.length == 0 ) {
            toastr.error('Tu Carrito esta Vacio');
            // $('#modal_save_venta').modal('hide');
        } else {
           $("input[name='recibido']").val(0);
           $("input[name='cambio']").val(0);
            var total = 0;
            for (let index = 0; index < micart.length; index++) {
            total = total + micart[index].total;
        }
        }
    }

    //ADD MIXTA
    async function addmixta() {
        var id = $('#s').val();
        var mixta1 = $('#mixta1').val();
        var mixta2 = $('#mixta2').val();
        var miresponse1 = await axios.get("{{ setting('admin.url') }}api/pos/producto/"+mixta1);
        var miresponse2 = await axios.get("{{ setting('admin.url') }}api/pos/producto/"+mixta2);
        var newcode = Math.floor(1000 + Math.random() * 9000);


        var cant_actual1 = 0;
        var cant_actual2 = 0;
        var cant_i1=false;
        var cant_i2=false;
        var prod1= "";
        var prod2= "";

        var inventario = false;
        if("{{setting('ventas.stock')}}"){
            inventario = true;
            prod1=miresponse1.data.name;
            cant_actual1 = miresponse1.data.stock;
            if(cant_actual1>1){
                cant_i1=true;
            }
            else{
                cant_i1=false;
            }
        }
        if("{{setting('ventas.stock')}}"){
            prod2=miresponse2.data.name;
            cant_actual2 = miresponse2.data.stock;
            if(cant_actual2>1){
                cant_i2=true;
            }
            else{
                cant_i2=false;
            }
        }

        if(inventario){
            if(cant_i1){
                if(cant_i2){
                    var vencimiento1=miresponse1.vencimiento ? miresponse1.vencimiento :1;
                    var vencimiento2=miresponse2.vencimiento ? miresponse2.vencimiento :1;
                    if(vencimiento1 || CalculoDiasRestantes(miresponse1.vencimiento)>=1){
                        if(vencimiento2 || CalculoDiasRestantes(miresponse2.vencimiento)>=1){
                            var micart_t = JSON.parse(localStorage.getItem('micart'));
                            var description = $('#mixta1 :selected').text() + ' - ' + $('#mixta2 :selected').text();
                            $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/producto/"+id,
                            dataType: "json",
                            success: function (response) {
                                $('#mixtos').attr("hidden", true);
                                var temp = {'code':newcode,'id': response.id, 'image': response.image, 'name': response.name, 'precio': response.precio, 'precio_inicial':response.precio , 'cant': 1, 'total': response.precio, 'description': description, 'extra': response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':'' };
                                micart_t.push(temp);
                                localStorage.setItem('micart', JSON.stringify(micart_t));
                                micart();
                                toastr.success(response.name+" - REGISTRADO");
                                }
                            });
                        }
                        else{
                            toastr.error("El producto: "+prod2+" está vencido");
                        }
                    }
                    else{
                        toastr.error("El producto: "+prod1+" está vencido");
                    }
                }else{
                    toastr.error("No existe en Stock: "+prod2);
                }
            }else{
                toastr.error("No existe en Stock: "+prod1);
            }
        }
        else{
            var newprecio = (miresponse1.data.precio > miresponse2.data.precio) ?  miresponse1.data.precio : miresponse2.data.precio
            var micart_t = JSON.parse(localStorage.getItem('micart'));
            var miproduct = JSON.parse(localStorage.getItem('miproduct'));
            var description = $('#mixta1 :selected').text() + ' - ' + $('#mixta2 :selected').text();
            $.ajax({
                url: "{{ setting('admin.url') }}api/pos/producto/"+miproduct.id,
                dataType: "json",
                success: function (response) {
                    var miimage =response.image ? response.image : "{{ setting('productos.imagen_default') }}";
                    $('#mixtos').attr("hidden", true);
                    var temp = {'code': newcode, 'id': response.id, 'image': miimage, 'name': response.name, 'precio': newprecio, 'precio_inicial': newprecio, 'cant': 1, 'total': newprecio, 'description': description, 'extra': response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':''};
                    micart_t.push(temp);
                    localStorage.setItem('micart', JSON.stringify(micart_t));
                    micart();
                    toastr.success(response.name+" - REGISTRADO");
                }
            });

        }
    }

    //Busquedas de Clientes
    $('#cliente_busqueda').keyup(function (e) {
        e.preventDefault();
        if (e.keyCode == 13) {
            $("#cliente_list tbody tr").remove();
            var mitable = "";
            $.ajax({
                url: "{{ setting('admin.url') }}api/pos/clientes/search/"+this.value,
                dataType: "json",
                success: function (response) {
                    if (response.length == 0 ) {
                        toastr.error('Sin Resultados.');
                    } else {
                        toastr.success('Clintes Encontrados');
                        for (let index = 0; index < response.length; index++) {
                            mitable = mitable + "<tr><td>"+response[index].id+"</td><td>"+response[index].display+"</td><td>"+response[index].ci_nit+"</td><td>"+response[index].phone+"</td><td><a class='btn btn-xs btn-dark' onclick='cliente_get("+response[index].id+")'>...</a></td></tr>";
                        }
                        $('#cliente_list').append(mitable);
                    }
                }
            });
        }
    });

    // cliente_get
    function cliente_get(id) {
        // $.ajax({
        //     url: "{{ setting('admin.url') }}api/pos/cliente/"+id,
        //     dataType: "json",
        //     success: function (response) {
        //         $("input[name='cliente_id']").val(id);
        //         $('#micliente').val(id);
        //         $('#micliente').text(response.display + ' - ' + response.ci_nit);
                $('#modal_cliente').modal('hide');
        //     }
        // });
    }

    // ADD DISPLAY
    $('#first_name').keyup(function (e) {
        e.preventDefault();
        $('#display').val(this.value+' '+$('#last_name').val());
        $('#email').val(this.value.toLowerCase()+'.'+$('#last_name').val().toLowerCase()+'@loginweb.dev');
    });

    $('#last_name').keyup(function (e) {
        e.preventDefault();
        $('#display').val($('#first_name').val()+' '+this.value);
        $('#email').val($('#first_name').val().toLowerCase()+'.'+this.value.toLowerCase()+'@loginweb.dev');
    });

    function cerrar_caja() {

        var micaja = JSON.parse(localStorage.getItem('micaja'));
        var total_ventas = $('#total_ventas').val();
        var importe_inicial = $('#importe_inicial').val();
        var ingresos = $('#ingresos').val();
        var egresos = $('#egresos').val();
        var description = $('#description').val();
        var _total = $('#_total').val();
        var cant_ventas = $('#cant_ventas').val();
        var venta_efectivo = $('#venta_efectivo').val();
        var venta_tarjeta = $('#venta_tarjeta').val();
        var venta_qr = $('#venta_qr').val();
        var venta_banipay = $('#venta_banipay').val();
        var cantidad_efectivo = $('#cantidad_efectivo').val();
        var cantidad_tarjeta = $('#cantidad_tarjeta').val();
        var cantidad_qr = $('#cantidad_qr').val();
        var cantidad_banipay = $('#cantidad_banipay').val();
        var efectivo_entregado = $('#efectivo_entregado').val();
        var cortes = $('#cortes').val();
        var ingreso_efectivo=$('#ingreso_efectivo').val();
        var ingreso_linea=$('#ingreso_linea').val();
        var egreso_efectivo=$('#egreso_efectivo').val();
        var egreso_linea=$('#egreso_linea').val();
        var editor_id = '{{ Auth::user()->id }}';
        var caja_id = micaja.caja_id;
        var status = 'close';
        var midata = JSON.stringify({caja_id: caja_id, editor_id: editor_id, cant_ventas: cant_ventas, _total: _total, description: description, egresos: egresos, ingresos: ingresos, importe_inicial: importe_inicial, total_ventas: total_ventas, status: status, venta_efectivo: venta_efectivo, cantidad_efectivo: cantidad_efectivo, venta_banipay:venta_banipay, cantidad_banipay:cantidad_banipay ,venta_tarjeta:venta_tarjeta,cantidad_tarjeta:cantidad_tarjeta,venta_qr:venta_qr,cantidad_qr:cantidad_qr, efectivo_entregado: efectivo_entregado, cortes: cortes, ingreso_efectivo: ingreso_efectivo, ingreso_linea: ingreso_linea, egreso_efectivo: egreso_efectivo, egreso_linea: egreso_linea});
        $.ajax({
            url: "{{ setting('admin.url') }}api/pos/caja/detalle/save/"+midata,
            success: function (response){
                localStorage.removeItem('micaja');
                window.open( "{{ setting('admin.url') }}admin/detalle_cajas/imprimir/"+response.id, "Recibo", "width=500,height=700");
                location.href = '/admin/profile';
            }
        });
    }

    async function venta_caja() {
        $('#productos_caja tbody').empty();
        var user_id = '{{ Auth::user()->id }}';
        var micaja = JSON.parse(localStorage.getItem('micaja'));
        var misventas = await axios("{{ setting('admin.url') }}api/pos/ventas/caja/"+$("input[name='caja_id']").val()+"/"+user_id);
        var total_efectivo=0;
        var total_banipay=0;
        var total_tarjeta=0;
        var total_qr=0;
        for (let index = 0; index < misventas.data.length; index++) {

            var detalle_venta= await axios.get("{{setting('admin.url')}}api/pedido/detalle/"+misventas.data[index].id)
            var nombres=""
            for (let j = 0; j < detalle_venta.data.length; j++) {
                nombres= nombres +detalle_venta.data[j].cantidad+" "+detalle_venta.data[j].name+"<br>"
            }
            if(misventas.data[index].pasarela.id==6){
                total_tarjeta+=misventas.data[index].total;
            }
            else if(misventas.data[index].pasarela.id==7){
                total_qr+=misventas.data[index].total;
            }
            else{
                total_efectivo+=misventas.data[index].total;
            }
            if(misventas.data[index].option_id=="{{ setting('ventas.pedido_domicilio_id') }}"||misventas.data[index].option_id=="{{ setting('ventas.delivery_zona1') }}"||misventas.data[index].option_id=="{{ setting('ventas.delivery_zona2') }}"){
                $("#productos_caja").append("<tr><td>"+nombres+"</td><td>"+misventas.data[index].ticket+"</td><td>"+misventas.data[index].pasarela.title+"</td><td>"+misventas.data[index].cliente.display+"</td><td>"+misventas.data[index].delivery.name+"</td><td>"+misventas.data[index].chofer.name+"</td><td>"+misventas.data[index].factura+"</td><td>"+misventas.data[index].total+"</td><td>"+misventas.data[index].published+"</td><td><a href='#deliverys' aria-controls='deliverys' role='tab' data-toggle='tab' class='btn btn-sm btn-primary' onclick='set_chofer("+misventas.data[index].id+")'>Chofer</a></td></tr>");
            }
            else{
                $("#productos_caja").append("<tr><td>"+nombres+"</td><td>"+misventas.data[index].ticket+"</td><td>"+misventas.data[index].pasarela.title+"</td><td>"+misventas.data[index].cliente.display+"</td><td>"+misventas.data[index].delivery.name+"</td><td>"+misventas.data[index].chofer.name+"</td><td>"+misventas.data[index].factura+"</td><td>"+misventas.data[index].total+"</td><td>"+misventas.data[index].published+"</td><td></td></tr>");
            }
        }
        if('{{setting('ventas.fila_totales')}}'){
            $("#productos_caja").append("<tr><td colpsan='10'><hr></td></tr>")
            $("#productos_caja").append("<tr><td><h4>Importe Inicial: </h4></td><td><h4>"+micaja.importe+"</h4></td><td><h4>Total Efectivo: </h4></td><td><h4>"+total_efectivo+"</h4></td><td><h4>Total Tarjeta: </h4></td><td><h4>"+total_tarjeta+"</h4></td><td><h4>Total QR: </h4></td><td><h4>"+total_qr+"</h4></td><td><h4>Total Banipay: </h4></td><td><h4>"+total_banipay+"</h4></td></tr>");
        }
    }

    async function set_chofer(id){
        $('#mideliverys').find('option').remove().end();
        var mideliverys = await axios("{{ setting('admin.url') }}api/pos/users");
        $('#mideliverys').append($('<option>', {
            value: null,
            text: 'Elige un Chofer'
        }));
        for (let index = 0; index < mideliverys.data.length; index++) {
            if(mideliverys.data[index].role_id=="{{setting('ventas.role_id_chofer')}}"){
                $('#mideliverys').append($('<option>', {
                    value: mideliverys.data[index].id,
                    text: mideliverys.data[index].name
                }));
            }
        }
        $('#venta_id').val(id);
    }

    async function save_set_chofer() {
        var chofer_id =  $('#mideliverys').val();
        var venta_id =  $('#venta_id').val();
        var save = await axios("{{ setting('admin.url') }}api/pos/chofer/set/"+venta_id+"/"+chofer_id);
        toastr.success('Chofer Asignado');
        $('#venta_caja').modal('hide');
    }

    function abrir_caja(id, title, sucursal, sucursal_id) {
        $.ajax({
            url: "{{ setting('admin.url') }}api/pos/caja/state/open/"+id,
            success: function (response){
                localStorage.setItem('micaja', JSON.stringify({caja_id: id, open: 'open', user_id: '{{ Auth::user()->id  }}', title: title, sucursal: sucursal, importe: $('#importe_'+id).val(), sucursal_id: sucursal_id } ));
                $("input[name='caja_id']").val(id);
                var micaja = JSON.parse(localStorage.getItem('micaja'));
                $("input[name='caja_id']").val(micaja.caja_id);
                $("input[name='sucursal_id']").val(micaja.sucursal_id);
                $("#info_caja").html("<h4>"+micaja.title+" - "+micaja.sucursal+" - "+micaja.importe+" Bs. - <a href='#' onclick='reset()'>Reset</a></h4>");
                toastr.success('Caja Abierta Correctamente.');
                $('#micaja').modal('hide');

            }
        });
    }

    // cliente
     $('#micliente').on('change', function() {
        $('input[name="cliente_id"]').val(this.value);
        toastr.success('Cambio de Cliente');
    });

    $('#midelivery').on('change', function() {
        $("input[name='delivery_id']").val(this.value);
        toastr.success('Cambio de Delivery');
    });

    $('#mipagos').on('change', function() {
        $("input[name='pago_id']").val(this.value);
        toastr.success('Cambio de Pasarela');
    });

    $('#micupon').on('change', function() {
        $("input[name='cupon_id']").val(this.value);
    });

    $('#venta_type').on('change', function() {
        $("input[name='option_id']").val(this.value);
        toastr.success('Cambio Tipo');
    });

    //save cliente
    async function savecliente() {
        var first = $('#first_name').val()
        var last = $('#last_name').val()
        var phone = $('#phone').val()
        var nit = $('#nit').val()
        var display = $('#display').val()
        var email = $('#email').val()
        var midata ={
            first_name: first,
            last_name: last,
            phone: phone,
            nit: nit,
            display: display,
            email: email
        };
        var newcliente = await axios.post("{{ setting('admin.url') }}api/pos/cliente/save", midata).
            catch(function (error) {
                // console.log(error.toJSON());
                $('#first_name').val('')
                $('#last_name').val('')
                $('#display').val('')
                $('#email').val('')
                toastr.error('Error en el registro')
                return false
            });
        toastr.success('Cliente registrad@: '+newcliente.data.display)
        $('#micliente').append($('<option>', {
            value: newcliente.data.id,
            text: newcliente.data.display+' - '+newcliente.data.ci_nit+' - '+newcliente.data.phone,
            selected: true
        }));
        $("input[name='cliente_id']").val(newcliente.data.id)
        $('#modal_cliente').modal('hide')
    }

    $('#micupon').on('change', function() {
        $.ajax({
            url: "{{ setting('admin.url') }}api/pos/cupon/"+this.value,
            dataType: "json",
            success: function (response) {
                toastr.success('Cupon Asignado');
                $("input[name='descuento']").val(response.valor);
                mitotal();
            }
        });
    });

    $('#miestado').on('change', function() {
        $("input[name='status_id']").val(this.value);
        mitotal();
    });

    $('input[type=radio][name=credito]').on('change', function() {
        switch ($(this).val()) {
            case 'Contado':
                $("input[name='status_credito']").val(0);
                mitotal();

                toastr.info('Venta Actualizada')
            break;
            case 'Credito':
                $("input[name='status_credito']").val(1);
                $("input[name='total']").val(0);
                toastr.info('Venta Actualizada')
            break;
        }
    });

    async function saveventas() {
        var micart = JSON.parse(localStorage.getItem('micart'));
        if (micart.length == 0 ) {
            toastr.error('Tu Carrito esta Vacio');
        }
        else{
            toastr.warning('Realizando nuevo pedido..');
            var cliente_id = $("input[name='cliente_id']").val();
            var cupon_id = $("input[name='cupon_id']").val();
            var pago_id = $("input[name='pago_id']").val();
            var status_id = $("input[name='status_id']").val();
            var option_id = $("input[name='option_id']").val();
            var factura = $("input[name='factura']:checked").val();
            var credito = $("input[name='credito']:checked").val();
            var status_credito=$("input[name='status_credito']").val();
            var total = $("input[name='total']").val();
            var descuento = $("input[name='descuento']").val();
            var observacion = $("input[name='observacion']").val();
            var register_id = $("input[name='register_id']").val();
            var caja_id = $("input[name='caja_id']").val();
            var delivery_id = $("input[name='delivery_id']").val();
            var sucursal_id = $("input[name='sucursal_id']").val();
            var subtotal = $("input[name='subtotal']").val();
            var recibido = $("input[name='recibido']").val();
            var cambio = $("input[name='cambio']").val();
            var chofer_id=$("input[name='chofer_id']").val();
            var adicional=$("input[name='adicional']").val();
            var pensionado_id=$("input[name='pensionado_id']").val();
            var nro_factura=null;

            if($("input[name='factura']:checked").val()=="Factura"){
                nrofactura =await axios("{{setting('admin.url')}}api/pos/nro_factura")
                nro_factura=nrofactura.data;
            }
            else{
                nrofactura=null;
                nro_factura=nrofactura;
            }
            var micart = JSON.parse(localStorage.getItem('micart'));
            var midata = JSON.stringify({'cliente_id': cliente_id, 'cupon_id': cupon_id, 'option_id': option_id, 'pago_id': pago_id, 'factura': factura, 'credito': credito ,'total': total, 'descuento': descuento, 'observacion': observacion, 'register_id': register_id, 'status_id': status_id, 'caja_id': caja_id, 'delivery_id': delivery_id, 'sucursal_id': sucursal_id, subtotal: subtotal, 'cantidad': micart.length, 'recibido': recibido, 'cambio': cambio, chofer_id : chofer_id, adicional:adicional, 'pensionado_id':pensionado_id, 'status_credito':status_credito, 'nro_factura':nro_factura });
            var venta = await axios.get("{{ setting('admin.url') }}api/pos/ventas/save/"+midata)
            switch ($('#mipagos').val()) {
                case '2':

                    for (let index = 0; index < micart.length; index++) {
                        var minew = micart[index].name
                        minew = minew.replace('#', '')
                        minew = minew.replace('%', '')
                        var midata2 = JSON.stringify({'producto_id': micart[index].id, 'venta_id': venta.data.id, 'precio': micart[index].precio, 'cantidad': micart[index].cant, 'total': micart[index].total, 'name': minew, 'foto':micart[index].foto, 'description': micart[index].description, 'extra_name':micart[index].extra_name, 'observacion':micart[index].observacion});

                        var venta_detalle = await axios.get("{{ setting('admin.url') }}api/pos/ventas/save/detalle/"+midata2)
                        $("#micart tr#"+micart[index].id).remove();
                        mitotal();
                    }
                    // BANIPAY
                    var micart2 = []
                    for (let index = 0; index < micart.length; index++) {
                        micart2.push({"concept": micart[index].name, "quantity": micart[index].cant, "unitPrice": micart[index].precio})
                    }
                    var miconfig = {"affiliateCode": "{{ setting('banipay.affiliatecode') }}",
                        "notificationUrl": "{{ setting('banipay.notificacion') }}",
                        "withInvoice": false,
                        "externalCode": venta.data.id,
                        "paymentDescription": "Pago por la compra en {{ setting('admin.title') }}",
                        "details": micart2,
                        "postalCode": "{{ setting('banipay.moneda') }}"
                        }
                        var banipay = await axios.post('https://banipay.me:8443/api/payments/transaction', miconfig)
                        var midata3 = JSON.stringify({paymentId: banipay.data.paymentId, transactionGenerated: banipay.data.transactionGenerated, externalCode: banipay.data.externalCode})
                        await axios.get("{{ setting('admin.url') }}api/pos/banipay/save/"+midata3)

                        if ($("input[name='season']:checked").val() == 'imprimir') {
                            localStorage.setItem('micart', JSON.stringify([]));
                                const myWindow = window.open( "{{ setting('admin.url') }}admin/ventas/imprimir/"+venta.data.id, "Recibo o Factura", "width=600,height=900");
                                setTimeout(function() {myWindow.close()}, {{ setting('impresion.tiempo_cierre') }});
                        }else{
                            localStorage.setItem('micart', JSON.stringify([]));
                        }
                    break;
                default:

                    for (let index = 0; index < micart.length; index++) {
                        var newname = micart[index].name
                        newname = newname.replace('%', '')
                        newname = newname.replace('#', '')
                        var midata2 = JSON.stringify({'producto_id': micart[index].id, 'venta_id': venta.data.id, 'precio': micart[index].precio, 'cantidad': micart[index].cant, 'total': micart[index].total, 'name': newname, 'foto':micart[index].foto, 'description': micart[index].description, 'extra_name':micart[index].extra_name, 'observacion':micart[index].observacion})
                        var impresion="{{ setting('admin.url') }}api/pos/ventas/save/detalle/"+midata2
                        //console.log(impresion)
                        var venta_detalle = await axios.get(impresion)
                        mitotal()

                    }
                    if(venta.data.credito=="Credito"){
                       CrearCredito(venta.data.id, venta.data.cliente_id);
                    }

                    if ($("input[name='season']:checked").val() == 'imprimir') {
                        localStorage.setItem('micart', JSON.stringify([]));
                            const myWindow = window.open( "{{ setting('admin.url') }}admin/ventas/imprimir/"+venta.data.id, "Recibo o Factura", "width=600,height=900");
                            setTimeout(function() {myWindow.close()}, {{ setting('impresion.tiempo_cierre') }});
                    }else{
                        localStorage.setItem('micart', JSON.stringify([]));
                    }
                    break;
            }
            toastr.info('Venta #'+venta.data.id+' Realizada Correctamente');
        }
        socket.emit("{{setting('notificaciones.cocina')}}", venta.data.id)
        LimpiarVenta();
    }

    async function LimpiarVenta() {
        $('input[name="register_id"]').val('{{ Auth::user()->id }}');
        $('input[name="chofer_id"]').val("{{setting('ventas.chofer')}}");
        $("input[name='status_credito']").val(0);
        Categorias();
        Deliverys();
        Cliente();
        Cupones();
        Pasarelas();
        Estados();
        Opciones();
        Pensionados();
        $("[name=credito]").val(["Contado"]);
        $("[name=season]").val(["imprimir"]);
        $("[name=factura]").val(["Recibo"]);
        $("input[name='total']").val(0);
        $("input[name='descuento']").val(0);
        $("input[name='observacion']").val("sin observ.");
        $("input[name='subtotal']").val(0);
        $("input[name='recibido']").val(0);
        $("input[name='cambio']").val(0);
        micart();
    }
    $('#category').on('change', async function() {
        if (this.value == 0) {
            $.ajax({
                url: "{{ setting('admin.url') }}api/pos/productos/",
                dataType: "json",
                success: function (response) {
                    $('#s').find('option').remove().end();
                    $('#s').append($('<option>', {
                        value: null,
                        text: 'Elige un Producto'
                    }));
                    for (let index = 0; index < response.length; index++) {
                        $('#s').append($('<option>', {
                            value: response[index].id,
                            text: response[index].abreviatura+'-'+response[index].name+'-'+response[index].precio+'-'+response[index].stock
                        }));
                    }
                }
            });
        } else {
            var products = await axios("{{ setting('admin.url') }}api/pos/productos/category/"+this.value)
            $('#s').find('option').remove().end();
            $('#s').append($('<option>', {
                value: null,
                text: 'Elige un Producto'
            }));
            for (let index = 0; index < products.data.length; index++) {
                $('#s').append($('<option>', {
                    value: products.data[index].id,
                    text: products.data[index].categoria.abreviatura+'-'+products.data[index].name+'-'+products.data[index].precio+'-'+products.data[index].stock
                }));
            }
        }
    });

    function mitotal() {
        var milist = JSON.parse(localStorage.getItem('micart'));
        var cant = milist.length;
        var des = $("input[name='descuento']").val();
        var total = 0;
        var adicional=parseFloat($("input[name='adicional']").val());
        for (let index = 0; index < milist.length; index++) {
            total = total + milist[index].total;
        }

        $("input[name='subtotal']").val(parseFloat(total).toFixed(2));
        $("input[name='total']").val(parseFloat(total+adicional-des).toFixed(2));
        $("input[name='cantidad']").val(cant);
    }

    $('#s').on('change', function() {
        console.log(this.value + " change s")
        addproduct(this.value);
    });

    $("input[name='adicional']").on('change', function() {
        mitotal();
    });
    $("input[name='adicional']").keyup(function(){
        mitotal();
    });

    $("input[name='descuento']").on('change', function() {
        mitotal();
    });
    $("input[name='descuento']").keyup(function(){
        mitotal();
    });

    async function addproduct(id) {
        $("#miresult").attr("hidden", true)
        var total = 0;
        var micart_temp = JSON.parse(localStorage.getItem('micart'));
        $("#micart tr#0").remove();
        var newcode = Math.floor(1000 + Math.random() * 9000);
        $.ajax({
            url: "{{ setting('admin.url') }}api/pos/producto/"+id,
            dataType: "json",
            success: function (response) {
                var miimage =response.image ? response.image : "{{ setting('productos.imagen_default') }}"
                var producto_aux=response;
                if('{{setting('ventas.stock')}}'){
                    // console.log(producto_aux)
                    if (response.mixta == 1 ) {
                        $('#mixtos').attr("hidden",false);
                        var micategory = $('#category').val();
                        console.log(micategory)
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/producto/mixto/0/"+micategory,
                            dataType: "json",
                            success: function (response) {
                                $('#mixta1').append($('<option>', {
                                    value: null,
                                    text: 'Elige una Mitad'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    $('#mixta1').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].name
                                    }));
                                }
                                $('#mixta2').append($('<option>', {
                                    value: null,
                                    text: 'Elige una Mitad'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    $('#mixta2').append($('<option>', {
                                        value: response[index].id,
                                            text: response[index].name
                                    }));
                                }
                            }
                        });
                    } else {
                        $('#mixtos').attr("hidden",true);
                        var vencimiento=response.vencimiento ? response.vencimiento: 1 ;
                        if((response.stock >= 1 && CalculoDiasRestantes(response.vencimiento)>0)||(vencimiento==1 && response.stock >= 1 )){
                            if(response.stock <= '{{setting('ventas.minimo_stock')}}')
                            {
                                toastr.error("Solo quedan: "+response.stock+" "+response.name +" ");
                            }
                            //else{
                                // var newname = response.name
                                // newname = newname.replace('%', '')
                                // newname = newname.replace('#', '')
                                var temp = {'code':newcode, 'id': response.id, 'image': miimage, 'name': response.name, 'precio': response.precio, 'precio_inicial':response.precio, 'cant': 1, 'total': response.precio, 'description': '', 'extra':response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':''}
                                micart_temp.push(temp)
                                localStorage.setItem('micart', JSON.stringify(micart_temp))
                                micart()
                                toastr.success(response.name+" - REGISTRADO")
                            //}
                        }
                        else{
                            if(response.stock<1){
                                toastr.error("No existe el producto: "+response.name +" en Stock");
                            }
                            if(CalculoDiasRestantes(response.vencimiento)<=0){
                                if(response.vencimiento!=null){
                                    toastr.error("El producto: "+response.name +" está vencido");
                                }
                            }
                        }
                    }
                } else {
                    if (response.mixta == 1 ) {
                        $('#mixtos').attr("hidden",false);
                        $('#mixta1').find('option').remove().end();
                        $('#mixta2').find('option').remove().end();
                        $("#category").val(response.categoria_id).change();
                        localStorage.setItem('miproduct', JSON.stringify(response))
                        var micategory = $('#category').val();
                        $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/producto/mixto/0/"+micategory,
                            dataType: "json",
                            success: function (response) {
                                $('#mixta1').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Mitad'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    $('#mixta1').append($('<option>', {
                                        value: response[index].id,
                                            text: response[index].name
                                    }));
                                }
                                $('#mixta2').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Mitad'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    $('#mixta2').append($('<option>', {
                                        value: response[index].id,
                                            text: response[index].name
                                    }));
                                }
                            }
                        });
                    } else {
                        $('#mixtos').attr("hidden",true);
                        var nuevoprecio=0;
                        if((response.categoria_id==8)||(response.categoria_id==1)){
                            nuevoprecio=Math.ceil(response.precio*(1-parseFloat("{{setting('ventas.promo_martes')}}")))
                        }
                        else{
                            nuevoprecio=response.precio
                        }
                        // console.log(response.categoria_id)
                        // var newname = response.name
                        // newname = newname.replace('%', '')
                        // newname = newname.replace('#', '')
                        var temp = {'code': newcode, 'id': response.id, 'image': miimage, 'name': response.name, 'precio': nuevoprecio, 'precio_inicial':nuevoprecio, 'cant': 1, 'total': nuevoprecio, 'description': '', 'extra':response.extra, 'extras':response.extras, 'extra_name':'', 'observacion':''}
                        micart_temp.push(temp);
                        localStorage.setItem('micart', JSON.stringify(micart_temp))
                        micart()
                        toastr.success(response.name+" - REGISTRADO")
                    }
                }
            }
        });
    }

    function midelete(id) {
        $("#micart tr#"+id).remove();
        var milist = JSON.parse(localStorage.getItem('micart'));
        var newlist = [];
        for (let index = 0; index < milist.length; index++) {
            if (milist[index].code == id) {
                toastr.error(milist[index].name+" - ELIMINADO");
            } else {
                var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio, 'precio_inicial':milist[index].precio_inicial, 'cant': milist[index].cant, 'total': milist[index].total, 'description': milist[index].description, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion };
                newlist.push(temp);
            }
        }
        localStorage.setItem('micart', JSON.stringify(newlist));
        mitotal();
    }
    async function CrearCredito(venta, cliente){
        var table=await axios("{{setting('admin.url')}}api/pos/venta/"+venta);
            var venta_id=venta;
            var cliente_id=cliente;
            var deuda=table.data.subtotal+table.data.adicional-table.data.descuento;
            var cuota=table.data.total;
            var restante=parseFloat(deuda).toFixed(2)-parseFloat(cuota).toFixed(2);
            if(restante<=0){
                var status=1;
            }
            else{
                var status=0;
            }
            var midata = JSON.stringify({'venta_id':venta_id,'cliente_id':cliente_id,'deuda':deuda,'cuota':cuota,'restante':restante,'status':status});
            var table= await axios("{{setting('admin.url')}}api/pos/cobrar-credito/"+midata);
    }

    async function updatecant(id,code) {

        //  GET GESTION INVENTARIO
        var cant_actual = 0;
        var inventario = false;
        if('{{setting('ventas.stock')}}'){
            var response = await axios("{{ setting('admin.url') }}api/pos/producto/"+id);
            cant_actual = response.data.stock;
            inventario = true;
        }
        var total = parseFloat($("#precio_"+code).val()).toFixed(2) * parseInt($("#cant_"+code).val());
        $("#total_"+code).val(parseFloat(total).toFixed(2));

        var milist = JSON.parse(localStorage.getItem('micart'));
        var newlist = [];
        for (let index = 0; index < milist.length; index++) {
            if (milist[index].code == code) {
                if(inventario){
                    if (milist[index].cant > cant_actual ) {
                        toastr.error('Cantidad Excedida')
                    } else {
                        var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': parseFloat($("#precio_"+code).val()).toFixed(2), 'precio_inicial':parseFloat($("#precio_"+code).val()).toFixed(2) , 'cant': parseInt($("#cant_"+code).val()), 'total': total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                        newlist.push(temp);
                    }
                }else{
                    var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description ,'precio': parseFloat($("#precio_"+code).val()).toFixed(2), 'precio_inicial':parseFloat($("#precio_"+code).val()).toFixed(2) , 'cant': parseInt($("#cant_"+code).val()), 'total': total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                    newlist.push(temp);
                }
            }else{
                var temp = {'code':milist[index].code,'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description ,'precio': milist[index].precio, 'precio_inicial':milist[index].precio_inicial , 'cant': milist[index].cant, 'total': milist[index].total,  'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                newlist.push(temp);
            }
        }
        localStorage.setItem('micart', JSON.stringify(newlist));
        mitotal();
    }

    async function updateprice(id,code) {
        updatecant(id,code);
    }

    function micart(){
        $("#micart tbody tr").remove();
        var milist = JSON.parse(localStorage.getItem('micart'));
        if(milist.length == 0){
            $("#micart").append("<tr id=0><td colspan='4'> <img class='img-responsive img-sm' src={{ setting('admin.url') }}storage/231-2317260_an-empty-shopping-cart-viewed-from-the-side.png></td></tr>");
        }else{
            for (let index = 0; index < milist.length; index++) {
                if(milist[index].extra){
                    $("#micart").append("<tr id="+milist[index].code+"><td>"+milist[index].id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+milist[index].image+"></td><td>"+milist[index].name+"<br>"+milist[index].description+"<br>"+milist[index].extra_name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+milist[index].id+","+milist[index].code+")' value='"+milist[index].observacion+"' id='observacion_"+milist[index].code+"'></td><td><a  class='btn btn-sm btn-success'  data-toggle='modal' data-target='#modal-lista_extras' onclick='addextra("+milist[index].extras+", "+milist[index].id+","+milist[index].code+")'><i class='voyager-plus'></i></a></td><td><input class='form-control' type='number' value='"+milist[index].precio+"' id='precio_"+milist[index].code+"' onchange='updateprice("+milist[index].id+","+milist[index].code+")'></td><td><input class='form-control' type='number' onchange='updatecant("+milist[index].id+","+milist[index].code+")' onclick='updatecant("+milist[index].id+","+milist[index].code+")' value='"+milist[index].cant+"' id='cant_"+milist[index].code+"'></td><td><input class='form-control' type='number' value='"+milist[index].total+"' id='total_"+milist[index].code+"' readonly></td><td><a class='btn btn-sm btn-danger' onclick='midelete("+milist[index].code+")'><i class='voyager-trash'></i></a></td></tr>");
                }
                else{
                    $("#micart").append("<tr id="+milist[index].code+"><td>"+milist[index].id+"</td><td> <img class='img-thumbnail img-sm img-responsive' src={{ setting('admin.url') }}storage/"+milist[index].image+"></td><td>"+milist[index].name+"<br>"+milist[index].description+"<br>"+milist[index].extra_name+"</td><td><input class='form-control' type='text' onchange='updateobservacion("+milist[index].id+","+milist[index].code+")' value='"+milist[index].observacion+"' id='observacion_"+milist[index].code+"'></td><td></td><td><input class='form-control' type='number' value='"+milist[index].precio+"' id='precio_"+milist[index].code+"' onchange='updateprice("+milist[index].id+","+milist[index].code+")'></td><td><input class='form-control' type='number'  onchange='updatecant("+milist[index].id+","+milist[index].code+")' onclick='updatecant("+milist[index].id+","+milist[index].code+")' value='"+milist[index].cant+"' id='cant_"+milist[index].code+"'></td><td><input class='form-control' type='number' value='"+milist[index].total+"' id='total_"+milist[index].code+"' readonly></td><td><a class='btn btn-sm btn-danger' onclick='midelete("+milist[index].code+")'><i class='voyager-trash'></i></a></td></tr>");
                }
            }
            mitotal();
        }
    }

    $("#micart").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
           saveventas()
        }
    });

    async function saveproducto() {
        var micaja = JSON.parse(localStorage.getItem('micaja'));
        var midata = {
            name: $("#name").val(),
            precio: $("#precio").val(),
            stock: $("#stock").val(),
            categoria_id: $("#categoria_id").val(),
            sucursal_id: micaja.sucursal_id
        }
        // console.log(midata)
        var newpproduct = await axios.post("{{setting('admin.url')}}api/pos/producto/simple", midata).
            catch(function (error) {
                toastr.error('Error en el registro')
                return false
            });
        toastr.success('Registro exitoso: '+newpproduct.data.name)
        addproduct(newpproduct.data.id)
        $('#modal_producto').modal('hide')
    }
</script>
@stop
