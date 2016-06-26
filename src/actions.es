import { getValue, updateState } from './state.es';

export function openOverlay(id) {
    const bricks = getValue('bricks') || [];
    const brick = bricks.find(brk => brk.id === id);
    if (brick) {
        updateState('overlay', {
            body: brick.body,
            title: brick.description,
            animate: true
        });
    }

    // window.setTimeout(() => {
    //     IFTS.overlay.animate = false;
    //     triggerUpdate();
    // }, 250);
}


export function stopAnimateOverlay() {
    updateState('overlay.animate', true);
}


export function closeOverlay() {
    updateState('overlay.animate', true);
}


export function easterEgg() {
    (function () {
        // ------------ config area ------------
        var keyToleranceInterval = 750;
        var urls = {
            '3004': 'https://www.facebook.com/betty.milton.12'
        };

        // ------------ logic ------------
        var buffer = '';
        var timeoutId = null;

        function scanUrls (str) {
            var keys = Object.keys(urls);
            for (var i = 0; i < keys.length; i++) {
                if (keys[i] === str) { return true; }
            }
            return false;
        }

        function debounceKeypress () {
            if (scanUrls(buffer)) {
                window.location = urls[buffer];
            } else {
                buffer = '';
            }
        }

        function onKeypress (event) {
            var char = String.fromCharCode(event.keyCode).toLowerCase();
            buffer += char;
            clearTimeout(timeoutId);
            timeoutId = setTimeout(debounceKeypress, keyToleranceInterval);
            event.preventDefault();
        }

        document.addEventListener('keypress', onKeypress, false);
    })();
}