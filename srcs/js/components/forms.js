import { crearAlerta } from './alertas.js';
import { apiGet, apiPost } from './../app/api.js';

export const form = document.querySelector('.form');
let alertas = null;

export async function enviarForm(e, url, data) {
    e.preventDefault();
    validarInputs();
    alertas = document.querySelectorAll('.alerta');
    if(alertas.length > 0) return;
    const res = await apiPost(url, data);
    if(res.status === 'error') {
        const errores = res.data.alertas.error;
        Object.entries(errores).forEach(([key, value]) => {
            const input = form.querySelector(`.form__input[name='${key}']`);
            crearAlerta(input.parentElement, 'danger', 'baner', value);
        });
    }
    return res;
}

function validarInputs() {
    const inputs = form.querySelectorAll('.form__input');
    inputs.forEach(input => {
        
        const id = input.id;
        const value = input.value;
        const alerta = input.parentElement.querySelector('.alerta');

        if(value === '') {
            crearAlerta(input.parentElement, 'danger', 'baner', 'El campo no debe ir vacio');
        } else {
            if(alerta) {
                alerta.remove();
            }
        }
        if(form.classList.contains('form--logup')) {
            validarLogup(id, value, alerta, input);
        }
    });
}

function validarLogup(id, value, alerta, input) {
    if (value !== '' && id === 'email') {
        const email = valdiarEmail(value);
        if(!email) {
            crearAlerta(input.parentElement, 'danger', 'baner', 'El correo no es valido');
        } else {
            if(alerta) {
                alerta.remove();
            }
        }
    }
    if (value !== '' && id === 'telefono') {
        const telefono = valdiarTelefono(value);
        if(!telefono) {
            crearAlerta(input.parentElement, 'danger', 'baner', 'El teléfono no es valido');
        } else {
            if(alerta) {
                alerta.remove();
            }
        }
    }
    if (value !== '' && id === 'username') {
        const username = valdiarUsername(value);
        if(!username) {
            crearAlerta(input.parentElement, 'danger', 'baner', 'El username no es valido');
        } else {
            if(alerta) {
                alerta.remove();
            }
        }
    }
    if (value !== '' && id === 'password') {
        const password = valdiarPassword(value);
        if(!password) {
            crearAlerta(input.parentElement, 'danger', 'baner', 'La contraseña no es valida');
        } else {
            if(alerta) {
                alerta.remove();
            }
        }
    }
    if (value !== '' && id === 'password-confirm') {
        if(value !== document.querySelector('#password').value) {
            crearAlerta(input.parentElement, 'danger', 'baner', 'Las contraseñas no coinciden');
        } else {
            if(alerta) {
                alerta.remove();
            }
        }
    }
}

function valdiarEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}
function valdiarTelefono(tel) {
    const telRegex = /^\d{10}$/;
    return telRegex.test(tel);
}
function valdiarUsername(usr) {
    const usrRegex =  /^[a-zA-Z0-9_-]{3,16}$/;
    return usrRegex.test(usr);
}
function valdiarPassword(pwd) {
    const pwdRegex =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?.&])[A-Za-z\d@$!%*?.&]{8,}$/;
    return pwdRegex.test(pwd);
}