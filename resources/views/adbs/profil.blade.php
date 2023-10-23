@extends('layouts.adbs')
<head>
    <!-- ========== Page Title ========== -->
      <title>Profil | Sistem Ahli DBS</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<head>

@section('content')   
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Profil</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->
<div class="row">
    @if(isset($profile))
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Profil</div>
            </div>
            <div class="card-body">
                <div class="text-center chat-image mb-5">
                    <div class="avatar avatar-xxl chat-profile mb-3 brround">
                        <a class="" ><img alt="avatar"  src="{{ asset('calon/' . $profile->passport_calon) }}" class="brround"></a>
                    </div>
                    <div class="main-chat-msg-name">
                        <a>
                            <h5 class="mb-1 text-dark fw-semibold">{{ $profile->nama }}</h5>
                        </a>
                        <p class="text-muted mt-0 mb-0 pt-0 fs-13">{{ $profile->dun }}</p>
                    </div>
                </div>
                <div class="card-body no-padding">
                    <ul class="list-group no-margin">
                        <li class="list-group-item d-flex ps-3">
                            <div class="social social-profile-buttons me-2">
                                <a class="social-icon text-primary" href=""><i class="fe fe-mail"></i></a>
                            </div>
                            <span class="my-auto">{{ $profile->emel }}</span>
                        </li>
                        <li class="list-group-item d-flex ps-3">
                            <div class="social social-profile-buttons me-2">
                                <a class="social-icon text-primary" href=""><i class="fe fe-phone"></i></a>
                            </div>
                            <span class="my-auto">{{ $profile->no_tel }}</span>
                        </li>
                        <li class="list-group-item d-flex ps-3">
                            <div class="social social-profile-buttons me-2">
                                <a class="social-icon text-primary" href=""><i class="fa fa-map"></i></a>
                            </div>
                            <span class="my-auto">{{ $profile->alamat }}</span>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
    @else
        <p>No profile found for this user.</p>
    @endif
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kemas Kini Kata Kunci</h3>
            </div>
            <form method="POST" action="{{ route('adbs-update-password') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger" id="error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            
            <!-- display success message -->
            @if(session('success'))
                <div id="success" class="alert alert-success">{{ session('success') }}</div>
            @endif
                <div class="form-group">
                    <label class="form-label">Kata Laluan Semasa</label>
                    <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                            <i class="fe fe-eye text-muted" aria-hidden="true"></i>
                        </a>
                        <input id="current_password" name="current_password" class="input100 form-control" type="password" placeholder="Kata Laluan Semasa">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Kata Laluan Baru</label>
                    <div class="wrap-input100 validate-input input-group" id="Password-toggle1">
                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                            <i class="fe fe-eye text-muted" aria-hidden="true"></i>
                        </a>
                        <input id="new_password" name="new_password" class="input100 form-control" type="password" placeholder="Kata Laluan Baru">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Pengesahan Kata Laluan</label>
                    <div class="wrap-input100 validate-input input-group" id="Password-toggle1">
                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                            <i class="fe fe-eye text-muted" aria-hidden="true"></i>
                        </a>
                        <input id="confirm_password" name="confirm_password" class="input100 form-control" type="password" placeholder="Kata Laluan Baru">
                    </div>
                </div>
                
            </div>
            <div class="card-footer text-end">
                <button type="reset" class="btn btn-white my-1" onclick="resetForm()">Tetapan Semula</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
            </div>
            </form>
        </div>
        
    </div>
</div>
<script>
    function resetForm() {
      document.getElementById("current_password").value = "";
      document.getElementById("new_password").value = "";
      document.getElementById("confirm_password").value = "";
    }
    </script>
    <script>
        setTimeout(function() {
            $('#success').fadeOut('fast');
        }, 3000); // 3 seconds

        setTimeout(function() {
            $('#error').fadeOut('fast');
        }, 3000); // 3 seconds
    </script>
@endsection
