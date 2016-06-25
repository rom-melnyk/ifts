import { random } from './utils/utils.es';
import Constants from './constants.es';

import bricks from './pages/list.json';

const bodies = {};

// HTML files: dynamic require
bricks.forEach((brick) => {
    if (brick.body) {
        try {
            bodies[brick.body] = require.context('./pages', false, /^\.\/.+\.html$/)(`./${brick.body}.html`);
        } catch (e) {
            throw new Error(`Failed to import "pages/${brick.body}.html". Make sure the file exists.`);
        }
    }
});

export function getBricksData() {
    // 2 for small screens; 4 for wide screens
    const maxWidthInRow = (window.innerWidth || document.clientWidth || document.body.clientWidth) > Constants.MIN_WIDTH_FOR_4_COLUMNS ? 4 : 2;
    let totalWidthInRow = 0;

    return bricks.map((brick, idx) => {
        const newBrick = {};

        for (let key in brick) {
            newBrick[key] = brick[key];
        }

        // ------ calculating brick width ------
        let width;

        if (totalWidthInRow >= maxWidthInRow) {
            totalWidthInRow = 0;
        }
        if (idx === bricks.length - 1) {
            width = maxWidthInRow - totalWidthInRow;
        } else {
            width = random(1, maxWidthInRow - totalWidthInRow);
        }
        totalWidthInRow += width;

        // ------ setting additional brick attribs ------
        newBrick.id = newBrick.body || (idx + ''); // human-friendly link if possible

        newBrick.classNames = [
            `column-${width}`,
            `color-${random(0, Constants.MAX_COLORS - 1)}`
        ];

        if (!newBrick.link) {
            newBrick.link = `#${idx}`;
        }

        if (newBrick.body) {
            newBrick.body = bodies[newBrick.body] || `The file ${newBrick.body} is not included properly!`;
        }

        return newBrick;
    });
}
