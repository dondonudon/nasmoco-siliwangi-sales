<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Nasmoco Siliwangi - Sales Summary</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/FixedColumns-3.2.5/css/fixedColumns.bootstrap4.css') }}">
</head>
<body>
<nav class="navbar navbar-danger bg-dark text-white">
    <adiv class="navbar-brand">
        <img src="{{ asset('img/logosiliwangilingkaran.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
        NASMOCO Siliwangi Plus
    </adiv>
</nav>
<div class="row mt-2">
    <div class="col-lg">
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
                <th>STNK</th>
                <th>PENAGIHAN</th>
                <th>PELUNASAN</th>
                <th>BPKB</th>
            </tr>
            </thead>
        </table>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>

<!-- DataTables -->
<script type="text/javascript" src="{{ asset('vendor/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/FixedColumns-3.2.5/js/dataTables.fixedColumns.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/FixedColumns-3.2.5/js/fixedColumns.bootstrap4.min.js') }}"></script>

<script>
    const tables = $('#datatable').DataTable({
        // "scrollY": "150px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
        // "pageLength": 25,
        "searching": false,
        "bInfo": false,
        "fixedColumns": {
            "leftColumns": 1,
        },
        "autoWidth": false,
        "columnDefs": [
            {width: '200px', targets: 0},
            {width: '100px', targets: 1},
            {width: '100px', targets: 2},
            {width: '100px', targets: 3},
            {width: '100px', targets: 4},
            {width: '100px', targets: 5},
            {width: '100px', targets: 6},
            {width: '100px', targets: 7},
            {width: '100px', targets: 8},
            {width: '100px', targets: 9},
            {width: '100px', targets: 10},
            {width: '100px', targets: 11},
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
                            $(td).css('background-color', 'red');
                            $(td).css('color', 'white');
                        } else if (tgl.startsWith('updated') == true) {
                            console.log(cellData);
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
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
                "data": "10",
                createdCell: function (td, cellData, rowData, row, col) {
                    var tgl = cellData;
                    if (tgl == null) {
                        $(td).css('background-color', 'white');
                    } else {
                        if (tgl.startsWith('overdue') == true) {
                            $(td).html(cellData.replace('overdue -', ''));
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
                            $(td).html(cellData.replace('overdue -', ''));
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
        "order": [[0, 'asc']]
    });

    function getTableData(start,end,status) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: "{{ url('dashboard/penjualan/summary/list') }}",
            method: "post",
            data: {start_date: start, end_date: end, status: status},
            success: function(result) {
                // console.log(result);
                let data = JSON.parse(result);
                tables.clear().draw();
                tables.rows.add(data.data).draw();
            }
        });
    }

    $(document).ready(function () {
        let start = "{{ $start }}";
        let end = "{{ $end }}";
        let status = "{{ $status }}";

        getTableData(start,end,status);

        setInterval(function() {
            getTableData(start,end,status);
        }, 5000);
    });
</script>
</body>
</html>