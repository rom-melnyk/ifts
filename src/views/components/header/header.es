import './header.scss'
import React, { Component } from 'react';

export default class Header extends Component {
    render() {
        return (
            <div className="row header">
                <div className="column-2 header-logo">
                    <img className="logo-big" alt="ІФТехСервіс" src="/gfx/logo.png" />
                        <div className="header-slogan">Ми&nbsp;ремонтуємо побутову&nbsp;техніку</div>
                </div>
                <div className="column-2 header-contact-us">
                    <ul>
                        <li><i className="fa fa-phone icon-s"></i><b>(097)</b> 133-22-11</li>
                        <li><i className="fa fa-envelope-o icon-s"></i><a href="mailto:whiplash@ukr.net">whiplash@ukr.net</a></li>
                    </ul>
                </div>
            </div>
        );
    }
}