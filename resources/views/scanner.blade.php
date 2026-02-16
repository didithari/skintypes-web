<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkinAI Scanner - Analisis Kulit</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: #A8C5B8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .header-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .header-nav a {
            text-decoration: none;
            color: #333;
            transition: color 0.3s;
        }

        .header-nav a:hover {
            color: #A8C5B8;
        }

        /* Main Section */
        .scanner-section {
            padding: 60px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .section-title h1 .highlight {
            color: #32C47E;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Content Layout */
        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        /* Instructions Grid */
        .instructions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .instruction-card {
            background: #f9f9f9;
            padding: 35px;
            border-radius: 15px;
            transition: all 0.3s;
        }

        .instruction-card:hover {
            background: #f0f0f0;
            transform: translateY(-5px);
        }

        .instruction-icon {
            width: 60px;
            height: 60px;
            background: #32C47E;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: white;
        }

        .instruction-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: #333;
        }

        .instruction-card p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.8;
        }

        /* Phone Mockup */
        .phone-mockup {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .phone {
            width: 300px;
            height: 600px;
            background: #1a1a2e;
            border-radius: 40px;
            padding: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
            overflow: hidden;
            border: 8px solid #0f0f1e;
        }

        .phone::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 25px;
            background: #0f0f1e;
            border-radius: 0 0 20px 20px;
            z-index: 10;
        }

        .phone-screen {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #87ceeb 0%, #e0f6ff 100%);
            border-radius: 35px;
            display: flex;
            flex-direction: column;
            padding: 10px;
            position: relative;
            overflow: hidden;
        }

        .phone-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            font-size: 0.75rem;
            color: #333;
            background: rgba(255,255,255,0.9);
            border-radius: 25px;
            margin-bottom: 8px;
        }

        .phone-app-name {
            text-align: center;
            padding: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .phone-camera {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .phone-camera::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 3px solid rgba(255,255,255,0.3);
        }

        .camera-feed {
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="100" cy="100" r="60" fill="none" stroke="%23fff" stroke-width="2" opacity="0.5"/><circle cx="100" cy="100" r="40" fill="none" stroke="%23fff" stroke-width="2" opacity="0.7"/><circle cx="100" cy="100" r="20" fill="none" stroke="%23fff" stroke-width="2"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .camera-person {
            width: 120px;
            height: 140px;
            background: rgba(100, 150, 200, 0.4);
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding-bottom: 15px;
        }

        .camera-head {
            width: 30px;
            height: 30px;
            background: rgba(150, 180, 220, 0.6);
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .camera-face {
            width: 50px;
            height: 35px;
            background: rgba(150, 180, 220, 0.8);
            border-radius: 50%;
            opacity: 0.8;
        }

        .phone-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            padding: 10px;
        }

        .control-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .shutter-btn {
            width: 60px;
            height: 60px;
            background: #32C47E;
            color: white;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(50, 196, 126, 0.4);
        }

        .shutter-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(50, 196, 126, 0.6);
        }

        .help-btn {
            width: 40px;
            height: 40px;
            background: transparent;
            color: #666;
            border: 2px solid #ddd;
            border-radius: 50%;
            font-size: 1rem;
        }

        /* Check Mark */
        .check-mark {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: #32C47E;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            z-index: 5;
            box-shadow: 0 4px 12px rgba(50, 196, 126, 0.4);
        }

        /* CTA Button */
        .cta-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 40px;
            align-items: center;
        }

        .btn-primary {
            background: #32C47E;
            color: white;
            padding: 16px 40px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            background: #28a66d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(50, 196, 126, 0.3);
        }

        .cta-note {
            color: #999;
            font-size: 0.9rem;
        }

        .cta-note strong {
            color: #333;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-wrapper {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .instructions-grid {
                grid-template-columns: 1fr;
            }

            .section-title h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .section-title h1 {
                font-size: 1.5rem;
            }

            .instructions-grid {
                grid-template-columns: 1fr;
            }

            .phone {
                width: 250px;
                height: 500px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <a href="/" class="logo">
                <div class="logo-icon">S</div>
                <span>SkinAI</span>
            </a>
            <div class="header-nav">
                <a href="/">← Kembali ke Beranda</a>
            </div>
        </div>
    </header>

    <!-- Scanner Section -->
    <section class="scanner-section">
        <div class="container">
            <!-- Section Title -->
            <div class="section-title">
                <h1>Cara Menggunakan Kamera untuk <span class="highlight">Analisis Kulit</span></h1>
                <p>Ikuti langkah-langkah sederhana untuk mendapatkan analisis kulit yang akurat menggunakan teknologi AI terdepan</p>
            </div>

            <!-- Content -->
            <div class="content-wrapper">
                <!-- Instructions -->
                <div class="instructions-grid">
                    <div class="instruction-card">
                        <div class="instruction-icon">📷</div>
                        <h3>Izinkan Akses Kamera</h3>
                        <p>Berikan izin akses kamera pada browser untuk memulai proses scanning wajah</p>
                    </div>

                    <div class="instruction-card">
                        <div class="instruction-icon">📐</div>
                        <h3>Posisikan Wajah di Frame</h3>
                        <p>Pastikan wajah berada di tengah frame dan teritik jelas seluruhnya</p>
                    </div>

                    <div class="instruction-card">
                        <div class="instruction-icon">💡</div>
                        <h3>Pastikan Pencahayaan Cukup</h3>
                        <p>Gunakan pencahayaan natural atau lampu yang terang untuk hasil optimal</p>
                    </div>

                    <div class="instruction-card">
                        <div class="instruction-icon">📸</div>
                        <h3>Ambil Foto & Tunggu Analisis</h3>
                        <p>Tekan tombol capture dan tunggu AI menganalisis kondisi kulit Anda</p>
                    </div>
                </div>

                <!-- Phone Mockup -->
                <div class="phone-mockup">
                    <div class="check-mark">✓</div>
                    <div class="phone">
                        <div class="phone-screen">
                            <div class="phone-header">
                                <span>9:41</span>
                                <span>📶 📡 🔋</span>
                            </div>
                            <div class="phone-app-name">SkinAI Scanner</div>
                            <div class="phone-camera">
                                <div class="camera-feed">
                                    <div class="camera-person">
                                        <div class="camera-head"></div>
                                        <div class="camera-face"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="phone-controls">
                                <button class="control-btn help-btn">?</button>
                                <button class="control-btn shutter-btn">📷</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="cta-container">
                <a href="{{ route('camera') }}" class="btn-primary">
                    📷 Mulai Scan Wajah
                </a>
                <div class="cta-note">
                    <strong>Gratis</strong> • Hasil Instan • <strong>100% privat</strong>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
