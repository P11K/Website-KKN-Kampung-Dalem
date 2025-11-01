<?php
// Koneksi ke database
include '../admin/koneksi.php';
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan folder penyimpanan gambar ada
$folder_linmas = "uploads";
if (!file_exists($folder_linmas)) {
    mkdir($folder_linmas, 0777, true);
}

// Default lkk_id (sesuai dengan tabel linmas)
$lkk_id = 7; // Pastikan id ini ada di tabel linmas

// Tambah Data
if (isset($_POST["tambah"])) {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $jabatan = $_POST["jabatan"];
    $no_hp = $_POST["no_hp"];
    
    // Upload Foto
    $foto = $_FILES["foto"]["name"];
    $target = "uploads/" . basename($foto);
    if (!empty($foto)) {
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target);
    } else {
        $foto = NULL;
    }

    $sql = "INSERT INTO linmas (lkk_id, nama, alamat, jabatan, foto, no_hp) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $lkk_id, $nama, $alamat, $jabatan, $foto, $no_hp);
    $stmt->execute();
    $stmt->close();

    header("Location: adminlinmas.php");
}

// Hapus Data
if (isset($_GET["hapus"])) {
    $id = $_GET["hapus"];
    $sql = "DELETE FROM linmas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: adminlinmas.php");
}

// Ambil Data untuk Edit
$editData = null;
if (isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $sql = "SELECT * FROM linmas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editData = $result->fetch_assoc();
    $stmt->close();
}

// Update Data
if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $jabatan = $_POST["jabatan"];
    $no_hp = $_POST["no_hp"];

    if ($_FILES["foto"]["name"]) {
        $foto = $_FILES["foto"]["name"];
        $target = "uploads/" . basename($foto);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target);

        $sql = "UPDATE linmas SET nama = ?, alamat = ?, jabatan = ?, foto = ?, no_hp = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nama, $alamat, $jabatan, $foto, $no_hp, $id);
    } else {
        $sql = "UPDATE linmas SET nama = ?, alamat = ?, jabatan = ?, no_hp = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $alamat, $jabatan, $no_hp, $id);
    }
    
    $stmt->execute();
    $stmt->close();
    header("Location: adminlinmas.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Linmas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Data Linmas</h2>

    <!-- Form Tambah & Edit -->
    <div class="card mb-4">
        <div class="card-body">
            <h5><?= isset($editData) ? "Edit Linmas" : "Tambah Linmas" ?></h5>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= isset($editData) ? $editData['id'] : '' ?>">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required value="<?= isset($editData) ? $editData['nama'] : '' ?>">
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required><?= isset($editData) ? $editData['alamat'] : '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" required value="<?= isset($editData) ? $editData['jabatan'] : '' ?>">
                </div>
                <div class="mb-3">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control">
                    <?php if (isset($editData) && $editData['foto']): ?>
                        <img src="uploads/<?= $editData['foto'] ?>" width="50">
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" required value="<?= isset($editData) ? $editData['no_hp'] : '' ?>">
                </div>
                <button type="submit" name="<?= isset($editData) ? "update" : "tambah" ?>" class="btn btn-success">
                    <?= isset($editData) ? "Update" : "Simpan" ?>
                </button>
                <?php if (isset($editData)): ?>
                    <a href="adminlinmas.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jabatan</th>
                <th>Foto</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM linmas WHERE lkk_id = $lkk_id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    <td><?= $row['jabatan'] ?></td>
                    <td><img src="uploads/<?= $row['foto'] ?>" width="50"></td>
                    <td><?= $row['no_hp'] ?></td>
                    <td>
                        <a href="adminlinmas.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="adminlinmas.php?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
