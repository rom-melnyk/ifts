<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/tiles.php';
?>

<html>
<head>
    <title>ІфТехСервіс 2013-2017</title>
    <link rel="icon" href="./gfx/icons/favicon.ico">
    <link rel="stylesheet" href="./style.css">
    <script type="application/javascript" src="./script.js"></script>
</head>
<body onload="IFTS.start();">
    <div class="main-content">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/includes/header.php'; ?>

        <section class="row">
            <?php render_tiles(); ?>
        </section>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/includes/footer.php'; ?>
    </div>
</body>
</html>