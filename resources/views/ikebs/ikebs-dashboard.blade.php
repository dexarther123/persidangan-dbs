@extends('layouts.ikebs')
<head>
<title>Dashboard | Sistem Ahli DBS</title>   
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- CHART -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- INPUT DATE FORMAT -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-center" style="padding-top:35px; padding-bottom:15px;"><strong>Graf Pecahan Umur ADBS</strong></h5>
                <div class="chart-container">
                    <div id="myChart_umur" style="height: 450px;">{!! $umur_chart->container() !!}</div>
                    {!! $umur_chart->script() !!}
                </div>
            </div>
        </div>
    </div>
	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-center" style="padding-top:35px; padding-bottom:15px;"><strong>Graf Pecahan Jantina ADBS</strong></h5>
                <div class="chart-container">
                    <div id="myChart" style="height: 450px;">{!! $jantina_chart->container() !!}</div>
                    {!! $jantina_chart->script() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jumlah Undi Persidangan</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered text-nowrap border-bottom" width="100%" id="usul-data">
                   <thead>
                    <tr>
                        <th>ID</th>
                        <th>KLUSTER</th>
                        <th>KLUSTER ID</th>
                        <th>USUL</th>
                        <th>JUMLAH SOKONG</th>
                        <th>JUMLAH TIDAK SOKONG</th>
                        <th>JUMLAH BERKECUALI</th>
                    </tr>
                   </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var dataTable = $('#usul-data').DataTable({
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
              url: "{{ url('ikebs/dashboard') }}",
              data: function (d) {
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                    { data: 'no', name: 'no', searchable: false },
                    { data: 'kluster_name', name: 'kluster_name', visible: false },
                    { data: 'kluster_id', name: 'kluster_id', visible: false},
                    { data: 'title', name: 'title'},
                    { data: 'sokong_votes', name: 'sokong_votes'  },
                    { data: 'tidak_sokong_votes', name: 'tidak_sokong_votes'  },
                    { data: 'berkecuali_votes', name: 'berkecuali_votes'  },
            ],
            order: [[ 0, 'asc' ]],
        });
    
    });     
</script>
@endsection