<?php
session_start();

header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

function sanitize_filename($filename) {
    $filename = preg_replace('/[^a-zA-Z0-9\-\._]/', '_', $filename);
    return substr($filename, 0, 100);
}

function validate_video_id($video_id) {
    return preg_match('/^[a-zA-Z0-9_-]{11}$/', $video_id);
}

function track_download($title, $format, $quality) {
    if (!isset($_SESSION['recent_downloads'])) {
        $_SESSION['recent_downloads'] = [];
    }
    
    array_unshift($_SESSION['recent_downloads'], [
        'title' => $title,
        'format' => $format,
        'quality' => $quality,
        'time' => time(),
        'type' => $format
    ]);
    
    $_SESSION['recent_downloads'] = array_slice($_SESSION['recent_downloads'], 0, 10);
}

$quality = $_GET['quality'] ?? '';
$format = $_GET['format'] ?? '';
$video_id = $_GET['id'] ?? '';
$title = $_GET['title'] ?? 'video';

if (empty($quality) || empty($format) || empty($video_id) || !validate_video_id($video_id)) {
    header("Location: index.php?error=Invalid+download+parameters");
    exit;
}

$sanitized_title = sanitize_filename($title);
$filename = $sanitized_title . '.' . $format;

track_download($sanitized_title, $format, $quality);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Download Complete - YTDownloader</title>
    <link rel='stylesheet' href='style.css'>
</head>
<body>
    <nav class='navbar'>
        <div class='nav-container'>
            <div class='logo'>
                <h2><a href='index.php' style='text-decoration: none;'>🎬 YTDownloader</a></h2>
            </div>
        </div>
    </nav>

    <div class='container' style='margin-top: 100px; text-align: center; padding: 50px;'>
        <div style='font-size: 4rem; margin-bottom: 20px;'>✅</div>
        <h1 style='color: #38a169; margin-bottom: 20px;'>Download Ready!</h1>
        <p style='font-size: 1.2rem; margin-bottom: 30px; color: var(--text-light);'>
            Your file <strong>'$sanitized_title'</strong> in $quality $format is ready to download.
        </p>
        <div style='margin-bottom: 30px;'>
            <div class='quality-badge' style='display: inline-block; margin: 5px;'>$quality</div>
            <div class='format-badge' style='display: inline-block; margin: 5px;'>$format</div>
        </div>
        <div style='margin-bottom: 40px;'>
            <a href='index.php' class='download-option-btn' style='margin: 10px;'>Download Another Video</a>
            <button onclick='window.close()' class='download-option-btn' style='background: var(--text-light); margin: 10px;'>Close Window</button>
        </div>
        <p style='color: var(--text-light); font-size: 0.9rem;'>
            💡 <strong>Note:</strong> In actual implementation, this would automatically download the file.<br>
            For this demo, we're showing a success message.
        </p>
    </div>
</body>
</html>";
?>
