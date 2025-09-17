import { apiPost, apiPut } from "./../../app/api";
import { limpiarAlerta, mostrarAlerta, mostrarAlertaChica } from "./../alertas";
// import { pasos, iniciarPasos } from './pasos.js';
import { cerrarModal } from './../modal.js';

const form = document.querySelector('.form');
const modal = document.querySelector('.modal');
let inputs = document.querySelectorAll('.form__input');
export const formSubmitBtn = document.querySelector('.form__submit');

document.addEventListener('DOMContentLoaded', () => {
    // if(pasos.length > 0) {
    //     inputs = document.querySelectorAll('.paso--activo .form__input');
    //     iniciarPasos();
    // }
    if(modal) {
        const formBtnCerrar = modal.querySelector('.form__action[data-action="close"]');
        formBtnCerrar.addEventListener('click', cerrarModal);
    }
});

export async function enviarForm(e, url, form, method = 'POST', func = null) {
    e.preventDefault();
    validarInputs();
    const alertas = document.querySelector('.form .alerta') ?? false;
    if(alertas) return;
    const data = new FormData(form);
    if(method !== 'POST') {
        data.append('_method', method);
    }
    const res = await apiPost(url, data);
    if(res.status === 'ok') {
        if(res.redireccionar) {
            window.open(res.redireccionar, '_self');
        }
        if(func) {
            func();
        }
        const alerta = mostrarAlertaChica(document.querySelector('BODY'), res.message, 'success');
        setTimeout((() => {
            alerta.remove();
        }), 3000);
    } else {
        const errores = res.errors;
        for (let i = 0; i < Object.keys(errores).length; i++) {
            const campoDiv = document.querySelector(`.form__input[name="${Object.keys(errores)[i]}"]`).parentElement;
            mostrarAlerta(campoDiv, Object.values(errores)[i], 'danger');
        }
    }
}

export function validarInputs() {
    inputs.forEach(campo => {
        const campoDiv = campo.parentNode;
        if(campo.value === '' && campo.dataset.obligatorio !== 'off') {
            mostrarAlerta(campoDiv, `El campo no puede ir vacio`, 'danger');
        } else {
            limpiarAlerta(campoDiv);
        }
        if(campo.value !== '' && campo.name === 'email') {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const isValid = (email) => {
                return regex.test(email);
            };
            if(!isValid(campo.value)) {
                mostrarAlerta(campoDiv, `El email no es valido`, 'danger');
            } else {
                limpiarAlerta(campoDiv);
            }
        }
        if(campo.value !== '' && campo.name === 'telefono') {
            const regex = /^\(?(\d{3})\)?[-.\s]?(\d{3})[-.\s]?(\d{4})$/;
            const isValid = (tel) => {
                return regex.test(tel);
            }
            if(!isValid(campo.value)) {
                mostrarAlerta(campoDiv, `El telefono no es valido`, 'danger');
            } else {
                limpiarAlerta(campoDiv);
            }
        }
        if(campo.value !== '' && campo.name === 'username' && form.classList.contains('form--logup')) {
            const regex = /^[A-Za-z][A-Za-z0-9_]{4,19}$/;
            const isValid = (username) => {
                return regex.test(username);
            }
            if(!isValid(campo.value)) {
                mostrarAlerta(campoDiv, `El nombre de usuario no debe empezar con numeros, debe tener 5 a 20 caracteres, solo se puede usar "_"(guiones bajos)`, 'danger');
            } else {
                limpiarAlerta(campoDiv);
            }
        }
        if(campo.value !== '' && campo.name === 'password' && form.classList.contains('form--logup')) {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s])\S{8,64}$/;
            const isValid = (pwd) => {
                return regex.test(pwd);
            }
            if(!isValid(campo.value)) {
                mostrarAlerta(campoDiv, `La cantraseña debe tener de 8 a 64 caracteres y al menos: 1 minúscula, 1 mayúscula, 1 dígito y 1 símbolo`, 'danger');
            } else {
                limpiarAlerta(campoDiv);
            }
        }
        if(campo.value !== '' && campo.name === 'password-confirm') {
            if(document.querySelector('#password').value !== campo.value) {
                mostrarAlerta(campoDiv, `Las cantraseñas no coinciden`, 'danger');
            } else {
                limpiarAlerta(campoDiv);
            }
        }
    });
}