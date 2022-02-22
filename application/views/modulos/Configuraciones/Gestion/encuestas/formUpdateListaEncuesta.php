<?php
$num = 1;
$nameSelectEncuesta = 'sl_encuesta';
$checkFoto = "chkFoto";
$select2 = "my_select2EditarLista";

?>


<form id="formUpdate">
    <input class="d-none" type="text" name="idLista" value="<?= $data['idListEncuesta'] ?>">


    <div class='form-row'>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='grupoCanal'>Grupo Canal</label><br>
            <select id='grupoCanal_form' name='grupoCanal_form' class='form-control form-control-sm my_select2 grupoCanal'>
                <?php if (!empty($data['idGrupoCanal'])) { ?>
                    <option value='<?= $data['idGrupoCanal'] ?>' selected><?= $data['grupoCanal'] ?></option>
                <?php } else { ?>
                    <option value=''>-- Seleccione --</option>
                <? } ?>
                <?php foreach ($grupoCanal as $idCanal => $grupoCanal) { ?>
                    <?php if ($data['idGrupoCanal'] != $grupoCanal['idGrupoCanal']) { ?>
                        <option value='<?= $grupoCanal['idGrupoCanal'] ?>'><?= $grupoCanal['nombre'] ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='canal'>Canal</label><br>
            <div class="canal_form">
                <select id='canal_form' name='canal_form' class='form-control form-control-sm my_select2 canal_cliente'>
                    <?php if (!empty($data['idCanal'])) { ?>
                        <option value='<?= $data['idCanal'] ?>' selected><?= $data['canal'] ?></option>
                    <?php } else { ?>
                        <option value=''>-- Seleccione --</option>
                    <? } ?>
                    <?php foreach ($canales as $idCanal => $canal) { ?>
                        <?php if ($data['idCanal'] != $canal['idCanal']) { ?>
                            <option value='<?= $canal['idCanal'] ?>'><?= $canal['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='tipoUsuario'>Tipo Usuario</label><br>
            <div class="tipoUsuario_sl_form">
                <select id='tipoUsuario_form' name='tipoUsuario_form' class='form-control form-control-sm my_select2 tipoUsuario_cliente'>
                    <?php if (!empty($data['idTipoUsuario'])) { ?>
                        <option value='<?= $data['idTipoUsuario'] ?>' selected><?= $data['tipo'] ?></option>
                    <?php } else { ?>
                        <option value=''>-- Seleccione --</option>
                    <? } ?>
                    <? if (!empty($tipoUsuario)) { ?>
                        <?php foreach ($tipoUsuario as $id => $value) { ?>
                            <?php if ($data['idTipoUsuario'] != $value['idTipoUsuario']) { ?>
                                <option value='<?= $value['idTipoUsuario'] ?>'><?= $value['nombre'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <? } ?>
                </select>
            </div>
        </div>
		
		<div class="form-row">
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
				<label for="cliente">Cliente</label>
				<div class="cliente_sl_form">
					<select id='cliente_form' name='cliente_form' class='form-control form-control-sm my_select2' style="width:100%;">
						<option value=''>-- Seleccionar --</option>
						<? foreach ($clientes as $row){ ?>
							<? if ($data['idCliente'] != $row['idCliente']) {$selected='';}else{$selected='selected';}?>
							 <option value='<?= $row['idCliente'] ?>' <?=$selected?> ><?= $row['razonSocial'] ?></option>
						<? } ?>
					</select>
				</div>
			</div>
		</div>

    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio' value="<?= $data['fecIni'] ?>">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin' value="<?= $data['fecFin'] ?>">
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class='table table-sm table-bordered text-nowrap'>
                    <thead class='thead-light'>
                        <tr>
                            <th class="text-center align-middle">
                                ACTUALIZAR
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">ENCUESTAS</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">OBLIGATORIO</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-10">FOTO OBLIGATORIO</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-10">FOTO MULTIPLE</div>
                            </th>
                            <th class="text-center align-middle">
                                <button class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?= $class ?>">
                            <td></td>

                            <td class="text-center" data-name='<?= $nameSelectEncuesta ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($encuestas as $idEncuesta => $encuesta) { ?>
                                        <option value='<?= $encuesta['idEncuesta'] ?>'><?= $encuesta['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center" data-name='sl_obligatorio'>
                                <select class='form-control form-control-sm'>
                                    <option value='0'>NO</option>
                                    <option value='1'>SÍ</option>
                                </select>
                            </td>
                            <td class="text-center" data-name='sl_fotoObligatorio'>
                                <select class='form-control form-control-sm'>
                                    <option value='0'>NO</option>
                                    <option value='1'>SÍ</option>
                                </select>
                            </td>
                            <td class="text-center" data-name='sl_fotoMultiple'>
                                <select class='form-control form-control-sm'>
                                    <option value='0'>NO</option>
                                    <option value='1'>SÍ</option>
                                </select>
                            </td>
                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        <?php
                        foreach ($lista_encuesta as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?= $num ?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idListEncuestaDet'] ?>'>
                                </td>
                                <td class="text-center">
                                    <input value="<?= $row['nombre'] ?>" type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-center">
                                    <input value="<?= !empty($row['obligatorio'])? "SÍ": "NO" ?>" type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-center">
                                    <input value="<?= !empty($row['flagFotoObligatorioEncuesta'])? "SÍ": "NO" ?>" type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-center">
                                    <input value="<?= !empty($row['flagMultiplesFotos'])? "SÍ": "NO" ?>" type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-left">
                                    <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento" disabled><i class="fa fa-trash"></i></button>
                                </td>

                            </tr>
                        <?php $num++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>



<script>
    $('#fechaInicio').daterangepicker(singleDatePickerModal);
    $('#fechaFin').daterangepicker($.extend({
        "autoUpdateInput": false,
    }, singleDatePickerModal));
    $('#fechaInicio').on('apply.daterangepicker', function(ev, picker) {
        $('#fechaFin').val('');
    });
    $('#fechaFin').on('apply.daterangepicker', function(ev, picker) {
        $.fechaLimite(picker, "#fechaFin", "#fechaInicio");
    });
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });

    Encuestas.grupoCanal_canales = <?= json_encode($grupoCanal_canales) ?>

    // var checkList = document.getElementById('listEncuestas');
    //     checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
    //         if (checkList.classList.contains('visible'))
    //             checkList.classList.remove('visible');
    //         else
    //             checkList.classList.add('visible');
    // }
    // // Todo esto para los dos primeros selects juntos
    // $('#fecIni').daterangepicker(singleDatePickerModal);
    // $('#fecFin').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin').val('');
    // });
    // $('#fecFin').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin", "#fecIni");
    // });

    // // Todo esto para los dos segundos selects juntos
    // $('#fecIni2').daterangepicker(singleDatePickerModal);
    // $('#fecFin2').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni2').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin2').val('');
    // });
    // $('#fecFin2').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin2", "#fecIni2");
    // });

    // // Esto para poner el modal como parent para los select2
    // $('.my_select2').select2({
    //     dropdownParent: $("div.modal-content"),
    //     width: '100%'
    // });
</script>