import './application-container.scss';

import React, { Component } from 'react';
import Header from './components/header/header.es';
import Brick from './components/brick/brick.es';
import Footer from './components/footer/footer.es';

export default class Main extends Component {
    render() {
        const bricks = IFTS.bricks.map(brick => <Brick {...brick} key={brick.id} />);
        return (
            <div className="application-container">
                <Header />
                {bricks}
                <Footer />
            </div>
        );
    }
}
