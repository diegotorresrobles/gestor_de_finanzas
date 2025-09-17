<section class="movimientos contenedor">
    <h2 class="movimientos-update__titulo">Actualizar movimiento</h2>
    <form class="form form--movimientos-update">
        <div class="form__campos">
            <div class="form__campo">
                <label for="monto" class="form__label">Monto</label>
                <input type="number" name="monto" id="monto" class="form__input">
            </div>
            <div class="form__campo">
                <label for="tipo" class="form__label">Tipo</label>
                <select name="tipo" id="tipo" class="form__input form__select">
                    <option value="" class="form__option" disabled selected>-- Seleccionar --</option>
                    <option value="1" class="form__option">Ingreso</option>
                    <option value="2" class="form__option">Gasto</option>
                </select>
            </div>
            <div class="form__campo">
                <label for="cuenta" class="form__label">Cuenta</label>
                <select name="cuenta" id="cuenta" class="form__input form__select">
                    <option value="" class="form__option" disabled selected>-- Seleccionar --</option>
                </select>
            </div>
            <div class="form__campo">
                <label for="fecha" class="form__label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form__input">
            </div>
            <div class="form__campo">
                <label for="categoria" class="form__label">Categoria</label>
                <input type="text" name="categoria" id="categoria" data-obligatorio="off" class="form__input">
            </div>
            <div class="form__campo">
                <label for="metodo_pago" class="form__label">Metodo de pago</label>
                <input type="text" name="metodo_pago" id="metodo_pago" data-obligatorio="off" class="form__input">
            </div>
            <div class="form__campo">
                <label for="descripcion" class="form__label">Descripcion</label>
                <textarea name="descripcion" id="descripcion" data-obligatorio="off" class="form__input form__textarea"></textarea>
            </div>
        </div>
        <div class="form__actions">
            <button type="submit" class="from__action btn-success">Agregar</button>
            <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="form__action btn-danger">Cancelar</a>
        </div>
    </form>
</section>