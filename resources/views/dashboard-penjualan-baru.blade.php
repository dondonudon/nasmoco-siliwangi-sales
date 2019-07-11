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
                                <th>Kota / Kabupaten</th>
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
                                <label for="inputNomorSPK">Nomor SPK</label>
                                <input type="text" class="form-control" id="inputNomorSPK" name="no_spk" placeholder="Nomor SPK" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputCustomer">Nama Customer</label>
                                <input type="text" class="form-control" id="inputCustomer" name="nama_customer" placeholder="Nama Customer" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputNomorRangka">Nomor Rangka</label>
                                <input type="text" class="form-control" id="inputNomorRangka" name="no_rangka" placeholder="Nomor Rangka" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputLeasing">Leasing</label>
                                <select class="form-control" id="inputLeasing" name="id_leasing" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputKota">Kota</label>
                                <select class="form-control" id="inputKota" name="id_kota" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputKecamatan">Kecamatan</label>
                                <select class="form-control" id="inputKecamatan" name="id_kecamatan" disabled required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputAlamat">Alamat</label>
                                <input type="text" class="form-control" id="inputAlamat" name="alamat" placeholder="Alamat" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputTanggalSPK">Tanggal SPK</label>
                                <input type="text" class="form-control" id="inputTanggalSPK" name="tanggal_spk" placeholder="Tanggal SPK" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputUsername">Admin</label>
                                <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Admin" value="{{ \Illuminate\Support\Facades\Session::get('username') }}" readonly>
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
        var noSPK = '';
        var iNomorSpk = $('#inputNomorSPK');
        var iCustomer = $('#inputCustomer');
        var iNomorRangka = $('#inputNomorRangka');
        var iLeasing = $('#inputLeasing');
        var iKota = $('#inputKota');
        var iKecamatan = $('#inputKecamatan');
        var iAlamat = $('#inputAlamat');
        var iTanggalSpk = $('#inputTanggalSPK');
        var iUsername = $('#inputUsername');

        var htmlLeasing = '';
        var htmlKota = '';
        var htmlKecamatan = '';

        iTanggalSpk.daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY',
            }
        }, function (start,end,label) {
            startDate = moment(start).format('YYYY-MM-DD');
            // console.log(startDate);
        });

        function formReset() {
            iNomorSpk.val('');
            iCustomer.val('');
            iNomorRangka.val('');
            iLeasing.val('');
            iKecamatan.html('');
            iKecamatan.attr('disabled');
            iAlamat.val('');
            iTanggalSpk.val(
                moment().format('DD-MM-YYYY')
            );
        }

        $(document).ready(function() {
            var cardComponent = $('#cardData');
            var cardForm = $('#cardForm');
            var cardTitle = $('#judulCard');
            var optionData = $('#option');

            var buttonNew = $('#btnNew');
            var buttonEdit = $('#btnEdit');
            var buttonCancel = $('#btnCancel');

            $.ajax({
                url: "{{ url('dashboard/penjualan/baru/leasing') }}",
                method: "get",
                success: function(result) {
                    var data = JSON.parse(result);
                    // console.log(data);
                    data.forEach(function(val,index) {
                        htmlLeasing += '<option value="' + val.id + '">' + val.nama + '</option>';
                    });
                    iLeasing.html(htmlLeasing);
                }
            });

            $.ajax({
                url: "{{ url('dashboard/penjualan/baru/kota') }}",
                method: "get",
                success: function(result) {
                    var data = JSON.parse(result);
                    // console.log(data);
                    data.forEach(function(val,index) {
                        htmlKota += '<option value="' + val.id + '">' + val.nama + '</option>';
                    });
                    iKota.html(htmlKota);
                }
            });
            iKota.change(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('dashboard/penjualan/baru/kecamatan') }}",
                    method: "post",
                    data: {kota: iKota.val()},
                    success: function(result) {
                        var data = JSON.parse(result);
                        htmlKecamatan = '';
                        data.forEach(function(val,index) {
                            htmlKecamatan += '<option value="' + val.id + '">' + val.nama + '</option>';
                        });
                        iKecamatan.html(htmlKecamatan);
                    }
                });
                iKecamatan.removeAttr('disabled');
            });

            buttonCancel.click(function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    cardComponent.addClass('d-none');
                    formReset();
                });
            });

            buttonNew.click(function (e) {
                e.preventDefault();
                optionData.val('new');
                cardTitle.html('Data Penjualan Baru');
                cardComponent.removeClass('d-none');
                formReset();
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonEdit.click(function (e) {
                e.preventDefault();
                optionData.val('edit');
                cardTitle.html('Edit Data Penjualan');
                cardComponent.removeClass('d-none');
                inputUsername.val(username);
                inputNamaLengkap.val(namalengkap);

                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
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
                    {
                        "render": function (data, type, full, meta) {
                            return moment(full.tanggal_spk).format('DD-MM-YYYY');
                        },
                    },
                    { "data": "username" },
                    {
                        "render": function (data, type, full, meta) {
                            if (full.finish == '0') {
                                var status = 'Dalam Proses';
                            } else {
                                var status = 'Selesai';
                            }
                            return status;
                        },
                    },
                ],
                "order": [[0,'asc']]
            });

            $('#datatable tbody').on( 'click', 'tr', function () {
                var data = tables.row( this ).data();
                noSPK = data.no_spk;
                // console.log(data);
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    buttonEdit.attr('disabled','true');
                } else {
                    tables.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    buttonEdit.removeAttr('disabled');
                }
            });

            cardForm.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                if (optionData.val() == 'new') {
                    $.ajax({
                        url: "{{ url('dashboard/penjualan/baru/add') }}",
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
                                        $("html, body").animate({ scrollTop: 0 }, 500, function () {
                                            cardComponent.addClass('d-none');
                                            tables.ajax.reload();
                                        });
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
                                    text: 'Data penjualan tersimpan',
                                    onClose: function() {
                                        $("html, body").animate({ scrollTop: 0 }, 500, function () {
                                            cardComponent.addClass('d-none');
                                            tables.ajax.reload();
                                        });
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