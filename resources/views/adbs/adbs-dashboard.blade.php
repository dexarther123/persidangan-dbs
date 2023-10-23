@extends('layouts.adbs')
<head>
    <!-- ========== Page Title ========== -->
    <title>Dashboard | Sistem Ahli DBS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<head>

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        </ol>
    </div>
</div>
@endsection
