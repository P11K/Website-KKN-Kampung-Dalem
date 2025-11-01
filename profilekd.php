<?php
// Koneksi ke database
include 'admin/koneksi.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data jumlah penduduk
$query_penduduk = "SELECT * FROM demografi";
$result_penduduk = $conn->query($query_penduduk);
$row_penduduk = $result_penduduk->fetch_assoc();

// Ambil data ekonomi masyarakat
$query_ekonomi = "SELECT * FROM ekonomi_masyarakat";
$result_ekonomi = $conn->query($query_ekonomi);

// Ambil data pejabat
$query_pejabat = "SELECT * FROM pejabat";
$result_pejabat = $conn->query($query_pejabat);

// Ambil data struktur organisasi
// $query_struktur = "SELECT * FROM struktur_organisasi";
// $result_struktur = $conn->query($query_struktur);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kelurahan Kampung Dalem</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Style -->
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
        }

        h2 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .card:hover {
            transform: translateY(-10px);
            transition: transform 0.3s;
        }

        .custom-bg {
            background-color: #f4f4f9;
        }

        #mainNav {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: rgba(0, 0, 0, 0.8) !important;
            transition: background-color 0.3s;
        }

        .custom-footer {
            background-color: #343a40;
            padding: 30px 0;
            color: white;
        }

        .custom-footer .footer-link {
            color: #f8f9fa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .custom-footer .footer-link:hover {
            color: #ffc107;
        }

        .custom-footer .social-links a {
            margin-right: 15px;
            font-size: 24px;
            transition: color 0.3s;
        }

        .custom-footer .social-links a:hover {
            color: #ffc107;
        }

        .card-img-top {
            height: 300px;
            width: 100%; /* Pastikan gambar memenuhi lebar kartu */
            object-fit: cover;
            border-bottom: 2px solid #007bff;
            display: block;
            margin: 0 auto; /* Pusatkan gambar */
        }

        .card {
            text-align: center; /* Pusatkan teks di dalam kartu */
            width: 100%; /* Pastikan kartu memenuhi lebar kolom */
        }

        .col-md-4 {
            display: flex;
            justify-content: center; /* Pusatkan kartu di dalam kolom */
        }

        /* Navbar Animation */
        .nav-link {
            position: relative;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #ffc107 !important;
        }

        .nav-link.active {
            color: #ffc107 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #343a40;" id="mainNav">
        <div class="container">
            <a class="navbar-brand text-white" href="#page-top">
                <img src="assets/img/kota.png" style="width: 50px; height: auto;" alt="Logo" class="logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="custom-bg text-black text-center py-5" style="margin-top: 100px;">
        <h1>Profil Kelurahan Kampung Dalem</h1>
    </header>
    <div class="container my-5">
        <section id="profil-pejabat" class="mb-5">
            <h2 class="text-center">Profil Pejabat</h2>
            <div class="row justify-content-center">
                <?php while ($row = $result_pejabat->fetch_assoc()) { 
                    $foto_path = "admin/uploads/" . $row['foto']; // Menggunakan nama file dari database
                ?>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card shadow-sm mb-4">
                            <img src="<?php echo $foto_path; ?>" class="card-img-top" 
                                 alt="Foto <?php echo $row['nama']; ?>" 
                                 onerror="this.onerror=null;this.src='uploads/default.jpg';">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['jabatan']; ?></h6>
                                <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <section id="gambaran-umum" class="mb-5">
            <h2>Gambaran Umum</h2>
            <p>Kelurahan Kampungdalem merupakan salah satu dari 17 kelurahan yang berada di Kecamatan Kota, Kota Kediri, Provinsi Jawa Timur, dengan luas wilayah 0,332 km² dari total luas kecamatan 14,90 km². Berlokasi di Jl. Brigjend Katamso No. 17 dengan kode pos 64126, kelurahan ini memiliki peran strategis dalam dinamika sosial dan ekonomi Kota Kediri. Sebagai bagian dari pusat kota, Kampungdalem memiliki potensi besar dalam pemanfaatan teknologi digital untuk meningkatkan kualitas layanan kepada masyarakat, khususnya dalam mendukung transparansi administrasi serta mempercepat penyebaran informasi yang lebih merata dan efisien  (Pemerintah Kota Kediri, 2019).</p>
        </section>
        <section id="ekonomi-masyarakat" class="mb-5">
            <h2>Ekonomi Masyarakat</h2>
            <ul class="list-group">
                <?php
                if ($result_ekonomi->num_rows > 0) {
                    while ($row = $result_ekonomi->fetch_assoc()) {
                        echo "<li class='list-group-item'>" . $row['kategori'] . ": " . $row['jumlah'] . " keluarga</li>";
                    }
                } else {
                    echo "<li class='list-group-item'>Tidak ada data ekonomi masyarakat.</li>";
                }
                ?>
            </ul>
        </section>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>