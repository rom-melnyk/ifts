<?php
$EXTENSIONS = array('html', 'php');

function get_page_name() {
    return array_key_exists('name', $_GET) ? $_GET['name'] : FALSE;
}

function get_page_path($name) {
    global $EXTENSIONS;

    if (!$name) {
        return FALSE;
    }

    $page_base = $_SERVER['DOCUMENT_ROOT'] . "/content/$name";
    $page_path = FALSE;

    foreach ($EXTENSIONS as $ext) {
        $path = "$page_base.$ext";
        if (file_exists($path)) {
            $page_path = $path;
            break;
        }
    }
    return $page_path;
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
