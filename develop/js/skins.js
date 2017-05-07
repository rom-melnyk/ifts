const { getCookie, setCookie } = require('./cookies');

const SKINS = [ 'purple', 'blue', 'green', 'olive' ]; // @see `css/_skins.scss`
const COOKIE_NAME = 'skin';

function setSkin(skin) {
    if (!skin) {
        skin = getCookie(COOKIE_NAME);
        if (SKINS.indexOf(skin) === -1) {
            skin = SKINS[ Math.floor(Math.random() * SKINS.length) ];
        }
    }

    setCookie(COOKIE_NAME, skin);
    SKINS.forEach((s) => {
        const method = s === skin ? 'add' : 'remove';
        document.body.classList[method](s);
    });
}

module.exports = { setSkin };
