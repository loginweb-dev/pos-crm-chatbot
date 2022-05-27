<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tickets</title>

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">


    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background: url("{{ url('storage/'.setting('ventas.encola')) }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            overflow-y:hidden
            /* margin: 0;
            padding: 0; */
        }
        .title{
            font-size: 50px;
            color: white;
            margin-top: 20px
        }
        .footer{
            position:fixed;
            bottom:0px;
            left:0px;
            background-color:rgba(0, 0, 0, 0.6);
            width: 100%
        }
        .footer-content{
            margin: 10px 20px;
            color: white
        }
        iframe{
            background-color: white
        }
    </style>
    <style>
        .card{
            background-color:rgba(0, 0, 0, 0.7);
            color:white;
            border: 10px solid rgba(0, 0, 0, 0.7);
        }
        .ticket-active{
            animation: colorchange 3s infinite; /* animation-name followed by duration in seconds*/
             /* you could also use milliseconds (ms) or something like 2.5s */
            -webkit-animation: colorchange 3s infinite; /* Chrome and Safari */
        }
        @keyframes colorchange
        {
            0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
            20%   {border: 10px solid #FB3532;}
            80%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        }

        @-webkit-keyframes colorchange /* Safari and Chrome - necessary duplicate */
        {
            0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
            25%   {border: 10px solid #FB3532;}
            75%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        }
    </style>
</head>
<body>
    @php
        $ventas = App\Venta::where('caja_status', false )->where('status_id', 3)->where('sucursal_id', $monitor->sucursal_id)->orderby('id', 'desc')->get();
        $venta = App\Venta::where('caja_status', false )->where('status_id', 3)->where('sucursal_id', $monitor->sucursal_id)->orderby('id', 'desc')->first();
    @endphp

    @if(count($ventas) <= 0 )
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h1 style="color:white;">Sin Pedidos</h1>
                <code>
                    {{ $monitor }}
                </code>
            </div>
            <div class="col-md-4 text-right">
                <div class="row">
                    <h1 class="title">{{ setting('empresa.title') }} <img src="{{ url('storage').'/'.setting('empresa.logo') }}" width="100px" alt=""></h1>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="" style="margin-top:20px;overflow-y:hidden">
                    <div class="card mb-3 ticket-active">
                        <h1 class="text-center" style="font-size:250px">T-{{  $venta->ticket }}</h1>
                    </div>
                </div>
                <div class="row">
                    @foreach ($ventas as $item)
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <p class="card-text" style="margin:10px;font-size:90px;white-space: nowrap;"><small>T-{{ $item->ticket ? $item->ticket : null }}</small></p>
                                <p class="card-text text-right" style="margin:10px;font-size:25px"><small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="row">
                    <h1 class="title">{{ setting('empresa.title') }} <img src="{{ url('storage').'/'.setting('empresa.logo') }}" width="100px" alt=""></h1>
                </div>

                {{-- <audio id="audio">
                    <source type="audio/mp3" src="iphone-notificacion.mp3">
                </audio> --}}
            </div>
        </div>
        <div class="footer">
            <div class="footer-content">
                Powered By <b>Loginweb</b>
            </div>
        </div>
    </div>

    @endif

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>
    <script>
        // document.getElementById("audio").play();
        const socket = io('https://socket.loginweb.dev')
        socket.on("{{ setting('notificaciones.monitor') }}", (msg) =>{
            location.reload();
        })
    </script>
</body>
</html>
