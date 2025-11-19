<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Logbook</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('/storage/berkas/gambar1.jpg') no-repeat center center fixed;
            background-size: cover;
            animation: backgroundChange 10s infinite;
        }

        @keyframes backgroundChange {
            0% { background-image: url('/storage/berkas/gambar1.jpg'); }
            25% { background-image: url('/storage/berkas/gambar2.jpg'); }
            50% { background-image: url('/storage/berkas/gambar3.jpg'); }
            75% { background-image: url('/storage/berkas/gambar4.jpg'); }
            100% { background-image: url('/storage/berkas/gambar1.jpg'); }
        }

        .login-container {
            display: flex;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .login-image {
            flex: 1;
            background: url('/storage/berkas/gambar1.jpg') no-repeat center center;
            background-size: cover;
        }

        .login-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-form input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form">
            <h1>Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="nim_nis" placeholder="NIM/NIS" required>
                <input type="password" name="password" placeholder="Password" required>
                <label>
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
                <button type="submit">Login</button>
            </form>
            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                Default Login:<br>
                Admin: admin / admin123<br>
                Mahasiswa: MHS001 / password<br>
                Pembimbing: PBM001 / password
            </p>
        </div>
    </div>
</body>
</html>
