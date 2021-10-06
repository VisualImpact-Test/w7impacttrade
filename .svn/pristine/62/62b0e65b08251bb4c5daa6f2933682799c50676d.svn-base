<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?= $menu ?>'>
    <input class='d-none' type='text' name='idUsuarioHistorico' value='<?= $idUsuarioHistorico ?>'>

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='cuenta'>Cuenta</label>
            <input id='cuenta' name='cuenta' type='text' class='form-control form-control-sm' placeholder='Cuenta' value="<?= $historico['cuenta'] ?>" disabled>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='proyecto'>Proyecto</label><br>
            <input id='proyecto' name='proyecto' type='text' class='form-control form-control-sm' placeholder='Proyecto' value="<?= $historico['proyecto'] ?>" disabled>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='tipoUsuario'>Tipo Usuario</label><br>
            <input id='tipoUsuario' name='tipoUsuario' type='text' class='form-control form-control-sm' placeholder='Tipo Usuario' value="<?= $historico['tipoUsuario'] ?>" disabled>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='aplicacion'>Aplicación</label><br>
            <input id='aplicacion' name='aplicacion' type='text' class='form-control form-control-sm' placeholder='Aplicación' value="<?= $historico['aplicacion'] ?>" disabled>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicioHistoricoDetalle'>Fecha Inicio</label><br>
            <input id='fechaInicioHistoricoDetalle' name='fechaInicioHistoricoDetalle' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio' value="<?= date_change_format($historico['fecIni']) ?>" disabled>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFinalHistoricoDetalle'>Fecha Final</label><br>
            <input id='fechaFinalHistoricoDetalle' name='fechaFinalHistoricoDetalle' type='text' class='form-control form-control-sm' placeholder='Fecha Final' value="<?= !empty($historico['fecFin']) ? date_change_format($historico['fecFin']) : '' ?>">
        </div>
    </div>
</form>

<script>
    // $('#fechaInicioHistoricoDetalle').daterangepicker($.extend({}, singleDatePickerModal, {
    //     "parentEl": "div.modal-content-<?= $class ?>",
    // }));
    $('#fechaFinalHistoricoDetalle').daterangepicker($.extend({}, singleDatePickerModal, {
        "parentEl": "div.modal-content-<?= $class ?>",
        "autoUpdateInput": false,
    }));

    // $('#fechaInicioHistoricoDetalle').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fechaFinalHistoricoDetalle').val('');
    // });
    $('#fechaFinalHistoricoDetalle').on('apply.daterangepicker', function(ev, picker) {
        $.fechaLimite(picker, "#fechaFinalHistoricoDetalle", "#fechaInicioHistoricoDetalle");
    });
</script>