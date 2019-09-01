@extends('dashboard-layout')

@section('style')
    <style>
        #datatable {
            width: 1700px;
        }
    </style>
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Penjualan Summary</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl-6 col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Filter Penjualan</h6>
                    </div>
                    <!-- Card Body -->
                    <form id="form_filter">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputTanggal">Tanggal</label>
                                <input type="text" class="form-control" id="inputTanggal" name="tanggal" placeholder="Range Tanggal" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="inputTanggal">Status Penjualan</label>
                                <select class="form-control" id="inputPenjualan" name="penjualan" required>
                                    <option value="0">Belum Selesai</option>
                                    <option value="1">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-8"></div>
                                <div class="col-xl-4">
                                    <button class="btn btn-sm btn-block btn-danger" id="btnView">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-6 col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Info Perbedaan Tanggal</h6>
                    </div>
                    <!-- Card Body -->
                    <form id="form_difference">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="noSpk">Nomor SPK</label>
                                <select id="noSpk"></select>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Area Awal</label>
{{--                                        <input type="text" class="form-control" id="area_awal" name="area_awal" placeholder="Area Awal">--}}
                                        <select id="area_awal"></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Area Akhir</label>
                                        <select id="area_akhir"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-4"></div>
                                <div class="col-xl-4">
                                    <button type="button" class="btn btn-sm btn-block btn-danger" id="btnViewAverage" disabled>
                                        <i class="fas fa-eye"></i> View Average
                                    </button>
                                </div>
                                <div class="col-xl-4">
                                    <button type="submit" class="btn btn-sm btn-block btn-danger" id="btnViewDateDiff" disabled>
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row d-none" id="cardData">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Status Area Penjualan</h6>
                        <button class="btn btn-sm btn-outline-primary" id="newTab">
                            <i class="fas fa-external-link-alt"></i> Buka di tab baru
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-sm btn-block btn-outline-info" data-toggle="modal" data-target="#modalInfoWarna">
                                    info warna
                                </button>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-sm btn-block btn-outline-danger" id="exportExcel">
                                    Export to Excel
                                </button>
                            </div>
                        </div>

                        <hr>

                        <table class="table table-hover table-bordered table-sm display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-dark">
                                <tr>
                                    <th>Nomor SPK</th>
                                    <th>AJU FAKTUR</th>
                                    <th>AJU DR</th>
                                    <th>PDS IN</th>
                                    <th>GESEK</th>
                                    <th>RETAIL</th>
                                    <th>F. DATANG</th>
                                    <th>PDS OUT</th>
                                    <th>STNK JADI</th>
                                    <th>PENAGIHAN</th>
                                    <th>PELUNASAN</th>
                                    <th>BPKB JADI</th>
                                    <th>BPKB DITERIMA</th>
                                    <th>BPKB DISERAHKAN</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="viewNoSpk" placeholder="Nomor SPK" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="button" id="btnViewDetail" disabled>View Detail SPK</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-outline-danger" id="btnClose">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none" id="cardDetailSPK">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Detail SPK</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead class="text-white bg-primary">
                            <tr>
                                <th>info</th>
                                <th>AJU FAKTUR</th>
                                <th>AJU DR</th>
                                <th>PDS IN</th>
                                <th>GESEK</th>
                                <th>RETAIL</th>
                                <th>F. DATANG</th>
                                <th>PDS OUT</th>
                                <th>STNK</th>
                                <th>PENAGIHAN</th>
                                <th>PELUNASAN</th>
                                <th>BPKB JADI</th>
                                <th>BPKB DITERIMA</th>
                                <th>BPKB DISERAHKAN</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="selisihPerArea"></tr>
                            <tr id="selisihPerFaktur"></tr>
                            <tr id="retailVsPenagihan"></tr>
                            <tr id="retailVsPelunasan"></tr>
                            <tr id="custom"></tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-10"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-outline-danger" id="btnCloseDetailSPK">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailTitle">Detail SPK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row text-dark" id="detailArea"></dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal INFO Warna -->
    <div class="modal fade bd-example-modal-lg" id="modalInfoWarna" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Info Warna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert text-white bg-success" role="alert">
                        Area yang sudah tervalidasi melalui <strong>Nasmoco Siliwangi APPS</strong>
                    </div>
                    <div class="alert text-white bg-danger" role="alert">
                        Area sudah melewati batas tanggal target
                    </div>
                    <div class="alert text-white bg-warning" role="alert">
                        Tanggal target pada area tersebut telah dirubah
                    </div>
                </div>
            </div>
        </div>
    </div>

    <iframe id="downloadFrame" style="display: none;"></iframe>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        const iframe = $('#downloadFrame');

        const iStatus = $('#inputPenjualan');
        const iAreaAwal = $('#area_awal');
        const iAreaAkhir = $('#area_akhir');
        const formFilter = $('#form_filter');
        const formDifference = $('#form_difference');

        const btnCancel = $('#btnClose');
        const btnCloseDetail = $('#btnCloseDetail');
        const btnCloseDetailSPK = $('#btnCloseDetailSPK');
        const btnNewTab = $('#newTab');
        const btnViewDetail = $('#btnViewDetail');
        const btnViewDateDiff = $('#btnViewDateDiff');
        const btnViewAverage = $('#btnViewAverage');
        const btnExportExcel = $('#exportExcel');

        const vNoSpk = $('#viewNoSpk');

        const cardComponent = $('#cardData');
        const cardDetailSPK = $('#cardDetailSPK');

        let noSPK;

        const selectSpk = new SlimSelect({
            select: '#noSpk',
            placeholder: 'Pilih SPK'
        });

        const dataAreaSelect = [
            {text: 'AJU FAKTUR', value: '1'},
            {text: 'AJU DR', value: '2'},
            {text: 'PDS IN', value: '3'},
            {text: 'GESEK', value: '4'},
            {text: 'RETAIL', value: '5'},
            {text: 'FAKTUR DATANG', value: '6'},
            {text: 'PDS OUT', value: '7'},
            {text: 'STNK JADI', value: '8'},
            {text: 'PENAGIHAN', value: '9'},
            {text: 'PELUNASAN', value: '10'},
            {text: 'BPKB', value: '11'},
        ];

        const selectAreaAwal = new SlimSelect({
            select: '#area_awal',
        });
        selectAreaAwal.setData(dataAreaSelect);

        const selectAreaAkhir = new SlimSelect({
            select: '#area_akhir',
        });
        selectAreaAkhir.setData(dataAreaSelect);

        const iTanggal = $('#inputTanggal').daterangepicker({
            maxDate: moment(),
            startDate: moment().startOf('month'),
            endDate: moment(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        btnCancel.click(function (e) {
            e.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 500, function () {
                btnViewDetail.attr('disabled',true);
                vNoSpk.val('');
                cardComponent.addClass('d-none');
            });
        });

        btnCloseDetail.click(function (e) {
            e.preventDefault();
        });

        btnCloseDetailSPK.click(function (e) {
            e.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 500, function () {
                cardDetailSPK.addClass('d-none');
            });
        });

        btnNewTab.click(function(e) {
            e.preventDefault();
            let startDate = moment($('#inputTanggal').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
            let endDate = moment($('#inputTanggal').data('daterangepicker').endDate._d).format('YYYY-MM-DD');
            let url = "/dashboard/penjualan/summary/"+startDate+"/"+endDate+"/"+iStatus.val();
            window.open('{{ url('') }}'+url);
        });

        btnViewDetail.click(function(e) {
            e.preventDefault();
            let htmlData = '';
            $.ajax({
                url: "{{ url('dashboard/penjualan/summary/spk/detail') }}",
                method: "post",
                data: {no_spk: noSPK},
                success: function(result) {
                    console.log(result);
                    let data = JSON.parse(result);
                    htmlData += '<dt class="col-sm-3">Nomor SPK</dt>';
                    htmlData += '<dd class="col-sm-9">'+data.detail[0].no_spk+'</dd>';

                    data.detail.forEach(function(v,i) {
                        htmlData += '<dt class="col-sm-3">'+v.nama_area+'</dt>';
                        htmlData += '<dd class="col-sm-9">';
                        htmlData += '<dl class="row">';
                        htmlData += '<dt class="col-sm-4">Catatan</dt>';
                        htmlData += '<dd class="col-sm-8"><textarea class="form-control" rows="4" readonly>'+v.catatan+'</textarea></dd>';

                        htmlData += '<dt class="col-sm-4">Tanggal Validasi</dt>';
                        if (v.tanggal == null) {
                            htmlData += '<dd class="col-sm-8">__</dd>';
                        } else {
                            htmlData += '<dd class="col-sm-8">'+v.tanggal+'</dd>';
                        }

                        htmlData += '<dt class="col-sm-4">Tanggal Target</dt>';
                        htmlData += '<dd class="col-sm-8">'+v.tanggal_target+'</dd>';

                        if (data.ar !== '') {
                            switch (v.nama_area) {
                                case 'AR':
                                    htmlData += '<dt class="col-sm-4">Nominal</dt>';
                                    htmlData += '<dd class="col-sm-8">';
                                    data.ar.forEach(function(v,i) {
                                        htmlData += '<p>'+v.nominal+'</p>';
                                    });
                                    htmlData += '</dd>';
                                    break;

                                case 'RETAIL':
                                    htmlData += '<dt class="col-sm-4">Nominal</dt>';
                                    htmlData += '<dd class="col-sm-8">'+v.nominal+'</dd>';
                                    break;

                                case 'PENAGIHAN':
                                    htmlData += '<dt class="col-sm-4">Nominal</dt>';
                                    htmlData += '<dd class="col-sm-8">'+v.nominal+'</dd>';
                                    break;

                                case 'PELUNASAN':
                                    htmlData += '<dt class="col-sm-4">Nominal</dt>';
                                    htmlData += '<dd class="col-sm-8">'+v.nominal+'</dd>';
                                    break;
                            }
                        }
                        htmlData += '</dl>';
                        htmlData += '</dd>';
                    });
                    $('#detailArea').html(htmlData);
                    $('#modalDetail').modal('show');
                }
            });
        });

        function setCreatedCells(data) {
            let result;
            if (data == null) {
                result = 'white';
            } else {
                if (tgl.indexOf('overdue') == -1) {
                    result = 'white';
                } else {
                    result = 'red';
                }
            }
            return result;
        }

        $(document).ready(function () {
            var tables = $('#datatable').DataTable({
                "scrollY": "250px",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                // "pageLength": 25,
                // "searching": false,
                "bInfo": false,
                "fixedColumns": {
                    "leftColumns": 1,
                },
                "autoWidth": false,
                "columnDefs": [
                    { width: '200px', targets: 0 },
                    { width: '100px', targets: 1 },
                    { width: '100px', targets: 2 },
                    { width: '100px', targets: 3 },
                    { width: '100px', targets: 4 },
                    { width: '100px', targets: 5 },
                    { width: '100px', targets: 6 },
                    { width: '100px', targets: 7 },
                    { width: '100px', targets: 8 },
                    { width: '100px', targets: 9 },
                    { width: '100px', targets: 10 },
                    { width: '100px', targets: 11 },
                ],
                {{--"ajax": {--}}
                {{--    "method": "GET",--}}
                {{--    "url": "{{ url('/dashboard/penjualan/summary') }}",--}}
                {{--    "header": {--}}
                {{--        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),--}}
                {{--    }--}}
                {{--},--}}
                "columns": [
                    {
                        "data": "no_spk",
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).css('background-color', 'white');
                            $(td).css('color', 'black');
                        }
                    },
                    {
                        "data": "1",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "2",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "3",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "4",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "5",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "6",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "7",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "8",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "9",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "11",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "12",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "13",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                    {
                        "data": "14",
                        createdCell: function (td, cellData, rowData, row, col) {
                            var tgl = cellData;
                            if (tgl == null) {
                                $(td).css('background-color', 'white');
                            } else {
                                if (tgl.startsWith('overdue') == true) {
                                    $(td).html('');
                                    $(td).css('background-color', 'red');
                                    $(td).css('color', 'white');
                                } else if (tgl.startsWith('updated') == true) {
                                    $(td).html(cellData.replace('updated -', ''));
                                    $(td).css('background-color', 'orange');
                                    $(td).css('color', 'white');
                                } else {
                                    $(td).css('background-color', 'green');
                                    $(td).css('color', 'white');
                                }
                            }
                        }
                    },
                ],
                "order": [[0,'asc']]
            });

            $('#datatable tbody').on( 'click', 'tr', function () {
                let data = tables.row( this ).data();
                noSPK = data.no_spk;
                $('#viewNoSpk').val(noSPK);
                // console.log(noSPK);
                btnViewDetail.removeAttr('disabled');
            });

            formFilter.submit(function(e) {
                let startDate = moment($('#inputTanggal').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
                let endDate = moment($('#inputTanggal').data('daterangepicker').endDate._d).format('YYYY-MM-DD');
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('dashboard/penjualan/summary/list') }}",
                    method: "post",
                    data: {start_date: startDate, end_date: endDate, status: iStatus.val()},
                    success: function(result) {
                        // console.log(result);
                        var data = JSON.parse(result);
                        if (data.rows == '') {
                            Swal.fire({
                                type: 'info',
                                title: 'Data kosong',
                                text: 'Tidak terdapat data pada filter yang anda pilih'
                            });
                        } else {
                            cardComponent.removeClass('d-none');
                            tables.clear().draw();
                            tables.rows.add(data.data).draw();
                            $('html, body').animate({
                                scrollTop: cardComponent.offset().top
                            }, 500);
                        }
                        let dataSPK = Array();
                        let tableData = tables.data();
                        for (i=0 ; i<tableData.length ; i++) {
                            let array = {
                                text: tableData[i].no_spk
                            };
                            dataSPK.push(array);
                        }
                        selectSpk.setData(dataSPK);
                        btnViewDateDiff.removeAttr('disabled');
                        // btnViewAverage.removeAttr('disabled');
                    }
                });
            });

            formDifference.submit(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('dashboard/penjualan/summary/spk/difference') }}",
                    method: "post",
                    data: {no_spk: selectSpk.selected(), area_awal: iAreaAwal.val(), area_akhir: iAreaAkhir.val()},
                    success: function(result) {
                        // console.log(result);
                        let htmlSpa = '<td>Selisih per Area</td>';
                        let htmlSdf = '<td>Selisih dari Faktur</td>';

                        var data = JSON.parse(result);
                        cardDetailSPK.removeClass('d-none');

                        data.selisih_per_area.forEach(function(v) {
                            htmlSpa += '<td>'+v+'</td>';
                        });

                        data.selisih_dari_faktur.forEach(function(v) {
                            htmlSdf += '<td>'+v+'</td>';
                        });

                        $('#selisihPerArea').html(htmlSpa);
                        $('#selisihPerFaktur').html(htmlSdf);
                        $('#retailVsPenagihan').html(data.retail_vs_penagihan);
                        $('#retailVsPelunasan').html(data.retail_vs_pelunasan);
                        $('#custom').html(data.custom);

                        $('html, body').animate({
                            scrollTop: cardDetailSPK.offset().top
                        }, 500);
                    }
                });
            });

            btnViewAverage.click(function (e) {
                e.preventDefault();
            });

            btnExportExcel.click(function (e) {
                e.preventDefault();

                let startDate = moment($('#inputTanggal').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
                let endDate = moment($('#inputTanggal').data('daterangepicker').endDate._d).format('YYYY-MM-DD');

                window.open('{{ url('dashboard/export/excel/penjualan-summary') }}'+'/'+startDate+'/'+endDate+'/'+iStatus.val(),'_blank');
                {{--$.ajax({--}}
                {{--    url: '{{ url('/dashboard/penjualan/summary/export/excel') }}',--}}
                {{--    method: 'post',--}}
                {{--    data: {start_date: startDate, end_date: endDate, status: iStatus.val(), data:'penjualan-summary'},--}}
                {{--    success: function(result) {--}}
                {{--        console.log(result);--}}
                {{--        // const a = document.createElement('a');--}}
                {{--        // const url = window.URL.createObjectURL((result));--}}
                {{--        //--}}
                {{--        // a.href = url;--}}
                {{--        // a.download = 'export-summary.xlsx';--}}
                {{--        // document.body.append(a);--}}
                {{--        // a.click();--}}
                {{--        // a.remove();--}}
                {{--        // window.URL.revokeObjectURL(url);--}}
                {{--    }--}}
                {{--});--}}
            })
        });
    </script>
@endsection
