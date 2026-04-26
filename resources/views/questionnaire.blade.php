<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner Riset Skripsi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            min-height: 100vh;
            padding: 20px;
            color: #2c3e50;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #7f8c8d;
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .question-group {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #f0f0f0;
        }

        .question-group:last-of-type {
            border-bottom: none;
            padding-bottom: 0;
        }

        .question-text {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .options-yes-no {
            display: flex;
            gap: 15px;
        }

        .option-label {
            flex: 1;
            position: relative;
        }

        .option-label input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .option-box {
            display: block;
            text-align: center;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-weight: 500;
            color: #7f8c8d;
            cursor: pointer;
            transition: all 0.2s;
        }

        .option-label input:checked + .option-box {
            border-color: #81c784;
            background: #f1f8f4;
            color: #2e7d32;
        }

        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 8px;
        }

        .rating-stars input {
            display: none;
        }

        .rating-stars label {
            cursor: pointer;
            color: #e0e0e0;
            font-size: 30px;
            transition: color 0.2s;
        }

        .rating-stars label:hover,
        .rating-stars label:hover ~ label,
        .rating-stars input:checked ~ label {
            color: #ffc107;
        }

        .consent-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 12px;
            margin: 30px 0;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .consent-box input[type="checkbox"] {
            margin-top: 4px;
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #81c784;
        }

        .consent-text {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        .submit-btn {
            width: 100%;
            background: #81c784;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .submit-btn:hover {
            background: #66bb6a;
        }

        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #7f8c8d;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #2c3e50;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali
        </a>

        <h1>Kuisioner Riset</h1>
        <p class="subtitle">Bantu validasi hasil ini agar riset skripsi saya makin akurat:</p>

        <form action="{{ route('questionnaire.submit', ['prediction' => $prediction->id]) }}" method="POST" id="questionnaireForm">
            @csrf
            
            <div class="question-group">
                <div class="question-text">1. Apakah proses upload/ambil foto wajah berjalan lancar?</div>
                <div class="options-yes-no">
                    <label class="option-label">
                        <input type="radio" name="q1" value="iya" required>
                        <span class="option-box">Iya</span>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="q1" value="tidak" required>
                        <span class="option-box">Tidak</span>
                    </label>
                </div>
            </div>

            <div class="question-group">
                <div class="question-text">2. Seberapa puas Anda dengan kecepatan website ini?</div>
                <div class="rating-stars">
                    <input type="radio" id="star5" name="q2" value="5" required />
                    <label for="star5" title="5 stars">★</label>
                    <input type="radio" id="star4" name="q2" value="4" />
                    <label for="star4" title="4 stars">★</label>
                    <input type="radio" id="star3" name="q2" value="3" />
                    <label for="star3" title="3 stars">★</label>
                    <input type="radio" id="star2" name="q2" value="2" />
                    <label for="star2" title="2 stars">★</label>
                    <input type="radio" id="star1" name="q2" value="1" />
                    <label for="star1" title="1 star">★</label>
                </div>
            </div>

            <div class="question-group">
                <div class="question-text">3. Apakah jenis kulit yang terdeteksi sesuai dengan kondisi yang Anda rasakan selama ini?</div>
                <div class="options-yes-no">
                    <label class="option-label">
                        <input type="radio" name="q3" value="iya" required onchange="toggleExpectedSkin(false)">
                        <span class="option-box">Iya</span>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="q3" value="tidak" required onchange="toggleExpectedSkin(true)">
                        <span class="option-box">Tidak</span>
                    </label>
                </div>
                
                <div id="expectedSkinContainer" style="display: none; margin-top: 15px;">
                    <div class="question-text" style="font-size: 14px;">Lalu, apa tipe kulit kamu yang sebenarnya?</div>
                    <input type="text" name="expected_skin" id="expectedSkinInput" placeholder="Contoh: Berminyak, Kering, dll" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; outline: none; transition: border-color 0.2s;">
                </div>
            </div>

            <div class="question-group">
                <div class="question-text">4. Apakah Anda pernah menggunakan salah satu produk skincare yang direkomendasikan?</div>
                <div class="options-yes-no">
                    <label class="option-label">
                        <input type="radio" name="q4" value="iya" required>
                        <span class="option-box">Iya</span>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="q4" value="tidak" required>
                        <span class="option-box">Tidak</span>
                    </label>
                </div>
            </div>

            <div class="question-group">
                <div class="question-text">5. Apakah informasi kandungan produk (ingredient) dalam rekomendasi mudah dipahami?</div>
                <div class="options-yes-no">
                    <label class="option-label">
                        <input type="radio" name="q5" value="iya" required>
                        <span class="option-box">Iya</span>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="q5" value="tidak" required>
                        <span class="option-box">Tidak</span>
                    </label>
                </div>
            </div>

            <div class="question-group">
                <div class="question-text">6. Apakah Anda merasa terbantu dalam memilih produk baru setelah melihat hasil website ini?</div>
                <div class="options-yes-no">
                    <label class="option-label">
                        <input type="radio" name="q6" value="iya" required>
                        <span class="option-box">Iya</span>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="q6" value="tidak" required>
                        <span class="option-box">Tidak</span>
                    </label>
                </div>
            </div>

            <div class="question-group">
                <div class="question-text">7. Jika ada tombol "Beli", apakah Anda akan mengkliknya?</div>
                <div class="options-yes-no">
                    <label class="option-label">
                        <input type="radio" name="q7" value="iya" required>
                        <span class="option-box">Iya</span>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="q7" value="tidak" required>
                        <span class="option-box">Tidak</span>
                    </label>
                </div>
            </div>

            <div class="consent-box">
                <input type="checkbox" id="consent" name="consent" required>
                <label for="consent" class="consent-text">
                    Saya bersedia data anonim ini digunakan untuk riset kampus.
                </label>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">Kirim Jawaban</button>
        </form>
    </div>
    <script>
        function toggleExpectedSkin(show) {
            const container = document.getElementById('expectedSkinContainer');
            const input = document.getElementById('expectedSkinInput');
            if (show) {
                container.style.display = 'block';
                input.required = true;
            } else {
                container.style.display = 'none';
                input.required = false;
                input.value = ''; // Kosongkan data jika jawabannya iya
            }
        }
        
        // Add focus effect for input
        document.getElementById('expectedSkinInput').addEventListener('focus', function() {
            this.style.borderColor = '#81c784';
        });
        document.getElementById('expectedSkinInput').addEventListener('blur', function() {
            this.style.borderColor = '#e0e0e0';
        });
    </script>
</body>
</html>
