<?php
session_start();

if (!isset($_SESSION['current_video'])) {
    header("Location: index.php");
    exit;
}

$video = $_SESSION['current_video'];
$video_id = $video['id'];
$video_title = $video['title'];

function sanitizeFilename($filename) {
    $filename = preg_replace('/[^a-zA-Z0-9\-\._]/', '_', $filename);
    return substr($filename, 0, 100);
}

$safe_title = sanitizeFilename($video_title);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Options - <?php echo htmlspecialchars($video_title); ?> | YTDownloader</title>
    <meta name="description" content="Download <?php echo htmlspecialchars($video_title); ?> in multiple formats and qualities">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <h2><a href="index.php" style="text-decoration: none;">🎬 YTDownloader</a></h2>
            </div>
        </div>
    </nav>

    <div class="options-container">
        <div class="video-preview">
            <h1 class="video-title">"<?php echo htmlspecialchars($video_title); ?>"</h1>
            <div class="video-thumbnail">
                <img src="https://img.youtube.com/vi/<?php echo $video_id; ?>/hqdefault.jpg" 
                     alt="<?php echo htmlspecialchars($video_title); ?>" 
                     style="max-width: 480px; width: 100%; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            </div>
        </div>

        <h2 class="section-title" style="text-align: center;">Choose Download Format</h2>
        
        <div class="quality-options">
            <div class="quality-card">
                <div class="quality-badge">144p</div>
                <div class="format-badge">MP4 Video</div>
                <p>Low Quality • Small Size</p>
                <a href="download.php?quality=144p&format=mp4&id=<?php echo $video_id; ?>&title=<?php echo urlencode($safe_title); ?>" 
                   class="download-option-btn">
                    Download 144p
                </a>
            </div>

            <div class="quality-card">
                <div class="quality-badge">360p</div>
                <div class="format-badge">MP4 Video</div>
                <p>Medium Quality • Balanced</p>
                <a href="download.php?quality=360p&format=mp4&id=<?php echo $video_id; ?>&title=<?php echo urlencode($safe_title); ?>" 
                   class="download-option-btn">
                    Download 360p
                </a>
            </div>

            <div class="quality-card">
                <div class="quality-badge">720p</div>
                <div class="format-badge">MP4 Video</div>
                <p>HD Quality • Recommended</p>
                <a href="download.php?quality=720p&format=mp4&id=<?php echo $video_id; ?>&title=<?php echo urlencode($safe_title); ?>" 
                   class="download-option-btn">
                    Download 720p
                </a>
            </div>

            <div class="quality-card">
                <div class="quality-badge">1080p</div>
                <div class="format-badge">MP4 Video</div>
                <p>Full HD • Best Quality</p>
                <a href="download.php?quality=1080p&format=mp4&id=<?php echo $video_id; ?>&title=<?php echo urlencode($safe_title); ?>" 
                   class="download-option-btn">
                    Download 1080p
                </a>
            </div>

            <div class="quality-card">
                <div class="quality-badge">MP3</div>
                <div class="format-badge">Audio Only</div>
                <p>High Quality Audio • 128kbps</p>
                <a href="download.php?quality=audio&format=mp3&id=<?php echo $video_id; ?>&title=<?php echo urlencode($safe_title); ?>" 
                   class="download-option-btn">
                    Download MP3
                </a>
            </div>

            <div class="quality-card">
                <div class="quality-badge">MP3</div>
                <div class="format-badge">High Quality Audio</div>
                <p>Best Audio Quality • 320kbps</p>
                <a href="download.php?quality=audio_hq&format=mp3&id=<?php echo $video_id; ?>&title=<?php echo urlencode($safe_title); ?>" 
                   class="download-option-btn">
                    Download HQ MP3
                </a>
            </div>
        </div>

        <center>
            <a href="index.php" class="back-btn">← Download Another Video</a>
        </center>
    </div>

    <script src="script.js"></script>
</body>
</html>
