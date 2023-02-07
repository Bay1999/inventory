@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5>Home</h5>
                            <div class="d-flex">
                                <a class="btn btn-primary" href="{{ route('inventory.create') }}">
                                    <i class="fa fa-plus">Tambah Inventory</i>
                                </a>
                                <a href="{{ route('inventory.beli') }}" class="btn btn-info mx-2">Beli Inventory</a>
                                <a href="{{ route('inventory.jual') }}" class="btn btn-success">Jual Inventory</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Stok Barang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($inventories as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->harga }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>
                                                <form>
                                                    <input type="hidden" name="_token" id="token"
                                                           value="{{ csrf_token() }}" />
                                                    <input type="hidden" id="id" name="id"
                                                           value="{{ $item->inventory_id }}">
                                                    <button type="button" class="btn btn-danger"
                                                            onclick="hapus()">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hapus() {
            Swal.fire({
                    title: `Anda yakin menghapus data ini?`,
                    text: "Data akan terhapus selamanya.",
                    icon: "warning",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak",
                    showCancelButton: true,
                })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            url: "{{ route('inventory.delete') }}",
                            type: "POST",
                            data: {
                                "_token": $('#token').val(),
                                "id": $('#id').val(),
                            },
                            success: function(response) {
                                data = JSON.parse(response);
                                if (data.status == '200') {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Inventory Berhasil Dihapus',
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
                                        text: 'Server Error',
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
                });
        }
    </script>
@endsection
