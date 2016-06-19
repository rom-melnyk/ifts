import './application-container.scss';

import React, { Component } from 'react';
import Header from './components/header/header.es';
import Footer from './components/footer/footer.es';

export default class Main extends Component {
    render() {
        return (
            <div className="application-container">
                <Header />
                It works!
                <div className="brick color-3">azaza</div>
                <Footer />
            </div>
        );
    }
}
