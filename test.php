<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Custom Video Player</title>
    <style>
        .player-container:hover .controls {
            transform: translateY(0);
            opacity: 1;
        }

        .controls {
            transform: translateY(100%);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .volume-slider {
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            cursor: pointer;
        }

        .volume-slider::-webkit-slider-runnable-track {
            background: #fff;
            height: 4px;
            border-radius: 2px;
        }

        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            height: 12px;
            width: 12px;
            background: #ff0000;
            border-radius: 50%;
            margin-top: -4px;
        }

        .progress-bar {
            transition: width 0.1s linear;
        }

        .tooltip {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .control-button:hover .tooltip {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="player-container relative bg-black rounded-lg overflow-hidden">
            <!-- Video -->
            <video id="video" class="w-full h-full" poster="/api/placeholder/1200/600">
                <source src="your-video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <!-- Controls Container -->
            <div class="controls absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-4">
                <!-- Progress Bar -->
                <div class="relative w-full bg-gray-600 h-1 rounded-full mb-4 cursor-pointer" id="progress-container">
                    <div class="progress-bar absolute top-0 left-0 bg-red-500 h-full rounded-full" style="width: 0%"></div>
                    <div class="preview-time absolute -top-8 bg-black/80 px-2 py-1 rounded text-xs hidden"></div>
                </div>

                <!-- Control Buttons -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- Play/Pause -->
                        <button id="play-pause" class="control-button relative group">
                            <svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-black/80 px-2 py-1 rounded text-xs whitespace-nowrap">Play (k)</span>
                        </button>

                        <!-- Volume -->
                        <div class="flex items-center space-x-2">
                            <button id="volume-btn" class="control-button relative">
                                <svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 8v8m-5-4h4l5 4V4L11 8H7a1 1 0 00-1 1v6a1 1 0 001 1z"></path>
                                </svg>
                                <span class="tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-black/80 px-2 py-1 rounded text-xs">Mute (m)</span>
                            </button>
                            <input type="range" class="volume-slider w-20" min="0" max="100" value="100">
                        </div>

                        <!-- Time -->
                        <div class="text-sm text-white">
                            <span id="current-time">0:00</span>
                            <span>/</span>
                            <span id="duration">0:00</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Speed -->
                        <button id="speed-btn" class="control-button relative px-2 py-1 text-sm bg-white/10 rounded hover:bg-white/20 transition-colors">
                            1x
                            <span class="tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-black/80 px-2 py-1 rounded text-xs">Playback Speed</span>
                        </button>

                        <!-- Picture in Picture -->
                        <button id="pip-btn" class="control-button relative">
                            <svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2M8 4v4m8-4v4M4 10h16"></path>
                            </svg>
                            <span class="tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-black/80 px-2 py-1 rounded text-xs">Picture in Picture</span>
                        </button>

                        <!-- Fullscreen -->
                        <button id="fullscreen-btn" class="control-button relative">
                            <svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                            <span class="tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-black/80 px-2 py-1 rounded text-xs">Fullscreen (f)</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const playPauseBtn = document.getElementById('play-pause');
        const volumeBtn = document.getElementById('volume-btn');
        const volumeSlider = document.querySelector('.volume-slider');
        const currentTimeEl = document.getElementById('current-time');
        const durationEl = document.getElementById('duration');
        const progressContainer = document.getElementById('progress-container');
        const progressBar = progressContainer.querySelector('.progress-bar');
        const previewTime = progressContainer.querySelector('.preview-time');
        const speedBtn = document.getElementById('speed-btn');
        const pipBtn = document.getElementById('pip-btn');
        const fullscreenBtn = document.getElementById('fullscreen-btn');

        // Play/Pause
        playPauseBtn.addEventListener('click', togglePlay);
        video.addEventListener('click', togglePlay);

        function togglePlay() {
            if (video.paused) {
                video.play();
                updatePlayButton('pause');
            } else {
                video.pause();
                updatePlayButton('play');
            }
        }

        function updatePlayButton(state) {
            playPauseBtn.innerHTML = state === 'play' ?
                `<svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>` :
                `<svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>`;
        }

        // Volume
        volumeBtn.addEventListener('click', toggleMute);
        volumeSlider.addEventListener('input', handleVolumeChange);

        function toggleMute() {
            video.muted = !video.muted;
            updateVolumeIcon();
        }

        function handleVolumeChange() {
            video.volume = volumeSlider.value / 100;
            video.muted = video.volume === 0;
            updateVolumeIcon();
        }

        function updateVolumeIcon() {
            const value = video.volume;
            volumeBtn.innerHTML = value === 0 || video.muted ?
                `<svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                </svg>` :
                `<svg class="w-6 h-6 text-white hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 8v8m-5-4h4l5 4V4L11 8H7a1 1 0 00-1 1v6a1 1 0 001 1z"></path>
                </svg>`;
        }

        // Progress
        video.addEventListener('timeupdate', updateProgress);
        progressContainer.addEventListener('click', seek);
        progressContainer.addEventListener('mousemove', showPreview);
        progressContainer.addEventListener('mouseout', () => previewTime.classList.add('hidden'));

        function updateProgress() {
            const percent = (video.currentTime / video.duration) * 100;
            progressBar.style.width = `${percent}%`;
            currentTimeEl.textContent = formatTime(video.currentTime);
            durationEl.textContent = formatTime(video.duration);
        }

        function seek(e) {
            const percent = e.offsetX / progressContainer.offsetWidth;
            video.currentTime = percent * video.duration;
        }

        function showPreview(e) {
            const percent = e.offsetX / progressContainer.offsetWidth;
            const previewTime = video.duration * percent;

            const preview = progressContainer.querySelector('.preview-time');
            preview.classList.remove('hidden');
            preview.style.left = `${e.offsetX}px`;
            preview.textContent = formatTime(previewTime);
        }

        // Speed
        const speeds = [0.5, 1, 1.5, 2];
        let currentSpeedIndex = 1;

        speedBtn.addEventListener('click', changeSpeed);

        function changeSpeed() {
            currentSpeedIndex = (currentSpeedIndex + 1) % speeds.length;
            const newSpeed = speeds[currentSpeedIndex];
            video.playbackRate = newSpeed;
            speedBtn.textContent = `${newSpeed}x`;
        }

        // Picture in Picture
        pipBtn.addEventListener('click', togglePiP);

        async function togglePiP() {
            try {
                if (document.pictureInPictureElement) {
                    await document.exitPictureInPicture();
                } else {
                    await video.requestPictureInPicture();
                }
            } catch (error) {
                console.error('PiP failed:', error);
            }
        }

        // Fullscreen
        fullscreenBtn.addEventListener('click', toggleFullscreen);

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                video.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.target.tagName === 'INPUT') return; // Ignore if typing in an input

            switch(e.key.toLowerCase()) {
                case ' ':
                    e.preventDefault();
                    togglePlay();
                    break;
                case 'arrowright':
                    e.preventDefault();
                    video.currentTime += 5;
                    break;
                case 'arrowleft':
                    e.preventDefault();
                    video.currentTime -= 5;
                    break;
                case 'arrowup':
                    e.preventDefault();
                    video.volume = Math.min(1, video.volume + 0.1);
                    volumeSlider.value = video.volume * 100;
                    updateVolumeIcon();
                    break;
                case 'arrowdown':
                    e.preventDefault();
                    video.volume = Math.max(0, video.volume - 0.1);
                    volumeSlider.value = video.volume * 100;
                    updateVolumeIcon();
                    break;
            }
        });

        // Add buffer indicator
        video.addEventListener('progress', updateBuffer);

        function updateBuffer() {
            if (video.buffered.length > 0) {
                const bufferedEnd = video.buffered.end(video.buffered.length - 1);
                const duration = video.duration;
                const bufferBar = document.querySelector('.buffer-bar');
                bufferBar.style.width = `${(bufferedEnd / duration) * 100}%`;
            }
        }

        // Add loading spinner
        const loadingSpinner = document.getElementById('loading-spinner');

        video.addEventListener('waiting', () => {
            loadingSpinner.classList.remove('hidden');
        });

        video.addEventListener('canplay', () => {
            loadingSpinner.classList.add('hidden');
        });

        // Settings menu toggle
        const settingsBtn = document.getElementById('settings-btn');
        const settingsMenu = document.getElementById('settings-menu');

        settingsBtn.addEventListener('click', () => {
            settingsMenu.classList.toggle('active');
        });

        // Close settings when clicking outside
        document.addEventListener('click', (e) => {
            if (!settingsBtn.contains(e.target) && !settingsMenu.contains(e.target)) {
                settingsMenu.classList.remove('active');
            }
        });

        // Quality selection
        document.querySelectorAll('.quality-option').forEach(option => {
            option.addEventListener('click', () => {
                // In a real implementation, this would switch video quality
                const quality = option.textContent;
                // Update current quality indicator
                document.querySelectorAll('.quality-option').forEach(opt => {
                    opt.classList.remove('text-red-500');
                });
                option.classList.add('text-red-500');
                settingsMenu.classList.remove('active');
            });
        });

        // Playback speed selection
        document.querySelectorAll('.speed-option').forEach(option => {
            option.addEventListener('click', () => {
                const speed = option.textContent;
                video.playbackRate = parseFloat(speed) || 1;
                document.querySelectorAll('.speed-option').forEach(opt => {
                    opt.classList.remove('text-red-500');
                });
                option.classList.add('text-red-500');
                settingsMenu.classList.remove('active');
            });
        });

        // Double click for fullscreen
        video.addEventListener('dblclick', toggleFullscreen);

        // Add touch support for mobile
        let touchStartX = 0;
        let touchStartY = 0;

        video.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        });

        video.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            const touchEndY = e.changedTouches[0].clientY;
            const deltaX = touchEndX - touchStartX;
            const deltaY = touchEndY - touchStartY;

            if (Math.abs(deltaX) < 10 && Math.abs(deltaY) < 10) {
                // It's a tap - toggle play/pause
                togglePlay();
            } else if (Math.abs(deltaX) > Math.abs(deltaY)) {
                // Horizontal swipe - seek
                if (deltaX > 0) {
                    video.currentTime += 10;
                } else {
                    video.currentTime -= 10;
                }
            }
        });

        // Format time helper function
        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = Math.floor(seconds % 60);

            if (hours > 0) {
                return `${hours}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
            return `${minutes}:${secs.toString().padStart(2, '0')}`;
        }
    </script>
</body>
</html>
