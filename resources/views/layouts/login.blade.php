<!doctype html>
<html lang="en" dir="ltr" style="--primary01:rgba(108, 95, 252, 0.1); --primary02:rgba(108, 95, 252, 0.2); --primary03:rgba(108, 95, 252, 0.3); --primary06:rgba(108, 95, 252, 0.6); --primary09:rgba(108, 95, 252, 0.9);">

    <head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="SmartMBS">
    
        <!-- title -->
    
        <!-- FAVICON -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo-mbs.png') }}" />
    
        <!-- BOOTSTRAP CSS -->
        <link id="style" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    
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
    
    <body>
        @yield('content')
    </body>
        
    <!-- JQUERY JS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    
    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    
    <!-- INPUT MASK JS-->
    <script src="{{ asset('plugins/input-mask/jquery.mask.min.js') }}"></script>
    
    <!-- SIDEBAR JS -->
    <script src="{{ asset('plugins/sidebar/sidebar.js') }}"></script>
    
    
    <!-- SPARKLINE JS-->
    <script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    
    <!-- INTERNAL Flot JS -->
    <script src="{{ asset('plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('plugins/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('plugins/flot/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('plugins/flot/dashboard.sampledata.js') }}"></script>
    
    <!-- INTERNAL Vector js -->
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

   
</html>
