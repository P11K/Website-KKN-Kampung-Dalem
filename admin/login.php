<?php
session_start();
require 'koneksi.php';

$user = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['pass']) ? $_POST['pass'] : '';

if (!empty($user) && !empty($password)) {
    // Mencegah SQL Injection
    $user = mysqli_real_escape_string($conn, $user);
    $password = mysqli_real_escape_string($conn, $password);

    // Ambil data user berdasarkan username
    $query_sql = "SELECT * FROM admin WHERE username='$user'";
    $result = mysqli_query($conn, $query_sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['pass']; // Password yang sudah di-hash di database

        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Simpan session
            $_SESSION['admin'] = $user;
            $_SESSION['login'] = true;

            header("Location: index.php");
            exit();
        } else {
            echo "<script>
                    alert('Password salah. Silakan coba lagi.');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Username tidak ditemukan. Silakan coba lagi.');
                window.location.href = 'login.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #ddd;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 14px;
        }
        .input-group input::placeholder {
            color: #ccc;
        }
        .input-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
        }
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #764ba2;
        }
        .icon {
            margin-bottom: 20px;
            font-size: 40px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h2>Login Admin</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="pass" placeholder="Masukkan password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
