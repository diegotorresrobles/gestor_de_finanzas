import { crearModal } from '../components/modals.js';
import { crearOverlay } from '../components/overlay.js';
import { apiGet, apiPost } from './api.js';

const verify = document.querySelector('#verify');

export function iniciarVerificacion() {
    if(window.location.pathname === '/account-verify') {
        const get = window.location.search;
        const parametros = new URLSearchParams(get);
        verificar(parametros.get('token'));
    }
}

async function verificar(token) {
    const res = await apiGet(`/api/account-verify?token=${token}`);
    console.log(res);

    if(res.status === 'error') {
        const overlay = crearOverlay();
        const html = `
            <div class="modal__icon modal__icon--danger">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.25"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" /><path d="M9 8l6 8" /><path d="M15 8l-6 8" /></svg>
            </div>
            <p class="modal__text">${res.message}</p>
            <a href="/" class="modal__action btn">Volver</a>
        `;
        crearModal(overlay, html);
    } else {
        const overlay = crearOverlay();
        const html = `
            <div class="modal__icon modal__icon--success">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.25"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
            </div>
            <p class="modal__text">${res.message}</p>
            <a href="/login" class="modal__action btn">OK</a>
        `;
        crearModal(overlay, html);
    }
}