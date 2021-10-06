<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['motivo']['id']] ?>">

    <div class="form-row">
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='motivo'>Motivo</label><br>
            <input id='motivo' name='motivo' type='text' class='form-control form-control-sm' placeholder='Motivo' value="<?=$data['nombre']?>">
        </div>
    </div>
</form>
