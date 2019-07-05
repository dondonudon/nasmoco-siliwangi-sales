@extends('dashboard-layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Master User</h1>
            <button class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btnNew">
                <i class="fas fa-plus"></i> New User
            </button>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-sm table-hover table-bordered display nowrap" id="datatable" width="100%">
                            <thead class="text-white bg-primary">
                                <tr>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xl-8"></div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-outline-primary">Disable</button>
                            </div>
                            <div class="col-xl-2">
                                <button class="btn btn-block btn-primary">Edit</button>
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
                                <div class="form-group">
                                    <label for="inputUsername">Username</label>
                                    <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword">Password</label>
                                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="inputNamaLengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="inputNamaLengkap" name="nama_lengkap" placeholder="Nama Lengkap">
                                </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-8"></div>
                                <div class="col-xl-2">
                                    <button type="button" class="btn btn-block btn-outline-primary" id="cancelBtn">Cancel</button>
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
            var newButton = $('#btnNew');
            var cancelButton = $('#cancelBtn');

            cancelButton.click(function (e) {
                e.preventDefault();
                cardComponent.addClass('d-none');
            });

            newButton.click(function (e) {
                e.preventDefault();
                cardTitle.html('New User');
                cardComponent.removeClass('d-none');
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
                    "url": "{{ url('/dashboard/master/user/list') }}",
                    "header": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    }
                },
                "columns": [
                    { "data": "username" },
                    { "data": "nama_lengkap" }
                ],
                "order": [[0,'asc']]
            });

            $('#datatable tbody').on( 'click', 'tr', function () {
                var data = tables.row( this ).data();
                console.log(data);
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    // setID.val('');
                    // setDisplayName.val('');
                    // btnEdit.attr('disabled','true');
                    // btnDelete.attr('disabled','true');
                }
                else {
                    tables.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    // setID.val(data['id_product']);
                    // setDisplayName.val(data['nama']);
                    // btnEdit.removeAttr('disabled');
                    // btnDelete.removeAttr('disabled');
                }
            });

            cardForm.submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('dashboard/master/user/new') }}",
                    method: "post",
                    data: $(this).serialize(),
                    success: function(result) {
                        var data = JSON.parse(result);
                        console.log(data);
                        // if (data.status == 'success') {
                        //     cardComponent.addClass('d-none');
                        //     tables.reload();
                        // }
                    }
                });
            });
        })
    </script>
@endsection