@extends('layouts.app')

@section('menu')
<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-light white">

  <div class="container"> 

    <a class="navbar-brand" href="/">
      <img src="https://mdbootstrap.com/img/logo/mdb-transparent.png" height="30" alt="mdb logo">
    </a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

      <!-- Left -->
      <ul class="navbar-nav mr-auto">
            {{ menu('LandingPage', 'menus.LandingPage') }}
      </ul>

   

    </div>

  </div>

</nav>
<!--/.Navbar-->


@endsection

@section('content')
  @foreach ($blocks as $item)
    @switch($item->type)
      @case('dinamyc-data')
          @include('blocks.'.$item->name, ['data' => json_decode($item->details)])
          @break
      @case('controller')
        @php
          $aux = json_decode($item->details);
          $myname = explode('.', $item->name);        
          $myname = $myname[1];
          $aux = $aux->$myname;
          $data = $aux->value;
          $data = explode('::', $data);
          $data = str_replace('()','',$data);
          $name_espace = $data[0];
          $function = $data[1];
        @endphp
        @include('blocks.'.$item->name, ['data' => $name_espace::$function(), 'block' => json_decode($item->details)])
        @break
    @endswitch
  @endforeach
@endsection

@section('footer')
  @include('layouts.lp.footer')
@endsection