<?php

if(!isset($_GET['ext']) || $_GET['ext'] == 'mp4') {
    $path = dirname(__FILE__) . '../resource/video1.mp4';
}else{
    header('HTTP/1.1 400 Bad Request');
    return;
}

$file = new finfo(FILEINFO_MIME);
$mp4 = $file->file($path);

header('Content-type: ' . $mp4);

$size = filesize($path);

if(isset($_SERVER['HTTP_RANGE'])) {
    
    list($specifier, $value) = explode('=', $_SERVER['HTTP_RANGE']);

    if($specifier != 'bytes') {
        header('HTTP/1.1 400 Bad Request');
        return;
    }

    list($from, $to) = explode('-', $value);
    if(!$to) {
        $to = $size - 1;
    }

    header('HTTP/1.1 206 Partial Content');
    header('Accept-Ranges: bytes');

    header('Content-Length: ' . ($to - $from));

    header("Content-Range: bytes {$from}-{$to}/{$size}");

    $fp = fopen($path, 'rb');
    $chunk = 8192; 

    fseek($fp, $from);

    while(true){

        if(ftell($fp) >= $to){
            break;
        }

        echo fread($fp, $chunk);

        ob_flush();
        flush();
    }
}else{

    header('Content-Length: ' . $size);

    readfile($path);
}
?>