<?php

$TOKEN_FILENAME = $_SERVER['DOCUMENT_ROOT'] . '/php/fb-token.txt';

$token = $_POST['access_token'];
$response = array('ok' => null, 'msg' => '');

if ($token) {
    $result = file_put_contents($TOKEN_FILENAME, $token);
    if ($result) {
        $response['ok'] = true;
    } else {
        $response['ok'] = false;
        $response['msg'] = 'Unable to save token into file';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header("HTTP/1.1 400 Bad Request");
    echo 'Not supported';
}

?>
