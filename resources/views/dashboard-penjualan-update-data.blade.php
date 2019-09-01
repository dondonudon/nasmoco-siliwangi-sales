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
            <button class="btn d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" id="btnSample">
                <i class="fas fa-download"></i> Download Excel Sample
            </button>
        </div>

        <!-- Content Row -->

        <div class="row">

            <div class="col-xl col-lg">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">UPLOAD FILE</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <input id="cardUpload_uploadFile" type="file" hidden>
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
        /*
        Card Upload
         */
        const uploadArea = document.getElementById('cardUpload_uploadFile');

        /*
        Download Excel
         */
        const download = document.getElementById('downloadFrame');
        const btnSample = $('#btnSample');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $(document).ready(function() {
            btnSample.click(function (e) {
                e.preventDefault();
                download.src = '{{ url('dashboard/penjualan/update-data/upload/sample') }}';
            });

            FilePond.create( uploadArea );
            FilePond.setOptions({
                allowMultiple: false,
                allowDrop: true,
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort) => {
                        const formData = new FormData();
                        formData.append(fieldName, file, file.name);

                        const request = new XMLHttpRequest();
                        request.open('POST','{{ url('dashboard/penjualan/update-data/upload') }}');
                        request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

                        request.upload.onprogress = (e) => {
                            progress(e.lengthComputable, e.loaded, e.total);
                        };

                        request.onload = function () {
                            if (request.status >= 200 && request.status < 300) {
                                load(request.responseText);
                                console.log(request.responseText);
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
        })
    </script>
@endsection
