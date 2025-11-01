<?php
include '../admin/koneksi.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pesan = "";
$status = "";

// Proses tambah data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $total_penduduk = $_POST['total_penduduk'];
    $total_balita = $_POST['total_balita'];
    $total_lansia = $_POST['total_lansia'];
    $total_ibu_hamil = $_POST['total_ibu_hamil'];
    $total_laki = $_POST['total_laki'];
    $total_perempuan = $_POST['total_perempuan'];
    $updated_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO data_penduduk (total_penduduk, total_balita, total_lansia, total_ibu_hamil, total_laki, total_perempuan, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiss", $total_penduduk, $total_balita, $total_lansia, $total_ibu_hamil, $total_laki, $total_perempuan, $updated_at);

    if ($stmt->execute()) {
        $pesan = "Data berhasil ditambahkan!";
        $status = "success";
    } else {
        $pesan = "Error: " . $stmt->error;
        $status = "error";
    }
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $total_penduduk = $_POST['total_penduduk'];
    $total_balita = $_POST['total_balita'];
    $total_lansia = $_POST['total_lansia'];
    $total_ibu_hamil = $_POST['total_ibu_hamil'];
    $total_laki = $_POST['total_laki'];
    $total_perempuan = $_POST['total_perempuan'];
    $updated_at = date("Y-m-d H:i:s");

    $sql = "UPDATE data_penduduk SET 
            total_penduduk = ?, total_balita = ?, total_lansia = ?, 
            total_ibu_hamil = ?, total_laki = ?, total_perempuan = ?, updated_at = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiissi", $total_penduduk, $total_balita, $total_lansia, $total_ibu_hamil, $total_laki, $total_perempuan, $updated_at, $id);

    if ($stmt->execute()) {
        $pesan = "Data berhasil diupdate!";
        $status = "success";
    } else {
        $pesan = "Error: " . $stmt->error;
        $status = "error";
    }
}

// Ambil semua data dari tabel
$sql = "SELECT * FROM data_penduduk";
$result = $conn->query($sql);
$data_list = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Penduduk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
         .back-options {
            margin-top: 20px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .back-options a {
            text-decoration: none;
        }

        .back-options button {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .back-options button:hover {
            background:rgb(207, 43, 43);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Kelola Data Penduduk</h2>

        <!-- Tombol Tambah Data -->
        <button class="btn btn-success mb-3" onclick="showTambahForm()">Tambah Data</button>

        <!-- Tabel Data Penduduk -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total Penduduk</th>
                    <th>Total Balita</th>
                    <th>Total Lansia</th>
                    <th>Total Ibu Hamil</th>
                    <th>Total Laki-Laki</th>
                    <th>Total Perempuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_list as $data) : ?>
                    <tr data-id="<?= $data['id']; ?>">
                        <td><?= $data['id']; ?></td>
                        <td><?= $data['total_penduduk']; ?></td>
                        <td><?= $data['total_balita']; ?></td>
                        <td><?= $data['total_lansia']; ?></td>
                        <td><?= $data['total_ibu_hamil']; ?></td>
                        <td><?= $data['total_laki']; ?></td>
                        <td><?= $data['total_perempuan']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="showUpdateForm(<?= $data['id']; ?>)">Update</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- SweetAlert2 untuk Tambah Data -->
    <script>
        function showTambahForm() {
            Swal.fire({
                title: 'Tambah Data Penduduk',
                html:
                    `<form id="tambahForm" method="POST">
                        <input type="hidden" name="tambah">
                        <input type="number" name="total_penduduk" class="swal2-input" placeholder="Total Penduduk" required>
                        <input type="number" name="total_balita" class="swal2-input" placeholder="Total Balita" required>
                        <input type="number" name="total_lansia" class="swal2-input" placeholder="Total Lansia" required>
                        <input type="number" name="total_ibu_hamil" class="swal2-input" placeholder="Total Ibu Hamil" required>
                        <input type="number" name="total_laki" class="swal2-input" placeholder="Total Laki-Laki" required>
                        <input type="number" name="total_perempuan" class="swal2-input" placeholder="Total Perempuan" required>
                    </form>`,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                preConfirm: () => {
                    document.getElementById('tambahForm').submit();
                }
            });
        }

        function showUpdateForm(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const cells = row.getElementsByTagName("td");

            Swal.fire({
                title: 'Update Data Penduduk',
                html:
                    `<form id="updateForm" method="POST">
                        <input type="hidden" name="update">
                        <input type="hidden" name="id" value="${id}">
                        <input type="number" name="total_penduduk" class="swal2-input" value="${cells[1].textContent}" required>
                        <input type="number" name="total_balita" class="swal2-input" value="${cells[2].textContent}" required>
                        <input type="number" name="total_lansia" class="swal2-input" value="${cells[3].textContent}" required>
                        <input type="number" name="total_ibu_hamil" class="swal2-input" value="${cells[4].textContent}" required>
                        <input type="number" name="total_laki" class="swal2-input" value="${cells[5].textContent}" required>
                        <input type="number" name="total_perempuan" class="swal2-input" value="${cells[6].textContent}" required>
                    </form>`,
                showCancelButton: true,
                confirmButtonText: 'Update',
                preConfirm: () => {
                    document.getElementById('updateForm').submit();
                }
            });
        }
    </script>

    <?php if (!empty($pesan)) : ?>
        <script>
            Swal.fire({ icon: "<?= $status; ?>", title: "<?= ($status == 'success') ? 'Berhasil!' : 'Gagal!'; ?>", text: "<?= $pesan; ?>" });
        </script>
    <?php endif; ?>
    <div class="back-options">
    <a href="index.php">
        <button><i class="fas fa-arrow-left"></i> Kembali</button>
    </a>
    </div>
</body>
</html>
