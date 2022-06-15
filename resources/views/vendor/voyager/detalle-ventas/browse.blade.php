@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
@php
    $venta =  App\Venta::find($_GET['s']);
    $cliente = App\Cliente::find($venta->cliente_id);
    $caja = App\Caja::find($venta->caja_id);
    $sucursal = App\Sucursale::find($venta->sucursal_id);
    $delivery = App\Mensajero::find($venta->delivery_id);
    $chofer = TCG\Voyager\Models\User::find($venta->chofer_id);
    $editor = TCG\Voyager\Models\User::find($venta->register_id);
    $estado = App\Estado::find($venta->status_id);
    $option = App\Option::find($venta->option_id);
    $pago = App\Pago::find($venta->pago_id);
    $cupon = App\Cupone::find($venta->cupon_id);
    $location = App\Location::find($venta->location);
    $banipay = App\Banipay::where('venta_id', $venta->id)->first();

    $choferes = TCG\Voyager\Models\User::where('role_id', 8)->get();

@endphp
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if(!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
        <a onclick="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_asignar_chofer"><i class="voyager-helm"></i><span class="hidden-xs hidden-sm">Asignar Chofer</span></a>
        @if ($venta->factura == "Recibo") 
            <a onclick="CargarClienteVenta()" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_recibo_a_factura" ><i class="voyager-helm"></i><span class="hidden-xs hidden-sm">Convertir a Factura</span></a>
        @endif
        <a onclick="imprimir()" class="btn btn-sm btn-dark"><i class="voyager-helm"></i><span class="hidden-xs hidden-sm">Imprimir en PDF</span></a>
   
        <a href="{{ url('admin/ventas') }}" class="btn btn-default btn-add-new" title="">
            <i class="voyager-helm"></i> <span>Volver a Ventas</span>
        </a>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="col-sm-4">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="dt-not-orderable">Key</th><th>Valor</th>
                                    <tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ID</td><th>{{ $venta->id;  }}</th>
                                    </tr>
                                    <tr>
                                        <td>Ticket #</td><th>{{ $venta->ticket;  }}</th>
                                    </tr>
                                    <tr>
                                        <td>Total</td><th>{{ $venta->total }} Bs.</th>
                                    </tr>
                                    <tr>
                                        <td>Recibo/Factura</td><th>{{ $venta->factura;  }}</th>
                                    </tr>
                                    <tr>
                                        <td>Estado</td><th>{{ $estado->title;  }}</th>
                                    </tr>
                                    <tr>
                                        <td>Tipo</td><th>{{ $option->title;  }}</th>
                                    </tr>
                                    <tr>
                                        <td>Fecha</td><th>{{ $venta->created_at }}</th>
                                    </tr>
                                    <tr>
                                        <td>Cliente</td><th>{{ $cliente->first_name.'  '.$cliente->last_name }}</th>
                                    </tr>
                                    <tr>
                                        <td>Direccion</td><th>{{ $location->descripcion }}</th>
                                    </tr>
                                    <tr>
                                        <td>Cupon</td><th>{{ $cupon->title }}</th>
                                    </tr>
                                    <tr>
                                        <td>Pasarela</td><th>
                                            {{ $pago->title;  }} <br>
                                            @if ($banipay)
                                                <a href="{{ setting('banipay.url_base').$banipay->urlTransaction }}" target="_blank" >Link de Pago - BaniPay</a>
                                            @endif

                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Caja</td><th>{{ $caja->title }}</th>
                                    </tr>
                                    <tr>
                                        <td>Sucursal</td><th>{{ $sucursal->name }}</th>
                                    <tr>
                                    <tr>
                                        <td>Delivery</td><th>{{ $delivery->name }}</th>
                                    <tr>
                                    <tr>
                                        <td>Chofer Asignado</td><th>{{ $chofer->name }}</th>
                                    <tr>
                                    <tr>
                                        <td>Control</td><th>{{ $venta->caja_status }}</th>
                                    <tr>
                                    <tr>
                                        <td>Cantidad</td><th>{{ $venta->cantidad }}</th>
                                    <tr>
                                    <tr>
                                        <td>Recibido</td><th>{{ $venta->recibido }}</th>
                                    <tr>
                                    <tr>
                                        <td>Cambio</td><th>{{ $venta->cambio }}</th>
                                    <tr>
                                    <tr>
                                        <td>Descuento</td><th>{{ $venta->descuento }}</th>
                                    <tr>
                                    <tr>
                                        <td>Editor</td><th>{{ $editor->name }}</th>
                                    <tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-8">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            @if($showCheckboxColumn)
                                                <th class="dt-not-orderable">
                                                    <input type="checkbox" class="select_all">
                                                </th>
                                            @endif
                                            @foreach($dataType->browseRows as $row)
                                                <th>
                                                    @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                        <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                    @endif
                                                    {{ $row->getTranslatedAttribute('display_name') }}
                                                    @if ($isServerSide)
                                                        @if ($row->isCurrentSortField($orderBy))
                                                            @if ($sortOrder == 'asc')
                                                                <i class="voyager-angle-up pull-right"></i>
                                                            @else
                                                                <i class="voyager-angle-down pull-right"></i>
                                                            @endif
                                                        @endif
                                                        </a>
                                                    @endif
                                                </th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataTypeContent as $data)
                                            <tr>

                                                @if($showCheckboxColumn)
                                                    <td>
                                                        <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                    </td>
                                                @endif
                                                @foreach($dataType->browseRows as $row)


                                                    @php
                                                    if ($data->{$row->field.'_browse'}) {
                                                        $data->{$row->field} = $data->{$row->field.'_browse'};
                                                    }
                                                    @endphp

                                                    <td>
                                                        @if (isset($row->details->view))
                                                            @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                        @elseif($row->type == 'image')
                                                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                        @elseif($row->type == 'relationship')
                                                            @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                        @elseif($row->type == 'select_multiple')
                                                            @if(property_exists($row->details, 'relationship'))

                                                                @foreach($data->{$row->field} as $item)
                                                                    {{ $item->{$row->field} }}
                                                                @endforeach

                                                            @elseif(property_exists($row->details, 'options'))
                                                                @if (!empty(json_decode($data->{$row->field})))
                                                                    @foreach(json_decode($data->{$row->field}) as $item)
                                                                        @if (@$row->details->options->{$item})
                                                                            {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    {{ __('voyager::generic.none') }}
                                                                @endif
                                                            @endif

                                                            @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                                @if (@count(json_decode($data->{$row->field})) > 0)
                                                                    @foreach(json_decode($data->{$row->field}) as $item)
                                                                        @if (@$row->details->options->{$item})
                                                                            {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    {{ __('voyager::generic.none') }}
                                                                @endif

                                                        @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                            {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                        @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                            @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                                {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                            @else
                                                                {{ $data->{$row->field} }}
                                                            @endif
                                                        @elseif($row->type == 'checkbox')
                                                            @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                @if($data->{$row->field})
                                                                    <span class="label label-info">{{ $row->details->on }}</span>
                                                                @else
                                                                    <span class="label label-primary">{{ $row->details->off }}</span>
                                                                @endif
                                                            @else
                                                            {{ $data->{$row->field} }}
                                                            @endif
                                                        @elseif($row->type == 'color')
                                                            <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                        @elseif($row->type == 'text')


                                                            @include('voyager::multilingual.input-hidden-bread-browse')
                                                            <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>


                                                        @elseif($row->type == 'text_area')
                                                            @include('voyager::multilingual.input-hidden-bread-browse')
                                                            <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                        @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                            @include('voyager::multilingual.input-hidden-bread-browse')
                                                            @if(json_decode($data->{$row->field}) !== null)
                                                                @foreach(json_decode($data->{$row->field}) as $file)
                                                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                        {{ $file->original_name ?: '' }}
                                                                    </a>
                                                                    <br/>
                                                                @endforeach
                                                            @else
                                                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                                    Download
                                                                </a>
                                                            @endif
                                                        @elseif($row->type == 'rich_text_box')
                                                            @include('voyager::multilingual.input-hidden-bread-browse')
                                                            <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                        @elseif($row->type == 'coordinates')
                                                            @include('voyager::partials.coordinates-static-image')
                                                        @elseif($row->type == 'multiple_images')
                                                            @php $images = json_decode($data->{$row->field}); @endphp
                                                            @if($images)
                                                                @php $images = array_slice($images, 0, 3); @endphp
                                                                @foreach($images as $image)
                                                                    <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                                @endforeach
                                                            @endif
                                                        @elseif($row->type == 'media_picker')
                                                            @php
                                                                if (is_array($data->{$row->field})) {
                                                                    $files = $data->{$row->field};
                                                                } else {
                                                                    $files = json_decode($data->{$row->field});
                                                                }
                                                            @endphp
                                                            @if ($files)
                                                                @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                    @foreach (array_slice($files, 0, 3) as $file)
                                                                    <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                                    @endforeach
                                                                @else
                                                                    <ul>
                                                                    @foreach (array_slice($files, 0, 3) as $file)
                                                                        <li>{{ $file }}</li>
                                                                    @endforeach
                                                                    </ul>
                                                                @endif
                                                                @if (count($files) > 3)
                                                                    {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                                @endif
                                                            @elseif (is_array($files) && count($files) == 0)
                                                                {{ trans_choice('voyager::media.files', 0) }}
                                                            @elseif ($data->{$row->field} != '')
                                                                @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                    <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                                @else
                                                                    {{ $data->{$row->field} }}

                                                                @endif
                                                            @else
                                                                {{ trans_choice('voyager::media.files', 0) }}
                                                            @endif
                                                        @else

                                                            @include('voyager::multilingual.input-hidden-bread-browse')
                                                            <span>{{ $data->{$row->field} }}</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label for="">Mueve el marcador para mejorar tu ubicacion</label>
                                    <div id="map"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal modal-primary fade" tabindex="-1" id="modal_recibo_a_factura" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <center><h4>Convertir Recibo a Factura</h4></center>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#principal" aria-controls="principal" role="tab" data-toggle="tab">Datos Actuales</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Buscar</a></li>
                        <li role="presentation"><a href="#create" aria-controls="create" role="tab" data-toggle="tab">Crear</a></li>

                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="principal">
                            <input type="hidden" class="form-control" id="id_venta_conversion" >
                            <input type="hidden" class="form-control" id="cliente_id_conversion" >
                            <div class="col-sm-6">
                                <label for="first_name_conversion">Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombres" id="first_name_conversion"  >
                            </div>
                            <div class="col-sm-6">
                                <label for="last_name_conversion">Apellido</label>
                                <input type="text" class="form-control" placeholder="Apellidos" id="last_name_conversion"  >
                            </div>
                            <div class="col-sm-6">
                                <label for="ci_nit_conversion">NIT o CI</label>
                                <input type="text" class="form-control" placeholder="NIT o CI" id="ci_nit_conversion"  >
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-dark" id="" onclick="ActualizarCliente()">Actualizar Cliente</button>
                            </div><br>

                            <div class="col-sm-7">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                            </div>
                            <div class="col-sm-5">
                                <button type="button" class="btn btn-primary" id="" onclick="modal_conversion()">Convertir a Factura</button>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="form-group col-sm-6">
                                <label for="">Buscar Cliente por Nombre</label>
                                <input type="text" class="form-control" placeholder="Criterio de Busquedas.." id="cliente_busqueda">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Buscar Cliente por CI</label>
                                <input type="text" class="form-control" placeholder="Criterio de Busquedas.." id="cliente_busqueda_ci">
                            </div>
                            <br>
                            <table class="table" id="cliente_list">
                                <thead>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>CI - NIT</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="create">
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
                            <div class="col-sm-6">
                                <label for="">Display</label>
                                <input class="form-control" type="text" placeholder="Display" id="display" hidden>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Correo</label>
                                <input class="form-control" type="text" placeholder="Email" id="email" hidden>
                            </div>
                            <div class="form-group col-sm-6">
                            </div>
                            <div class="form-group col-sm-3">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                            </div>
                            <div class="form-group col-sm-3">
                                <button type="button" class="btn btn-sm btn-primary" onclick="savecliente()" >Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_asignar_chofer" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <center><h4>Asignar Chofer</h4></center>
                </div>
                <div class="modal-body">
                    <label for="">Elije un Chofer</label>
                    <select class="form-control" name="" id="chofer_id">
                        @foreach ($choferes as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <small>luego de cambiar el chofer, se asignara el mismo</small>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
<style>
    #map {
        width: 100%;
        height: 350px;
        /* box-shadow: 5px 5px 5px #888; */
    }
</style>
@stop

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>

    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [
                            ['targets' => 'dt-not-orderable', 'searchable' =>  false, 'orderable' => false],
                        ],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });

            getlocation()
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 1]), true)) }}"></a>');
                    }else{
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 0]), true)) }}"></a>');
                    }

                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });

        function getlocation() {
            var lat = '{{ $location->latitud }}'
            var lng =  '{{ $location->longitud }}'
            var map = L.map('map').setView([lat, lng], 14);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 22
            }).addTo(map);
            var mimarker = L.marker([lat, lng], { title: "My marker", draggable: true }).addTo(map);
            mimarker.bindPopup("Ubicacion solicitada").openPopup();
        }

        function imprimir() {
            location.href = "{{ route('venta.imprimir', $_GET['s']) }}"
        }

        async function CargarClienteVenta(){
            console.log('HOLA')
            console.log({{ $venta->cliente_id }})
            micliente()
            
            var table= await axios("{{setting('admin.url')}}api/pos/cliente/{{ $venta->cliente_id }}")
            if(table.data.default){
                $("#first_name_conversion").attr("readonly", true)
                $("#last_name_conversion").attr("readonly", true)
                $("#ci_nit_conversion").attr("readonly", true)
                toastr.error("Seleccione un cliente o vaya a crearlo")
            }
            else{

            }
            $('#first_name_conversion').val(table.data.first_name)
            $('#last_name_conversion').val(table.data.last_name)
            $('#ci_nit_conversion').val(table.data.ci_nit)
            $('#id_venta_conversion').val("{{ $venta->id }}")
            $('#cliente_id_conversion').val("{{ $venta->cliente_id }}")
        }
        async function micliente() {
            var miphone = Math.floor(Math.random() * 1000000000);
            $('#phone').val(miphone)
        }

        $("#chofer_id").on('change', async function(){
            await axios("{{ setting('admin.url') }}api/pos/chofer/set/{{ $venta->id }}/"+this.value);
            toastr.success('Chofer Asignado');
            // $("#modal_asignar_chofer").modal('hide')
            location.reload()
        })
    </script>
@stop
