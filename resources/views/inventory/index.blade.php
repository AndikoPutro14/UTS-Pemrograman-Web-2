@extends('layouts.app')

@section('content')
    <h2>Daftar Barang</h2>
    <a href="{{ url('/inventory/create') }}" class="btn btn-primary mb-3">Tambahkan Barang</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID Barang</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $item)
                <tr>
                    <td>{{ $item->id_barang }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah_barang }}</td>
                    <td>{{ $item->satuan_barang }}</td>
                    <td>{{ $item->harga_beli }}</td>
                    <td>
                        {!! $item->status_barang ? '<span class="badge bg-success">Available</span>' : '<span class="badge bg-danger">Not Available</span>' !!}
                    </td>
                    <td>
                        <!-- Pinjam -->
                        <form action="{{ route('inventory.pinjam', $item->id_barang) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm" {{ $item->jumlah_barang == 0 ? 'disabled' : '' }}>Pinjam</button>
                        </form>

                        <!-- Tambah Stok -->
                        <form action="{{ route('inventory.tambah-stok', $item->id_barang) }}" method="POST" class="d-inline-flex gap-1 align-items-center mt-1">
                            @csrf
                            <input type="number" name="jumlah_tambah" min="1" class="form-control form-control-sm" style="width: 80px;" placeholder="Jumlah">
                            <button type="submit" class="btn btn-success btn-sm">Tambah Stok</button>
                        </form>

                        <!-- Update -->
                        <a href="{{ route('inventory.edit', $item->id_barang) }}" class="btn btn-info btn-sm mt-1">Update</a>

                        <!-- Hapus -->
                        <form action="{{ route('inventory.destroy', $item->id_barang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');" style="display:inline-block; margin-top:0.5rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
