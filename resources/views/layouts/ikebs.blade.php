<!doctype html>
<html lang="en" dir="ltr">

<head>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-TH1XN8HY7K"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-TH1XN8HY7K');
	</script>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <link rel="shortcut icon" type="image/x-icon" href="#" /> 

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon"  href="{{ asset('img/logo-dbs.png') }}"/>

    <!-- STYLE CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('plugins/icons/icons.css') }}" rel="stylesheet" />

	<!-- Other meta tags and links -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	
	<style>
		body {
			overflow-x: hidden;
		}
	</style>
	
</head>

<body class="app sidebar-mini ltr">

    <!-- page -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                        <a class="logo-horizontal " href="#">
                            <img src="{{ asset('img/logo-dbs.png') }}" class="header-brand-img desktop-logo" alt="logo" style="height: 60px">
                            <img src="{{ asset('img/logo-dbs.png') }}"  class="header-brand-img light-logo" alt="logo" style="height: 60px">
                            <img src="{{ asset('img/logo-dbs.png') }}"  class="header-brand-img light-logo1" alt="logo" style="height: 60px">
                        </a>
                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                                </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">
                                        <!-- COUNTRY -->
                                        <div class="d-flex">
                                        
                                        </div>
                                        <div class="d-flex country">
                                            <a hidden class="nav-link icon text-center" data-bs-target="#country-selector" data-bs-toggle="modal">
                                                <i class="fe fe-globe"></i><span class="fs-16 ms-2 d-none d-xl-block">English</span>
                                            </a>
                                        </div>
                                        <!-- SEARCH -->
                                        <div class="dropdown  d-flex message">
                                            <a hidden id="notifications" class="nav-link icon text-center" data-bs-toggle="dropdown">
                                                <i class="fe fe-bell"></i><span class="pulse-danger"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading border-bottom">
                                                    <div class="d-flex">
                                                        <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">Notifications</h6>
                                                    </div>
                                                </div>
                                                <div class="message-menu" >
                                                    
                                                </div>     
                                            </div>
                                        </div>
                                        <!-- NOTIFICATION-BOX -->
                                        <div class="dropdown d-flex profile-1">
                                            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                                <span class="avatar avatar-md brround me-3 bg-primary " id="name"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold" id="fullname">{{ Auth::user()->name }} </h5>
                                                        <small class="text-muted"></small>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();"><i class="dropdown-icon fa fa-sign-out"></i> 
                                                    {{ __('Log Keluar') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
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
                    <div class="side-header">
                        <a class="header-brand1" href="#">
                            <img src="{{ asset('img/logo-dbs.png') }}" class="header-brand-img desktop-logo" alt="logo" style="height: 100%">
                            <img src="{{ asset('img/logo-dbs.png') }}"  class="header-brand-img toggle-logo" alt="logo" style="height: 100%">
                            <img src="{{ asset('img/logo-dbs.png') }}"  class="header-brand-img light-logo" alt="logo" style="height: 100%">
                            <img src="{{ asset('img/logo-dbs.png') }}"  class="header-brand-img light-logo1" alt="logo" style="height: 100%">
                        </a>
                    </div>
                    <div class="main-sidemenu">
                        <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
                        <ul class="side-menu">
                            <li class="sub-category">
                                <h3>MENU</h3>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('ikebs/dashboard') }}"><i class="side-menu__icon fa fa-bar-chart"></i><span class="side-menu__label">Dashboard</span></a>
                            </li>
							<li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('ikebs/senarai-usul') }}"><i class="side-menu__icon fa fa-align-justify"></i><span class="side-menu__label">Senarai Usul</span></a>
                            </li>	
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();"><i class="side-menu__icon fa fa-sign-out"></i><span class="side-menu__label">Log Keluar</span>
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
                    </div>
                </div>
            </div>
        </footer>
        <!-- FOOTER CLOSED -->

    </div>
    <!-- page -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <script>
        const f = document.getElementById("fullname").innerHTML;
        document.getElementById("name").innerHTML = f.substring(0, 1);
    </script>
	
	<!-- JQUERY JS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- SIDE-MENU JS -->
    <script src="{{ asset('plugins/sidemenu/sidemenu.js') }}"></script>

    <!-- SIDEBAR JS -->
    <script src="{{ asset('plugins/sidebar/sidebar.js') }}"></script>
    
    <!-- DATA TABLE JS-->
    <script src="{{ asset('plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.buttons.min.js') }} "></script>
    <script src="{{ asset('plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/pdfmake/pdfmake.min.js') }} "></script>
    <script src="{{ asset('plugins/datatable/pdfmake/vfs_fonts.js') }} "></script>
    <script src="{{ asset('plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/responsive.bootstrap5.min.js') }} "></script>
    
    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	
	<!-- SELECT2 JS -->
   <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>

</body>

</html>