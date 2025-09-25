import { mostrarCuentas } from './app/cuentas.js';
import { iniciarLogin } from './app/login.js';
import { iniciarLogup } from './app/logup.js';
import { mostrarMovimientos } from './app/movimientos.js';
import { cargarTtheme } from './app/theme.js';
import { iniciarVerificacion } from './app/verify.js';

document.addEventListener('DOMContentLoaded', () => {
    cargarTtheme();
    iniciarLogin();
    iniciarLogup();
    iniciarVerificacion();
    mostrarCuentas();
    mostrarMovimientos();
});