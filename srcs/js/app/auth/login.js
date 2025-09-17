import { enviarForm } from "../../components/forms/forms.js";

const formLogin = document.querySelector('.form--login');
if(formLogin) {
    formLogin.addEventListener('submit', (e) => enviarForm(e , '/api/login', formLogin));
}