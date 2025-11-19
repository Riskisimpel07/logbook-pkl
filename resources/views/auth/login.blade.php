<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            transition: background 2s ease;
        }
        .login-card {
            background: rgba(255,255,255,0.97);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            max-width: 370px;
            width: 100%;
            padding: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-image {
            width: 100%;
            height: 140px;
            background: url('/storage/berkas/gambar2.jpeg') no-repeat center center;
            background-size: cover;
            border-radius: 18px 18px 0 0;
        }
        .login-form {
            width: 100%;
            padding: 24px 18px 18px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
        }
        .logo img {
            height: 44px;
            margin-bottom: 8px;
        }
        .login-form h2 {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 2px;
        }
        .login-form p {
            color: #666;
            margin-bottom: 18px;
            font-size: 13px;
        }
        .login-form input {
            margin-bottom: 12px;
            padding: 9px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        .login-form button {
            padding: 9px;
            font-size: 15px;
            color: #fff;
            background-color: #2563eb;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .login-form button:hover {
            background-color: #1e40af;
        }
        .form-check {
            width: 100%;
            margin-bottom: 10px;
        }
        @media (max-width: 480px) {
            .login-card {
                max-width: 98vw;
                border-radius: 10px;
            }
            .login-image {
                height: 90px;
                border-radius: 10px 10px 0 0;
            }
            .logo img {
                height: 32px;
            }
            .login-form {
                padding: 14px 6px 10px 6px;
            }
            .login-form h2 {
                font-size: 15px;
            }
            .login-form p {
                font-size: 11px;
            }
            .login-form input, .login-form button {
                font-size: 13px;
                padding: 7px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-image"></div>
        <div class="login-form">
            <div class="logo">
                <img src="/storage/berkas/lambang_kota_cirebon.png" alt="Logo Kota Cirebon">
            </div>
            <h2>E-Logbook</h2>
            <p>Logbook PKL Pemerintah Kota Cirebon</p>
            @if($errors->any())
            <div class="alert alert-danger" style="width:100%;">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}" style="width:100%;">
                @csrf
                <input type="text" name="nim_nis" placeholder="NIM/NIS" value="{{ old('nim_nis') }}" required autofocus>
                <input type="password" name="password" placeholder="Password" required>
                <div class="form-check mb-2" style="display: inline-flex; align-items: center; gap: 4px; width: auto;">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember" style="margin:0; width:16px; height:16px;">
                    <label class="form-check-label" for="remember" style="margin:0; font-size:14px; white-space:nowrap;">Ingat Saya</label>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
