<h5>PREMIACIÓN</h5>
<div class="table-responsive">
<table class="mb-0 table table-bordered table-sm text-nowrap">
	<thead class="bg-light">
		<tr class="">
			<!--th class="text-center align-middle">ENCUESTA</th-->
			<th class="text-center align-middle">#</th>
			<th class="text-center align-middle">PREGUNTA</th>
			<th class="text-center align-middle">RESPUESTA</th>
		</tr>
	</thead>
	<tbody class="bg-purple-gradient text-white">
		<? $i=1; foreach($encuestas as $row){ ?>
			<tr>
				<td class="text-center" colspan="<?=count($row['preguntas']);?>"><?=$row['encuesta']?></td>
			</tr>
			<?foreach ($row['preguntas'] as $kp => $pregunta): ?>
				<tr>
					<td class="text-center"><?=$i++?></td>
					<td class="text-center"><?=!empty($pregunta['pregunta'])? $pregunta['pregunta'] : '-'?></td>
					<td class="text-center"><?=!empty($pregunta['respuesta'])? $pregunta['respuesta'] : '-'?></td>
				</tr>	
			<?endforeach ?>
		<? } ?>
	</tbody>
</table>
</div>