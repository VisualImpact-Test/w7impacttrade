<h5>VISIBILIDAD - SOS</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead>
			<tr>
				<th class="text-center align-middle">#</th>
				<th class="text-center align-middle">CATEGORIA</th>
				<th class="text-center align-middle">MARCA</th>
				<th class="text-center align-middle">cm</th>
				<th class="text-center align-middle">FRENTES</th>
				<th class="text-center align-middle">COMPETENCIA</th>
				<th class="text-center align-middle">FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i=1; foreach($sos as $row){ ?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$row['categoria']?></td>
					<td><?=$row['marca']?></td>
					<td class="text-center"><?=$row['cm']?></td>
					<td class="text-center"><?=$row['frentes']?></td>
					<td class="text-center" ><?=(!empty($row['flagCompetencia']))? 'SI' :'-';?></td>
					<td class="text-center">
						<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$this->fotos_url.'sos/'.$row['foto']?>"  >
						<?=($row['foto']!=0)?'<img src="'.$this->fotos_url.'sos/'.$row['foto'].'" style="width:96px;border: 2px solid #CCC;" />':'-';?></a>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>