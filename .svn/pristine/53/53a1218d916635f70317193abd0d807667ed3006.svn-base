<?php
$num = 1;
$nameGrupoCanal = 'grupoCanal';
$nameCanal = 'canal';
$select2 = "my_select2EditarHistorico";
//
$nameTextoTest = 'textoTest';
$nameSelectMultipleTest = 'selectMultipleTest';
$nameCheckBoxTest = 'checkBoxTest';
$nameRadioTest = 'radioTest';
$select2 = "my_select2EditarHistorico";
$class = "formEditarHistorico";
?>


<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?=$menu?>'>
    <input class='d-none' type='text' name='idUsuarioHistorico' value='<?=$idUsuarioHistorico?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Canales:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="overflow-auto hr-15">
                <table class='table table-sm table-bordered text-nowrap'>
                    <thead class='thead-light'>
                        <tr>
                            <th class="text-center align-middle">
                                ACTUALIZAR
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-10">GRUPO CANAL</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-10">CANAL</div>
                            </th>
                            <!-- <th class="text-center align-middle">
                                <div class="wr-15">SELECT MULTIPLE</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-10">TEXTO</div>
                            </th>
                            <th class="text-center align-middle">
                                <div>CHECKBOX</div>
                            </th>
                            <th class="text-center align-middle">
                                <div>RADIO</div>
                            </th> -->
                            <th class="text-center align-middle">
                                <button class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                            <td></td>
                            <td class="text-center" data-name='<?= $nameGrupoCanal ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($grupoCanales as $key => $row) { ?>
                                        <option value='<?= $row['idGrupoCanal'] ?>'><?= $row['grupoCanal'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center" data-name='<?= $nameCanal ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                </select>
                            </td>

                            <!-- <td class="text-center" data-name='<?= $nameSelectMultipleTest ?>'>
                                <select class='form-control form-control-sm' multiple='multiple'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($grupoCanales as $key => $row) { ?>
                                        <option value='<?= $row['idGrupoCanal'] ?>'><?= $row['grupoCanal'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center" data-name='<?= $nameTextoTest ?>'>
                                <input type="text" class="form-control form-control-sm" placeholder="textotest">
                            </td>
                            <td class="text-center" data-name='<?= $nameCheckBoxTest ?>'>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="opcion1">
                                    <label class="form-check-label">Primera opción</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="opcion2">
                                    <label class="form-check-label">Segunda opción</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" value="opcion3">
                                    <label class="form-check-label">Tercera opción</label>
                                </div>
                            </td>
                            <td class="text-center" data-name='<?= $nameRadioTest ?>'>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input uncheckableRadio" type="radio" value="opcion1">
                                    <label class="form-check-label">Primer Radio</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input uncheckableRadio" type="radio" value="opcion2">
                                    <label class="form-check-label">Segundo radio</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input uncheckableRadio" type="radio" value="opcion3">
                                    <label class="form-check-label">Tercer radio</label>
                                </div>
                            </td> -->

                            <td class="text-center">
                                <button class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        <?php
                        foreach ($canalesDeHistorico as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idUsuarioHistCanal'] ?>'>
                                </td>
                                <td class="text-center">
                                    <select name='<?= $nameGrupoCanal ?>-<?= $num ?>' id='<?= $nameGrupoCanal ?>-<?= $num ?>' class='form-control form-control-sm <?= $select2 ?>' disabled>
                                        <option value=''>-- Seleccionar --</option>
                                        <?php
                                        $grupoCanalSeleccionado = ['idGrupoCanal' =>  $row['idGrupoCanal'], 'grupoCanal' => $row['grupoCanal']];
                                        agregarSiNoEsta($grupoCanalSeleccionado, $grupoCanales);
                                        foreach ($grupoCanales as $grupoCanal) {
                                            $stringSelected = ($grupoCanal['idGrupoCanal'] == $row['idGrupoCanal']) ? 'selected' : ''; ?>
                                            <option value='<?= $grupoCanal['idGrupoCanal'] ?>' <?= $stringSelected ?>><?= $grupoCanal['grupoCanal'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td class="text-center">
                                    <select name='<?= $nameCanal ?>-<?= $num ?>' id='<?= $nameCanal ?>-<?= $num ?>' class='form-control form-control-sm <?= $select2 ?>' disabled>
                                        <option value=''>-- Seleccionar --</option>
                                        <?php
                                        $canalSeleccionado = ['idCanal' =>  $row['idCanal'], 'canal' => $row['canal']];
                                        agregarSiNoEsta($canalSeleccionado, $canales[$row['idGrupoCanal']]);
                                        foreach ($canales[$row['idGrupoCanal']] as $canal) {
                                            $stringSelected = ($canal['idCanal'] == $row['idCanal']) ? 'selected' : ''; ?>
                                            <option value='<?= $canal['idCanal'] ?>' <?= $stringSelected ?>><?= $canal['canal'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <!-- <td class="text-center">
                                    <select name='<?= $nameSelectMultipleTest ?>-<?= $num ?>' id='<?= $nameSelectMultipleTest ?>-<?= $num ?>' class='form-control form-control-sm <?= $select2 ?>' multiple='multiple' disabled>
                                        <option value=''>-- Seleccionar --</option>
                                        <?php foreach ($grupoCanales as $key => $row) { ?>
                                            <option value='<?= $row['idGrupoCanal'] ?>'><?= $row['grupoCanal'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td class="text-center">
                                    <input name='<?= $nameTextoTest ?>-<?= $num ?>' id='<?= $nameTextoTest ?>-<?= $num ?>' type="text" class="form-control form-control-sm" placeholder="textotest" disabled>
                                </td>

                                <td class="text-center">
                                    <div id='<?= $nameCheckBoxTest ?>-<?= $num ?>' class="form-check form-check-inline">
                                        <input name='<?= $nameCheckBoxTest ?>-<?= $num ?>' class="form-check-input" type="checkbox" value="opcion1" disabled>
                                        <label class="form-check-label">Primera opción</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name='<?= $nameCheckBoxTest ?>-<?= $num ?>' class="form-check-input" type="checkbox" value="opcion2" disabled>
                                        <label class="form-check-label">Segunda opción</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name='<?= $nameCheckBoxTest ?>-<?= $num ?>' class="form-check-input" type="checkbox" value="opcion3" disabled>
                                        <label class="form-check-label">Tercera opción</label>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div id='<?= $nameRadioTest ?>-<?= $num ?>' class="form-check form-check-inline">
                                        <input name='<?= $nameRadioTest ?>-<?= $num ?>' class="form-check-input uncheckableRadio" type="radio" value="opcion1" disabled>
                                        <label class="form-check-label">Primer Radio</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name='<?= $nameRadioTest ?>-<?= $num ?>' class="form-check-input uncheckableRadio" type="radio" value="opcion2" disabled>
                                        <label class="form-check-label">Segundo radio</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name='<?= $nameRadioTest ?>-<?= $num ?>' class="form-check-input uncheckableRadio" type="radio" value="opcion3" disabled>
                                        <label class="form-check-label">Tercer radio</label>
                                    </div>
                                </td> -->

                                <td class="text-center">
                                    <button class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento" disabled><i class="fa fa-trash"></i></button>
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
    var canales = <?= json_encode($canales) ?>;
    $('.<?= $select2 ?>').select2({
        dropdownParent: $("div.modal-content-<?= $class ?>"),
        width: '100%'
    });
</script>