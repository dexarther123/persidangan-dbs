@extends('layouts.adbs')
<head>
<title>Senarai Usul | Sistem Ahli DBS</title>   
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
    <h1 class="page-title">Senarai Undi Persidangan</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Senarai Undi Persidangan</li>
        </ol>
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
                <h3 class="card-title">Senarai Undi Persidangan</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered text-nowrap border-bottom" width="100%" id="usul-data">
                   <thead>
                    <tr>
                        <th>UNDI</th>
                        <th>ID</th>
                        <th>USUL</th>
                        <th>KLUSTER</th>
                        <th>KLUSTER ID</th>
                    </tr>
                   </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Undi Modal -->
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
                <form action="javascript:void(0)" id="addUndiUsulForm" name="addUndiUsulForm" class="form-horizontal" method="POST" enctype="multipart/form-data" >
                    <input type="hidden" name="id_edit" id="id_edit">

                    <div class=" row mb-4">
                        <label style="font-weight: bold;" for="kluster" class="col-md-3 form-label">{{ __('Kluster') }}</label>
                        <div class="col-md-6  mt-md-0">
                            <input class="form-control" id="kluster" name="kluster" type="text" readonly>  
                      </div>
                    </div>

                    <div class=" row mb-4">
                        <label style="font-weight: bold;" for="title_view" class="col-md-3 form-label">{{ __('Usul') }}</label>
                        <div class="col-md-6  mt-md-0">
                            <input class="form-control" id="title_view" name="title_view" type="text" readonly>  
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label style="font-weight: bold;" for="undi" class="col-md-3 form-label">{{ __('Undi') }}</label>
                        <div class="col-md-6  mt-md-0">
                            <select name="undi" id="undi" class="form-control form-select" data-bs-placeholder="{{ __('Pilih') }}">
                            <option value="">-- Pilih --</option>
                            <option value="0">Sokong</option>
                            <option value="1">Tidak Sokong</option>
                            <option value="2">Berkecuali</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-save-edit" value="updateLeave">Hantar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end undi model -->

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
        
        $('#addUsul').click(function () {
                $('#addUndiUsulForm').trigger("reset");
                $('#ajaxaddUsulModel').html("Tambah Usul");
                $('#ajax-addusul-model').modal('show');
        });

        $('#addUndiUsulForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $("#btn-save").html('Processing...');
            $("#btn-save"). attr("disabled", true);
            //ajax
            $.ajax({

                type: "POST",
                url: "{{ url('adbs/store-undi-usul') }}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    document.getElementById("undi").value = "";
                    $('#ajax-edit-usul-model').modal('hide');
                    var oTable = $('#usul-data').DataTable();
                    oTable.ajax.reload(null, false);
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                    $("#success-modal").modal('show');
                    $("#success-message").html('Anda telah berjaya undi usul.');
                },
                error: function(data, responseJSON) {
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                    $('#addUndiUsulForm').trigger("reset");
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
              url: "{{ url('adbs/undi') }}",
              data: function (d) {
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                    { data: 'action', name: 'action', orderable: false},
                    { data: 'no', name: 'no', orderable: false, searchable: false },
                    { data: 'title', name: 'title'},
                    { data: 'kluster_name', name: 'kluster_name'  },
                    { data: 'kluster_id', name: 'kluster_id', visible: false},
            ],
            order: [[ 0, 'asc' ]],
        });

        $('body').on('click','.edit',function(){

            var id = $(this).data('id');
            
            //ajax
            $.ajax({
                    type:"POST",
                    url:"{{ url('adbs/undi-usul') }}",
                    data: { id:id },
                    dataType: 'json',
                    success: function(res){
                        $('#ajaxEditUsulModel').html(res.title);
                        $('#ajax-edit-usul-model').modal('show');
                        $('#id_edit').val(res.id);
                        $('#kluster').val(res.kluster_name);
                        $('#title_view').val(res.title);
                    }
                });
        });
        

        setTimeout(function() {
            $('#success-alert').fadeOut('fast');
        }, 3000); // 3 seconds
    
    });     
</script>
@endsection