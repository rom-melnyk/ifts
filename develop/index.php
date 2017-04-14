<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/tiles.php'; ?>

<html>
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/includes/head.php'; ?>
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