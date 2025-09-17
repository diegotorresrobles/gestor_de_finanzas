import {  } from './app/imagenes.js';
import {  } from './app/auth/logup.js';
import {  } from './app/auth/login.js';
import { dropdownBtn, alternarDropdow } from './components/aside.js';
import {  } from './components/modal.js';
import {  } from './app/profile.js';
import { cuentasSec, mostrarCuentas } from './app/cuentas.js';
import {  } from './app/movimientos.js';

document.addEventListener('DOMContentLoaded', () => {
    iniciarApp();
});

function iniciarApp() {
    eventos();
}

function eventos() {
    if(dropdownBtn.length > 0) {
        dropdownBtn.forEach(btn => {
            btn.addEventListener('click', alternarDropdow)
        });
    }
    if(cuentasSec) {
        mostrarCuentas();
    }
}