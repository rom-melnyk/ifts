<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/pages.php'; ?>

<html>
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/includes/head.php'; ?>
</head>
<body onload="IFTS.start();">
    <div class="main-content">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/includes/header.php'; ?>

        <section>
            <?php
            $page_name = get_page_name();
            $page_path = get_page_path($page_name);
            render_page_or_error_message($page_name, $page_path);
            ?>
        </section>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/includes/footer.php'; ?>
    </div>
</body>
</html>