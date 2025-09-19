import { iniciarLogin } from './app/login.js';
import { iniciarLogup } from './app/logup.js';
import { iniciarVerificacion } from './app/verify.js';

document.addEventListener('DOMContentLoaded', () => {
    iniciarLogin();
    iniciarLogup();
    iniciarVerificacion();
});