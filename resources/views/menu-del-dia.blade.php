@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h2><u>Menu del Dia</u></h2 >
        </div>
        @php
            $catalogo = App\Catalogo::latest()->first();
            $products = App\RelCatalogoProducto::where('catalogo_id', $catalogo->id)->get();
        @endphp



           @foreach($products as $item)
            <div class="col-lg-4 col-md-6 col-sm-12">

                @php
                    $product = App\Producto::find($item->producto_id);
                    $miimage = $product->image ? $product->image : setting('productos.imagen_default');
                @endphp
                <div class="row mt-1 py-1 mb-1 hoverable align-items-center">
                    <div class="col-6">
                        <img src="{{ setting('admin.url') }}storage/{{ $miimage }}" class="img-fluid">
                    </div>
                    <div class="col-6">
                        <small>{{ $product->categoria->name }}</small><br>
                        <a class="pt-5"><strong>{{ $product->name }}</strong></a>
                        <h6 class="h6-responsive font-weight-bold dark-grey-text"><strong>{{ $product->precio }} Bs.</strong></h6>
                        <a href="#" onclick="addproduct('{{ $product->id }}')" class="btn btn-sm"><i class="fas fa-cart-arrow-down"></i> Agregar</a>
                    </div>
                </div>
            </div>
            @endforeach

    </div>
</div>
<br>
@endsection
