<script>
	$('#detalle_scorecard').DataTable();
</script>
<div class="col-lg-12 ">
		<div class="mb-3 card">
			<div class="card-body">

			<table id="detalle_scorecard" class="table table-striped table-bordered nowrap"  style="font-size: 90%">
				<thead>
					<tr>
						<th>N°</th>
						<th>COD VISUAL</th>
						<th>EJECUTIVO</th>
						<th>COORDINADOR</th>
						<th>SUPERVISOR</th>
						<th>GRUPO CANAL</th>
						<th>DISTRIBUIDORA/PLAZA</th>
						<th>CIUDAD</th>
						<th>CANAL</th>
						<th>SUBCANAL</th>
						<th>COD DISTRIBUIDORA</th>
						<th>RAZON SOCIAL</th>
						<th>DIRECCION</th>
					</tr>
				</thead>
				<tbody>
					<? $i=1; foreach($cartera as $row){ ?>
					<tr>
						<td style="text-align:center;"><?=$i?></td>
						<td style="text-align:center;"><?=$row['idCliente']?></td>
						<td style="text-align:center;"><?=$row['ejecutivo']?></td>
						<td style="text-align:center;"><?=$row['coordinador']?></td>
						<td style="text-align:center;"><?=$row['supervisor']?></td>
						<td style="text-align:center;"><?=$row['grupoCanal']?></td>
						<td style="text-align:center;"><?=$row['DISTRIBUIDORA-PLAZA']?></td>
						<td style="text-align:center;"><?=$row['CIUDAD']?></td>
						<td style="text-align:center;"><?=$row['canal']?></td>
						<td style="text-align:center;"><?=$row['subcanal']?></td>
						<td style="text-align:center;"><?=$row['codCliente']?></td>
						<td style="text-align:center;"><?=$row['razonSocial']?></td>
						<td style="text-align:center;"><?=$row['direccion']?></td>
					</tr>
					<? $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
