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

function render_page_or_error_message($page_name, $page_path) {
    if ($page_path) {
        include $page_path;
    } else {
        echo '<div class="error">';
        if (!$page_name) {
            echo 'Expected parameter "?name=<...>" but got nothing.';
        } else {
            echo "Page \"$page_name\" not found in content folder.";
        }
        echo '</div>';
    }
}
?>
