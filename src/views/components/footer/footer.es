import './footer.scss';

import React, { Component } from 'react';

export default class Footer extends Component {
    render() {
        const counter = (
            <script type="text/javascript">
                {
                    'var sc_project=10142154; ' +
                    'var sc_invisible=0; ' +
                    'var sc_security="0d25dfee"; ' +
                    'document.write("<sc" + "ript type=\'text/javascript\' src=\'" + scJsHost + "http://www.statcounter.com/counter/counter.js\'></" + "script>");'
                }
            </script>
        );
        const counterNoScript = (
            <noscript>
                <div className="statcounter">
                    <a title="create counter" href="http://statcounter.com/free-hit-counter/" target="_blank">
                        <img className="statcounter" src="http://c.statcounter.com/10142154/0/0d25dfee/0/" alt="create counter" />
                    </a>
                </div>
            </noscript>
        );

        return (
            <div className="footer">
                <div className="row footer-int-wrapper">
                    <div className="column-2 footer-logo-about-us">
                        <div className="row">
                            <div className="column-1 footer-logo">
                                <img className="logo-small" alt="ІФТехСервіс" src="/gfx/logo.png" />
                            </div>
                            <div className="column-3 footer-about-us">
                                <p title="Вже третій рік пішов, чувааак!">&copy; ІФТехСервіс, 2013-2016</p>
                                <p>Ми ремонтуємо техніку в Івано-Франківську:<br />
                                    телевізори, комп"ютери та ноутбуки, монітори, магнітофони, цифрові фотоапарати, аудіо- та відеотехніку, кухонну та&nbsp;іншу побутову електроніку.
                                </p>
                                <p>Samsung LG Panasonic Sony Lenovo IBM Gigabyte MSI BenQ Canon Philips Siemens Bosh.</p>
                            </div>
                        </div>
                    </div>
                    <div className="column-1 footer-counters">
                        <p>
                            {counter}
                            {/*counterNoScript*/}
                        </p>
                    </div>
                    <div className="column-1 footer-design transition-opa">
                        <p>Придумав <a href="mailto:whiplash@ukr.net">Богдан&nbsp;Тимків</a></p>
                        <p>Реалізував <a href="mailto:email.rom.melnyk@gmail.com">Роман&nbsp;Мельник</a></p>
                    </div>
                </div>
            </div>
        );
    }
}