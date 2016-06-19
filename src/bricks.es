import { random } from './utils/utils.es';
import Constants from './constants.es';

import bricks from './pages/list.json';
// HTML files
import body_01_ifts from './pages/01-ifts.html';
import body_02_map from './pages/02-map.html';
import body_03_photo from './pages/03-photo.html';
import body_09_partners from './pages/09-partners.html';

const bodies = {
    '01-ifts': body_01_ifts,
    '02-map': body_02_map,
    '03-photo': body_03_photo,
    '09-partners': body_09_partners
};

export function updateBricksData() {
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
        newBrick.id = idx;

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

// ------ location handling ------
// var locHash = window.location.hash.substr(1);
// if (locHash) {
//     $('#' + locHash).find('.brick-link').trigger('click', [{}]);
// }

// window.addEventListener("hashchange", funcRef, false);
