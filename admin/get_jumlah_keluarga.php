<?php
include '../admin/koneksi.php';

// Cek jika ada request kategori dari AJAX
if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];

    // Query untuk mengambil jumlah dari kategori
    $stmt = $conn->prepare("SELECT jumlah FROM ekonomi_masyarakat WHERE kategori=?");
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $stmt->bind_result($jumlah);
    $stmt->fetch();
    
    // Pastikan output hanya angka jumlah
    echo $jumlah;

    $stmt->close();
    $conn->close();
    exit();
}
?>
