<?php
$PATH = __DIR__ . '/../content/tiles.json';

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
    for ($i = 0; $i < count($content); $i++) {
        $object = $content[$i];
        echo "<div>";
        echo $object->{'title'};
        echo "</div>";
    }
}
?>
