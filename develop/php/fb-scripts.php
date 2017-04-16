<?php
$TOKEN_FILE = $_SERVER['DOCUMENT_ROOT'] . '/php/fb-token.txt';

function read_token() {
    global $TOKEN_FILE;
    return file_exists($TOKEN_FILE) ? file_get_contents($TOKEN_FILE) : FALSE;
}

function write_token($token) {
    global $TOKEN_FILE;
    file_put_contents($TOKEN_FILE, $token);
}
?>
