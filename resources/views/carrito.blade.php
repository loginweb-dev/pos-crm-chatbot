@extends('layouts.master')

@section('content')
    <br>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2>Mi Carrito</h2>
            </div>

            <div class="col-sm-12 col-md-8 offset-md-2">
                <div class="table-responsive">
                    <table class="table product-table" id="micart">
                        <thead class="mdb-color lighten-5">
                            <tr>
                                <th></th>
                                <th class="font-weight-bold">
                                <strong>Producto</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Extras</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Observación</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Precio</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>Cantidad</strong>
                                </th>
                                <th class="font-weight-bold">
                                    <strong>STotal</strong>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-md-8 offset-md-2">
                <h4 class="font-weight-bold mt-4 title-1">
                    <strong>Productos que te pueden interesar </strong>
                </h4>
                <hr class="blue mb-5">
                @php
                    $categorias = App\Categoria::where('ecommerce', false)->orderBy('order', 'asc')->get();
                @endphp
                @foreach($categorias as $key)
                    @php
                        $products = App\Producto::where('ecommerce', true)->where('categoria_id', $key->id)->orderBy('name', 'asc')->with('categoria')->get();
                    @endphp
                    <h2><strong>{{ $key->name }}</strong></h2>
                    <table class="table table-responsive">
                        <tr>
                            @foreach($products as $item)
                                <td style="white-space: normal; width:900px;">
                                    @php
                                        $miimage = $item->image ? $item->image : setting('productos.imagen_default');
                                    @endphp
                                    <div class="card">
                                        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                        <img src="{{ setting('admin.url') }}storage/{{ $miimage }}" class="img-fluid"/>
                                        <a href="#!">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                        </a>
                                        </div>
                                        <div class="card-body">
                                        <h6 class="h6-responsive font-weight-bold dark-grey-text">{{ $item->name }}</h6>
                                        <h6 class="h6-responsive font-weight-bold dark-grey-text"><strong>{{ $item->precio }} Bs.</strong></h6>
                                        {{-- <p class="card-text">{{ $item->description }}</p> --}}
                                        <a href="#!"  onclick="addproduct('{{ $item->id }}')" class="btn btn-sm"><i class="fas fa-cart-arrow-down"></i>Agregar</a>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                @endforeach
            </div>
        </div>
    </div>

    <!----------------------MODALES--------------------------->
    <div class="modal modal-primary fade" tabindex="-1" id="modal-lista_extras" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="voyager-list-add"></i> Lista de extras</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="producto_extra_id" id="producto_extra_id" hidden>
                    <table class="table table-responsive" id="table-extras">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Extra</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" onclick="calcular_total_extra()" data-dismiss="modal">Añadir</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
       $('document').ready(function () {
            var micart = JSON.parse(localStorage.getItem('micart'));
            if (micart.length == 0) {
                toastr.error('Carrito Vacio')
            } else {
                milist()
            }
            $("#mireload").attr("hidden",true);
        });
        function pagar() {
            location.href = "{{ route('pages', 'pasarela') }}"
        }
    </script>
@endsection
