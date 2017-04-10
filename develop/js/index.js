const test = require('./test');

const IFTS = {
    start: () => {
        console.info(`IFTS ${test}!`);
    }
};

if (window) {
    window.IFTS = IFTS;
} else {
    module.exports = IFTS
}
