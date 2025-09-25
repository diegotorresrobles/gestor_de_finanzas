import { crearAlerta1 } from '../components/alertas.js';
import { enviarForm } from '../components/forms.js';
import { crearModal } from '../components/modals.js';
import { crearOverlay } from '../components/overlay.js';
import { apiGet, apiPost } from './api.js';
import { mostrarCuentas } from './cuentas.js';

const movimientosSection = document.querySelector('.section--movimientos');
const movimientosBtn = document.querySelector('.movimientos__agregar');
const movimientosTable = document.querySelector('.movimientos__table');
let movimientosDiv;
if (movimientosSection) {
    movimientosDiv = document.querySelector('.movimientos');
    movimientosBtn.addEventListener('click', mostrarAgregar);
}

export async function mostrarMovimientos() {
    if(movimientosSection) {
        const res = await apiGet('/api/movimientos');
        if(res.data === null) {
            const alerta = crearAlerta1({
                ref: movimientosDiv,
                mensaje: res.message + 'da click en el boton "Agregar" y agrega uno',
                estado: 'danger'
            });
            movimientosTable.classList.add('ocultar');
        } else {
            if (movimientosDiv.querySelector('.alerta')) {
                movimientosDiv.querySelector('.alerta').remove();
            }
            if(movimientosTable.classList.contains('ocultar')) {
                movimientosTable.classList.remove('ocultar');
            }
            res.data.forEach(m => {
                const movimientoDiv = document.createElement('TR');
                movimientoDiv.classList.add('movimientos__movimiento');

                const formateador = new Intl.NumberFormat('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });
                const monto = document.createElement('TD');
                monto.textContent = formateador.format(m.monto);
                movimientoDiv.appendChild(monto);

                const tipo = document.createElement('TD');
                tipo.textContent = m.tipo === '1' ? 'Ingreso' : 'Gasto';
                movimientoDiv.appendChild(tipo);

                const desc = document.createElement('TD');
                desc.textContent = m.descripcion;
                movimientoDiv.appendChild(desc);

                const fecha = document.createElement('TD');
                fecha.textContent = m.fecha;
                movimientoDiv.appendChild(fecha);

                const del = document.createElement('BUTTON');
                del.classList.add('btn', 'btn--danger');
                del.dataset.id = m.id;
                del.textContent = 'Eliminar';
                del.addEventListener('click', async e => {
                    const data = new FormData;
                    data.append('id', m.id);
                    const res = await apiPost('/api/movimientos', false, 'DELETE', data);
                    if (res.status === 'success') {
                        eliminarMovimientosPre();
                        mostrarMovimientos();
                        eliminarCuentasPre();
                        mostrarCuentas();
                        const overlay = crearOverlay(true);
                        const html = `
                            <div class="modal__icon modal__icon--success">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.25"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
                            </div>
                            <p class="modal__text">${res.message}</p>
                            <button onclick="overlay.remove()" class="modal__action btn">OK</button>
                        `;
                        crearModal(overlay, html);
                    }
                    console.log(res);
                });
                movimientoDiv.appendChild(del);

                movimientosTable.appendChild(movimientoDiv);
                console.log(m);
            });
        }
    }
}

function mostrarAgregar() {
    const overlay = crearOverlay(false);
    const html = `
        <form method="post" class="form form--movimientos" autocomplete="off">
            <h1 class="form__name">Agregar movimiento</h1>
            <div class="form__campo">
                <input type="text" name="monto" id="monto" placeholder="." class="form__input">
                <label for="monto" class="form__label">Monto</label>
            </div>
            <div class="form__campo">
                <select name="tipo" id="tipo" class="form__input">
                    <option selected disabled>-- Seleccionar --</option>
                    <option value="1">Ingreso</option>
                    <option value="2">Gasto</option>
                </select>
                <label for="tipo" class="form__label">Tipo</label>
            </div>
            <div class="form__campo">
                <textarea name="descripcion" id="descripcion" placeholder="." class="form__input"></textarea>
                <label for="descripcion" class="form__label">Descripción</label>
            </div>
            <button type="submit" class="form__submit btn">Crear</button>
        </form>
        <button onclick="overlay.remove()" class="modal__action btn btn--danger">Cerrar</button>
    `;
    crearModal(overlay, html);

    agregarMovimiento();
}
async function agregarMovimiento() {
    const form = document.querySelector('.form--movimientos');
    form.addEventListener('submit', async e => {
        const res = await enviarForm(e, '/api/movimientos', form);
        if(res.status === 'success') {
            eliminarMovimientosPre();
            mostrarMovimientos();
            eliminarCuentasPre();
            mostrarCuentas();
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
        }
    });
}

function eliminarMovimientosPre() {
    const movimientos = document.querySelectorAll('.movimientos__movimiento');
    if(movimientos.length >= 1) {
        movimientos.forEach(m => {
            m.remove();
        });
    }
}
function eliminarCuentasPre() {
    const cuentas = document.querySelectorAll('.cuentas__cuenta');
    if(cuentas.length >= 1) {
        cuentas.forEach(c => {
            c.remove();
        });
    }
}