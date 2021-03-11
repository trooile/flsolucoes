<?php 

    include "include/include.php";

if(php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

?>

<body>
    <div class="jumbotron vertical-center">
        <div class="container">
            <video id="video" controls preload="auto" width="1024" height="768"> <!-- <video width="1024" height="768" controls autoplay>-->
                <source src="/resource/video.mp4" type="video/mp4">
                    Sorry, your browser doesn't support the video element.
            </video>
        </div>
    <div>
</body>

<p>

<?php 

    include "include/footer.php";

?>