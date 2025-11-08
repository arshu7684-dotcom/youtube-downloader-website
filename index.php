<?php
session_start();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_url'])) {
    header("Location: process.php?url=" . urlencode($_POST['video_url']));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YTDownloader - Download YouTube Videos Free | MP4, MP3, HD Quality</title>
    <meta name="description" content="Free YouTube video downloader. Download videos in 144p, 360p, 720p, 1080p quality and MP3 audio format. Fast, secure and mobile friendly.">
    <meta name="keywords" content="youtube downloader, video download, mp4 download, mp3 download, youtube to mp3">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="logo">
                    <h2>🎬 YTDownloader</h2>
                </div>
                <ul class="nav-menu">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#how-to-use">How to Use</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
        </nav>
        
        <div class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">Download YouTube Videos <span class="highlight">Free & Fast</span></h1>
                    <p class="hero-subtitle">Convert YouTube videos to MP4, MP3 in multiple qualities. No registration required!</p>
                    
                    <!-- Download Form -->
                    <div class="download-form-container">
                        <form method="POST" class="download-form" id="downloadForm">
                            <div class="input-group">
                                <input 
                                    type="url" 
                                    name="video_url" 
                                    class="url-input" 
                                    placeholder="Paste YouTube link here... Example: https://www.youtube.com/watch?v=..." 
                                    required
                                    id="videoUrl">
                                <button type="submit" class="download-btn" id="downloadBtn">
                                    <span class="btn-text">Download Now</span>
                                    <span class="btn-loader" style="display: none;">⏳ Processing...</span>
                                </button>
                            </div>
                        </form>
                        <div class="form-note">
                            <span>🔒 Secure & Fast • 📱 Mobile Friendly • 🆓 100% Free</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose Our Downloader?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎥</div>
                    <h3>Multiple Qualities</h3>
                    <p>Download in 144p, 360p, 720p, 1080p - Choose the quality that fits your needs</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎵</div>
                    <h3>MP3 Audio</h3>
                    <p>Extract high-quality MP3 audio from any YouTube video</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Fast Processing</h3>
                    <p>High-speed downloads with optimized processing</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Mobile Friendly</h3>
                    <p>Works perfectly on all devices - desktop, tablet & mobile</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Safe & Secure</h3>
                    <p>No ads, no malware, completely safe to use</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🆓</div>
                    <h3>100% Free</h3>
                    <p>Unlimited downloads without any registration</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Use Section -->
    <section class="how-to-section" id="how-to-use">
        <div class="container">
            <h2 class="section-title">How to Download?</h2>
            <div class="steps-container">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Copy YouTube URL</h3>
                    <p>Go to YouTube and copy the video link from address bar</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Paste Link</h3>
                    <p>Paste the copied URL in the input field above</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Choose Format</h3>
                    <p>Select your preferred quality and format</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Download</h3>
                    <p>Click download and save your file instantly</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Downloads -->
    <?php if (isset($_SESSION['recent_downloads']) && !empty($_SESSION['recent_downloads'])): ?>
    <section class="recent-section">
        <div class="container">
            <h2 class="section-title">Recently Downloaded</h2>
            <div class="recent-grid">
                <?php foreach (array_slice($_SESSION['recent_downloads'], 0, 6) as $download): ?>
                <div class="recent-item">
                    <div class="recent-icon">📥</div>
                    <div class="recent-info">
                        <h4><?php echo htmlspecialchars(substr($download['title'], 0, 50)); ?><?php echo strlen($download['title']) > 50 ? '...' : ''; ?></h4>
                        <p><?php echo strtoupper($download['type']); ?> • <?php echo date('M j, g:i A', $download['time']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQ Section -->
    <section class="faq-section" id="faq">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="faq-container">
                <div class="faq-item">
                    <h3>Is this service free?</h3>
                    <p>Yes, completely free! No hidden charges or registration required.</p>
                </div>
                <div class="faq-item">
                    <h3>What qualities are available?</h3>
                    <p>We support 144p, 360p, 720p, 1080p for video and MP3 for audio.</p>
                </div>
                <div class="faq-item">
                    <h3>Is it mobile friendly?</h3>
                    <p>Yes, our website works perfectly on all devices including smartphones and tablets.</p>
                </div>
                <div class="faq-item">
                    <h3>How long does processing take?</h3>
                    <p>Usually 5-10 seconds depending on video length and server load.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 YTDownloader. All rights reserved. | Free YouTube Video Downloader</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
