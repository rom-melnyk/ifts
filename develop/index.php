<?php
include_once __DIR__ . '/php/tiles.php';
?>

<html>
<head>
    <title>ІфТехСервіс 2013-2017</title>
    <link rel="stylesheet" href="./style.css">
    <script type="application/javascript" src="./script.js"></script>
</head>
<body onload="IFTS.start();">
    <div class="main-content">
        <header class="row">
            <div class="column-3">
                <div class="logo">/-- LOGO --/</div>
            </div>
            <div class="column-1">
                <div class="phone-nums">
                    <ul>
                        <li>+380 (67) 111-2233</li>
                        <li>+380 (67) 111-2233</li>
                        <li>+380 (67) 111-2233</li>
                    </ul>
                </div>
            </div>
        </header>

        <section>
            <p><?php  render_tiles(); ?></p>
        </section>

        <footer class="row">
            <div class="column-1">
                <div class="logo">IFTS</div>
            </div>
            <div class="column-2">
                <div class="phone-nums">Repair SEO test</div>
            </div>
            <div class="column-1">
                &copy; IFTS
                Розробка: ...
            </div>
        </footer>
    </div>
</body>
</html>