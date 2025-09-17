import { enviarForm } from "../components/forms/forms.js";
import { apiDelete, apiGet, apiPost } from "./api.js";

const form = document.querySelector('.form--account');
const formSubmitBtn = document.querySelector('.form__submit');
const formActualizarBtn = document.querySelector('.form__accion[data-accion="actualizar"]');
const formEliminarBtn = document.querySelector('.form__accion[data-accion="eliminar"]');
let inputs;
let edicion = false;

if(form) {
    inputs = form.querySelectorAll('.form__input');
    document.addEventListener('DOMContentLoaded', () => {
        mostrarInfoUser();
    });
    
    form.addEventListener('submit', (e) => enviarForm(e , '/api/profile', form, 'PUT', a));

    if(formActualizarBtn) {
        formActualizarBtn.addEventListener('click', modoEdicion);
    }
    if(formEliminarBtn) {
        formEliminarBtn.addEventListener('click', eliminarUser);
    }
}

async function obtenerUser() {
    return apiGet('/api/profile');
}
function a() {
    mostrarInfoUser();
    modoEdicion();
}
async function mostrarInfoUser() {
    const info = await obtenerUser();
    let valores = []
    Object.entries(info).forEach(([key, value]) => {
        valores[key] = value;
    });
    inputs.forEach(input => {
        input.disabled = true;
        if(input.name === 'password') input.hidden = true;
        if(valores[input.name]) {
            input.value = valores[input.name];
        }
    });
}

function modoEdicion(e) {
    if(!edicion) {
        edicion = true;
        formSubmitBtn.classList.remove('form__submit--ocultar');
        formActualizarBtn.textContent = 'Deshacer cambios';
        inputs.forEach(input => {
            input.disabled = false;
            if(input.name === 'password') {
                if(input.hidden) {
                    input.nextElementSibling.hidden = false;
                    input.nextElementSibling.classList.add('btn-warning');
                }
                input.nextElementSibling.addEventListener('click', (e) => {
                    input.value = '';
                    input.hidden = false;
                    input.nextElementSibling.hidden = true;
                    input.nextElementSibling.classList.remove('btn-warning');
                });
            }
        });
    } else {
        edicion = false;
        formSubmitBtn.classList.add('form__submit--ocultar');
        formActualizarBtn.textContent = 'Actualizar';
        inputs.forEach(input => {
            if(input.name === 'password') {
                if(input.hidden) {
                    input.nextElementSibling.hidden = true;
                    input.nextElementSibling.classList.remove('btn-warning');
                }
            }
        });
        mostrarInfoUser();
    }
}

async function eliminarUser() {
    const res = await apiDelete('/api/profile');
    if(res.resultado) {

    } else {

    }
}