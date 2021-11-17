<form id="formNew">
    <div class='form-row'>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <label for='cuenta_tipoPremiacion'>Cuenta:</label><br>
            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_tipoPremiacion', 'id' => 'cuenta_tipoPremiacion', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre:</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' patron="requerido">
        </div>
		
		<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>FechaInicio:</label><br>
			<input type="date" name="fechaInicio" id="fechaInicio" placeholder="Fecha Inicio" class="form-control" patron="requerido" value="" >
		   
        </div>
		<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>FechaFin:</label><br>
            <input type="date" name="fechaFin" id="fechaFin" placeholder="Fecha Fin" class="form-control" value="">
        </div>

    </div>
</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>