<div class="tab-content">
    <div id="tab1_b" class="tab-pane fade in active">
        <div style="padding:20px; border: 1px solid #E6E9ED;">
            <div class="card-header" style="margin-bottom: 14px;">
                <h4><?= $nombre_premiacion; ?></h4>
            </div>
            <form id="formCargos">
                <div class="row">
                    <input type="hidden" name="idPremiacion_cargo" id="idPremiacion_cargo" value="<?= $id_premiacion; ?>">
                    <input type="hidden" name="nombrePremiacion_cargo" id="nombrePremiacion_cargo" value="<?= $nombre_premiacion; ?>">
                    <div class="col-md-6 col-sm-6 col-xs-6 filtros_asistencia">
                        <label><strong>GRUPO CANAL</strong></label>
                        <select class="form-control selectpicker" name="sel-cargo-grupo-canal" id="sel-cargo-grupo-canal" title="Grupo Canal (Todo)" data-actions-box="true" data-live-search="true" data-container="body" patron="requerido">
                            <option value="">-- Seleccione --</option>
                            <? foreach ($grupo_canal as $k => $r) { ?>
                                <option value="<?= $r['id'] ?>"><?= $r['value'] ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label><strong>CANAL</strong></label>
                            <select class="form-control selectpicker" name="sel-cargo-canal" id="sel-cargo-canal" title="Canal (Todo)" data-actions-box="true" data-live-search="true" data-container="body" patron="requerido">
                                <option value="">-- Seleccione --</option>
                                <? foreach ($canal as $k => $r) { ?>
                                    <option value="<?= $r['id'] ?>" data-grupocanal="<?= $r['idGrupoCanal'] ?>"><?= $r['value'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div id="selCargoRD" class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label><strong>DISTRIBUIDORA</strong></label>
                            <select class="form-control selectpicker" name="sel-cargo-rd" id="sel-cargo-rd" title="Distribuidora (Todo)" data-actions-box="true" data-live-search="true" data-container="body">
                                <option value="">-- Seleccione --</option>
                                <? foreach ($distribuidora as $k => $r) { ?>
                                    <option value="<?= $r['id'] ?>"><?= $r['value'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div id="selCargoPlaza" class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label><strong>PLAZA</strong></label>
                            <select class="form-control selectpicker" name="sel-cargo-plaza" id="sel-cargo-plaza" title="Plaza (Todo)" data-actions-box="true" data-live-search="true" data-container="body">
                                <option value="">-- Seleccione --</option>
                                <? foreach ($plaza as $k => $r) { ?>
                                    <option value="<?= $r['id'] ?>"><?= $r['value'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label><strong>IMAGEN</strong></label>
                            <input type="file" class="form-control-file" name="inputFileCargo" id="inputFileCargo" patron="requerido">
                        </div>
                        <button type="button" class="btn btn-outline-trade-visual" style="margin-bottom: 0px;float: right" id="btn-guardar-cargo">Guardar</button>
                    </div>
                </div>
            </form>
            <div id="resultadoGuardarCargos" style="margin-top:15px;"></div>
        </div>
        <div style="padding:20px;max-height:200px !important;overflow-y:auto;">
            <table class="table" id="tb-cargoPremiaciones" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>CANAL</th>
                        <th>DISTRIBUIDORA/PLAZA</th>
                        <th class="text-center">IMAGEN</th>
                        <th class="text-center">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody id="bodyTablaCargosPremiaciones">
                    <? $i = 1; ?>
                    <? foreach ($premiaciones_cargos as $row) { ?>
                        <tr data-id="<?= $row['idCargo']; ?>">
                            <td><?= $i++; ?></td>
                            <td><?= $row['grupoCanal']; ?></td>
                            <td><?= (!empty($row['plaza']) ? $row['plaza'] : $row['distribuidora']); ?></td>
                            <td class="text-center"><a href="javascript:;" data-foto="<?= base_url(); ?>public/files/img/<?= $row['foto']; ?>" class="prettyphoto" style="font-size: 20px;"><i class="fa fa-file-image"></i></a></td>
                            <td class="text-center"><a href="javascript:;" data-id="<?= $row['idCargo']; ?>" class="eliminarCargoPremiacion" style="font-size: 20px;"><i class="fa fa-times"></i></a></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>