<form method="post" class="form form--login">
    <div class="contenedor form__contenedor">
        <h1 class="form__name">Iniciar Sesión</h1>
        <div class="form__campos">
            <div class="form__campo">
                <label for="username" class="form__label">Usuario</label>
                <input type="text" name="username" id="username" autocapitalize="off" class="form__input">
            </div>
            <div class="form__campo">
                <label for="password" class="form__label">Contraseña</label>
                <input type="password" name="password" id="password" autocapitalize="off" class="form__input">
            </div>
        </div>
        <button class="form__submit">Iniciar Sesión</button>
        <a href="/logup" class="form__link">No tienes una cuenta? Crea una</a>
    </div>
</form>