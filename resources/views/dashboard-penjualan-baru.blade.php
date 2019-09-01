@extends('dashboard-layout')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/filepond-master/filepond.min.css') }}">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Penjualan</h1>
            <button class="btn d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" id="btnUpload">
                <i class="fas fa-upload"></i> Upload Data
            </button>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
                        <button class="btn d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" id="btnNew">
                            <i class="fas fa-plus"></i> Penjualan Baru
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-hover table-bordered table-sm display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th>Nomor SPK</th>
                                <th>Nama Customer</th>
<<<<<<< HEAD
                                <th>Nama STNK</th>
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                                <th>Nomor Rangka</th>
                                <th>Leasing</th>
                                <th>Kota / Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Alamat</th>
<<<<<<< HEAD
                                <th>Tanggal Input</th>
=======
                                <th>Tanggal SPK</th>
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                                <th>Admin</th>
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
                                <button class="btn btn-block btn-outline-primary" id="btnDelete" disabled>Delete</button>
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
                        <h6 class="m-0 font-weight-bold text-primary" id="judulCard">New User</h6>
                    </div>
                    <form id="cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="option" value="new">
<<<<<<< HEAD
{{--                            <div class="form-group">--}}
{{--                                <label for="inputKota">Tipe Aju</label>--}}
{{--                                <select class="form-control" id="inputAju" name="aju" >--}}
{{--                                    <option value="1">AJU FAKTUR</option>--}}
{{--                                    <option value="2">AJU DR</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="inputTanggalSPK">Tanggal Area Aju</label>--}}
{{--                                <input type="text" class="form-control" id="inputTanggalSPK" name="tanggal_spk" placeholder="Tanggal SPK" autocomplete="off" >--}}
{{--                            </div>--}}
=======
                            <div class="form-group">
                                <label for="inputKota">Tipe Aju</label>
                                <select class="form-control" id="inputAju" name="aju" required>
                                    <option value="1">AJU FAKTUR</option>
                                    <option value="2">AJU DR</option>
                                </select>
                            </div>
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                            <div class="form-group">
                                <label for="inputNomorSPK">Nomor SPK</label>
                                <input type="text" class="form-control" id="inputNomorSPK" name="no_spk" placeholder="Nomor SPK" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputCustomer">Nama Customer</label>
                                <input type="text" class="form-control" id="inputCustomer" name="nama_customer" placeholder="Nama Customer" autocomplete="off" required>
                            </div>
                            <div class="form-group">
<<<<<<< HEAD
                                <label for="inputNamaSTNK">Nama STNK</label>
                                <input type="text" class="form-control" id="inputNamaSTNK" name="nama_stnk" placeholder="Nama STNK" autocomplete="off" required>
                            </div>
                            <div class="form-group">
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD
=======
                                <label for="inputTanggalSPK">Tanggal SPK</label>
                                <input type="text" class="form-control" id="inputTanggalSPK" name="tanggal_spk" placeholder="Tanggal SPK" autocomplete="off" required>
                            </div>
                            <div class="form-group">
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                                <label for="inputUsername">Admin</label>
                                <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Admin" value="{{ \Illuminate\Support\Facades\Session::get('username') }}" readonly>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-8"></div>
                                <div class="col-xl-2">
                                    <button type="button" class="btn btn-block btn-outline-dark" id="btnCancel">Cancel</button>
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

        <div class="row d-none" id="cardUpload">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary" id="cardUpload_title">Upload File</h6>
                        <button type="button" class="btn d-none d-sm-inline-block btn btn-sm btn-outline-danger shadow-sm" style="font-size: 12px;" id="cardUpload_btnClose">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form id="cardUpload_cardForm">
                    @csrf
                    <!-- Card Body -->
                        <div class="card-body">
                            <input type="hidden" id="cardUpload_cardOption" value="new">
                            <input id="cardUpload_uploadFile" type="file" hidden>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg">
                                    <button type="button" class="btn btn-sm btn-outline-info" id="downloadExcel">
                                        Download Excel Sample
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <iframe id="downloadFrame" style="display: none;"></iframe>
<<<<<<< HEAD

    <div class="modal fade" id="ModalInfoUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Sebagian data berhasil tersimpan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Berikut data yang tidak tersimpan karena sudah ada pada database</p>
                    <div class="row" id="ModalInfoData">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe id="downloadArea" hidden></iframe>

=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
@endsection

@section('script')
    <script src="{{ asset('vendor/filepond-master/filepond.min.js') }}"></script>
    <script>
<<<<<<< HEAD
        const download = document.getElementById('downloadArea');

=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        /*
        Card Data
        new SPK and edit SPK
         */
        const cardComponent = $('#cardData');
        const cardForm = $('#cardForm');
        const cardTitle = $('#judulCard');
        const optionData = $('#option');
        const buttonCancel = $('#btnCancel');
<<<<<<< HEAD

        const iNomorSpk = $('#inputNomorSPK');
        const iCustomer = $('#inputCustomer');
        const iNamaSTNK = $('#inputNamaSTNK');
=======
        const iNomorSpk = $('#inputNomorSPK');
        const iCustomer = $('#inputCustomer');
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        const iNomorRangka = $('#inputNomorRangka');
        const iLeasing = $('#inputLeasing');
        const iKota = $('#inputKota');
        const iKecamatan = $('#inputKecamatan');
        const iAlamat = $('#inputAlamat');
<<<<<<< HEAD
        const iUsername = $('#inputUsername');

        let vNomorSpk = '';
        let vCustomer = '';
        let vNamaSTNK = '';
        let vNomorRangka = '';
        let vLeasing = '';
        let vKota = '';
        let vKecamatan = '';
        let vAlamat = '';
        let vUsername = '';

=======
        const iTanggalSpk = $('#inputTanggalSPK');
        const iUsername = $('#inputUsername');

>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        /*
        Card SPK List
        */
        const buttonNew = $('#btnNew');
        const buttonEdit = $('#btnEdit');
        const buttonDelete = $('#btnDelete');

        /*
        Card Upload
         */
        const btnUpload = $('#btnUpload');
        const cardUpload = $('#cardUpload');
        const cuBtnClose = $('#cardUpload_btnClose');
        const cuBtnSet = $('#cardUpload_btnSet');
        const cuSelectTipe = $('#cardUpload_selectTipe');
        const cuTitle = $('#cardUpload_title');
        const cuForm = $('#cardUpload_cardForm');
        const cuUpload = document.getElementById('cardUpload_uploadFile');

        /*
        Download Excel
         */
        const btnSample = $('#downloadExcel');

        let noSPK = '';
        let htmlLeasing = '';
        let htmlKota = '';
        let htmlKecamatan = '';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        function formReset() {
            iNomorSpk.val('');
            iCustomer.val('');
            iNomorRangka.val('');
            iLeasing.val('');
            iKecamatan.html('');
            iKecamatan.attr('disabled');
            iAlamat.val('');
<<<<<<< HEAD
=======
            iTanggalSpk.val(
                moment().format('DD-MM-YYYY')
            );
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        }

        $(document).ready(function() {
            $.ajax({
                url: "{{ url('dashboard/penjualan/baru/leasing') }}",
                method: "get",
                success: function(result) {
<<<<<<< HEAD
                    let data = JSON.parse(result);
=======
                    var data = JSON.parse(result);
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                    // console.log(data);
                    data.forEach(function(val,index) {
                        htmlLeasing += '<option value="' + val.nama + '">' + val.nama + '</option>';
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

<<<<<<< HEAD
=======
            iTanggalSpk.daterangepicker({
                maxDate: moment().format('DD-MM-YYYY'),
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY',
                }
            }, function (start,end,label) {
                startDate = moment(start).format('YYYY-MM-DD');
                // console.log(startDate);
            });

>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            iKota.change(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('dashboard/penjualan/baru/kecamatan') }}",
                    method: "post",
                    data: {kota: iKota.val()},
                    success: function(result) {
<<<<<<< HEAD
                        let data = JSON.parse(result);
=======
                        var data = JSON.parse(result);
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                        htmlKecamatan = '';
                        data.forEach(function(val,index) {
                            htmlKecamatan += '<option value="' + val.nama + '">' + val.nama + '</option>';
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
<<<<<<< HEAD
                iNomorSpk.val(vNomorSpk);
                iCustomer.val(vCustomer);
                iNamaSTNK.val(vNamaSTNK);
                iNomorRangka.val(vNomorRangka);
                iLeasing.val(vLeasing);
                iKota.val(vKota);
                iKecamatan.val(vKecamatan);
                iAlamat.val(vAlamat);
                iUsername.val(vUsername);
=======
                inputUsername.val(username);
                inputNamaLengkap.val(namalengkap);
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });

            buttonDelete.click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin ingin menghapus SPK?',
                    text: 'Data area pada SPK tersebut akan ikut terhapus dan tidak dapat dikembalikan!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus SPK'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('dashboard/penjualan/hapus') }}',
                            method: 'post',
                            data: {no_spk: noSPK},
                            success: function(result) {
                                let data = JSON.parse(result);
                                if (data.status === 'success') {
                                    tables.ajax.reload();
                                    Swal.fire(
                                        'Terhapus',
                                        'SPK berhasil dihapus',
                                        'success'
                                    )
                                }
                            }
                        });
                    }
                })
            });

            // btnUpload.click(function (e) {
            //     e.preventDefault();
            //     cardUpload.removeClass('d-none');
            //     $('html, body').animate({
            //         scrollTop: cardUpload.offset().top
            //     }, 500);
            // });

            cuBtnClose.click(function(e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    cuSelectTipe.attr('disabled',false);
                    FilePond.destroy(cuUpload);
                    cuUpload.setAttribute('hidden','');
                    cuBtnSet.attr('disabled',false);
                    cardUpload.addClass('d-none');
                    tables.ajax.reload();
                });
            });

            btnSample.click(function (e) {
                e.preventDefault();
<<<<<<< HEAD
                {{--window.open('{{ url('/dashboard/penjualan/baru/upload/sample') }}');--}}
                download.src = '{{ url('dashboard/penjualan/baru/upload/sample') }}';
=======
                window.open('{{ url('/dashboard/penjualan/baru/upload/sample') }}');
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            });

            btnUpload.click(function (e) {
                e.preventDefault();
                cardUpload.removeClass('d-none');
                cuSelectTipe.attr('disabled',true);
                cuUpload.removeAttribute('hidden');
                $('html, body').animate({
                    scrollTop: cardUpload.offset().top
                }, 1000);
                FilePond.create( cuUpload );
                FilePond.setOptions({
                    allowMultiple: false,
                    allowDrop: true,
                    server: {
                        process: (fieldName, file, metadata, load, error, progress, abort) => {
                            const formData = new FormData();
                            formData.append(fieldName, file, file.name);

                            const request = new XMLHttpRequest();
                            request.open('POST','{{ url('dashboard/penjualan/baru/upload') }}/'+cuSelectTipe.val());
                            request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

                            request.upload.onprogress = (e) => {
                                progress(e.lengthComputable, e.loaded, e.total);
                            };

                            request.onload = function () {
                                if (request.status >= 200 && request.status < 300) {
                                    load(request.responseText);
                                    console.log(request.responseText);
<<<<<<< HEAD
                                    let data = JSON.parse(request.responseText);
                                    if (data.duplicate == '') {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Data berhasil tersimpan',
                                        });
                                    } else {
                                        let htmlData = '';
                                        data['duplicate'].forEach(function (v,i) {
                                            htmlData += '<div class="col-md-6 text-center">';
                                            htmlData += '<div class="card shadow mb-4">';
                                            htmlData += '<div class="card-body">'+v+'</div>';
                                            htmlData += '</div>';
                                            htmlData += '</div>';
                                        });
                                        $('#ModalInfoData').html(htmlData);
                                        $('#ModalInfoUpload').modal('show');
                                    }
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                                } else {
                                    error('gagal');
                                }
                            };

                            request.send(formData);

                            return {
                                abort: () => {
                                    request.abort();

                                    abort();
                                }
                            }
                        }
                    }
                });
            });

            const tables = $('#datatable').DataTable({
<<<<<<< HEAD
                "scrollY": "400px",
=======
                "scrollY": "150px",
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD
                    { "data": "nama_stnk" },
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                    { "data": "no_rangka" },
                    { "data": "leasing" },
                    { "data": "kota" },
                    { "data": "kecamatan" },
                    { "data": "alamat" },
                    {
                        "render": function (data, type, full, meta) {
<<<<<<< HEAD
                            return moment(full.created_at).format('DD-MM-YYYY');
=======
                            return moment(full.tanggal_spk).format('DD-MM-YYYY');
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
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
<<<<<<< HEAD
=======

>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            $('#datatable tbody').on( 'click', 'tr', function () {
                let data = tables.row( this ).data();
                noSPK = data.no_spk;
                // console.log(data);
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    buttonEdit.attr('disabled','true');
                    buttonDelete.attr('disabled','true');
                } else {
                    tables.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    buttonEdit.removeAttr('disabled');
                    buttonDelete.removeAttr('disabled');
<<<<<<< HEAD
                    vNomorSpk = data.no_spk;
                    vCustomer = data.nama_customer;
                    vNamaSTNK = data.nama_stnk;
                    vNomorRangka = data.no_rangka;
                    vLeasing = data.leasing;
                    vKota = data.kota;
                    vKecamatan = data.kecamatan;
                    vAlamat = data.alamat;
                    vUsername = data.username;
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                }
            });

            cardForm.submit(function (e) {
                e.preventDefault();
                let url;
                if (optionData.val() === 'new') {
                    url = "{{ url('dashboard/penjualan/baru/add') }}";
                } else {
                    url = "{{ url('dashboard/penjualan/baru/edit') }}";
                }
                $.ajax({
                    url: url,
                    method: "post",
                    data: $(this).serialize(),
                    success: function(result) {
<<<<<<< HEAD
                        console.log(result);
=======
                        // console.log(result);
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                        let data = JSON.parse(result);
                        if (data.status === 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Data tersimpan',
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
            });
        })
    </script>
@endsection
