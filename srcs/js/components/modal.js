import { crearElemento } from './elementos.js';

window.addEventListener('keydown', e => {
    if(e.key === 'Escape') {
        const modal = document.querySelector('.modal');
        if(modal) {
            cerrarModal();
        }
    }
});

export function crearModal(html) {
    const overlay = crearElemento({
        tipo: 'DIV',
        class: 'overlay',
        events: {
            click: e => {if(e.target === overlay) cerrarModal()}
        },
        append: document.querySelector('BODY')
    });
    crearElemento({
        tipo: 'DIV',
        class: 'modal',
        innerHTML: html,
        append: overlay
    });
}

export function abrirModal() {
    crearModal();
}

export function cerrarModal(e) {
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.overlay');
    if(modal) {
        modal.remove();
        overlay.remove();
    }
}