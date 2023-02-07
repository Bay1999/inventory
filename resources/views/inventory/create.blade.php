@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Buat Inventory
                    </div>

                    <div class="card-body">
                        <form>
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" id="nama_barang" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" id="harga_barang" class="form-control" required>
                            </div>
                            <button type="button" onclick="simpan()" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function simpan() {
            $.ajax({
                url: "{{ route('inventory.save') }}",
                type: "POST",
                data: {
                    "_token": $('#token').val(),
                    "nama_barang": $('#nama_barang').val(),
                    "harga_barang": $('#harga_barang').val(),
                },
                success: function(response) {
                    data = JSON.parse(response);
                    if (data.status == '200') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Inventory Berhasil Di tambah',
                            icon: 'success',
                            confirmButtonText: 'OKE'
                        }).then(function() {
                            window.location.href = "{{ route('home') }}";
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Server Error',
                            icon: 'error',
                            confirmButtonText: 'OKE'
                        })
                    }
                },
                error: function(response) {
                    if (response.status == 422) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Nama Barang & Harga Barang Tidak Boleh Kosong',
                            icon: 'error',
                            confirmButtonText: 'OKE'
                        })
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Server Error',
                            icon: 'error',
                            confirmButtonText: 'OKE'
                        })
                    }
                }

            })
        }
    </script>
@endsection
