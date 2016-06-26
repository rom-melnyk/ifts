import './brick.scss';

import React, { Component } from 'react';

export default class Brick extends Component {
    render() {
        const { id, script, icon, link, description, title, /*body, */classNames } = this.props;
        const _classNames = (['brick', ...classNames]).join(' ');
        return (
            <div className={_classNames} id={id} /*dataAcript={script}*/>
                <a className="transition-background" href={link || `#${id}`} title={description}>
                    <div className="shader transition-opa"></div>
                    <i className={`fa ${icon} transition-transform`} />
                    <span className="brick-title transition-transform">{title}</span>
                </a>
            </div>
        );
    }
}
