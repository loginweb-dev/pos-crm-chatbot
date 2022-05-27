@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h2>Gracias por tu Compra</h2>
        </div>

        <div class="col-sm-12 col-md-8 offset-md-2">
            <table class="table">
                <tr>
                    <td>ID:</td>
                    <td><div id="id"></div></td>
                </tr>
                <tr>
                    <td>Fecha</td>
                    <td><div id="fecha"></div></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><div id="total"></div></td>
                </tr>
                <tr>
                    <td>Mensaje</td>
                    <td><div id="observacion"></div></td>
                </tr>
                <tr class="text-center">
                    <td colspan="2">
                        <a href="{{ route('pages', 'consultas') }}" class="btn btn-sm btn-primary">Ver todas mi compras</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {
        $("#mireload").attr("hidden",true);
        var mipedido = JSON.parse(localStorage.getItem('mipedido'))
        $("#id").html(mipedido.id)
        $("#fecha").html(mipedido.created_at)
        $("#total").html(mipedido.total+' Bs.')
        $("#observacion").html(mipedido.observacion)
    });
</script>
@endsection
