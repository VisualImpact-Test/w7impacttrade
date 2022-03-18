<form id="formReprogramacion">
    <input class="d-none" type="text" name="idVisitaReprogramacion" value="<?= $reprogramacion['idVisitaReprogramacion'] ?>">
    <input class="d-none" type="text" name="idVisita" value="<?= $reprogramacion['idVisita'] ?>">
    <input class="d-none" type="text" name="idClienteReprogramacion" value="<?= $reprogramacion['idCliente'] ?>">
    <input class="d-none" type="text" name="idUsuarioReprogramacion" value="<?= $reprogramacion['idUsuario'] ?>">

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Datos de Punto de Venta</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-3'>
        <div class='col-xs-2 col-sm-2 col-md-2 col-lg-2 mb-2'>
            <label>Código Visual</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['idCliente'] ?>" readonly>
        </div>
        <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5 mb-2'>
            <label>Razón Social</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['razonSocial'] ?>" readonly>
        </div>
        <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5 mb-2'>
            <label>Dirección</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['direccion'] ?>" readonly>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label>Departamento</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['departamento'] ?>" readonly>
        </div>
        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label>Distrito</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['distrito'] ?>" readonly>
        </div>
        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label>Provincia</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['provincia'] ?>" readonly>
        </div>
    </div>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Solicitud</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-3'>
        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Usuario Solicitante</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['nombreCompleto'] ?>" readonly>
        </div>

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Tipo Usuario</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['tipoUsuario'] ?>" readonly>
        </div>

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Tipo Documento</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['tipoDocumento'] ?>" readonly>
        </div>

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Num. Documento</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['numDocumento'] ?>" readonly>
        </div>

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Hora</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= time_change_format($reprogramacion['hora']) ?>" readonly>
        </div>

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Motivo</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['motivoReprogramacion'] ?>" readonly>
        </div>

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Observación</label><br>
            <input type='text' class='form-control form-control-sm' value="<?= $reprogramacion['observacion'] ?>" readonly>
        </div>

        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>Foto</label><br>
            <button <?= empty($reprogramacion['fotoUrl']) ? 'disabled' : '' ?> data-urlfoto="<?= verificarUrlFotos($reprogramacion['fotoUrl']) . 'reprogramaciones/' . $reprogramacion['fotoUrl'] ?>" class="btn btn-verFoto btn-outline-secondary border-0 btn-sm" title="Ver Foto"><i class="fa fa-camera"></i></button>
        </div>
    </div>

    <?php
    $estadoReprogramacion = $reprogramacion['idEstadoReprogramacion'];
    switch ($estadoReprogramacion) {
        case 1:
            $mensajeEstado = 'Aprobado';
            $badge = 'btn-primary';
            break;

        case 2:
            $mensajeEstado = 'Rechazado';
            $badge = 'btn-danger';
            break;

        default:
            $mensajeEstado = 'Pendiente';
            $badge = 'btn-warning';
            break;
    }
    ?>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-calendar-times-o"></i> Reprogramación <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span></h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='row mb-3'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            <div id="calendar"></div>
        </div>
    </div>

    <div class='form-row mb-3'>
        <input class="d-none" type="text" name="idRutaReprogramacion">
        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='fechaReprogramacion'>Fecha Reprogramación</label><br>
            <input id='fechaReprogramacion' name='fechaReprogramacion' type='text' class='form-control form-control-sm' value="<?= !empty($reprogramacion['fechaNueva']) ? date_change_format($reprogramacion['fechaNueva']) : '' ?>" readonly>
        </div>
        <div class='col-xs-8 col-sm-4 col-md-8 col-lg-8 mb-2'>
            <label for='comentario'>Comentario</label><br>
            <input id='comentario' name='comentario' type='text' class='form-control form-control-sm' value="<?= !empty($reprogramacion['comentario']) ? $reprogramacion['comentario'] : '' ?>">
        </div>
    </div>

</form>