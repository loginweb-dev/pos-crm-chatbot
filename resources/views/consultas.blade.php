@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">

        <div class="col-sm-12 col-md-8 offset-md-2">
            <label for="">Ingresa tu telefono</label>
            <input type="number" id="misearch" class="form-control" placeholder="whatsapp">
            <label><div id="micliente"></div></label>
        </div>
        <div class="col-sm-12 col-md-8 offset-md-2">
            <table class="table table-responsive" id="mipedidos">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Pasarela</th>
                        <th>Delivery</th>
                        <th>Cupon</th>
                        <th>Total</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="midetalle_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Productos</h5>
          {{-- <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
            <table class="table table-responsive" id="midetalle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody> </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            if (miuser) {
                cargar_user(miuser.phone)
            } else {
                toastr.error('Inicia Sesion')
            }
            $("#mireload").attr("hidden",true);
        });

        async function cargar_user(phone) {
            var miuser = await axios.get("{{ setting('admin.url') }}api/consulta/"+phone)
            if (miuser.data.message) {
                toastr.error(miuser.data.message)
            } else {
                // toastr.info('Cliente Encontrado')
                localStorage.setItem('miuser', JSON.stringify(miuser.data));
                $("#micliente").html(miuser.data.display + " <a href='#' onclick='reset()'>Salir</a>");
                $("#misearch").val(miuser.data.phone);
                var pedidos = await axios.get("{{ setting('admin.url') }}api/pedidos/cliente/"+miuser.data.id)
                $("#mipedidos tbody tr").remove();
                for (let index = 0; index < pedidos.data.length; index++) {
                    var banipay = await axios.get("{{ setting('admin.url') }}api/banipay/"+pedidos.data[index].id)
                    var urlbaipay = banipay.data ? banipay.data.urlTransaction : ''
                    if (banipay.data) {
                        $("#mipedidos").append("<tr><td>Codigo:"+pedidos.data[index].id+"<br>Ticket:"+pedidos.data[index].ticket+"</td><td>"+pedidos.data[index].published+"</td><td>"+pedidos.data[index].estado.title+"</td><td>"+pedidos.data[index].pasarela.title+"<br><a href='{{ setting('banipay.url_base') }}"+urlbaipay+"' target='_blank' class='btn btn-sm btn-dark'>Pagar</a></td><td>"+pedidos.data[index].delivery.name+"</td><td>"+pedidos.data[index].cupon.title+"</td><td>"+pedidos.data[index].total+" Bs.</td><td><button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#midetalle_modal' onclick=detalle('"+pedidos.data[index].id+"')>Productos</button></td></tr>")
                    } else {
                        $("#mipedidos").append("<tr><td>Codigo:"+pedidos.data[index].id+"<br>Ticket:"+pedidos.data[index].ticket+"</td><td>"+pedidos.data[index].published+"</td><td>"+pedidos.data[index].estado.title+"</td><td>"+pedidos.data[index].pasarela.title+"</td><td>"+pedidos.data[index].delivery.name+"</td><td>"+pedidos.data[index].cupon.title+"</td><td>"+pedidos.data[index].total+" Bs.</td><td><button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#midetalle_modal' onclick=detalle('"+pedidos.data[index].id+"')>Productos</button></td></tr>")
                    }
                }
            }
        }

        $('#misearch').on('keypress', async function (e) {
            if(e.which === 13){
                cargar_user(this.value)
            }
        });

        //reset session
        function reset() {
            localStorage.removeItem('miuser')
            localStorage.removeItem('micart')
            localStorage.removeItem('miproducts')
            localStorage.removeItem('mipedido')
            location.reload()
        }

        async function detalle(id) {
            var productos = await axios.get("{{ setting('admin.url') }}api/pedido/detalle/"+id)
            console.log(productos.data)
            var misearch = ''
            $("#midetalle tbody tr").remove();
            for (let index = 0; index < productos.data.length; index++) {
                $('#midetalle').append("<tr><td>"+productos.data[index].name+"</td><td>"+productos.data[index].precio+"</td><td>"+productos.data[index].cantidad+"</td></tr>")
            }

        }
    </script>
@endsection
