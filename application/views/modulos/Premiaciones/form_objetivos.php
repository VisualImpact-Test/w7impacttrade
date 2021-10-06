<div class="tab-content">
    <div id="tab1_b" class="tab-pane fade in active">
        <div style="padding:20px; border: 1px solid #E6E9ED;">
            <div class="card-header" style="margin-bottom: 14px;">
                <h4><?= $nombre_premiacion; ?></h4>
            </div>
            <form id="formObjetivos" role="form">
                <div class="row">
                    <input type="hidden" name="idPremiacion_cargo" id="idPremiacion_cargo" value="<?= $id_premiacion; ?>">
                    <input type="hidden" name="nombrePremiacion_cargo" id="nombrePremiacion_cargo" value="<?= $nombre_premiacion; ?>">
                    <div class="col-md-12 col-sm-12 col-xs-12 filtros_asistencia">
                        <div class="col-md-12" id="divTablaCargaMasiva">
                            <div class="tab-content mt-4 text-white">
                                <div class="">
                                    <div class="alert alert-warning" role="alert" style="color:#695560 !important;">
                                        <i class="fa fa-check-circle"></i> <label class="">Se pide que solo una fila (la última) debe quedar en <strong>BLANCO</strong></label>.<br>
                                        <i class="fa fa-check-circle"></i> <label class="">Los campos con una cabecera que contenga (*) son <strong>OBLIGATORIOS</strong></label>.<br>
                                    </div>
                                </div>
                                <? foreach ($hojas as $key => $row) { ?>
                                    <div class="tab-pane <?= ($key == 0) ? 'active' : '' ?>" id="hoja<?= $key ?>" role="tabpanel" aria-labelledby="hoja<?= $key ?>-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="divHT<?= $key ?>">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-trade-visual" style="margin-top: 10px;width: 100%;" id="btn-guardar-objetivo">Registrar</button>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="resultadoGuardarCargos" style="margin-top:15px;"></div>
        </div>
        <div style="padding:20px;max-height:200px !important;overflow-y:auto;">
            <table class="table" id="tb-objetivoPremiaciones" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">CANAL</th>
                        <th class="text-center">COD PDV</th>
                        <th class="text-center">PDV</th>
                        <th class="text-center">ESTADO</th>
                    </tr>
                </thead>
                <tbody id="bodyTablaObjetivosPremiaciones">
                    <? $i = 1; ?>
                    <? foreach ($premiaciones_objetivos as $key => $row) {
                        $mensajeEstado = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
                        $badge = $row['estado'] == 1 ? 'badge-success' : 'badge-danger';
                    ?>
                        <tr data-id="<?= $row['idObjetivo']; ?>">
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $row['grupoCanal']; ?></td>
                            <td class="text-center"><?= $row['idCliente']; ?></td>
                            <td><?= $row['cliente']; ?></td>
                            <td class="text-center" style="font-size: 20px;">
                                <span class="badge <?= $badge ?>" id="spanEstado-<?= $row['idObjetivo']; ?>"><?= $mensajeEstado; ?></span>
                                <a href="javascript:;" data-id="<?= $row['idObjetivo']; ?>" class="btn-estado-objetivo"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>