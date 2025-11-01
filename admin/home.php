<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_test";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
  die("Koneksi terputus");
} else {

}
$username = "";
$nama = "";
$email = "";
$no_hp = "";
$password = "";
$error = "";
$sukses = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = '';
}

if ($op == 'edit') {
  $id = $_GET['id'];
  $sql1 = "select * from user where id = '$id'";
  $q1 = mysqli_query($koneksi, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $username = $r1['username'];
  $nama = $r1['nama'];
  $email = $r1['email'];
  $no_hp = $r1['no_hp'];
  $password = $r1['password'];

  if ($nama == '') {
    $error = "Data tidak ditemukan.";
  }
}

if ($op  == 'delete'){
  $id     = $_GET['id'];
  $sql1   = "delete from user where id = '$id'";
  $q1     = mysqli_query($koneksi, $sql1);

  if ($q1){
    $sukses = "Berhasil menghapus data.";
  } else {
    $error  = "Gagal menghapus data.";
  }
}

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $no_hp = $_POST['no_hp'];
  $password = $_POST['password'];

  if ($username && $nama && $email && $no_hp && $password) {
    if ($op == 'edit') {
      $sql1 = "update user set username = '$username',nama = '$nama', email = '$email',
      no_hp = '$no_hp', password = '$password' where id = '$id'";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil di update.";
      } else {
        $error = "Data gagal di update.";
      }
    } else {
      $sql1 = "insert into user(username, nama, email, no_hp, password)
      values('$username', '$nama', '$email', '$no_hp', '$password')";
      $q1 = mysqli_query($koneksi, $sql1);

      if ($q1) {
        $sukses = "Berhasil menyimpan Data Baru.";
      } else {
        $error = "Gagal menyimpan Data.";
      }
    }
  } else {
    $error = "Silahkan Memasukkan datanya.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    .mx-auto {
      width: 800px
    }

    .card {
      margin-top: 10px;
    }
  </style>
</head>

<body>
<link href='css/Style.css' rel='stylesheet'>
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"></svg>
        <span class="fs-4">Selamat Datang Admin</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="logout.php" class="button" role="button">Log out</a></li>
    </header>
  </div>
  <div class="mx-auto">
    <!-- Untuk mengedit Data -->
    <div class="card">
      <div class="card-header">
        Create / Edit Data
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:3;url=home.php");
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:3;url=home.php");
        }
        ?>
        <!-- Bagian Pengisian Data -->
        <form action="" method="POST">
          <div class="mb-3 row">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">E-mail</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="no_hp" class="col-sm-2 col-form-label">No Hp</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $no_hp ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="password" name="password" value="<?php echo $password ?>">
            </div>
          </div>

          <div class="col-12">
            <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary" />
          </div>
        </form>
      </div>
    </div>

    <!-- Untuk mengeluarkan Data -->
    <div class="card">
      <div class="card-header text-white bg-secondary">
        Data Pegawai
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Username</th>
              <th scope="col">Nama</th>
              <th scope="col">E-mail</th>
              <th scope="col">No Hp</th>
              <th scope="col">Password</th>
              <th scope="col">Aksi</th>
            </tr>
          <tbody>
            <?php
            $sql2 = "select * from user order by id desc";
            $q2 = mysqli_query($koneksi, $sql2);
            $urut = 1;
            while ($r2 = mysqli_fetch_array($q2)) {
              $id = $r2['id'];
              $username = $r2['username'];
              $nama = $r2['nama'];
              $email = $r2['email'];
              $no_hp = $r2['no_hp'];
              $password = $r2['password'];

              ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                  <?php echo $username ?>
                </td>
                <td scope="row">
                  <?php echo $nama ?>
                </td>
                <td scope="row">
                  <?php echo $email ?>
                </td>
                <td scope="row">
                  <?php echo $no_hp ?>
                </td>
                <td scope="row">
                  <?php echo $password ?>
                </td>
                <td scope="row">
                  <a href="home.php?op=edit&id=<?php echo $id ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="home.php?op=delete&id=<?php echo $id ?>" 
                  onclick="return confirm('Anda ingin Delete data ini ?')"><button type="button"
                      class="btn btn-danger">Delete</button></a>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
  </div>
</body>

</html>