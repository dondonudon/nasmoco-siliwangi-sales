@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Master Leasing</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Leasing</h6>
                        <button class="btn btn-sm d-none d-sm-inline-block btn btn-success shadow-sm" id="btnNew" style="font-size: 12px;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-sm table-hover table-bordered display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th>Nama Leasing</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-8"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-outline-primary" id="btnDisable">Disable</button>
                            </div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-danger" id="btnEdit">Edit</button>
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
                        <h6 class="m-0 font-weight-bold text-primary" id="judulCard">Leasing Baru</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <input type="hidden" id="option" value="new">
                        <input type="hidden" id="idLeasing" name="id">
                        <div class="card-body">
                            <input type="hidden" id="option" value="new">
                            <div class="form-group">
                                <label for="inputArea">Nama Leasing</label>
                                <input type="text" class="form-control" id="inputLeasing" name="nama" placeholder="Nama Leasing" autocomplete="off" required>
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
                                    <button type="submit" class="btn btn-block btn-danger">Simpan</button>
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
        const iLeasing = $('#inputLeasing');
        const iIDLeasing = $('#idLeasing');

        const cardComponent = $('#cardData');
        const cardForm = $('#cardForm');
        const cardTitle = $('#judulCard');
        const optionData = $('#option');

        const buttonNew = $('#btnNew');
        const buttonDisable = $('#btnDisable');
        const buttonEdit = $('#btnEdit');
        const buttonCancel = $('#btnCancel');

        var idLeasing;
        var namaLeasing;

        function resetForm() {
            iLeasing.val('');
        }

        $(document).ready(function() {
            const tables = $('#datatable').DataTable({
                "scrollY": "150px",
                "scrollX": true,
                "scrollCollapse": true,
                // "paging": false,
                "pageLength": 25,
                "bInfo": false,
                "ajax": {
                    "method": "GET",
                    "url": "{{ url('/dashboard/master/leasing/list') }}",
                    "header": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    }
                },
                "columns": [
                    { "data": "nama" },
                    {
                        "render": function (data, type, full, meta) {
                            let status;
                            if (full.isDel == '0') {
                                status = 'aktif';
                            } else {
                                status = 'disabled';
                            }
                            return status;
                        },
                    }
                ],
                "order": [[0,'asc']]
            });
            $('#datatable tbody').on( 'click', 'tr', function () {
                let data = tables.row( this ).data();
                idLeasing = data.id;
                namaLeasing = data.nama;
                // console.log(data);
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    buttonEdit.attr('disabled','true');
                    buttonDisable.attr('disabled','true');
                } else {
                    tables.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    buttonEdit.removeAttr('disabled');
                    buttonDisable.removeAttr('disabled');
                }
            });

            cardForm.submit(function (e) {
                e.preventDefault();
                let url;

                if (optionData.val() == 'new') { url = "{{ url('dashboard/master/leasing/add') }}"; }
                else { url = "{{ url('dashboard/master/leasing/edit') }}"; }

                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), } });
                $.ajax({
                    url: url,
                    method: "post",
                    data: $(this).serialize(),
                    success: function(result) {
                        var data = JSON.parse(result);
                        if (data.status == 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Data Tersimpan',
                                onClose: function() {
                                    $("html, body").animate({ scrollTop: 0 }, 500, function () {
                                        cardComponent.addClass('d-none');
                                        tables.ajax.reload();
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                type: 'warning',
                                title: 'Gagal',
                                text: data.reason,
                            });
                        }
                    }
                });
            });

            buttonNew.click(function (e) {
                e.preventDefault();
                optionData.val('new');
                cardTitle.html('New Leasing');
                cardComponent.removeClass('d-none');
                resetForm();
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonEdit.click(function (e) {
                e.preventDefault();
                optionData.val('edit');
                cardTitle.html('Edit Leasing');
                cardComponent.removeClass('d-none');
                iLeasing.val(namaLeasing);
                iIDLeasing.val(idLeasing);
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonCancel.click(function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    cardComponent.addClass('d-none');
                    resetForm();
                });
            });

            buttonDisable.click(function (e) {
                e.preventDefault();
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), } });
                $.ajax({
                    url: "{{ url('dashboard/master/leasing/delete') }}",
                    method: "post",
                    data: {id: idLeasing},
                    success: function(result) {
                        var data = JSON.parse(result);
                        if (data.status == 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Data Tersimpan',
                                onClose: function() {
                                    cardComponent.addClass('d-none');
                                    tables.ajax.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                type: 'warning',
                                title: 'Gagal',
                                text: data.reason,
                            });
                        }
                    }
                });
            });

        })
    </script>
@endsection