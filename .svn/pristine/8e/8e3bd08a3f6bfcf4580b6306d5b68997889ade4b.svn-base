<?foreach($categorias as $id_cat => $row_cat){?>
	<h5><?=$row_cat['categoria']?></h5>
	<div class="table-responsive">
		<table class="mb-0 table table-bordered table-sm text-nowrap">
			<thead>
				<tr class="">
					<th class="text-center align-middle">#</th>
					<th class="text-center align-middle">FOTO</th>
				</tr>
			</thead>
			<tbody>
				<? $i=1; foreach($encartes[$id_cat] as $row_en){ ?>
					<tr>
						<td class="text-center"><?=$i++?></td>
						<td class="text-center">
							<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$this->fotos_url.'encartes/'.$row_en['foto']?>"  >
							<?=($row_en['foto']!=0)?'<img src="'.$this->fotos_url.'encartes/'.$row_en['foto'].'" style="width:96px;border: 2px solid #CCC;" />':'-';?></a>
						</td>
					</tr>
				<? } ?>
			</tbody>
		</table>
	</div>
<?}?>