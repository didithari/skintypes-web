<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Sabun Wajah</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated background blobs */
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            z-index: 0;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 400px;
            height: 400px;
            background: #059669;
            top: -100px;
            left: -100px;
        }
        body::after {
            width: 350px;
            height: 350px;
            background: #7c3aed;
            bottom: -80px;
            right: -80px;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -20px) scale(1.05); }
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 520px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255,255,255,0.05);
            position: relative;
            z-index: 1;
        }

        /* ── Left Branding Panel ── */
        .branding-panel {
            flex: 1;
            background: linear-gradient(160deg, #059669 0%, #047857 40%, #065f46 100%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            position: relative;
            overflow: hidden;
        }

        .branding-panel::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }
        .branding-panel::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            bottom: -40px;
            left: -60px;
        }

        .branding-icon {
            width: 56px;
            height: 56px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 24px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .branding-panel h1 {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .branding-panel h1 span {
            display: block;
            font-size: 15px;
            font-weight: 500;
            opacity: 0.8;
            margin-top: 4px;
        }

        .branding-desc {
            color: rgba(255,255,255,0.75);
            font-size: 14px;
            line-height: 1.7;
            position: relative;
            z-index: 1;
            margin-bottom: 32px;
        }

        .branding-features {
            list-style: none;
            position: relative;
            z-index: 1;
        }
        .branding-features li {
            color: rgba(255,255,255,0.85);
            font-size: 13px;
            font-weight: 500;
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .branding-features li .feat-icon {
            width: 28px;
            height: 28px;
            background: rgba(255,255,255,0.12);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        /* ── Right Form Panel ── */
        .form-panel {
            flex: 1;
            background: #fff;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-panel .form-header {
            margin-bottom: 32px;
        }

        .form-panel .form-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .form-panel .form-header p {
            font-size: 14px;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 600;
            font-size: 13px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            background: #f9fafb;
        }

        .form-group input:focus {
            outline: none;
            border-color: #059669;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
            font-weight: 500;
        }

        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 4px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: #6b7280;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #059669;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 440px;
            }
            .branding-panel {
                padding: 32px 28px;
            }
            .branding-panel h1 {
                font-size: 22px;
            }
            .branding-desc {
                margin-bottom: 20px;
            }
            .branding-features {
                display: none;
            }
            .form-panel {
                padding: 32px 28px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        {{-- Left Branding --}}
        <div class="branding-panel">
            <div class="branding-icon">🧴</div>
            <h1>
                SPK Sabun Wajah
                <span>Sistem Pendukung Keputusan</span>
            </h1>
            <p class="branding-desc">
                Rekomendasi sabun wajah terbaik berdasarkan jenis kulit Anda menggunakan metode Simple Additive Weighting (SAW) dan klasifikasi CNN.
            </p>
            <ul class="branding-features">
                <li>
                    <span class="feat-icon">📸</span>
                    Deteksi jenis kulit otomatis
                </li>
                <li>
                    <span class="feat-icon">📊</span>
                    Perangkingan metode SAW
                </li>
                <li>
                    <span class="feat-icon">🧴</span>
                    Rekomendasi produk personal
                </li>
            </ul>
        </div>

        {{-- Right Form --}}
        <div class="form-panel">
            <div class="form-header">
                <h2>Masuk ke Dashboard</h2>
                <p>Silakan masuk menggunakan akun admin Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.handle') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@example.com"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <div class="back-link">
                <a href="{{ route('home') }}">← Kembali ke Home</a>
            </div>
        </div>
    </div>
</body>
</html>
