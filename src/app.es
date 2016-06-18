import React from 'react';
import ReactDOM from 'react-dom';
import Main from './views/main.es';

window.IFTS = {
    runApp: () => {
        const appContainer = document.createElement('div');
        appContainer.className = 'application-container';
        document.body.appendChild(appContainer);

        ReactDOM.render(<Main />, appContainer);
    }
};

