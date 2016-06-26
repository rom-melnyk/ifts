import './brick.scss';

import React, { Component } from 'react';

export default class Brick extends Component {
    render() {
        const { id, icon, title, description, link, width, color } = this.props;
        const className = `brick column-${width} color-${color}`;

        return (
            <div className={className} id={id}>
                <a className="transition-background" href={link || `#${id}`} title={description}>
                    <div className="shader transition-opa"></div>
                    <i className={`fa ${icon} transition-transform`} />
                    <span className="brick-title transition-transform">{title}</span>
                </a>
            </div>
        );
    }
}
