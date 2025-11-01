<?php
include '../admin/koneksi.php';

// Tambah Data
if (isset($_POST['add'])) {
    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $foto = basename($_FILES['foto']['name']);  // Store only the file name, not the full path
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto);
    }

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];

    $stmt = $conn->prepare("INSERT INTO perangkat (foto, nama, alamat, jabatan, no_hp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $foto, $nama, $alamat, $jabatan, $no_hp);
    $stmt->execute();
}

// Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $foto = $row['foto']; // Foto lama tetap digunakan jika tidak diubah

    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $foto = basename($_FILES['foto']['name']);  // Store only the file name, not the full path
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto);
    }

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];

    $stmt = $conn->prepare("UPDATE perangkat SET foto = ?, nama = ?, alamat = ?, jabatan = ?, no_hp = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $foto, $nama, $alamat, $jabatan, $no_hp, $id);
    $stmt->execute();
}

// Hapus Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM perangkat WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Ambil data untuk ditampilkan
$result = $conn->query("SELECT * FROM perangkat");

// Ambil data untuk Edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result_edit = $conn->query("SELECT * FROM perangkat WHERE id = $id");
    $row_edit = $result_edit->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Perangkat Kelurahan</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .modal-body input, .modal-body textarea {
            width: 100%;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">CRUD Perangkat Kelurahan Kampungdalem</h1>

        <!-- Form Tambah Data -->
        <h2 class="mb-4">Tambah Data</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= isset($row_edit['nama']) ? $row_edit['nama'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= isset($row_edit['alamat']) ? $row_edit['alamat'] : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?= isset($row_edit['jabatan']) ? $row_edit['jabatan'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= isset($row_edit['no_hp']) ? $row_edit['no_hp'] : ''; ?>" required>
            </div>
            <?php if (isset($row_edit)): ?>
                <input type="hidden" name="id" value="<?= $row_edit['id']; ?>">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            <?php else: ?>
                <button type="submit" name="add" class="btn btn-primary">Tambah</button>
            <?php endif; ?>
        </form>

        <hr>

        <!-- Tabel Data perangkat -->
        <h2 class="mb-4">Data Perangkat</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jabatan</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= $row['foto']; ?>" width="100" alt="Foto <?= $row['nama']; ?>"></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['alamat']; ?></td>
                    <td><?= $row['jabatan']; ?></td>
                    <td><?= $row['no_hp']; ?></td>
                    <td>
                        <a href="?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
