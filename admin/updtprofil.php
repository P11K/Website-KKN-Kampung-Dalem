<?php
// Koneksi ke database
include '../admin/koneksi.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk membersihkan input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Menangani update data Ekonomi Masyarakat
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kategori'])) {
    $kategori = clean_input($_POST['kategori']);
    $jumlah = clean_input($_POST['jumlah']);

    $stmt = $conn->prepare("UPDATE ekonomi_masyarakat SET jumlah=? WHERE kategori=?");
    $stmt->bind_param("is", $jumlah, $kategori);
    
    if ($stmt->execute()) {
        echo "Data Ekonomi Masyarakat berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Mengambil data kategori untuk dropdown
$query_kategori = "SELECT DISTINCT kategori FROM ekonomi_masyarakat";
$result_kategori = $conn->query($query_kategori);

// Menangani update data Profil Pejabat
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pejabat'])) {
    $id_pejabat = clean_input($_POST['id_pejabat']);
    $nama = clean_input($_POST['nama']);
    $jabatan = clean_input($_POST['jabatan']);
    $deskripsi = clean_input($_POST['deskripsi']);
    
    // Menangani upload foto pejabat
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $upload_dir = "uploads/pejabat/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $foto_path = $upload_dir . basename($foto);
        move_uploaded_file($foto_temp, $foto_path);
    } else {
        // Jika tidak ada file foto yang diupload, tetap gunakan foto sebelumnya
        $foto = clean_input($_POST['foto_lama']); // Mempertahankan foto lama jika tidak ada perubahan
    }

    // Update data pejabat
    $stmt = $conn->prepare("UPDATE pejabat SET nama=?, jabatan=?, foto=?, deskripsi=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama, $jabatan, $foto, $deskripsi, $id_pejabat);
    
    if ($stmt->execute()) {
        echo "Profil Pejabat berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Ekonomi Masyarakat</title>
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <!-- Tombol untuk Menampilkan Form -->
        
        <button class="btn btn-primary mb-3" onclick="document.getElementById('form-ekonomi').style.display = 'block';">Update Ekonomi Masyarakat</button>
        <a href="get_pejabat_data.php"><button class="btn btn-primary mb-3">Update profil Pejabat</button></a>
        <!-- Form Input Ekonomi Masyarakat -->
        <section id="form-ekonomi" class="form-section" style="display:none;">
            <h2>Input Data Ekonomi Masyarakat</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-control" id="kategori" name="kategori" required onchange="getJumlahKeluarga(this.value)">
                        <option value="">Pilih Kategori</option>
                        <?php while($row = $result_kategori->fetch_assoc()) { ?>
                            <option value="<?php echo $row['kategori']; ?>"><?php echo $row['kategori']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Keluarga</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </form>
        </section>

        
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getJumlahKeluarga(kategori) {
            if (kategori) {
                fetch('get_jumlah_keluarga.php?kategori=' + kategori)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('jumlah').value = data.jumlah;
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('jumlah').value = '';
            }
        }
    </script>
</body>
</html>