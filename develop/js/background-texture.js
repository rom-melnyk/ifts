// background-color: #026873;
// background-image: linear-gradient(90deg, rgba(255,255,255,.07) 50%, transparent 50%),
// linear-gradient(90deg, rgba(255,255,255,.13) 50%, transparent 50%),
// linear-gradient(90deg, transparent 50%, rgba(255,255,255,.17) 50%),
// linear-gradient(90deg, transparent 50%, rgba(255,255,255,.19) 50%);
// background-size: 13px, 29px, 37px, 53px;

const backgrounds = [
    { a: .006, size: 13 },
    { a: .026, size: 29 },
    { a: .034, size: 37 },
    { a: .038, size: 53 },
]

function getGradient({ h = 0, s = 0, l = 100, a = .05 }) {
    return `linear-gradient(90deg, hsla(${h},${s}%,${l}%,${a}) 50%, transparent 50%)`;
}

function getBackgroundImage() {
    const gradients = backgrounds.map(getGradient).join(', ');
    return `background-image: ${gradients};`;
}

function getBackgroundSize() {
    const sizes = backgrounds.map(bg => `${bg.size}px`).join(', ');
    return `background-size: ${sizes};`
}

function writeBackgoundStyle() {
    const styleText = `body {
  /*background-color: #026873;*/
  ${getBackgroundImage()}
  ${getBackgroundSize()}
}`;
    const styleEl = document.createElement('style');
    styleEl.innerHTML = styleText;
    document.body.insertBefore(styleEl, document.body.children[0]);
}

module.exports = { writeBackgoundStyle };
