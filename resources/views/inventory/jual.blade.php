@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Jual Inventory
                    </div>

                    <div class="card-body">
                        <form>
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <select id="nama_barang" class="form-select">
                                    @forelse ($inventories as $item)
                                        <option value="{{ $item->inventory_id }}">{{ $item->nama }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" id="jumlah_barang" class="form-control" required>
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
                url: "{{ route('inventory.jual.simpan') }}",
                type: "POST",
                data: {
                    "_token": $('#token').val(),
                    "nama_barang": $('#nama_barang').val(),
                    "jumlah_barang": $('#jumlah_barang').val(),
                },
                success: function(response) {
                    data = JSON.parse(response);
                    if (data.status == '200') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Inventory Berhasil Dijual',
                            icon: 'success',
                            confirmButtonText: 'OKE'
                        }).then(function() {
                            window.location.href = "{{ route('home') }}";
                        });
                    } else if (data.status == '401') {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Jumlah Barang Yang dijual harus lebih sedikit dari stok atau lebih dari 0',
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
                },
                error: function(response) {
                    if (response.status == 422) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Nama Barang & Jumlah Barang Tidak Boleh Kosong',
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
