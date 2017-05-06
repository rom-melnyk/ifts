const { setSkin } = require('./colors');

const IFTS = {
    start: () => {
        setSkin();
    },
    setSkin
};

if (window) {
    window.IFTS = IFTS;
} else {
    module.exports = IFTS
}
