<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ setting('site.title') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ setting('admin.url').'storage/'.setting('site.logo') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="{{ asset('ecommerce1/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('ecommerce1/css/mdb.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <meta name="theme-color" content="{{ setting('site.color') }}">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ setting('site.title') }}">
    <link rel="icon" sizes="512x512" href="{{ setting('admin.url').'storage/'.setting('site.logo') }}">

    @yield('css')
    <style>
        .page-footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body class="homepage-v2 hidden-sn white-skin animated">
    <header>
        {{-- <ul id="slide-out" class="side-nav custom-scrollbar">
        <li>
            <div class="logo-wrapper waves-light">
            <a href="/"><img src="{{ setting('admin.url').'storage/'.setting('site.banner') }}" class="img-fluid flex-center"></a>
            </div>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
            @php
                $menus =  DB::table('menu_items')->where('menu_id', setting('site.menu_movil'))->orderBy('order','asc')->get();
            @endphp
            @foreach ($menus as $item)
                <li>
                <a href="{{ route('pages', $item->url) }}" class="collapsible-header waves-effect"><i class="fas fa-plus"></i>
                {{ $item->title }}</a>
                </li>
            @endforeach
            </ul>
        </li> --}}
        <div class="sidenav-bg mask-strong"></div>
        </ul>
        <nav class="navbar fixed-top navbar-expand-lg  navbar-dark scrolling-navbar bg-dark">
            {{-- <div class="container"> --}}
                <!-- SideNav slide-out button -->
                {{-- <div class="float-left mr-2">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
                </div> --}}
                <a class="navbar-brand mx-auto font-weight-bold" href="/"><strong>{{ setting('site.title') }}</strong></a>
                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
                aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                </button> --}}
                {{-- <div class="float-rigth mr-2">
                    <a href="{{ route('pages', 'carrito') }}">
                        <i class="fas fa-shopping-cart"><span class="badge rounded-pill badge-notification bg-danger"><div id="micount"></div></span></i>
                    </a>
                </div> --}}
            {{-- </div> --}}
        </nav>
    </header>

    <div class="text-center" id="mireload">
        <img src="{{ setting('admin.url').'storage/'.setting('site.reload') }}" class="img img-responsive" alt="">
    </div>
    @yield('content')

    <footer class="page-footer text-center text-md-left stylish-color-dark pt-0 mt-2">
        <div class="footer-copyright py-0 text-center">
            ©2022 <a href="https://loginweb.dev" target="_blank">LoginWeb - Desarrollo de Software</a>
        </div>
    </footer>

    <script type="text/javascript" src="{{ asset('ecommerce1/js/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('ecommerce1/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('ecommerce1/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('ecommerce1/js/mdb.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>

    <script type="text/javascript">
        new WOW().init();
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(document).ready(function () {

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-left",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            $('.mdb-select').material_select();
            //carrito
            if (localStorage.getItem('micart')) {
                mitotal()
            } else {
                localStorage.setItem('micart', JSON.stringify([]));
                mitotal()
            }

        });
        $(".button-collapse").sideNav();

        //carrito
        async function addproduct(id) {
            var micart = JSON.parse(localStorage.getItem('micart'))
            var mirep = false
            var newcant = 0
            for (let index = 0; index < micart.length; index++) {
                if(micart[index].id == id){
                    mirep = true
                    newcant = micart[index].cant
                    break;
                }
            }
            if(mirep){
                toastr.success("Cantidad Actualizada del Item: "+id)
                updatecant(id)
            }else{
                var product = await axios ("{{ setting('admin.url') }}api/pos/producto/"+id)
                toastr.info('Item Agregado: '+product.data.name)
                // console.log(product.data)
                var miimage =product.data.image ? product.data.image:  "{{setting('productos.imagen_default')}}" ;
                var temp = {'id': product.data.id, 'image': miimage, 'name': product.data.name, 'precio': product.data.precio,'precio_inicial': product.data.precio , 'cant': 1, 'description':'' ,'extra':product.data.extra, 'extras':product.data.extras,'extra_name':'', 'observacion':''}
                micart.push(temp)
                localStorage.setItem('micart', JSON.stringify(micart))
                mitotal()
            }
        }

        async function updatecant(id) {
            var milist = JSON.parse(localStorage.getItem('micart'));
            var newlist = [];
            for (let index = 0; index < milist.length; index++) {
                if (milist[index].id == id) {
                    var newcant = milist[index].cant + 1
                    var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio,'precio_inicial': milist[index].precio_inicial, 'cant': newcant, 'description':milist[index].description,  'extra':milist[index].extra, 'extras':milist[index].extras,'extra_name':milist[index].extra_name , 'observacion':milist[index].observacion}
                }else{
                    var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant,'description':milist[index].description, 'extra':milist[index].extra, 'extras':milist[index].extras,'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion}
                }
                newlist.push(temp);
            }
            localStorage.setItem('micart', JSON.stringify(newlist));
            mitotal()
        }
        async function midelete(id) {
            // $("#micart tr#"+id).remove();
            var milist = JSON.parse(localStorage.getItem('micart'));
            var newlist = [];
            for (let index = 0; index < milist.length; index++) {
                if (milist[index].id == id) {
                    toastr.info(milist[index].name+" - ELIMINADO");
                } else {
                    var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'precio': milist[index].precio,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant,'description':milist[index].description ,'extra':milist[index].extra, 'extras':milist[index].extras,'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion };
                    newlist.push(temp);
                }
            }
            localStorage.setItem('micart', JSON.stringify(newlist));
            location.reload();
        }

        async function addextra(extras , producto_id) {
            $("#table-extras tbody tr").remove();
            $("#producto_extra_id").val(producto_id);
            var mitable="";
            var extrasp=  await axios.get("{{ setting('admin.url') }}api/pos/producto/extra/"+extras);
            for(let index=0; index < extrasp.data.length; index++){
                mitable = mitable + "<tr><td>"+extrasp.data[index].id+"</td><td><input class='form-control extra-name' readonly value='"+extrasp.data[index].name+"'></td><td><input class='form-control extra-precio' readonly  value='"+extrasp.data[index].precio+" Bs."+"'></td><td><input class='form-control extra-cantidad' style='width:100px' type='number' min='0' value='0'  id='extra_"+extrasp.data[index].id+"'></td></tr>";
            }
            $('#table-extras').append(mitable);
        }
        async function calcular_total_extra(){
            var cantidad=[];
            var name=[];
            var precio=[];
            var subtotal=0;
            var index_cantidad=0;
            var index_name_aux=0;
            var index_precio_aux=0;
            var index_cantidad_aux=0;
            var precio_extras=0;
            var nombre_extras="";
            $('.extra-cantidad').each(function(){
                if($(this).val()>0){
                    cantidad[index_cantidad_aux]=parseFloat($(this).val());
                    index_cantidad_aux+=1;
                    var index_name=0;
                    $('.extra-name').each(function(){
                        if(index_name==index_cantidad){
                            name[index_name_aux]=$(this).val();
                            index_name_aux+=1;
                        }
                        index_name+=1;
                    });
                    var index_precio=0;
                    $('.extra-precio').each(function(){
                        if(index_precio==index_cantidad){
                            precio[index_precio_aux]=parseFloat($(this).val());
                            index_precio_aux+=1;
                        }
                        index_precio+=1;
                    });
                }
                index_cantidad+=1;
            });

            for(let index=0;index<precio.length;index++){
                nombre_extras+=name[index]+' ';
                precio_extras+=parseFloat(cantidad[index])*parseFloat(precio[index]);
            }
            var producto_id=$("#producto_extra_id").val();
            var name_extra=nombre_extras;
            var precio_extra=precio_extras;
            updatecantextra(name_extra, precio_extra, producto_id);
        }

        async function updatecantextra( name_extra, precio_extra, producto_id){
            var miprice = $("#precio_"+producto_id).val()
            var nuevoprecio = parseFloat(precio_extra)+ parseFloat(miprice);
            var nuevototal = parseFloat(nuevoprecio).toFixed(2)*parseFloat($("#cant_"+producto_id).val());
            var milist = JSON.parse(localStorage.getItem('micart'));
            var newlist = [];
            for (let index = 0; index < milist.length; index++) {
                if (milist[index].id == producto_id) {
                        var miprice = milist[index].precio_inicial;
                        var nuevoprecio = parseFloat(precio_extra)+ parseFloat(miprice);
                        var nuevototal = parseFloat(nuevoprecio).toFixed(2)*parseFloat($("#cant_"+producto_id).val());

                        var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': nuevoprecio ,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant,  'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name': name_extra, 'observacion':milist[index].observacion};
                        newlist.push(temp);
                }
                else{
                        var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio , 'precio_inicial': milist[index].precio_inicial ,'cant': milist[index].cant,  'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                        newlist.push(temp);
                }
            }
            localStorage.setItem('micart', JSON.stringify(newlist));
            this.milist();
        }
        async function updateobservacion(id){
            var observacion= $("#observacion_"+id).val()
            var milist = JSON.parse(localStorage.getItem('micart'));
            var newlist = [];
            for (let index = 0; index < milist.length; index++) {
                if (milist[index].id == id) {
                        var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio ,'precio_inicial': milist[index].precio_inicial, 'cant': milist[index].cant, 'total':milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name': milist[index].extra_name, 'observacion':observacion};
                        newlist.push(temp);
                }
                else{
                        var temp = {'id': milist[index].id, 'image': milist[index].image, 'name': milist[index].name, 'description': milist[index].description , 'precio': milist[index].precio , 'cant': milist[index].cant, 'total': milist[index].total, 'extra':milist[index].extra, 'extras':milist[index].extras, 'extra_name':milist[index].extra_name, 'observacion':milist[index].observacion};
                        newlist.push(temp);
                }
            }
            localStorage.setItem('micart', JSON.stringify(newlist));
            this.milist();
        }


        function mitotal() {
            var micart = JSON.parse(localStorage.getItem('micart'))
                var mitotal = 0
                for (let index = 0; index < micart.length; index++) {
                    mitotal += micart[index].cant
                }
            $('#micount').html(mitotal)
        }

        async function milist() {
            $("#micart tbody tr").remove();
            var milist = JSON.parse(localStorage.getItem('micart'))
            var mitotal = 0
            for (let index = 0; index < milist.length; index++) {
                var stotal = milist[index].precio * milist[index].cant
                var observacion = milist[index].observacion ? milist[index].observacion: ''
                if(milist[index].extra){
                    $("#micart").append("<tr id="+milist[index].id+"><td><img class='img-responsive img-thumbnail' src='{{ setting('admin.url') }}storage/"+milist[index].image+"'></td><td><strong>"+milist[index].name+"<br>"+milist[index].description+"</strong></td><td><strong>"+milist[index].extra_name+"</strong><a href='#' class='btn btn-sm btn-success'  data-toggle='modal' data-target='#modal-lista_extras' onclick='addextra("+milist[index].extras+", "+milist[index].id+")'><i class='fas fa-align-justify'></i></a></td><td><input class='form-control' type='text'  onchange='updateobservacion("+milist[index].id+")' id='observacion_"+milist[index].id+"' value='"+observacion+"' placeholder='algun detalle?'></td><td>"+milist[index].precio+"</td><td>"+milist[index].cant+"</td><td>"+stotal+"</td><td><button type='button' class='btn btn-sm btn-danger' data-toggle='tooltip' data-placement='top' onclick='midelete("+milist[index].id+")' title='Remove item'>X</button></td></tr>")
                    mitotal += stotal
                }
                else{
                    $("#micart").append("<tr id="+milist[index].id+"><td><img class='img-responsive img-thumbnail' src='{{ setting('admin.url') }}storage/"+milist[index].image+"'></td><td><strong>"+milist[index].name+"<br>"+milist[index].description+"</strong></td><td></td><td><input class='form-control' type='text' onchange='updateobservacion("+milist[index].id+")' id='observacion_"+milist[index].id+"' value='"+observacion+"'  placeholder='algun detalle?'></td><td>"+milist[index].precio+"</td><td>"+milist[index].cant+"</td><td>"+stotal+"</td><td><button type='button' class='btn btn-sm btn-danger' data-toggle='tooltip' data-placement='top' onclick='midelete("+milist[index].id+")' title='Remove item'>X</button></td></tr>")
                    mitotal += stotal
                }
            }
            $("#micart").append("<tr id='mitotal' ><td colspan='2'><h4 class='mt-2'><strong>Total Bs.</strong></h4></td><td><h4 class='mt-2'><strong>"+mitotal+"</strong></h4></td><td <td colspan='2'><a type='button' href='#' onclick='pagar()' class='btn btn-md btn-primary btn-rounded'>Pagar<i class='fas fa-angle-right right'></i></td></tr>")
        }

    </script>

@yield('javascript')
</body>
</html>
