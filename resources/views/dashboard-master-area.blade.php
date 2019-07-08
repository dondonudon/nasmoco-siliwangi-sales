@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Master Area</h1>
            <button class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btnNew">
                <i class="fas fa-plus"></i> Tambah Area Baru
            </button>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Area</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-sm table-hover table-bordered display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Area</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-8"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-outline-primary" id="btnDisable" disabled>Disable</button>
                            </div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-primary" id="btnEdit" disabled>Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none" id="cardData">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary" id="judulCard">Area Baru</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="option" value="new">
                            <div class="form-group">
                                <label for="inputArea">Nama Area</label>
                                <input type="text" class="form-control" id="inputArea" name="area" placeholder="Nama Area" autocomplete="off" required>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-8"></div>
                                <div class="col-xl-2">
                                    <button type="button" class="btn btn-block btn-outline-primary" id="btnCancel">Cancel</button>
                                </div>
                                <div class="col-xl-2">
                                    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        let iArea = $('#inputArea');

        let cardComponent = $('#cardData');
        let cardForm = $('#cardForm');
        let cardTitle = $('#judulCard');
        let optionData = $('#option');

        let buttonNew = $('#btnNew');
        let buttonDisable = $('#btnDisable');
        let buttonEdit = $('#btnEdit');
        let buttonCancel = $('#btnCancel');

        var idArea;

        function resetForm() {
            iArea.val('');
        }

        buttonNew.click(function (e) {
            e.preventDefault();
            optionData.val('new');
            cardTitle.html('Area Baru');
            cardComponent.removeClass('d-none');
            resetForm();
            $('html, body').animate({
                scrollTop: cardComponent.offset().top
            }, 500);
        });

        buttonCancel.click(function (e) {
            e.preventDefault();
            cardComponent.addClass('d-none');
            resetForm();
        });

        $(document).ready(function() {

            let tables = $('#datatable').DataTable({
                "scrollY": "150px",
                "scrollX": true,
                "scrollCollapse": true,
                // "paging": false,
                "pageLength": 25,
                "bInfo": false,
                "ajax": {
                    "method": "GET",
                    "url": "{{ url('/dashboard/master/area/list') }}",
                    "header": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "nama" }
                ],
                "order": [[0,'asc']]
            });
        })
    </script>
@endsection