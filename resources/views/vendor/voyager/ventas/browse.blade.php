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
                                        <select id="search_key" name="key" style="width: 300px" class="">
                                                <option value="id">Buscar por ID</option>
                                                {{-- <option value="libro_venta">Libro de Ventas</option> --}}
                                                {{-- <option value="chofer_deudas">Deudas de Choferes</option> --}}
                                                <option value="credito">Ventas a Créditos</option>
                                                <option value="reportes">Ventas por Fechas</option>
                                                <option value="pedidos">Cant. Platos</option>
                                                <option value="agrupadas">Ventas Agrupadas</option>
                                                {{-- @if(setting('empresa.type_negocio')=="Restaurante")
                                                    <option value="pensionado_kardex"> Kardex Pensionados </option>
                                                @endif --}}
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                                <option value="equals"> = </option>
                                                {{-- <option value="contains">LIKE</option> --}}
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-control" type="search"  id="s" name="s" onchange="this.form.submit()">
                                    </div>
                                </div>

                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
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
                                        <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
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
                                    
                                        @if(($data->register_id == Auth::user()->id) || ($data->register_id == setting('ventas.cliente_pag_id')))
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <td>
                                                        <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                    </td>
                                                @endif

                                                <td class="no-sort no-click bread-actions">
                                                    @foreach($actions as $action)
                                                        @if (!method_exists($action, 'massAction'))
                                                            @include('voyager::bread.partials.actions', ['action' => $action])
                                                        @endif
                                                    @endforeach
                                                </td>

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

                                                                @switch($row->field)
                                                                    @case('pago_id')
                                                                        @php
                                                                            $pago = App\Pago::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $pago ? $pago->title : null }}</span>
                                                                        @break

                                                                    @case('status_id')
                                                                        @php
                                                                            $estado = App\Estado::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $estado->title }}</span>
                                                                        @break

                                                                    @case('cliente_id')
                                                                        @php
                                                                            $cliente = App\Cliente::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $cliente ? $cliente->display : 'null' }}</span>
                                                                        @break
                                                                    @case('register_id')
                                                                        @php
                                                                            $user = TCG\Voyager\Models\User::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $user->name }}</span>
                                                                        @break
                                                                    @case('caja_id')
                                                                        @php
                                                                            $user = App\Caja::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $user->title }}</span>
                                                                        @break
                                                                    @case('cupon_id')
                                                                        @php
                                                                            $cupon = App\Cupone::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $cupon->title }}</span>
                                                                        @break
                                                                    @case('delivery_id')
                                                                        @php
                                                                            $delivery = App\Mensajero::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $delivery->name }}</span>
                                                                        @break
                                                                    @case('option_id')
                                                                        @php
                                                                            $option = App\Option::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $option->title }} </span>
                                                                        @break
                                                                    @case('sucursal_id')
                                                                        @php
                                                                            $sucursal = App\Sucursale::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $sucursal ? $sucursal->name : null }}</span>
                                                                        @break
                                                                    @case('chofer_id')
                                                                        @php
                                                                            $chofer =  TCG\Voyager\Models\User::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $chofer ? $chofer->name : null }}</span>
                                                                        @break
                                                                    @default
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <span>{{ $data->{$row->field} }}</span>
                                                                @endswitch

                                                            @endif
                                                        </td>
                                                @endforeach

                                            </tr>
                                        @elseif(Auth::user()->id == 1 OR Auth::user()->role_id == 5 )
                                            <tr>
                                                @if($showCheckboxColumn)
                                                    <td>
                                                        <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                    </td>
                                                @endif
                                                <td class="no-sort no-click bread-actions">

                                                    @foreach($actions as $action)
                                                        @if (!method_exists($action, 'massAction'))
                                                            @include('voyager::bread.partials.actions', ['action' => $action])
                                                        @endif
                                                        {{-- <a href="#" class="btn btn-sm btn-danger">Factura</a> --}}
                                                    @endforeach
                                                    {{-- @if ($data->factura == "Recibo")
                                                        <a onclick="CargarClienteVenta({{$data}})" class="btn btn-sm btn-warning pull-right" data-toggle="modal" data-target="#modal_recibo_a_factura" ><i class="voyager-helm"></i><span class="hidden-xs hidden-sm">Factura</span></a>

                                                    @endif --}}
                                                </td>
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

                                                                @switch($row->field)
                                                                    @case('pago_id')
                                                                        @php
                                                                            $pago = App\Pago::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $pago ? $pago->title : null }}</span>
                                                                        @break

                                                                    @case('status_id')
                                                                        @php
                                                                            $estado = App\Estado::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $estado ? $estado->title : null }}</span>
                                                                        @break
                                                                    @case('cliente_id')
                                                                        @php
                                                                            $cliente = App\Cliente::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $cliente ? $cliente->display : null }}</span>
                                                                        @break
                                                                    @case('register_id')
                                                                        @php
                                                                            $user = TCG\Voyager\Models\User::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $user ? $user->name : null }}</span>
                                                                        @break
                                                                    @case('caja_id')
                                                                        @php
                                                                            $user = App\Caja::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $user ? $user->title : null }}</span>
                                                                        @break
                                                                    @case('cupon_id')
                                                                        @php
                                                                            $cupon = App\Cupone::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $cupon->title }}</span>
                                                                        @break
                                                                    @case('option_id')
                                                                        @php
                                                                            $option = App\Option::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $option->title }}</span>
                                                                        @break
                                                                    @case('sucursal_id')
                                                                        @php
                                                                            $sucursal = App\Sucursale::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $sucursal->name }}</span>
                                                                        @break
                                                                    @case('delivery_id')
                                                                        @php
                                                                            $delivery = App\Mensajero::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $delivery ? $delivery->name : null }}</span>
                                                                        @break
                                                                    @case('chofer_id')
                                                                        @php
                                                                            $chofer =  TCG\Voyager\Models\User::find($data->{$row->field});
                                                                        @endphp
                                                                        <span>{{ $chofer ? $chofer->name : null }}</span>
                                                                        @break
                                                                    @default
                                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                                        <span>{{ $data->{$row->field} }}</span>
                                                                @endswitch

                                                            @endif
                                                        </td>
                                                @endforeach

                                            </tr>
                                        @endif
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

    <div class="modal modal-primary fade" tabindex="-1" id="modal_deudas" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Deudas Choferes</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <select name="" id="micajas" class="form-control"></select>
                        </div>
                        <div class="col-sm-6">
                            <select name="" id="michoferes" class="form-control"></select>
                        </div>
                        <div class="col-sm-7">
                            <button type="button" class="btn btn-dark pull-right" onclick="filtro1()"><i class="voyager-search"></i> Consultar</button>
                        </div>
                        <div class="col-sm-12">
                            <table class="table" id="table_deudas">
                                <thead>
                                    <tr>
                                        <th>Venta</th>
                                        <th>Cliente</th>
                                        <th>Pasarela</th>
                                        <th>Delivery</th>
                                        <th>Subtotal</th>
                                        <th>Creado</th>
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

    <div class="modal modal-primary fade" tabindex="-1" id="modal_pedidos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Pedidos por Tipo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <select name="" id="tipo_ventas" class="form-control"></select>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" onclick="tipo_pedidos()"><i class="voyager-eye"></i> Ver </button>
                            <button type="button" class="btn btn-dark" onclick="TipoPedidos()"><i class="voyager-search"></i> Imprimir</button>
                        </div>
                        {{-- <div class="col-sm-12">
                            <small>debe tener una caja abierta, para realizar una consulta</small>
                        </div> --}}
                    </div>
                    <small>debe tener una caja abierta, para realizar una consulta</small>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home2">Resumen</a></li>
                        <li><a data-toggle="tab" href="#menu1">Listado</a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="home2" class="tab-pane fade in active">
                            <table class="table table-responsive" id="cantidad_platos_table">
                                <thead>
                                    <th>PRODUCTO</th>
                                    <th>CANT</th>
                                    <th>PRECIO</th>
                                    <th>SUBTOTAL</th>
                                    <th>RESTANT</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <table class="table" id="platos_cliente_table">
                                <thead>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD</th>
                                    <th>CLIENTE</th>
                                    <th>TIPO</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_kardex" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <h4>Kardex Pensionados</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-6">
                            {{-- <label for="">Elija una Sucursal</label> --}}
                            <strong>Elija una Sucursal</strong>
                            <select name="" id="sucursalpensionado" class="form-control js-example-basic-single"></select>
                        </div>
                        <div class="col-sm-6">
                            {{-- <label for="">Elija un Pensionado</label> --}}
                            <strong>Elija un Pensionado</strong>
                            <select name="" id="mipensionado" class="form-control js-example-basic-single"></select>
                        </div>
                        <div class="col-sm-7">
                            <button type="button" class="btn btn-primary pull-right" onclick="FiltroKardex()">Consultar</button>
                        </div>
                        <div class="col-sm-12">
                            <table class="table" id="table_kardex">
                                <thead>
                                    <tr>
                                        <th>Venta</th>
                                        <th>Cliente</th>

                                        <th>Creado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Consultar</button> --}}
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_cobros" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4>Ventas a Crédito</h4>
                </div>
                <div class="modal-body">
                    <div id="tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Créditos</a></li>
                            <li role="presentation" ><a href="#historial" aria-controls="historial" role="tab" data-toggle="tab">Historial</a></li>
                            <li role="presentation" ><a href="#cobro" aria-controls="cobro" role="tab" data-toggle="tab">Cobrar</a></li>
                        </ul>
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="home">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>Elija una Sucursal</strong>
                                        <select name="" id="sucursal_consulta" class="form-control" data-width="100%"></select>
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Elija un Cliente</strong>
                                        <select name="" id="cliente_consulta" class="form-control"></select>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn btn-dark" onclick="ConsultarCredito()"> <i class="voyager-search"></i> Consultar</button>
                                        <table class="table" id="table_consultas_cobros">
                                            <thead>
                                                <tr>
                                                    <th>Venta</th>
                                                    <th>Estado</th>
                                                    <th>Cliente</th>
                                                    <th>Deuda</th>
                                                    <th>Creado</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="historial">

                                <div class="col-sm-12">
                                    <table class="table" id="table_historial">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Venta</th>
                                                <th>Cliente</th>
                                                <th>Deuda</th>
                                                <th>Cuota</th>
                                                <th>Restante a Pagar</th>
                                                <th>Creado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="cobro">
                                <div class="col-sm-12">
                                    <table class="table" id="table_cobros">
                                        <thead>
                                            <tr>
                                                <th>Venta</th>
                                                <th>Cliente</th>
                                                <th>Deuda Inicial</th>
                                                <th>Restante a Pagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>

                                    </table>
                                    <div class="form-group col-md-4 text-center">
                                        <form class="form-horizontal" role="form">
                                            <label class="radio-inline"> <input type="radio" name="season" id="" value="1" checked> Pago En Efectivo </label>
                                            <label class="radio-inline"> <input type="radio" name="season" id="" value="0"> Pago en Línea </label>
                                        </form>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Cuota</label>
                                        <input class="form-control" type="number" value="0" min="0" placeholder="Ingrese Monto" id="cuota_cobro">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Venta" id="venta_id">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Deuda" id="deuda">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Cliente" id="cliente_id">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese texto Cliente" id="cliente_text">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="form-control" type="hidden" placeholder="Ingrese Restante" id="restante">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-dark" onclick="ActualizarCredito()">Guardar</button>
                                {{-- <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_capital" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <h4>Capital en Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <button type="button" class="btn btn-primary pull-right" onclick="CalcularCapitalDefault()">Consultar</button>
                        </div>
                        <div class="col-sm-12">
                            <table class="table" id="table-capital-productos">
                                <thead>
                                    <tr>
                                        <th>Cantidad Productos</th>
                                        <th>Total Stock * Cantidad Productos</th>
                                        <th>Promedio de Ganancia por Producto</th>
                                        <th><b>Capital en Productos</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal modal-primary fade" tabindex="-1" id="modal_vencimiento_productos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <h4>Vencimiento de Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicial_vencimiento"  >
                        </div>
                        <div class="col-sm-6">
                            <label for="">Fecha Final</label>
                            <input type="date" class="form-control" id="fecha_final_vencimiento"  >
                        </div>
                        <div class="col-sm-7">
                            <button type="button" class="btn btn-primary pull-right" onclick="Consulta_Vencimiento_Productos()">Consultar</button>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    {{-- //graficos --}}
    <div class="modal modal-primary fade" tabindex="-1" id="modal_reportes" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Ventas por Fechas</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="">Fecha Inicial</label>
                            <input class="form-control" type="date" name="date1" id="date1">
                        </div>
                        <div class="col-sm-6">
                            <label for="">Fecha Final</label>
                            <input class="form-control" type="date" name="date2" id="date2">
                        </div>
                        <div class="col-sm-4">
                            <label for="">Cajas</label>
                            <select name="caja_id" id="caja_id" class="form-control"></select>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Cajar@s</label>
                            <select name="register_id" id="register_id" class="form-control"></select>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Sucursal</label>
                            <select name="" id="" class="form-control"></select>
                        </div>
                    </div>
                    <small>el resumen y el listado se actualizaran cada vez de cambie: (Cajas, Cajer@s o Sucursales)</small>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home22">Resumen</a></li>
                        <li><a data-toggle="tab" href="#menu11">Listado</a></li>
                    </ul>
                    
                    <div class="tab-content">
                        <div id="home22" class="tab-pane fade in active">
                            <table class="table table-responsive" id="report_table">
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="menu11" class="tab-pane fade">
                            <table class="table" id="report_list">
                                <thead>
                                    <th>id</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Pasarela</th>
                                    <th>Cliente</th>
                                    <th>Productos</th>
                                    <th>Total</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- //LIBRO DE VENTAS --}}
    <div class="modal modal-primary fade" tabindex="-1" id="modal_libro" role="dialog">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Libro de Ventas</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-4">
                        <label for="">Mes</label>
                        <select name="mes_reporte" id="mes_reporte" class="form-control"></select>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Año</label>
                        <select name="year_reporte" id="year_reporte" class="form-control"></select>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-sm btn-primary" onclick="GenerarListaFacturas()" >Generar</button>
                        <button type="button" class="btn btn-sm btn-dark" onclick="ExportarListaFacturas()" >Exportar</button>
                    </div>
                    {{-- <div class="table-responsive"> --}}
                        <table class="table" id="table_libro">
                            <thead>
                                <th>Número</th>
                                <th>Fecha</th>
                                <th>Nro. de Factura</th>
                                <th>Nro. de Autorización</th>
                                <th>CI/NIT</th>
                                <th>Razón Social</th>
                                <th>Subtotal</th>
                                <th>Descuento</th>
                                <th>Importe Base</th>
                                <th>Débito Fiscal</th>
                                <th>Código de Control</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>

        
    <div class="modal modal-primary fade" tabindex="-1" id="modal_agrupadas" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Ventas Agrupadas</h4>
                </div>
                <div class="modal-body">
                    <small>solo se listaran las ventas activas (con cajas abiertas)</small>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#mitabs1">Opciones</a></li>
                        <li><a data-toggle="tab" href="#mitabs2">Productos</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="mitabs1" class="tab-pane fade in active">
                            <div class="row">
                                <div id="mititle"></div>
                               <div class="col-sm-4">
                                   <div id="group_uno"></div>
                               </div>
                               <div class="col-sm-4">
                                   <div id="group_dos"></div>       
                               </div>
                               <div class="col-sm-4">
                                   <div id="group_tres"></div>    
                               </div>
                            </div>  
                        </div>
                        <div id="mitabs2" class="tab-pane fade">
                            <h2>en desarrollo</h2>
                        </div>
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
            $('.js-example-basic-single').select2();
            DesactivarPensionados();

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
                $('.side-body').multilingual()
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init()
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change')
            });
        });
        async function DesactivarPensionados(){
            var table=await axios.get("{{ setting('admin.url') }}api/pos/pensionados");
            for(let index=0;index < table.data.length;index++){
                var aux= parseInt(CalculoDiasRestantes(table.data[index].fecha_final));
                if(aux<0){
                var actualizar= await axios("{{ setting('admin.url') }}api/pos/pensionados/actualizar/"+table.data[index].id);
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
            var fechaf = new Date(ff).getTime();
            var diff = fechaf - fechai;
            return (diff/(1000*60*60*24));
        }
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


        async function ActualizarCliente() {
            var id=$('#cliente_id_conversion').val()
            var nombres=$('#first_name_conversion').val()
            var apellidos=$('#last_name_conversion').val()
            var ci_nit=$('#ci_nit_conversion').val()
            var midata= JSON.stringify({
                'id':id,
                'first_name': nombres,
                'last_name':apellidos,
                'ci_nit':ci_nit
            })
            if((nombres!="Cliente")&&(apellidos!="Generico")){
                var table=await axios("{{setting('admin.url')}}api/pos/update_datos_cliente/"+midata)
                if(table.data){
                    toastr.success('Cliente Actualizado')
                }
            }
            else{
                toastr.error("El Cliente Generico ya existe y no se puede facturar a ese nombre")
            }

        }

        $('#cliente_busqueda').keyup(async function (e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                $("#cliente_list tbody tr").remove();
                var mitable = "";
                var table= await axios.get("{{ setting('admin.url') }}api/pos/clientes/search/"+this.value)
                if(table.data){
                    if (table.data.length == 0 ) {
                            toastr.error('Sin Resultados.');
                    }
                    else{
                        toastr.success('Clientes Encontrados');
                        for (let index = 0; index < table.data.length; index++) {
                            mitable = mitable + "<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].display+"</td><td>"+table.data[index].ci_nit+"</td><td><a class='btn btn-sm btn-success' onclick='cliente_get("+table.data[index].id+")'>Elegir</a></td></tr>";
                        }
                        $('#cliente_list').append(mitable);
                    }
                }
            }
        });

        $('#cliente_busqueda_ci').keyup(async function (e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                $("#cliente_list tbody tr").remove();
                var mitable = "";
                var table= await axios.get("{{ setting('admin.url') }}api/pos/clientes/search_ci/"+this.value)
                if(table.data){
                    if (table.data.length == 0 ) {
                            toastr.error('Sin Resultados.');
                    }
                    else{
                        toastr.success('Clientes Encontrados');
                        for (let index = 0; index < table.data.length; index++) {
                            mitable = mitable + "<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].display+"</td><td>"+table.data[index].ci_nit+"</td><td><a class='btn btn-sm btn-success' onclick='cliente_get("+table.data[index].id+")'>Elegir</a></td></tr>";
                        }
                        $('#cliente_list').append(mitable);
                    }
                }
            }
        });

        // async function savecliente() {
        //     var first = $('#first_name').val();
        //     var last = $('#last_name').val();
        //     var phone = $('#phone').val();
        //     var nit = $('#nit').val();
        //     var display = $('#display').val();
        //     var email = $('#email').val();
        //     var midata = JSON.stringify({first_name: first, last_name: last, phone: phone, nit: nit, display: display, email: email});
        //     var table= await axios("{{ setting('admin.url') }}api/pos/savacliente/"+midata)
        //     if(table.data){
        //         toastr.success('Cliente Creado');
        //         $('#first_name_conversion').val(table.data.first_name)
        //         $('#last_name_conversion').val(table.data.last_name)
        //         $('#ci_nit_conversion').val(table.data.ci_nit)
        //         $('#cliente_id_conversion').val(table.data.id)

        //     }
        // }
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
            $('#first_name_conversion').val(newcliente.data.first_name)
            $('#last_name_conversion').val(newcliente.data.last_name)
            $('#ci_nit_conversion').val(newcliente.data.ci_nit)
            $('#cliente_id_conversion').val(newcliente.data.id)
            $('#first_name').val('')
            $('#last_name').val('')
            $('#display').val('')
            $('#email').val('')
        }

        // cliente_get
        async function cliente_get(id) {
            var table= await axios("{{ setting('admin.url') }}api/pos/cliente/"+id)
            if((table.data)&&(table.data.default!=1)){
                toastr.success('Cliente Seleccionado');
                $("#first_name_conversion").attr("readonly", false)
                $("#last_name_conversion").attr("readonly", false)
                $("#ci_nit_conversion").attr("readonly", false)

                $('#first_name_conversion').val(table.data.first_name)
                $('#last_name_conversion').val(table.data.last_name)
                $('#ci_nit_conversion').val(table.data.ci_nit)
                $('#cliente_id_conversion').val(table.data.id)
            }
            if(table.data.default){
                toastr.error("No puede convertir a una factura con Cliente Genérico")
                // $("#first_name_conversion").attr("readonly", true)
                // $("#last_name_conversion").attr("readonly", true)
                // $("#ci_nit_conversion").attr("readonly", true)
            }
        }

        // ADD DISPLAY
        $('#first_name').keyup(function (e) {
            e.preventDefault();
            $('#display').val(this.value+' '+$('#last_name').val());
            $('#email').val(this.value+'.'+$('#last_name').val()+'@loginweb.dev');
        });

        $('#last_name').keyup(function (e) {
            e.preventDefault();
            $('#display').val($('#first_name').val()+' '+this.value);
            $('#email').val($('#first_name').val()+'.'+this.value+'@loginweb.dev');
        });

  

        async function modal_conversion() {
            var id=$('#id_venta_conversion').val()
            var table=await axios("{{setting('admin.url')}}api/pos/venta/"+id)
            var cliente_id=$('#cliente_id_conversion').val()
            var nrofactura =await axios("{{setting('admin.url')}}api/pos/nro_factura")
            var midata = JSON.stringify({
                'id':table.data.id,
                'numero_factura':nrofactura.data,
                'cliente_id' : cliente_id,
                'fecha_compra' : table.data.created_at,
                'monto_compra' : table.data.total
            })
            var table=await axios("{{setting('admin.url')}}api/pos/convertir_a_factura/"+midata)
            location.reload();
        }


                $('#search_key').on('change', async function() {
                    // $('.js-example-basic-single').select2();
                    switch (this.value) {
                        case 'libro_venta':
                            $('#modal_libro').modal();
                            MonthYear()
                            break;
                        case 'cliente_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/clientes",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Cliente'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].first_name +" "+ response[index].last_name  +" "+ response[index].ci_nit
                                        }));
                                    }
                                }
                            });
                            break;
                        case 'sucursal_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/sucursales",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige una Sucursal'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                            case 'delivery_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/deliverys",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Delivery'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                            case 'chofer_id':
                            $('#s').find('option').remove().end();
                            const queryString = window.location.search;
                            const urlParams = new URLSearchParams(queryString);
                            $.ajax({
                                url: "{{ setting('admin.url') }}api/pos/choferes/",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Chofer'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                        case 'status_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/estados",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Estado'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].title
                                        }));
                                    }
                                }
                            });
                            break
                        case 'pago_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/pagos",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Tipo de Pago'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].title
                                        }));
                                    }
                                }
                            });
                            break
                        case'register_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/cajeros",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Cajero'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                }
                            });
                            break
                        case'cupon_id':
                            $('#s').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/cupones",
                                dataType: "json",
                                success: function (response) {
                                    $('#s').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Cajero'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        // const element = response[index];
                                        $('#s').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].title
                                        }));
                                    }
                                }
                            });
                            break
                        case'option_id':
                            $('#s').find('option').remove().end();
                                $('#s').append($('<option>', {
                                    value: null,
                                    text: 'Elige una Opción'
                                }));
                                $('#s').append($('<option>', {
                                    value: 'Mesa',
                                    text: 'En Mesa'
                                }));
                                $('#s').append($('<option>', {
                                    value: 'Delivery',
                                    text: 'Delivery'
                                }));
                                $('#s').append($('<option>', {
                                    value: 'Recoger',
                                    text: 'Para Llevar'
                                }));
                            break
                        case 'chofer_deudas':
                                $('#modal_deudas').modal();
                                Cajas_Deudas_Choferes();
                                Choferes_Deudas();
                            break
                        case 'pedidos':
                                $('#modal_pedidos').modal();
                                Opciones();
                            break
                        case 'agrupadas':
                            $('#modal_agrupadas').modal();
                            var agroup = await axios("{{setting('admin.url')}}api/ventas/group")
                            // console.log(agroup.data)
                            var uno = ''
                            var uno_count = 0
                            var dos = ''
                            var dos_count = 0
                            var tres = ''
                            var tres_count = 0
                            var micount = 0
                            for (let index = 0; index < agroup.data.length; index++) {
                                switch (agroup.data[index].option_id) {
                                    case 1:
                                        uno +=  "<code>ID:"+agroup.data[index].id+" "+agroup.data[index].published+"</code><br>"     
                                        uno += agroup.data[index].estado.title+"<br>"       
                                        uno += agroup.data[index].pasarela.title+"<br>"                       
                                        uno += agroup.data[index].cliente.display+"<br>"
                                        uno += " -> Carrito<br>"
                                        var miproducts = "<ul>"
                                        for (let j = 0; j < agroup.data[index].detalle_venta.length; j++) {
                                            miproducts += "<li>"+agroup.data[index].detalle_venta[j].cantidad+" - "+agroup.data[index].detalle_venta[j].name+"</li>"
                                        }
                                        miproducts += "</ul>"
                                        uno += "<p>"+miproducts+"</p>"
                                        uno_count++
                                        break;
                                    case 2:
                                        dos += "<code>ID: "+agroup.data[index].id+" "+agroup.data[index].published+"</code><br>"    
                                        dos += agroup.data[index].estado.title+"<br>"    
                                        dos += agroup.data[index].pasarela.title+"<br>"  
                                        dos += agroup.data[index].cliente.display+"<br>"
                                        dos += " -> Carrito<br>"
                                        var miproducts = "<ul>"
                                        for (let j = 0; j < agroup.data[index].detalle_venta.length; j++) {
                                            miproducts += "<li>"+agroup.data[index].detalle_venta[j].cantidad+" - "+agroup.data[index].detalle_venta[j].name+"</li>"
                                        }
                                        miproducts += "</ul>"
                                        dos += "<p>"+miproducts+"</p>"        
                                        dos_count++                                
                                        break;       
                                    case 3:
                                        tres += "<code>ID: "+agroup.data[index].id+" "+agroup.data[index].published+"</code><br>"   
                                        tres += agroup.data[index].estado.title+"<br>"     
                                        tres += agroup.data[index].pasarela.title+"<br>"  
                                        tres += agroup.data[index].cliente.display+"<br>"
                                        tres += " -> Carrito<br>"
                                        var miproducts = "<ul>"
                                        for (let j = 0; j < agroup.data[index].detalle_venta.length; j++) {
                                            miproducts += "<li>"+agroup.data[index].detalle_venta[j].cantidad+" - "+agroup.data[index].detalle_venta[j].name+"</li>"
                                        }
                                        miproducts += "</ul>"
                                        tres += "<p>"+miproducts+"</p>"      
                                        tres_count++                                  
                                        break;                                 
                                    default:
                                        break;                                
                                }
                                micount++
                                // console.log(micount)
                            }
                            $("#group_uno").html(uno)
                            $("#group_dos").html(dos)
                            $("#group_tres").html(tres)
                            $("#mititle").html("<table class='table'><tr><td>COMER AQUI: "+uno_count+"</td><td>A Domicilio : "+dos_count+"</td><td>Para llevar : "+tres_count+"</td></tr></table>")
                            break
                        case 'pensionado_kardex':
                            LimpiarKardex();
                            $('#modal_kardex').modal();
                            Sucursales();
                        break
                        case 'reportes':
                            $('#modal_reportes').modal();
                            $('#register_id').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/cajeros",
                                dataType: "json",
                                success: function (response) {
                                    $('#register_id').append($('<option>', {
                                        value: null,
                                        text: 'Elige un Cajero'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#register_id').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].name
                                        }));
                                    }
                                    $('#register_id').append($('<option>', {
                                        value: 'all',
                                        text: 'Todos los Cajeros'
                                    }));
                                }
                            });
                            $('#caja_id').find('option').remove().end();
                            $.ajax({
                                url: "{{setting('admin.url')}}api/pos/cajas",
                                dataType: "json",
                                success: function (response) {
                                    $('#caja_id').append($('<option>', {
                                        value: null,
                                        text: 'Elige una Caja'
                                    }));
                                    for (let index = 0; index < response.length; index++) {
                                        $('#caja_id').append($('<option>', {
                                            value: response[index].id,
                                            text: response[index].title
                                        }));
                                    }
                                    $('#caja_id').append($('<option>', {
                                        value: 'all',
                                        text: 'Todas las Cajas'
                                    }));
                                }
                            });
                        break
                        case 'credito':
                            $('#modal_cobros').modal();
                            LimpiarCobroCreditos();                            
                            sucursal_consulta();
                        break
                        case 'caja_id':
                            $('#s').find('option').remove().end();
                            Cajas();
                        break
                        default:
                            //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
                            break
                    }
                });

                async function micliente() {
                    var miphone = Math.floor(Math.random() * 1000000000);
                    $('#phone').val(miphone)
                }

                async function ExportarListaFacturas() {
                    var mes= $('#mes_reporte').val()
                    var year=$('#year_reporte').val()
                    var inicio=1;
                    var final=0;
                    if((mes==1)||(mes==3)||(mes==5)||(mes==7)||(mes==8)||(mes==10)||(mes==12)){
                        final=31
                    }
                    else if((mes==4)||(mes==6)||(mes==9)||(mes==11)){
                        final=30
                    }
                    else{
                        if ((((year % 4) == 0) && ((year % 100) != 0)) || (((year % 100) == 0) && ((year % 400) == 0))) {
                            final = 29
                        } else {
                            final = 28
                        }
                    }
                    if(mes<10){
                        var fecha_inicio_text=year+'-0'+mes+'-01'
                        var fecha_final_text=year+'-0'+mes+'-'+final
                    }
                    else{
                        var fecha_inicio_text=year+'-'+mes+'-01'
                        var fecha_final_text=year+'-'+mes+'-'+final
                    }
                    var var1=fecha_inicio_text
                    var var2=fecha_final_text
                    console.log(fecha_inicio_text)
                    var ruta="{{ route('excel.ventas', ['var1', 'var2']) }}"
                    ruta = ruta.replace("var1", fecha_inicio_text)
                    ruta = ruta.replace("var2", fecha_final_text)
                    location.href=ruta
                }

                async function GenerarListaFacturas() {
                    $('#table_libro tbody tr').remove();
                    var mes= $('#mes_reporte').val()
                    var year=$('#year_reporte').val()
                    var inicio=1;
                    var final=0;
                    if((mes==1)||(mes==3)||(mes==5)||(mes==7)||(mes==8)||(mes==10)||(mes==12)){
                        final=31
                    }
                    else if((mes==4)||(mes==6)||(mes==9)||(mes==11)){
                        final=30
                    }
                    else{
                        if ((((year % 4) == 0) && ((year % 100) != 0)) || (((year % 100) == 0) && ((year % 400) == 0))) {
                            final = 29
                        } else {
                            final = 28
                        }
                    }
                    if(mes<10){
                        var fecha_inicio_text=year+'-0'+mes+'-01'
                        var fecha_final_text=year+'-0'+mes+'-'+final
                    }
                    else{
                        var fecha_inicio_text=year+'-'+mes+'-01'
                        var fecha_final_text=year+'-'+mes+'-'+final
                    }
                    var midata= {
                        var1:fecha_inicio_text,
                        var2:fecha_final_text
                    }
                    var table= await axios.post("{{setting('admin.url')}}api/reporte/ventas/facturas", midata)
                    var dosificacion= await axios("{{setting('admin.url')}}api/dosificacion/activa")
                    if(table.data.length!=0){
                        //console.log("hola")
                        for (let index = 0; index < table.data.length; index++) {
                            $('#table_libro').append("<tr><td>"+(index+1)+"</td><td>"+table.data[index].fecha+"</td><td>"+table.data[index].nro_factura+"</td><td>"+dosificacion.data.nro_autorizacion+"</td><td>"+table.data[index].cliente.ci_nit+"</td><td>"+table.data[index].cliente.display+"</td><td>"+(table.data[index].subtotal+table.data[index].adicional)+"</td><td>"+table.data[index].descuento+"</td><td>"+table.data[index].total+"</td><td>"+parseFloat(table.data[index].total*0.13).toFixed(2)+"</td><td>"+table.data[index].codigo_control+"</td></tr>");
                        }
                    }
                    else{
                        toastr.error("No hay Facturas Ingresadas el Mes: "+$('#mes_reporte :selected').text()+" del Año: "+$('#year_reporte :selected').text())
                    }
                }
                async function MonthYear() {
                    $('#mes_reporte').append($('<option>', {
                            value: 1,
                            text: "Enero"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 2,
                            text: "Febrero"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 3,
                            text: "Marzo"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 4,
                            text: "Abril"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 5,
                            text: "Mayo"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 6,
                            text: "Junio"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 7,
                            text: "Julio"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 8,
                            text: "Agosto"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 9,
                            text: "Septiembre"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 10,
                            text: "Octubre"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 11,
                            text: "Noviembre"
                    }));
                    $('#mes_reporte').append($('<option>', {
                            value: 12,
                            text: "Diciembre"
                    }));

                    for (let index = 0; index < 2; index++) {
                        $('#year_reporte').append($('<option>', {
                            value: (index+2022),
                            text: (index+2022)
                        }));
                    }
                }

                async function TipoPedidos() {
                    var option_id=$('#tipo_ventas').val()
                    var micaja = JSON.parse(localStorage.getItem('micaja'));
                    var data= JSON.stringify({
                        'user_id':micaja.user_id,
                        'sucursal_id':micaja.sucursal_id,
                        'option_id':option_id
                    })
                    var table= await axios.get("{{setting('admin.url')}}api/ventas/opcion/"+data)
                    if((table.data) || (option_id==4)){
                        const myWindow = window.open( "{{ setting('admin.url') }}admin/ventas/imprimir/opcion/"+data, "Recibo o Factura", "width=600,height=900")
                        setTimeout(function() {myWindow.close()}, {{ setting('impresion.tiempo_cierre') }})
                    }
                    else{
                        toastr.error("No hay ventas de tipo: "+$('#tipo_ventas :selected').text())
                    }
                }

                
                async function tipo_pedidos() {
                    $('#cantidad_platos_table tbody tr').remove();
                    $('#platos_cliente_table tbody tr').remove();

                    var option_id=$('#tipo_ventas').val()
                    var micaja = JSON.parse(localStorage.getItem('micaja'));
                    var ventas=[]
                    var data= JSON.stringify({
                        'user_id':micaja.user_id,
                        'sucursal_id':micaja.sucursal_id,
                        'option_id':option_id
                    })
                    var data2= {
                        'user_id':micaja.user_id,
                        'sucursal_id':micaja.sucursal_id,
                        'option_id':option_id
                    }
                    var subtotal_plato=0
                    var total_plato=0
                    var total_dinero=0;

                    var total_mesa=0
                    var total_para_llevar=0
                    var total_a_domicilio=0

                    var table = await axios.get("{{setting('admin.url')}}api/ventas/opcion/"+data)
                    if((table.data) || (option_id==4)){
                        var platomayor=await axios.post("{{setting('admin.url')}}api/ventas/platos/idmayor", data2)
                        //console.log(platomayor.data)
                        var table2 = await axios.post("{{setting('admin.url')}}api/ventas/platos/cantidades", data2)
                        // var stock=0
                         //console.log(table2.data)
                         var newlist = [];
                         var newlist2 = [];
                         for (let index = 0; index < ((platomayor.data)+1); index++) {
                            if (table2.data[index]) {
                                newlist.push(index)
                            }
                         }
                        //console.log(newlist)

                         data3={
                            'user_id':micaja.user_id,
                            'sucursal_id':micaja.sucursal_id,
                            'option_id':option_id,
                            'vector':newlist,
                         }
                         var table4=await axios.post("{{setting('admin.url')}}api/ventas/platos/cantidades/segundo", data3)
                         //console.log(table4.data)

                        for (let index = 0; index < table4.data.length; index++) {
                            stock= table4.data[index].stock ? table4.data[index].stock : ""
                            $('#cantidad_platos_table').append("<tr><td>"+table4.data[index].name+"</td><td>"+table4.data[index].cant+"</td><td>"+table4.data[index].precio+"</td><td>"+table4.data[index].subtotal+"</td><td>"+stock+"</td></tr>")
                            total_dinero+=table4.data[index].subtotal
                            total_plato+=table4.data[index].cant
                        }
                        $('#cantidad_platos_table').append("<tr><td><h5>Total Platos:</h5></td><td><h5>"+total_plato+"</h5></td><td><h5>Total Dinero:</h5></td><td><h5>"+total_dinero+"</h5></td><td></td></tr>")

                        var table3= await axios.post("{{setting('admin.url')}}api/ventas/lista/detalle", data2)
                        //console.log(table3.data)
                        for (let index = 0; index < table4.data.length; index++) {
                            for (let index2 = 0; index2 < table3.data.length; index2++) {

                                for (let index3 = 0; index3 < table3.data[index2].detalle_venta.length; index3++) {
                                    //console.log("Hola")

                                    if (table4.data[index].name==table3.data[index2].detalle_venta[index3].name) {
                                        //console.log(table4.data[index].name)
                                         $('#platos_cliente_table').append("<tr><td>"+table4.data[index].name+"</td><td>"+table3.data[index2].detalle_venta[index3].cantidad+"</td><td>"+table3.data[index2].cliente.display+"</td><td>"+table3.data[index2].option.title+"</td></tr>")
                                         subtotal_plato+=table3.data[index2].detalle_venta[index3].cantidad
                                         if (table3.data[index2].option.id==1) {
                                            total_mesa+=table3.data[index2].detalle_venta[index3].cantidad
                                         }
                                         if (table3.data[index2].option.id==2) {
                                            total_para_llevar+=table3.data[index2].detalle_venta[index3].cantidad
                                         }
                                         if (table3.data[index2].option.id==3) {
                                            total_a_domicilio+=table3.data[index2].detalle_venta[index3].cantidad
                                         }
                                        //  if ((index2+1)==table3.data.length) {
                                        if (subtotal_plato==table4.data[index].cant) {
                                            //total_plato+=subtotal_plato
                                            //console.log("Hola")
                                            if ((option_id==4)) {
                                                $('#platos_cliente_table').append("<tr><td><h5>COMER AQUÍ: </h5></td><td><h5>"+total_mesa+"</h5></td><td></td><td></td></tr>")
                                                $('#platos_cliente_table').append("<tr><td><h5>Recoger en Tienda: </h5></td><td><h5>"+total_para_llevar+"</h5></td><td></td><td></td></tr>")
                                                $('#platos_cliente_table').append("<tr><td><h5>A Domicilio (Delivery): </h5></td><td><h5>"+total_a_domicilio+"</h5></td><td></td><td></td></tr>")
                                            }
                                            
                                            $('#platos_cliente_table').append("<tr><td><h5>SUBTOTAL: "+table4.data[index].name+"  </h5></td><td><h5>"+subtotal_plato+"</h5></td><td></td><td></td></tr>")
                                         }
                                    }
                                }
                            }
                           
                            subtotal_plato=0
                            total_mesa=0
                            total_para_llevar=0
                            total_a_domicilio=0

                        }
                         $('#platos_cliente_table').append("<tr><td><h4>Total Platos: </h4></td><td><h4>"+total_plato+"</h4></td><td></td><td></td></tr>")

                    }
                    else{
                        toastr.error("No hay ventas de tipo: "+$('#tipo_ventas :selected').text())
                    }
                }
                
                

                async function Opciones() {
                    $('#tipo_ventas').find('option').remove().end();
                    var table= await axios.get("{{setting('admin.url')}}api/pos/options")
                    $('#tipo_ventas').append($('<option>', {
                        value: null,
                        text: 'Elige una Opción'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#tipo_ventas').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                    }
                    $('#tipo_ventas').append($('<option>', {
                            value: 4,
                            text: "Todos"
                    }));
                }

                async function Cajas() {
                    var table= await axios.get("{{setting('admin.url')}}api/pos/cajas");
                    $('#s').append($('<option>', {
                        value: null,
                        text: 'Elige una Caja'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#s').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                    }


                }

                async function Cajas_Deudas_Choferes(){
                    $('#micajas').find('option').remove().end();
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/cajas");
                    $('#micajas').append($('<option>', {
                        value: null,
                        text: 'Elige una Caja'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#micajas').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].id + ' - '+ table.data[index].title +' - '+ table.data[index].sucursal.name
                        }));
                    }
                }

                async function Choferes_Deudas() {
                    $('#michoferes').find('option').remove().end();
                    var table=await axios.get("{{ setting('admin.url') }}api/pos/choferes/");
                    $('#michoferes').append($('<option>', {
                        value: null,
                        text: 'Elige un Chofer'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#michoferes').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                function filtro1() {
                    $('#table_deudas tbody tr').remove();
                    var urli = "{{ setting('admin.url') }}api/pos/choferes/deudas/"+$("#michoferes").val()+"/"+$("#micajas").val();
                    var mitable = "";
                    var total_efectivo=0;
                    var total_credito=0;
                    var total_banipay=0;
                    $.ajax({
                        url: urli,
                        dataType: "json",
                        success: function (response) {
                            if (response.length == 0 ) {
                                toastr.error('Sin Resultados.');
                            } else {
                                for (let index = 0; index < response.length; index++) {
                                    mitable = mitable + "<tr><td>"+response[index].id+"</td><td>"+response[index].cliente.display+"</td><td>"+response[index].pasarela.title+"</td><td>"+response[index].delivery.name+"</td><td>"+response[index].total+"</td><td>"+response[index].published+"</td></tr>";
                                    if(response[index].pasarela_id=="{{setting('ventas.banipay_1')}}"||response[index].pasarela_id=="{{setting('ventas.banipay_2')}}"){
                                        total_banipay+=response[index].total;
                                    }
                                    else{
                                        if(response[index].credito=='Contado'){
                                            total_efectivo+=response[index].total;
                                        }
                                        else{
                                            total_credito+=response[index].total;
                                        }
                                    }
                                }
                                mitable = mitable +"<tr><td></td><td></td><td></td><td></td><td>Total en Banipay</td><td><b>"+total_banipay+"</b></td> </tr>"
                                mitable = mitable +"<tr><td></td><td></td><td></td><td></td><td>Total a Credito</td><td><b>"+total_credito+"</b></td> </tr>"
                                mitable = mitable +"<tr><td></td><td></td><td></td><td><td></td>Total en Efectivo</td><td><b>"+total_efectivo+"</b></td> </tr>"
                                $('#table_deudas').append(mitable);
                            }
                        }
                    });
                    // Cajas_Deudas_Choferes();
                    // Choferes_Deudas();
                }

                async function Sucursales(){
                    $('#sucursalpensionado').find('option').remove().end();
                    var table = await axios.get("{{setting('admin.url')}}api/pos/sucursales");
                    $('#sucursalpensionado').append($('<option>', {
                        value: 0,
                        text: 'Elige una Sucursal'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#sucursalpensionado').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                $('#sucursalpensionado').on('change', function() {
                    Pensionados();
                });

                async function Pensionados(){
                    $('#mipensionado').find('option').remove().end();
                    var table = await axios.get("{{setting('admin.url')}}api/pos/pensionados");
                    $('#mipensionado').append($('<option>', {
                        value: 0,
                        text: 'Elige un Pensionado'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#mipensionado').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].cliente.display
                        }));
                    }

                }

                async function FiltroKardex() {
                    $('#table-kardex tbody tr').remove();
                    var table= await axios.get(" {{setting('admin.url')}}api/pos/pensionados/kardex/"+$("#sucursalpensionado").val()+"/"+$("#mipensionado").val());
                    var midata="";
                    total=0;
                    if (table.data.length == 0 ) {
                        toastr.error('Sin Resultados.');
                    } else {
                        for (let index = 0; index < table.data.length; index++) {
                            midata = midata + "<tr><td>"+table.data[index].id+"</td><td>"+table.data[index].cliente.display+"</td><td>"+table.data[index].published+"</td></tr>";
                            total+=1;
                            var fecha=table.data[index].pensionado.fecha_final;
                        }
                        midata = midata +"<tr><td></td><td></td><td></td></tr>"
                        midata = midata +"<tr><td></td><td>Dias Ventas</td><td><b>"+total+"</b></td> </tr>"
                        midata = midata +"<tr><td></td><td>Dias Restantes del Plan</td><td><b>"+CalculoDiasRestantes(fecha)+"</b></td> </tr>"
                        $('#table_kardex').append(midata);
                    }
                    Sucursales();
                    Pensionados();
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

                async function sucursal_consulta(){
                    $('#sucursal_consulta').find('option').remove().end()
                    var table= await axios.get("{{setting('admin.url')}}api/pos/sucursales")
                    $('#sucursal_consulta').append($('<option>', {
                        value: null,
                        text: 'Elige una Sucursal'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        // const element = table.data[index];
                        $('#sucursal_consulta').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name,
                            // selected: true
                        }));
                    }
                }

                $('#sucursal_consulta').on('change', function() {
                    cliente_consulta();
                });

                async function cliente_consulta() {
                    $('#cliente_consulta').find('option').remove().end();
                    var table= await axios.get("{{setting('admin.url')}}api/pos/clientes");
                    $('#cliente_consulta').append($('<option>', {
                        value: null,
                        text: 'Elige un Cliente'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        if(table.data[index].default==0){
                            $('#cliente_consulta').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].display+' - '+table.data[index].ci_nit
                            }));
                        }
                    }
                }

                async function ConsultarCredito() {
                    $('#table_consultas_cobros tbody tr').remove();
                    var sucursal_id = $("#sucursal_consulta").val()
                    var cliente_id = $("#cliente_consulta").val()
                    var venta= await axios.get("{{setting('admin.url')}}api/pos/ventas-creditos/"+cliente_id+"/"+sucursal_id);
                    var midata="";
                    total=0;
                    if (venta.data.length == 0 ) {
                        toastr.error('Sin Resultados.');
                    } else {
                        for (let index = 0; index < venta.data.length; index++) {
                            if(venta.data[index].status_credito==0){
                                var estado="Pagado";
                            }
                            else{
                                var estado="Debe";
                            }
                            var deuda= venta.data[index].subtotal+venta.data[index].adicional-venta.data[index].descuento;
                            $('#table_consultas_cobros').append("<tr><td>"+venta.data[index].id+"</td><td>"+estado+"</td><td>"+venta.data[index].cliente.display+"</td><td>"+deuda+"</td><td>"+venta.data[index].published+"</td><td><a href='#historial' aria-controls='historial' role='tab' data-toggle='tab' class='btn btn-sm btn-primary' onclick='DetalleCredito("+venta.data[index].id+")'>Historial</a></td></tr>");
                        }
                    }
                }

                async function DetalleCredito(id) {
                    $('#table_historial tbody tr').remove();
                    // $( "#tabs" ).tabs({ active: 1 });
                    $('.nav-tabs a[href="#historial"]').tab('show')
                    var credito= await axios.get("{{setting('admin.url')}}api/pos/creditos/cliente/"+id);
                    var midata="";
                    var pagar=0;
                    var venta=0;
                    var cliente=0;
                    var cliente_text="";
                    var deuda=0;
                    var status=0;
                    if(credito.data.length==0){
                        toastr.error('No se encontraron creditos del cliente.'+credito.data[index].cliente.display);
                    }
                    else{
                        for(let index=0;index<credito.data.length;index++){
                            $('#table_historial').append("<tr><td>"+credito.data[index].id+"</td><td>"+id+"</td><td>"+credito.data[index].cliente.display+"</td><td>"+credito.data[index].deuda+"</td><td>"+credito.data[index].cuota+"</td><td>"+credito.data[index].restante+"</td><td>"+credito.data[index].published+"</td></tr>");
                            pagar=credito.data[index].restante;
                            cliente=credito.data[index].cliente.id;
                            cliente_text=credito.data[index].cliente.display;
                            deuda=credito.data[index].deuda;
                            status=credito.data[index].status;
                        }
                        if(status==0){
                            $('#table_historial').append("<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><a onclick='nexttabs()' href='#cobro' aria-controls='cobro' role='tab' data-toggle='tab' class='btn btn-sm btn-dark' >Pagar Cuota</a></td></tr>");
                            $('#table_cobros tbody tr').remove();
                            $('#table_cobros').append("<tr><td>"+id+"</td><td>"+cliente_text+"</td><td>"+deuda+"</td><td>"+pagar+"</td></tr>");
                            $('#venta_id').val(id);
                            $('#cliente_id').val(cliente);
                            $('#cliente_text').val(cliente_text);
                            $('#deuda').val(deuda);
                            $('#restante').val(pagar);
                            
                        }
                    }
                }

                function nexttabs() {
                    $('.nav-tabs a[href="#cobro"]').tab('show')
                }
                async function ActualizarCredito() {
                    $('#table_cobros tbody tr').remove();
                    if($('#cuota_cobro').val()==0){
                        toastr.error("Error, revise que los datos ingresados sean correctos");
                    }
                    else{
                        var venta_id=$('#venta_id').val();
                        var cliente_id=$('#cliente_id').val();
                        var deuda=$('#deuda').val();
                        var cuota=$('#cuota_cobro').val();
                        var restante=parseFloat( $('#restante').val()).toFixed(2)-parseFloat($('#cuota_cobro').val()).toFixed(2);
                        if(restante<=0){
                            var status=1;
                            var venta_actualizada= await axios.get("{{setting('admin.url')}}api/pos/status_credito/actualizar/"+venta_id);
                            if(venta_actualizada){
                                toastr.success('Estado de Crédito en Venta Actualizado');
                            }
                        }
                        else{
                            var status=0;
                        }
                        var midata = JSON.stringify({'venta_id':venta_id,'cliente_id':cliente_id,'deuda':deuda,'cuota':cuota,'restante':restante,'status':status});

                        var table= await axios("{{setting('admin.url')}}api/pos/cobrar-credito/"+midata);
                        if(table){
                            toastr.success('Pago de Crédito Registrado');

                            if ($("input[name='season']:checked").val() == '0') {
                            var pagotext="En Linea";
                            }
                            if ($("input[name='season']:checked").val() == '1'){
                                var pagotext="En Efectivo";
                            }
                            var pago=$("input[name='season']:checked").val();
                            var micaja = JSON.parse(localStorage.getItem('micaja'));
                            var concepto = "Pago por cuota de Crédito de Venta: "+ $('#venta_id').val() +" del cliente: "+$('#cliente_text').val()+"";
                            var monto = $('#cuota_cobro').val();
                            var type = "Ingresos";
                            var caja_id = micaja.caja_id;
                            var editor_id = '{{ Auth::user()->id }}';
                            var midata = {caja_id: caja_id, type: type, monto: monto, editor_id: editor_id, concepto: concepto, pago:pago};
                            console.log(midata)
                            var asiento= await axios.post("{{setting('admin.url')}}api/pos/asiento/save", midata);
                            if(asiento){
                                toastr.success('Asiento registrado como: '+asiento.data.type);
                            }
                        }
                    }
                }

                async function LimpiarDeudasChofer() {
                    $('#micajas').find('option').remove().end();
                    $('#michoferes').find('option').remove().end();
                    $('#table_deudas tbody tr').remove();
                }

                async function LimpiarKardex(){
                    $('#sucursalpensionado').find('option').remove().end();
                    $('#cliente_consulta').find('option').remove().end();
                    $('#table-kardex tbody tr').remove();
                }

                async function LimpiarCobroCreditos() {
                    $('#table_consultas_cobros tbody tr').remove();
                    $('#table_historial tbody tr').remove();
                    $('#table_cobros tbody tr').remove();
                    $('#venta_id').val(0);
                    $('#cliente_id').val(0);
                    $('#cliente_text').val("");
                    $('#deuda').val(0);
                    $('#restante').val(0);
                    $('#cuota_cobro').val(0);
                    $('#sucursal_consulta').find('option').remove().end();
                    $('#cliente_consulta').find('option').remove().end();
                }

                function imprimir(){
                    const queryString = window.location.search;
                    const urlParams = new URLSearchParams(queryString);
                    location.href = '{{"setting('admin.url')"}}admin/afiliados/recepciones/imprimir?key='+urlParams.get('key')+'&s='+urlParams.get('s');
                }


            $('#caja_id').on('change', async function() {
                var midata1 = $("#date1").val()
                var midata2 = $("#date2").val()
                var caja_id = this.value
                var midata = JSON.stringify({
                    date1: midata1,
                    date2: midata2,
                    caja_id: caja_id
                })
                // console.log(midata1)
                var ventas = await axios("{{ setting('admin.url') }}api/pos/ventas/fechas/caja/"+midata)
                $('#report_table tbody tr').remove();
                if (ventas.data) {
                    $('#report_table').append("<tr><td>Total Ventas Bs: </td><td> "+ventas.data.total+"</td></tr>");
                    $('#report_table').append("<tr><td>Cantidad de Ventas: </td><td> "+ventas.data.cantidad+"</td></tr>");
                    $('#report_table').append("<tr><td>Pasarelas: </td><td> "+makeTableHTML(ventas.data.pasarelas)+"</td></tr>");
                    $('#report_table').append("<tr><td>Impuestos: </td><td> "+makeTableHTML(ventas.data.impuestos)+"</td></tr>");
                    $('#report_table').append("<tr><td>Delivery: </td><td> "+makeTableHTML(ventas.data.delivery)+"</td></tr>");
                    $('#report_table').append("<tr><td>Estados: </td><td> "+makeTableHTML(ventas.data.estados)+"</td></tr>");
                } else {
                    toastr.error('Ingresa fechas validas')
                }
                var midata2 = {
                    date1: midata1,
                    date2: midata2,
                    caja_id: caja_id
                }
                console.log(midata2)
                var ventas_list = await axios.post("{{ setting('admin.url') }}api/pos/ventas/fechas/caja/list", midata2)
                $('#report_list tbody tr').remove();
                console.log(ventas_list.data)
                for (let index = 0; index < ventas_list.data.length; index++) {
                    var midetalle_venta = '<ul>'
                    for (let j = 0; j < ventas_list.data[index].detalle_venta.length; j++) {
                        midetalle_venta += "<li>"+ventas_list.data[index].detalle_venta[j].cantidad+" "+ventas_list.data[index].detalle_venta[j].name+"</li>"
                    }
                    midetalle_venta += "</ul>"
                    $("#report_list").append("<tr><td>"+ventas_list.data[index].id+"</td><td>"+ventas_list.data[index].fecha+"</td><td>"+ventas_list.data[index].estado.title+"</td><td>"+ventas_list.data[index].pasarela.title+"</td><td>"+ventas_list.data[index].cliente.display+"</td><td>"+midetalle_venta+"</td><td>"+ventas_list.data[index].total+"</td></tr>");
                }
            });

            $('#register_id').on('change', async function() {
                var midata1 = $("#date1").val()
                var midata2 = $("#date2").val()
                var register_id = this.value
                var midata = JSON.stringify({
                    date1: midata1,
                    date2: midata2,
                    register_id: register_id
                })
                var ventas = await axios("{{ setting('admin.url') }}api/pos/ventas/fechas/editor/"+midata)
                $('#report_table tbody tr').remove();
                if (ventas.data) {
                    $('#report_table').append("<tr><td>Total Bs: </td><td> "+ventas.data.total+"</td></tr>");
                    $('#report_table').append("<tr><td>Cantidad: </td><td> "+ventas.data.cantidad+"</td></tr>");
                    $('#report_table').append("<tr><td>Pasarelas: </td><td> "+makeTableHTML(ventas.data.pasarelas)+"</td></tr>");
                    $('#report_table').append("<tr><td>Impuestos: </td><td> "+makeTableHTML(ventas.data.impuestos)+"</td></tr>");
                    $('#report_table').append("<tr><td>Delivery: </td><td> "+makeTableHTML(ventas.data.delivery)+"</td></tr>");
                    $('#report_table').append("<tr><td>Estados: </td><td> "+makeTableHTML(ventas.data.estados)+"</td></tr>");
                } else {
                    toastr.error('Ingresa fechas validas')
                }
            });

            function makeTableHTML(myArray) {
                var result = "<table border=0>";
                for(var i=0; i<myArray.length; i++) {
                    result += "<tr>";
                    for(var j=0; j<myArray[i].length; j++){
                        result += "<td>"+myArray[i][j]+"</td>";
                    }
                    result += "</tr>";
                }
                result += "</table>";
                return result;
            }

    </script>
@stop
