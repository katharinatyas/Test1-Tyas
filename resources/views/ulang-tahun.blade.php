@extends('layouts.app')
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard
                    </h2>
                    <h5 class="text-white op-7 mb-2">Aplikasi Ulang Tahun</h5>
                </div>

            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <h2 class="header-title">Ucapan Selamat Ulang Tahun</h2>
                                </div>
                            </div>
                            <br>
                            <form method="post" action="{{ route('index.store') }}">
                                @csrf
                                <label for="birthday">Masukkan Nama:</label>
                                <input type="text" id="nama" name="nama">
                                <label for="birthday">Masukkan tanggal ulang tahun:</label>
                                <input type="date" id="birthday" name="birthday">
                                <button type="submit">Submit</button>
                            </form>
                            <div id="message">
                                @isset($message)
                                    <p>{{ $message }}</p>
                                @endisset

                                @isset($hadiah)
                                    <h2>Spin the Wheel</h2>
                                    <button onclick="spinWheel()">Spin</button>
                                    <div id="spinResult"></div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div class="ml-md-auto py-2 py-md-0">
                            <button onclick="add()" class="btn btn-primary btn-round">Tambah Hadiah <i
                                    class="fas fa-plus-circle"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="display table table-hover" width="70%">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>Daftar Hadiah</th>
                                            <th style="width: 130px;">
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('modal')
@section('js')
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script src="{{ url('atlantis/assets/vendor/number/jquery.number.min.js') }}"></script>

    <script>
        var table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = $('#dataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('index.index') }}",
                    type: "GET",
                    data: function(data) {
                        data.name = $('#name').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        function reload_table() {
            table.ajax.reload(null, false);
        }

        function add() {
            $('#form')[0].reset(); // reset form on modals
            $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
            $('#modal-form').modal('show'); // show bootstrap modal
        }

        function save() {
            $('#nama').html("");
            $.ajax({
                url: "{{ route('index.store') }}",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('#modal-form').modal('hide');
                    reload_table();
                    sukses();
                },
            });
        }

        function delete_data(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
            })
            swalWithBootstrapButtons.fire({
                title: 'Konfirmasi !',
                text: "Anda Akan Menghapus Data ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus !',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "/index/" + id,
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(data) {
                            reload_table();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Batal',
                        'Data tidak dihapus',
                        'error'
                    )
                }
            })
        }

        function edit(id) {
            $('#form')[0].reset();
            // console.log(id);
            $('#nama').html("");
            $('[name="id"]').val('');
            //Ajax Load data from ajax
            $.ajax({
                url: "/index/" + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.id);
                    $('[name="nama"]').val(data.name);
                    $('#modal-form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title
                }
            });
        }

        function spinWheel() {
            var hadiah = @json($hadiah ?? []);
            var nama = @json($nama ?? []);
            if (hadiah.length === 0) {
                return;
            }
            var randomIndex = Math.floor(Math.random() * hadiah.length);
            var spinResult = document.getElementById('spinResult');
            spinResult.innerHTML = "<p>CONGRATZ " + nama.toUpperCase() + " YOU GOT " + hadiah[randomIndex].name
                .toUpperCase() + " FROM US</p>";
        }
    </script>
@endsection
