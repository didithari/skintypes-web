<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SkinAI - Camera Scan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .camera-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .camera-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            background: #000;
            overflow: hidden;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .camera-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            pointer-events: none;
        }

        .face-frame {
            position: relative;
            width: 320px;
            height: 400px;
        }

        /* Face outline - oval shape */
        .face-oval {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid rgba(50, 196, 126, 0.6);
            border-radius: 50% 50% 45% 45%;
            top: 0;
            left: 0;
        }

        /* Inner glow */
        .face-oval::before {
            content: '';
            position: absolute;
            inset: -10px;
            border: 2px solid rgba(50, 196, 126, 0.3);
            border-radius: 50% 50% 45% 45%;
            animation: pulse 2s infinite;
        }

        /* Checkpoints for alignment */
        .alignment-point {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #32C47E;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.8);
        }

        .eye-left {
            top: 25%;
            left: 20%;
        }

        .eye-right {
            top: 25%;
            right: 20%;
        }

        .nose {
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
        }

        .mouth-left {
            bottom: 20%;
            left: 25%;
        }

        .mouth-right {
            bottom: 20%;
            right: 25%;
        }

        /* Guides */
        .face-guides {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .horizontal-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(50, 196, 126, 0.4) 10%, rgba(50, 196, 126, 0.4) 90%, transparent 100%);
            left: 0;
        }

        .line-top {
            top: 20%;
        }

        .line-middle {
            top: 50%;
        }

        .line-bottom {
            bottom: 20%;
        }

        .vertical-line {
            position: absolute;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent 0%, rgba(50, 196, 126, 0.4) 10%, rgba(50, 196, 126, 0.4) 90%, transparent 100%);
            top: 0;
            left: 50%;
            transform: translateX(-1px);
        }

        /* Corner markers */
        .corner-marker {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 3px solid rgba(50, 196, 126, 0.8);
        }

        .top-left {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
            border-radius: 10px 0 0 0;
        }

        .top-right {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
            border-radius: 0 10px 0 0;
        }

        .bottom-left {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 10px;
        }

        .bottom-right {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
            border-radius: 0 0 10px 0;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.6;
            }
        }

        /* Top Control Bar */
        .controls-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 20;
            background: linear-gradient(180deg, rgba(0,0,0,0.5) 0%, transparent 100%);
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: white;
            transform: scale(1.05);
        }

        .info-text {
            color: white;
            font-weight: 600;
            text-align: center;
            font-size: 1.1rem;
        }

        .torch-btn {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.3rem;
            transition: all 0.3s;
        }

        .torch-btn:hover {
            background: white;
            transform: scale(1.05);
        }

        .torch-btn.active {
            background: #FFD700;
        }

        /* Bottom Control Bar */
        .controls-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px 20px 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            z-index: 20;
            background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.5) 100%);
        }

        .shutter-btn {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #32C47E;
            border: 5px solid white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            transition: all 0.3s;
            box-shadow: 0 0 0 0 rgba(50, 196, 126, 0.7);
        }

        .shutter-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 20px rgba(50, 196, 126, 0.2);
        }

        .shutter-btn:active {
            transform: scale(0.95);
        }

        .countdown {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 20px rgba(0,0,0,0.8);
            z-index: 30;
            display: none;
        }

        .countdown.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Status messages */
        .status-message {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 25;
            font-size: 0.95rem;
            text-align: center;
            display: none;
        }

        .status-message.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translate(-50%, -10px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%);
            }
        }

        /* Permission denied message */
        .permission-denied {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 100;
            color: white;
            text-align: center;
            padding: 20px;
            display: none;
        }

        .permission-denied.show {
            display: flex;
        }

        .permission-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .permission-denied h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .permission-denied p {
            color: #ccc;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .retry-btn {
            background: #32C47E;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .retry-btn:hover {
            background: #28a66d;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .back-btn,
            .torch-btn {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .info-text {
                font-size: 1rem;
            }

            .controls-bottom {
                padding: 25px 20px 35px;
                gap: 15px;
            }

            .shutter-btn {
                width: 75px;
                height: 75px;
                font-size: 1.8rem;
            }
        }

        @media (max-width: 768px) {
            .controls-top {
                padding: 15px;
            }

            .back-btn,
            .torch-btn {
                width: 42px;
                height: 42px;
                font-size: 1.1rem;
            }

            .info-text {
                font-size: 0.9rem;
                font-weight: 500;
            }

            .controls-bottom {
                padding: 20px 15px 30px;
                gap: 12px;
            }

            .shutter-btn {
                width: 70px;
                height: 70px;
                font-size: 1.3rem;
            }

            .face-frame {
                width: 250px;
                height: 300px;
            }

            .alignment-point {
                width: 6px;
                height: 6px;
            }

            .corner-marker {
                width: 25px;
                height: 25px;
                border-width: 2px;
            }

            .status-message {
                font-size: 0.85rem;
                padding: 10px 20px;
            }

            .countdown {
                font-size: 3rem;
            }
        }

        @media (max-width: 480px) {
            .controls-top {
                padding: 12px;
                gap: 10px;
            }

            .back-btn,
            .torch-btn {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                min-height: 44px;
                min-width: 44px;
            }

            .info-text {
                font-size: 0.8rem;
                font-weight: 600;
            }

            .controls-bottom {
                padding: 15px 12px 25px;
                gap: 8px;
            }

            .shutter-btn {
                width: 65px;
                height: 65px;
                font-size: 1.2rem;
                border-width: 4px;
                min-height: 44px;
            }

            .face-frame {
                width: 200px;
                height: 250px;
            }

            .face-oval {
                border-width: 2px;
            }

            .alignment-point {
                width: 5px;
                height: 5px;
                border-width: 1px;
            }

            .corner-marker {
                width: 20px;
                height: 20px;
                border-width: 2px;
            }

            .horizontal-line,
            .vertical-line {
                height: 1px;
                width: 1px;
            }

            .status-message {
                top: 25%;
                font-size: 0.8rem;
                padding: 8px 16px;
            }

            .countdown {
                font-size: 2.5rem;
            }

            .permission-denied {
                padding: 15px;
            }

            .permission-icon {
                font-size: 3rem;
                margin-bottom: 15px;
            }

            .permission-denied h2 {
                font-size: 1.3rem;
                margin-bottom: 8px;
            }

            .permission-denied p {
                font-size: 0.85rem;
                margin-bottom: 15px;
            }

            .retry-btn {
                padding: 10px 25px;
                font-size: 0.9rem;
                min-height: 44px;
            }
        }
    </style>
</head>
<body>
    <div class="camera-container">
        <div class="camera-wrapper">
            <video id="cameraVideo" autoplay playsinline></video>

            <div class="camera-overlay">
                <!-- Face Frame -->
                <div class="face-frame">
                    <div class="face-oval"></div>
                    
                    <!-- Alignment Points -->
                    <div class="alignment-point eye-left"></div>
                    <div class="alignment-point eye-right"></div>
                    <div class="alignment-point nose"></div>
                    <div class="alignment-point mouth-left"></div>
                    <div class="alignment-point mouth-right"></div>

                    <!-- Guide Lines -->
                    <div class="face-guides">
                        <div class="horizontal-line line-top"></div>
                        <div class="horizontal-line line-middle"></div>
                        <div class="horizontal-line line-bottom"></div>
                        <div class="vertical-line"></div>
                    </div>

                    <!-- Corner Markers -->
                    <div class="corner-marker top-left"></div>
                    <div class="corner-marker top-right"></div>
                    <div class="corner-marker bottom-left"></div>
                    <div class="corner-marker bottom-right"></div>
                </div>
            </div>

            <!-- Top Control Bar -->
            <div class="controls-top">
                <button class="back-btn" onclick="goBack()" title="Kembali">
                    ← 
                </button>
                <div class="info-text">Posisikan Wajah di Frame</div>
                <button class="torch-btn" id="torchBtn" onclick="toggleTorch()" title="Lampu">
                    💡
                </button>
            </div>

            <!-- Bottom Control Bar -->
            <div class="controls-bottom">
                <button class="shutter-btn" id="shutterBtn" onclick="capturePhoto()">
                    📷
                </button>
            </div>

            <!-- Status Message -->
            <div class="status-message" id="statusMessage"></div>

            <!-- Countdown -->
            <div class="countdown" id="countdown"></div>

            <!-- Permission Denied -->
            <div class="permission-denied" id="permissionDenied">
                <div class="permission-icon">📷</div>
                <h2>Akses Kamera Ditolak</h2>
                <p>Silakan izinkan akses kamera di pengaturan browser Anda untuk melanjutkan</p>
                <button class="retry-btn" onclick="retryCamera()">Coba Lagi</button>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('cameraVideo');
        const shutterBtn = document.getElementById('shutterBtn');
        const torchBtn = document.getElementById('torchBtn');
        const statusMessage = document.getElementById('statusMessage');
        const countdown = document.getElementById('countdown');
        const permissionDenied = document.getElementById('permissionDenied');
        let stream = null;
        let torchActive = false;

        // Initialize camera
        async function initCamera() {
            try {
                const constraints = {
                    video: {
                        facingMode: 'user',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    },
                    audio: false
                };

                stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
                
                // Wait for video to load
                video.onloadedmetadata = () => {
                    console.log('Camera ready');
                };

            } catch (error) {
                console.error('Camera error:', error);
                permissionDenied.classList.add('show');
                shutterBtn.disabled = true;
            }
        }

        // Capture Photo
        function capturePhoto() {
            if (!stream) {
                showStatus('Kamera sedang dimuat...');
                return;
            }

            shutterBtn.disabled = true;
            
            // Show countdown
            let count = 3;
            countdown.classList.add('show');
            countdown.textContent = count;

            const countInterval = setInterval(() => {
                count--;
                if (count > 0) {
                    countdown.textContent = count;
                } else {
                    clearInterval(countInterval);
                    countdown.classList.remove('show');
                    
                    // Take screenshot
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0);

                    // Convert to blob and send to server
                    canvas.toBlob((blob) => {
                        sendPhotoToServer(blob);
                    }, 'image/jpeg', 0.9);

                    shutterBtn.disabled = false;
                }
            }, 1000);
        }

        // Send photo to server
        function sendPhotoToServer(blob) {
            showStatus('⏳ Menganalisis wajah Anda...');
            
            const formData = new FormData();
            formData.append('photo', blob, 'photo.jpg');

            fetch('/camera/predict', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showStatus('✓ Analisis selesai!');
                    console.log('Result:', data);
                    setTimeout(() => {
                        // Redirect to result page
                        if (data.redirectUrl) {
                            window.location.href = data.redirectUrl;
                        } else {
                            alert('Tipe Kulit: ' + data.skinType + '\nPrediksi: ' + data.prediction);
                        }
                    }, 1500);
                } else {
                    showStatus('❌ ' + (data.message || 'Gagal menganalisis'));
                    shutterBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showStatus('❌ Gagal menganalisis. Coba lagi.');
                shutterBtn.disabled = false;
            });
        }

        // Toggle Torch/Flash
        async function toggleTorch() {
            try {
                const track = stream.getVideoTracks()[0];
                const capabilities = track.getCapabilities();
                
                if (!capabilities.torch) {
                    showStatus('⚠ Lampu tidak tersedia di device ini');
                    return;
                }

                torchActive = !torchActive;
                await track.applyConstraints({
                    advanced: [{ torch: torchActive }]
                });

                torchBtn.classList.toggle('active', torchActive);
                showStatus(torchActive ? '💡 Lampu Hidup' : '💡 Lampu Mati');
            } catch (error) {
                console.error('Torch error:', error);
            }
        }

        // Show status message
        function showStatus(message) {
            statusMessage.textContent = message;
            statusMessage.classList.add('show');
            
            if (!message.includes('Analisis') && !message.includes('selesai')) {
                setTimeout(() => {
                    statusMessage.classList.remove('show');
                }, 2500);
            }
        }

        // Go back
        function goBack() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            window.history.back();
        }

        // Retry camera
        function retryCamera() {
            permissionDenied.classList.remove('show');
            initCamera();
        }

        // Initialize on load
        window.addEventListener('load', () => {
            initCamera();
        });

        // Stop camera when leaving page
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>
