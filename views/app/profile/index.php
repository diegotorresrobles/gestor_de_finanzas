<section class="account">
    <div class="account__contenedor contenedor">
        <h2 class="account__titulo">Perfil</h2>
        <form method="POST" class="form form--account">
            <div class="form__contenedor">
                <div class="form__campos">
                    <div class="form__group">
                        <h3 class="form__desc">Información personal</h3>
                        <div class="form__campo">
                            <label for="nombre" class="form__label">Nombre(s)</label>
                            <input type="text" name="nombre" id="nombre" class="form__input">
                        </div>
                        <div class="form__campo">
                            <label for="apellido" class="form__label">Apellido(s)</label>
                            <input type="text" name="apellido" id="apellido" class="form__input">
                        </div>
                    </div>
                    <div class="form__group">
                        <h3 class="form__desc">Información de contacto</h3>
                        <div class="form__campo">
                            <label for="email" class="form__label">Correo</label>
                            <input type="email" name="email" id="email" class="form__input">
                        </div>
                        <div class="form__campo">
                            <label for="telefono" class="form__label">Teléfono</label>
                            <input type="tel" name="telefono" id="telefono" class="form__input">
                        </div>
                    </div>
                    <div class="form__group">
                        <h3 class="form__desc">Credenciales</h3>
                        <div class="form__campo">
                            <label for="username" class="form__label">Usuario</label>
                            <input type="text" name="username" id="username" autocapitalize="off" class="form__input">
                        </div>
                        <div class="form__campo">
                            <label for="password" class="form__label">Contraseña</label>
                            <input type="password" name="password" id="password" autocapitalize="off" class="form__input" hidden>
                            <button type="button" hidden>Actualizar Contraseña</button>
                        </div>
                    </div>
                    <div class="form__group">
                        <h3 class="form__desc">Acciones</h3>
                        <div class="form__actions">
                            <button type="button" data-accion="actualizar" class="form__accion form__accion--warning btn-warning">Actualizar</button>
                            <button type="button" data-accion="eliminar" class="form__accion form__accion--danger btn-danger">Eliminar</button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="form__submit form__submit--ocultar">Actualizar</button>
            </div>
        </form>
    </div>
</section>