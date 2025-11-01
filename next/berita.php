<?php
include '../admin/koneksi.php';

// Query untuk mengambil berita beserta isiannya
$sql = "SELECT berita.id_berita, berita.judul, berita.gambar AS gambar_berita, berita.tanggal, 
               isian.id_isian, isian.judul_isian, isian.deskripsi, isian.gambar AS gambar_isian
        FROM berita
        LEFT JOIN isian ON berita.id_berita = isian.id_berita
        ORDER BY berita.tanggal DESC";

$result = mysqli_query($conn, $sql);
$berita_array = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id_berita = $row['id_berita'];
    
    if (!isset($berita_array[$id_berita])) {
        $berita_array[$id_berita] = [
            'judul' => $row['judul'],
            'tanggal' => $row['tanggal'],
            'gambar_berita' => $row['gambar_berita'],
            'isian' => []
        ];
    }

    if (!empty($row['id_isian'])) {
        $berita_array[$id_berita]['isian'][] = [
            'id_isian' => $row['id_isian'],
            'judul_isian' => $row['judul_isian'],
            'deskripsi' => $row['deskripsi'],
            'gambar_isian' => $row['gambar_isian']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Kampungdalem Kota Kediri</title>
  <link rel="icon" type="image/x-icon" href="../assets/l1.png" />
  <link href="../css/styles.css" rel="stylesheet" />
  <link href="../css/main.css" rel="stylesheet" />
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img src="../assets/img/kota.png" style="width: 50px; height: auto;"
                    alt="Logo" class="logo" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Beranda</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="data.html">Data Penduduk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profile">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Berita dan Galeri</a></li>
                    <a href="admin/index.html"><button>
                        Log in
                    </button></a> -->
                </ul>
            </div>
        </div>
    </nav>
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center" style="margin-top: 50px;">
            <h2 class="section-heading text-uppercase">Berita Yang Lain</h2>
        </div>
        <div class="row">
            <?php foreach ($berita_array as $id_berita => $berita) { ?>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $id_berita; ?>">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid custom-img" src="../assets/img/<?php echo $berita['gambar_berita']; ?>" alt="...">
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?php echo $berita['judul']; ?></div>
                            <div class="portfolio-caption-subheading text-muted"><?php echo date("d F Y", strtotime($berita['tanggal'])); ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php foreach ($berita_array as $id_berita => $berita) { ?>
    <div class="portfolio-modal modal fade" id="portfolioModal<?php echo $id_berita; ?>" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-lg-8">
                          <div class="modal-body">
                              <h2 class="text-uppercase"><?php echo $berita['judul']; ?></h2>
                              <p class="item-intro text-muted"><?php echo date("d F Y", strtotime($berita['tanggal'])); ?></p>
                              <!-- <img class="img-fluid d-block mx-auto" src="../assets/img/<?php echo $berita['gambar_berita']; ?>" alt="..."> -->
                              
                              <?php if (!empty($berita['isian'])) { ?>
                                  <!-- <h4>Isiannya:</h4> -->
                                  <?php foreach ($berita['isian'] as $isian) { ?>
                                      <div class="mt-3">
                                          <h5><?php echo $isian['judul_isian']; ?></h5>
                                          <img class="img-fluid d-block mx-auto" src="../assets/img/<?php echo $isian['gambar_isian']; ?>" alt="..." width="100%">
                                          <p><?php echo nl2br($isian['deskripsi']); ?></p>
                                      </div>
                                  <?php } ?>
                              <?php } else { ?>
                                  <p class="text-muted">Belum ada isian untuk berita ini.</p>
                              <?php } ?>

                              <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                  <i class="fas fa-xmark me-1"></i> Close
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
<?php } ?>
<!-- Footer-->
<footer id="footer" class="footer">
<div class="container footer-top">
    <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.html" class="d-flex align-items-center">
                <img src="../assets/l1.png" style="width: 50px; height: auto;" alt="Logo" class="logo" />
                <span class="sitename"> Kampungdalem</span>
            </a>
            <div class="footer-contact pt-3">
                <p>Jl. Brigjen Katamso No.17, Kp. Dalem, Kec. Kota, Kota Kediri, Jawa Timur 64129</p>
                <p class="mt-3"><strong>Telepon:</strong> <span>0354-696997</span></p>
                <p><strong>Email:</strong> <span>Kampungdalem@gmail.com</span></p>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
            <h4>Alternative Button</h4>
            <ul>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            </ul>
        </div>

        <div class="col-lg-4 col-md-12">
            <h4>Follow Us</h4>
            <p>Untuk mengetahui kegiatan yang lebih lengkap di media sosial di bawah ini.</p>
            <div class="social-links d-flex">
                <!-- <a href=""><i class="bi bi-whatsapp"></i></a> -->
                <a href=""><i class="bi bi-facebook"></i></a>
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
        Designed by <a href="https://www.instagram.com/kknt24.kampungdalem2025/">KKN-T Kampungdalem 2025</a>
    </div>
</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/scripts.js"></script>

</body>
</html>