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
            min-height: 100vh;
            height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .camera-container {
            flex: 1;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            background: #000;
        }

        .camera-wrapper {
            position: relative;
            width: min(100vw, calc(100dvh * 9 / 16));
            height: min(100dvh, calc(100vw * 16 / 9));
            max-width: 100vw;
            max-height: 100dvh;
            background: #000;
            overflow: hidden;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transform: scaleX(-1);
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
            width: min(78%, 320px);
            aspect-ratio: 4 / 5;
            height: auto;
        }

        .face-frame.aligned .face-target-zone {
            border-color: rgba(50, 196, 126, 0.95);
            box-shadow: 0 0 0 6px rgba(50, 196, 126, 0.16);
        }

        .face-frame.aligned .target-line {
            background: rgba(50, 196, 126, 0.9);
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

        .face-target-zone {
            position: absolute;
            left: 12%;
            right: 12%;
            top: 11%;
            bottom: 9%;
            border: 2px dashed rgba(255, 255, 255, 0.75);
            border-radius: 48% 48% 46% 46%;
            pointer-events: none;
            transition: all 0.2s ease;
        }


        .target-line {
            position: absolute;
            left: 15%;
            right: 15%;
            height: 2px;
            background: rgba(255, 255, 255, 0.65);
            pointer-events: none;
            transition: background 0.2s ease;
        }

        .target-line.eye-line {
            top: 34%;
        }

        .target-line.chin-line {
            top: 78%;
        }

        .target-label {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.92);
            font-size: clamp(0.62rem, 1.5vw, 0.72rem);
            font-weight: 600;
            letter-spacing: 0.02em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            pointer-events: none;
            white-space: nowrap;
        }

        .target-label.top {
            top: 27.5%;
        }

        .target-label.bottom {
            top: 81.5%;
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
            font-size: clamp(0.9rem, 2.2vw, 1.1rem);
            flex: 1;
        }

        /* Bottom Control Bar */
        .controls-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 0 20px max(14px, env(safe-area-inset-bottom, 0px));
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            z-index: 20;
        }

        .shutter-btn {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background: #32C47E;
            border: 4px solid white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            transition: all 0.3s;
            box-shadow: 0 0 0 0 rgba(50, 196, 126, 0.7);
        }

        .shutter-icon {
            width: 30px;
            height: 30px;
            display: block;
        }

        .camera-wrapper .back-btn {
            width: 44px !important;
            height: 44px !important;
            font-size: 1.15rem !important;
        }

        .camera-wrapper .face-frame {
            width: min(78%, 320px) !important;
            height: auto !important;
            aspect-ratio: 4 / 5;
        }

        .camera-wrapper .shutter-btn {
            width: 74px !important;
            height: 74px !important;
            border-width: 4px !important;
        }

        .camera-wrapper .shutter-icon {
            width: 30px !important;
            height: 30px !important;
        }

        .shutter-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 20px rgba(50, 196, 126, 0.2);
        }

        .shutter-btn:active {
            transform: scale(0.95);
        }

        .shutter-btn:disabled {
            background: #6b7280;
            cursor: not-allowed;
            opacity: 0.7;
            box-shadow: none;
            transform: none;
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
            .back-btn {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .info-text {
                font-size: 1rem;
            }

            .controls-bottom {
                padding: 0 20px max(12px, env(safe-area-inset-bottom, 0px));
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

            .back-btn {
                width: 42px;
                height: 42px;
                font-size: 1.1rem;
            }

            .info-text {
                font-size: 0.9rem;
                font-weight: 500;
            }

            .controls-bottom {
                padding: 0 15px max(10px, env(safe-area-inset-bottom, 0px));
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

            .back-btn {
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
                padding: 0 12px max(8px, env(safe-area-inset-bottom, 0px));
                gap: 8px;
            }

            .shutter-btn {
                width: 65px;
                height: 65px;
                border-width: 4px;
                min-height: 44px;
            }

            .shutter-icon {
                width: 26px;
                height: 26px;
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
                    <div class="face-target-zone"></div>
                    <div class="target-line eye-line"></div>
                    <div class="target-line chin-line"></div>
                    <div class="target-label top">Posisi alis digaris ini</div>
                    <div class="target-label bottom">Pastikan hidung diatas garis ini</div>
                    
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
            </div>

            <!-- Bottom Control Bar -->
            <div class="controls-bottom">
                <button class="shutter-btn" id="shutterBtn" onclick="capturePhoto()">
                    <svg class="shutter-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M4 8.5C4 7.11929 5.11929 6 6.5 6H8.13597C8.54473 6 8.92957 5.80005 9.16688 5.46476L9.83312 4.53524C10.0704 4.19995 10.4553 4 10.864 4H13.136C13.5447 4 13.9296 4.19995 14.1669 4.53524L14.8331 5.46476C15.0704 5.80005 15.4553 6 15.864 6H17.5C18.8807 6 20 7.11929 20 8.5V16.5C20 17.8807 18.8807 19 17.5 19H6.5C5.11929 19 4 17.8807 4 16.5V8.5Z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12.5" r="3.3" stroke="white" stroke-width="1.8"/>
                    </svg>
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
        const statusMessage = document.getElementById('statusMessage');
        const countdown = document.getElementById('countdown');
        const permissionDenied = document.getElementById('permissionDenied');
        const infoText = document.querySelector('.info-text');
        const faceFrame = document.querySelector('.face-frame');
        let stream = null;
        let faceDetector = null;
        let faceDetectionInterval = null;
        let heuristicDetectionInterval = null;
        let mediaPipeDetector = null;
        let mediaPipeLoopHandle = null;
        let mediaPipeBusy = false;
        let mediaPipeLoaded = false;
        let mediaPipeWatchdog = null;
        let mediaPipeStartedAt = 0;
        let mediaPipeLastResultAt = 0;
        let isFaceAligned = false;
        let lastAlignedAt = 0;
        const mediaPipeInputCanvas = document.createElement('canvas');
        const mediaPipeInputCtx = mediaPipeInputCanvas.getContext('2d', { willReadFrequently: false });
        const isMobileDevice = /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
        const MEDIA_PIPE_FACE_BASE = "{{ asset('vendor/mediapipe/face_detection') }}";
        const MEDIA_PIPE_FACE_SCRIPT_URL = "{{ asset('vendor/mediapipe/face_detection/face_detection.js') }}";
        const MEDIA_PIPE_CAMERA_UTILS_URL = "{{ asset('vendor/mediapipe/camera_utils/camera_utils.js') }}";

        // Initialize camera
        async function initCamera() {
            try {
                shutterBtn.disabled = true;
                stopFaceDetection();

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
                    initFaceDetection();
                };

            } catch (error) {
                console.error('Camera error:', error);
                permissionDenied.classList.add('show');
                shutterBtn.disabled = true;
            }
        }

        function stopFaceDetection() {
            if (faceDetectionInterval) {
                clearInterval(faceDetectionInterval);
                faceDetectionInterval = null;
            }

            if (heuristicDetectionInterval) {
                clearInterval(heuristicDetectionInterval);
                heuristicDetectionInterval = null;
            }

            if (mediaPipeLoopHandle) {
                cancelAnimationFrame(mediaPipeLoopHandle);
                mediaPipeLoopHandle = null;
            }

            if (mediaPipeWatchdog) {
                clearInterval(mediaPipeWatchdog);
                mediaPipeWatchdog = null;
            }

            mediaPipeBusy = false;
        }

        function loadScript(src) {
            return new Promise((resolve, reject) => {
                const existing = document.querySelector(`script[src="${src}"]`);
                if (existing) {
                    if (existing.dataset.loaded === 'true') {
                        resolve();
                    } else {
                        existing.addEventListener('load', () => resolve(), { once: true });
                        existing.addEventListener('error', () => reject(new Error(`Gagal memuat ${src}`)), { once: true });
                    }
                    return;
                }

                const script = document.createElement('script');
                script.src = src;
                script.async = true;
                script.onload = () => {
                    script.dataset.loaded = 'true';
                    resolve();
                };
                script.onerror = () => reject(new Error(`Gagal memuat ${src}`));
                document.head.appendChild(script);
            });
        }

        function evaluateFaceBox(box, detectorType = 'generic') {
            // Cukup cek: ada wajah & posisi vertikal sekitar tengah video
            const faceCenterY = (box.y + box.height / 2) / video.videoHeight;
            const faceCenterX = (box.x + box.width / 2) / video.videoWidth;

            // Wajah di sekitar tengah vertikal (15%–85% tinggi video)
            // dan sekitar tengah horizontal (10%–90% lebar video)
            const inVerticalCenter = faceCenterY >= 0.15 && faceCenterY <= 0.85;
            const inHorizontalRange = faceCenterX >= 0.10 && faceCenterX <= 0.90;

            // Ukuran wajah minimal (lebih dari 3% lebar video)
            const faceWidthRatio = box.width / video.videoWidth;
            const faceBigEnough = faceWidthRatio >= 0.03;

            if (inVerticalCenter && inHorizontalRange && faceBigEnough) {
                updateCaptureState(true, 'Wajah terdeteksi ✓ Siap difoto');
            } else {
                updateCaptureState(false, 'Arahkan wajah ke area tengah frame');
            }
        }

        function updateCaptureState(aligned, message) {
            const now = Date.now();
            faceFrame.classList.toggle('aligned', aligned);

            if (aligned) {
                lastAlignedAt = now;
                isFaceAligned = true;
                shutterBtn.disabled = false;
                infoText.textContent = message;
                return;
            }

            const graceMs = 900;
            if (now - lastAlignedAt <= graceMs) {
                isFaceAligned = true;
                shutterBtn.disabled = false;
                infoText.textContent = 'Tahan posisi wajah...';
                faceFrame.classList.add('aligned');
            } else {
                isFaceAligned = false;
                shutterBtn.disabled = true;
                infoText.textContent = message;
                faceFrame.classList.remove('aligned');
            }
        }

        function initFaceDetection() {
            if ('FaceDetector' in window) {
                // Native FaceDetector tersedia (Chrome/Edge)
                initNativeFaceDetection();
            } else {
                // Coba MediaPipe sebagai fallback (mobile & desktop)
                initMediaPipeFaceDetection();
            }
        }

        function initNativeFaceDetection() {
            if (!('FaceDetector' in window)) {
                // Tidak ada native, coba MediaPipe
                initMediaPipeFaceDetection();
                return;
            }

            faceDetector = new FaceDetector({
                fastMode: true,
                maxDetectedFaces: 1
            });

            if (faceDetectionInterval) {
                clearInterval(faceDetectionInterval);
            }

            faceDetectionInterval = setInterval(detectFaceAndValidateFrame, 350);
        }


        async function initMediaPipeFaceDetection() {
            try {
                updateCaptureState(false, 'Memuat deteksi wajah...');
                showStatus('Memulai engine MediaPipe lokal...');

                if (!mediaPipeLoaded) {
                    await loadScript(MEDIA_PIPE_FACE_SCRIPT_URL);
                    await loadScript(MEDIA_PIPE_CAMERA_UTILS_URL);
                    mediaPipeLoaded = true;
                }

                if (!window.FaceDetection) {
                    throw new Error('FaceDetection global tidak tersedia setelah script dimuat');
                }

                mediaPipeDetector = new FaceDetection({
                    locateFile: (file) => `${MEDIA_PIPE_FACE_BASE}/${file}`
                });

                mediaPipeDetector.setOptions({
                    model: 'short',
                    minDetectionConfidence: isMobileDevice ? 0.2 : 0.3
                });

                mediaPipeLastResultAt = Date.now();
                mediaPipeStartedAt = Date.now();

                mediaPipeDetector.onResults((results) => {
                    mediaPipeLastResultAt = Date.now();
                    const detections = results.detections || [];

                    if (detections.length !== 1) {
                        updateCaptureState(false, detections.length === 0
                            ? 'Arahkan wajah ke dalam frame'
                            : 'Pastikan hanya 1 wajah di frame');
                        return;
                    }

                    const det = detections[0];
                    // MediaPipe bisa pakai format berbeda tergantung versi
                    const rb = det.locationData?.relativeBoundingBox
                        || det.boundingBox
                        || det;

                    const xMin = rb.xMin ?? rb.originX ?? rb.x ?? 0;
                    const yMin = rb.yMin ?? rb.originY ?? rb.y ?? 0;
                    const w = rb.width ?? 0;
                    const h = rb.height ?? 0;

                    if (w === 0 || h === 0) {
                        updateCaptureState(false, 'Wajah belum terbaca, coba dekatkan');
                        return;
                    }

                    const box = {
                        x: xMin * video.videoWidth,
                        y: yMin * video.videoHeight,
                        width: w * video.videoWidth,
                        height: h * video.videoHeight,
                    };

                    evaluateFaceBox(box, 'mediapipe');
                });

                const runLoop = async () => {
                    if (!mediaPipeDetector || !video.videoWidth || !video.videoHeight) {
                        mediaPipeLoopHandle = requestAnimationFrame(runLoop);
                        return;
                    }

                    if (!mediaPipeBusy) {
                        mediaPipeBusy = true;
                        try {
                            const targetWidth = isMobileDevice ? 420 : 520;
                            const ratio = video.videoHeight / video.videoWidth;
                            mediaPipeInputCanvas.width = targetWidth;
                            mediaPipeInputCanvas.height = Math.max(180, Math.round(targetWidth * ratio));
                            mediaPipeInputCtx.drawImage(video, 0, 0, mediaPipeInputCanvas.width, mediaPipeInputCanvas.height);

                            await mediaPipeDetector.send({ image: mediaPipeInputCanvas });
                        } catch (error) {
                            console.error('MediaPipe detection error:', error);
                            updateCaptureState(false, 'Deteksi wajah bermasalah, cek pencahayaan');
                        } finally {
                            mediaPipeBusy = false;
                        }
                    }

                    mediaPipeLoopHandle = requestAnimationFrame(runLoop);
                };

                runLoop();

                mediaPipeWatchdog = setInterval(() => {
                    const now = Date.now();
                    const startupTimeout = isMobileDevice ? 14000 : 6000;
                    const silenceTimeout = isMobileDevice ? 7000 : 3500;

                    const startupExpired = now - mediaPipeStartedAt > startupTimeout && mediaPipeLastResultAt === mediaPipeStartedAt;
                    const stalled = now - mediaPipeLastResultAt > silenceTimeout;

                    if (startupExpired || stalled) {
                        console.error('MediaPipe watchdog timeout: tidak ada hasil inferensi yang stabil.');
                        stopFaceDetection();

                        if ('FaceDetector' in window) {
                            initNativeFaceDetection();
                            showStatus('⚠ MediaPipe timeout, pakai engine native');
                        } else {
                            updateCaptureState(false, 'Deteksi wajah gagal. Coba refresh halaman');
                            showStatus('⚠ Deteksi wajah tidak tersedia, coba refresh');
                        }
                    }
                }, 2000);
            } catch (error) {
                console.error('Fallback face detection error:', error);
                if ('FaceDetector' in window) {
                    initNativeFaceDetection();
                    showStatus('⚠ MediaPipe gagal, pakai engine native');
                } else {
                    updateCaptureState(false, 'Deteksi wajah gagal dimuat. Coba refresh');
                    showStatus('⚠ Deteksi wajah gagal, coba refresh halaman');
                }
            }
        }

        async function detectFaceAndValidateFrame() {
            if (!faceDetector || !video.videoWidth || !video.videoHeight) {
                return;
            }

            try {
                const faces = await faceDetector.detect(video);

                if (faces.length !== 1) {
                    updateCaptureState(false, 'Pastikan hanya 1 wajah di frame');
                    return;
                }

                const face = faces[0];
                const box = face.boundingBox;
                evaluateFaceBox(box);
            } catch (error) {
                console.error('Face detection error:', error);
                updateCaptureState(false, 'Deteksi wajah bermasalah, coba atur posisi kamera');
            }
        }

        // Capture Photo
        function capturePhoto() {
            if (!stream) {
                showStatus('Kamera sedang dimuat...');
                return;
            }

            if (!isFaceAligned) {
                showStatus('⚠ Pastikan wajah terdeteksi di dalam frame');
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
                    
                    // Take screenshot with center-crop 1:1
                    const canvas = document.createElement('canvas');
                    const sourceWidth = video.videoWidth;
                    const sourceHeight = video.videoHeight;
                    const cropSize = Math.min(sourceWidth, sourceHeight);
                    const sourceX = (sourceWidth - cropSize) / 2;
                    const sourceY = (sourceHeight - cropSize) / 2;

                    canvas.width = cropSize;
                    canvas.height = cropSize;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(
                        video,
                        sourceX,
                        sourceY,
                        cropSize,
                        cropSize,
                        0,
                        0,
                        cropSize,
                        cropSize
                    );

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
            stopFaceDetection();

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
            stopFaceDetection();

            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>
