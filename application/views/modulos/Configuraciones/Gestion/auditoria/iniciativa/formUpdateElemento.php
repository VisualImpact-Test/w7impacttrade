<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['elemento']['id']] ?>">

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $data['nombre'] ?>">
        </div>
    </div>
   
	<div class='form-row inline'>
         <div class='col-xs-11 col-sm-11 col-md-11 col-lg-11 mb-2'>
            <label for='iniciativa'>Iniciativa</label><br>
            <div class="iniciativa_sl">
                <select id='iniciativa' name='iniciativa' class='form-control form-control-sm my_select2'>
					<?php if (!empty($data['idIniciativa'])) { ?>
						<option value='<?= $data['idIniciativa'] ?>' selected><?= $data['tipo'] ?></option>
					<?php } ?>
					<?php foreach ($tipos as $idTipo => $tipo) { ?>
						<?php if ($data['idIniciativa'] != $tipo['idIniciativa']) { ?>
							<option value='<?= $tipo['idIniciativa'] ?>'><?= $tipo['nombre'] ?></option>
						<?php } ?>
					<?php } ?>
                </select>
            </div>
        </div>
        <div class='col-xs-1 col-sm-1 col-md-1 col-lg-1 mb-2'>
        <br>
            <button class="btn btn-outline-primary border-0 btn-new-iniciativa" title="Agregar">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
        </div>
    </div>

</form>
