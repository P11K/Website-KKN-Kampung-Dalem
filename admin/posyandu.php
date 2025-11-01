<?php
include '../admin/koneksi.php';
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$table = isset($_GET['table']) ? $_GET['table'] : 'posyandu_tomat';
if (!in_array($table, ['posyandu_tomat', 'posyandu_kesemek', 'posyandu_srigading', 'posyandu_anggrek'])) {
    die("Tabel tidak valid");
}

if (isset($_POST['action'])) {
    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $foto = $target_dir . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    }
    
    if ($_POST['action'] == 'add') {
        $stmt = $conn->prepare("INSERT INTO $table (foto, nama, alamat, jabatan, no_hp) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $foto, $_POST['nama'], $_POST['alamat'], $_POST['jabatan'], $_POST['no_hp']);
        $stmt->execute();
    } elseif ($_POST['action'] == 'edit') {
        if (empty($foto)) {
            $foto = $_POST['existing_foto'];
        }
        $stmt = $conn->prepare("UPDATE $table SET foto=?, nama=?, alamat=?, jabatan=?, no_hp=? WHERE id=?");
        $stmt->bind_param("sssssi", $foto, $_POST['nama'], $_POST['alamat'], $_POST['jabatan'], $_POST['no_hp'], $_POST['id']);
        $stmt->execute();
    } elseif ($_POST['action'] == 'delete') {
        $stmt = $conn->prepare("SELECT foto FROM $table WHERE id=?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $stmt->bind_result($foto);
        $stmt->fetch();
        $stmt->close();
        if (!empty($foto) && file_exists($foto)) {
            unlink($foto);
        }
        
        $stmt = $conn->prepare("DELETE FROM $table WHERE id=?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    }
    header("Location: ?table=$table");
    exit;
}

$result = $conn->query("SELECT * FROM $table");
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Posyandu</title>
</head>
<body>
    <h1>Data <?php echo ucfirst(str_replace('_', ' ', $table)); ?></h1>
    <a href="?table=posyandu_tomat">Tomat</a> |
    <a href="?table=posyandu_kesemek">Kesemek</a> |
    <a href="?table=posyandu_srigading">Srigading</a> |
    <a href="?table=posyandu_anggrek">Anggrek</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jabatan</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="<?php echo $row['foto']; ?>" width="50"></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['jabatan']; ?></td>
            <td><?php echo $row['no_hp']; ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">Hapus</button>
                </form>
                <button onclick="editData(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h2>Tambah / Edit Data</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="action" id="action" value="add">
        <input type="hidden" name="existing_foto" id="existing_foto">
        <label>Foto: <input type="file" name="foto" id="foto"></label><br>
        <label>Nama: <input type="text" name="nama" id="nama"></label><br>
        <label>Alamat: <input type="text" name="alamat" id="alamat"></label><br>
        <label>Jabatan: <input type="text" name="jabatan" id="jabatan"></label><br>
        <label>No HP: <input type="text" name="no_hp" id="no_hp"></label><br>
        <button type="submit">Simpan</button>
    </form>

    <script>
    function editData(data) {
        document.getElementById('id').value = data.id;
        document.getElementById('existing_foto').value = data.foto;
        document.getElementById('nama').value = data.nama;
        document.getElementById('alamat').value = data.alamat;
        document.getElementById('jabatan').value = data.jabatan;
        document.getElementById('no_hp').value = data.no_hp;
        document.getElementById('action').value = 'edit';
    }
    </script>
</body>
</html>
