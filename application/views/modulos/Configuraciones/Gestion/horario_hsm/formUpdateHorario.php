<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['elemento']['id']] ?>">

    <div class='form-row'>
    
        <div class='col-xs-6 col-lg-6 col-md-6 col-sm-12 mb-2'>
            <label for='nombre'>Hora Ingreso</label><br>
            <input id='horaIni' name='horaIni' type='time' class='form-control form-control-sm'  value="<?= $data['horaIni'] ?>">
        </div>
        <div class='col-xs-6 col-lg-6 col-md-6 col-sm-12 mb-2'>
            <label for='nombre'>Hora Salida</label><br>
            <input id='horaFin' name='horaFin' type='time' class='form-control form-control-sm'  value="<?= $data['horaFin'] ?>">
        </div>
    </div>
    
</form>
<script>

</script>
