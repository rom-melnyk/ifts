<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/file-exists.php';

function get_page_name() {
    return array_key_exists('name', $_GET) ? $_GET['name'] : FALSE;
}

function render_error_message($page_name) {
    echo '<div class="error">';
    if (!$page_name) {
        echo 'Параметр "?name=<...>" не заданий.';
    } else {
        echo "Немає файла \"$page_name\" у папці content/.";
    }
    echo '</div>';
}
?>
