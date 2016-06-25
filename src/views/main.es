import './application-container.scss';

import React, { Component } from 'react';

import Header from './components/header/header.es';
import Brick from './components/brick/brick.es';
import Footer from './components/footer/footer.es';

import { getState, addChangeListener, removeChangeListener } from '../state.es';

export default class Main extends Component {
    constructor() {
        super();
        this.state = getState();
    }

    componentDidMount() {
        addChangeListener(this._updateState);
    }

    componentWillUnmount() {
        removeChangeListener(this._updateState);
    }

    render() {
        const bricks = this.state.bricks.map(brick => <Brick {...brick} key={brick.id} />);
        return (
            <div className="application-container">
                <Header />
                {bricks}
                <Footer />
                {/* IFTS.overlay && <Overlay {IFTS.overlay} /> */}
            </div>
        );
    }

    _updateState(state) {
        this.setState(state);
    }

}
