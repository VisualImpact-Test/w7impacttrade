<h5>
	MODULACION CORRECTA : <?= ($flagCorrecto!=NULL)? ( ($flagCorrecto==1)? "Si" : "No" ) :"No" ?>
</h5>
<div class="table-responsive mb-3">

	<? 
		if( !empty($modulacion)){
			if( count($modulacion)>0){	
			?>
				<table class="table table-bordered table-sm text-nowrap">
					<thead class="bg-light">
						<tr class="text-center">
							<th>#</th>
							<th>ELEMENTO</th>
							<th>ESTADO</th>
						</tr>
					</thead>
					<tbody>
						<? $i = 1; ?>
						<?foreach($modulacion as $row){ ?>
							<tr>
								<td class="text-center"><?=$i++?></td>
								<td class="text-center"><?=( !empty($row['elemento']) ? $row['elemento'] :'-' )?></td>
								<td class="text-center"> <?= ($row['flagCorrectoDet']!=NULL)? ( ($row['flagCorrectoDet']==1)? "Si" : "No" ) :"No" ?></td>
							</tr>
						<? } ?>
						</tbody>
				</table>
			<?
			}
	}
	?>

	
</div>