@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

    @switch($dataType->getTranslatedAttribute('slug'))
        @case('cocinas')

            @break
        @case('ventas')

            @break

        @case('chatbots')
            @php
                $miuser = TCG\Voyager\Models\User::find(Auth::user()->id);
                $micajas = App\Caja::all();
            @endphp
            @section('page_header')
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <strong style="font-size: 30px;">
                            <i class="{{ $dataType->icon }}"></i>
                            CHATBOT
                        </strong>
                    </div>
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-4">
                    </div>

                </div>
            @stop
            @break

        @case('productions')
            @section('page_header')
                <br>
                <div class="row">
                    <div class="col-sm-8">
                        <strong style="font-size: 30px;">
                            <i class="{{ $dataType->icon }}"></i>
                            {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
                        </strong>
                    </div>

                    <div class="col-sm-4">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_save_prod">Guardar</button>
                            </div>
                    </div>

                </div>
            @stop
            @break


        @default
            @section('page_header')
                <h1 class="page-title">
                    <i class="{{ $dataType->icon }}"></i>
                    {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
                </h1>
                @include('voyager::multilingual.language-selector')
            @stop
    @endswitch



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

                        @switch($dataType->getTranslatedAttribute('slug'))
                            @case('cocinas')


                                @break
                            @case('ventas')


                            @case('productions')
                                <div class="form-group col-md-8">
                                    <label for="">Lista de Ingrediente</label>
                                    <div id="search-input">
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="proveedorelab"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="unidades"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="insumos"></select>
                                        </div>
                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single" id="prod_semi"></select>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-inverse table-responsive" id="miproduction">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>ID</th>
                                                <th>Insumo</th>
                                                <th>Proveedor</th>
                                                <th>Costo</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                                <th>Opciones</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                    </table>

                                </div>

                                <div class="form-group col-md-4">

                                    <div class="form-group col-sm-12">
                                        <label>Producto</label>
                                        <select class="form-control js-example-basic-single" id="new_producto_id"></select>
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
                                </div>
                                @break

                            @case('production-semis')
                                <div class="form-group col-md-8">


                                    <div id="search-input">

                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single"  id="proveedorsemi"></select>
                                        </div>

                                    </div>

                                    <div id="search-input">
                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single" id="unidadessemi"></select>
                                        </div>
                                        <div class="input-group col-md-6">
                                            <select class="form-control js-example-basic-single" id="insumossemi"></select>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-inverse table-responsive" id="miprodsemi">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>#</th>
                                                <th>Ítem</th>
                                                <th>Proveedor</th>
                                                <th>Costo</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                                <th>Opciones</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                    </table>
                                </div>

                                <div class="form-group col-md-4">
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
                                </div>
                                @break

                            @case('imports')
                                <div class="form-group col-sm-6">
                                    <h3>Elije una Opcion</h3>
                                    <p>La importacion se realizara con la opcion que elejiste y luego de enviar.</p>
                                    <hr>
                                    <h5>MODULO VENTAS</h5>
                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Clientes
                                        </label> -->
                                        <a href="{{ route('import.clientes') }}" class="btn btn-primary">Clientes</a>
                                        <br>
                                    <!-- </div> -->
                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Productos
                                        </label> -->
                                        <a href="{{ route('import.products') }}" class="btn btn-primary btn-sm">Productos</a>
                                        <br>
                                    <!-- </div> -->
                                    <!-- <div class="form-check"> -->
                                        <a href="{{ route('import.ventas') }}" class="btn btn-primary btn-sm">Ventas</a>
                                    <!-- </div> -->
                                    <hr>
                                    <h5>MODULO PRODUCCION</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" disabled>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Insumos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Proveedores
                                        </label>
                                    </div>
                                </div>

                            @break
                            @case('compras')

                                {{-- <div class="form-group col-md-6">
                                    <div id="search-input">

                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="proveedores_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="unidades_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="insumos_compras"> </select>
                                        </div>


                                    </div>

                                </div> --}}

                                <div class="form-group col-md-12">

                                    <div id="search-input">

                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="proveedores_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="unidades_compras"> </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control js-example-basic-single" id="insumos_compras"> </select>
                                        </div>


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
                                </div>

                            @break

                            @case('productos')

                                @break
                            @case('chatbots')
                                <div class="form-group col-sm-5">
                                    @php
                                        $clientes = App\Cliente::orderBy('created_at', 'asc')->get();
                                    @endphp
                                    <h4 class="title">Cliente</h4>
                                    <select id="micliente" class="form-control">
                                        <option> Elije una Cliente</option>
                                        @foreach ($clientes as $item)
                                            <option value="{{ $item->phone }}"> {{ $item->display }}</option>
                                        @endforeach
                                    </select>
                                    @php
                                        $productos = App\Producto::where('ecommerce', true)->orderBy('name', 'asc')->get();
                                    @endphp
                                    <h4 class="title">Producto</h4>
                                    <select id="product" class="form-control">
                                        <option> Elije una Producto</option>
                                        @foreach ($productos as $item)
                                        <option value="{{ $item->id }}">{{ $item->categoria->name }} - {{ $item->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-7">
                                    <h4 class="title">CHAT - <small>Copia y Pega los Emojis!</small>
                                        <br />
                                        <a class="btn btn-sm btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Smileys
                                        </a>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">Gestures</button>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">People</button>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4">Clothing</button>
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample5" aria-expanded="false" aria-controls="collapseExample5">Objects</button>

                                    </h4>
                                    <div class="collapse multi-collapse" id="collapseExample">
                                        😀 😃 😄 😁 😆 😅 😂 🤣 🥲 ☺️ 😊 😇 🙂 🙃 😉 😌 😍 🥰 😘 😗 😙 😚 😋 😛 😝 😜 🤪 🤨 🧐 🤓 😎 🥸 🤩 🥳 😏 😒 😞 😔 😟 😕 🙁 ☹️ 😣 😖 😫 😩 🥺 😢 😭 😤 😠 😡 🤬 🤯 😳 🥵 🥶 😱 😨 😰 😥 😓 🤗 🤔 🤭 🤫 🤥 😶 😐 😑 😬 🙄 😯 😦 😧 😮 😲 🥱 😴 🤤 😪 😵 🤐 🥴 🤢 🤮 🤧 😷 🤒 🤕 🤑 🤠 😈 👿 👹 👺 🤡 💩 👻 💀 ☠️ 👽 👾 🤖 🎃 😺 😸 😹 😻 😼 😽 🙀 😿 😾
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample2">
                                        👋 🤚 🖐 ✋ 🖖 👌 🤌 🤏 ✌️ 🤞 🤟 🤘 🤙 👈 👉 👆 🖕 👇 ☝️ 👍 👎 ✊ 👊 🤛 🤜 👏 🙌 👐 🤲 🤝 🙏 ✍️ 💅 🤳 💪 🦾 🦵 🦿 🦶 👣 👂 🦻 👃 🫀 🫁 🧠 🦷 🦴 👀 👁 👅 👄 💋 🩸
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample3">
                                        👶 👧 🧒 👦 👩 🧑 👨 👩‍🦱 🧑‍🦱 👨‍🦱 👩‍🦰 🧑‍🦰 👨‍🦰 👱‍♀️ 👱 👱‍♂️ 👩‍🦳 🧑‍🦳 👨‍🦳 👩‍🦲 🧑‍🦲 👨‍🦲 🧔 👵 🧓 👴 👲 👳‍♀️ 👳 👳‍♂️ 🧕 👮‍♀️ 👮 👮‍♂️ 👷‍♀️ 👷 👷‍♂️ 💂‍♀️ 💂 💂‍♂️ 🕵️‍♀️ 🕵️ 🕵️‍♂️ 👩‍⚕️ 🧑‍⚕️ 👨‍⚕️ 👩‍🌾 🧑‍🌾 👨‍🌾 👩‍🍳 🧑‍🍳 👨‍🍳 👩‍🎓 🧑‍🎓 👨‍🎓 👩‍🎤 🧑‍🎤 👨‍🎤 👩‍🏫 🧑‍🏫 👨‍🏫 👩‍🏭 🧑‍🏭 👨‍🏭 👩‍💻 🧑‍💻 👨‍💻 👩‍💼 🧑‍💼 👨‍💼 👩‍🔧 🧑‍🔧 👨‍🔧 👩‍🔬 🧑‍🔬 👨‍🔬 👩‍🎨 🧑‍🎨 👨‍🎨 👩‍🚒 🧑‍🚒 👨‍🚒 👩‍✈️ 🧑‍✈️ 👨‍✈️ 👩‍🚀 🧑‍🚀 👨‍🚀 👩‍⚖️ 🧑‍⚖️ 👨‍⚖️ 👰‍♀️ 👰 👰‍♂️ 🤵‍♀️ 🤵 🤵‍♂️ 👸 🤴 🥷 🦸‍♀️ 🦸 🦸‍♂️ 🦹‍♀️ 🦹 🦹‍♂️ 🤶 🧑‍🎄 🎅 🧙‍♀️ 🧙 🧙‍♂️ 🧝‍♀️ 🧝 🧝‍♂️ 🧛‍♀️ 🧛 🧛‍♂️ 🧟‍♀️ 🧟 🧟‍♂️ 🧞‍♀️ 🧞 🧞‍♂️ 🧜‍♀️ 🧜 🧜‍♂️ 🧚‍♀️ 🧚 🧚‍♂️ 👼 🤰 🤱 👩‍🍼 🧑‍🍼 👨‍🍼 🙇‍♀️ 🙇 🙇‍♂️ 💁‍♀️ 💁 💁‍♂️ 🙅‍♀️ 🙅 🙅‍♂️ 🙆‍♀️ 🙆 🙆‍♂️ 🙋‍♀️ 🙋 🙋‍♂️ 🧏‍♀️ 🧏 🧏‍♂️ 🤦‍♀️ 🤦 🤦‍♂️ 🤷‍♀️ 🤷 🤷‍♂️ 🙎‍♀️ 🙎 🙎‍♂️ 🙍‍♀️ 🙍 🙍‍♂️ 💇‍♀️ 💇 💇‍♂️ 💆‍♀️ 💆 💆‍♂️ 🧖‍♀️ 🧖 🧖‍♂️ 💅 🤳 💃 🕺 👯‍♀️ 👯 👯‍♂️ 🕴 👩‍🦽 🧑‍🦽 👨‍🦽 👩‍🦼 🧑‍🦼 👨‍🦼 🚶‍♀️ 🚶 🚶‍♂️ 👩‍🦯 🧑‍🦯 👨‍🦯 🧎‍♀️ 🧎 🧎‍♂️ 🏃‍♀️ 🏃 🏃‍♂️ 🧍‍♀️ 🧍 🧍‍♂️ 👭 🧑‍🤝‍🧑 👬 👫 👩‍❤️‍👩 💑 👨‍❤️‍👨 👩‍❤️‍👨 👩‍❤️‍💋‍👩 💏 👨‍❤️‍💋‍👨 👩‍❤️‍💋‍👨 👪 👨‍👩‍👦 👨‍👩‍👧 👨‍👩‍👧‍👦 👨‍👩‍👦‍👦 👨‍👩‍👧‍👧 👨‍👨‍👦 👨‍👨‍👧 👨‍👨‍👧‍👦 👨‍👨‍👦‍👦 👨‍👨‍👧‍👧 👩‍👩‍👦 👩‍👩‍👧 👩‍👩‍👧‍👦 👩‍👩‍👦‍👦 👩‍👩‍👧‍👧 👨‍👦 👨‍👦‍👦 👨‍👧 👨‍👧‍👦 👨‍👧‍👧 👩‍👦 👩‍👦‍👦 👩‍👧 👩‍👧‍👦 👩‍👧‍👧 🗣 👤 👥 🫂
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample4">
                                        🧳 🌂 ☂️ 🧵 🪡 🪢 🧶 👓 🕶 🥽 🥼 🦺 👔 👕 👖 🧣 🧤 🧥 🧦 👗 👘 🥻 🩴 🩱 🩲 🩳 👙 👚 👛 👜 👝 🎒 👞 👟 🥾 🥿 👠 👡 🩰 👢 👑 👒 🎩 🎓 🧢 ⛑ 🪖 💄 💍 💼
                                    </div>
                                    <div class="collapse multi-collapse" id="collapseExample5">
                                        ⌚️ 📱 📲 💻 ⌨️ 🖥 🖨 🖱 🖲 🕹 🗜 💽 💾 💿 📀 📼 📷 📸 📹 🎥 📽 🎞 📞 ☎️ 📟 📠 📺 📻 🎙 🎚 🎛 🧭 ⏱ ⏲ ⏰ 🕰 ⌛️ ⏳ 📡 🔋 🔌 💡 🔦 🕯 🪔 🧯 🛢 💸 💵 💴 💶 💷 🪙 💰 💳 💎 ⚖️ 🪜 🧰 🪛 🔧 🔨 ⚒ 🛠 ⛏ 🪚 🔩 ⚙️ 🪤 🧱 ⛓ 🧲 🔫 💣 🧨 🪓 🔪 🗡 ⚔️ 🛡 🚬 ⚰️ 🪦 ⚱️ 🏺 🔮 📿 🧿 💈 ⚗️ 🔭 🔬 🕳 🩹 🩺 💊 💉 🩸 🧬 🦠 🧫 🧪 🌡 🧹 🪠 🧺 🧻 🚽 🚰 🚿 🛁 🛀 🧼 🪥 🪒 🧽 🪣 🧴 🛎 🔑 🗝 🚪 🪑 🛋 🛏 🛌 🧸 🪆 🖼 🪞 🪟 🛍 🛒 🎁 🎈 🎏 🎀 🪄 🪅 🎊 🎉 🎎 🏮 🎐 🧧 ✉️ 📩 📨 📧 💌 📥 📤 📦 🏷 🪧 📪 📫 📬 📭 📮 📯 📜 📃 📄 📑 🧾 📊 📈 📉 🗒 🗓 📆 📅 🗑 📇 🗃 🗳 🗄 📋 📁 📂 🗂 🗞 📰 📓 📔 📒 📕 📗 📘 📙 📚 📖 🔖 🧷 🔗 📎 🖇 📐 📏 🧮 📌 📍 ✂️ 🖊 🖋 ✒️ 🖌 🖍 📝 ✏️ 🔍 🔎 🔏 🔐 🔒 🔓
                                    </div>
                                    <textarea class="form-control" name="" id="mimensaje" rows="8"></textarea>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="option1" name="gender" value="option1" checked>
                                        <span class="form-check-label"> Texto </span>
                                    </label>
                                    {{-- <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="option2" name="gender" value="option2">
                                        <span class="form-check-label"> Imagen </span>
                                    </label> --}}
                                    <br>
                                    <a href="#" onclick="send_whatsapp()" class="btn btn-sm btn-primary">Enviar</a>
                                </div>
                                @break
                            @default
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

                        @endswitch

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @switch($dataType->getTranslatedAttribute('slug'))
                                @case('cocinas')

                                @break
                                @case('ventas')

                                @break

                                @case('imports')

                                @break
                                @case('chatbots')

                                @break
                                @case('productions')
                                    <!-- <a class="btn btn-primary" href="#" onclick="saveproductions()">Guardar</a> -->
                                    @break

                                @case('production-semis')
                                    <a class="btn btn-primary" href="#" onclick="saveproductionssemi()">Guardar</a>
                                    @break

                                @default
                                    @section('submit-buttons')
                                        <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                    @stop
                                    @yield('submit-buttons')
                            @endswitch
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


    <!-- -------------------MODALES----------------------- -->
    <!-- -------------------MODALES----------------------- -->
    @switch($dataType->getTranslatedAttribute('slug'))
        @case('ventas')

            @break

        @case('productions')
            <div class="modal fade modal-primary" id="modal_save_prod">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                        </div>

                        <div class="modal-body">
                            <h4>¿Estás seguro que quieres guardar ?</h4>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                            <button type="button" class="btn btn-primary" onclick="saveproductions()">SI</button>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @default
            <div class="modal fade modal-danger" id="confirm_delete_modal">
                <div class="modal-dialog modal-sm">
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

    @endswitch



@stop


<!-- -------------------CARGADO DE JS----------------------- -->
<!-- -------------------CARGADO DE JS----------------------- -->

@switch($dataType->getTranslatedAttribute('slug'))
    @case('chatbots')
        @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                const socket_ventas = "{{ setting('notificaciones.venta') }}";
                const socket_cocina = "{{ setting('notificaciones.cocina') }}";

                async function send_whatsapp() {

                    var phone = $('#micliente').val()
                    var message = $('#mimensaje').val()
                    console.log(phone)
                    console.log(message)
                    var send = await axios.get("{{ setting('notificaciones.url_chatbot') }}?phone="+phone+"&type=text"+"&message="+message)
                    toastr.success('Mensaje Enviado')
                }
            </script>
        @stop
    @break
    @case('cocinas')

    @break

    @case('ventas')

    @break
    @case('productions')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>

                //  AL CARGAR LA VISTA
                $('document').ready(async function () {

                    $('.js-example-basic-single').select2();
                    $('input[name="user_id"]').val('{{ Auth::user()->id }}');

                    // PRODUCTOS PRE ELABORADO
                    InsumosSemi();


                    // PRODUCTOS PARA PRODUCCION
                    ProductosProduction();


                    // CARGADO DE SESSION INSUMOS
                    if (localStorage.getItem('miproduction')) {
                        var milistProduction = JSON.parse(localStorage.getItem('miproduction'));
                        for (var index = 0; index < milistProduction.length; index++) {

                            $("#miproduction").append("<tr id="+milistProduction[index].cod+"><td>"+milistProduction[index].cod+"</td><td>"+milistProduction[index].type+"</td><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' min='1' onclick='updatemiproduction("+milistProduction[index].id+")' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' min='1' onclick='updatemiproduction("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+milistProduction[index].cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                            mitotal2();
                        }
                    } else {
                        localStorage.setItem('miproduction', JSON.stringify([]));
                    }

                    //Crear variable miprodsemi
                    if (localStorage.getItem('miprodsemi')) {
                        var milistProduction = JSON.parse(localStorage.getItem('miprodsemi'));
                        for (var index = 0; index < milistProduction.length; index++) {

                            $("#miprodsemi").append("<tr id="+milistProduction[index].id+"><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproductionsemi("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+milistProduction[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                            mitotal3();
                        }
                    } else {
                        localStorage.setItem('miprodsemi', JSON.stringify([]));
                    }

                    // TODOS LOS INSUMOS

                    insumos();



                    Unidades();


                    //PROVEDORES
                    ProveedoresProduction();



                });

                async function ProveedoresProduction() {
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/proveedores");
                    // $('#proveedorelab').append($('<option>', {
                    //     value: null,
                    //     text: 'Elige un Proveedor'
                    // }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#proveedorelab').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                async function InsumosSemi(){
                    var table = await axios.get("{{ setting('admin.url') }}api/pos/productosemi");

                    $('#prod_semi').append($('<option>', {
                        value: null,
                        text: 'Elige un Pre Elaborado'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#prod_semi').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }

                }

                async function ProductosProduction(){
                    var table = await axios.get("{{ setting('admin.url') }}api/pos/productos/production");

                     $('#new_producto_id').append($('<option>', {
                        value: null,
                        text: 'Elige un Producto'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        $('#new_producto_id').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].categoria.name+' '+table.data[index].name
                        }));
                    }
                }

                // async function unidad_name(id){
                //        var table= await axios("{{ setting('admin.url') }}api/pos/unidades/"+id);
                //        var unidad= table.data.name
                //        var prueba=1;
                //        console.log(prueba);
                //        return prueba;
                //     }

                async function insumos(){

                    var insumo=await axios("{{ setting('admin.url') }}api/pos/insumos");
                    //var unidad= await axios("{{ setting('admin.url') }}api/pos/unidades/"+id);

                    $('#insumos').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < insumo.data.length; index++) {
                        const element = insumo.data[index];
                        $('#insumos').append($('<option>', {
                            value: insumo.data[index].id,
                            //text: unidad_name(insumo.data[index].unidad_id) + ' de '+ insumo.data[index].name
                            //console.log(unidad_name(insumo.data[index].unidad_id));
                            text:insumo.data[index].name
                        }));
                    }

                }

                // ADD INSUMO PRE ELEBORADO
                $('#prod_semi').on('change', function() {

                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var mirep = false;
                    var thisvalue = this.options[this.selectedIndex].text;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].name == thisvalue){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {
                        toastr.warning(thisvalue+ 'Elaborado Repetido');
                    }else{
                        AgregarInsumoPre(this.value);

                    }
                });
                async function AgregarInsumoPre(id){
                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));

                    var idpro = $('#proveedorelab').val();
                    var miprotext = $('#proveedorelab option:selected').text();

                    var jchavez= await axios.get("{{ setting('admin.url') }}api/pos/productopreid/"+id);
                    var cod = Math.floor(Math.random() * 999) + 800;

                    if('{{setting('ventas.stock')}}'){
                        if(jchavez.data.stock>=1){

                        $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>elaborado</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' max='"+jchavez.data.stock+"' onclick='updatemiproduction("+jchavez.data.id+")' value='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                        var temp = {'cod': cod, 'type': 'elaborado', 'idpro' :idpro,'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                        miproduction.push(temp);
                        localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        mitotal2();
                        toastr.success('Agreado Insumo: '+jchavez.data.name);
                        }
                        else{
                            toastr.error("No existe el producto: "+jchavez.data.name +" en Stock");
                        }
                    }
                    else{
                        $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>elaborado</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.data.id+")' value='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                        var temp = {'cod': cod, 'type': 'elaborado', 'idpro' :idpro,'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                        miproduction.push(temp);
                        localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        mitotal2();
                        toastr.success('Agreado Insumo: '+jchavez.data.name);
                    }
                }

                $('#new_producto_id').on('change', function() {
                    $("input[name='producto_id']").val(this.value);
                    toastr.success('Producto Establecido');
                });

                function mitotal2() {
                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var total = 0
                    for (let index = 0; index < miproduction.length; index++) {
                        total = total + miproduction[index].total;
                    }
                    $("input[name='valor']").val(parseFloat(total).toFixed(2));
                }
                function mitotal3() {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var total = 0
                    for (let index = 0; index < miproduction.length; index++) {
                        total = total + miproduction[index].total;
                    }
                    $("input[name='valor']").val(parseFloat(total).toFixed(2));
                }

                async function Unidades(){
                    var table= await axios.get("{{ setting('admin.url') }}api/pos/unidades");

                    $('#unidades').append($('<option>', {
                        value: null,
                        text: 'Elige una Unidad'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#unidades').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].title
                        }));
                    }

                }

                $('#unidades').on('change', function() {
                    InsumosPorUnidad(this.value);

                });

                async function InsumosPorUnidad(id){

                    var table= await axios.get("{{ setting('admin.url') }}api/pos/insumo/unidad/"+id);
                    $('#insumos').find('option').remove().end();
                    $('#insumos').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#insumos').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }
                }

                $('#unidadessemi').on('change', function() {
                    InsumosPorUnidadSemi(this.value);

                });

                async function InsumosPorUnidadSemi(id){
                    var table = await axios.get("{{ setting('admin.url') }}api/pos/insumo/unidad/"+id);
                    $('#insumossemi').find('option').remove().end();
                    $('#insumossemi').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < table.data.length; index++) {
                        const element = table.data[index];
                        $('#insumossemi').append($('<option>', {
                            value: table.data[index].id,
                            text: table.data[index].name
                        }));
                    }

                }

                // ADD INSUMO SIMPLE
                $('#insumos').on('change', function() {

                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var mirep = false;
                    var thisvalue = this.options[this.selectedIndex].text;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].name == thisvalue){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {
                        toastr.warning('Insumo Repetido');
                    }else{
                        AgregarInsumoSimple(this.value);

                    }
                });

                async function AgregarInsumoSimple(id){
                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));

                    var idpro = $('#proveedorelab').val();
                    var miprotext = $('#proveedorelab option:selected').text();

                    var jchavez= await axios.get("{{ setting('admin.url') }}api/pos/insumos/"+id);
                    var cod = Math.floor(Math.random() * 999) + 800;

                    if('{{setting('ventas.stock')}}'){
                        if(jchavez.data.stock>=1){

                            $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>simple</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproduction("+jchavez.data.id+")' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' max='"+jchavez.data.stock+"' type='number' onclick='updatemiproduction("+jchavez.data.id+")' value='1' min='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' min='0' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                            var temp = {'cod': cod, 'type': 'simple', 'idpro' :idpro, 'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                            miproduction.push(temp);
                            localStorage.setItem('miproduction', JSON.stringify(miproduction));
                            mitotal2();
                            toastr.success('Agregado Insumo: '+jchavez.data.name);
                        }
                        else{
                            toastr.error("No existe el producto: "+jchavez.data.name +" en Stock");

                        }
                    }
                    else{
                        $("#miproduction").append("<tr id="+cod+"><td>"+cod+"</td><td>simple</td><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproduction("+jchavez.data.id+")' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' onclick='updatemiproduction("+jchavez.data.id+")' value='1' min='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' min='0' type='number' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumo("+cod+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                        var temp = {'cod': cod, 'type': 'simple', 'idpro' :idpro, 'id': jchavez.data.id, 'name': jchavez.data.name, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                        miproduction.push(temp);
                        localStorage.setItem('miproduction', JSON.stringify(miproduction));
                        mitotal2();
                        toastr.success('Agregado Insumo: '+jchavez.data.name);
                    }
                }

                $('#insumossemi').on('change', function() {
                    addinsumosemi(this.value);
                });

                function addinsumosemi(id) {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var mirep = false;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].id == id){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {

                    }else{
                        AgregarInsumoSimpleSemi(id);

                    }
                }

                async function AgregarInsumoSimpleSemi(id){

                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));

                    var mipro = $('#proveedorsemi').val();
                    var miprotext = $('#proveedorsemi option:selected').text();

                    var jchavez= await axios.get("{{ setting('admin.url') }}api/pos/insumos/"+id);

                    $("#miprodsemi").append("<tr id="+jchavez.data.id+"><td>"+jchavez.data.id+"</td><td>"+jchavez.data.name+"</td><td>"+miprotext +"</td><td><input class='form-control' min='0' type='number' onclick='updatemiproductionsemi("+jchavez.data.id+")' value='"+jchavez.data.costo+"' id='costo_"+jchavez.data.id+"' ></td><td><input class='form-control' type='number' min='1' onclick='updatemiproductionsemi("+jchavez.data.id+")' value='1' min='1' id='cant_"+jchavez.data.id+"'></td><td><input class='form-control' type='number' min='0' value='"+jchavez.data.costo+"' id='total_"+jchavez.data.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.data.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");


                    var temp = {'id': jchavez.data.id, 'name': jchavez.data.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.data.costo, 'cant': 1, 'total': jchavez.data.costo};
                    miproduction.push(temp);
                    localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                    mitotal3();
                }

                // DELETE FROM PRODUCTION
                function mideleteInsumo(id) {
                    // console.log(id);

                    $("#miproduction tr#"+id).remove();
                    var milist = JSON.parse(localStorage.getItem('miproduction'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].cod == id) {
                            toastr.success(milist[index].name+' eliminado');
                        } else {
                            var temp = {'cod': milist[index].cod, 'type': milist[index].type, 'idpro' :milist[index].idpro, 'id': milist[index].id, 'name': milist[index].name, 'proveedor_text': milist[index].proveedor_text, 'costo': milist[index].costo, 'cant': milist[index].cant, 'total': milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miproduction', JSON.stringify(newlist));
                    mitotal2();
                }

                function mideleteInsumosemi(id) {
                    $("#miprodsemi tr#"+id).remove();
                    var milist = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {

                        } else {
                            var temp = {'id': milist[index].id, 'name': milist[index].name,'proveedor':milist[index].proveedor, 'costo': milist[index].costo, 'cant': milist[index].cant, 'total': milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                function updatemiproduction(id) {

                    var total = parseFloat($("#costo_"+id).val()).toFixed(2) * parseFloat($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                    var newlist = [];
                    for (let index = 0; index < miproduction.length; index++) {
                        if (miproduction[index].id == id) {
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name, 'proveedor': miproduction[index].proveedor,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miproduction', JSON.stringify(newlist));
                    mitotal2();

                }

                function updatemiproductionsemi(id) {

                    var total = parseFloat($("#costo_"+id).val()).toFixed(2) * parseFloat($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < miproduction.length; index++) {
                        if (miproduction[index].id == id) {
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'cod':miproduction[index].cod,'type':miproduction[index].type,'idpro':miproduction[index].idpro,'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                //SAVE PRODUCCION
                function saveproductions() {

                    var producto_id = $("input[name='producto_id']").val();
                    var cantidad = $("input[name='cantidad']").val();
                    var valor = $("input[name='valor']").val();
                    var description = $("textarea[name='description']").val();
                    var user_id = $("input[name='user_id']").val();

                    var midata = JSON.stringify({'producto_id': producto_id, 'cantidad': cantidad, 'valor': valor, 'description': description, 'user_id': user_id });
                    var urli = "{{ setting('admin.url') }}api/pos/productions/save/"+midata;
                    //var urli=0;
                    $.ajax({
                        url: urli,
                        success: function (response) {
                            var miproduction = JSON.parse(localStorage.getItem('miproduction'));
                            for (let index = 0; index < miproduction.length; index++) {
                                console.log(miproduction[index].type);
                                var midata = JSON.stringify({'type': miproduction[index].type, 'production_id': response, 'insumo_id': miproduction[index].id, 'proveedor_id': miproduction[index].idpro, 'precio': miproduction[index].costo, 'cantidad': miproduction[index].cant, 'total': miproduction[index].total});
                                var urli = "{{ setting('admin.url') }}api/pos/productions/save/detalle/"+midata;
                                $.ajax({
                                    url: urli,
                                    success: function () {
                                        $("#miproduction tr#"+ miproduction[index].cod).remove();
                                        mitotal2();
                                    }
                                });

                            }
                            localStorage.setItem('miproduction', JSON.stringify([]));
                            // location.reload();
                            $('#modal_save_prod').modal('hide');

                        }
                    });

                    toastr.success('Producion Registrada');
                }

                function saveproductionssemi() {

                    var producto_semi_id = $("select[name='producto_semi_id']").val();
                    var cantidad = $("input[name='cantidad']").val();
                    var valor = $("input[name='valor']").val();
                    var description = $("textarea[name='description']").val();
                    var user_id = $("input[name='user_id']").val();

                    var midata = JSON.stringify({'producto_semi_id': producto_semi_id, 'cantidad': cantidad, 'valor': valor, 'description': description, 'user_id': user_id });
                    // console.log(midata)
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/productions/savesemi/"+midata,
                        success: function (response) {
                            var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));

                            for (let index = 0; index < miproduction.length; index++) {

                                var midata = JSON.stringify({'production_semi_id': response, 'insumo_id': miproduction[index].id, 'proveedor_id': miproduction[index].proveedor, 'precio': miproduction[index].costo, 'cantidad': miproduction[index].cant, 'total': miproduction[index].total});

                                $.ajax({
                                    url: "{{ setting('admin.url') }}api/pos/productions/savesemi/detalle/"+midata,
                                    success: function () {

                                    }
                                });
                            }
                            localStorage.setItem('miprodsemi', JSON.stringify([]));
                            location.href='{{ setting('admin.url') }}admin/production-semis';
                        }
                    });


                }
            </script>
        @stop
    @break
    @case('production-semis')
        @section('javascript')
            <script>
                // LOAD VIEW
                $('document').ready(function () {

                    $('.js-example-basic-single').select2();
                    $('input[name="user_id"]').val('{{ Auth::user()->id }}');


                    //Crear variable miprodsemi
                    if (localStorage.getItem('miprodsemi')) {
                        var milistProduction = JSON.parse(localStorage.getItem('miprodsemi'));
                        for (var index = 0; index < milistProduction.length; index++) {

                            $("#miprodsemi").append("<tr id="+milistProduction[index].id+"><td>"+milistProduction[index].id+"</td><td>"+milistProduction[index].name+"</td><td>"+milistProduction[index].proveedor_text+"</td><td><input class='form-control' type='number' min='0' value='"+milistProduction[index].costo+"' id='costo_"+milistProduction[index].id+"' ></td><td><input class='form-control' type='number' min='1' onclick='updatemiproductionsemi("+milistProduction[index].id+")' value='"+milistProduction[index].cant+"' id='cant_"+milistProduction[index].id+"'></td><td><input class='form-control' type='number' min='0' value='"+milistProduction[index].total+"' id='total_"+milistProduction[index].id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+milistProduction[index].id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");
                            mitotal3();
                        }
                    } else {
                        localStorage.setItem('miprodsemi', JSON.stringify([]));
                    }


                    // TODOS LOS INSUMOS SEMI
                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/insumos",
                            dataType: "json",
                            success: function (response) {
                                $('#insumossemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Insumo'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#insumossemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].name
                                    }));
                                }
                            }
                        });

                    //--------------------------------
                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/unidades",
                            dataType: "json",
                            success: function (response) {
                                $('#unidadessemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige una Unidad'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#unidadessemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].title
                                    }));
                                }
                            }
                        });

                    //--------------
                    $.ajax({
                            url: "{{ setting('admin.url') }}api/pos/proveedores",
                            dataType: "json",
                            success: function (response) {
                                $('#proveedorsemi').append($('<option>', {
                                    value: null,
                                    text: 'Elige un Proveedor'
                                }));
                                for (let index = 0; index < response.length; index++) {
                                    const element = response[index];
                                    $('#proveedorsemi').append($('<option>', {
                                        value: response[index].id,
                                        text: response[index].name
                                    }));
                                }
                            }
                        });

                });


                // FUNCIONES

                $('#unidadessemi').on('change', function() {
                    $.ajax({
                        type: "get",
                        url: "{{ setting('admin.url') }}api/pos/insumo/unidad/"+this.value,
                        dataType: "json",
                        success: function (response) {
                            $('#insumossemi').find('option').remove().end();
                            $('#insumossemi').append($('<option>', {
                                value: null,
                                text: 'Elige un Insumo'
                            }));
                            for (let index = 0; index < response.length; index++) {
                                const element = response[index];
                                $('#insumossemi').append($('<option>', {
                                    value: response[index].id,
                                    text: response[index].name
                                }));
                            }
                        }
                    });
                });

                function mitotal3() {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var total = 0
                    for (let index = 0; index < miproduction.length; index++) {
                        total = total + miproduction[index].total;
                    }
                    $("input[name='valor']").val(parseFloat(total).toFixed(2));
                }


                //Agregar

                $('#insumossemi').on('change', function() {
                    addinsumosemi(this.value);
                });

                function addinsumosemi(id) {
                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var mirep = false;
                    for (let index = 0; index < miproduction.length; index++) {
                        if(miproduction[index].id == id){
                            mirep = true;
                            break;
                        }
                    }
                    if (mirep) {

                    }else{
                        var mipro = $('#proveedorsemi').val();
                        var miprotext = $('#proveedorsemi option:selected').text();
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/insumos/"+id,
                        dataType: "json",
                        success: function (jchavez) {



                            if('{{setting('ventas.stock')}}'){
                                if(jchavez.stock>=1){
                                    $("#miprodsemi").append("<tr id="+jchavez.id+"><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproductionsemi("+jchavez.id+")' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' min='1' max='"+jchavez.stock+"' onclick='updatemiproductionsemi("+jchavez.id+")' value='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' min='0' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                                    var temp = {'id': jchavez.id, 'name': jchavez.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                                    miproduction.push(temp);
                                    localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                                    mitotal3();
                                }
                                else{
                                    toastr.error("No existe el producto: "+jchavez.name +" en Stock");
                                }
                            }
                            else{
                                $("#miprodsemi").append("<tr id="+jchavez.id+"><td>"+jchavez.id+"</td><td>"+jchavez.name+"</td><td>"+miprotext +"</td><td><input class='form-control' type='number' min='0' onclick='updatemiproductionsemi("+jchavez.id+")' value='"+jchavez.costo+"' id='costo_"+jchavez.id+"' ></td><td><input class='form-control' type='number' min='1'  onclick='updatemiproductionsemi("+jchavez.id+")' value='1' id='cant_"+jchavez.id+"'></td><td><input class='form-control' type='number' min='0' value='"+jchavez.costo+"' id='total_"+jchavez.id+"' readonly></td><td><a href='#' class='btn btn-sm btn-danger' onclick='mideleteInsumosemi("+jchavez.id+")'><i class='voyager-trash'></i>Quitar</a></td></tr>");

                                var temp = {'id': jchavez.id, 'name': jchavez.name,'proveedor': mipro, 'proveedor_text': miprotext, 'costo': jchavez.costo, 'cant': 1, 'total': jchavez.costo};
                                miproduction.push(temp);
                                localStorage.setItem('miprodsemi', JSON.stringify(miproduction));
                                mitotal3();
                            }


                            }
                        });
                    }
                }

                //Eliminar
                function mideleteInsumosemi(id) {
                    $("#miprodsemi tr#"+id).remove();
                    var milist = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < milist.length; index++) {
                        if (milist[index].id == id) {

                        } else {
                            var temp = {'id': milist[index].id, 'name': milist[index].name,'proveedor':milist[index].proveedor,'proveedor_text':milist[index].proveedor_text , 'costo': milist[index].costo, 'cant': milist[index].cant, 'total': milist[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                //Actualizar
                function updatemiproductionsemi(id) {

                    var total = parseFloat($("#costo_"+id).val()).toFixed(2) * parseFloat($("#cant_"+id).val());
                    $("#total_"+id).val(parseFloat(total).toFixed(2));

                    var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));
                    var newlist = [];
                    for (let index = 0; index < miproduction.length; index++) {
                        if (miproduction[index].id == id) {
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'proveedor_text':milist[index].proveedor_text, 'costo': parseFloat($("#costo_"+id).val()), 'cant': parseFloat($("#cant_"+id).val()), 'total': total};
                            newlist.push(temp);
                        }else{
                            var temp = {'id': miproduction[index].id, 'name': miproduction[index].name,'proveedor': miproduction[index].proveedor, 'proveedor_text':milist[index].proveedor_text,'costo': miproduction[index].costo, 'cant': miproduction[index].cant, 'total': miproduction[index].total};
                            newlist.push(temp);
                        }
                    }
                    localStorage.setItem('miprodsemi', JSON.stringify(newlist));
                    mitotal3();

                }

                //Guardar
                function saveproductionssemi() {

                    var producto_semi_id = $("select[name='producto_semi_id']").val();
                    var cantidad = $("input[name='cantidad']").val();
                    var valor = $("input[name='valor']").val();
                    var description = $("textarea[name='description']").val();
                    var user_id = $("input[name='user_id']").val();

                    var midata = JSON.stringify({'producto_semi_id': producto_semi_id, 'cantidad': cantidad, 'valor': valor, 'description': description, 'user_id': user_id });
                    // console.log(midata)
                    $.ajax({
                        url: "{{ setting('admin.url') }}api/pos/productions/savesemi/"+midata,
                        success: function (response) {
                            var miproduction = JSON.parse(localStorage.getItem('miprodsemi'));

                            for (let index = 0; index < miproduction.length; index++) {

                                var midata = JSON.stringify({'production_semi_id': response, 'insumo_id': miproduction[index].id, 'proveedor_id': miproduction[index].proveedor, 'precio': miproduction[index].costo, 'cantidad': miproduction[index].cant, 'total': miproduction[index].total});

                                $.ajax({
                                    url: "{{ setting('admin.url') }}api/pos/productions/savesemi/detalle/"+midata,
                                    success: function () {

                                    }
                                });
                            }
                            localStorage.setItem('miprodsemi', JSON.stringify([]));
                            location.href='{{ setting('admin.url') }}admin/production-semis';
                        }
                    });
                }

            </script>
        @stop
    @break
    @case('productos')
        @section('javascript')

        <script>


        </script>
        @stop
    @break
    @case('compras')
        @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                $('document').ready(function () {
                    $('.js-example-basic-single').select2();
                    $('input[name="editor_id"]').val('{{ Auth::user()->id }}');
                    Proveedores_Compras();
                    Unidades_Compras();



                });

                async function Proveedores_Compras(){

                    var tabla= await axios("{{setting('admin.url')}}api/pos/proveedores");

                    $('#proveedores_compras').append($('<option>', {
                        value: null,
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

                async function Unidades_Compras(){

                    var tabla= await axios("{{setting('admin.url')}}api/pos/unidades");

                    $('#unidades_compras').append($('<option>', {
                        value: null,
                        text: 'Elige una Unidad'
                    }));
                    for (let index = 0; index < tabla.data.length; index++) {
                        const element = tabla.data[index];
                        $('#unidades_compras').append($('<option>', {
                            value: tabla.data[index].id,
                            text: tabla.data[index].title
                        }));
                    }

                }

                async function InsumosPorUnidadesCompras(id){
                    var tabla= await axios("{{setting('admin.url')}}api/pos/insumo/unidad/"+id);

                    $('#insumos_compras').find('option').remove().end();
                    $('#insumos_compras').append($('<option>', {
                        value: null,
                        text: 'Elige un Insumo'
                    }));
                    for (let index = 0; index < tabla.data.length; index++) {
                        const element = tabla.data[index];
                        $('#insumos_compras').append($('<option>', {
                            value: tabla.data[index].id,
                            text: tabla.data[index].name
                        }));
                    }

                }

                $('#proveedores_compras').on('change',function() {

                    $('input[name="proveedor_id"]').val($('#proveedores_compras').val());

                });


                $('#unidades_compras').on('change', function() {
                    InsumosPorUnidadesCompras(this.value);

                    $('input[name="unidad_id"]').val($('#unidades_compras').val());
                });

                $('#insumos_compras').on('change',function() {

                    $('input[name="insumo_id"]').val($('#insumos_compras').val());

                });



            </script>

        @stop
    @break

    @default

        @section('javascript')
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
                });
            </script>
        @stop

@endswitch
