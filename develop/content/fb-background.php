<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-helpers.php';

function has_picture($obj) {
    return (boolean) $obj['full_picture'];
}

function render_fb_background() {
    $posts = get_posts_from_file();
    $pictures = $posts ? array_filter($posts, 'has_picture') : array();
    $icon = '<i class="icon fa fa-facebook-square"></i>';

    if (count($pictures) >= 3) {
        for ($i = 1; $i <= 3; $i++) {
            $pic = $pictures[$i - 1]['full_picture'];
            echo '<div class="fb-background fb-' . $i . '" style="background-image: url(\'' . $pic . '\')"></div>';
        }

        echo '<div class="fb-background fb-4">' . $icon . '</div>';
    } else {
        echo $icon;
    }
}

render_fb_background();
?>
