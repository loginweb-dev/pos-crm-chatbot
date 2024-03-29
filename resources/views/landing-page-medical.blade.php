<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    {{-- <meta http-equiv="x-ua-compatible" content="ie=edge"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>{{ setting('site.title') }}</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="{{ asset('mdb/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('mdb/css/mdb.min.css') }}" rel="stylesheet">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ setting('site.title') }}">
    <link rel="icon" sizes="512x512" href="{{ setting('admin.url').'storage/'.setting('site.logo') }}">

  <style type="text/css">
    html,
    body,
    header,
    .view {
      height: 100%;
    }
  </style>
   <link href="{{ asset('css/floating-wpp.css') }}">
</head>

<body class="medical-lp">

  <!--Navigation & Intro-->
  <header>

    <!--Navbar-->
    {{-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar"> --}}
    <nav class="navbar fixed-top navbar-expand-lg navbar-light scrolling-navbar white">
      <div class="container">
        <a class="navbar-brand" href="#"><strong>{{ setting('site.title') }}</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!--Links-->
          <ul class="navbar-nav mr-auto smooth-scroll">
            @php
                $menus =  DB::table('menu_items')->where('menu_id', 2)->orderBy('order','asc')->get();
            @endphp
            @foreach ($menus as $item)
            <li class="nav-item">
              <a class="nav-link" href="{{ $item->url }}">{{ $item->title }}<span class="sr-only">(current)</span></a>
            </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="#about" data-offset="80">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#team" data-offset="80">Team</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#pricing" data-offset="20">Pricing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#features" data-offset="80">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#testimonials" data-offset="80">Testimonials</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="modal" data-target="#modal-info">Info</a>
            </li> --}}
            @endforeach
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#modal-info">Infomacion</a>
              </li>
          </ul>

          <!--Social Icons-->
          <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
              <a class="nav-link"><i class="fab fa-facebook-f white-text"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link"><i class="fab fa-twitter white-text"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link"><i class="fab fa-instagram white-text"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--/Navbar-->

    <!--Intro Section-->
    <section id="home" class="view" style="background-image: url('https://mdbootstrap.com/img/Photos/Others/images/37.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
      <div class="mask">
        <div class="container h-100 d-flex justify-content-center align-items-center">
          <div class="row pt-5 mt-3">
            <div class="col-12 col-md-6 text-center text-md-left">
              <div class="white-text">
                <h1 class="h1-responsive font-weight-bold mt-md-5 mt-0 wow fadeInLeft" data-wow-delay="0.3s">{{ setting('site.title') }}</h1>
                <hr class="hr-light wow fadeInLeft" data-wow-delay="0.3s">
                {{-- <p class="wow fadeInLeft mb-3" data-wow-delay="0.3s">Lorem ipsum dolor sit amet, consectetur
                  adipisicing elit. Rem repellendus quasi fuga nesciunt
                  dolorum nulla magnam veniam sapiente, fugiat! Commodi sequi non animi ea dolor molestiae
                  iste.
                </p> --}}
                <p class="wow fadeInLeft mb-3" data-wow-delay="0.3s">{{ setting('site.description') }}</p>
                <br>
                <a href="{{ route('pages', 'catalogo') }}" class="btn btn-unique btn-rounded font-weight-bold ml-lg-0 wow fadeInLeft" data-wow-delay="0.3s">Catalogo</a>
                {{-- <a class="btn btn-outline-white btn-rounded font-weight-bold wow fadeInLeft" data-wow-delay="0.3s">Learn
                  more
                </a> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!--Modal Info-->
    <div class="modal fade modal-ext" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header text-center">
            <h4 class="modal-title w-100 py-3" id="myModalLabel">Information about clinic</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body text-center">

            <!--Title-->
            <h5 class="title mb-3 font-weight-bold">Opening hours:</h5>

            <!--Opening hours table-->
            <table class="table">
              <tbody>
                <tr>
                  <td>Monday - Friday:</td>
                  <td>8 AM - 9 PM</td>
                </tr>
                <tr>
                  <td>Saturday:</td>
                  <td>9 AM - 6 PM</td>
                </tr>
                <tr>
                  <td>Sunday:</td>
                  <td>11 AM - 6 PM</td>
                </tr>
              </tbody>
            </table>

            <!--Title-->
            <h5 class="title mb-4 font-weight-bold">Addresses:</h5>

            <!--First row-->
            <div class="row">

              <!--First column-->
              <div class="col-md-6">

                <p>125 Street<br> New York, NY 10012</p>

              </div>
              <!--/First column-->

              <!--Second column-->
              <div class="col-md-5">

                <p>Allen Street 5<br> New York, NY 10012</p>

              </div>
              <!--/Second column-->

            </div>
            <!--/First row-->

          </div>
          <!--Footer-->
          <div class="modal-footer">
            <button type="button" class="btn btn-rounded btn-info waves-effect" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!--/Content-->
      </div>
    </div>
    <!--/Modal Info-->

  </header>
  <!--/Navigation & Intro-->

  <!--Main content-->
  <main>

    <div class="container">

      <!--Section: Features v.1-->
      <section id="features" class="mt-4 mb-5 pb-5">

        <!--Section heading-->
        <h1 class="text-center mb-5 mt-5 pt-5 font-weight-bold dark-grey-text wow fadeIn" data-wow-delay="0.2s">Professional
          treatments</h1>
        <!--Section sescription-->
        <p class="text-center grey-text w-responsive mx-auto mb-5 wow fadeIn" data-wow-delay="0.2s">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum quas, eos officia maiores ipsam ipsum
          dolores reiciendis
          ad voluptas, animi obcaecati adipisci sapiente mollitia? Autem delectus quod accusamus tempora, aperiam
          minima assumenda deleniti hic.</p>

        <!--First row-->
        <div class="row features-big my-4 text-center">
          <!--First column-->
          <div class="col-md-4 mb-4 wow fadeIn" data-wow-delay="0.4s">
            <div class="card hoverable">
              <i class="fas fa-heart blue-text mt-3 fa-3x my-4"></i>
              <h5 class="font-weight-bold mb-4"">Experience</h5>
                            <p class=" grey-text
                font-small mx-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam,
                aperiam
                minima assumenda deleniti hic.</p fa-3x mb-4>
            </div>
          </div>
          <!--/First column-->

          <!--Second column-->
          <div class="col-md-4 mb-4 wow fadeIn" data-wow-delay="0.4s">
            <div class="card hoverable">
              <i class="far fa-eye blue-text mt-3 fa-3x my-4"></i>
              <h5 class="font-weight-bold mb-4">Protection</h5>
              <p class="grey-text font-small mx-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Reprehenderit maiores nam, aperiam
                minima assumenda deleniti hic.</p>
            </div>
          </div>
          <!--/Second column-->

          <!--Third column-->
          <div class="col-md-4 mb-1 wow fadeIn" data-wow-delay="0.4s">
            <div class="card hoverable">
              <i class="fas fa-briefcase-medical blue-text mt-3 fa-3x my-4"></i>
              <h5 class="font-weight-bold mb-4"">Qualifications</h5>
                            <p class=" grey-text
                font-small mx-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam,
                aperiam
                minima assumenda deleniti hic.</p>
            </div>
          </div>
          <!--/Third column-->
        </div>
        <!--/First row-->

      </section>
      <!--/Section: Features v.1-->
    </div>

    <div id="home" class="container-fluid">

      <!--Grid row-->
      <div class="row my-5">

        <!--Grid column-->
        <div class="col-md-12">

          <!--Tiles blog-->
          <div>
            <!--First row-->
            <div class="row">
              <!--First column-->
              <div class="col-xl-3 col-md-6 px-0">
                <!--Single blog post-->
                <div class="waves-effect waves-light">
                  <!--Blog post link-->
                  <a href="#!">
                    <!--Image-->
                    <div class="view overlay">

                      <img src="https://mdbootstrap.com/img/Photos/Others/images/40.jpg" class="img-fluid" alt="">

                      <div class="mask flex-center rgba-blue-strong">
                        <h4 class="white-text font-weight-bold">Lorem ipsum dolor sit amet</h4>
                      </div>
                    </div>
                    <!--/Image-->
                  </a>
                  <!--Blog post link-->

                </div>
                <!--/Single blog post-->
              </div>
              <!--/First column-->

              <!--Second column-->
              <div class="col-xl-3 col-md-6 px-0">
                <!--Single blog post-->
                <div class="waves-effect waves-light">
                  <!--Blog post link-->
                  <a href="#!">
                    <!--Image-->
                    <div class="view overlay">

                      <img src="https://mdbootstrap.com/img/Photos/Others/images/39.jpg" class="img-fluid" alt="">

                      <div class="mask flex-center rgba-blue-strong">
                        <h4 class="white-text font-weight-bold">Lorem ipsum dolor sit amet</h4>
                      </div>
                    </div>
                    <!--/Image-->
                  </a>
                  <!--Blog post link-->

                </div>
                <!--/Single blog post-->
              </div>
              <!--/Second column-->

              <!--Third column-->
              <div class="col-xl-3 col-md-6 px-0">
                <!--Single blog post-->
                <div class="waves-effect waves-light">
                  <!--Blog post link-->
                  <a href="#!">
                    <!--Image-->
                    <div class="view overlay">

                      <img src="https://mdbootstrap.com/img/Photos/Others/images/38.jpg" class="img-fluid" alt="">

                      <div class="mask flex-center rgba-blue-strong">
                        <h4 class="white-text font-weight-bold">Lorem ipsum dolor sit amet</h4>
                      </div>
                    </div>
                    <!--/Image-->
                  </a>
                  <!--Blog post link-->

                </div>
                <!--/Single blog post-->
              </div>
              <!--/Third column-->

              <!--Fourth column-->
              <div class="col-xl-3 col-md-6 px-0">
                <!--Single blog post-->
                <div class="waves-effect waves-light">
                  <!--Blog post link-->
                  <a href="#!">
                    <!--Image-->
                    <div class="view overlay">

                      <img src="https://mdbootstrap.com/img/Photos/Others/images/41.jpg" class="img-fluid" alt="">

                      <div class="mask flex-center rgba-blue-strong">
                        <h4 class="white-text font-weight-bold">Lorem ipsum dolor sit amet</h4>
                      </div>
                    </div>
                    <!--/Image-->
                  </a>
                  <!--Blog post link-->
                </div>
                <!--/Single blog post-->
              </div>
              <!--/Fourth column-->
            </div>
            <!--/First row-->

          </div>

        </div>
        <!--/Grid column-->

      </div>
      <!--/Grid row-->

    </div>

    <div class="container">

      <!--Section: About-->
      <section id="about" class="info-section mb-5 mt-5 pt-4">

        <!--First row-->
        <div class="row pt-5">

          <!--First column-->
          <div class="col-md-7 mb-2 smooth-scroll wow fadeIn" data-wow-delay="0.2s">

            <!--Heading-->
            <h2 class="mb-3 font-weight-bold">We Provide High Quality services</h2>
            <!--Description-->
            <h4 class="mb-5 dark-grey-text">Visit Our New Clinic in New York.</h4>
            <!--Content-->
            <p class="grey-text" align="justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo animi
              soluta ratione quisquam, dicta
              ab cupiditate iure eaque? Repellendus voluptatum, magni impedit eaque delectus, beatae maxime
              temporibus maiores quibusdam quasi. Rem magnam ad perferendis iusto sint tempora ea voluptatibus
              iure, animi excepturi modi aut possimus in hic molestias repellendus illo ullam odit quia velit.
            </p>

            <p class="grey-text" align="justify">Qui expedita sit quo, maxime molestiae. Lorem ipsum dolor sit amet,
              consectetur adipisicing elit.
              Nemo animi soluta ratione quisquam, dicta ab cupiditate iure eaque repellendus voluptatum.
            </p>
            <br>
            <!--Button-->
            <a href="#home" class="btn btn-rounded btn-blue mb-4">Contact Us Now</a>

          </div>
          <!--/First column-->

          <!--Second column-->
          <div class="col-lg-4 flex-center ml-lg-auto col-md-5 mb-5 wow fadeIn" data-wow-delay="0.3s">

            <!--Image-->
            <img src="https://mdbootstrap.com/img/Photos/Vertical/People/img%20%282%29.jpg" class="img-fluid z-depth-1">

          </div>
          <!--/Second column-->

        </div>
        <!--/First row-->

      </section>
      <!--Section: About-->

    </div>

    <!--Streak-->
    <div class="streak streak-photo streak-long-2" style="background-image: url('https://mdbootstrap.com/img/Others/doctor.jpg');">
      <div class="flex-center mask rgba-blue-strong">
        <div class="container text-center white-text">
          <h3 class="text-center text-white text-uppercase font-weight-bold mt-5 mb-5 pt-3 wow fadeIn" data-wow-delay="0.2s">Great
            people trusted our services</h3>

          <!--First row-->
          <div class="row text-white text-center wow fadeIn" data-wow-delay="0.2s">

            <!--First column-->
            <div class="col-md-3 mt-2">
              <h1 class="white-text font-weight-bold">+950</h1>
              <p>Lorem ipsum dolor</p>
            </div>
            <!--/First column-->

            <!--Second column-->
            <div class="col-md-3 mt-2">
              <h1 class="white-text font-weight-bold">+150</h1>
              <p>Lorem ipsum dolor</p>
            </div>
            <!--/Second column-->

            <!--Third column-->
            <div class="col-md-3 mt-2">
              <h1 class="white-text font-weight-bold">+85</h1>
              <p>Lorem ipsum dolor</p>
            </div>
            <!--/Third column-->

            <!--Fourth column-->
            <div class="col-md-3 mt-2 mb-5 pb-3">
              <h1 class="white-text font-weight-bold">+6K</h1>
              <p>Lorem ipsum dolor</p>
            </div>
            <!--/Fourth column-->

          </div>
          <!--/First row-->

        </div>
      </div>
    </div>
    <!--/Streak-->

    <div class="container">

      <!--Projects section v.3-->
      <section id="team" class="mt-4 mb-2">

        <!--Section heading-->
        <h1 class="text-center mb-5 mt-5 pt-4 font-weight-bold dark-grey-text wow fadeIn" data-wow-delay="0.2s">Meet
          our doctors</h1>
        <!--Section description-->
        <p class="text-center grey-text w-responsive mx-auto mb-5 wow fadeIn" data-wow-delay="0.2s">Duis aute irure
          dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
          sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <!--First row-->
        <div class="row wow fadeIn" data-wow-delay="0.4s">

          <!--First column-->
          <div class="col-md-12">

            <div class="mb-2">

              <!-- Nav tabs -->
              <ul class="nav md-pills pills-primary flex-center" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#panel31" role="tab"><i class="far fa-eye fa-2x"></i><br>
                    John</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#panel32" role="tab"><i class="fas fa-heartbeat fa-2x"></i><br>
                    Anna</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#panel33" role="tab"><i class="fas fa-search fa-2x"></i><br>
                    Maria</a>
                </li>
              </ul>

            </div>

            <!--Tab panels-->
            <div class="tab-content">

              <!--Panel 1-->
              <div class="tab-pane fade show in active" id="panel31" role="tabpanel">
                <br>

                <!--First row-->
                <div class="row d-flex justify-content-center">

                  <!--First column-->
                  <div class="col-lg-3 col-md-6 pb-5">

                    <!--Featured image-->
                    <div class="view overlay z-depth-1 z-depth-2">
                      <img src="https://mdbootstrap.com/img/Photos/Vertical/People/img%20%281%29.jpg" class="img-fluid">
                    </div>
                  </div>
                  <!--/First column-->

                  <!--Second column-->
                  <div class="col-lg-6 col-md-12 text-left">

                    <!--Title-->
                    <h4 class="mb-3">John Doe</h4>

                    <!--Description-->
                    <p class="grey-text" align="justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo
                      animi soluta ratione
                      quisquam, dicta ab cupiditate iure eaque? Repellendus voluptatum, magni impedit
                      eaque delectus, beatae maxime temporibus maiores quibusdam quasi.Rem magnam ad
                      perferendis iusto sint tempora ea voluptatibus iure, animi excepturi modi aut
                      possimus in hic molestias repellendus illo ullam odit quia velit.</p>

                  </div>
                  <!--/Second column-->
                </div>
                <!--/First row-->

              </div>
              <!--/.Panel 1-->

              <!--Panel 2-->
              <div class="tab-pane fade" id="panel32" role="tabpanel">
                <br>

                <!--First row-->
                <div class="row d-flex justify-content-center">

                  <!--First column-->
                  <div class="col-lg-3 col-md-6 pb-5">

                    <!--Featured image-->
                    <div class="view overlay z-depth-1 z-depth-2">
                      <img src="https://mdbootstrap.com/img/Photos/Vertical/People/img%20%283%29.jpg" class="img-fluid">
                    </div>
                  </div>
                  <!--/First column-->

                  <!--Second column-->
                  <div class="col-lg-6 col-md-12 text-left">

                    <!--Title-->
                    <h4 class="mb-3">Anna Moon</h4>

                    <!--Description-->
                    <p class="grey-text" align="justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo
                      animi soluta ratione
                      quisquam, dicta ab cupiditate iure eaque? Repellendus voluptatum, magni impedit
                      eaque delectus, beatae maxime temporibus maiores quibusdam quasi.Rem magnam ad
                      perferendis iusto sint tempora ea voluptatibus iure, animi excepturi modi aut
                      possimus in hic molestias repellendus illo ullam odit quia velit.</p>

                  </div>
                  <!--/Second column-->
                </div>
                <!--/First row-->

              </div>
              <!--/.Panel 2-->

              <!--Panel 3-->
              <div class="tab-pane fade" id="panel33" role="tabpanel">
                <br>

                <!--First row-->
                <div class="row d-flex justify-content-center">

                  <!--First column-->
                  <div class="col-lg-3 col-md-6 pb-5">

                    <!--Featured image-->
                    <div class="view overlay z-depth-1 z-depth-2">
                      <img src="https://mdbootstrap.com/img/Photos/Vertical/People/img%20%284%29.jpg" class="img-fluid">
                    </div>
                  </div>
                  <!--/First column-->

                  <!--Second column-->
                  <div class="col-lg-6 col-md-12 text-left">

                    <!--Title-->
                    <h4 class="mb-3">Maria Clark</h4>

                    <!--Description-->
                    <p class="grey-text" align="justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo
                      animi soluta ratione
                      quisquam, dicta ab cupiditate iure eaque? Repellendus voluptatum, magni impedit
                      eaque delectus, beatae maxime temporibus maiores quibusdam quasi.Rem magnam ad
                      perferendis iusto sint tempora ea voluptatibus iure, animi excepturi modi aut
                      possimus in hic molestias repellendus illo ullam odit quia velit.</p>

                  </div>
                  <!--/Second column-->
                </div>
                <!--/First row-->

              </div>
              <!--/.Panel 3-->

            </div>
            <!--/Tab panels-->

          </div>
          <!--/First column-->

        </div>
        <!--/First row-->

      </section>
      <!--/Projects section v.3-->

    </div>

    <div class="container-fluid grey lighten-3">
      <div class="container">

        <!--Section: Pricing v.1-->
        <section id="pricing" class="pb-5 pt-3">

          <!--Section heading-->
          <h1 class="text-center mb-5 h1 pt-5 mt-5">Our pricing plans</h1>

          <!--Section description-->
          <p class="text-center w-responsive mx-auto my-5 grey-text">Lorem ipsum dolor sit amet, consectetur
            adipisicing elit. Fugit, error amet numquam iure provident voluptate
            esse quasi, veritatis totam voluptas nostrum quisquam eum porro a pariatur accusamus veniam.</p>

          <!--Grid row-->
          <div class="row">

            <!--Grid column-->
            <div class="col-lg-4 col-md-12 mb-4">

              <!--Pricing card-->
              <div class="card pricing-card">
                <!-- Price -->
                <div class="price header white-text blue lighten-3 rounded-top">
                  <h2 class="number">10</h2>
                  <div class="version">
                    <h5 class="mb-0">Basic</h5>
                  </div>
                </div>

                <!--Features-->
                <div class="card-body striped darker-striped">
                  <ul>
                    <li>
                      <p class="mt-1"><i class="fas fa-check"></i> 20 GB Of Storage</p>
                    </li>
                    <li>
                      <p><i class="fas fa-check"></i> 2 Email Accounts</p>
                    </li>
                    <li>
                      <p><i class="fas fa-times"></i> 24h Tech Support</p>
                    </li>
                    <li>
                      <p><i class="fas fa-times"></i> 300 GB Bandwidth</p>
                    </li>
                    <li>
                      <p><i class="fas fa-times"></i> User Management </p>
                    </li>
                  </ul>

                  <button class="btn btn-blue btn-rounded mb-3">Buy now</button>
                </div>
                <!--Features-->

              </div>
              <!--Pricing card-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-4 col-md-6 mb-4">

              <!--Pricing card-->
              <div class="card pricing-card">
                <!-- Price -->
                <div class="price header white-text blue lighten-3 rounded-top">
                  <h2 class="number">20</h2>
                  <div class="version">
                    <h5 class="mb-0">Pro</h5>
                  </div>
                </div>

                <!--Features-->
                <div class="card-body striped darker-striped">
                  <ul>
                    <li>
                      <p class="mt-1"><i class="fas fa-check"></i> 20 GB Of Storage</p>
                    </li>
                    <li>
                      <p><i class="fas fa-check"></i> 4 Email Accounts</p>
                    </li>
                    <li>
                      <p><i class="fas fa-check"></i> 24h Tech Support</p>
                    </li>
                    <li>
                      <p><i class="fas fa-times"></i> 300 GB Bandwidth</p>
                    </li>
                    <li>
                      <p><i class="fas fa-times"></i> User Management </p>
                    </li>
                  </ul>

                  <button class="btn btn-blue btn-rounded mb-3">Buy now</button>
                </div>
                <!--Features-->

              </div>
              <!--Pricing card-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-4 col-md-6 mb-4">
              <!--Pricing card-->
              <div class="card pricing-card">
                <!-- Price -->
                <div class="price header white-text blue lighten-3 rounded-top">
                  <h2 class="number">30</h2>
                  <div class="version">
                    <h5 class="mb-0">Enterprise</h5>
                  </div>
                </div>

                <!--Features-->
                <div class="card-body striped darker-striped">
                  <ul>
                    <li>
                      <p class="mt-1"><i class="fas fa-check"></i> 30 GB Of Storage</p>
                    </li>
                    <li>
                      <p><i class="fas fa-check"></i> 5 Email Accounts</p>
                    </li>
                    <li>
                      <p><i class="fas fa-check"></i> 24h Tech Support</p>
                    </li>
                    <li>
                      <p><i class="fas fa-check"></i> 300 GB Bandwidth</p>
                    </li>
                    <li>
                      <p><i class="fas fa-check"></i> User Management </p>
                    </li>
                  </ul>

                  <button class="btn btn-blue btn-rounded mb-3">Buy now</button>
                </div>
                <!--Features-->

              </div>
              <!--Pricing card-->
            </div>
            <!--Grid column-->

          </div>
          <!--Grid row-->

        </section>
        <!--Section: Pricing v.1-->

      </div>
    </div>

    <div class="container">

      <!-- Section: Contact v.3 -->
      <section class="contact-section my-5">

        <!-- Form with header -->
        <div class="card">

          <!-- Grid row -->
          <div class="row">

            <!-- Grid column -->
            <div class="col-lg-8">

              <div class="card-body form">

                <!-- Header -->
                <h3 class="mt-4"><i class="fas fa-envelope pr-2"></i>Write to us:</h3>

                <!-- Grid row -->
                <div class="row">

                  <!-- Grid column -->
                  <div class="col-md-6">
                    <div class="md-form mb-0">
                      <input type="text" id="form-contact-name" class="form-control">
                      <label for="form-contact-name" class="">Your name</label>
                    </div>
                  </div>
                  <!-- Grid column -->

                  <!-- Grid column -->
                  <div class="col-md-6">
                    <div class="md-form mb-0">
                      <input type="text" id="form-contact-email" class="form-control">
                      <label for="form-contact-email" class="">Your email</label>
                    </div>
                  </div>
                  <!-- Grid column -->

                </div>
                <!-- Grid row -->

                <!-- Grid row -->
                <div class="row">

                  <!-- Grid column -->
                  <div class="col-md-6">
                    <div class="md-form mb-0">
                      <input type="text" id="form-contact-phone" class="form-control">
                      <label for="form-contact-phone" class="">Your phone</label>
                    </div>
                  </div>
                  <!-- Grid column -->

                  <!-- Grid column -->
                  <div class="col-md-6">
                    <div class="md-form mb-0">
                      <input type="text" id="form-contact-company" class="form-control">
                      <label for="form-contact-company" class="">Your company</label>
                    </div>
                  </div>
                  <!-- Grid column -->

                </div>
                <!-- Grid row -->

                <!-- Grid row -->
                <div class="row">

                  <!-- Grid column -->
                  <div class="col-md-12">
                    <div class="md-form mb-0">
                      <textarea type="text" id="form-contact-message" class="form-control md-textarea" rows="3"></textarea>
                      <label for="form-contact-message">Your message</label>
                      <a class="btn-floating btn-lg blue">
                        <i class="far fa-paper-plane"></i>
                      </a>
                    </div>
                  </div>
                  <!-- Grid column -->

                </div>
                <!-- Grid row -->

              </div>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-lg-4">

              <div class="card-body contact text-center h-100 white-text light-blue darken-2">

                <h3 class="my-4 pb-2">Contact information</h3>
                <ul class="text-lg-left list-unstyled ml-4">
                  <li>
                    <p><i class="fas fa-map-marker-alt pr-2 white-text"></i>New York, 94126, USA</p>
                  </li>
                  <li>
                    <p><i class="fas fa-phone pr-2 white-text"></i>+ 01 234 567 89</p>
                  </li>
                  <li>
                    <p><i class="fas fa-envelope pr-2 white-text"></i>contact@example.com</p>
                  </li>
                </ul>
                <hr class="hr-light my-4">
                <ul class="list-inline text-center list-unstyled">
                  <li class="list-inline-item">
                    <a class="p2 fa-lg tw-ic">
                      <i class="fab fa-twitter white-text"></i>
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a class="p2 fa-lg li-ic">
                      <i class="fab fa-linkedin-in white-text"> </i>
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a class="p2 fa-lg ins-ic">
                      <i class="fab fa-instagram white-text"> </i>
                    </a>
                  </li>
                </ul>

              </div>

            </div>
            <!-- Grid column -->

          </div>
          <!-- Grid row -->

        </div>
        <!-- Form with header -->

      </section>
      <!-- Section: Contact v.3 -->

      <hr>

      <!--Section: Testimonials v.2-->
      <section id="testimonials" class="mb-5 pb-4">

        <!--Section heading-->
        <h1 class="text-center mb-5 mt-5 pt-4 font-weight-bold dark-grey-text wow fadeIn" data-wow-delay="0.2s">What
          Clients said:</h1>

        <div class="wrapper-carousel-fix">

          <!--Carousel Wrapper-->
          <div id="carousel-example-1" class="carousel no-flex testimonial-carousel slide carousel-fade wow fadeIn"
            data-wow-delay="0.4s" data-ride="carousel" data-interval="false">

            <!--Slides-->
            <div class="carousel-inner" role="listbox">
              <!--First slide-->
              <div class="carousel-item active">

                <div class="testimonial text-center">
                  <!--Avatar-->
                  <div class="avatar mx-auto mb-4">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%2820%29.jpg" class="rounded-circle img-fluid">
                  </div>
                  <!--Content-->
                  <p><i class="fas fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Quod eos id officiis hic tenetur quae quaerat ad velit ab. Lorem ipsum dolor sit amet,
                    consectetur adipisicing elit. Dolore cum accusamus eveniet molestias voluptatum inventore
                    laboriosam labore sit, aspernatur praesentium iste impedit quidem dolor veniam.
                  </p>

                  <h4>Anna Deynah</h4>

                  <!--Review-->
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                </div>

              </div>
              <!--/First slide-->

              <!--Second slide-->
              <div class="carousel-item">

                <div class="testimonial text-center">
                  <!--Avatar-->
                  <div class="avatar mx-auto mb-4">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%2817%29.jpg" class="rounded-circle img-fluid">
                  </div>
                  <!--Content-->
                  <p><i class="fas fa-quote-left"></i> Nemo enim ipsam voluptatem quia voluptas sit aspernatur
                    aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi
                    nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                    adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore.
                  </p>

                  <h4>Maria Kate</h4>

                  <!--Review-->
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star-half-alt"> </i>
                </div>

              </div>
              <!--/Second slide-->

              <!--Third slide-->
              <div class="carousel-item">

                <div class="testimonial text-center">
                  <!--Avatar-->
                  <div class="avatar mx-auto mb-4">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%289%29.jpg" class="rounded-circle img-fluid">
                  </div>
                  <!--Content-->
                  <p><i class="fas fa-quote-left"></i> Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                    sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde
                    omnis iste natus error sit voluptatem accusantium.
                  </p>

                  <h4>John Doe</h4>

                  <!--Review-->
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                  <i class="fas fa-star"> </i>
                </div>

              </div>
              <!--/Third slide-->
            </div>
            <!--/Slides-->

            <!--Controls-->
            <a class="carousel-control-prev left carousel-control" href="#carousel-example-1" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next right carousel-control" href="#carousel-example-1" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
            <!--/.Controls-->
          </div>
          <!--/Carousel Wrapper-->
        </div>

      </section>
      <!--/Section: Testimonials v.2-->

    </div>

  </main>
  <!--/Main content-->

  <!--Footer-->
  <footer class="page-footer text-center text-md-left stylish-color-dark pt-0">
{{--
    <div class="top-footer-color">
      <div class="container">
        <div class="row py-4 d-flex align-items-center">
          <div class="col-md-6 col-lg-5 text-center text-md-left mb-md-0">
            <h6 class="mb-0 white-text">Get connected with us on social networks!</h6>
          </div>
          <div class="col-md-6 col-lg-7 text-center text-md-right">
            <a class="p-2 m-2 fa-lg fb-ic ml-0"><i class="fab fa-facebook-f white-text mr-lg-4"> </i></a>
            <a class="p-2 m-2 fa-lg tw-ic"><i class="fab fa-twitter white-text mr-lg-4"> </i></a>
            <a class="p-2 m-2 fa-lg gplus-ic"><i class="fab fa-google-plus-g white-text mr-lg-4"> </i></a>
            <a class="p-2 m-2 fa-lg li-ic"><i class="fab fa-linkedin-in white-text mr-lg-4"> </i></a>
            <a class="p-2 m-2 fa-lg ins-ic"><i class="fab fa-instagram white-text mr-lg-4"> </i></a>
          </div>
        </div>
      </div>
    </div> --}}


    {{-- <div class="container mt-5 mb-4 text-center text-md-left">
      <div class="row mt-3">
        <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
          <h6 class="text-uppercase font-weight-bold"><strong>Company name</strong></h6>
          <hr class="blue mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>Here you can use rows and columns here to organize your footer content. Lorem ipsum dolor sit amet,
            consectetur
            adipisicing elit.</p>
        </div>
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase font-weight-bold"><strong>Products</strong></h6>
          <hr class="blue mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p><a href="#!">MDBootstrap</a></p>
          <p><a href="#!">MDWordPress</a></p>
          <p><a href="#!">BrandFlow</a></p>
          <p><a href="#!">Bootstrap Angular</a></p>
        </div>
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase font-weight-bold"><strong>Useful links</strong></h6>
          <hr class="blue mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p><a href="#!">Your Account</a></p>
          <p><a href="#!">Become an Affiliate</a></p>
          <p><a href="#!">Shipping Rates</a></p>
          <p><a href="#!">Help</a></p>
        </div>
        <div class="col-md-4 col-lg-3 col-xl-3">
          <h6 class="text-uppercase font-weight-bold"><strong>Contact</strong></h6>
          <hr class="blue mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p><i class="fas fa-home mr-3"></i> New York, NY 10012, US</p>
          <p><i class="fas fa-envelope mr-3"></i> info@example.com</p>
          <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
          <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
        </div>
      </div>
    </div> --}}

    <!-- Copyright-->
    <div class="footer-copyright py-3 text-center wow fadeIn" data-wow-delay="0.3s">
      <div class="container-fluid">
        © 2022 <a href="https://loginweb.dev" target="_blank"> LoginWeb - Desarrollo de Software </a>
      </div>
    </div>
    <!--/.Copyright -->

  </footer>
  {{-- <div id="myWP"></div> --}}
  <!--/.Footer-->

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="{{ asset('mdb/js/jquery-3.4.1.min.js') }}"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="{{ asset('mdb/js/popper.min.js') }}"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="{{ asset('mdb/js/mdb.min.js') }}"></script>
  <script src="{{ asset('js/floating-wpp.js') }}"></script>
  <!-- Custom scripts -->
  <script>
    $(document).ready(function() {
        // whatsapp ------------------------------------
        $('#myWP').floatingWhatsApp({
            phone: '71130523',
            popupMessage: 'Hola',
            message: 'Hola 2',
            showPopup: true,
            showOnIE: true,
            headerTitle: '',
            headerColor: '',
            backgroundColor: '',
            buttonImage: '',
            position: '',
            autoOpenTimeout: 1000,
            size: 50
        });
    });

    // Animation init
    new WOW().init();

  </script>

</body>

</html>
