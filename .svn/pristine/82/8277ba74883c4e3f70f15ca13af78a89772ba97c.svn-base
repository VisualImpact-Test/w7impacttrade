<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form id="formUpdatePregunta">
                        <table class="mb-0 table-bordered table-sm no-footer w-100 text-nowrap" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">OPCIONES</th>
                                    <th class="text-center">TIPO PREGUNTA</th>
                                    <th class="text-center" style="width: 50%;">NOMBRE</th>
                                    <th class="text-center">ORDEN</th>
                                    <th class="text-center">ESTADO</th>
                                    <!-- <th></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;foreach ($data as $value) {
                                    $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                                    $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                                    $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
                                ?>
                                    <tr data-id="<?= $value['idPregunta'] ?>" data-estado="<?= $value['estado'] ?>">
                                        <td><?=$i++;?></td>
                                        <td>
                                            <div>
                                                <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                                            </div>
                                        </td>
                                        <td>
                                        <select name="pregunta_<?=$value['idPregunta']?>" id="pregunta_<?=$value['idPregunta']?>" class='form-control form-control-sm my_select2'>
                                        <?php if (!empty($value['idTipoPregunta'])) { ?>
                                            <option value='<?=$value['idTipoPregunta'] ?>' selected><?= $value['tipo'] ?></option>
                                        <?php } ?>
                                        <?php foreach ($tiposPregunta as $idTipoPregunta => $tipos) { ?>
                                            <?php if ($value['idTipoPregunta'] != $tipos['idTipoPregunta']) { ?>
                                                <option value='<?= $tipos['idTipoPregunta'] ?>'><?= $tipos['nombre'] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                        </select>
                                        </td>
                                        <td><? if(!empty($value['nombre'])){?>
                                                <input type="text" name="pregunta_<?=$value['idPregunta']?>" id="pregunta_<?=$value['idPregunta']?>" class="form-control" style="border:none" value="<?=$value['nombre']?>">
                                            <?}?>
                                        </td>
                                        <td><? if(!empty($value['orden'])){?>
                                                <input type="text"name="pregunta_<?=$value['idPregunta']?>" id="pregunta_<?=$value['idPregunta']?>" class="form-control" style="border:none" value="<?=$value['orden']?>">
                                            <?}?>
                                        </td>
                                        <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                                            <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                                        </td>
                                        <!-- <?if($value['idTipoPregunta'] == 2 || $value['idTipoPregunta'] == 3 ){?>
                                            <td><button type="button" class="btn btn-secondary">Alternativas</button></td>
                                        <?}?> -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>