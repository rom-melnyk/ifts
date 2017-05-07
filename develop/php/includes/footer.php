<footer class="row">
    <div class="column-2 footer-logo-about-us">
        <div class="row">
            <div class="column-1 footer-logo">
                <a href="/"><img class="logo-small" alt="ІФТехСервіс" src="/gfx/logo.png"></a>
            </div>
            <div class="column-3 footer-about-us">
                <p>&copy; ІФТехСервіс, <span title="Вже чотири роки!">2013-2017</span></p>
                <p>Ми ремонтуємо техніку в Івано-Франківську:<br>
                телевізори, комп'ютери та ноутбуки, монітори, магнітофони, цифрові фотоапарати, аудіо- та відеотехніку, кухонну та&nbsp;іншу побутову електроніку.
                </p>
                <p>Samsung LG Panasonic Sony Lenovo IBM Gigabyte MSI BenQ Canon Philips Siemens Bosh.</p>
            </div>
        </div>
    </div>
    <div class="column-1 footer-counters">
        <?php
        $colors = [ 'purple', 'blue', 'green', 'olive' ]; // @see `css/_skins.scss`
        foreach ($colors as $color) {
            echo '<a class="skin ' . $color . '" href="javascript:IFTS.setSkin(\'' . $color . '\')" title="Змінити палітру">&nbsp;</a>';
        }
        ?>
        &nbsp;
        <!--<p>[counter-1]</p>
        <p>[counter-2]</p>-->
    </div>
    <div class="column-1 footer-design transition-opa-5">
        <p>Придумав <a class="link" href="mailto:whiplash@ukr.net">Богдан&nbsp;Тимків</a></p>
        <p>Реалізував <a class="link" href="mailto:email.rom.melnyk@gmail.com">Роман&nbsp;Мельник</a></p>
    </div>
</footer>
