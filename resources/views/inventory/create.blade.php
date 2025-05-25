@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Barang Baru</h2>

    @if ($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Kode Barang</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="kode_barang" value="{{ old('kode_barang') }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Nama Barang</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="nama_barang" value="{{ old('nama_barang') }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Jumlah Barang</label>
            <div class="col-sm-6">
                <input type="number" min="1" class="form-control" name="jumlah_barang" value="{{ old('jumlah_barang', 1) }}" required>
                <div class="form-text">Minimal 1</div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Satuan Barang</label>
            <div class="col-sm-6">
                <select class="form-select" name="satuan_barang">
                    <option value="pcs">pcs</option>
                    <option value="kg">kg</option>
                    <option value="liter">liter</option>
                    <option value="meter">meter</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Harga Beli</label>
            <div class="col-sm-6">
                <input type="number" step="0.01" min="0" class="form-control" name="harga_beli" value="{{ old('harga_beli') }}" required>
            </div>
        </div>

        <input type="hidden" name="status_barang" value="1">

        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a href="{{ route('inventory.index') }}" class="btn btn-outline-primary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
