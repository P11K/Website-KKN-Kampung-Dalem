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

// Menangani update data pejabat
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pejabat'])) {
    $id_pejabat = clean_input($_POST['id_pejabat']);
    $nama = clean_input($_POST['nama']);
    $jabatan = clean_input($_POST['jabatan']);
    $deskripsi = clean_input($_POST['deskripsi']);
    $foto = $_FILES['foto']['name'];
    $foto_lama = clean_input($_POST['foto_lama']);
    
    // Menangani upload foto
    if ($foto != "") {
        // Upload foto baru
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    } else {
        // Jika tidak ada foto baru, tetap menggunakan foto lama
        $foto = $foto_lama;
    }
    
    // Update data pejabat
    $stmt = $conn->prepare("UPDATE pejabat SET nama=?, jabatan=?, deskripsi=?, foto=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama, $jabatan, $deskripsi, $foto, $id_pejabat);
    
    if ($stmt->execute()) {
        echo "Data Pejabat berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Mengambil data pejabat untuk dropdown
$query_pejabat = "SELECT id, nama FROM pejabat";
$result_pejabat = $conn->query($query_pejabat);

// Menangani data pejabat yang dipilih untuk form
$pejabat_data = [];
if (isset($_GET['id_pejabat'])) {
    $id_pejabat = $_GET['id_pejabat'];
    $query_pejabat_detail = "SELECT * FROM pejabat WHERE id = ?";
    $stmt = $conn->prepare($query_pejabat_detail);
    $stmt->bind_param("i", $id_pejabat);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $pejabat_data = $result->fetch_assoc();
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
    <title>Update Profil Pejabat</title>
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Update Profil Pejabat</h2>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Dropdown untuk memilih Pejabat -->
            <div class="mb-3">
                <label for="id_pejabat" class="form-label">Pilih Pejabat</label>
                <select class="form-control" id="id_pejabat" name="id_pejabat" required>
                    <option value="">Pilih Pejabat</option>
                    <?php while($row = $result_pejabat->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo isset($pejabat_data['id']) && $pejabat_data['id'] == $row['id'] ? 'selected' : ''; ?>>
                            <?php echo $row['nama']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Input untuk Nama -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($pejabat_data['nama']) ? $pejabat_data['nama'] : ''; ?>" required>
            </div>

            <!-- Input untuk Jabatan -->
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo isset($pejabat_data['jabatan']) ? $pejabat_data['jabatan'] : ''; ?>" required>
            </div>

            <!-- Input untuk Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo isset($pejabat_data['deskripsi']) ? $pejabat_data['deskripsi'] : ''; ?></textarea>
            </div>

            <!-- Input untuk Foto -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <input type="hidden" name="foto_lama" value="<?php echo isset($pejabat_data['foto']) ? $pejabat_data['foto'] : ''; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
