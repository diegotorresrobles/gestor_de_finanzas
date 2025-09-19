const body = document.querySelector('BODY');

export function crearOverlay(close = true) {
    const overlay = document.createElement('DIV');
    overlay.classList.add('overlay');
    overlay.id = 'overlay';
    body.appendChild(overlay);

    if(close) {
        overlay.onclick = (e) => {
            if(e.target.id === 'overlay') {
                overlay.remove();
            }
        }
    }
    
    return overlay;
}