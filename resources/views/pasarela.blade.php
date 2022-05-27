@extends('layouts.master')

@section('css')
    <style>
        #map {
            width: 100%;
            height: 350px;
            /* box-shadow: 5px 5px 5px #888; */
        }

    </style>
   {{-- <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" /> --}}
@endsection
@section('content')
<br>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2>Formulario de Solicitud</h2>
            </div>

            <div class="col-sm-8">
                <div class="form-group">
                    <label for="">Telefono *</label>
                    <input type="number" class="form-control" id="telefono" placeholder="escribe tu whatsapp">
                </div>
                <div class="form-group">
                    <label for="">Nombres</label>
                    <input type="text" class="form-control" id="nombres" placeholder="escribe tu nombre">
                </div>
                <div class="form-group">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" placeholder="escribe tu apellido">
                </div>
                <div class="form-group">
                    <label for="">Carnet o NIT</label>
                    <input type="text" id="ci_nit" class="form-control" placeholder="escribe tu carnet o nit">
                </div>
                <div class="form-group">
                    <label for="">Detalle de tu direccion *</label>
                    <input type="text" class="form-control" id="direccion" placeholder="escribe tu direccion">
                </div>
                <div class="form-group">
                    <label for="">Mueve el marcador para mejorar tu ubicacion</label>
                    <div id="map"></div>
                </div>
                <input type="text" id="latitud" hidden>
                <input type="text" id="longitud" hidden>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Opciones</label>
                    <select class="browser-default custom-select" id="miopciones">
                        @php
                            $options = App\Option::where('view', 'frontend')->get();
                        @endphp
                        @foreach ($options as $item)
                            <option value="{{ $item->id }}">{{ $item->title.' - Bs. '.$item->valor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pasarela de Pago</label>
                    <select class="browser-default custom-select" id="pago_id">
                        @php
                        $options = App\Pago::where('view', 'frontend')->get();
                        @endphp
                        @foreach ($options as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                      </select>
                </div>

                <div class="form-group">
                    <label for="">Cupon</label>
                    <input id="micupon" type="text" class="form-control" placeholder="escribe el codigo de tu cupon">
                    {{-- <input id="midescuento" type="text" class="form-control" value="0" hidden> --}}
                    <input id="micupon_id" type="text" class="form-control" value="1" hidden>
                </div>
                <div class="form-group">
                    <label for="">Descuento</label>
                    <input type="number" class="form-control" value="0" id="descuento" readonly>
                </div>
                <div class="form-group">
                    <label for="">Total</label>
                    <input type="number" class="form-control" id="total" readonly>
                </div>
                <div class="form-group">
                    <label for="">Mensaje al vendedor *</label>
                    <textarea id="observacion" class="form-control">Sin detalle</textarea>
                </div>

                @if(setting('empresa.type_negocio')=="Restaurante")
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="switch_pensionado" />
                            <label class="form-check-label" for="switch_pensionado">Es un pensionado?</label>
                        </div>
                    </div>
                @endif
                <div class="form-group text-center" id="miboton">
                    <a href="#" class="btn btn-primary" onclick="save_pedido()"><i class="fab fa-cc-amazon-pay"></i> Enviar Pedido</a>
                </div>
                <div class="form-group text-center">
                    <p>Luego de confirmar el pedido, se le notificara todo los detalles de su compra.</p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
@endsection

@section('javascript')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBacu367x_GAuwEOzKrjbQSyYqHCwWJpsc&v=weekly" defer></script>

    <script>
        const socket = io('https://socket.loginweb.dev')
        $('document').ready(function () {
            pagototal(null)
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            var milocation = JSON.parse(localStorage.getItem('milocation'))
            var options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            };
            if (miuser || milocation ) {
                getuser(miuser)
                if (milocation) {
                    // getlocation(milocation)
                } else {
                    navigator.geolocation.getCurrentPosition(initMap, error, options);
                }
            } else {
                navigator.geolocation.getCurrentPosition(initMap, error, options);
            }
            $("#mireload").attr("hidden",true);
        });

        //----------- GEO ------------
        function initMap(pos) {
            var crd = pos.coords
            var radio = pos.accuracy
            var myLatLng = { lat: pos.coords.latitude, lng: pos.coords.longitude }
            map = new google.maps.Map(document.getElementById("map"), {
                center: myLatLng,
                zoom: 14,
            });
            marker = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                draggable: true,
                position: myLatLng,
                map,
                title: "Hola Mundo",
                label: "Yo"
            });
            google.maps.event.addListener(marker, 'dragend', function (evt) {
                $("#latitud").val(evt.latLng.lat());
                $("#longitud").val(evt.latLng.lng());
                map.panTo(evt.latLng);
            });
            $("#latitud").val(pos.coords.latitude);
            $("#longitud").val(pos.coords.longitude);
        }

        function pagototal(delivery) {
            var micart = JSON.parse(localStorage.getItem('micart'))
            var mitotal = 0
            for (let index = 0; index < micart.length; index++) {
                var stotal = micart[index].precio * micart[index].cant
                mitotal += stotal
            }
            mitotal = delivery ? (mitotal + parseFloat(delivery)) : mitotal
            mitotal = mitotal - parseFloat($('#descuento').val())
            $('#total').val(mitotal)
            return mitotal
        }

        function error(err) {
            alert(err.message)
            console.warn('ERROR(' + err.code + '): ' + err.message)
        };

        async function save_pedido() {
            //validacion
            if ($('#telefono').val() == '' || $('#direccion').val() == '' || $('#observacion').val() == '') {
                toastr.error('Todos los Campos (*) son obligatorios')
            } else {
                // query client
                $("#mireload").attr("hidden",false);
                $("#miboton").attr("hidden",true);
                var cliente = {
                    'nombres': $('#nombres').val(),
                    'apellidos': $('#apellidos').val(),
                    'telefono': $('#telefono').val(),
                    'ci_nit': $('#ci_nit').val()
                }
                var micliente = await axios.get("{{ setting('admin.url') }}api/cliente/"+JSON.stringify(cliente))
                localStorage.setItem('miuser', JSON.stringify(micliente.data));

                var pension = 0
                if($('#switch_pensionado').is(":checked")){
                    pension= await axios.get("{{setting('admin.url')}}api/pos/pensionado/cliente/"+micliente.data.id);
                    if(pension.data){
                        pension = pension.data.id
                    }
                    else{
                        toastr.error("Pensión no Encontrada o Inactiva");
                    }
                }

                // query location client
                var location = {
                    'cliente_id': micliente.data.id,
                    'latitud': $('#latitud').val(),
                    'longitud': $('#longitud').val(),
                    'direccion': $('#direccion').val()
                }

                // console.log(location);
                var milocation = await axios.get("{{ setting('admin.url') }}api/location/"+JSON.stringify(location))

                var register_id={{setting('ventas.cliente_pag_id')}};

                if($('#miopciones').val()=="{{setting('ventas.delivery_zona1')}}"||$('#miopciones').val()=="{{setting('ventas.delivery_zona2')}}"){
                    var delivery_id="{{setting('ventas.delivery_negocio_id')}}";
                }
                else{
                    var delivery_id="{{setting('ventas.sindelivery_id')}}";
                }

                var aux=0;
                var micart = JSON.parse(localStorage.getItem('micart'))
                for(let index=0;index < micart.length;index++){
                    aux=aux+micart[index].precio*micart[index].cant;
                }

                //save venta
                var pedido = {
                    'cliente_id': micliente.data.id,
                    'pensionado_id':pension,
                    'option_id': $('#miopciones').val(),
                    'pago_id': $('#pago_id').val(),
                    'subtotal': aux,
                    'total': $('#total').val(),
                    'descuento': $('#descuento').val(),
                    'observacion': $('#observacion').val(),
                    'cupon_id': $('#micupon_id').val(),
                    'location': milocation.data.id,
                    'credito':"Contado",
                    'register_id':register_id,
                    'delivery_id':delivery_id

                }
                var newpedido = await axios.get("{{ setting('admin.url') }}api/pedido/save/"+JSON.stringify(pedido))
                var micart = JSON.parse(localStorage.getItem('micart'))
                for (let index = 0; index < micart.length; index++) {
                    var midata2 = JSON.stringify({'producto_id': micart[index].id, 'venta_id': newpedido.data.id, 'precio': micart[index].precio, 'cantidad': micart[index].cant, 'total': micart[index].total, 'name':micart[index].name, 'foto':micart[index].foto, 'description': micart[index].description, 'extra_name':micart[index].extra_name, 'observacion':micart[index].observacion});
                    var venta_detalle = await axios.get("{{ setting('admin.url') }}api/pedido/products/save/"+midata2)
                }
                switch ($('#pago_id').val()) {
                    case '6':// efectivo

                        break;
                    case '7': // Contra Reembolso
                        break;
                    case '8': // BaniPay
                        var micart2 = []
                        for (let index = 0; index < micart.length; index++) {
                            micart2.push({"concept": micart[index].name, "quantity": micart[index].cant, "unitPrice": micart[index].precio})
                        }
                        var miconfig = {"affiliateCode": "{{ setting('banipay.affiliatecode') }}",
                            "notificationUrl": "{{ setting('banipay.notificacion') }}",
                            "withInvoice": false,
                            "externalCode": newpedido.data.id,
                            "paymentDescription": "Pago por la compra en {{ setting('admin.title') }}",
                            "details": micart2,
                            "postalCode": "{{ setting('banipay.moneda') }}"
                            }
                        var banipay = await axios.post('https://banipay.me:8443/api/payments/transaction', miconfig)
                        var midata3 = JSON.stringify({paymentId: banipay.data.paymentId, transactionGenerated: banipay.data.transactionGenerated, externalCode: banipay.data.externalCode})
                        await axios.get("{{ setting('admin.url') }}api/pos/banipay/save/"+midata3)
                        break;
                    default:
                        console.log('default')
                        break;
                }

                //Notifications
                localStorage.setItem('mipedido', JSON.stringify(newpedido.data))
                var minoti = "Venta Registrada con ID:"+newpedido.data.id
                socket.emit("{{ setting('notificaciones.venta') }}", minoti);
                // console.log(JSON.stringify(newpedido.data))
                var phone = micliente.data.phone
                var miurl= "{{ setting('admin.url').'page/pedido' }}"
                var message = "Gracias por tu preferencia 🙂, Para ver tu compra completa, dirigite a siguiente link 🔎"
                var chatbot = await axios.get("{{ setting('notificaciones.url_chatbot') }}?phone="+phone+"&type=text"+"&message="+message)
                var chatbot2 = await axios.get("{{ setting('notificaciones.url_chatbot') }}?phone="+phone+"&type=text"+"&message="+miurl)
                redireccionar();
             }
        }

        function redireccionar(){
            localStorage.setItem('micart', JSON.stringify([]));
            location.href = "{{ route('pages', 'pedido') }}";
        }

        $('#telefono').on('keypress', async function (e) {
            if(e.which === 13){
                var miuser = await axios.get("{{ setting('admin.url') }}api/consulta/"+this.value)
                console.log(miuser.data)
                if (miuser.data.message) {
                    $('#nombres').val('')
                    $('#apellidos').val('')
                    $('#telefono').val('')
                    $('#ci_nit').val('')
                    toastr.error('Cliente NO encontrado')
                } else {
                    $('#nombres').val(miuser.data.first_name)
                    $('#apellidos').val(miuser.data.last_name)
                    $('#telefono').val(miuser.data.phone)
                    $('#ci_nit').val(miuser.data.ci_nit)
                    toastr.success('Cliente Encontrado')
                    localStorage.setItem('miuser', JSON.stringify(miuser.data));
                }
            }
        });

        $('#miopciones').on('change', async function (e) {
            toastr.success('Delivery Actualizado')
            var options = await axios("{{ setting('admin.url') }}api/option/"+this.value)
            pagototal(options.data.valor)

        });

        $('#pago_id').on('change', async function (e) {
            toastr.success('Pasarela de Pago Actualizado')

        });

        async function getuser(midata) {
            $('#nombres').val(midata.first_name)
            $('#apellidos').val(midata.last_name)
            $('#telefono').val(midata.phone)
            $('#ci_nit').val(midata.ci_nit)
        }

        $('#micupon').on('keypress', async function (e) {
            if(e.which === 13){
                var desc = await axios("{{ setting('admin.url') }}api/cupon/"+this.value)
                if (desc.data) {
                    if (confirm("Quieres Validar tu Cupon?") == true) {
                        $('#descuento').val(desc.data.valor)
                        $('#micupon_id').val(desc.data.id)
                        toastr.success('Cupon Validado')
                    } else {
                        toastr.error('Cupon NO validado')
                        $('#micupon').val('')
                        $('#descuento').val(0)
                        $('#micupon_id').val(1)
                    }
                } else {
                    toastr.error('Cupon no valido')
                    $('#micupon').val('')
                    $('#descuento').val(0)
                    $('#micupon_id').val(1)
                }
                pagototal(null)
            }
        });

    </script>
@stop
