<?php
$num = 1;
$namePlaza = 'plaza';
$select2 = "my_select2EditarHistorico"; ?>

<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?=$menu?>'>
    <input class='d-none' type='text' name='idUsuarioHistorico' value='<?=$idUsuarioHistorico?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Plazas:</h6>
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
                                <div class="wr-10">PLAZA</div>
                            </th>
                            <th class="text-center align-middle">
                                <button class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                            <td></td>
                            <td class="text-center" data-name='<?= $namePlaza ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($plazas as $key => $row) { ?>
                                        <option value='<?= $row['idPlaza'] ?>'><?= $row['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center">
                                <button class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        <?php
                        foreach ($plazasDeHistorico as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idUsuarioHistPlaza'] ?>'>
                                </td>
                                <td class="text-center">
                                    <select name='<?= $namePlaza ?>-<?= $num ?>' id='<?= $namePlaza ?>-<?= $num ?>' class='form-control form-control-sm <?= $select2 ?>' disabled>
                                        <option value=''>-- Seleccionar --</option>
                                        <?php
                                        $plazaSeleccionada = ['idPlaza' =>  $row['idPlaza'], 'nombre' => $row['plaza']];
                                        agregarSiNoEsta($plazaSeleccionada, $plazas);
                                        foreach ($plazas as $plaza) {
                                            $stringSelected = ($plaza['idPlaza'] == $row['idPlaza']) ? 'selected' : ''; ?>
                                            <option value='<?= $plaza['idPlaza'] ?>' <?= $stringSelected ?>><?= $plaza['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
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
    $('.<?= $select2 ?>').select2({
        dropdownParent: $("div.modal-content-<?= $class ?>"),
        width: '100%'
    });
</script>