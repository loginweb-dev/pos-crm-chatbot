@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
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

                            <div class="form-group col-md-6">
                                <strong>Categoria</strong>
                                <select class="form-control js-example-basic-single" name="micategory" id="micategory"></select>
                            </div>

                            {{-- <div class="form-group col-md-6">
                                <strong>Presentacion</strong>
                                <select class="form-control js-example-basic-single" name="presentacion_producto" id="presentacion_producto"></select>
                            </div> --}}
                            @if(setting('empresa.type_negocio')=="Restaurante")
                                <div class="form-group col-md-6">
                                    <strong>Tipo Producto</strong>
                                    <select class="form-control js-example-basic-single" name="type_producto" id="type_producto"></select>
                                </div>
                            @endif
                            @if(setting('empresa.type_negocio')=="Farmacia")
                                <div class="form-group col-md-6">
                                    <strong>Laboratorio</strong>
                                    <select class="form-control js-example-basic-single" name="laboratorio_producto" id="laboratorio_producto"></select>
                                </div>
                            @endif
                            @if(setting('empresa.type_negocio')=="Ferreteria")
                                <div class="form-group col-md-6">
                                    <strong>Marca</strong>
                                    <select class="form-control js-example-basic-single" name="marca_producto" id="marca_producto"></select>
                                </div>
                                <div class="form-group col-md-6">
                                    <strong>Presentación</strong>
                                    <select class="form-control js-example-basic-single" name="presentacion_producto" id="presentacion_producto"></select>
                                </div>
                            @endif
                            <div class="form-group col-md-6">
                                <strong>Sucursal</strong>
                                <select class="form-control js-example-basic-single" name="misucursal" id="misucursal"></select>
                            </div>

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
                                    @if(isset($row->details->mitoolstip))
                                        <i class="voyager-info-circled" data-toggle="tooltip" rel="tooltip" title="{{ $row->details->mitoolstip }}"></i>
                                    @endif
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

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
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
@stop

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var params = {};
        var $file;

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

            Categorias()
            // TypeProductos()
            LaboratorioProducto()
            // PresentacionProducto()
            Sucursales()
        });

        async function Categorias() {
            // var id=parseInt("{{$dataTypeContent->getKey()}}")
            var table= await axios.get("{{setting('admin.url')}}api/pos/categorias_all")
            // var producto= await axios("{{setting('admin.url')}}api/pos/producto/"+id)
            // var categoria= await axios("{{setting('admin.url')}}api/pos/category/"+producto.data.categoria_id)
            $('#micategory').append($('<option>', {
                value: null,
                text: 'Elija una Categoria'
            }));
            for (let index = 0; index < table.data.length; index++) {
                // if(table.data[index].id!=producto.data.categoria_id){
                    $('#micategory').append($('<option>', {
                        value: table.data[index].id,
                        text: table.data[index].name
                    }));
                // }
            }
        }
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

        async function TypeProductos() {

        var id=parseInt("{{$dataTypeContent->getKey()}}")

        var producto= await axios("{{setting('admin.url')}}api/pos/producto/"+id)
        console.log(producto.data)
        var type= await axios("{{setting('admin.url')}}api/pos/typeproduct/"+producto.data.type_producto_id)
        var table= await axios.get("{{ setting('admin.url') }}api/pos/typeproductos")

        $('#type_producto').append($('<option>', {
            value: producto.data.type_producto_id,
            text: type.data.name
        }));
    for (let index = 0; index < table.data.length; index++) {
        if(table.data[index].id!=producto.data.type_producto_id){
            $('#type_producto').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].name
            }));
        }
    }
    }

    async function LaboratorioProducto() {
        var table= await axios.get("{{setting('admin.url')}}api/pos/laboratorios");
        $('#laboratorio_producto').append($('<option>', {
            value: null,
            text: 'Elige un Laboratorio'
        }));
        for (let index = 0; index < table.data.length; index++) {
            // const element = table.data[index];
            $('#laboratorio_producto').append($('<option>', {
                value: table.data[index].id,
                text: table.data[index].name
            }));
        }
    }
    async function PresentacionProducto(){
    var table= await axios.get("{{setting('admin.url')}}api/pos/presentaciones");

    // $('#presentacion_producto').append($('<option>', {
    //     value: null,
    //     text: 'Elige una Presentación'
    // }));
    for (let index = 0; index < table.data.length; index++) {
        // const element = table.data[index];
        $('#presentacion_producto').append($('<option>', {
            value: table.data[index].id,
            text: table.data[index].name
        }));
    }
    }

    async function MarcaProducto() {
    var table= await axios.get("{{setting('admin.url')}}api/pos/marcas");

    $('#marca_producto').append($('<option>', {
        value: null,
        text: 'Elige una Marca'
    }));
    for (let index = 0; index < table.data.length; index++) {
        const element = table.data[index];
        $('#marca_producto').append($('<option>', {
            value: table.data[index].id,
            text: table.data[index].name
        }));
    }
    }

    $('#micategory').on('change', function() {

    var category = $('#micategory').val();
    $('input[name="categoria_id"]').val(category);

    });

    $('#misucursal').on('change', function() {

    var sucursal = $('#misucursal').val();
    $('input[name="sucursal_id"]').val(sucursal);

    });

    $('#type_producto').on('change', function() {

    var type_producto_id = $('#type_producto').val();
    $('input[name="type_producto_id"]').val(type_producto_id);

    });

    $('#laboratorio_producto').on('change', function() {

    var laboratorio_producto = $('#laboratorio_producto').val();
    $('input[name="laboratorio_id"]').val(laboratorio_producto);

    });

    $('#presentacion_producto').on('change', function() {

    var presentacion_producto = $('#presentacion_producto').val();
    $('input[name="presentacion_id"]').val(presentacion_producto);

    });

    $('#marca_producto').on('change', function() {

    var marca_producto = $('#marca_producto').val();
    $('input[name="marca_id"]').val(marca_producto);

    });

    </script>
@stop
