<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "db_inventory";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_barang   = trim($_POST["kode-barang"]);
    $nama_barang   = trim($_POST["nama-barang"]);
    $jumlah_barang = intval($_POST["jumlah-barang"]);
    $satuan_barang = $_POST["satuan-barang"];
    $harga_beli    = floatval($_POST["harga-beli"]);
    // force status always available
    $status_barang = 1;

    // Validation
    if (empty($kode_barang) || empty($nama_barang)) {
        echo "<div class='alert alert-warning text-center'>Kode Barang dan Nama Barang wajib diisi.</div>";
    }
    elseif ($jumlah_barang < 1) {
        echo "<div class='alert alert-warning text-center'>Jumlah Barang harus lebih dari 1.</div>";
    }
    else {
        $sql = "INSERT INTO tb_inventory 
                (kode_barang, nama_barang, jumlah_barang, satuan_barang, harga_beli, status_barang)
                VALUES 
                ('$kode_barang', '$nama_barang', $jumlah_barang, '$satuan_barang', $harga_beli, $status_barang)";

        if ($connection->query($sql) === TRUE) {
            echo "<div class='alert alert-success text-center'>Data berhasil ditambahkan!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . $connection->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <h2>Barang Baru</h2>
    <form method="post" novalidate>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Kode Barang</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="kode-barang" required>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nama Barang</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="nama-barang" required>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Jumlah Barang</label>
        <div class="col-sm-6">
          <input type="number" min="1" class="form-control" name="jumlah-barang" value="1" required>
          <div class="form-text">Minimal 1</div>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Satuan Barang</label>
        <div class="col-sm-6">
          <select class="form-select" name="satuan-barang">
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
          <input type="number" step="0.01" min="0" class="form-control" name="harga-beli" required>
        </div>
      </div>

      <!-- Status is always Available, so we can hide this or keep it read-only -->
      <input type="hidden" name="status-barang" value="1">

      <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-sm-3 d-grid">
          <a href="/uts/index.php" class="btn btn-outline-primary">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
