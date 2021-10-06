<div style="padding:20px; border: 1px solid #E6E9ED;">
    <form name="formEstadosObjetivos" id="formEstadosObjetivos">
        <div class="form-group">
            <label>ESTADO</label>
            <select class="form-control" name="sel_formestado" id="sel_formestado">
                <option value="1" <?= ($premiaciones_objetivos_estado[0]['estado'] == '1') ? "selected" : ""; ?>>ACTIVO</option>
                <option value="0" <?= ($premiaciones_objetivos_estado[0]['estado'] == '0') ? "selected" : "";  ?>>INACTIVO</option>
            </select>
        </div>
        <div class="form-group">
            <label>COMENTARIO</label>
            <input type="text" class="form-control input-sm" id="txt_comentario" name="txt_comentario" value="<?= $premiaciones_objetivos_estado[0]['comentario']; ?>" />
        </div>
        <div class="form-group">
            <input type="hidden" name="idObjetivo_formestado" id="idObjetivo_formestado" value="<?= $premiaciones_objetivos_estado[0]['idObjetivo']; ?>">
            <button type="button" class="btn btn-primary" id="btn-estado-objetivos">Actualizar</button>
        </div>
    </form>
</div>