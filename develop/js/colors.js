const colors = [ 'purple', 'blue', 'green', 'olive' ]; // @see `css/_skins.scss`

function setSkin(color) {
    if (!color) {
        color = colors[ Math.floor(Math.random() * colors.length) ];
    }

    document.body.className = color;
}

module.exports = { setSkin };
