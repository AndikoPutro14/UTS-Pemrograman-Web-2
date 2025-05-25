@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Update Data Barang</h2>

    @if ($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('inventory.update', $item->id_barang) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>ID Barang</label>
            <input type="text" class="form-control" value="{{ $item->id_barang }}" disabled>
        </div>

        <div class="mb-3">
            <label>Kode Barang</label>
            <input type="text" class="form-control" value="{{ $item->kode_barang }}" disabled>
            <input type="hidden" name="kode_barang" value="{{ $item->kode_barang }}">
        </div>

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" class="form-control" name="nama_barang" value="{{ old('nama_barang', $item->nama_barang) }}" required>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" class="form-control" name="jumlah_barang" min="0" value="{{ old('jumlah_barang', $item->jumlah_barang) }}" required>
        </div>

        <div class="mb-3">
            <label>Satuan</label>
            <input type="text" class="form-control" name="satuan_barang" value="{{ old('satuan_barang', $item->satuan_barang) }}" required>
        </div>

        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli" min="0" step="0.01" value="{{ old('harga_beli', $item->harga_beli) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
