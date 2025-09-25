import { enviarForm } from '../components/forms.js';
import { crearModal } from '../components/modals.js';
import { crearOverlay } from '../components/overlay.js';
import { apiGet } from './api.js';

const cuentasSection = document.querySelector('.section--cuentas');
let cuentasDiv;
if(cuentasSection) {
    cuentasDiv = cuentasSection.querySelector('.cuentas');
}
function obtenerCuentas() {
    return apiGet('/api/cuentas');
}

export async function mostrarCuentas() {
    if(cuentasSection) {
        const res = await obtenerCuentas();
        if(res.status === 'error') {
            crearCuenta();
        } else {
            const cuentaDiv = document.createElement('TR');
            cuentaDiv.classList.add('cuentas__cuenta');

            const nombre = document.createElement('TD');
            nombre.textContent = res.data.nombre;
            cuentaDiv.appendChild(nombre);

            const formateador = new Intl.NumberFormat('es-MX', {
                style: 'currency',
                currency: 'MXN'
            });
            const saldo = document.createElement('TD');
            saldo.textContent = formateador.format(res.data.saldo_actual);
            cuentaDiv.appendChild(saldo);

            const cuentasTable = document.querySelector('.cuentas__table');
            cuentasTable.appendChild(cuentaDiv);
        }
    }
}

async function crearCuenta() {
    const overlay = crearOverlay(false);
    const html = `
        <div class="modal__icon modal__icon--success">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.25"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-input-spark"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 22.5a4.75 4.75 0 0 1 3.5 -3.5a4.75 4.75 0 0 1 -3.5 -3.5a4.75 4.75 0 0 1 -3.5 3.5a4.75 4.75 0 0 1 3.5 3.5" /><path d="M20 11.5v-2.5a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v5a2 2 0 0 0 2 2h7" /></svg>
        </div>
        <p class="modal__text">Crea una cuenta para comenzar a usar la app</p>
        <button class="modal__action btn">Crear</button>
    `;
    crearModal(overlay, html);
    const btn = document.querySelector('.modal__action.btn');
    btn.onclick = e => {
        document.querySelector('.overlay').remove();
        const overlay = crearOverlay(false);
        const html = `
            <form method="post" class="form form--cuentas" autocomplete="off">
                <h1 class="form__name">Crear Cuenta</h1>
                <div class="form__campo">
                    <input type="text" name="nombre" id="nombre" placeholder="." class="form__input">
                    <label for="nombre" class="form__label">Nombre</label>
                </div>
                <div class="form__campo">
                    <select name="tipo" id="tipo" class="form__input">
                        <option selected disabled>-- Seleccionar --</option>
                        <option value="1">Efectivo</option>
                    </select>
                    <label for="tipo" class="form__label">Tipo</label>
                </div>
                <button type="submit" class="form__submit btn">Crear</button>
            </form>
        `;
        crearModal(overlay, html);
        const form = document.querySelector('.form--cuentas');
        console.log(form);
        form.addEventListener('submit', async e => {
            const res = await enviarForm(e, '/api/cuentas', form);
            if(res.status === 'error') {
                const overlay = crearOverlay(false);
                const html = `
                    <div class="modal__icon modal__icon--danger">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.25"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" /><path d="M9 8l6 8" /><path d="M15 8l-6 8" /></svg>
                    </div>
                    <p class="modal__text">${res.message}</p>
                    <button onclick="overlay.remove()" class="modal__action btn">OK</button>
                `;
                crearModal(overlay, html);
            } else {
                document.querySelector('.overlay').remove();
                const overlay = crearOverlay(true);
                const html = `
                    <div class="modal__icon modal__icon--success">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.25"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
                    </div>
                    <p class="modal__text">${res.message}</p>
                    <button onclick="overlay.remove()" class="modal__action btn">OK</button>
                `;
                crearModal(overlay, html);
                mostrarCuentas();
            }
        });
    }
}