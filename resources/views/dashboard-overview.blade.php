@extends('dashboard-layout')

@php
$infoArea = App\Http\Controllers\OverviewCard::infoDashboard();
@endphp

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
<<<<<<< HEAD
                            <div class="font-weight-bold text-primary text-uppercase mb-1">SPK Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $infoArea['spk_bulan_ini']->total }}</div>
=======
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">SPK Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $infoArea['spk'] }}</div>
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                        </div>
                        <div class="col-auto" id="cobaIcon">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <div class="row">
        <div class="col col-md mt-4 mb-4">
            <div class="card shadow h-100 bg-dark text-white text-center">
                <div class="card-body">
                    Info dibawah merupakan total SPK dari masing-masing Area yang belum tervalidasi pada bulan ini
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        @foreach($infoArea['spk_belum_validasi'] as $i)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">{{ $i->nama }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $i->total }}</div>
                            </div>
                            <div class="col-auto">
                                <form id="viewSPK" onsubmit="event.preventDefault(); getNoSPK('{{ $i->id_area }}');">
                                    <input type="hidden" name="area" value="{{ $i->id_area }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Lihat</button>
                                </form>
=======
    <!-- Content Row -->
    <div class="row">

        @foreach($infoArea['info'] as $i => $v)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card {{ $v['color'] }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ $i }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $v['x'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-area fa-2x text-gray-300"></i>
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
<<<<<<< HEAD
    <!-- Content Row -->

</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalInfo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="infoTable" class="table table-sm table-bordered display nowrap" width="100%">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>No SPK</th>
                        <th>Nama Customer</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
=======

    <!-- Content Row -->



>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
</div>
@endsection

@section('script')
    <script>
<<<<<<< HEAD
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#cobaIcon').html('<i class="fas fa-car fa-2x text-gray-300"></i>');
        const tables = $('#infoTable').DataTable({
            "scrollCollapse": true,
            "pageLength": 25,
            "columns": [
                { "data": "no_spk" },
                { "data": "nama_customer" },
            ],
            "order": [[0,'asc']]
        });

        function getNoSPK(id) {
            $.ajax({
                url: '{{ url('dashboard/get-detail') }}',
                method: 'post',
                data: {id: id},
                success: function (response) {
                    console.log(response);
                    let data = JSON.parse(response);
                    tables.clear().draw();
                    tables.rows.add(data).draw();
                    $('#modalInfo').modal('show');
                }
            })
        }
    </script>
@endsection
=======
        $('#cobaIcon').html('<i class="fas fa-car fa-2x text-gray-300"></i>');
    </script>
@endsection
>>>>>>> fb36541946d6bf550f664e9214eca5d209eafcac
