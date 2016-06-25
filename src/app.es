import './style.scss';

import React from 'react';
import ReactDOM from 'react-dom';
import Main from './views/main.es';

import { getBricksData } from './bricks.es';
import { openOverlay } from './actions.es';
import { updateState } from './state.es';


updateState('bricks', getBricksData());
window.IFTS = {
    runApp: () => {
        const appContainer = document.createElement('div');
        appContainer.className = 'application-container';
        document.body.appendChild(appContainer);

        ReactDOM.render(<Main />, appContainer);
    }
};

// ------ location handling ------
window.addEventListener('hashchange', () => {
    const id = window.location.hash.substr(1);
    openOverlay(id);
}, false);
