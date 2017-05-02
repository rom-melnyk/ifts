const { writeBackgoundStyle } = require('./background-texture');

const IFTS = {
    start: () => {
        writeBackgoundStyle();
    }
};

if (window) {
    window.IFTS = IFTS;
} else {
    module.exports = IFTS
}
