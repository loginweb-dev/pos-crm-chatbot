<!DOCTYPE html>

<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ setting('site.title') }} - </title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="../mdb2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="../mdb2/css/mdb.min.css" rel="stylesheet">

  <style>

  </style>

</head>

<body class="homepage-v2 hidden-sn white-skin animated">

  <!-- Navigation -->
  <header>

    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav custom-scrollbar">
      <!-- Logo -->
      <li>
        <div class="logo-wrapper waves-light">
          <a href="#"><img src="{{ setting('admin.url').'storage/'.setting('site.banner') }}" class="img-fluid flex-center"></a>
        </div>
      </li>
      <!-- Logo -->
      <!-- Side navigation links -->
      <li>
        <ul class="collapsible collapsible-accordion">
          @php
              $menus =  DB::table('menu_items')->where('menu_id', 3)->orderBy('order','asc')->get();
          @endphp
          @foreach ($menus as $item)
            <li>
              <a href="#" class="collapsible-header waves-effect"><i class="fas fa-plus"></i>
              {{ $item->title }}</a>
            </li>
          @endforeach
        
        </ul>
      </li>
      <!-- Side navigation links -->
      <div class="sidenav-bg mask-strong"></div>

    </ul>
    <!-- Sidebar navigation -->

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg  navbar-light scrolling-navbar white">

      <div class="container-fluid">
        <!-- SideNav slide-out button -->
        <div class="float-left mr-2">
          <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
        </div>
        <a class="navbar-brand font-weight-bold" href="#"><strong>{{ $page->name }}</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
          aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <div class="float-rigth mr-2">
          <a href="#" data-activates="slide-out" class="button-collapse">
            <i class="fas fa-shopping-cart"><span class="badge rounded-pill badge-notification bg-danger">0</span></i>
          </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        </div>
      </div>

    </nav>
    <!-- Navbar -->

  </header>
  <!-- Navigation -->

  <!-- Main Container -->
  <div class="container-fluid mt-2 pt-2">
    <!-- Grid row -->
    <div class="row pt-4">
      <!-- Content -->
      <div class="col-lg-12">

      </div>
      <!-- Content -->
    </div>
    <!-- Grid row -->
  </div>
  <!-- Main Container -->

  <footer class="page-footer text-center text-md-left stylish-color-dark pt-0">
    <div class="footer-copyright py-3 text-center">
      <div class="container-fluid">
        ©2022 <a href="https://loginweb.dev" target="_blank">LoginWeb - Diseño y Desarrollo de Software</a>
      </div>
    </div>
  </footer>

  <!-- JQuery -->
  <script type="text/javascript" src="mdb2/js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="mdb2/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="mdb2/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="mdb2/js/mdb.min.js"></script>
  <script type="text/javascript">
    /* WOW.js init */
    new WOW().init();

    // Tooltips Initialization
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // Material Select Initialization
    $(document).ready(function () {

      $('.mdb-select').material_select();
    });

    // SideNav Initialization
    $(".button-collapse").sideNav();

  </script>

</body>

</html>
