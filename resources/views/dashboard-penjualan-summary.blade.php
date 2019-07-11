@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Penjualan Summary</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Filter Penjualan</h6>
                    </div>
                    <!-- Card Body -->
                    <form id="form_filter">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="inputTanggal">Tanggal</label>
                                        <input type="text" class="form-control" id="inputTanggal" name="tanggal" placeholder="Range Tanggal" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="inputTanggal">Status Penjualan</label>
                                        <select class="form-control" id="inputPenjualan" name="penjualan" required>
                                            <option value="1">Selesai</option>
                                            <option value="0">Belum Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-10"></div>
                                <div class="col-xl-2">
                                    <button class="btn btn-block btn-danger" id="btnView">
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
                        <h6 class="m-0 font-weight-bold text-primary">Chart</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div id="timeline" style="height: 450px;"></div>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-10"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-danger" id="btnClose">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        const iStatus = $('#inputPenjualan');
        const formFilter = $('#form_filter');

        const btnCancel = $('#btnClose');

        const cardComponent = $('#cardData');

        const iTanggal = $('#inputTanggal').daterangepicker({
            maxDate: moment(),
            startDate: moment().startOf('month'),
            endDate: moment(),
            maxSpan: {
                'days': 31,
            },
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        btnCancel.click(function (e) {
            e.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 500, function () {
                cardComponent.addClass('d-none');
            });
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
                    var data = JSON.parse(result);
                    if (data.rows == '') {
                        Swal.fire({
                            type: 'info',
                            title: 'Data kosong',
                            text: 'Tidak terdapat data pada filter yang anda pilih'
                        });
                    } else {
                        cardComponent.removeClass('d-none');
                        google.charts.load('current', {'packages':['timeline']});
                        google.charts.setOnLoadCallback(function () {
                            drawChart(result);
                        });
                        $('html, body').animate({
                            scrollTop: cardComponent.offset().top
                        }, 500);
                    }
                }
            });
        });

        function drawChart(datas) {
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var data = new google.visualization.DataTable(datas);

            chart.draw(data);
        }
    </script>
@endsection