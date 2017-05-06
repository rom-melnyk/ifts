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
    $quadrant_size = 0;

    for ($i = 0; $i < $count; $i++) {
        $object = $content[$i];

        if ($quadrant_size === 0) {
            echo '<div class="quadrant">';
        }

        $size = 1;
        if (array_key_exists('size', $object)) {
            $size = $object['size'];
        }
        $quadrant_size += $size;

        $width = $size > 1 ? 2 : 1;
        $height = $size === 4 ? 2 : 1;
        echo "<div class=\"tile width-$width height-$height\">";

        $wrapper = get_wrapper($object);
        echo $wrapper['open'];
        echo get_icon($object);
        echo get_title($object);
        echo $wrapper['close'];
        echo '</div>';

        if ($quadrant_size >= 4) {
            echo '</div>';
            $quadrant_size = 0;
        }
    }
}

// ----------------------- helpers -----------------------
function get_title($object) {
    return array_key_exists('title', $object)
        ? '<div class="title">' . $object['title'] . '</div>'
        : '';
}

function get_icon($object) {
    global $ICONS_BASE;
    if (array_key_exists('icon-file', $object)) {
        return '<div class="icon file" style="background-image: url(' . "'" . $ICONS_BASE . $object['icon-file'] . "'" . ')"></div>';
    } else if (array_key_exists('icon-class', $object)) {
        return '<i class="icon fa ' . $object['icon-class'] . '"></i>';
    } else {
        return '';
    }
}

function get_wrapper($object) {
    $href = FALSE;
    $link_title = '';

    $link = get_link($object);
    $content_file = get_content_file($object);

    if ($link) {
        $href = $link;
        preg_match('/^https?:\/\/([^\/]+)/', $href, $parsed); // extract the site name
        if (count($parsed) === 2) {
            $link_title = "Перейти на ${parsed[1]}";
        } else {
            $link_title = 'Перейти на сайт';
        }
    } else if ($content_file) {
        $href = "/page/$content_file";
        $link_title = 'Відкрити розділ';
    }

    return $href
        ? array(
            'open' => '<a href="' . $href . '" class="inner-wrapper" title="' . $link_title . '">',
            'close' => '</a>'
        )
        : array('open' => '<div class="inner-wrapper">', 'close' => '</div>');
}

function get_link($object) {
    return array_key_exists('link', $object)
        ? $object['link']
        : FALSE;
}

function get_content_file($object) {
    return array_key_exists('content-file', $object)
        ? $object['content-file']
        : FALSE;
}
?>
