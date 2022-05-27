@extends('layouts.master')


@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h2>Resultado de Busqueda</h2>
        </div>
        <div class="col-sm-12 col-md-8 offset-md-2">
            <table class="table table-responsive" id="miresult">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titulo</th>
                        <th>Precio</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                                    <a href="#"  onclick="addproduct('{{ $item->id }}')" class="btn btn-sm"><i class="fas fa-cart-arrow-down"></i>Agregar</a>
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
@endsection


@section('javascript')
    <script>
        $(document).ready(function () {
            cargar_search()
            $("#mireload").attr("hidden",true);
        });

        async function cargar_search() {
            var miproducts = JSON.parse(localStorage.getItem('miproducts'))
            $("#miresult tbody tr").remove();
            for (let index = 0; index < miproducts.length; index++) {
                $("#miresult").append("<tr><td><img class='img-responsive img-thumbnail' src='{{ setting('admin.url') }}storage/"+miproducts[index].image+"'></td><td>"+miproducts[index].name+"</td><td>"+miproducts[index].precio+" Bs.</td><td><a href='#' class='btn btn-sm' onclick='addproduct("+miproducts[index].id+")'><i class='fas fa-cart-arrow-down'>Agregar</a></td></tr>")
            }
        }
    </script>
@endsection
