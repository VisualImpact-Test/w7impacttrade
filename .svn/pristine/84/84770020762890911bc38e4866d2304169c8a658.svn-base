<form id="formEditarHistoricosDeUsuario">

    <input class='d-none' type='text' name='idUsuario' value='<?= $idUsuario ?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Históricos de Usuario:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="overflow-auto">
                <table class='table table-sm table-bordered'>
                    <thead class='thead-light'>
                        <tr>
                            <th>OPCIONES</th>
                            <th>CUENTA</th>
                            <th>PROYECTO</th>
                            <th>TIPO USUARIO</th>
                            <th>APLICACIÓN</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historicos as $key => $value) { ?>
                            <tr data-idcuenta="<?= $value['idCuenta'] ?>" data-idaplicacion="<?= $value['idAplicacion'] ?>" data-idproyecto="<?= $value['idProyecto'] ?>" data-idusuariohistorico="<?= $value['idUsuarioHist'] ?>" data-idusuario="<?= $value['idUsuario'] ?>">
                                <td class='text-center'>
                                    <button data-menu='Detalles' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Histórico"><i class="fa fa-edit"></i></button>
                                    <button data-menu='Canal' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Canales de Histórico"><i class="fa fa-th"></i></button>
                                    <button data-menu='Zona' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Zonas de Histórico"><i class="fa fa-globe"></i></button>
                                    <button data-menu='PermisosCarpetas' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Permisos de Carpetas"><i class="fa fa-folder"></i></button>
                                    <button data-menu='PermisosMovil' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Permisos de Móvil"><i class="fa fa-mobile"></i></button>
                                    <button data-menu='PermisosIntranet' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Permisos de Intranet"><i class="fa fa-check-square"></i></button>
                                    <button data-menu='Banner' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Segmentación Moderno"><i class="fa fa-flag"></i></button>
                                    <button data-menu='DistribuidoraSucursal' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Segmentación Tradicional"><i class="fa fa-flag"></i></button>
                                    <button data-menu='Plaza' class="btn btn-EditarHistorico btn-outline-secondary border-0 pl-1 pr-1 pt-0 pb-0" title="Editar Segmentación Mayorista"><i class="fa fa-flag"></i></button>
                                </td>
                                <td><?= !empty($value['cuenta']) ? $value['cuenta'] : '-' ?></td>
                                <td><?= !empty($value['proyecto']) ? $value['proyecto'] : '-' ?></td>
                                <td><?= !empty($value['tipoUsuario']) ? $value['tipoUsuario'] : '-' ?></td>
                                <td><?= !empty($value['aplicacion']) ? $value['aplicacion'] : '-' ?></td>
                                <td><?= !empty($value['fecIni']) ? date_change_format($value['fecIni'])  : '-' ?></td>
                                <td><?= !empty($value['fecFin']) ? date_change_format($value['fecFin'])  : '-' ?></td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	
	<!--
    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-folder"></i> Permisos de Carpetas:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-3'>
        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Permisos de carpetas</label>
        </div>
        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <button type="button" class="btn btn-secondary btn-ClickBtnCarpetas">Ver Carpetas</button>
        </div>
    </div>
	-->
    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Usuario Histórico:</h6>
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
            <select id='cuentaHistorico' name='cuentaHistorico' class='form-control form-control-sm my_select2EditarHistoricosDeUsuario'>
                <option value=''>-- Seleccionar --</option>
                <?php foreach ($cuentas as $cuenta) { ?>
                    <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='proyectoHistorico'>Proyecto</label><br>
            <select id='proyectoHistorico' name='proyectoHistorico' class='form-control form-control-sm my_select2EditarHistoricosDeUsuario'>
                <option value=''>-- Seleccionar --</option>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='tipoUsuarioHistorico'>Tipo Usuario</label><br>
            <select id='tipoUsuarioHistorico' name='tipoUsuarioHistorico' class='form-control form-control-sm my_select2EditarHistoricosDeUsuario'>
                <option value=''>-- Seleccionar --</option>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for="aplicacionHistorico">Aplicación</label><br>
            <select id="aplicacionHistorico" name='aplicacionHistorico' class='form-control form-control-sm my_select2EditarHistoricosDeUsuario'>
                <option value=''>-- Seleccionar --</option>
            </select>
        </div>
    </div>
</form>

<script>
    var proyectos = <?= json_encode($proyectos) ?>;
    var aplicaciones = <?= json_encode($aplicaciones) ?>;
    var tiposDeUsuario = <?= json_encode($tiposDeUsuario) ?>;

    $('#fechaInicio').daterangepicker(singleDatePickerModal);

    $('.my_select2EditarHistoricosDeUsuario').select2({
        dropdownParent: $("div.modal-content-<?= $class ?>"),
        width: '100%'
    });
</script>