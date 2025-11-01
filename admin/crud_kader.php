<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'kampungdalem';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah Data
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];
    $no_wa = $_POST['no_wa'];
    $posyandu_id = $_POST['posyandu_id'];
    
    // Ambil nama Posyandu
    $sqlPosyandu = "SELECT nama_posyandu FROM posyandu WHERE id = $posyandu_id";
    $resultPosyandu = $conn->query($sqlPosyandu);
    $rowPosyandu = $resultPosyandu->fetch_assoc();
    $namaPosyandu = $rowPosyandu['nama_posyandu'];
    
    // Membuat folder berdasarkan nama Posyandu jika belum ada
    $target_dir = "assets/FOTOKADER/" . $namaPosyandu . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);  // Buat folder jika belum ada
    }
    
    $foto = "";
    if (!empty($_FILES["foto"]["name"])) {
        $foto = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    }
    
    $sql = "INSERT INTO kader_posyandu (nama, alamat, jabatan, no_wa, posyandu_id, foto) VALUES ('$nama', '$alamat', '$jabatan', '$no_wa', '$posyandu_id', '$foto')";
    $conn->query($sql);
    header("Location: crud_kader.php");
}

// Hapus Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "SELECT foto, posyandu_id FROM kader_posyandu WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $posyandu_id = $row['posyandu_id'];
    $foto = $row['foto'];
    
    if ($foto) {
        // Ambil nama Posyandu
        $sqlPosyandu = "SELECT nama_posyandu FROM posyandu WHERE id = $posyandu_id";
        $resultPosyandu = $conn->query($sqlPosyandu);
        $rowPosyandu = $resultPosyandu->fetch_assoc();
        $namaPosyandu = $rowPosyandu['nama_posyandu'];
        
        // Hapus foto dari folder Posyandu
        unlink("assets/FOTOKADER/"); // Hapus file gambar
    }
    
    $sql = "DELETE FROM kader_posyandu WHERE id=$id";
    $conn->query($sql);
    header("Location: crud_kader.php");
}

// Ambil Data Kader
$sql = "SELECT k.id, k.nama, k.alamat, k.jabatan, k.no_wa, k.foto, p.nama_posyandu FROM kader_posyandu k INNER JOIN posyandu p ON k.posyandu_id = p.id";
$result = $conn->query($sql);

// Ambil Data Posyandu
$sqlPosyandu = "SELECT * FROM posyandu";
$resultPosyandu = $conn->query($sqlPosyandu);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Kader Posyandu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Manajemen Kader Posyandu</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>No WA</label>
            <input type="text" name="no_wa" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Posyandu</label>
            <select name="posyandu_id" class="form-control" required>
                <?php while ($row = $resultPosyandu->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"> <?php echo $row['nama_posyandu']; ?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button type="submit" name="add" class="btn btn-primary">Tambah Kader</button>
    </form>
    
    <h3 class="mt-4">Daftar Kader</h3>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jabatan</th>
                <th>No WA</th>
                <th>Posyandu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <img src="<?php echo $row['foto'] ? 'assets/FOTOKADER/' . $row['nama_posyandu'] . '/' . $row['foto'] : 'assets/default-avatar.png'; ?>" 
                             width="50" height="50" alt="Foto Kader">
                    </td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td><?php echo $row['jabatan']; ?></td>
                    <td><?php echo $row['no_wa']; ?></td>
                    <td><?php echo $row['nama_posyandu']; ?></td>
                    <td>
                        <a href="crud_kader.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
