<form method="POST" class="form form--logup">
    <div class="form__contenedor">
        <h1 class="form__name">Crear Cuenta</h1>
        <div class="form__campos">
            <h3 class="paso__titulo">Información personal</h3>
            <div class="form__campo">
                <label for="nombre" class="form__label">Nombre(s)</label>
                <input type="text" name="nombre" id="nombre" class="form__input">
            </div>
            <div class="form__campo">
                <label for="apellido" class="form__label">Apellido(s)</label>
                <input type="text" name="apellido" id="apellido" class="form__input">
            </div>
            <h3 class="paso__titulo">Información de contacto</h3>
            <div class="form__campo">
                <label for="email" class="form__label">Correo</label>
                <input type="email" name="email" id="email" class="form__input">
            </div>
            <div class="form__campo">
                <label for="telefono" class="form__label">Teléfono</label>
                <input type="tel" name="telefono" id="telefono" class="form__input">
            </div>
            <h3 class="paso__titulo">Seleccion de credenciales</h3>
            <div class="form__campo">
                <label for="username" class="form__label">Usuario</label>
                <input type="text" name="username" id="username" autocapitalize="off" class="form__input">
            </div>
            <div class="form__campo">
                <label for="password" class="form__label">Contraseña</label>
                <input type="password" name="password" id="password" autocapitalize="off" class="form__input">
            </div>
            <div class="form__campo">
                <label for="password-confirm" class="form__label">Confirmar contraseña</label>
                <input type="password" name="password-confirm" id="password-confirm" autocapitalize="off" class="form__input">
            </div>
            <!-- <div class="paso__nav">
                <button type="button" class="paso__btn paso__btn--anterior paso__btn--ocultar">Anterior</button>
                <button type="button" class="paso__btn paso__btn--siguiente">Siguiente</button>
            </div> -->
        </div>
        <button class="form__submit">Crear Cuenta</button>
        <a href="/login" class="form__link">Ya tienes una cuenta? Inicia sesión</a>
    </div>
</form>