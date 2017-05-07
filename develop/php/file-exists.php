<?php
$EXTENSIONS = array('html', 'php');
define('DEFAULT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/content/');

function get_file_name_if_exists($name, $path = DEFAULT_PATH) {
    global $EXTENSIONS;

    if (!$name) {
        return FALSE;
    }

    $page_base = $path . $name;
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

?>
