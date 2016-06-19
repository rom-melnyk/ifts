import React, { Component } from 'react';

export default class Brick extends Component {
    render() {
        const { id, script, icon, link, action, description, title, body } = this.props;
        return (
            <div className="brick" id={id} /*dataAcript={script}*/>
                <a className="brick-link" href={link} /*dataAction={action}*/ title={description}>
                    <div className="brick-int-wrapper transition-bg-color-5">
                        <i className={`fa icon-xl ${icon}`} /><span className="brick-descr">{title}</span>
                    </div>
                </a>
            <div className="brick-content" style="display: none;">{body}</div>
        </div>
        );
    }
}
