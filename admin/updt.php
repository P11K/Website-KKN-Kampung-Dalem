<?php
include '../admin/koneksi.php';

// Logika Tambah Berita
if (isset($_POST['submit_berita'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tanggal = $_POST['tanggal'];
    $thumbnail = $_FILES['thumbnail']['name'];
    $target_dir = "../assets/img/";
    $target_file = $target_dir . basename($thumbnail);

    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO berita (judul, tanggal, gambar) VALUES ('$judul', '$tanggal', '$thumbnail')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Berita berhasil ditambahkan.'); window.location.href='';</script>";
        } else {
            echo "Gagal menambahkan berita.";
        }
    } else {
        echo "Gagal mengupload thumbnail.";
    }
}

// Logika Hapus Berita
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Hapus data terkait di tabel isian
    $query_isian = "DELETE FROM isian WHERE id_berita = $id";
    mysqli_query($conn, $query_isian);

    // Ambil nama gambar sebelum menghapus berita
    $query_berita = "SELECT gambar FROM berita WHERE id_berita = $id";
    $result = mysqli_query($conn, $query_berita);
    $row = mysqli_fetch_assoc($result);
    $gambar = $row['gambar'];

    // Hapus berita dari database
    $query_berita = "DELETE FROM berita WHERE id_berita = $id";
    if (mysqli_query($conn, $query_berita)) {
        // Hapus gambar jika bukan gambar default
        if ($gambar && file_exists("../assets/img/$gambar")) {
            unlink("../assets/img/$gambar");
        }
        
        // Redirect untuk menghindari looping
        echo "<script>alert('Berita dan isian terkait berhasil dihapus.'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "Gagal menghapus berita.";
    }
}


// Ambil data berita untuk ditampilkan
$query = "SELECT * FROM berita ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
$berita_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $berita_data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff; /* Latar belakang putih */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        /* Form Container */
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-in-out;
            margin-bottom: 20px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-container h2 {
            margin-bottom: 25px;
            font-size: 26px;
            color: #444;
            text-align: center;
            font-weight: 600;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #555;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="file"] {
            width: calc(100% - 24px); /* Adjust width to account for padding */
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="date"]:focus,
        .form-container input[type="file"]:focus {
            border-color: #6a11cb;
            outline: none;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-container button:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }

        /* Daftar Berita */
        .berita-list {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-top: 20px;
        }

        .berita-list h3 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }

        .berita-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .berita-item:last-child {
            border-bottom: none;
        }

        .berita-item button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .berita-item button:hover {
            background: #c82333;
        }

        /* Extra Options */
        .extra-options {
            margin-top: 20px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .extra-options a {
            text-decoration: none;
        }

        .extra-options button {
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

        .extra-options button:hover {
            background: #218838;
        }

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
            background: rgb(207, 43, 43);
        }
    </style>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="form-container">
        <h2>Tambah Berita</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="judul">Judul:</label>
            <input type="text" name="judul" id="judul" required>

            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" required>

            <label for="thumbnail">Gambar Thumbnail:</label>
            <input type="file" name="thumbnail" id="thumbnail" required>

            <button type="submit" name="submit_berita">Tambahkan Berita</button>
        </form>
    </div>

    <!-- Daftar Berita -->
    <div class="berita-list">
        <h3>Daftar Berita</h3>
        <?php
        if (!empty($berita_data)) {
            foreach ($berita_data as $berita) {
                echo "<div class='berita-item'>
                        <span>{$berita['judul']} - {$berita['tanggal']}</span>
                        <button onclick=\"confirmDelete({$berita['id_berita']})\">Hapus</button>
                      </div>";
            }
        } else {
            echo "<p>Tidak ada berita.</p>";
        }
        ?>
    </div>

    <!-- Tombol Tambah Isian di bawah container -->
    <div class="extra-options">
        <a href="isian.php"><button><i class="fas fa-plus"></i> Tambah Isian</button></a>
    </div>
    <div class="back-options">
        <a href="index.php">
            <button><i class="fas fa-arrow-left"></i> Kembali</button>
        </a>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus berita ini?")) {
                window.location.href = `?hapus=${id}`;
            }
        }
    </script>
</body>
</html>