import './overlay.scss';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { closeOverlay } from '../../../actions.es'

export default class Overlay extends Component {
    componentDidMount() {
        const node = ReactDOM.findDOMNode(this);
        console.log(node);
    }

    render() {
        const { title, body, animate } = this.props;
        const classNames = 'overlay-window' + (animate && ' transition-trigger' || '');

        return (
            <div className={classNames}>
                <div className="ovr-shader transition-opa"></div>
                <div className="ovr-container transition-opa">
                    <div className="ovr-header">
                        <a className="ovr-back" href="javascript://"><i className="fa fa-angle-left icon-l" /><span className="ovr-back-text">на головну</span></a>
                        <span className="ovr-title">{title}</span>
                    </div>
                    <div className="ovr-content" dangerouslySetInnerHTML={{__html: body}}></div>
                </div>
            </div>
        );
    }
}
