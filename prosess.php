<?php
session_start();

function validateYouTubeUrl($url) {
    $patterns = [
        '/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
        '/^(https?:\/\/)?(www\.)?(youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
        '/^(https?:\/\/)?(www\.)?(youtube\.com\/v\/)([a-zA-Z0-9_-]{11})/'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[4];
        }
    }
    return false;
}

function getVideoTitle($video_id) {
    $methods = [
        [
            'url' => "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=$video_id&format=json",
            'callback' => function($data) {
                return json_decode($data, true)['title'] ?? null;
            }
        ],
        [
            'url' => "https://noembed.com/embed?url=https://www.youtube.com/watch?v=$video_id",
            'callback' => function($data) {
                return json_decode($data, true)['title'] ?? null;
            }
        ]
    ];
    
    foreach ($methods as $method) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
            ]
        ]);
        
        $response = @file_get_contents($method['url'], false, $context);
        if ($response) {
            $title = $method['callback']($response);
            if ($title) {
                return $title;
            }
        }
    }
    
    return "YouTube_Video_$video_id";
}

$video_url = isset($_GET['url']) ? urldecode($_GET['url']) : '';

if (empty($video_url)) {
    header("Location: index.php?error=Please+enter+a+YouTube+URL");
    exit;
}

$video_id = validateYouTubeUrl($video_url);
if (!$video_id) {
    header("Location: index.php?error=Invalid+YouTube+URL+provided");
    exit;
}

$video_title = getVideoTitle($video_id);

$_SESSION['current_video'] = [
    'id' => $video_id,
    'title' => $video_title,
    'url' => $video_url,
    'timestamp' => time()
];

header("Location: download-options.php");
exit;
?>
