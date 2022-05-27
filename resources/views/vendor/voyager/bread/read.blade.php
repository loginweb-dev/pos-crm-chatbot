@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))
    @switch($dataType->getTranslatedAttribute('slug'))

        @case('insumos')
            @section('page_header')
                <br>
                {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-2">
                        <h1 class="page-title">
                    <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

                    </div>                --}}
                    @php
                    $midata = App\Insumo::find($dataTypeContent->getKey());
                    $unidad = App\Unidade::find($midata->unidad_id);
                    @endphp
                    <h2>Comprando: {{$unidad->title}} de {{$midata->name}}</h2>
                    {{-- <h2>Comprando Insumo: {{$midata->name}} </h2> --}}
                     <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                {{-- <button type="button" class="btn btn-danger" data-toggle="modal" onclick="get_total()" data-target="#cerrar_caja">Cerrar</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#venta_caja" onclick="venta_caja()">Ventas</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_cliente">Cliente</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_asientos" onclick="cargar_asientos()">Asientos</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_save_venta" onclick="get_cambio()">Vender</button> --}}
                                <button type="button" class="btn btn-primary"  onclick="savecompra()">Comprar</button>

                            </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="info_caja"></div>
                    </div>
                {{-- </div> --}}
            @stop
        @break
        @case('productos')
            @section('page_header')
                <br>
                {{-- <div class="row"> --}}
                    {{-- <div class="col-sm-2">
                        <h1 class="page-title">
                    <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

                    </div>                --}}
                    @php
                    if(setting('empresa.type_negocio')=="Farmacia"){
                        $midata = App\Producto::find($dataTypeContent->getKey());

                        if($midata->presentacion_id!=null){
                            $presentacion = App\Presentacione::find($midata->presentacion_id);

                            if($midata->laboratorio_id!=null){
                                $laboratorio = App\Laboratorio::find($midata->laboratorio_id);
                                print"<h2>Comprando: $presentacion->name de $midata->name del Laboratorio: $laboratorio->name</h2>";
                            }
                            else{
                                print"<h2>Comprando: $presentacion->name de $midata->name</h2>";
                            }
                        }
                        else{
                            print"<h2>Comprando: $midata->name</h2>";
                        }
                    }
                    if(setting('empresa.type_negocio')=="Ferreteria"){
                        $midata = App\Producto::find($dataTypeContent->getKey());
                        $marca = App\Marca::find($midata->marca_id);

                        if($midata->marca_id!=null){
                            if($midata->presentacion_id!=null){
                                $presentacion = App\Presentacione::find($midata->presentacion_id);
                                print"<h2>Comprando: $presentacion->name de $midata->name marca $marca->name</h2>";

                            }
                            else{
                                print"<h2>Comprando: $midata->name marca $marca->name</h2>";

                            }
                        }
                        else{
                            print"<h2>Comprando: $midata->name</h2>";

                        }

                    }

                    @endphp
                    {{-- <h2>Comprando: {{$unidad->name}} de {{$midata->name}}</h2> --}}
                    {{-- <h2>Comprando: {{$midata->name}}</h2> --}}

                    {{-- <h2>Comprando Insumo: {{$midata->name}} </h2> --}}
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                {{-- <button type="button" class="btn btn-danger" data-toggle="modal" onclick="get_total()" data-target="#cerrar_caja">Cerrar</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#venta_caja" onclick="venta_caja()">Ventas</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_cliente">Cliente</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_asientos" onclick="cargar_asientos()">Asientos</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_save_venta" onclick="get_cambio()">Vender</button> --}}
                                <button type="button" class="btn btn-primary"  onclick="savecompra()">Comprar</button>

                            </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="info_caja"></div>
                    </div>
                {{-- </div> --}}
            @stop
        @break
        @default
            @section('page_header')


                <h1 class="page-title">
                    <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

                    @can('edit', $dataTypeContent)
                        <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                            <i class="glyphicon glyphicon-pencil"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
                        </a>
                    @endcan
                    {{-- @can('delete', $dataTypeContent)
                        @if($isSoftDeleted)
                            <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                            </a>
                        @else
                            <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                            </a>
                        @endif
                    @endcan --}}
                    @can('browse', $dataTypeContent)
                    <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
                        <i class="glyphicon glyphicon-list"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
                    </a>
                    @endcan
                </h1>
                @include('voyager::multilingual.language-selector')

            @stop
    @endswitch



@section('content')

@switch($dataType->getTranslatedAttribute('slug'))
    @case('detalle-cajas')

    @php
        $midata = App\DetalleCaja::find($dataTypeContent->getKey());
    @endphp

        <div class="page-content read container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <div class="form-group">
                            <code>
                                {{ $midata }}
                            </code>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @break
    @case('insumos')

        @php
            $midata = App\Insumo::find($dataTypeContent->getKey());
        @endphp

        {{-- <div class="form-group col-md-12"> --}}
            <div class="form-control" id="search-input">

                <div class="input-group col-md-4">
                    <select class="form-control js-example-basic-single" id="proveedores_compras"> </select>
                </div>
                {{-- <div class="input-group col-md-4">
                    <select class="form-control js-example-basic-single" id="unidades_compras"> </select>
                </div>
                <div class="input-group col-md-4">
                    <select class="form-control js-example-basic-single" id="insumos_compras"> </select>
                </div>    --}}


            </div>
        {{-- </div> --}}


            <div>
                <table class="table table-responsive">

                    <tbody>
                        <tr>
                            {{-- <td>
                                Proveedor
                                <input type="number" class="form-control" id="proveedor_compras">
                            </td> --}}
                            {{-- <td>
                                Unidad
                                <input type="number" class="form-control" id="unidad_compras">
                            </td> --}}
                            @php
                                $midata = App\Insumo::find($dataTypeContent->getKey());
                            @endphp
                            <td>
                                <input type="hidden" class="form-control" id="unidad_id" value="{{$midata->unidad_id}}">

                            </td>
                            <td>
                                <input type="hidden" class="form-control" id="editor_id" >

                            </td>
                            <td>
                                <input type="hidden" class="form-control" id="insumo_compras" value="{{$dataTypeContent->getKey()}}" >
                            </td>

                        </tr>

                        <tr>
                            <td>
                                Cantidad
                                <input type="number" value="1" min="0" class="form-control" id="cantidad_compras">
                            </td>
                            <td>
                                Costo Unitario
                                <input type="number" value="{{$midata->costo}}"  min="0" class="form-control" id="costo_compras">
                            </td>
                            <td>
                                Total
                                <input type="number" class="form-control" id="total_compras" readonly>

                            </td>
                            <td>
                                Descripción
                                {{-- <input type="text-area" class="form-control" id="description_compras"> --}}
                                <textarea class="form-control" name="" id="descripcion_compras"></textarea>
                            </td>

                        </tr>
                    </tbody>

                </table>
            </div>



    @break

    @case('productos')

        @php
            $midata = App\Producto::find($dataTypeContent->getKey());
        @endphp

        <div class="page-content read  container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="">Título</label>
                                            <input type="text"  class="form-control" id="title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Cantidad</label>
                                            <input type="number" value="1" min="0" class="form-control" id="cantidad_compras">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Precio Compra</label>
                                            <input type="number" value="{{$midata->precio_compra}}"  min="0" class="form-control" id="costo_compras">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Total</label>
                                            <input type="number" class="form-control" id="total_compras" readonly>
                                        </div>


                                        <input type="hidden" class="form-control" id="producto_compras" >
                                        <input type="hidden" class="form-control" id="fecha_vec_original">
                                        <input type="hidden" class="form-control" id="stock_original" >



                                        <input type="hidden" class="form-control" id="categoria_id" >
                                        <input type="hidden" class="form-control" id="editor_id" >
                                        <input type="hidden" class="form-control" id="name_producto"  >
                                        <input type="hidden" class="form-control" id="descripcion_compras_producto"  >
                                        <input type="hidden" class="form-control" id="image"  >
                                        <input type="hidden" class="form-control" id="production"  >
                                        <input type="hidden" class="form-control" id="description_long"  >
                                        <input type="hidden" class="form-control" id="images"  >
                                        <input type="hidden" class="form-control" id="mixta"  >
                                        <input type="hidden" class="form-control" id="type_producto_id"  >
                                        <input type="hidden" class="form-control" id="extra"  >
                                        <input type="hidden" class="form-control" id="extras"  >
                                        <input type="hidden" class="form-control" id="ecommerce"  >
                                        <input type="hidden" class="form-control" id="presentacion_id"  >
                                        <input type="hidden" class="form-control" id="laboratorio_id"  >
                                        <input type="hidden" class="form-control" id="marca_id" >
                                        <input type="hidden" class="form-control" id="title_generico"  >
                                        <input type="hidden" class="form-control" id="lote"  >
                                        <input type="hidden" class="form-control" id="registro_sanitario"  >
                                        <input type="hidden" class="form-control" id="origen"  >
                                        <input type="hidden" class="form-control" id="sku"  >
                                        <input type="hidden" class="form-control" id="etiqueta"  >
                                        <input type="hidden" class="form-control" id="sucursal_id"  >





                                        {{-- @if (setting('empresa.type_negocio')=="Farmacia")
                                        @endif --}}
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Proveedor</label>
                                            <select class="form-control js-example-basic-single" id="proveedores_compras"> </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Precio Venta</label>
                                            <input type="number" value="{{$midata->precio}}"  min="0" class="form-control" id="costo_compras_venta">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Fecha Vencimiento</label>
                                            <input type="date" value="null" class="form-control" id="fecha_vencimiento_compras">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Descripción de la Compra</label>
                                            <textarea class="form-control" name="" id="descripcion_compras"></textarea>
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="">Descripción del Producto</label>
                                            <textarea class="form-control" name="" id="descripcion_compras_producto"></textarea>
                                        </div> --}}

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @break


    @default

        <div class="page-content read container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <!-- form start -->
                        @foreach($dataType->readRows as $row)
                            @php
                            if ($dataTypeContent->{$row->field.'_read'}) {
                                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_read'};
                            }
                            @endphp
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">{{ $row->getTranslatedAttribute('display_name') }}</h3>
                            </div>

                            <div class="panel-body" style="padding-top:0;">
                                @if (isset($row->details->view))
                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => 'read', 'view' => 'read', 'options' => $row->details])
                                @elseif($row->type == "image")
                                    <img class="img-responsive"
                                        src="{{ filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL) ? $dataTypeContent->{$row->field} : Voyager::image($dataTypeContent->{$row->field}) }}">
                                @elseif($row->type == 'multiple_images')
                                    @if(json_decode($dataTypeContent->{$row->field}))
                                        @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
                                            <img class="img-responsive"
                                                src="{{ filter_var($file, FILTER_VALIDATE_URL) ? $file : Voyager::image($file) }}">
                                        @endforeach
                                    @else
                                        <img class="img-responsive"
                                            src="{{ filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL) ? $dataTypeContent->{$row->field} : Voyager::image($dataTypeContent->{$row->field}) }}">
                                    @endif
                                @elseif($row->type == 'relationship')
                                    @include('voyager::formfields.relationship', ['view' => 'read', 'options' => $row->details])
                                @elseif($row->type == 'select_dropdown' && property_exists($row->details, 'options') &&
                                        !empty($row->details->options->{$dataTypeContent->{$row->field}})
                                )
                                    <?php echo $row->details->options->{$dataTypeContent->{$row->field}};?>
                                @elseif($row->type == 'select_multiple')
                                    @if(property_exists($row->details, 'relationship'))

                                        @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                                            {{ $item->{$row->field}  }}
                                        @endforeach

                                    @elseif(property_exists($row->details, 'options'))
                                        @if (!empty(json_decode($dataTypeContent->{$row->field})))
                                            @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                                                @if (@$row->details->options->{$item})
                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ __('voyager::generic.none') }}
                                        @endif
                                    @endif
                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                    @if ( property_exists($row->details, 'format') && !is_null($dataTypeContent->{$row->field}) )
                                        {{ \Carbon\Carbon::parse($dataTypeContent->{$row->field})->formatLocalized($row->details->format) }}
                                    @else
                                        {{ $dataTypeContent->{$row->field} }}
                                    @endif
                                @elseif($row->type == 'checkbox')
                                    @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                        @if($dataTypeContent->{$row->field})
                                        <span class="label label-info">{{ $row->details->on }}</span>
                                        @else
                                        <span class="label label-primary">{{ $row->details->off }}</span>
                                        @endif
                                    @else
                                    {{ $dataTypeContent->{$row->field} }}
                                    @endif
                                @elseif($row->type == 'color')
                                    <span class="badge badge-lg" style="background-color: {{ $dataTypeContent->{$row->field} }}">{{ $dataTypeContent->{$row->field} }}</span>
                                @elseif($row->type == 'coordinates')
                                    @include('voyager::partials.coordinates')
                                @elseif($row->type == 'rich_text_box')
                                    @include('voyager::multilingual.input-hidden-bread-read')
                                    {!! $dataTypeContent->{$row->field} !!}
                                @elseif($row->type == 'file')
                                    @if(json_decode($dataTypeContent->{$row->field}))
                                        @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}">
                                                {{ $file->original_name ?: '' }}
                                            </a>
                                            <br/>
                                        @endforeach
                                    @else
                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($row->field) ?: '' }}">
                                            {{ __('voyager::generic.download') }}
                                        </a>
                                    @endif
                                @else
                                    @include('voyager::multilingual.input-hidden-bread-read')
                                    <p>{{ $dataTypeContent->{$row->field} }}</p>
                                @endif
                            </div><!-- panel-body -->
                            @if(!$loop->last)
                                <hr style="margin:0;">
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @endswitch
    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop




<!-- -------------------CARGADO DE JS----------------------- -->
<!-- -------------------CARGADO DE JS----------------------- -->

@switch($dataType->getTranslatedAttribute('slug'))

    @case('insumos')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                $('document').ready(function () {
                    $('.js-example-basic-single').select2();
                    UpdateCosto();
                    Proveedores_Compras();
                    // Unidades_Compras();




                });

                async function UpdateCosto(){

                    var total=parseFloat($('#cantidad_compras').val()).toFixed(2)*parseFloat($('#costo_compras').val()).toFixed(2);
                    $('#total_compras').val(total);

                }

                $('#cantidad_compras').on('change', function() {
                    UpdateCosto(this.value);
                });

                $('#costo_compras').on('change', function() {
                    UpdateCosto(this.value);
                });

                async function Proveedores_Compras(){

                    var tabla= await axios("{{setting('admin.url')}}api/pos/proveedores");

                    $('#proveedores_compras').append($('<option>', {
                        value: 0,
                        text: 'Elige un Proveedor'
                    }));
                    for (let index = 0; index < tabla.data.length; index++) {
                        const element = tabla.data[index];
                        $('#proveedores_compras').append($('<option>', {
                            value: tabla.data[index].id,
                            text: tabla.data[index].name
                        }));
                    }
                }

                // async function Unidades_Compras(){

                //     var tabla= await axios("{{setting('admin.url')}}api/pos/unidades");

                //     $('#unidades_compras').append($('<option>', {
                //         value: null,
                //         text: 'Elige una Unidad'
                //     }));
                //     for (let index = 0; index < tabla.data.length; index++) {
                //         const element = tabla.data[index];
                //         $('#unidades_compras').append($('<option>', {
                //             value: tabla.data[index].id,
                //             text: tabla.data[index].title
                //         }));
                //     }

                // }

                // async function InsumosPorUnidadesCompras(id){
                //     var tabla= await axios("{{setting('admin.url')}}api/pos/insumo/unidad/"+id);

                //     $('#insumos_compras').find('option').remove().end();
                //     $('#insumos_compras').append($('<option>', {
                //         value: null,
                //         text: 'Elige un Insumo'
                //     }));
                //     for (let index = 0; index < tabla.data.length; index++) {
                //         const element = tabla.data[index];
                //         $('#insumos_compras').append($('<option>', {
                //             value: tabla.data[index].id,
                //             text: tabla.data[index].name
                //         }));
                //     }

                // }

                // $('#proveedores_compras').on('change',function() {

                //     $('input[name="proveedor_id"]').val($('#proveedores_compras').val());

                // });


                // $('#unidades_compras').on('change', function() {
                //     InsumosPorUnidadesCompras(this.value);

                //     $('input[name="unidad_id"]').val($('#unidades_compras').val());
                // });

                // $('#insumos_compras').on('change',function() {

                //     $('input[name="insumo_id"]').val($('#insumos_compras').val());

                // });

                async function savecompra(){

                    var description=$('#descripcion_compras').val();
                    var editor_id=$('#editor_id').val();
                    var cantidad=$('#cantidad_compras').val();
                    var costo=$('#costo_compras').val();
                    var total= $('#total_compras').val();
                    var proveedor_id=$('#proveedores_compras').val();
                    var insumo_id=$('#insumo_compras').val();
                    var unidad_id=$('#unidad_id').val();

                    var midata = JSON.stringify({'description':description, 'editor_id':editor_id, 'cantidad':cantidad, 'costo':costo,'total':total, 'proveedor_id':proveedor_id, 'insumo_id':insumo_id, 'unidad_id':unidad_id});

                    var compra = await axios("{{setting('admin.url')}}api/pos/compras/save/"+midata);
                    if(compra){

                        $('#descripcion_compras').val("");
                        $('#editor_id').val("");
                        $('#cantidad_compras').val("");
                        $('#costo_compras').val("");
                        $('#total_compras').val("");
                        $('#proveedores_compras').val("");
                        $('#insumo_compras').val("");
                        $('#unidad_id').val("");
                         //$ins= App\Insumo::find(insumo_id);
                        window.location.href = "{{setting('admin.url')}}admin/insumos";
                        toastr.success('Se Registró la Compra');

                    }

                }



            </script>

        @stop
    @break

    @case('productos')
        @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            $('document').ready(async function () {
                $('.js-example-basic-single').select2();
                $('#editor_id').val('{{ Auth::user()->id }}');
                UpdateCosto();
                Proveedores_Compras();
                // Unidades_Compras();
                LLenarInputs()




            });

            async function LLenarInputs() {
                var prod="{{$dataTypeContent->getKey()}}"

                var table = await axios("{{setting('admin.url')}}api/pos/producto/"+prod)

                $('#producto_compras').val(table.data.id)
                $('#fecha_vec_original').val(table.data.vencimiento)
                $('#stock_original').val(table.data.stock)

                $('#categoria_id').val(table.data.categoria_id)
                $('#editor_id').val('{{ Auth::user()->id }}')
                $('#name_producto').val(table.data.name)
                $('#descripcion_compras_producto').val(table.data.description)
                $('#image').val(table.data.image)
                $('#production').val(table.data.production)
                $('#description_long').val(table.data.description_long)
                $('#images').val(table.data.images)
                $('#mixta').val(table.data.mixta)
                $('#type_producto_id').val(table.data.type_producto_id)
                $('#extra').val(table.data.extra)
                $('#extras').val(table.data.extras)
                $('#ecommerce').val(table.data.ecommerce)
                $('#presentacion_id').val(table.data.presentacion_id)
                $('#laboratorio_id').val(table.data.laboratorio_id)
                $('#marca_id').val(table.data.marca_id)
                $('#title_generico').val(table.data.title)
                $('#lote').val(table.data.lote)
                $('#registro_sanitario').val(table.data.registro_sanitario)
                $('#origen').val(table.data.origen)
                $('#sku').val(table.data.sku)
                $('#etiqueta').val(table.data.etiqueta)
                $('#sucursal_id').val(table.data.sucursal_id)
            }

            async function UpdateCosto(){

                var total=parseFloat($('#cantidad_compras').val()).toFixed(2)*parseFloat($('#costo_compras').val()).toFixed(2);
                $('#total_compras').val(total);

            }

            $('#cantidad_compras').on('change', function() {
                UpdateCosto(this.value);
            });

            $('#costo_compras').on('change', function() {
                UpdateCosto(this.value);
            });

            async function Proveedores_Compras(){

                var tabla= await axios("{{setting('admin.url')}}api/pos/proveedores");

                $('#proveedores_compras').append($('<option>', {
                    value: 0,
                    text: 'Elige un Proveedor'
                }));
                for (let index = 0; index < tabla.data.length; index++) {
                    const element = tabla.data[index];
                    $('#proveedores_compras').append($('<option>', {
                        value: tabla.data[index].id,
                        text: tabla.data[index].name
                    }));
                }
            }


            async function savecompra(){


                var vencimiento=$('#fecha_vencimiento_compras').val();


                var description_producto=$('#descripcion_compras_producto').val();
                var description=$('#descripcion_compras').val();
                var editor_id=$('#editor_id').val();
                var cantidad=$('#cantidad_compras').val();
                var costo=$('#costo_compras').val();
                var total= $('#total_compras').val();
                var proveedor_id=$('#proveedores_compras').val();
                var producto_id=$('#producto_compras').val();
                var categoria_id=$('#categoria_id').val();


                var title=$('#title').val();
                var precio_venta=$('#costo_compras_venta').val();
                var name=$('#name_producto').val();
                var image=$('#image').val();
                var production=$('#production').val();
                var description_long=$('#description_long').val();
                var images=$('#images').val();
                var mixta=$('#mixta').val();
                var type_producto_id=$('#type_producto_id').val();
                var extra=$('#extra').val();
                var extras=$('#extras').val();
                var ecommerce=$('#ecommerce').val();
                var presentacion_id=$('#presentacion_id').val();
                var laboratorio_id=$('#laboratorio_id').val();
                var marca_id=$('#marca_id').val();
                var title_generico=$('#title_generico').val()
                var lote=$('#lote').val()
                var registro_sanitario=$('#registro_sanitario').val()
                var origen=$('#origen').val()
                var sku=$('#sku').val()
                var etiqueta=$('#etiqueta').val()
                var sucursal_id= $('#sucursal_id').val()


                var midata = JSON.stringify({'description':description, 'editor_id':editor_id, 'cantidad':cantidad, 'costo':costo,'total':total, 'proveedor_id':proveedor_id, 'producto_id':producto_id, 'categoria_id':categoria_id, 'description_producto':description_producto, 'vencimiento':vencimiento, 'precio_venta':precio_venta,'name':name, 'image':image,'production':production, 'description_long':description_long, 'images':images, 'mixta':mixta, 'type_producto_id':type_producto_id, 'extra':extra, 'extras':extras, 'ecommerce':ecommerce, 'presentacion_id':presentacion_id, 'laboratorio_id':laboratorio_id, 'marca_id':marca_id, 'title':title, 'title_generico':title_generico,'lote':lote, 'registro_sanitario':registro_sanitario,'origen':origen,'sku':sku,'etiqueta':etiqueta,'sucursal_id':sucursal_id });
                var miurl = "{{setting('admin.url')}}api/pos/addproducto/"+midata
                var producto= await axios(miurl);

                if(producto.data.length!=0){
                    toastr.success("Producto Creado exitosamente");
                }
                else{
                    toastr.error("Ha ocurrido un error con el guardado del producto");
                }


                var compra = await axios("{{setting('admin.url')}}api/pos/compras-productos/save/"+midata+"/"+producto.data.id);
                if(compra.data.length!=0){

                    $('#descripcion_compras').val("");
                    $('#editor_id').val("");
                    $('#cantidad_compras').val("");
                    $('#costo_compras').val("");
                    $('#total_compras').val("");
                    $('#proveedores_compras').val("");
                    $('#insumo_compras').val("");
                    $('#categoria_id').val("");
                    $('#descripcion_compras_producto').val("");
                    $('#fecha_vencimiento_compras').val("");
                    $('#costo_compras_venta').val("");

                    $('#name_producto').val("");
                    $('#image').val("");
                    $('#production').val("");
                    $('#description_long').val("");
                    $('#images').val("");
                    $('#mixta').val("");
                    $('#type_producto_id').val("");
                    $('#extra').val("");
                    $('#extras').val("");
                    $('#ecommerce').val("");
                    $('#presentacion_id').val("");
                    $('#laboratorio_id').val("");
                    $('#marca_id').val("");
                    $('#title_generico').val("");
                    $('#lote').val("");
                    $('#registro_sanitario').val("");
                    $('#origen').val("");
                    $('#sku').val("");
                    $('#etiqueta').val("");

                     //$ins= App\Insumo::find(insumo_id);
                    toastr.success('Se Registró la Compra');

                    var fecha_vec_original=$('#fecha_vec_original').val();


                    var stock_original=$('#stock_original').val();

                    if(fecha_vec_original!=null){
                        if(CalcularFecha(fecha_vec_original)<=0){
                            // console.log("Entró a fecha");
                            // console.log(CalcularFecha(fecha_vec_original));

                            var actualizacion= await axios("{{setting('admin.url')}}api/pos/producto-update/"+producto_id);
                        }
                    }

                    if(stock_original==0){
                        // console.log("Entró a Stock");
                        var actualizacion= await axios("{{setting('admin.url')}}api/pos/producto-update/"+producto_id);
                    }
                    window.location.href = "{{setting('admin.url')}}admin/productos";



                }
                else{
                    toastr.error("Ha ocurrido un error con el guardado de la compra");
                }


            }

            function CalcularFecha(fecha_final){
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





        </script>

        @stop
    @break


    @default
        @section('javascript')
            @if ($isModelTranslatable)
                <script>
                    $(document).ready(function () {
                        $('.side-body').multilingual();
                    });
                </script>
            @endif
            <script>
                var deleteFormAction;
                $('.delete').on('click', function (e) {
                    var form = $('#delete_form')[0];

                    if (!deleteFormAction) {
                        // Save form action initial value
                        deleteFormAction = form.action;
                    }

                    form.action = deleteFormAction.match(/\/[0-9]+$/)
                        ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                        : deleteFormAction + '/' + $(this).data('id');

                    $('#delete_modal').modal('show');
                });

            </script>
        @stop

@endswitch
