@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Penjualan</h1>
            <button class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btnNew">
                <i class="fas fa-plus"></i> Penjualan Baru
            </button>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-sm display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th>Nomor SPK</th>
                                <th>Nama Customer</th>
                                <th>Nomor Rangka</th>
                                <th>Leasing</th>
                                <th>Kota</th>
                                <th>Kecamatan</th>
                                <th>Alamat</th>
                                <th>Tanggal SPK</th>
                                <th>Admin</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-10"></div>
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
                        <h6 class="m-0 font-weight-bold text-primary" id="judulCard">New User</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="option" value="new">
                            <div class="form-group">
                                <label for="inputUsername">Nomor SPK</label>
                                <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputNamaLengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="inputNamaLengkap" name="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off" required>
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
        $(document).ready(function() {
            var cardComponent = $('#cardData');
            var cardForm = $('#cardForm');
            var cardTitle = $('#judulCard');
            var optionData = $('#option');

            var buttonNew = $('#btnNew');
            var buttonDisable = $('#btnDisable');
            var buttonEdit = $('#btnEdit');
            var buttonCancel = $('#btnCancel');

            var username = '';
            var namalengkap = '';
            var inputUsername = $('#inputUsername');
            var inputPassword = $('#inputPassword');
            var inputNamaLengkap = $('#inputNamaLengkap');

            buttonCancel.click(function (e) {
                e.preventDefault();
                cardComponent.addClass('d-none');
                inputUsername.val('');
                inputNamaLengkap.val('');
            });

            buttonNew.click(function (e) {
                e.preventDefault();
                optionData.val('new');
                cardTitle.html('New User');
                cardComponent.removeClass('d-none');
                inputUsername.val('');
                inputPassword.val('');
                inputNamaLengkap.val('');
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonEdit.click(function (e) {
                e.preventDefault();
                optionData.val('edit');
                cardTitle.html('Edit User');
                cardComponent.removeClass('d-none');
                inputUsername.val(username);
                inputNamaLengkap.val(namalengkap);

                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonDisable.click(function (e) {
                e.preventDefault();
                Swal.fire({
                    type: 'warning',
                    title: 'Disable user '+username,
                    text: 'Anda yakin ingin menonaktifkan user?',
                    showCancelButton: true
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }
                        });
                        $.ajax({
                            url: "{{ url('dashboard/master/user/disable') }}",
                            method: "post",
                            data: {username: username},
                            success: function(result) {
                                var data = JSON.parse(result);
                                console.log(data);
                                if (data.status == 'success') {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'User dinonaktifkan',
                                        onClose: function() {
                                            tables.ajax.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        type: 'info',
                                        title: 'Gagal',
                                        text: data.reason,
                                    });
                                }
                            }
                        });
                    }
                });
            });

            var tables = $('#datatable').DataTable({
                "scrollY": "150px",
                "scrollX": true,
                "scrollCollapse": true,
                // "paging": false,
                "pageLength": 25,
                "bInfo": false,
                "ajax": {
                    "method": "GET",
                    "url": "{{ url('/dashboard/penjualan/baru/list') }}",
                    "header": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    }
                },
                "columns": [
                    { "data": "no_spk" },
                    { "data": "nama_customer" },
                    { "data": "no_rangka" },
                    { "data": "id_leasing" },
                    { "data": "id_kota" },
                    { "data": "id_kecamatan" },
                    { "data": "alamat" },
                    { "data": "created_at" },
                    { "data": "username" },
                    { "data": "finish" },
                ],
                "order": [[0,'asc']]
            });

            $('#datatable tbody').on( 'click', 'tr', function () {
                var data = tables.row( this ).data();
                username = data.username;
                namalengkap = data.nama_lengkap;
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                if ($('#option').val() == 'new') {
                    $.ajax({
                        url: "{{ url('dashboard/master/user/new') }}",
                        method: "post",
                        data: $(this).serialize(),
                        success: function(result) {
                            var data = JSON.parse(result);
                            if (data.status == 'success') {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Berhasil',
                                    text: 'Data user tersimpan',
                                    onClose: function() {
                                        cardComponent.addClass('d-none');
                                        tables.ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    type: 'info',
                                    title: 'Gagal',
                                    text: data.reason,
                                });
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ url('dashboard/master/user/edit') }}",
                        method: "post",
                        data: $(this).serialize(),
                        success: function(result) {
                            var data = JSON.parse(result);
                            console.log(data);
                            var data = JSON.parse(result);
                            if (data.status == 'success') {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Berhasil',
                                    text: 'Data user tersimpan',
                                    onClose: function() {
                                        cardComponent.addClass('d-none');
                                        tables.ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    type: 'info',
                                    title: 'Gagal',
                                    text: data.reason,
                                });
                            }
                        }
                    });
                }
            });
        })
    </script>
@endsection