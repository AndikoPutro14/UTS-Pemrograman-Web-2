<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Daftar Barang</h2>
        <a class="btn btn-primary" href="{{ route('inventory.create') }}" role="button">Tambahkan Barang</a>
        <br>
        <table class="table table-striped table-bordered mt-4">
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
            @foreach ($inventories as $item)
                @php
                    $statusText = $item->status_barang
                        ? '<span class="badge bg-success">Available</span>'
                        : '<span class="badge bg-danger">Not Available</span>';
                @endphp
                <tr>
                    <td>{{ $item->id_barang }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah_barang }}</td>
                    <td>{{ $item->satuan_barang }}</td>
                    <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td>{!! $statusText !!}</td>
                    <td>
                        <!-- Pinjam -->
                        <form method="POST" action="{{ route('inventory.pinjam', $item->id_barang) }}" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm mb-1" {{ $item->jumlah_barang == 0 ? 'disabled' : '' }}>Pinjam</button>
                        </form>

                        <!-- Tambah Stok -->
                        <form method="POST" action="{{ route('inventory.tambah-stok', $item->id_barang) }}" class="d-flex gap-1 mt-1">
                            @csrf
                            <input type="number" name="jumlah_tambah" min="1" class="form-control form-control-sm" style="width: 80px;" placeholder="Jumlah">
                            <button type="submit" class="btn btn-success btn-sm">Tambah Stok</button>
                        </form>

                        <!-- Hapus -->
                        <form method="POST" action="{{ route('inventory.destroy', $item->id_barang) }}"
                              onsubmit="return confirm('Yakin ingin menghapus barang ini?');" style="margin-top: 0.5rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>

                        <!-- Update -->
                        <a href="{{ route('inventory.edit', $item->id_barang) }}" class="btn btn-info btn-sm mt-1">Update</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
