<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-helpers.php';

render_fb_part();


// ------------------------ main ------------------------
function render_fb_part() {
    global $FB_CONFIG;
    global $FB_GROUP_ID;

    $posts = get_posts_from_file();

    if ($posts) {
        render_posts($posts);
    }

    $date_from_file = $posts ? get_first_post_date($posts) : new DateTime('2000-01-01');
    if (!$posts || get_time_diff(new DateTime(), $date_from_file) > 0) {
        echo "<script>Object.assign(IFTS.facebook, { appId: '" . $FB_CONFIG['app_id'] . "', groupId: '" . $FB_GROUP_ID . "', shouldFetchPosts: true });</script>";
    }
}
