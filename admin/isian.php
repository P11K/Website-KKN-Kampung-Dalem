<?php
include '../admin/koneksi.php';

$berita_result = mysqli_query($conn, "SELECT id_berita, judul FROM berita");
if (isset($_POST['submit_isian'])) {
    include '../admin/koneksi.php'; // Pastikan koneksi tersedia

    // Ambil data dari form
    $id_berita = mysqli_real_escape_string($conn, $_POST['id_berita']);
    $judul_isian = mysqli_real_escape_string($conn, $_POST['judul_isian']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Periksa apakah file gambar diunggah
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "../assets/img/";
        $target_file = $target_dir . basename($gambar);

        // Coba unggah gambar
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Query INSERT ke database
            $sql = "INSERT INTO isian (id_berita, judul_isian, deskripsi, gambar) 
                    VALUES ('$id_berita', '$judul_isian', '$deskripsi', '$gambar')";
        } else {
            echo "<script>alert('Gagal mengupload gambar.');</script>";
            exit;
        }
    } else {
        // Jika tidak ada gambar, gunakan gambar default
        $sql = "INSERT INTO isian (id_berita, judul_isian, deskripsi, gambar) 
                VALUES ('$id_berita', '$judul_isian', '$deskripsi', 'default.jpg')";
    }

    // Jalankan query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Isian berhasil ditambahkan!'); window.location.href='';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan isian: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Isian</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-in-out;
            box-sizing: border-box;
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

        .form-container select,
        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="file"] {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .form-container select:focus,
        .form-container input[type="text"]:focus,
        .form-container textarea:focus,
        .form-container input[type="file"]:focus {
            border-color: #6a11cb;
            outline: none;
        }

        .form-container textarea {
            resize: vertical;
            height: 100px;
        }

        .form-container button {
            width: calc(100% - 24px);
            padding: 12px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .form-container button:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
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
            background:rgb(207, 43, 43);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h2>Tambah Isian</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="id_berita">Pilih Berita:</label>
            <select name="id_berita" id="id_berita" required>
                <option value="">-- Pilih Berita --</option>
                <?php while ($row = mysqli_fetch_assoc($berita_result)) { ?>
                    <option value="<?= $row['id_berita']; ?>"><?= $row['judul']; ?></option>
                <?php } ?>
            </select>

            <label for="judul_isian">Judul Isian:</label>
            <input type="text" name="judul_isian" id="judul_isian" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" id="deskripsi" required></textarea>

            <label for="gambar">Gambar:</label>
            <input type="file" name="gambar" id="gambar" required>

            <button type="submit" name="submit_isian">Tambahkan Isian</button>
        </form>
    </div>
    <div class="back-options">
    <a href="updt.php">
        <button><i class="fas fa-arrow-left"></i> Kembali</button>
    </a>
    </div>
</body>
</html>
