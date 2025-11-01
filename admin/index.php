<?php
require 'koneksi.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href = 'admin/login.php';
          </script>";
    exit();
}

// Koneksi ke database


// Ambil data LKK
$query = "SELECT id, nama FROM lkk";
$result = $conn->query($query);

$lkk_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lkk_data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kampungdalem</title>
    <link href="css/admin.css" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <nav>
        <h5>Halaman Admin
            <a class="nav-link" href="logout.php">
                <button>Kembali</button>
            </a>
        </h5>
    </nav>

    <!-- Admin Links Container -->
    <div class="admin-container" style="margin-top: 30px;">
        <a href="updt.php" style="text-decoration: none;">
            <div class="admin-card">
                <i class="fas fa-edit"></i>
                <p>Update Berita</p>
            </div>
        </a>

        <a href="upddatapenduduk.php" style="text-decoration: none;">
            <div class="admin-card">
                <i class="fas fa-database"></i>
                <p>Tambah Dan Update Data Penduduk</p>
            </div>
        </a>

        <a href="updtprofil.php" style="text-decoration: none;">
            <div class="admin-card">
                <i class="fas fa-user-circle"></i>
                <p>Tambah Dan Update Profil Kelurahan</p>
            </div>
        </a>

        <a href="perangkat.php" style="text-decoration: none;">
            <div class="admin-card">
                <i class="fas fa-user-circle"></i>
                <p>Tambah Dan Hapus Perangkat</p>
            </div>
        </a>

        <!-- Tombol LKK -->
       <!-- Tombol LKK -->
<button id="btnLKK">Tambah Dan Hapus LKK</button>

<!-- Modal untuk Menampilkan LKK -->
<div id="lkkModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Daftar LKK</h3>
        <div id="lkkList">
            <?php
            foreach ($lkk_data as $lkk) {
                // Tentukan file tujuan berdasarkan nama LKK
                switch ($lkk['nama']) {
                    case 'LPMK':
                        $file = 'adminlpmk.php';
                        break;
                    case 'RT':
                        $file = 'adminrt.php';
                        break;
                    case 'RW':
                        $file = 'adminrw.php';
                        break;
                    case 'PKK':
                        $file = 'adminpkk.php';
                        break;
                    case 'Posyandu':
                        $file = 'crud_kader.php';
                        break;
                    case 'Karang Taruna':
                        $file = 'adminkartar.php';
                        break;
                    case 'LINMAS':
                        $file = 'adminlinmas.php';
                        break;
                    default:
                        echo"File Tidak Ada"; // Default jika tidak cocok
                        break;
                }

                // Buat link dengan ID sebagai parameter (menggunakan htmlspecialchars untuk keamanan)
                echo "<a href='" . htmlspecialchars($file) . "?id=" . htmlspecialchars($lkk['id']) . "' class='lkk-button'>" . htmlspecialchars($lkk['nama']) . "</a>";
            }
            ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const btnLKK = document.getElementById("btnLKK");
    const modal = document.getElementById("lkkModal");
    const closeModal = document.querySelector("#lkkModal .close");

    // Ketika tombol LKK diklik, modal muncul
    btnLKK.addEventListener("click", function () {
        modal.style.display = "flex";
    });

    // Tutup modal jika tombol close diklik
    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Tutup modal jika klik di luar modal
    window.addEventListener("click", function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
});
</script>

</body>
</html>
