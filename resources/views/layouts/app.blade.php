<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Cart</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper"
    class="d-flex justify-content-center align-items-center">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column p-3 m-3">

      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-10 col-md-6">
              <div class="mb-4 d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-4 text-gray-800 text-center">@yield('section_title', 'Title')</h1>
                <!-- cart button -->
                <div class="mb-3">
                  @if (auth()->check() && auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Panel</a>
                  @endif
                  @if(!request()->routeIs('home'))
                    <a href="{{ route('home') }}" class="btn btn-warning">Products</a>
                  @endif

                  <x-view-cart-button />
                  
                  @if (auth()->check())
                  <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Menu
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="#">My Account</a>
                      <a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a>
                      <div class="dropdown-divider"></div>
                      <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
                        @csrf
                        <button type="submit" class="btn btn-link dropdown-item text-danger">
                          Logout
                        </button>
                      </form>
                    </div>
                  </div>


                  @elseif(!auth()->check() && !request()->routeIs('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                  @endif

                </div>
              </div>
            </div>
          </div>

          @yield('content')

          @include('layouts.footer')
        </div>
        <!-- End of Content Wrapper -->

      </div>
      <!-- End of Page Wrapper -->

      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset("assets/vendor/jquery/jquery.min.js") }}"></script>

  <script src=" {{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset("assets/vendor/jquery-easing/jquery.easing.min.js") }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset("assets/js/sb-admin-2.min.js") }}"></script>

</body>

</html>