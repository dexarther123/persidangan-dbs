<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <link rel="shortcut icon" type="image/x-icon" href="{{ url('dashboard') }}" /> 

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon"  href="{{ asset('img/logo-triple.png') }}" />

    <!-- STYLE CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/dark-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/transparent-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/skin-modes.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('plugins/icons/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('css/color1.css') }}" />

</head>

<body class="app sidebar-mini ltr">

    <!-- page -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="text-white app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                        <a class="logo-horizontal " href="{{ url('dashboard') }}">
                            <img src="{{ asset('img/logo-triple.png') }}" class="header-brand-img desktop-logo" alt="logo" style="height: 50px">
                            <img src="{{ asset('img/logo-triple.png') }}"  class="header-brand-img light-logo" alt="logo" style="height: 50px">
                            <img src="{{ asset('img/logo-triple.png') }}"  class="header-brand-img light-logo1" alt="logo" style="height: 50px">
                        </a>
                        
                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon "></span>
								</button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">
                                        
                                        <!-- Theme-Layout -->
                                        <div class="dropdown d-flex">
                                            <a class="nav-link icon full-screen-link nav-link-bg">
                                                <i hidden class="fe fe-minimize fullscreen-button"></i>
                                            </a>
                                        </div>
                                        <!-- FULL-SCREEN -->
                                        
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- /app-Header -->

            <!--APP-SIDEBAR-->
            <div class="sticky">
                <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                <div class="app-sidebar">
                    <div class="side-header bg-red-dark">
                        <a class="header-brand1" href="{{ url('dashboard') }}">
                            <img src="{{ asset('img/logo-triple.png') }}" class="header-brand-img desktop-logo" alt="logo" style="height: 100%">
                            <img src="{{ asset('img/logo-triple.png') }}"  class="header-brand-img toggle-logo" alt="logo" style="height: 100%">
                            <img src="{{ asset('img/logo-triple.png') }}"  class="header-brand-img light-logo" alt="logo" style="height: 100%">
                            <img src="{{ asset('img/logo-triple.png') }}"  class="header-brand-img light-logo1" alt="logo" style="height: 100%">
                        </a>
                        <!-- LOGO -->
                    </div>
                    <div class="main-sidemenu">
                        <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
                        <ul class="side-menu">
                            <li class="sub-category">
                                <h3>MENU</h3>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('dashboard') }}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('vehicle-flow') }}"><i class="side-menu__icon fe fe-list"></i><span class="side-menu__label">Vehicle Flow</span></a>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();"><i class="side-menu__icon fa fa-sign-out"></i><span class="side-menu__label">Logout</span>
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                     @csrf
                                </form>
                            </li>
                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
                    </div>
                </div>
                <!--/APP-SIDEBAR-->
            </div>

            <!--app-content open-->
            <div class="main-content app-content">
                <div class="side-app">
                    @yield('content')
                    </div>
                
            </div>
            <!--app-content closed-->
        </div>
        <!-- page-main closed -->
        <!-- FOOTER -->
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 text-center">
                        Copyright © 2022 <a href="javascript:void(0)">MEGATEQ</a>. Designed by <a href="javascript:void(0)"> MEGATEQ SDN BHD</a> All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
        <!-- FOOTER CLOSED -->

    </div>
    <!-- page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- SIDE-MENU JS -->
    <script src="{{ asset('plugins/sidemenu/sidemenu.js') }}"></script>

    <!-- SIDEBAR JS -->
    <script src="{{ asset('plugins/sidebar/sidebar.js') }}"></script>




</body>

</html>