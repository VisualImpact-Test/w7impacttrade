	<div class="row themeWhite">
	    <div class="col-md-12">
	        <div class="mb-3 mt-3 card">
	            <div class="card-header">
                    <div class="alert alert-warning w-100" role="alert">
						<i class="fas fa-check-circle"></i> Alerta! Las siguientes rutas contienen visitas trabajadas <br>
						<!--<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 50 filas</strong>, si usted dispone de más datos, se recomienda realizar el procedimiento dos veces.<br>-->
					</div>
	            </div>
	            <div class="card-body">
	                <div class="tab-content">
	                    <div class="form-row">
	                        <div class="col-md-12">
	                            <div class="divider"></div>
	                            <div class="table-responsive">
	                                <table id="tb-validacionRutaConData" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
	                                    <thead>
	                                        <tr>
	                                            <th class="text-center align-middle">#</th>
	                                            <th class="text-center align-middle">ID RUTA </th>
	                                            <th class="text-center align-middle">FECHA </th>
	                                            <th class="text-center align-middle">USUARIO </th>
	                                            <th class="text-center align-middle">TIPO USUARIO</th>
	                                            <th class="text-center align-middle">VISITAS TRABAJADAS</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <? $ix = 1; ?>
	                                        <? foreach ($rutasData as $klr => $row) : ?>
	                                            <tr class="tr-reprogramarRuta" data-ruta="<?= $row['idRuta'] ?>" data-usuario="<?= $row['idUsuario'] ?>">
	                                                <td class="text-center"><?= $ix++; ?></td>
	                                                <td class="text-center"><?= (!empty($row['idRuta']) ? $row['idRuta'] : '-') ?></td>
	                                                <td class="text-center"><?= (!empty($row['fecha']) ? $row['fecha'] : '-') ?></td>
	                                                <td class=""><?= (!empty($row['nombreUsuario']) ? $row['nombreUsuario'] : '-') ?></td>
	                                                <td class=""><?= (!empty($row['tipoUsuario']) ? $row['tipoUsuario'] : '-') ?></td>
	                                                <td class="text-center"><?= (!empty($row['cantVisitas']) ? $row['cantVisitas'] : '-') ?></td>
	                                                <td class="text-center"></td>
	                                            </tr>
	                                        <? endforeach ?>
	                                    </tbody>
	                                </table>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>