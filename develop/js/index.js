const { setSkin } = require('./skins');
const facebook = require('./facebook');

const IFTS = {
    start: () => {
        setSkin();
        facebook.run();
    },
    setSkin,
    facebook
};

if (window) {
    window.IFTS = IFTS;
} else {
    module.exports = IFTS
}
