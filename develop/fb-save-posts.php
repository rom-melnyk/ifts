<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-helpers.php';

$posts = file_get_contents('php://input');
$response = array('ok' => null, 'msg' => '');

if ($posts) {
    $result = save_posts_to_file($posts);
    if ($result) {
        $response['ok'] = true;
    } else {
        $response['ok'] = false;
        $response['msg'] = 'Unable to save posts into file';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header("HTTP/1.1 400 Bad Request");
    echo 'Not supported';
}

?>
