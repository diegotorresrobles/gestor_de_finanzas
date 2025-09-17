import { apiGet } from './api.js';
import { mostrarAlerta, mostrarAlertaChica } from './../components/alertas.js';
import { crearElemento } from './../components/elementos.js';
import { cerrarModal, crearModal } from './../components/modal.js';
import { formatoDinero, obtnerCuentas } from './../app/cuentas.js';
import { enviarForm } from '../components/forms/forms.js';

const movimientosSec = document.querySelector('.movimientos');
const movimientosTable = document.querySelector('.movimientos .table');
const movimientosBtnAgregar = document.querySelector('.movimientos__action[data-action="create"]');
let cuentas;
let tiposMovimientos;

async function initDatos() {
    const [cuentasRes, tiposRes] = await Promise.all([
        obtnerCuentas(),
        obtenerTiposMovimientos()
    ]);
    cuentas = cuentasRes.cuentas || cuentasRes;
    tiposMovimientos = tiposRes.tipos_movimientos || tiposRes;
}

document.addEventListener('DOMContentLoaded', async () => {
    if (!movimientosSec) return;
    await initDatos();
    await mostrarMovimientos();
});


if(movimientosSec) {
    movimientosBtnAgregar.addEventListener('click', () => {
        cargarFormAgregar();
    });
}

function obtenerMovimientos() {
    return apiGet('/api/movimientos');
}
function obtenerTiposMovimientos() {
    return apiGet('/api/tipos-movimientos');
}

async function mostrarMovimientos() {
    const res = await obtenerMovimientos();
    let movimientos = normalizarLista(res.movimientos);
    cuentas = normalizarLista(cuentas);
    console.log(movimientos)
    if(movimientos[0] === null) {
        mostrarAlerta(movimientosSec, 'No hay movimientos, agrega uno!', 'warning');
        return;
    }
    movimientosTable.classList.remove('table--ocultar');
    movimientos.forEach(movimiento => {
        const cuenta = cuentas.find(c => c.id === movimiento.cuenta);
        const tipo = tiposMovimientos.find(c => c.id === movimiento.tipo);
        const obj = {
            movimiento: movimiento,
            cuenta: cuenta,
            tipo: tipo
        }
        crearMovimiento(movimientosTable.querySelector('.table__body'), obj)
    });
}

function normalizarLista(data) {
  return Array.isArray(data) ? data : [data];
}

function crearMovimiento(ref, obj) {
    const tr = crearElemento({
        tipo: 'TR',
        class: ['table__row', 'movimientos__movimiento'],
        append: ref
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: obj.cuenta.nombre,
        append: tr
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: obj.tipo.nombre,
        append: tr
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: formatoDinero(obj.movimiento.monto),
        dataset: {
            tipo: obj.tipo.nombre.toLowerCase()
        },
        append: tr
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: obj.movimiento.categoria,
        append: tr
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: obj.movimiento.fecha,
        append: tr
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: obj.movimiento.metodo_pago,
        append: tr
    });
    const actions = crearElemento({
        tipo: 'TD',
        class: ['table__col', 'table__actions'],
        append: tr
    });
    crearElemento({
        tipo: 'BUTTON',
        class: ['table__action', 'btn-warning'],
        attrs: {
            type: 'button',
        },
        dataset: {
            id: obj.movimiento.id
        },
        innerHTML: `<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>`,
        events: {
            click: cargarFormUpdate
        },
        append: actions
    });
    crearElemento({
        tipo: 'BUTTON',
        class: ['table__action', 'btn-danger'],
        attrs: {
            type: 'button'
        },
        innerHTML: `<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>`,
        append: actions
    });
}

function cargarFormAgregar() {
    abrirModal();
    const formAgregarMovimientos = document.querySelector('.form--movimientos');
    if(formAgregarMovimientos) {
        cargarTipos();
        cargarCuentas();
        formAgregarMovimientos.addEventListener('submit', e => {
            enviarForm(e, '/api/movimientos', formAgregarMovimientos, 'POST', actualizarMovimientos);
        });
    }
    const formActionClose = document.querySelector('.form__action[data-action="close"]');
    formActionClose.addEventListener('click', cerrarModal);
}

async function cargarFormUpdate(e) {
    const movimiento = await apiGet(`/api/movimientos?id=${e.target.dataset.id}`);
    if (movimiento.status === 'error') {
        cerrarModal();
        const alerta = mostrarAlertaChica(document.querySelector('BODY'), movimiento.message, 'danger');
        setTimeout((() => alerta.remove()), 3000)
        return;
    }
    if(movimiento) {
        abrirModal(movimiento.movimientos);
        const formUpdateMovimientos = document.querySelector('.form--movimientos');
        if(formUpdateMovimientos) {
            cargarTipos(movimiento.movimientos);
            cargarCuentas(movimiento.movimientos);
            formUpdateMovimientos.addEventListener('submit', e => {
                enviarForm(e, '/api/movimientos', formUpdateMovimientos, 'PUT', actualizarMovimientos);
            });
        }
        const formActionClose = document.querySelector('.form__action[data-action="close"]');
        formActionClose.addEventListener('click', cerrarModal);
    }
}

function abrirModal(data) {
    let html;
    if(!data) {
        html = `
        <form class="form form--movimientos">
            <h2 class="form__name">Agregar movimiento</h2>
            <div class="form__campos">
                <div class="form__campo">
                    <label for="monto" class="form__label">Monto</label>
                    <input type="number" name="monto" id="monto" class="form__input">
                </div>
                <div class="form__campo">
                    <label for="tipo" class="form__label">Tipo</label>
                    <select name="tipo" id="tipo" class="form__input form__select">
                        <option value="" class="form__option" disabled selected>-- Seleccionar --</option>
                    </select>
                </div>
                <div class="form__campo">
                    <label for="cuenta" class="form__label">Cuenta</label>
                    <select name="cuenta" id="cuenta" class="form__input form__select">
                        <option value="" class="form__option" disabled selected>-- Seleccionar --</option>
                    </select>
                </div>
                <div class="form__campo">
                    <label for="fecha" class="form__label">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form__input">
                </div>
                <div class="form__campo">
                    <label for="descripcion" class="form__label">Descripcion</label>
                    <textarea type="date" name="descripcion" id="descripcion" data-obligatorio="off" class="form__input form__textarea"></textarea>
                </div>
            </div>
            <div class="form__actions">
                <button type="submit" class="from__action btn-success">Agregar</button>
                <button type="button" data-action="close" class="form__action btn-danger">Cancelar</button>
            </div>
        </form>
        `;
    } else {
        html = `
        <form class="form form--movimientos">
        <input type="text" name="id" id="id" value="${data.id}" class="form__input" hidden>
        <h2 class="form__name">Actualizar movimiento</h2>
        <div class="form__campos">
            <div class="form__campo">
                <label for="monto" class="form__label">Monto</label>
                <input type="number" name="monto" id="monto" value="${data.monto}" class="form__input">
            </div>
            <div class="form__campo">
                <label for="tipo" class="form__label">Tipo</label>
                <select name="tipo" id="tipo" class="form__input form__select">
                    <option value="" class="form__option" disabled selected>-- Seleccionar --</option>
                </select>
            </div>
            <div class="form__campo">
                <label for="cuenta" class="form__label">Cuenta</label>
                <select name="cuenta" id="cuenta" class="form__input form__select">
                    <option value="" class="form__option" disabled selected>-- Seleccionar --</option>
                </select>
            </div>
            <div class="form__campo">
                <label for="fecha" class="form__label">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="${data.fecha}" class="form__input">
            </div>
            <div class="form__campo">
                <label for="categoria" class="form__label">Categoria</label>
                <input type="text" name="categoria" id="categoria" value="${data.categoria}" class="form__input">
            </div>
            <div class="form__campo">
                <label for="metodo_pago" class="form__label">Metodo de pago</label>
                <input type="text" name="metodo_pago" id="metodo_pago" value="${data.metodo_pago}" class="form__input">
            </div>
            <div class="form__campo">
                <label for="descripcion" class="form__label">Descripcion</label>
                <textarea type="date" name="descripcion" id="descripcion" data-obligatorio="off" class="form__input form__textarea">${data.descripcion}</textarea>
            </div>
        </div>
        <div class="form__actions">
            <button type="submit" class="from__action btn-success">Agregar</button>
            <button type="button" data-action="close" class="form__action btn-danger">Cancelar</button>
        </div>
    </form>
    `;
    }
    crearModal(html);
}

function cargarTipos(data) {
    const tiposInput = document.querySelector('.form__input[name="tipo"]');
    if(!data) {
        if (tiposMovimientos.id) {
            crearOption(tiposInput, tiposMovimientos);
        } else {
            tiposMovimientos.forEach(cuenta => {
                crearOption(tiposInput, cuenta);
            });
        }
    } else {
        if (tiposMovimientos.id) {
            crearOption(tiposInput, tiposMovimientos, data);
        } else {
            tiposMovimientos.forEach(tipo => {
                crearOption(tiposInput, tipo, data);
            });
        }
    }
}

function cargarCuentas(data) {
    const cuentasInput = document.querySelector('.form__input[name="cuenta"]');
    if(!data) {
        if (cuentas.id) {
            crearOption(cuentasInput, cuentas);
        } else {
            cuentas.forEach(cuenta => {
                crearOption(cuentasInput, cuenta);
            });
        }
    } else {
        if (cuentas.id) {
            crearOption(cuentasInput, cuentas, data);
        } else {
            cuentas.forEach(cuenta => {
                crearOption(cuentasInput, cuenta, data);
            });
        }
    }
}

function crearOption(ref, obj, data) {
    if(!data) {
        crearElemento({
            tipo: 'OPTION',
            class: 'form__option',
            attrs: {
                value: obj.id
            },
            textContent: obj.nombre,
            append:ref
        });
    } else {
        const option = crearElemento({
            tipo: 'OPTION',
            class: 'form__option',
            attrs: {
                value: obj.id
            },
            textContent: obj.nombre,
            append:ref
        });
        if(obj.id === data.tipo && !data.saldo_actual) {
            option.selected = true;
        }
        if(obj.id === data.cuenta && obj.saldo_actual) {
            option.selected = true;
        }
    }
}

function actualizarMovimientos() {
    cerrarModal();
    const eliminarMovimientosPrevios = () => {
        const movimientos = document.querySelectorAll('.movimientos__movimiento');
        movimientos.forEach(m => {
            m.remove();
        });
    }
    eliminarMovimientosPrevios();
    mostrarMovimientos();
}