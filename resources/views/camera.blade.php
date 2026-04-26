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

        .shutter-icon {
            width: 34px;
            height: 34px;
            display: block;
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
        let faceStableFrames = 0;
        const heuristicCanvas = document.createElement('canvas');
        const heuristicCtx = heuristicCanvas.getContext('2d', { willReadFrequently: true });
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

        function evaluateFaceBox(box) {
            const videoRect = video.getBoundingClientRect();
            const frameRect = faceFrame.getBoundingClientRect();

            const scale = Math.max(
                videoRect.width / video.videoWidth,
                videoRect.height / video.videoHeight
            );

            const renderedWidth = video.videoWidth * scale;
            const renderedHeight = video.videoHeight * scale;
            const offsetX = videoRect.left + (videoRect.width - renderedWidth) / 2;
            const offsetY = videoRect.top + (videoRect.height - renderedHeight) / 2;

            const centerX = offsetX + (box.x + box.width / 2) * scale;
            const centerY = offsetY + (box.y + box.height / 2) * scale;
            const framePadding = 20;

            const inFrame =
                centerX >= frameRect.left + framePadding &&
                centerX <= frameRect.right - framePadding &&
                centerY >= frameRect.top + framePadding &&
                centerY <= frameRect.bottom - framePadding;

            const faceWidthRatio = box.width / video.videoWidth;
            const faceHeightRatio = box.height / video.videoHeight;
            const minFaceRatio = isMobileDevice ? 0.08 : 0.15;
            const maxFaceWidthRatio = isMobileDevice ? 0.9 : 0.75;
            const maxFaceHeightRatio = isMobileDevice ? 0.95 : 0.85;
            const faceSizeOk = faceWidthRatio >= minFaceRatio && faceWidthRatio <= maxFaceWidthRatio && faceHeightRatio >= minFaceRatio && faceHeightRatio <= maxFaceHeightRatio;

            if (inFrame && faceSizeOk) {
                updateCaptureState(true, 'Wajah terdeteksi, siap difoto');
            } else {
                updateCaptureState(false, 'Posisikan wajah pas di dalam frame');
            }
        }

        function updateCaptureState(aligned, message) {
            isFaceAligned = aligned;
            shutterBtn.disabled = !aligned;
            infoText.textContent = message;
        }

        function initFaceDetection() {
            if (isMobileDevice) {
                if ('FaceDetector' in window) {
                    initNativeFaceDetection();
                } else {
                    initMediaPipeFaceDetection();
                }
            } else {
                initNativeFaceDetection();
            }
        }

        function initNativeFaceDetection() {
            if (!('FaceDetector' in window)) {
                initHeuristicFaceDetection();
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

        function initHeuristicFaceDetection() {
            updateCaptureState(false, 'Memeriksa wajah di frame...');

            if (heuristicDetectionInterval) {
                clearInterval(heuristicDetectionInterval);
            }

            heuristicDetectionInterval = setInterval(() => {
                if (!video.videoWidth || !video.videoHeight) {
                    return;
                }

                const score = getFaceLikelihoodScore();

                if (score >= 0.62) {
                    faceStableFrames++;
                } else {
                    faceStableFrames = 0;
                }

                if (faceStableFrames >= 2) {
                    updateCaptureState(true, 'Wajah terdeteksi (mode lokal), siap difoto');
                } else {
                    updateCaptureState(false, 'Arahkan wajah ke tengah frame, objek lain ditolak');
                }
            }, 350);
        }

        function getFaceLikelihoodScore() {
            const sampleSize = 200;
            heuristicCanvas.width = sampleSize;
            heuristicCanvas.height = sampleSize;

            const srcW = video.videoWidth;
            const srcH = video.videoHeight;
            const crop = Math.min(srcW, srcH) * 0.5;
            const sx = (srcW - crop) / 2;
            const sy = (srcH - crop) / 2;

            heuristicCtx.drawImage(video, sx, sy, crop, crop, 0, 0, sampleSize, sampleSize);

            const imageData = heuristicCtx.getImageData(0, 0, sampleSize, sampleSize);
            const pixels = imageData.data;

            let skinCount = 0;
            let brightCount = 0;
            let centerSkinCount = 0;
            let edgeSkinCount = 0;
            let leftSkinCount = 0;
            let rightSkinCount = 0;
            let eyeLeftDarkCount = 0;
            let eyeRightDarkCount = 0;
            let lumaSum = 0;
            let lumaSqSum = 0;
            const total = sampleSize * sampleSize;

            const cx = sampleSize / 2;
            const cy = sampleSize / 2;
            let centerPixelCount = 0;
            let edgePixelCount = 0;
            let eyeLeftPixelCount = 0;
            let eyeRightPixelCount = 0;

            const eyeTop = Math.floor(sampleSize * 0.25);
            const eyeBottom = Math.floor(sampleSize * 0.5);
            const eyeLeftStart = Math.floor(sampleSize * 0.2);
            const eyeLeftEnd = Math.floor(sampleSize * 0.45);
            const eyeRightStart = Math.floor(sampleSize * 0.55);
            const eyeRightEnd = Math.floor(sampleSize * 0.8);

            for (let yPos = 0; yPos < sampleSize; yPos++) {
                for (let xPos = 0; xPos < sampleSize; xPos++) {
                    const i = (yPos * sampleSize + xPos) * 4;
                    const r = pixels[i];
                    const g = pixels[i + 1];
                    const b = pixels[i + 2];

                    const luma = 0.299 * r + 0.587 * g + 0.114 * b;
                    const cb = 128 - 0.168736 * r - 0.331264 * g + 0.5 * b;
                    const cr = 128 + 0.5 * r - 0.418688 * g - 0.081312 * b;

                    const isSkinByYCbCr = cb >= 77 && cb <= 132 && cr >= 135 && cr <= 177;
                    const isSkinByRgb = r > 72 && g > 38 && b > 24 && Math.max(r, g, b) - Math.min(r, g, b) > 14 && r > g && r > b;
                    const isSkin = isSkinByYCbCr || isSkinByRgb;

                    const nx = (xPos - cx) / cx;
                    const ny = (yPos - cy) / cy;
                    const centerEllipse = (nx * nx) / (0.68 * 0.68) + (ny * ny) / (0.92 * 0.92) <= 1;
                    const edgeRing = Math.abs(nx) > 0.86 || Math.abs(ny) > 0.9;

                    if (isSkin) {
                        skinCount++;

                        if (xPos < cx) {
                            leftSkinCount++;
                        } else {
                            rightSkinCount++;
                        }

                        if (centerEllipse) {
                            centerSkinCount++;
                        }

                        if (edgeRing) {
                            edgeSkinCount++;
                        }
                    }

                    if (centerEllipse) {
                        centerPixelCount++;
                    }

                    if (edgeRing) {
                        edgePixelCount++;
                    }

                    if (luma > 55 && luma < 230) {
                        brightCount++;
                    }

                    if (yPos >= eyeTop && yPos <= eyeBottom && xPos >= eyeLeftStart && xPos <= eyeLeftEnd) {
                        eyeLeftPixelCount++;
                        if (luma < 85) {
                            eyeLeftDarkCount++;
                        }
                    }

                    if (yPos >= eyeTop && yPos <= eyeBottom && xPos >= eyeRightStart && xPos <= eyeRightEnd) {
                        eyeRightPixelCount++;
                        if (luma < 85) {
                            eyeRightDarkCount++;
                        }
                    }

                    lumaSum += luma;
                    lumaSqSum += luma * luma;
                }
            }

            const skinRatio = skinCount / total;
            const exposureRatio = brightCount / total;
            const centerSkinRatio = centerPixelCount > 0 ? centerSkinCount / centerPixelCount : 0;
            const edgeSkinRatio = edgePixelCount > 0 ? edgeSkinCount / edgePixelCount : 0;
            const symmetryDiff = skinCount > 0 ? Math.abs(leftSkinCount - rightSkinCount) / skinCount : 1;
            const eyeLeftDarkRatio = eyeLeftPixelCount > 0 ? eyeLeftDarkCount / eyeLeftPixelCount : 0;
            const eyeRightDarkRatio = eyeRightPixelCount > 0 ? eyeRightDarkCount / eyeRightPixelCount : 0;

            const lumaMean = lumaSum / total;
            const variance = Math.max(0, (lumaSqSum / total) - (lumaMean * lumaMean));
            const lumaStd = Math.sqrt(variance);

            if (exposureRatio < 0.4) {
                return 0;
            }

            if (skinRatio < 0.13 || skinRatio > 0.62) {
                return 0;
            }

            if (centerSkinRatio < 0.18 || edgeSkinRatio > 0.2) {
                return 0;
            }

            if (symmetryDiff > 0.35) {
                return 0;
            }

            if (eyeLeftDarkRatio < 0.04 || eyeLeftDarkRatio > 0.42 || eyeRightDarkRatio < 0.04 || eyeRightDarkRatio > 0.42) {
                return 0;
            }

            if (lumaStd < 20 || lumaStd > 70) {
                return 0;
            }

            const eyeBalance = 1 - Math.min(Math.abs(eyeLeftDarkRatio - eyeRightDarkRatio) / 0.25, 1);
            const symmetryScore = 1 - Math.min(symmetryDiff / 0.35, 1);
            const centerScore = Math.min(centerSkinRatio / 0.35, 1);
            const edgePenalty = Math.min(edgeSkinRatio / 0.2, 1);

            const score = (0.35 * symmetryScore) + (0.35 * centerScore) + (0.2 * eyeBalance) + (0.1 * (1 - edgePenalty));

            return Math.max(0, Math.min(1, score));
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

                if (!window.FaceDetection || !window.FaceDetection.FaceDetection) {
                    throw new Error('FaceDetection global tidak tersedia setelah script dimuat');
                }

                mediaPipeDetector = new FaceDetection.FaceDetection({
                    locateFile: (file) => `${MEDIA_PIPE_FACE_BASE}/${file}`
                });

                mediaPipeDetector.setOptions({
                    model: 'short',
                    minDetectionConfidence: isMobileDevice ? 0.3 : 0.35
                });

                mediaPipeLastResultAt = Date.now();
                mediaPipeStartedAt = Date.now();

                mediaPipeDetector.onResults((results) => {
                    mediaPipeLastResultAt = Date.now();
                    const detections = results.detections || [];

                    if (detections.length !== 1) {
                        updateCaptureState(false, 'Arahkan 1 wajah ke dalam frame');
                        return;
                    }

                    const relativeBox = detections[0].locationData?.relativeBoundingBox;

                    if (!relativeBox) {
                        updateCaptureState(false, 'Wajah belum terbaca, coba dekatkan sedikit');
                        return;
                    }

                    const box = {
                        x: relativeBox.xMin * video.videoWidth,
                        y: relativeBox.yMin * video.videoHeight,
                        width: relativeBox.width * video.videoWidth,
                        height: relativeBox.height * video.videoHeight,
                    };

                    evaluateFaceBox(box);
                });

                const runLoop = async () => {
                    if (!mediaPipeDetector || !video.videoWidth || !video.videoHeight) {
                        mediaPipeLoopHandle = requestAnimationFrame(runLoop);
                        return;
                    }

                    if (!mediaPipeBusy) {
                        mediaPipeBusy = true;
                        try {
                            const targetWidth = isMobileDevice ? 320 : 480;
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
                            initHeuristicFaceDetection();
                            showStatus('⚠ MediaPipe timeout, mode lokal aktif');
                        }
                    }
                }, 2000);
            } catch (error) {
                console.error('Fallback face detection error:', error);
                if ('FaceDetector' in window) {
                    initNativeFaceDetection();
                    showStatus('⚠ MediaPipe gagal, pakai engine native');
                } else {
                    initHeuristicFaceDetection();
                    showStatus('⚠ Mode lokal aktif: validasi wajah sederhana');
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
                    updateCaptureState(false, 'Arahkan 1 wajah ke dalam frame');
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
