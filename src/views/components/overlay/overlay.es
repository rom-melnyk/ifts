import './overlay.scss';

import React, { Component } from 'react';
import { closeOverlay } from '../../../actions.es'

const BACK_BUTTON = 'back-button';

export default class Overlay extends Component {
    componentDidMount() {
        const backButton = this.refs[BACK_BUTTON];
        if (backButton) {
            backButton.onclick = closeOverlay;
        }
    }

    render() {
        const { title, body, color, animate } = this.props;
        const className = `overlay-window color-${color} ${animate && 'transition-trigger' || ''}`;

        return (
            <div className={className}>
                <div className="ovr-shader transition-opa"></div>
                <div className="ovr-container transition-opa">
                    <div className="ovr-header">
                        <a className="ovr-back" href="javascript://" ref={BACK_BUTTON}>
                            <i className="fa fa-angle-left icon-l" />
                            <span className="ovr-back-text">на головну</span>
                        </a>
                        <span className="ovr-title">{title}</span>
                    </div>
                    <div className="ovr-content" dangerouslySetInnerHTML={{__html: body}}></div>
                </div>
            </div>
        );
    }
}
