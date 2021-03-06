<? $verTransferenciaAgregados = ($htmlTranferirAgregados) ? '' : 'd-none'; ?>
<div class="card-datatable">
	<table id="tb-maestrosClientesAgregados" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center" rowspan="2">#</th>
				<? if ($htmlTranferirAgregados) : ?>
					<th class="text-center" colspan="5">OPCIONES</th>
				<? else : ?>
					<th class="text-center" colspan="3">OPCIONES</th>
				<? endif ?>
				<th class="text-center" colspan="4">DATOS GENERALES</th>
				<th class="text-center" colspan="5">DATOS UBICACIÓN</th>
				<th class="text-center" colspan="7">DATOS HISTÓRICOS</th>
				<th class="text-center" colspan="3">SEGMENTACIÓN<br>NEGOCIO</th>
				<th class="text-center" colspan="4">SEGMENTACIÓN<br>CLIENTE<br>TRADICIONAL</th>
				<th class="text-center" colspan="2">SEGMENTACIÓN<br>CLIENTE<br>MODERNO</th>

			</tr>
			<tr>
				<th class="text-center <?= $verTransferenciaAgregados; ?>">ALL<br><input type="checkbox" id="chkb-deBajaAllAgregados" name="chkb-deBajaAllAgregados" class="dataDeBajaTodo"></th>
				<th class="text-center">ESTADO<br>TRANSFERIR</th>
				<th class="text-center">RECHAZAR</th>
				<th class="text-center <?= $verTransferenciaAgregados; ?>">ESTADO<br>FECHA<br>FIN</th>
				<th class="text-center">EDITAR</th>

				<th class="text-center">RAZÓN<br>SOCIAL</th>
				<th class="text-center">NOMBRE<br>COMERCIAL</th>
				<th class="text-center">DNI</th>
				<th class="text-center">RUC</th>

				<th class="text-center">DEPARTAMENTO</th>
				<th class="text-center">PROVINCIA</th>
				<th class="text-center">DISTRITO</th>
				<th class="text-center">DIRECCIÓN</th>
				<th class="text-center">REFERENCIA</th>

				<th class="text-center">ZONA PELIGROSA</th>
				<th class="text-center">COD<br>CLIENTE</th>
				<th class="text-center">CARTERA<br>CLIENTE</th>
				<th class="text-center">FECHA<br>INICIO</th>
				<th class="text-center">FECHA<br>FIN</th>
				<th class="text-center">CUENTA</th>
				<th class="text-center">PROYECTO</th>

				<th class="text-center">GRUPO CANAL</th>
				<th class="text-center">CANAL</th>
				<th class="text-center">CLIENTE TIPO</th>

				<th class="text-center">FRECUENCIA</th>
				<th class="text-center">ZONA</th>
				<th class="text-center">PLAZA</th>
				<th class="text-center">DISTRIBUIDORA SUCURSAL</th>

				<th class="text-center">CADENA</th>
				<th class="text-center">BANNER</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1;
			$estiloBloqueado = '';
			$estadoPDV = '';
			$estadoPDVChkb = '-';
			$estadoTransferir = '';
			$estadoRechazar = '';
			$editarPdv = ''; ?>
			<? foreach ($listaAgregados as $kla => $agregado) : ?>
				<?
				switch ($agregado['idSolicitudTipo']) {
					case 1:
						$estadoTransferir = '<span class="badge badge-primary">' . $agregado['solicitudTipo'] . '</span>';
						$estadoRechazar = '<button class="btn btn-outline-secondary border-0 rechazarSolicitud" title="Rechazar Transferencia" data-cliente="' . $agregado['idClientePg'] . '" data-clienteHistorico="' . $agregado['idClienteHistPg'] . '" data-tabla="pg_v1"><i class="fas fa-lg fa-thumbs-down"></i></button>';
						$editarPdv = '<button class="btn btn-outline-secondary border-0 editarClienteHistoricoAgregado" title="Editar PDV" data-cliente="' . $agregado['idClientePg'] . '" data-clienteHistorico="' . $agregado['idClienteHistPg'] . '" data-tabla="pg_v1"><i class="fas fa-lg fa-edit"></i></button>';

						$estado = true;

						if (!(empty($agregado['fecFin']))) {
							$f = explode("/", $agregado['fecFin']);
							$tm = strtotime($f[1] . "/" . $f[0] . "/" . $f[2]);
							$ts = strtotime(date('m/d/Y'));
							if ($ts > $tm) {
								$estado = false;
							}
						}

						if ((empty($agregado['fecFin'])) || $estado) {
							$estadoPDVChkb = '<input type="checkbox" name="solicitudRegistro" class="dataSolicitudRegistro" data-cliente="' . $agregado['idClientePg'] . '" data-clienteHistorico="' . $agregado['idClienteHistPg'] . '">';
							$estadoPDV = '<a href="javascript:;" id="ch-ca-' . $agregado['idClienteHistPg'] . '" class="btn btn-outline-secondary border-0 cambiarEstado" title="Activado" data-cliente="' . $agregado['idClientePg'] . '" data-clienteHistorico="' . $agregado['idClienteHistPg'] . '" data-estado="1" data-tabla="pg_v1"><i class="fas fa-toggle-on fa-lg"></i></a>';
							$estiloBloqueado = '';
						} else {
							$estadoPDVChkb = '<span>-</span>';
							$estadoPDV = '<a href="javascript:;" id="ch-ca-' . $agregado['idClienteHistPg'] . '" class="btn btn-outline-secondary border-0 cambiarEstado" title="Desactivado" data-cliente="' . $agregado['idClientePg'] . '" data-clienteHistorico="' . $agregado['idClienteHistPg'] . '" data-estado="0" data-tabla="pg_v1"><i class="fas fa-toggle-off fa-lg"></i></a>';
							$estiloBloqueado = 'tdBloqueado';
						}
						break;
					case 2:
						$estadoTransferir = '<span class="badge badge-success">' . $agregado['solicitudTipo'] . '</span>';
						$estadoPDVChkb = '<span>-</span>';
						$estadoRechazar = '<span>-</span>';
						$estadoPDV = '<span>-</span>';
						$editarPdv = '<span>-</span>';
						break;
					case 3:
						$estadoTransferir = '<span class="badge badge-danger">' . $agregado['solicitudTipo'] . '</span>';
						$estadoPDVChkb = '<span>-</span>';
						$estadoRechazar = '<button class="btn btn-outline-secondary border-0 verRechazo" title="Ver Motivo Rechazo" data-cliente="' . $agregado['idClientePg'] . '" data-clienteHistorico="' . $agregado['idClienteHistPg'] . '" data-tabla="pg_v1"><i class="fas fa-lg fa-eye"></i></button>';
						$estadoPDV = '<span>-</span>';
						$editarPdv = '<span>-</span>';
					default:
						$estadoPDVChkb = '<span>-</span>';
						$estadoPDV = '<span>-</span>';
						$estiloBloqueado = '';
						break;
				}
				?>
				<tr id="tr-ca-<?= $agregado['idClienteHistPg'] ?>" class="<?= $estiloBloqueado ?>" data-clienteHistorico="<?= $agregado['idClienteHistPg'] ?>">
					<td class="text-center"><?= $ix++; ?></td>
					<td class="text-center <?= $verTransferenciaAgregados; ?>" id="chkb-ca-<?= $agregado['idClienteHistPg'] ?>"><?= $estadoPDVChkb; ?></td>
					<td class="text-center style-icons" id="lb-estTransferir-<?= $agregado['idClienteHistPg'] ?>"><?= $estadoTransferir; ?></td>
					<td class="text-center" id="btn-rechazar-<?= $agregado['idClienteHistPg'] ?>"><?= $estadoRechazar; ?></td>
					<td class="text-center <?= $verTransferenciaAgregados; ?>" id="btn-ca-<?= $agregado['idClienteHistPg'] ?>"><?= $estadoPDV; ?></td>
					<td class="text-center" id="btn-editar-ca-<?= $agregado['idClienteHistPg'] ?>"><?= $editarPdv; ?></td>
					<td class=""><?= (!empty($agregado['razonSocial']) ? $agregado['razonSocial'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['nombreComercial']) ? $agregado['nombreComercial'] : '-'); ?></td>
					<td class="text-center"><?= (!empty($agregado['dni']) ? $agregado['dni'] : '-'); ?></td>
					<td class="text-center"><?= (!empty($agregado['ruc']) ? $agregado['ruc'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['departamento']) ? $agregado['departamento'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['provincia']) ? $agregado['provincia'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['distrito']) ? $agregado['distrito'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['direccion']) ? $agregado['direccion'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['referencia']) ? $agregado['referencia'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['zonaPeligrosa']) ? $agregado['zonaPeligrosa'] : '-'); ?></td>
					<td class="text-center"><?= (!empty($agregado['codCliente']) ? $agregado['codCliente'] : '-'); ?></td>
					<td class="text-center"><?= (!empty($agregado['carteraCliente']) ? $agregado['carteraCliente'] : '-'); ?></td>
					<td class="text-center"><?= (!empty($agregado['fecIni']) ? $agregado['fecIni'] : '-'); ?></td>
					<td class="text-center" id="tdFf-ca-<?= $agregado['idClienteHistPg'] ?>"><span><?= (!empty($agregado['fecFin']) ? $agregado['fecFin'] : '-'); ?></span></td>
					<td class=""><?= (!empty($agregado['cuenta']) ? $agregado['cuenta'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['proyecto']) ? $agregado['proyecto'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['grupoCanal']) ? $agregado['grupoCanal'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['canal']) ? $agregado['canal'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['clienteTipo']) ? $agregado['clienteTipo'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['frecuencia']) ? $agregado['frecuencia'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['zona']) ? $agregado['zona'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['plaza']) ? $agregado['plaza'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['distribuidoraSucursal']) ? implode(", <br>", $agregado['distribuidoraSucursal']) : '-'); ?></td>
					<td class=""><?= (!empty($agregado['cadena']) ? $agregado['cadena'] : '-'); ?></td>
					<td class=""><?= (!empty($agregado['banner']) ? $agregado['banner'] : '-'); ?></td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</div>