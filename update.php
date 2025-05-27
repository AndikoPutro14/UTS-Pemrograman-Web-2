<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_inventory";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get ID from URL
if (!isset($_GET["id"])) {
    echo "ID Barang tidak ditemukan.";
    exit;
}
$id = intval($_GET["id"]);

// Update Data (if form submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama_barang"];
    $jumlah = intval($_POST["jumlah_barang"]);
    $satuan = $_POST["satuan_barang"];
    $harga = floatval($_POST["harga_beli"]);
    $status = ($jumlah > 0) ? 1 : 0;

    $sql = "UPDATE tb_inventory 
            SET nama_barang='$nama', jumlah_barang=$jumlah, satuan_barang='$satuan', harga_beli=$harga, status_barang=$status 
            WHERE id_barang=$id";

    if ($connection->query($sql)) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data');</script>";
    }
}

// Fetch data to fill the form
$result = $connection->query("SELECT * FROM tb_inventory WHERE id_barang = $id");
if ($result->num_rows != 1) {
    echo "Barang tidak ditemukan.";
    exit;
}
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Update Data Barang</h2>
    <form method="post">
        <div class="mb-3">
            <label>ID Barang</label>
            <input type="text" class="form-control" value="<?= $data['id_barang'] ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Kode Barang</label>
            <input type="text" class="form-control" value="<?= $data['kode_barang'] ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" class="form-control" name="nama_barang" value="<?= $data['nama_barang'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" class="form-control" name="jumlah_barang" min="0" value="<?= $data['jumlah_barang'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Satuan</label>
            <input type="text" class="form-control" name="satuan_barang" value="<?= $data['satuan_barang'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli" min="0" step="0.01" value="<?= $data['harga_beli'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
