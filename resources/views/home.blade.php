<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkinAI - Kenali Jenis Kulit Wajahmu</title>
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
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation */
        nav {
            background: #fff;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav .container {
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

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #333;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #A8C5B8;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #f5e6e8 0%, #e8d5d8 100%);
            padding: 80px 0;
            position: relative;
        }

        .hero .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero-content .highlight {
            color: #A8C5B8;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn {
            padding: 15px 35px;
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

        .btn-primary {
            background: #A8C5B8;
            color: white;
        }

        .btn-primary:hover {
            background: #8fb3a1;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(168, 197, 184, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: #333;
            border: 2px solid #ddd;
        }

        .btn-secondary:hover {
            border-color: #A8C5B8;
            color: #A8C5B8;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 0.95rem;
        }

        .hero-badge svg {
            width: 20px;
            height: 20px;
        }

        .hero-image {
            position: relative;
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        .hero-image img {
            width: 100%;
            border-radius: 20px;
            display: block;
        }

        .analysis-badge {
            position: absolute;
            top: 60px;
            left: 40px;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .analysis-icon {
            width: 30px;
            height: 30px;
            background: #A8C5B8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .combination-badge {
            position: absolute;
            bottom: 60px;
            right: 40px;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            font-weight: 600;
        }

        /* Steps Section */
        .steps {
            padding: 80px 0;
            background: white;
            text-align: center;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-badge {
            display: inline-block;
            color: #A8C5B8;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            margin-top: 3rem;
        }

        .step-card {
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: #e8f4f0;
            color: #A8C5B8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
        }

        .step-icon {
            width: 80px;
            height: 80px;
            background: #f5f5f5;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .step-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .step-card p {
            color: #666;
            line-height: 1.8;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: linear-gradient(135deg, #f5e6e8 0%, #e8d5d8 100%);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #e8f4f0;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.8rem;
        }

        .feature-icon.pink {
            background: #fce8ec;
        }

        .feature-content h3 {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
        }

        .feature-content p {
            color: #666;
            line-height: 1.8;
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            background: #C5D8C8;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .cta p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 2.5rem;
        }

        .cta .btn {
            font-size: 1.1rem;
            padding: 18px 40px;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 4rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #555;
            font-size: 1rem;
        }

        /* Footer */
        footer {
            background: #1a1a2e;
            color: #fff;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .footer-brand .logo-icon {
            background: #A8C5B8;
        }

        .footer-about p {
            color: #aaa;
            line-height: 1.8;
        }

        .footer-section h4 {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #A8C5B8;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: #2a2a3e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s;
        }

        .social-link:hover {
            background: #A8C5B8;
        }

        .footer-bottom {
            border-top: 1px solid #2a2a3e;
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #aaa;
            font-size: 0.9rem;
        }

        .footer-bottom-links {
            display: flex;
            gap: 2rem;
        }

        .footer-bottom-links a {
            color: #aaa;
            text-decoration: none;
        }

        .footer-bottom-links a:hover {
            color: #A8C5B8;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .container {
                padding: 0 15px;
            }

            .hero {
                padding: 60px 0;
            }

            .hero .container {
                gap: 40px;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-image {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 15px 0;
            }

            .logo {
                font-size: 1.2rem;
            }

            .logo-icon {
                width: 35px;
                height: 35px;
            }

            nav ul {
                display: none;
            }

            .hero {
                padding: 40px 0;
            }

            .hero .container {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .hero-content h1 {
                font-size: 1.75rem;
                line-height: 1.3;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn {
                padding: 12px 30px;
                font-size: 0.95rem;
                width: 100%;
            }

            .hero-image {
                padding: 20px;
            }

            .analysis-badge,
            .combination-badge {
                padding: 10px 15px;
                font-size: 0.85rem;
            }

            .section-title {
                margin-bottom: 30px;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .section-title p {
                font-size: 0.95rem;
            }

            .steps {
                padding: 50px 0;
            }

            .steps-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .step-card h3 {
                font-size: 1.1rem;
            }

            .step-card p {
                font-size: 0.9rem;
            }

            .features {
                padding: 50px 0;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .feature-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .feature-content h3 {
                font-size: 1.1rem;
            }

            .cta {
                padding: 50px 0;
            }

            .cta h2 {
                font-size: 1.8rem;
            }

            .cta p {
                font-size: 0.95rem;
            }

            .stats {
                flex-direction: column;
                gap: 1.5rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .stat-label {
                font-size: 0.9rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 12px;
            }

            nav {
                padding: 12px 0;
            }

            .logo {
                font-size: 1rem;
            }

            .logo-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .hero {
                padding: 30px 0;
            }

            .hero-content h1 {
                font-size: 1.5rem;
                margin-bottom: 0.8rem;
            }

            .hero-content p {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 10px;
                margin-bottom: 1.5rem;
            }

            .btn {
                padding: 12px 25px;
                font-size: 0.9rem;
                min-height: 44px;
            }

            .hero-badge {
                font-size: 0.85rem;
            }

            .hero-image {
                padding: 15px;
            }

            .analysis-badge {
                top: 40px;
                left: 20px;
            }

            .combination-badge {
                bottom: 40px;
                right: 20px;
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .section-title h2 {
                font-size: 1.5rem;
            }

            .section-title p {
                font-size: 0.85rem;
            }

            .steps {
                padding: 35px 0;
            }

            .steps-grid {
                gap: 15px;
            }

            .step-number {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
                margin-bottom: 1rem;
            }

            .step-icon {
                width: 60px;
                height: 60px;
                font-size: 1.8rem;
            }

            .step-card h3 {
                font-size: 1rem;
                margin-bottom: 0.6rem;
            }

            .step-card p {
                font-size: 0.85rem;
            }

            .features {
                padding: 35px 0;
            }

            .features-grid {
                gap: 1.2rem;
            }

            .feature-card {
                padding: 1.2rem;
                gap: 1rem;
            }

            .feature-icon {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
                min-width: 45px;
            }

            .feature-content h3 {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }

            .feature-content p {
                font-size: 0.85rem;
            }

            .cta {
                padding: 35px 0;
            }

            .cta h2 {
                font-size: 1.5rem;
            }

            .cta p {
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
            }

            .cta .btn {
                min-height: 44px;
            }

            .stats {
                gap: 1.2rem;
            }

            .stat-value {
                font-size: 1.8rem;
            }

            footer {
                padding: 40px 0 20px;
            }

            .footer-about p {
                font-size: 0.85rem;
            }

            .footer-section h4 {
                font-size: 1rem;
                margin-bottom: 1rem;
            }

            .footer-section ul li {
                margin-bottom: 0.6rem;
            }

            .footer-section a {
                font-size: 0.85rem;
            }

            .social-links {
                gap: 0.8rem;
            }

            .social-link {
                width: 36px;
                height: 36px;
            }

            .footer-bottom {
                font-size: 0.8rem;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container">
            <div class="logo">
                <div class="logo-icon">S</div>
                <span>SkinAI</span>
            </div>
            <ul>
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#cara-kerja">Cara Kerja</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <h1>Kenali Jenis<br><span class="highlight">Kulit Wajahmu</span></h1>
                <p>Analisis wajahmu dengan teknologi AI canggih untuk mendapatkan rekomendasi produk skincare yang tepat dan personal sesuai jenis kulitmu.</p>
                <div class="hero-buttons">
                    <a href="{{ route('scanner') }}" class="btn btn-primary">
                        Coba Sekarang ➜
                    </a>
                    <a href="#" class="btn btn-secondary">
                        ▶ Lihat Demo
                    </a>
                </div>
                <div class="hero-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span>100% Aman & Private</span>
                </div>
            </div>
            <div class="hero-image">
                <div class="analysis-badge">
                    <div class="analysis-icon">
                        <svg viewBox="0 0 24 24" fill="white" width="16" height="16">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div>
                        <strong>Kesalahan</strong>
                        <div style="font-size: 0.85rem; color: #666;">Memindai</div>
                    </div>
                </div>
                <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=500&h=600&fit=crop" alt="Woman touching face">
                <div class="combination-badge">
                    Combination
                </div>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="steps" id="cara-kerja">
        <div class="container">
            <div class="section-title">
                <div class="section-badge">✦ Cara Kerja</div>
                <h2>Mudah & Cepat dalam 3 Langkah</h2>
                <p>Dapatkan analisis kulit wajah yang akurat dan rekomendasi produk yang tepat hanya dalam hitungan detik</p>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">📸</div>
                    <h3>Foto Wajah</h3>
                    <p>Ambil foto wajahmu dengan pencahayaan yang baik atau upload foto yang sudah ada</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">🤖</div>
                    <h3>Analisis AI</h3>
                    <p>Teknologi AI kami akan menganalisis kulit wajah dengan akurasi dan kecepatan maksimal</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">✨</div>
                    <h3>Rekomendasi Skincare</h3>
                    <p>Dapatkan rekomendasi produk skincare yang tepat dan personal untuk kulit kamu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="tentang">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Memilih SkinAI?</h2>
                <p>Teknologi terdepan untuk analisis kulit yang akurat dan rekomendasi yang personal</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <div class="feature-content">
                        <h3>AI Teknologi Terkini</h3>
                        <p>Menggunakan machine learning dan deep learning yang presisi dan akurat</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon pink">🔒</div>
                    <div class="feature-content">
                        <h3>Privasi Terjamin</h3>
                        <p>Data dan foto wajahmu aman, tidak disimpan dan tidak digunakan untuk database</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <div class="feature-content">
                        <h3>Hasil Instan</h3>
                        <p>Dapatkan hasil analisis dan rekomendasi hanya dalam hitungan detik</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon pink">💝</div>
                    <div class="feature-content">
                        <h3>Rekomendasi Personal</h3>
                        <p>Produk skincare yang direkomendasikan sesuai dengan kondisi kulit kamu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Siap Menemukan Skincare yang Tepat?</h2>
            <p>Mulai perjalanan skincare-mu sekarang dan dapatkan kulit sehat yang kamu impikan</p>
            <a href="{{ route('scanner') }}" class="btn btn-primary">Coba Sekarang Gratis ➜</a>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-value">50K+</div>
                    <div class="stat-label">Pengguna</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">98%</div>
                    <div class="stat-label">Akurasi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">4.9/5</div>
                    <div class="stat-label">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-brand">
                        <div class="logo-icon">S</div>
                        <span>SkinAI</span>
                    </div>
                    <p>Solusi cerdas untuk menemukan skincare yang tepat dan personal menggunakan AI.</p>
                </div>
                <div class="footer-section">
                    <h4>Produk</h4>
                    <ul>
                        <li><a href="#">Analisis Kulit</a></li>
                        <li><a href="#">Rekomendasi</a></li>
                        <li><a href="#">Konsultasi</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Perusahaan</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Kontak</a></li>
                        <li><a href="#">Partnership</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M9 12a1 1 0 11-2 0 1 1 0 012 0zm1 0a1 1 0 11 2 0 1 1 0 01-2 0zm5 0a1 1 0 11 2 0 1 1 0 01-2 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div>© 2025 SkinAI. All rights reserved.</div>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
