<div action="/api/login" class="form__contenedor">
    <form method="post" class="form form--login" autocomplete="off">
        <h1 class="form__name">Iniciar Sesión</h1>
        <div class="form__campo">
            <input type="text" name="username" id="username" placeholder="." class="form__input">
            <label for="username" class="form__label">Username</label>
        </div>
        <div class="form__campo">
            <input type="password" name="password" id="password" placeholder="." class="form__input">
            <label for="password" class="form__label">Contraseña</label>
        </div>
        <button type="submit" class="form__submit btn">Ingresar</button>
        <a href="/logup" class="form__link">No tienes una cuenta? Crea una</a>
    </form>
</div>