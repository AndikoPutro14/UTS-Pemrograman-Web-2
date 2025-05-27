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
        <a class="btn btn-primary" href="/uts/create.php" role="button">Tambahkan Barang</a>
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
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_inventory";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// --- Handle Pinjam action ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle hapus
    if (isset($_POST['hapus_id'])) {
    $hapus_id = intval($_POST['hapus_id']);
    $delete_sql = "DELETE FROM tb_inventory WHERE id_barang = $hapus_id";
    if ($connection->query($delete_sql) === TRUE) {
        echo "<script>alert('Barang berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus barang');</script>";
    }
}
    // Handle Pinjam
    if (isset($_POST['pinjam_id'])) {
        $pinjam_id = $_POST['pinjam_id'];

        $check = $connection->query("SELECT jumlah_barang FROM tb_inventory WHERE id_barang = $pinjam_id");
        if ($check && $check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $jumlah = $row["jumlah_barang"];
            if ($jumlah > 0) {
                $new_jumlah = $jumlah - 1;
                $new_status = ($new_jumlah == 0) ? 0 : 1;
                $connection->query("UPDATE tb_inventory SET jumlah_barang = $new_jumlah, status_barang = $new_status WHERE id_barang = $pinjam_id");
                echo "<script>alert('Kamu berhasil meminjam barang');</script>";
            } else {
                echo "<script>alert('Stok barang habis');</script>";
            }
        }
    }

    // Handle Tambah Stok
    if (isset($_POST['tambah_stok_id']) && isset($_POST['jumlah_tambah'])) {
        $id = $_POST['tambah_stok_id'];
        $jumlah_tambah = intval($_POST['jumlah_tambah']);

        if ($jumlah_tambah > 0) {
            // Get current jumlah
            $check = $connection->query("SELECT jumlah_barang FROM tb_inventory WHERE id_barang = $id");
            if ($check && $check->num_rows > 0) {
                $row = $check->fetch_assoc();
                $new_jumlah = $row["jumlah_barang"] + $jumlah_tambah;
                $new_status = ($new_jumlah > 0) ? 1 : 0;
                $connection->query("UPDATE tb_inventory SET jumlah_barang = $new_jumlah, status_barang = $new_status WHERE id_barang = $id");
                echo "<script>alert('Stok berhasil ditambahkan');</script>";
            }
        } else {
            echo "<script>alert('Jumlah stok harus lebih dari 0');</script>";
        }
    }
}


$sql = "SELECT * FROM tb_inventory";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid Query: " . $connection->error);
}

while ($row = $result->fetch_assoc()) {
    $status_text = $row['status_barang'] ? '<span class="badge bg-success">Available</span>' : '<span class="badge bg-danger">Not Available</span>';
    $pinjam_disabled = $row['jumlah_barang'] == 0 ? 'disabled' : '';

    echo "
    <tr>
        <td>{$row['id_barang']}</td>
        <td>{$row['kode_barang']}</td>
        <td>{$row['nama_barang']}</td>
        <td>{$row['jumlah_barang']}</td>
        <td>{$row['satuan_barang']}</td>
        <td>{$row['harga_beli']}</td>
        <td>$status_text</td>
        <td>
            <form method='post' style='display:inline-block;'>
                <input type='hidden' name='pinjam_id' value='{$row['id_barang']}'>
                <button type='submit' class='btn btn-warning btn-sm mb-1' $pinjam_disabled>Pinjam</button>
            </form>

            <form method='post' class='d-flex gap-1 mt-1'>
                <input type='hidden' name='tambah_stok_id' value='{$row['id_barang']}'>
                <input type='number' name='jumlah_tambah' min='1' class='form-control form-control-sm' style='width: 80px;' placeholder='Jumlah'>
                <button type='submit' class='btn btn-success btn-sm'>Tambah Stok</button>
            </form>

            <form method='post' onsubmit='return confirm(\"Yakin ingin menghapus barang ini?\");' style='margin-top: 0.5rem;'>
                <input type='hidden' name='hapus_id' value='{$row['id_barang']}'>
                <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
            </form>
            <a href='/uts/update.php?id={$row['id_barang']}' class='btn btn-info btn-sm mt-1'>Update</a>

        </td>
    </tr>
    ";
}

?>
</tbody>

        </table>
    </div>
</body>
</html>