import React, { Component } from 'react';

export default class Brick extends Component {
    render() {
        const { id, script, icon, link, description, title, /*body, */classNames } = this.props;
        const _classNames = (['brick', ...classNames]).join(' ');
        return (
            <div className={_classNames} id={id} /*dataAcript={script}*/>
                <a className="brick-link" href={link || `#${id}`} title={description}>
                    <div className="brick-int-wrapper transition-bg-color-5">
                        <i className={`fa icon-xl ${icon}`} /><span className="brick-descr">{title}</span>
                    </div>
                </a>
            </div>
        );
    }
}
