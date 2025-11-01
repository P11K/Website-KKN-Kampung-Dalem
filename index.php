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

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img src="assets/img/kota.png" style="width: 50px; height: auto;"
                    alt="Logo" class="logo" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profile">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Berita dan Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#maps">Maps</a></li>
                    <li class="nav-item"><a class="nav-link" href="data.html">Data Penduduk</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Welcome To Kelurahan</div>
            <div class="masthead-heading text-uppercase">Kampungdalem</div>
            <!-- <a class="btn btn-primary btn-xl text-uppercase" href="#profile">Tell Me More</a> -->
        </div>
    </header>
    <!-- Services-->
    <section class="page-section" id="profile">
        <div class="container">
            <div class="text-center">
            </div>
            <div class="row text-center">
                <div class="col-md-4" style="margin-top: 150px;">
                    <span class="fa-stack fa-4x">
                        <img src="assets/img/kota.png" style="width: auto; height: 140px;" alt="Logo" class="logo" />
                    </span>
                    <a href="perangkat.php">
                        <h4 class="my-3">Perangkat Kelurahan</h4>
                    </a>
                    <p class="text-muted">Profil Perangkat Kelurahan Kampungdalem.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <img src="assets/img/lgokpg.png" style="width: auto; height: 140px;" alt="Logo" class="logo" />
                    </span>
                    <a href="profilekd.php">
                        <h4 class="my-3">Profile Kelurahan</h4>
                    </a>
                    <p class="text-muted">Penjelasan Tentang Biografi Kelurahan Kampungdalem.</p>
                </div>
                <div class="col-md-4" style="margin-top: 144px;">
                    <span class="fa-stack fa-4x">
                        <img src="assets/l2.png" style="width: auto; height: 165px;" alt="Logo" class="logo" />
                    </span>
                    <a href="lkk.php">
                        <h4 class="my-3">Lembaga Kemasyarakatan Kelurahan</h4>
                    </a>
                    <p class="text-muted">LPMK, RT, RW, PKK, Posyandu, Karang Taruna dan LINMAS</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Berita Grid-->
    <?php
    include 'admin/koneksi.php'; // Koneksi hanya sekali

    // Ambil berita terbaru
    $sql = "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3";
    $result = mysqli_query($conn, $sql);

    $berita_array = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $id_berita = $row['id_berita'];
        $berita_array[$id_berita] = $row;
        $berita_array[$id_berita]['isian'] = []; // Siapkan array kosong untuk isian
    }

    // Ambil data isian berita jika ada berita yang ditemukan
    if (!empty($berita_array)) {
        $sql_isian = "SELECT isian.* FROM isian WHERE isian.id_berita IN (" . implode(',', array_keys($berita_array)) . ")";
        $result_isian = mysqli_query($conn, $sql_isian);

        while ($row_isian = mysqli_fetch_assoc($result_isian)) {
            $id_berita = $row_isian['id_berita'];
            $berita_array[$id_berita]['isian'][] = $row_isian;
        }
    }
    ?>


    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">BERITA DAN GALERI KAMPUNGKU</h2>
            </div>
            <div class="row">
                <?php if (!empty($berita_array)) { ?>
                    <?php foreach ($berita_array as $id_berita => $berita) { ?>
                        <div class="col-lg-4 col-sm-6 mb-4">
                            <div class="portfolio-item">
                                <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $id_berita; ?>">
                                    <div class="portfolio-hover">
                                        <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                    </div>
                                    <img class="img-fluid custom-img" src="assets/img/<?php echo !empty($berita['gambar']) ? $berita['gambar'] : 'default.jpg'; ?>" alt="..." />
                                </a>
                                <div class="portfolio-caption">
                                    <div class="portfolio-caption-heading"><?php echo $berita['judul']; ?></div>
                                    <div class="portfolio-caption-subheading text-muted"><?php echo date("d F Y", strtotime($berita['tanggal'])); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada berita yang tersedia.</p>
                    </div>
                <?php } ?>
            </div>
            <ul class="pagination">
                <li><a href="next/berita.php">Berita Yang Lain</a></li>
            </ul>
        </div>
    </section>

    <section class="page-section bg-light" id="maps">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Maps</h2>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d988.1592948068218!2d112.01212575622431!3d-7.828170409713354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78570f4bd18033%3A0x226882e63af4ae0f!2sKantor%20Kelurahan%20Kampung%20Dalem!5e0!3m2!1sid!2sid!4v1739675514791!5m2!1sid!2sid" width="100%" height="380" style="border:0;" allowfullscreen></iframe>
    </section>

    <?php if (!empty($berita_array)) { ?>
        <?php foreach ($berita_array as $id_berita => $berita) { ?>
            <div class="portfolio-modal modal fade" id="portfolioModal<?php echo $id_berita; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="modal-body">
                                        <h2 class="text-uppercase" style="word-wrap: break-word;"><?php echo $berita['judul']; ?></h2>
                                        <p class="item-intro text-muted"><?php echo date("d F Y", strtotime($berita['tanggal'])); ?></p>
                                        <!-- <img class="img-fluid d-block mx-auto" src="assets/img/<?php echo !empty($berita['gambar']) ? $berita['gambar'] : 'default.jpg'; ?>" alt="..."> -->

                                        <?php if (!empty($berita['isian'])) { ?>
                                            <?php foreach ($berita['isian'] as $isian) { ?>
                                                <div class="mt-3">
                                                    <h5><?php echo $isian['judul_isian']; ?></h5>
                                                    <img class="img-fluid d-block mx-auto" src="assets/img/<?php echo !empty($isian['gambar']) ? $isian['gambar'] : 'default.jpg'; ?>" alt="..." width="100%">
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
    <?php } ?>

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
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#profile">Profile</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#portfolio">Berita dan Galeri</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#maps">Maps</a></li>
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>