<?php
require 'admin/koneksi.php';

// Query untuk mengambil semua data LKK
$sql = "SELECT id, nama, foto FROM lkk";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kampungdalem Kota Kediri</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/l1.png" />
    <link href="assets/l1.png" rel="icon">
    <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/main.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.php#page-top"><img src="assets/img/kota.png" style="width: 50px; height: auto;"
                    alt="Logo" class="logo" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#profile">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#portfolio">Berita dan Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#maps">Maps</a></li>
                    <li class="nav-item"><a class="nav-link" href="data.html">Data Penduduk</a></li>
                </ul>
            </div>
        </div>
    </nav>
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center" style="margin-top: 40px;">
            <h2 class="section-heading text-uppercase">LKK</h2>
            <h3 class="section-subheading text-muted">Lembaga Kemasyarakatan Kelurahan.</h3>
        </div>
        <div class="row justify-content-center">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $lkk_id = $row['id'];
                    $lkk_nama = $row['nama'];

                    // Query untuk mengambil detail dari masing-masing tabel berdasarkan lkk_id
                    $query_detail = "
                    SELECT 'lpmk' AS kategori, nama, alamat, jabatan, no_hp, foto FROM lpmk WHERE lkk_id = $lkk_id AND nama IS NOT NULL
                    UNION ALL
                    SELECT 'rt' AS kategori, nama, alamat, jabatan, no_hp, foto FROM rt WHERE lkk_id = $lkk_id AND nama IS NOT NULL
                    UNION ALL
                    SELECT 'pkk' AS kategori, nama, alamat, jabatan, no_hp, foto FROM pkk WHERE lkk_id = $lkk_id AND nama IS NOT NULL
                    UNION ALL
                    SELECT 'rw' AS kategori, nama, alamat, jabatan, no_hp, foto 
                    FROM rw WHERE lkk_id = $lkk_id AND nama IS NOT NULL 
                    AND EXISTS (SELECT 1 FROM lkk WHERE id = $lkk_id AND nama = 'RW')
                    UNION ALL
                    SELECT 'karang_taruna' AS kategori, nama, alamat, jabatan, no_hp, foto FROM karang_taruna WHERE lkk_id = $lkk_id AND nama IS NOT NULL
                    UNION ALL
                    SELECT 'linmas' AS kategori, nama, alamat, jabatan, no_hp, foto FROM linmas WHERE lkk_id = $lkk_id AND nama IS NOT NULL
                ";
                
               

                $result_detail = $conn->query($query_detail);
//                 echo "<pre>";
// print_r($result_detail->fetch_all(MYSQLI_ASSOC));
// echo "</pre>";

                if (!$result_detail) {
                    die("Query Error: " . $conn->error);
                }
                
                
                    $result_detail = $conn->query($query_detail);
                    ?>

<div class="col-lg-4 col-sm-6 mb-4">
    <div class="portfolio-item text-center"> <!-- Tambahkan text-center di sini -->
        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $lkk_id; ?>">
            <div class="portfolio-hover">
                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
            </div>
            <div class="d-flex justify-content-center"> <!-- Tambahkan wrapper ini -->
                <img class="img-fluid w-50" src="logolkk/<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto <?php echo htmlspecialchars($lkk_nama); ?>" />
            </div>
        </a>
        <div class="portfolio-caption">
            <div class="portfolio-caption-heading"><?php echo htmlspecialchars($lkk_nama); ?></div>
        </div>
    </div>
</div>


                    
                    <!-- Modal untuk setiap LKK -->
                    <div class="modal fade" id="portfolioModal<?php echo $lkk_id; ?>" tabindex="-1" aria-labelledby="portfolioModalLabel<?php echo $lkk_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="portfolioModalLabel<?php echo $lkk_id; ?>">
                                        <?php echo htmlspecialchars($lkk_nama); ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Daftar <?php echo htmlspecialchars($lkk_nama); ?>:</strong></p>
                                    <?php
                                    if ($result_detail->num_rows > 0) {
                                        while ($detail = $result_detail->fetch_assoc()) {
                                            echo "<div class='member-card'>";
                                            echo "<h5>" . htmlspecialchars($detail['nama']) . "</h5>";
                                            echo "<p><strong>Jabatan:</strong> " . htmlspecialchars($detail['jabatan']) . "</p>";
                                            echo "<p><strong>Alamat:</strong> " . htmlspecialchars($detail['alamat']) . "</p>";
                                            echo "<p><strong>No. HP:</strong> " . htmlspecialchars($detail['no_hp']) . "</p>";
                                            if (!empty($detail['foto'])) {
                                                echo "<img src='admin/uploads/" . htmlspecialchars($detail['foto']) . "' alt='Foto' class='member-photo'>";
                                            } else {
                                                echo "<p><em>Tidak ada foto</em></p>";
                                            }
                                            echo "<hr>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<p class='text-center'>Data tidak tersedia</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center'>Belum ada data LKK.</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- CSS Tambahan -->
<style>
.member-card {
    padding: 15px;
    border-radius: 8px;
    background: #f8f9fa;
    margin-bottom: 10px;
}
.member-photo {
    width: 80px;
    height: 80px;
    object-fit: cover;
    margin-top: 5px;
}
</style>
<!-- Footer-->
<footer id="footer" class="footer">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="#" class="d-flex align-items-center">
                        <img src="assets/l1.png" style="width: 50px; height: auto;" alt="Logo" class="logo" />
                        <span class="sitename"> Kampungdalem</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl. Brigjen Katamso No.17, KampungDalem, Kec. Kota, Kota Kediri, Jawa Timur 64129</p>
                        <p class="mt-3"><strong>Telepon:</strong> <span>0354-696997</span></p>
                        <p><strong>Email:</strong> <span>Kampungdalem@gmail.com</span></p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Alternative Button</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="index.php">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="index.php#profile">Profile</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="index.php#portfolio">Berita dan Galeri</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="index.php#maps">Maps</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="data.html">Data Penduduk</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h4>Follow Us</h4>
                    <p>Untuk mengetahui kegiatan yang lebih lengkap di media sosial di bawah ini.</p>
                    <div class="social-links d-flex">
                        <!-- <a href=""><i class="bi bi-whatsapp"></i></a> -->
                        <a href="https://www.facebook.com/profile.php?id=100079334840888&ref=ig_profile_ac"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/kelurahan_kampungdalem/" target="_blank"><i class="bi bi-instagram"></i></a>
                        <!-- <a href="https://www.youtube.com/"><i class="bi bi-youtube"></i></a> -->
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Kampungdalem</strong> <span>All Rights
                    Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://www.instagram.com/kknt24.kampungdalem2025/">KKN-T Kel-24 UN PGRI Kediri Kel Kampungdalem 2025</a>
            </div>
        </div>
    </footer>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#portfolioModal3").addEventListener("show.bs.modal", function (event) {
        let lkkId = 3; // Ganti dengan ID sesuai dengan yang digunakan di database

        fetch("get_rw_data.php?lkk_id=" + lkkId)
            .then(response => response.json())
            .then(data => {
                let modalBody = document.querySelector("#portfolioModal3 .modal-body");
                modalBody.innerHTML = "<p><strong>Anggota RW:</strong></p>";

                if (data.length > 0) {
                    data.forEach(member => {
                        modalBody.innerHTML += `
                            <div class='member-card'>
                                <h5>${member.nama} </h5>
                                <p><strong>Jabatan:</strong> ${member.jabatan}</p>
                                <p><strong>Alamat:</strong> ${member.alamat}</p>
                                <p><strong>No. HP:</strong> ${member.no_hp}</p>
                                ${member.foto ? `<img src='admin/uploads/${member.foto}' alt='Foto' class='member-photo'>` : `<p><em>Tidak ada foto</em></p>`}
                                <hr>
                            </div>
                        `;
                    });
                } else {
                    modalBody.innerHTML += "<p class='text-center'>Data tidak tersedia</p>";
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    });
});
document.addEventListener("DOMContentLoaded", function () {
    let modal5 = document.querySelector("#portfolioModal5");

    if (modal5) {
        modal5.addEventListener("show.bs.modal", function () {
            window.location.href = "posyandu.php";
        });
    }
});

</script>

</body>
</html>