<form id="formNew">
    <input class='d-none' type='text' name='externo' value='<?=!is_array($default)?$default:'1'?>'>
    <input class='d-none' type='text' name='idEmpleado' value='<?= (!empty($default['idEmpleado'])) ? $default['idEmpleado'] : "" ?>'>
<?
$readonly='';
if($default==1){
	$readonly='readonly';
}else{
	$readonly='';
}
?>
    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Datos de Usuario:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-3'>
		 <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4'>
			 <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2' style="float:left;">
				<label for='tipoDocumento'>Tipo Documento</label><br>
				<select id='tipoDocumento' name='tipoDocumento' class='form-control form-control-sm my_select2New' <?= (!empty($default['idTipoDocumento'])) ? "readonly" : "" ?>>
					<?php if (!empty($default['idTipoDocumento'])) { ?>
						<option value='<?= $default['idTipoDocumento'] ?>' selected><?= $default['tipoDocumento'] ?></option>
						<?php foreach ($tiposDeDocumento as $tipoDeDocumento) { 
							if($tipoDeDocumento['idTipoDocumento']!=$default['idTipoDocumento']){
							?>
							<option value='<?= $tipoDeDocumento['idTipoDocumento'] ?>'><?= $tipoDeDocumento['breve'] ?></option>
						<?php }  } ?>
					<?php  } else { ?>
						<option value=''>-- Seleccionar --</option>
						<?php foreach ($tiposDeDocumento as $tipoDeDocumento) { ?>
							<option value='<?= $tipoDeDocumento['idTipoDocumento'] ?>'><?= $tipoDeDocumento['breve'] ?></option>
						<?php } ?>
					<?php   } ?>
				</select>
			</div>
			
			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2' style="float:left;" >
				<label for='numDocumento'>Num. Documento</label><br>
				<input id='numDocumento' name='numDocumento' type='text' class='form-control form-control-sm' placeholder='Num. Documento' <?= (!empty($default['numDocumento'])) ? "value = '" . $default['numDocumento'] . "' readonly" : "" ?>>
			</div>
			<? if($default==1){ ?>
			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2' style="float:left;" >
				<button type="button" class="btn btn-primary btn-busqueda">Buscar Data RRHH</button>
			</div>
			<? } ?>
        </div>
        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='nombres'>Nombres</label><br>
            <input id='nombres' name='nombres' type='text' class='form-control form-control-sm' placeholder='Nombres' <?= (!empty($default['nombres'])) ? "value = '" . $default['nombres'] . "' readonly" : "" ?>  <?=$readonly?>>
        </div >

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='apePaterno'>Apellido Paterno</label><br>
            <input id='apePaterno' name='apePaterno' type='text' class='form-control form-control-sm' placeholder='Apellido Paterno' <?= (!empty($default['apePaterno'])) ? "value = '" . $default['apePaterno'] . "' readonly" : "" ?> <?=$readonly?>>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='apeMaterno'>Apellido Materno</label><br>
            <input id='apeMaterno' name='apeMaterno' type='text' class='form-control form-control-sm' placeholder='Apellido Materno' <?= (!empty($default['apeMaterno'])) ? "value = '" . $default['apeMaterno'] . "' readonly" : "" ?> <?=$readonly?>>
        </div>

       

        <!--<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='numDocumento'>Num. Documento</label><br>
            <input id='numDocumento' name='numDocumento' type='text' class='form-control form-control-sm' placeholder='Num. Documento' <?= (!empty($default['numDocumento'])) ? "value = '" . $default['numDocumento'] . "' readonly" : "" ?>>
        </div>-->

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='email'>Email</label><br>
            <input id='email' name='email' type='text' class='form-control form-control-sm' placeholder='Email' <?= (!empty($default['email'])) ? "value = '" . $default['email'] . "' " : "" ?>>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <label for="usuario">Usuario</label><br>
            <div class="input-group input-group-sm">
                <input id="usuario" name="usuario" type="text" class="form-control" placeholder='Usuario' <?= (!empty($default['numDocumento'])) ? "value = '" . $default['numDocumento'] . "'" : "" ?> readonly>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-GenerarUsuario" title="Generar Usuario" type="button"><i class="fa fa-user"></i></button>
                </div>
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <label for="clave">Clave</label><br>
            <div class="input-group input-group-sm">
                <input id="clave" name="clave" type="password" class="form-control" placeholder='Clave'>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-GenerarClave" title="Generar Clave" type="button"><i class="fa fa-key"></i></button>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-MostrarClave" title="Mostrar clave" type="button"><i class="fa fa-eye"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Primer Histórico:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-3'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='cuentaHistorico'>Cuenta</label><br>
            <select id='cuentaHistorico' name='cuentaHistorico' class='form-control form-control-sm my_select2New'>
                <?php if (!empty($default['idCuenta'])) { ?>
                    <option value='<?= $default['idCuenta'] ?>' selected><?= $default['nombreEmpresa'] ?></option>
                    <?php foreach ($cuentas as $cuenta) { 
                         if($default['idCuenta']!=$cuenta['idCuenta']){ ?>?>
                        <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                <?php  } else { ?>
                    <option value=''>-- Seleccionar --</option>
                    <?php foreach ($cuentas as $cuenta) { ?>
                       
                            <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                        
                    <?php } ?>
                <?php   } ?>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='proyectoHistorico'>Proyecto</label><br>
            <select id='proyectoHistorico' name='proyectoHistorico' class='form-control form-control-sm my_select2New'>
                <?php if (!empty($default['idCuenta'])) { ?>
                    <option value=''>-- Seleccionar --</option>
                    <?php foreach ($proyectos[$default['idCuenta']] as $key => $proyecto) { ?>
                        <option value='<?= $proyecto['idProyecto'] ?>'><?= $proyecto['nombre'] ?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value=''>-- Seleccionar --</option>
                <?php  } ?>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='tipoUsuarioHistorico'>Tipo Usuario</label><br>
            <select id='tipoUsuarioHistorico' name='tipoUsuarioHistorico' class='form-control form-control-sm my_select2New'>
                <?php if (!empty($default['idCuenta'])) { ?>
                    <option value=''>-- Seleccionar --</option>
                    <?php foreach ($tiposDeUsuario[$default['idCuenta']] as $key => $tipoDeUsuario) { ?>
                        <option value='<?= $tipoDeUsuario['idTipoUsuario'] ?>'><?= $tipoDeUsuario['tipoUsuario'] ?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value=''>-- Seleccionar --</option>
                <?php  } ?>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for="aplicacionHistorico">Aplicación</label><br>
            <select id="aplicacionHistorico" name='aplicacionHistorico' class='form-control form-control-sm my_select2New'>
                <?php if (!empty($default['idCuenta'])) { ?>
                    <option value=''>-- Seleccionar --</option>
                    <?php foreach ($aplicaciones[$default['idCuenta']] as $key => $aplicacion) { ?>
                        <option value='<?= $aplicacion['idAplicacion'] ?>'><?= $aplicacion['nombre'] ?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value=''>-- Seleccionar --</option>
                <?php  } ?>
            </select>
        </div>
    </div>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Encargado:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class="form-row">

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <div class="form-row">
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                    <label>¿Tiene encargado?</label><br>
                    <div class="form-check form-check-inline" id="tieneEncargado">
                        <input name="tieneEncargado" class="form-check-input" type="radio" value="1" checked>
                        <label class="form-check-label">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="tieneEncargado" class="form-check-input" type="radio" value="0">
                        <label class="form-check-label">No</label>
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-9 col-sm-9 col-md-9 col-lg-9 mb-2 seccionTieneEncargado'>
            <div class="form-row">
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='tipoDocumentoSuperior'>Tipo</label><br>
                    <select data-radio='tieneEncargado' id='tipoDocumentoSuperior' name='tipoDocumentoSuperior' class='form-control form-control-sm my_select2New'>
                        <?php foreach ($tiposDeDocumento as $tipoDeDocumento) { ?>
                            <option value='<?= $tipoDeDocumento['idTipoDocumento'] ?>'><?= $tipoDeDocumento['breve'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='numDocSuperior'>Num. Documento</label><br>
                    <div class="input-group input-group-sm">
                        <input data-radio="tieneEncargado" id='numDocSuperior' name='numDocSuperior' type="text" class="form-control" placeholder="Num. Documento">
                        <div class="input-group-append">
                            <button data-radio="tieneEncargado" class="btn btn-outline-secondary btn-FindSuperior" title="Buscar Superior" type="button"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                    <label for='idUsuarioSuperior'>Superior</label><br>
                    <input data-radio="tieneEncargado" id='idUsuarioSuperior' name='superiorEncontrado' type='text' class='form-control form-control-sm' readonly>
                    <input data-radio="tieneEncargado" class='d-none' type='text' name='idUsuarioSuperior'>
                </div>
            </div>
        </div>



    </div>

</form>

<script>
    var proyectos = <?= json_encode($proyectos) ?>;
    var aplicaciones = <?= json_encode($aplicaciones) ?>;
    var tiposDeUsuario = <?= json_encode($tiposDeUsuario) ?>;

    $('#fechaInicio').daterangepicker(singleDatePickerModal);

    $('.my_select2New').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });

    $('#cuentaHistorico').change();
</script>