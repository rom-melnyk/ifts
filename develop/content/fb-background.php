<?php
// include $_SERVER['DOCUMENT_ROOT'] . '/php/fb-helpers.php';

function has_picture($obj) {
    return (boolean) $obj['full_picture'];
}

function render_fb_background() {
    $posts = get_posts_from_file();
    $pictures = $posts ? array_filter($posts, 'has_picture') : [];

    if (count($pictures) >= 3) {
        for ($i = 1; $i <= 3; $i++) {
            echo '<div class="fb-background fb-' . $i . '" style="background-image: url(\'' . $pictures[$i]['full_picture'] . '\')"></div>';
        }

        echo <<<HTML
<div class="fb-background fb-4">
    <i class="icon fa fa-facebook-square"></i>
</div>
HTML;
    } else {
        echo '<i class="icon fa fa-facebook-square"></i>';
    }
}

render_fb_background();
?>
