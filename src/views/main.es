import './application-container.scss';

import React, { Component } from 'react';

import Header from './components/header/header.es';
import Brick from './components/brick/brick.es';
import Footer from './components/footer/footer.es';
import Overlay from './components/overlay/overlay.es';

import { getState, addChangeListener, removeChangeListener } from '../state.es';

export default class Main extends Component {
    constructor() {
        super();
        this.state = getState();

        // for some reason this method being called from the outside loses the context
        this._updateState = this.setState.bind(this);
    }

    componentDidMount() {
        addChangeListener(this._updateState);
    }

    componentWillUnmount() {
        removeChangeListener(this._updateState);
    }

    render() {
        const bricks = (
            <div className="row bricks-container">
                {this.state.bricks.map(brick => <Brick {...brick} key={brick.id} />)}
            </div>
        );
        const overlay = this.state.overlay && <Overlay {...this.state.overlay} />;
        return (
            <div className="application-container">
                <Header />
                {bricks}
                <Footer />
                {overlay}
            </div>
        );
    }

}
