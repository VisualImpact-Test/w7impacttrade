<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
    </div>
	<div class='form-row'>
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='categoria'>Categoria</label><br>
			<select id='categoria' name='categoria' class='form-control form-control-sm my_select2'>
				<option value=''>-- Seleccionar --</option>
				<?php foreach ($categoria as $row) { ?>
					<option value='<?= $row['idCategoria'] ?>'><?= $row['nombre'] ?></option>
				<?php } ?>
			</select>
        </div>
    </div>
</form>
<script>
    $('.my_select2').select2({
        width: '100%'
    });
</script>
