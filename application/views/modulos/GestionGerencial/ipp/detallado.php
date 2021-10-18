<div class="card-datatable">
	<div class="panel panel-default">
			<div class="panel-body" style="min-height: 100px; padding: 0px !important;"> 
				<div  id="idContentDetallado" class="widget-content table-responsive-ipp table-responsive table-content">
					<table id="tb-detalle-horizontal" class="table table-bordered" ><!--class="table tb-scroll- tb-scroll"-->
						<thead class="thead-dark">
							<tr>
								<th rowspan="3">#</th>
								<th rowspan="3">FECHA</th>
								<th rowspan="3">TIPO DE USUARIO</th>
								<th rowspan="3">COD <br />USUARIO</th>
								<th rowspan="3">USUARIO</th>
								<th rowspan="3">CANAL</th>
								<th rowspan="3">CADENA</th>
								<th rowspan="3">BANNER</th>
								<th rowspan="3">COD VI</th>
								<th rowspan="3">COD PDV</th>
								<th rowspan="3">PDV</th>
								<th rowspan="3">DIRECCIÓN</th>
								<th rowspan="3">DEPARTAMENTO</th>
								<th rowspan="3">PROVINCIA</th>
								<th rowspan="3">DISTRITO</th>
								<? foreach ($preguntas as $key => $pregunta): ?>
									<th colspan="<?=count($pregunta['alternativas'])?>"><?=$pregunta['pregunta']?></th>
								<? endforeach ?>
							</tr>
							<tr>
								<? foreach ($preguntas as $key => $pregunta): ?>
									<? foreach ($pregunta['alternativas'] as $key => $alternativa): ?>
										<th><?=$alternativa['alternativa']?></th>
									<? endforeach ?>
								<? endforeach ?>
							</tr>
							<tr>
								<? foreach ($preguntas as $key => $pregunta): ?>
									<? foreach ($pregunta['alternativas'] as $key => $alternativa): ?>
										<th><?=(is_null($alternativa['puntaje']))?0:$alternativa['puntaje']?></th>
									<? endforeach ?>
								<? endforeach ?>
							</tr>
						</thead>
						<tbody>
							<?$k=1; foreach ($visitas as $key => $row): ?>
								<tr>
									<td class="text-center" ><?=($k++)?></td>
									<td class="text-center"><?=$row['fecha']?></td>
									<td class="text-center"><?=$row['tipoUsuario']?></td>
									<td class="text-center"><?=$row['idUsuario']?></td>
									<td><?=$row['usuario']?></td>
									<td><?=$row['canal']?></td>
									<td><?=$row['cadena']?></td>
									<td><?=$row['banner']?></td>
									<td class="text-center"><?=$row['idCliente']?></td>
									<td class="text-center"><?=$row['codCliente']?></td>
									<td><?=$row['razonSocial']?></td>
									<td><?=$row['direccion']?></td>
									<td><?=$row['departamento']?></td>
									<td><?=$row['provincia']?></td>
									<td><?=$row['distrito']?></td>
									<? foreach ($preguntas as $key => $pregunta): ?>
										<? foreach ($pregunta['alternativas'] as $key => $alternativa): ?>
											<? if ( isset($pregAlternativas[$row['idVisita']]['preguntas'][$pregunta['idPregunta']]['alternativas'][$alternativa['idAlternativa']] )   ){ ?>
												<td class="text-center">SÍ</td>
											<? } else { ?>
												<td class="text-center">-</td>
											<? } ?>
										<? endforeach ?>
									<? endforeach ?>
								</tr>
							<? endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<style type="text/css">

</style>
<script>
	// $("#tb-detalle").tableHeadFixer({

	// 	// fix table header
	// 	head: true,

	// 	// fix table footer
	// 	foot: false,

	// 	// fix x left columns
	// 	left: 9,

	// 	// z-index
	// 	'z-index': 0

	// 	}); 

	$('#tb-detalle-horizontal').DataTable();
</script>