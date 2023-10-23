@extends('layouts.login')
<head>
    <title>Login | Sistem Ahli DBS</title>
    <style>
        .page {
           background-image: url('/img/mbscover.jpg');
           background-repeat: repeat-x;
           background-size: contain;
           background-position: bottom center;  
           background-color: #0207e5;
          }
        @media only screen and (max-width: 600px) {
        .page {
           background-image: url('/img/mbscovermobile.jpg');
           background-repeat: repeat-x;
           background-size: contain;
           background-position: bottom center;  
          }
        }

    </style>
</head>

@section('content')
<!-- BACKGROUND-IMAGE -->
<div class="login-img">
    <div class="page"  >
        <div class="container">
            <div class="row justify">
                            <div class="text-center">
                                <img src="{{ asset('img/logo-dbs.png') }}"  style="height:100px;" class="header-brand-img m-0" alt="">
                            </div>
                            <h3 class="text-center text-white" style="padding-top:10px" ><strong>Sistem Ahli DBS</strong></h3>
            </div>
            <div class="container-login100">
                            <div class="wrap-login100 p-6">
                                <h2 class="login100-form-title">
                                    <strong>Log Masuk</strong>
                                </h2>
                                @if (session('error'))
                                    <div class="alert alert-danger" id="error-alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                               <form method="POST" action="{{ route('login') }}">
                                @csrf
        
                                <div class="row mb-4 ">
                                    <div class="wrap-input100 validate-input input-group" >
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                        </a>
                                        <input id="email" placeholder="E-mel" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-4">
                                    <div class="wrap-input100 validate-input input-group" >
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="fa fa-key" aria-hidden="true"></i>
                                        </a>
                                        <input id="password" placeholder="Kata Laluan" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                </div>
                                
                                <div class="row mb-0">
                                    <div class="col-md-12 ">
                                        <button type="submit" class="login100-form-btn btn-primary" >
                                            {{ __('Log Masuk') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
           
            
        </div>
        
    </div>
<!-- BACKGROUND-IMAGE -->
</div>

@endsection
