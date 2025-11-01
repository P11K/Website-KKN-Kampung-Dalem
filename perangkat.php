<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perangkat Kelurahan Kampungdalem</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom CSS */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-img-top {
            height: 300px;
            object-fit: cover;
        }

        h2.section-heading {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        #mainNav {
            background-color: rgba(0, 0, 0, 0.8) !important;
            transition: background-color 0.3s;
        }

        #mainNav.scrolled {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .nav-link {
            color: #ffffff !important;
            transition: color 0.3s, background-color 0.3s;
            border-radius: 5px;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #fff !important;
            background-color: #007bff;
        }

        .nav-link.active {
            color: #fff !important;
            background-color: #0056b3;
        }

        /* Footer Styles */
        .custom-footer {
            background-color: #343a40;
            padding: 40px 0;
            color: white;
            text-align: left;
        }

        .custom-footer a {
            color: #ffc107;
            text-decoration: none;
            transition: color 0.3s;
        }

        .custom-footer a:hover {
            color: #fff;
        }

        .custom-footer .sitename {
            font-weight: bold;
            font-size: 24px;
            margin-left: 10px;
        }

        .custom-footer .footer-contact p {
            margin-bottom: 10px;
            font-size: 14px;
            color: #f8f9fa;
        }

        .custom-footer .footer-about .logo {
            border-radius: 50%;
        }

        .custom-footer .footer-top {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 30px;
            margin-bottom: 30px;
        }

        .custom-footer .copyright {
            font-size: 14px;
            color: #aaa;
        }

        .custom-footer .credits {
            font-size: 13px;
            color: #888;
        }

        .custom-footer .credits a {
            color: #ffc107;
        }

        .custom-footer .credits a:hover {
            color: #fff;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-icon {
            color: #fff;
            font-size: 20px;
            transition: color 0.3s, transform 0.3s;
        }

        .social-icon:hover {
            transform: scale(1.2);
        }

        .social-icon.facebook:hover {
            color: #3b5998;
        }

        .social-icon.instagram:hover {
            color: #bc2a8d;
        }

        .social-icon.youtube:hover {
            color: #ff0000;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="assets/img/kota.png" style="width: 50px; height: auto;"
                    alt="Logo" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section Perangkat Kelurahan -->
    <section class="page-section bg-light py-5" id="perangkat-kelurahan">
        <div class="container">
            <div class="text-center mb-4" style="margin-top: 100px;">
                <h2 class="section-heading text-uppercase">Perangkat Kelurahan</h2>
                <p class="text-muted">Profil Perangkat Kelurahan Kampungdalem.</p>
            </div>
            <div class="row">
                <?php
                // Tampilkan data perangkat dari database
                include 'admin/koneksi.php';
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM perangkat";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-lg-4 col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <img class="card-img-top" src="admin/uploads/'.$row['foto'].'" alt="Foto '.$row['nama'].'">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">'.$row['nama'].'</h4>
                                        <p class="card-text">'.$row['jabatan'].'</p>
                                        <p class="card-text">Alamat: '.$row['alamat'].'</p>
                                        <p class="card-text">No HP: <a href="https://wa.me/'.$row['no_hp'].'" target="_blank">'.$row['no_hp'].'</a></p>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    echo "Tidak ada perangkat kelurahan.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer custom-footer">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="d-flex align-items-center">
                        <img src="assets/l1.png" style="width: 50px; height: auto;" alt="Logo" class="logo" />
                        <span class="sitename text-white"> Kampungdalem</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p class="text-white">Jl. Brigjen Katamso No.17, KampungDalem, Kec. Kota, Kota Kediri, Jawa
                            Timur 64129</p>
                        <p class="mt-3 text-white"><strong>Telepon:</strong> <span>0354-696997</span></p>
                        <p class="text-white"><strong>Email:</strong> <span>Kampungdalem@gmail.com</span></p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container copyright text-center mt-4">
            <p class="text-white">© <span>Copyright</span> <strong class="px-1 sitename">Kampungdalem</strong> <span>All
                    Rights Reserved</span></p>
            <div class="credits text-white">
                Designed by <a href="https://www.instagram.com/kknt24.kampungdalem2025/">KKN-T UNP PGRI Kediri Kel
                    Kampungdalem 2025</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
