<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';

$FB_CONTENT_FILENAME = $_SERVER['DOCUMENT_ROOT'] . '/fb-cache/fb-content.json';
$FB_TOKEN_FILENAME = $_SERVER['DOCUMENT_ROOT'] . '/fb-cache/fb-token.txt';


function log_error($message, $err) {
    $err = str_replace("\n", '', $err);
    echo "<script>console.error('Facebook $message error:', '$err');</script>";
}


function get_posts_from_file() {
    global $FB_CONTENT_FILENAME;

    $posts = FALSE;
    if (file_exists($FB_CONTENT_FILENAME)) {
        $posts = file_get_contents($FB_CONTENT_FILENAME);
        try {
            $posts = json_decode($posts, true);
        } catch (Exception $e) {}
    }

    return $posts;
}


function save_posts_to_file($posts) {
    global $FB_CONTENT_FILENAME;

    $posts = json_encode($posts);
    file_put_contents($FB_CONTENT_FILENAME, $posts);
}


function render_posts($posts) {
    global $FB_GROUP_PAGE;

    foreach($posts as $post) {
        $url = get_post_url($post['id']);
        $date = get_post_date($post);

        echo '<article class="fb-post">';
        echo '<p class="date"><a class="link" href="' . $url . '" title="Перейти до допису">' . $date . '</a></p>';

        $img_class_name = array_key_exists('message', $post) ? 'wrapped' : '';
        if (array_key_exists('full_picture', $post)) {
            echo "<a href=\"$url\"><img class=\"$img_class_name\" src=\"${post['full_picture']}\"/></a>";
        }

        if (array_key_exists('message', $post)) {
            echo "<p class=\"text\">${post['message']}</p>";
        }
        echo '</article>';
    };

    echo "<h1><a class=\"link\" href=\"$FB_GROUP_PAGE\" title=\"Перейти на нашу сторінку\">Читати інші дописи на сторінці facebook</a></h1>";
}


function get_post_date($post) {
    $date = 'Перейти до допису';
    if (array_key_exists('updated_time', $post)) {
        preg_match('/(.*)T(\d\d:\d\d)/', $post['updated_time'], $parsed);
        if (count($parsed) === 3) {
            $date = "${parsed[1]} в ${parsed[2]}";
        }
    }

    return $date;
}


function get_post_url($id) {
    global $FB_GROUP_PAGE;
    preg_match('/.*_(.*)/', $id, $parsed);

    return $parsed && $parsed[1]
        ? "${FB_GROUP_PAGE}permalink/${parsed[1]}/"
        : 'javascript:void(0);';
}


function get_first_post_date($posts) {
    try {
        return new DateTime( $posts[0]['updated_time'] );
    } catch (Exception $e) {
        return new DateTime('1970-01-01');
    }
}


function get_time_diff($d1, $d2) {
    $diff = 0;
    try {
        $interval = $d1->diff($d2, TRUE);
        $diff = $interval->days;
    } catch (Exception $e) {}

    return $diff;
}


?>
