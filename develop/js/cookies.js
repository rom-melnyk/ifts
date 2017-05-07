function getCookie(name) {
    const cname = name + '=';
    const decodedCookies = decodeURIComponent(document.cookie).split(';');
    for (let i = 0; i < decodedCookies.length; i++) {
        let c = decodedCookies[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(cname) === 0) {
            return c.substring(cname.length, c.length);
        }
    }
    return '';
}

function setCookie(name, value, exdays = 30, path = '/') {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${d.toUTCString()}; path=${path}`;
}

module.exports = { getCookie, setCookie };
