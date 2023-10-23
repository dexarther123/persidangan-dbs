@extends('layouts.ikebs')
<head>
<title>Senarai Usul | Sistem Ahli DBS </title>   
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
@section('content')
<div class="page-header">
    <h1 class="page-title">Senarai Usul</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('president/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Senarai Usul</li>
        </ol>
    </div>
</div>
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Senarai Usul</h3>
                <div class="card-options">
                    <div class="btn-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary mt-1 mb-1" id="addUsul" name="addUsul">Tambah Usul</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="filterForm">
                    <div class="row" style="padding-top:0px; padding-bottom:20px">
                        <label style="font-weight: bold;" for="filter_kluster" class="col-md-2 form-label">{{ __('Kluster') }}</label>
                        <div class="col-md-2  mt-md-0">
                            <select name="filter_kluster" id="filter_kluster" class="form-control form-select" data-bs-placeholder="{{ __('Pilih Kluster') }}">
                                <option value="">--Pilih Kluster--</option>
                                @foreach($data_usulkluster as $usul_kluster)
                                <option value="{{ $usul_kluster->kluster_id }}">{{ $usul_kluster->nama_kluster }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2  mt-md-0">
                            <button type="button" class="btn btn-blue mt-1 mb-1" id="resetForm" name="resetForm">Tetapan Semula</button>
                        </div>
                    </div>
                    </form>
                <div class="table-responsive">
                <table class="table table-bordered text-nowrap border-bottom" width="100%" id="usul-data">
                   <thead>
                    <tr>
                        <th>ID</th>
                        <th>KLUSTER</th>
                        <th>KLUSTER ID</th>
                        <th>USUL</th>
                        <th>JUMLAH DIPILIH</th>
                        <th>TINDAKAN</th>
                    </tr>
                   </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add Usul Modal -->
<div class="modal fade" id="ajax-addusul-model" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5  style="font-weight: bold;"  class="modal-title" id="ajaxaddUsulModel"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addUsulForm" name="addUsulForm" class="form-horizontal" method="POST" enctype="multipart/form-data" >
                    <div class=" row mb-4">
                        <label  style="font-weight: bold;"  for="cluster" class="col-md-3 form-label">{{ __('Kluster') }}<span style="color:red">*</span></label>
                        <div class="col-md-6  mt-md-0">
                            <select name="kluster_id" id="kluster_id" class="form-control form-select" data-bs-placeholder="{{ __('Pilih Kluster') }}" required>
                                <optgroup label="Pilih Kluster">
                                <option unselected hidden="">Pilih Kluster</option>
                                @foreach($data_kluster as $kluster)
                                    <option value="{{ $kluster->id }}">{{ $kluster->nama_kluster }}</option>
                                @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4" >
                        <label  style="font-weight: bold;"  for="title" class="col-md-3 form-label">{{ __('Usul') }}<span style="color:red">*</span></label>
                        <div class="col-md-6  mt-md-0">
                            <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('') }}" required>
                        </div>
                    </div> 
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-save" >Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Usul Modal -->

<!--Edit Usul Modal -->
<div class="modal fade" id="ajax-edit-usul-model" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold;" class="modal-title" id="ajaxEditUsulModel"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="editStatusForm" name="editStatusForm" class="form-horizontal" method="POST" enctype="multipart/form-data" >
                    <input type="hidden" name="id_edit" id="id_edit">

                    <div class=" row mb-4">
                        <label style="font-weight: bold;" for="kluster_edit" class="col-md-3 form-label">{{ __('Kluster') }}</label>
                        <div class="col-md-6  mt-md-0">
                            <select name="kluster_edit" id="kluster_edit" class="form-control form-select" data-bs-placeholder="{{ __('Pilih Kluster') }}" required>
                                <optgroup label="Pilih Kluster">
                                <option unselected hidden="">Pilih Kluster</option>
                                @foreach($data_kluster as $kluster)
                                    <option value="{{ $kluster->nama_kluster }}">{{ $kluster->nama_kluster }}</option>
                                @endforeach
                                </optgroup>
                            </select> 
                      </div>
                    </div>

                    <div class=" row mb-4">
                        <label style="font-weight: bold;" for="title_edit" class="col-md-3 form-label">{{ __('Usul') }}</label>
                        <div class="col-md-6  mt-md-0">
                            <input class="form-control" id="title_edit" name="title_edit" type="text">  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-save-edit" value="updateLeave">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end edit Usul model -->

<!--Success update Modal -->
<div class="modal fade" id="success-modal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body text-center p-4 pb-5">
                <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                <i class="fa fa-check fs-70 text-success lh-1 my-5 d-inline-block"></i>
                <h4 class="text-success tx-semibold">Berjaya!</h4>
                <p class="mg-b-20 mg-x-20" id="success-message"></p>
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

        document.getElementById("resetForm").addEventListener("click", function () {
            // Reset the form by setting the values to their default states
            document.getElementById("filter_kluster").value = "";
            dataTable.draw();
        });
        
        $('#addUsul').click(function () {
                $('#addUsulForm').trigger("reset");
                $('#ajaxaddUsulModel').html("Tambah Usul");
                $('#ajax-addusul-model').modal('show');
        });

        $('#addUsulForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $("#btn-save").html('Processing...');
            $("#btn-save"). attr("disabled", true);
            //ajax
            $.ajax({

                type: "POST",
                url: "{{ url('ikebs/store-usul') }}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#ajax-addusul-model").modal('hide');
                    var oTable = $('#usul-data').DataTable();
                    oTable.ajax.reload(null, false);
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                    $("#success-modal").modal('show');
                    $("#success-message").html('Anda telah berjaya tambah usul.');
                },
                error: function(data, responseJSON) {
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                    $('#addUsulForm').trigger("reset");
                    console.log(data);

                    var errors = '';
                    for(datos in data.responseJSON){
                        errors += data.responseJSON[datos] + '<br>';
                    }
                    $('#all_error').show().html(errors); 
                    setTimeout(function() { $("#all_error").hide(); }, 5000);
                }
            });

        });

        var dataTable = $('#usul-data').DataTable({
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
              url: "{{ url('ikebs/senarai-usul') }}",
              data: function (d) {
                    d.filter_kluster = $('#filter_kluster').val(),
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                    { data: 'no', name: 'no', orderable: false, searchable: false },
                    { data: 'kluster_name', name: 'kluster_name'  },
                    { data: 'kluster_id', name: 'kluster_id', visible: false},
                    { data: 'title', name: 'title'},
                    { data: 'total_dipilih', name: 'total_dipilih'},
                    { data: 'action', name: 'action' , visible: false},
            ],
            order: [[ 0, 'asc' ]],
        });

        $('#filter_kluster').change(function(){
            dataTable.draw();
        });

        $('body').on('click','.edit',function(){

            var id = $(this).data('id');
            
            //ajax
            $.ajax({
                    type:"POST",
                    url:"{{ url('ikebs/edit-usul') }}",
                    data: { id:id },
                    dataType: 'json',
                    success: function(res){
                        $('#ajaxEditUsulModel').html("Kemas Kini Usul");
                        $('#ajax-edit-usul-model').modal('show');
                        $('#id_edit').val(res.id);
                        $('#kluster_edit').val(res.kluster_name);
                        $('#title_edit').val(res.title);
                    }
                });
        });

        $('#editStatusForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $("#btn-save-edit").html('Processing...');
            $("#btn-save-edit"). attr("disabled", true);

            //ajax
            $.ajax({

                type: "POST",
                url: "{{ url('ikebs/update-usul') }}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#ajax-edit-usul-model").modal('hide');
                    var oTable = $('#usul-data').DataTable();
                    oTable.ajax.reload(null, false);
                    $("#success-modal").modal('show');
                    $("#btn-save-edit").html('Submit');
                    $("#btn-save-edit"). attr("disabled", false);
                    $("#success-message").html('Anda telah berjaya kemas kini status program.');
                },
                error: function(data, responseJSON) {
                    $("#btn-save-edit").html('Submit');
                    $("#btn-save-edit"). attr("disabled", false);
                    $('#editStatusForm').trigger("reset");
                    console.log(data);
                }
            });

        });

        

        setTimeout(function() {
            $('#success-alert').fadeOut('fast');
        }, 3000); // 3 seconds
    
    });     
</script>
@endsection