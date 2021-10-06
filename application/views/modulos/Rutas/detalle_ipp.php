<? foreach($encuesta as $row=>$value){?>
	<h5><?=$value['name'];?></h5>
	<div class="table-responsive">
		<table class="mb-0 table table-bordered table-sm text-nowrap">
			<thead>
				<tr  class="bg-purple-gradient text-white">
					<th class="text-center align-middle">#</th>
					<th class="text-center align-middle">PREGUNTA</th>
					<th class="text-center align-middle">RESPUESTA</th>
					<th class="text-center align-middle">PUNTAJE</th>
				</tr>
			</thead>
			<tbody>
			<?$i= 1; foreach($pregunta[$row] as $row_p=>$value_p){?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$value_p['pregunta'];?></td>
					<?if(count($value_p['respuestas']) > 1 ){?>
						<td >
						<?foreach($value_p['respuestas'] as $row_r){?>
							<?=$row_r.'<br />';?>
						<?}?>
						</td>
						<td  class="text-center"><?=!empty($value_p['puntaje'])? $value_p['puntaje'] : '-';?></td>
					<?} else {?>
						<td ><?=$value_p['respuesta'];?></td>
						<td class="text-center" ><?=!empty($value_p['puntaje'])? $value_p['puntaje'] : '-';?></td>
					<?}?>
				</tr>
			<?}?>
			</tbody>
		</table>
	</div>
<?}?>
