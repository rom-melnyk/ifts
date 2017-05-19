const { setSkin } = require('./skins');

const IFTS = {
    start: () => {
        setSkin();
        facebook.run();
    },
    setSkin,
};

if (window) {
    window.IFTS = IFTS;
} else {
    module.exports = IFTS
}
