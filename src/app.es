import './style.scss';

import React from 'react';
import ReactDOM from 'react-dom';
import Main from './views/main.es';

window.IFTS = {
    brick: {},
    ui: {
        $overlay: {}, // is set dynamically after document is ready;
        backgrounds: [] // is set dynamically in backgrounds.js
    },

    runApp: () => {
        const appContainer = document.createElement('div');
        appContainer.className = 'application-container';
        document.body.appendChild(appContainer);

        ReactDOM.render(<Main />, appContainer);
    }
};
