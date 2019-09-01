@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Master Area</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Area</h6>
{{--                        <button class="btn d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="btnNew" style="font-size: 12px;">--}}
{{--                            <i class="fas fa-plus"></i>--}}
{{--                        </button>--}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-sm table-hover table-bordered display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                                <tr>
<<<<<<< HEAD
                                    <th>ID Area</th>
                                    <th>Nama Area</th>
                                    <th>Perbandingan (ID Area)</th>
                                    <th>Target (Hari)</th>
=======
                                    <th>Nama Area</th>
                                    <th>Target (Hari)</th>
                                    <th>Color</th>
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                                    <th>Order</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-8"></div>
                            <div class="col-xl-2">
{{--                                <button class="btn btn-block btn-outline-primary" id="btnDisable" disabled>Disable</button>--}}
                            </div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-danger" id="btnEdit" disabled>Edit</button>
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
                            <div class="form-group">
<<<<<<< HEAD
                                <label for="inputTarget">ID Pembanding</label>
                                <input type="number" class="form-control" id="inputPembanding" name="perbandingan" placeholder="Tanggal Target" autocomplete="off" required>
                            </div>
                            <div class="form-group">
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                                <label for="inputTarget">Tanggal Target Default</label>
                                <input type="number" class="form-control" id="inputTarget" name="target" placeholder="Tanggal Target" autocomplete="off" required>
                            </div>
                            <div class="form-group">
<<<<<<< HEAD
=======
                                <label for="inputColor">Color</label>
                                <input type="text" class="form-control" id="inputColor" name="color" placeholder="Hex Color" autocomplete="off" required>
                            </div>
                            <div class="form-group">
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                                <label for="inputOrder">Order</label>
                                <input type="number" class="form-control" id="inputOrder" name="ord" placeholder="Input Order" autocomplete="off" required>
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
        let iArea = $('#inputArea');
<<<<<<< HEAD
        let iPembanding = $('#inputPembanding');
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
        let iTarget = $('#inputTarget');
        let iColor = $('#inputColor');
        let iOrder = $('#inputOrder');

        let cardComponent = $('#cardData');
        let cardForm = $('#cardForm');
        let cardTitle = $('#judulCard');
        let optionData = $('#option');

        let buttonNew = $('#btnNew');
        let buttonDisable = $('#btnDisable');
        let buttonEdit = $('#btnEdit');
        let buttonCancel = $('#btnCancel');

<<<<<<< HEAD
        let idArea, namaArea, pembanding, target, color, order;
=======
        var idArea;
        var namaArea;
        var target;
        var color;
        var order;
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac

        function resetForm() {
            iArea.val('');
            iTarget.val('');
            iColor.val('');
            iOrder.val('');
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

        buttonEdit.click(function (e) {
            e.preventDefault();
            optionData.val('edit');
            cardTitle.html('Edit Area');
            cardComponent.removeClass('d-none');
            iArea.val(namaArea);
<<<<<<< HEAD
            iPembanding.val(pembanding);
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            iTarget.val(target);
            iColor.val(color);
            iOrder.val(order);

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

        $(document).ready(function() {
            let tables = $('#datatable').DataTable({
                "scrollY": "250px",
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
<<<<<<< HEAD
                    { "data": "id" },
                    { "data": "nama" },
                    { "data": "perbandingan" },
                    { "data": "tgl_target_default" },
                    { "data": "ord" },
                ],
                "order": [[0,'asc']]
=======
                    { "data": "nama" },
                    { "data": "tgl_target_default" },
                    {
                        "render": function (data, type, full, meta) {
                            // return '<hr style="border: 10px; border-color: '+full.color+'; border-radius: 5px;">';
                            return '<span style="font-weight: bold; color: '+full.color+'">'+full.color+'</span>';
                        },
                    },
                    { "data": "ord" },
                ],
                "order": [[3,'asc']]
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
            });
            $('#datatable tbody').on( 'click', 'tr', function () {
                var data = tables.row( this ).data();
                idArea = data.id;
                namaArea = data.nama;
<<<<<<< HEAD
                pembanding = data.perbandingan;
=======
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                target = data.tgl_target_default;
                color = data.color;
                order = data.ord;
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
                if (optionData.val() == 'new') {
                    $.ajax({
                        url: "{{ url('dashboard/master/area/add') }}",
                        method: "post",
                        data: $(this).serialize(),
                        success: function(result) {
                            // console.log(result);
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
                                    type: 'info',
                                    title: 'Gagal',
                                    text: data.reason,
                                });
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ url('dashboard/master/area/edit') }}",
                        method: "post",
<<<<<<< HEAD
                        data: {id: idArea, area: iArea.val(),perbandingan: iPembanding.val(), target: iTarget.val(), color: iColor.val(), ord: iOrder.val()},
                        success: function(result) {
                            console.log(result);
=======
                        data: {id: idArea, area: iArea.val(), target: iTarget.val(), color: iColor.val(), ord: iOrder.val()},
                        success: function(result) {
                            var data = JSON.parse(result);
                            console.log(data);
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                            var data = JSON.parse(result);
                            if (data.status == 'success') {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Update Berhasil',
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
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
