@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
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
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-4">
                                        <select id="search_key" name="key" style="width: 200px" class="">
                                            <option value="id"> ID </option>
                                                <option value="name"> N. COMERCIAL </option>
                                                <option value="title"> N. GENERICO </option>
                                                <option value="etiqueta"> ETIQUETAS </option>
                                                <option value="filtros"> FILTROS </option>
                                                <option value="capital_productos">CAPITAL EN PRODUCTOS</option>
                                                <option value="vencimiento_productos">VENCIMIENTO PRODUCTOS</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                                {{-- <option value="equals"> = </option> --}}
                                                <option value="contains">LIKE</option>

                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input type="search" class="form-control" id="s" name="s" onchange="this.form.submit()" value="{{ $search->value }}">
                                    </div>
                                </div>
                            </form>
                        @endif
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
                                        <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
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
                                        <td class="no-sort no-click bread-actions">
                                            @foreach($actions as $action)
                                                @if (!method_exists($action, 'massAction'))
                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                    's' => $search->value,
                                    'filter' => $search->filter,
                                    'key' => $search->key,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder,
                                    'showSoftDeleted' => $showSoftDeleted,
                                ])->links() }}
                            </div>
                        @endif
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

    <div class="modal modal-primary fade" tabindex="-1" id="modal_capital" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4>Capital en Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <strong>Sucursal</strong>
                            <br>
                            <select class="form-control" name="misucursal" id="misucursal"></select>
                        </div>
                        <div class="col-sm-12 text-center">
                            <table class="table" id="table-capital-productos">
                                <thead>
                                    <tr>
                                        <th>Cantidad Productos</th>
                                        <th>Total Stock * Cantidad Productos</th>
                                        {{-- <th>Promedio de Ganancia por Producto</th> --}}
                                        <th><b>Capital en Productos Compras</b></th>
                                        <th><b>Capital en Productos Ventas</b></th>

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_vencimiento_productos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4>Vencimiento de Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicial_vencimiento">
                        </div>
                        <div class="col-sm-6">
                            <label for="">Fecha Final</label>
                            <input type="date" class="form-control" id="fecha_final_vencimiento">
                        </div>
                        <div class="form-group col-md-6">
                            <strong>Sucursal</strong>
                            <select class="form-control" name="misucursal_vencimiento" id="misucursal_vencimiento"></select>
                        </div>
                        <div class="col-sm-12">
                            <table class="table" id="table-vencimiento_productos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Vencimiento</th>
                                        <th>Días Restantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_filtros" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4>Filtros</h4>
                </div>
                <div class="modal-body">
                    {{-- <div class="row">

                    </div> --}}
                    @php
                        $categorias = App\Categoria::all();
                        $laboratorios = App\Laboratorio::all();
                    @endphp
                    <div class="form-group">
                        <label for="">Categorias</label>
                        <select class="form-control" name="" id="categoria_id">
                            <option value="">Elije un Opcion</option>
                            @foreach ($categorias as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Laboratorio</label>
                        <select class="form-control" name="" id="laboratorio_id">
                            <option value="">Elije un Opcion</option>
                            @foreach ($laboratorios as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <div id="text_filtros"></div>
                        <table class="table" id="filtros_productos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>P. Venta</th>
                                    <th>P. Compra</th>
                                    <th>Vencimiento</th>
                                    <th>Categoria</th>
                                    <th>Laboratorio</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

        $('#search_key').on('change', function() {
            switch (this.value) {
                case('capital_productos'):
                    Sucursales()
                    $('#table-capital-productos tbody tr').remove();
                    $('#modal_capital').modal();
                    break;
                case('vencimiento_productos'):
                    SucursalesVencimiento()
                    $('#modal_vencimiento_productos').modal();
                    break;
                case('filtros'):
                    $('#modal_filtros').modal();
                    break;
                default:
                break
            }
        });

        async function Sucursales() {
            var table= await axios.get("{{setting('admin.url')}}api/pos/sucursales")

            $('#misucursal').append($('<option>', {
                value: null,
                text: 'Elija una Sucursal'
            }));
            for (let index = 0; index < table.data.length; index++) {
                // if(table.data[index].id!=producto.data.categoria_id){
                    $('#misucursal').append($('<option>', {
                        value: table.data[index].id,
                        text: table.data[index].name
                    }));
                // }
            }
        }

        $('#misucursal').on('change', function() {
            var sucursal = $('#misucursal').val();
            CalcularCapitalDefault(sucursal)
        });

        async function SucursalesVencimiento() {
            var table= await axios.get("{{setting('admin.url')}}api/pos/sucursales")
            $('#misucursal_vencimiento').append($('<option>', {
                value: null,
                text: 'Elija una Sucursal'
            }));
            for (let index = 0; index < table.data.length; index++) {
                    $('#misucursal_vencimiento').append($('<option>', {
                        value: table.data[index].id,
                        text: table.data[index].name
                    }));
            }
        }

        $('#misucursal_vencimiento').on('change', async function() {
            var sucursal = $('#misucursal_vencimiento').val();
            Consulta_Vencimiento_Productos(sucursal)
        });

        async function Consulta_Vencimiento_Productos(sucursal) {
            var table= await axios.get("{{setting('admin.url')}}api/pos/productos_sucursal/"+sucursal)
            $('#table-vencimiento_productos tbody tr').remove();
            var fecha_inicial=$('#fecha_inicial_vencimiento').val() ? $('#fecha_inicial_vencimiento').val():null;
            var fecha_final=$('#fecha_final_vencimiento').val() ? $('#fecha_final_vencimiento').val():null;
            for(let index=0;index<table.data.length;index++){
                if(fecha_inicial==null){
                    var calculo_dias_restantes=CalculoDiasRestantes(fecha_final);

                    var vencimiento_actual= table.data[index].vencimiento ? CalculoDiasRestantes(table.data[index].vencimiento):null;

                    if(vencimiento_actual<0){
                        var dias= "Venció hace "+(vencimiento_actual*-1)+" días";
                    }
                    if(vencimiento_actual==0){
                        var dias="Vence hoy";
                    }
                    if(vencimiento_actual>0){
                        var dias="Vence en "+vencimiento_actual+" días";
                    }
                    if((vencimiento_actual<=calculo_dias_restantes) && (table.data[index].vencimiento!=null)){
                        $('#table-vencimiento_productos').append("<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].name+"</td><td>"+table.data[index].vencimiento+"</td><td>"+dias+"</td></tr>");
                    }
                }
                else{
                    var calculo_dias_restantes=CalculoDiasRestantes(fecha_final);
                    var calculo_dias_inicio=CalculoDiasRestantes(fecha_inicial);

                    var vencimiento_actual= table.data[index].vencimiento ? CalculoDiasRestantes(table.data[index].vencimiento):null;

                    if(vencimiento_actual<0){
                        var dias= "Venció hace "+(vencimiento_actual*-1)+" días";
                    }
                    if(vencimiento_actual==0){
                        var dias="Vence hoy";
                    }
                    if(vencimiento_actual>0){
                        var dias="Vence en "+vencimiento_actual+" días";
                    }
                    if((vencimiento_actual>=calculo_dias_inicio)&&(vencimiento_actual<=calculo_dias_restantes) && (table.data[index].vencimiento!=null)){
                        $('#table-vencimiento_productos').append("<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].name+"</td><td>"+table.data[index].vencimiento+"</td><td>"+dias+"</td></tr>");
                    }
                }
            }
        }

        function CalculoDiasRestantes(fecha_final){
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

        async function CalcularCapitalDefault(sucursal) {
            $('#table-capital-productos tbody tr').remove();
            var table= await axios.get("{{setting('admin.url')}}api/pos/productos_sucursal/"+sucursal)
            var num_productos=table.data.length;
            var num_total_stock_productos=0;
            var promedio_prod=0;
            var capital=0;
            var capital_venta=0;
            for(let index=0;index<table.data.length;index++){
                if(table.data[index].stock!=null){
                    // promedio_prod+=(table.data[index].precio-table.data[index].precio_compra);
                    capital+=(table.data[index].precio_compra*table.data[index].stock);
                    capital_venta+=(table.data[index].precio*table.data[index].stock);
                    num_total_stock_productos+=table.data[index].stock;
                    // if (table.data[index].precio_compra>100) {
                    //     console.log("ID"+table.data[index].id)
                    //     console.log("Precio"+table.data[index].precio_compra)
                    // }
                    
                    // console.log(table.data[index].precio_compra)
                    // console.log(table.data[index].stock)
                    // console.log(capital)
                }
            }
            // promedio_prod=promedio_prod/num_productos;
            $('#table-capital-productos').append("<tr><td><h5>"+num_productos+"</h5></td><td><h5>"+num_total_stock_productos+"</h5></td><td><h4>"+capital.toFixed(2)+"</h4></td><td><h4>"+capital_venta.toFixed(2)+"</h4></td></tr>");
        }

        $('#categoria_id').on('change', async function() {
            var table = await axios("{{setting('admin.url')}}api/filtros/"+this.value)
            $('#filtros_productos tbody tr').remove();
            total = 0
            for(let index=0; index<table.data.length; index++){
                var categoria = table.data[index].categoria ? table.data[index].categoria.name : 'Sin categoria'
                var laboratorio = table.data[index].laboratorio ? table.data[index].laboratorio.name : 'Sin laboratorio'
                total +=table.data[index].stock * table.data[index].precio
                var miedit = "{{ route('voyager.productos.edit', 'miid') }}"
                miedit = miedit.replace('miid', table.data[index].id)
                $('#filtros_productos').append("<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].name+"</td><td>"+table.data[index].stock+"</td><td>"+table.data[index].precio+"</td><td>"+table.data[index].precio_compra+"</td><td>"+table.data[index].vencimiento+"</td><td>"+categoria+"</td><td>"+laboratorio+"</td><td><a href='"+miedit+"' class='btn btn-warning'>Editar</td></tr>")
            }
            $("#text_filtros").html("<h6> Cantidad (stock): "+table.data.length+" - Total(stock*p.venta): "+total+"</h6>")
        });

        $('#laboratorio_id').on('change', async function() {
            var table = await axios("{{setting('admin.url')}}api/filtros2/"+this.value)
            $('#filtros_productos tbody tr').remove();
            total = 0
            for(let index=0; index<table.data.length; index++){
                var categoria = table.data[index].categoria ? table.data[index].categoria.name : 'Sin categoria'
                var laboratorio = table.data[index].laboratorio ? table.data[index].laboratorio.name : 'Sin laboratorio'
                total +=table.data[index].stock * table.data[index].precio
                var miedit = "{{ route('voyager.productos.edit', 'miid') }}"
                miedit = miedit.replace('miid', table.data[index].id)
                $('#filtros_productos').append("<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].name+"</td><td>"+table.data[index].stock+"</td><td>"+table.data[index].precio+"</td><td>"+table.data[index].precio_compra+"</td><td>"+table.data[index].vencimiento+"</td><td>"+categoria+"</td><td>"+laboratorio+"</td><td><a href='"+miedit+"' class='btn btn-warning'>Editar</td></tr>")
            }
            $("#text_filtros").html("<h6> Cantidad (stock): "+table.data.length+" - Total(stock*p.venta): "+total+"</h6>")
        });

        // // filtros_productos
        // <th>ID</th>
        // <th>Producto</th>
        // <th>P. Venta</th>
        // <th>P. Compra</th>
        // <th>Vencimiento</th>
        // <th>Categoria</th>
        // <th>Laboratorio</th>
        // <th>Editar</th>
    </script>
@stop
