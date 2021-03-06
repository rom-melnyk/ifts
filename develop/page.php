<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/pages.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/file-exists.php'; ?>

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
            $page_path = get_file_name_if_exists($page_name);
            if ($page_path) {
                include $page_path;
            } else {
                render_error_message($page_name);
            }
            ?>
        </section>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/includes/footer.php'; ?>
    </div>
</body>
</html>