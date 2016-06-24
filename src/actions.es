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
            };
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