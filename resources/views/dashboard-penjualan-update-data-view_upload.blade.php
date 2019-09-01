@extends('dashboard-layout')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/filepond-master/filepond.min.css') }}">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Data</h1>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Preview Data Excel</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table>
                            <thead>
                            <tr>
                                <td>No SPK</td>
                                <td>Nama Customer</td>
                                <td>Nama STNK</td>
                                <td>Aju Faktur</td>
                                <td>Aju DR</td>
                                <td>PDS In</td>
                                <td>Gesek</td>
                                <td>Retail</td>
                                <td>Faktur Datang</td>
                                <td>PDS Out</td>
                                <td>STNK Jadi</td>
                                <td>Penagihan</td>
                                <td>Pelunasan</td>
                                <td>BPKB Jadi</td>
                                <td>BPKB Diterima</td>
                                <td>BPKB Diserahkan</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <iframe id="downloadFrame" style="display: none;"></iframe>
@endsection

@section('script')
    <script src="{{ asset('vendor/filepond-master/filepond.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        const tables = $('#datatable').DataTable({
            "scrollY": "400px",
            "scrollX": true,
            "scrollCollapse": true,
            // "paging": false,
            "pageLength": 25,
            "bInfo": false,
            "columns": [
                { "data": "no_spk" },
                {
                    "data": "nama_customer",
                    "render": function (data,type,row,meta) {
                        let result = '';
                        if (data !== 'false') {
                            result = data;
                        }
                    }
                },
                { "data": "nama_stnk" },
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "5" },
                { "data": "6" },
                { "data": "7" },
                { "data": "8" },
                { "data": "9" },
                { "data": "11" },
                { "data": "12" },
                { "data": "13" },
                { "data": "14" },
            ],
            "order": [[0,'asc']]
        });

        $(document).ready(function() {

        })
    </script>
@endsection
