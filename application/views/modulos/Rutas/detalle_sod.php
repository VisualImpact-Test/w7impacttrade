<?foreach($categorias as $ix_cat => $row_cat){?>
	<h5><?=$row_cat['categoria']?></h5>
	<div class="table-responsive">
		<table class="mb-0 table table-bordered table-sm text-nowrap">
			<thead>
				<tr>
					<th class="text-center align-middle">#</th>
					<th class="text-center align-middle">TIPO ELEMENTO</th>
					<th class="text-center align-middle">MARCA</th>
					<th class="text-center align-middle">CANTIDAD</th>
					<th class="text-center align-middle">FOTOS</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?$i=1;?>
				<?foreach($elementos[$ix_cat] as $ix => $row){?>
					<tr>
						<td><?=$i++?></td>
						<td><?=$row['tipoElemento']?></td>
						<td><?=$row['marca']?></td>
						<td><?=$row['cantidad']?></td>
						<td>
							<?$fotos_ = ''; foreach($fotos[$ix_cat][$ix] as $row_){?>
								<? $fotos_ .=  !empty($row_['foto'])? '<a href="javascript:;" class="lk-foto" data-fotoUrl="'.$this->fotos_url.'sod/'.$row_['foto'].'"  ><img src="'.$this->fotos_url.'sod/'.$row_['foto'].'" style="width:16px;border: 1px solid #CCC;" /></a>' :'';?>
							<?}?>
							<?=!empty($fotos_)? $fotos_ : '-';?>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</div>
<?}?>