<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #764ba2, #667eea);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            background: #764ba2;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #6b46c1;
        }

        .text-center {
            text-align: center;
            margin-top: 15px;
        }

        .text-center a {
            text-decoration: none;
            color: #764ba2;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>Daftar</h2>

    <form method="POST" action="/daftar">
        @csrf

        <div class="input-group">
            <label>Nama</label>
            <input type="text" name="name" placeholder="Masukkan nama" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <div class="input-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn">Daftar</button>
    </form>

    <div class="text-center">
        <p>Sudah punya akun? <a href="/login">Login</a></p>
    </div>
</div>

</body>
</html>