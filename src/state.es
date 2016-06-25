const listeners = [];

const state = {
    bricks: null,
    overlay: null
};


export function getState() {
    return state;
}


export function addChangeListener(callback) {
    if (listeners.indexOf(callback) === -1 && typeof callback === 'function') {
        listeners.push(callback);
    }
}


export function removeChangeListener(callback) {
    const index = listeners.indexOf(callback);
    if (index !== -1) {
        listeners.splice(index, 1);
    }
}


export function getValue(path) {
    const keys = path.split('.');
    let branch = state;
    for (let i = 0; i < keys.length; i++) {
        const key = keys[i];
        branch = branch[key];
        if (branch === undefined) {
            return branch;
        }
    }

    return branch;
}


const NUMBER_MASK = /^\d+$/;

export function updateState(path, value) {
    // normalize the path
    const keys = path.split('.').map((key) => {
        if (NUMBER_MASK.test(key)) {
            key = parseInt(key, 10);
        }
        return key;
    });

    // crawl down the path
    let branch = state;
    keys.forEach((key, idx) => {
        // set the value
        if (idx === keys.length - 1) {
            branch[key] = value;
            return;
        }

        // prepare the path if not crawlable
        if (typeof branch[key] !== 'object' || typeof branch[key] !== 'function') {
            if (keys[idx + 1].constructor === Number) {
                branch[key] = [];
            } else {
                branch[key] = {};
            }
        }

        // crawl further
        branch = branch[key];
    });
    branch = null;

    listeners.forEach((listener) => {
        listener(state);
    });
}
