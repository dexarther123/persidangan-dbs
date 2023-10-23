@extends('layouts.adbs')
<head>
    <!-- ========== Page Title ========== -->
    <title>Senarai Calon | Dewan Belia Sabah</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<head>
    @section('content')
    <div class="page-header">
        <h1 class="page-title">Senarai Usul</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Senarai Usul</a></li>
            </ol>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Senarai Usul Dipilih  (<span id="totalCheckedSpan">0</span>)</h3>
                    <div class="card-options">
                        <div class="btn-group">
                            <div class="btn-group">
                            <button type="button" class="btn btn-primary mt-1 mb-1" id="showTotalCheckedButton">Hantar</button>
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
                                <option disabled>--Pilih Kluster--</option>
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
                            <th>PILIH</th>
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
<!--Start Confirm Modal -->
    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: bold;" class="modal-title">Pengesahan Pilih Usul</h5>
                    <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body text-center p-4 pb-5">
                    <h6><strong>Adakah anda pasti pilih senarai usul ini?</strong></h6>
                    <input type="text" id="checkedUsulIdsInput" >
                        <!-- Checked titles will be displayed here dynamically -->
                    </p>
                    <ul id="checkedTitlesList" class="list-group">
                        <!-- Checked titles will be displayed here dynamically -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light pd-x-25" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" id="submitBtn" class="btn btn-primary pd-x-25">Ya</button>
                </div>
            </div>
        </div>
    </div>
<!--End Confirm Modal -->

<!--Start Success update Modal -->
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
<!--End Success update Modal -->

<!--Start Error update Modal -->
<div class="modal fade" id="error-modal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body text-center p-4 pb-5">
                <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                <i class="fa fa-times fs-70 text-danger lh-1 my-5 d-inline-block"></i>
                <h4 class="text-danger tx-semibold">Tidak Berjaya!</h4>
                <p class="mg-b-20 mg-x-20" id="error-message"></p>
            </div>
        </div>
    </div>
</div>
<!--End Error update Modal -->
<script type="text/javascript">
    $(document).ready(function () {
    let totalCheckedUsul = 0;
    let checkedUsuls = {}; // Store checked usuls
    let checkedTitles = []; // Store checked titles

    // Event handler for the "Show Total Checked Usuls" button
    $('#showTotalCheckedButton').click(function () {
        if(totalCheckedUsul == '9' ){
            openCheckedTitlesModal(); // Show checked titles
        } else{
            alert('Anda mesti pilih 9 usul daripada 9 kluster. ' + 'Jumlah Usul Dipilih: ' + totalCheckedUsul );
        }
        
    });

    // Function to open the modal and display checked titles
    function openCheckedTitlesModal() {
        const modal = $('#confirm-modal');
        const checkedTitlesList = $('#checkedTitlesList');

        checkedTitlesList.empty(); // Clear the list

        // Populate the list with checked titles
        for (const title of checkedTitles) {
            checkedTitlesList.append($('<li>').text(title).addClass('list-group-item'));
        }

        modal.modal('show');
    }

    // Event handler for the "Tetapan Semula" button
    $('#resetForm').click(function () {
        reset();
    });

    function reset() {
        document.getElementById("filter_kluster").value = "1";
        // Clear the checkedUsulIds Set
        checkedUsulIds.clear();

        dataTable.draw();
        // Uncheck all checkboxes
        $('.usulCheckbox').prop('checked', false);

        // Clear the checkedUsuls object
        checkedUsuls = {};

        // Clear the checkedTitles array
        checkedTitles = [];

        // Update the total checked count
        updateTotalChecked();

        // Update the checkbox states
        updateCheckboxStates();

        // Update the total checked count in the breadcrumb
        $('#totalCheckedSpan').text(totalCheckedUsul);
    }

    // Event handler for the filter select element
    $('#filter_kluster').change(function () {
        dataTable.draw();
    });

    let checkedUsulIds = new Set(); // Use a Set to store unique Usul IDs

// Event handler for the checkbox change
$(document).on('change', '.usulCheckbox', function () {
    let usulId = $(this).data('id');
    let isChecked = $(this).prop('checked');
    let title = $(this).data('title');

    if (isChecked) {
        checkedUsuls[usulId] = true;

        // Add the title to the checkedTitles array
        checkedTitles.push(title);

        // Add the Usul ID to the checkedUsulIds Set
        checkedUsulIds.add(usulId);
    } else {
        checkedUsuls[usulId] = false;

        // Remove the title from the checkedTitles array
        const index = checkedTitles.indexOf(title);
        if (index > -1) {
            checkedTitles.splice(index, 1);
        }

        // Remove the Usul ID from the checkedUsulIds Set
        checkedUsulIds.delete(usulId);
    }

    updateTotalChecked();
    updateCheckboxStates();

    // Update the total checked count in the breadcrumb
    $('#totalCheckedSpan').text(totalCheckedUsul);

    $('#checkedUsulIdsInput').val(Array.from(checkedUsulIds).join(','));
});


    function updateCheckboxStates() {
        let checkedCount = $('.usulCheckbox:checked').length;

        if (checkedCount === 1) {
            $('.usulCheckbox:not(:checked)').prop('disabled', true).addClass('disabled');
        } else {
            $('.usulCheckbox').prop('disabled', false).removeClass('disabled');
        }
    }

    // Function to update the total checked count
    function updateTotalChecked() {
        totalCheckedUsul = Object.values(checkedUsuls).filter(Boolean).length;
    }

    var dataTable = $('#usul-data').DataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('adbs/pilih-usul') }}",
            data: function (d) {
                d.filter_kluster = $('#filter_kluster').val(),
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [
            { data: 'action', name: 'action', orderable: false },
            { data: 'id', name: 'id', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'kluster_name', name: 'kluster_name' },
            { data: 'kluster_id', name: 'kluster_id', visible: false },
            
            
        ],
        order: [[0, 'asc']],
        drawCallback: function () {
            // Re-check the previously checked usuls after table redraw
            for (const usulId in checkedUsuls) {
                if (checkedUsuls[usulId]) {
                    $(`.usulCheckbox[data-id="${usulId}"]`).prop('checked', true);
                }
            }

            // Update the total checked count
            updateTotalChecked();

            // Update the checkbox states
            updateCheckboxStates();
        }
    });

    // Initial call to update the total checked count
    updateTotalChecked();

    // Event handler for the "Submit" button
    $('#submitBtn').click(function () {
        // Perform the vote submission here
        // Send the checked Usul IDs to your server for storage
        $.ajax({
            type: 'POST',
            url: '{{ route('adbs-store-pilih-usul') }}', // Replace with your route URL
            data: {
                _token: "{{ csrf_token() }}", // Include the CSRF token in the request data
                checkedUsulIds: $('#checkedUsulIdsInput').val(),
            },
            success: function (response) {
                document.getElementById("filter_kluster").value = "1";
                $('.usulCheckbox').prop('checked', false);
                checkedUsuls = {};
                checkedTitles = [];
                updateTotalChecked();
                updateCheckboxStates();
                $('#totalCheckedSpan').text(totalCheckedUsul);
                if (response.status === 'success') {
                    // Display the success message in the success modal
                    dataTable.draw();
                    $('#success-message').text(response.message);
                    $('#success-modal').modal('show');
                } else if (response.status === 'error') {
                    // Display the error message in the error modal
                    $('#error-message').text(response.message);
                    $('#error-modal').modal('show');
                }
                $('#confirm-modal').modal('hide');
                reset();
            },
            error: function (xhr, status, error) {
                // Handle errors or display error messages
                console.log(error);
            }
        });
    });

});

    </script>
    @endsection