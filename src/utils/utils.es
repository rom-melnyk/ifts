/**
 * @param {Number} from
 * @param {Number} [to]             if omitted, function returns [0 .. `from`]
 * @return {Number}                 the Integer in the range [`from` .. `to`]
 */
export function random(from, to) {
    if (to === undefined) {
        to = from;
        from = 0;
    }
    return Math.floor(Math.random() * (to - from + 1)) + from;
}
