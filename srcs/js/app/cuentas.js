import { crearElemento } from "../components/elementos";
import { apiGet, apiPost } from "./api";

export const cuentasSec = document.querySelector('.cuentas');
export const cuentasTable = document.querySelector('.cuentas .table');
const actions = document.querySelectorAll('.cuentas__action');

actions.forEach(action => {
    action.addEventListener('click', actionsCuentas)
});

export function obtnerCuentas() {
    return apiGet('/api/cuentas');
}

export async function mostrarCuentas() {
    const res = await obtnerCuentas();
    const cuentas = res.cuentas;
    console.log(cuentas);
    if(cuentas === null) {
        cuentasTable.classList.add('table--ocultar');
        mostrarAlerta(cuentasSec, 'No hay movimientos, agrega uno!', 'warning');
        return;
    }
    if(cuentas.id) {
        crearCuenta(cuentasTable.querySelector('.table__body'), cuentas);
    } else {
        cuentas.forEach(cuenta => {
            crearCuenta(cuentasTable.querySelector('.table__body'), cuenta);
        });
    }
}

function crearCuenta(ref, cuenta) {
    const tr = crearElemento({
        tipo: 'TR',
        class: 'table__row',
        append: ref
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: cuenta.nombre,
        append: tr
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: cuenta.tipo,
        append: tr
    });
    crearElemento({
        tipo: 'TD',
        class: 'table__col',
        textContent: formatoDinero(cuenta.saldo_actual),
        append: tr
    });
}

export function formatoDinero(monto, moneda = "MXN", locale = "es-MX") {
  return new Intl.NumberFormat(locale, {
    style: "currency",
    currency: moneda,
    minimumFractionDigits: 2,
  }).format(monto);
}

function carrusel() {
    const contenedor = document.querySelector('.cuentas__cuentas');
    // const btnPrev = document.querySelector('.btn-prev');
    // const btnNext = document.querySelector('.btn-next');
    
    // btnNext.addEventListener('click', () => {
    //   contenedor.scrollBy({ left: contenedor.clientWidth * 0.9, behavior: 'smooth' });
    // });
    
    // btnPrev.addEventListener('click', () => {
    //   contenedor.scrollBy({ left: -contenedor.clientWidth * 0.9, behavior: 'smooth' });
    // });
    contenedor.addEventListener('wheel', e => {
        e.preventDefault();
        contenedor.scrollBy({ left: e.deltaY, behavior: 'smooth' });
    });
}

async function actionsCuentas(e) {
    if (e.target.dataset.action === 'create') {
        
    }
}