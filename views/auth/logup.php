<div class="form__contenedor">
    <form method="post" class="form form--logup" autocomplete="off">
        <h1 class="form__name">Iniciar Sesión</h1>
        <div class="form__campos">
            <h3 class="form__campos-name">Información personal</h3>
            <div class="form__campo">
                <input type="nombre" name="nombre" id="nombre" placeholder="." class="form__input">
                <label for="nombre" class="form__label">Nombre</label>
            </div>
            <div class="form__campo">
                <input type="text" name="apellido" id="apellido" placeholder="." class="form__input">
                <label for="apellido" class="form__label">Apellido</label>
            </div>
        </div>
        <div class="form__campos">
            <h3 class="form__campos-name">Información de contacto</h3>
            <div class="form__campo">
                <input type="text" name="email" id="email" placeholder="." class="form__input">
                <label for="email" class="form__label">Correo</label>
            </div>
            <div class="form__campo">
                <input type="tel" name="telefono" id="telefono" placeholder="." class="form__input">
                <label for="telefono" class="form__label">Teléfono</label>
                <ul class="form__reqs">
                    <li class="form__req">10 digitos</li>
                </ul>
            </div>
        </div>
        <div class="form__campos">
            <h3 class="form__campos-name">Credenciales</h3>
            <div class="form__campo">
                <input type="text" name="username" id="username" placeholder="." class="form__input">
                <label for="username" class="form__label">Username</label>
                <ul class="form__reqs">
                    <li class="fomr__req">Letras (mayúsculas, minúsculas)</li>
                    <li class="fomr__req">Numeros (0 al 9)</li>
                    <li class="fomr__req">_ o -</li>
                    <li class="fomr__req">3 a 16 caracteres</li>
                </ul>
            </div>
            <div class="form__campo">
                <input type="password" name="password" id="password" placeholder="." class="form__input">
                <label for="password" class="form__label">Contraseña</label>
                <ul class="form__reqs">
                    <li class="fomr__req">Al menos 8 caracteres</li>
                    <li class="fomr__req">Al menos una letra mayúscula y minúscula</li>
                    <li class="fomr__req">Al menos un número y un carácter especial</li>
                </ul>
            </div>
            <div class="form__campo">
                <input type="password" name="password-confirm" id="password-confirm" placeholder="." class="form__input">
                <label for="password-confirm" class="form__label">Confirmar contraseña</label>
            </div>
        </div>
        <button type="submit" class="form__submit btn">Crear</button>
        <a href="/login" class="form__link">Ya tienes una cuenta? Inicia sesión</a>
    </form>
</div>