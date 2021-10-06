<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['elemento']['id']] ?>">

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $data['nombre'] ?>">
        </div>
    </div>
    <div class='form-row'>
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
			<label for='categoria'>Categoria</label><br>
			<select id='categoria' name='categoria' class='form-control form-control-sm my_select2'>
				<option value=''>-- Seleccionar --</option>
			<?php foreach ($categoria as $row) { ?>
				<?php if ($data['idCategoria'] != $row['idCategoria']) { ?>
					<option value='<?= $row['idCategoria'] ?>'><?= $row['nombre'] ?></option>
				<?php } ?>
				<?php if ($data['idCategoria'] == $row['idCategoria']) { ?>
					<option value='<?= $row['idCategoria'] ?>' selected ><?= $row['nombre'] ?></option>
				<?php } ?>
			<?php } ?>
			</select>
		</div>
    </div>
</form>
