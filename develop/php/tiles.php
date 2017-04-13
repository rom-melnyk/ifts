<?php
$PATH = $_SERVER['DOCUMENT_ROOT'] . '/content/tiles.json';
$ICONS_BASE = 'gfx/icons/';

function read_file() {
    global $PATH;
    $content = file_get_contents($PATH);

    try {
        $content = json_decode($content, true);
    } catch (Exception $e) {
        $content = array();
    }

    return $content;
}

function render_tiles() {
    $content = read_file();
    $count = count($content);
    for ($i = 0; $i < $count; $i++) {
        $object = $content[$i];
        $width = rand(1, 4);
        echo "<div class=\"tile column-$width\"><div class=\"inner-wrapper\">";
        echo get_icon($object);
        echo get_title($object);
        echo '</div></div>';
    }
}

// ----------------------- helpers -----------------------
function get_title($object) {
    return array_key_exists('title', $object)
        ? "<div class=\"title\">${object['title']}</div>"
        : '';
}

function get_icon($object) {
    global $ICONS_BASE;
    if (array_key_exists('icon-file', $object)) {
        return "<div class=\"icon file\" style=\"background-image: url('${ICONS_BASE}${object['icon-file']}')\"></div>";
    } else if (array_key_exists('icon-class', $object)) {
        return "<div class=\"icon ${object['icon-class']}\"></div>";
    } else {
        return '';
    }
}
?>
