<?php
$CONTENT_FILENAME = $_SERVER['DOCUMENT_ROOT'] . '/php/fb-content.json';

function log_error($message, $err) {
    $err = str_replace("\n", '', $err);
    echo "<script>console.error('Facebook $message error:', '$err');</script>";
}


function get_posts_from_file() {
    global $CONTENT_FILENAME;

    $posts = FALSE;
    if (file_exists($CONTENT_FILENAME)) {
        $posts = file_get_contents($CONTENT_FILENAME);
        try {
            $posts = json_decode($posts, true);
        } catch (Exception $e) {}
    }

    return $posts;
}


function save_posts_to_file($posts) {
    global $CONTENT_FILENAME;

    $posts = json_encode($posts);
    file_put_contents($CONTENT_FILENAME, $posts);
}


?>
