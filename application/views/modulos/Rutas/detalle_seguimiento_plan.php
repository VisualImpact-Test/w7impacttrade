<?foreach($planes as $id_p => $row_p){?>
	<h5><?=$row_p['plan_']?></h5>
	<div class="table-responsive">
		<table class="mb-0 table table-bordered table-sm text-nowrap">
			<thead>
				<tr>
					<th class="text-center align-middle">#</th>
					<th class="text-center align-middle">TIPO ELEMENTO</th>
					<th class="text-center align-middle">ARMADO</th>
					<th class="text-center align-middle">REVESTIDO</th>
					<th class="text-center align-middle">MOTIVO</th>
					<th class="text-center align-middle">COMENTARIO</th>
					<!--<th >FOTO</th>-->
				</tr>
			</thead>
			<tbody>
				<? $i=1; foreach($seguimiento[$id_p] as $row){ ?>
					<tr>
						<td><?=$i++?></td>
						<td><?=$row['tipoElemento']?></td>
						<td class="text-center" ><?=!empty($row['armado'] )? '<strong>SI</strong>' : '-'?></td>
						<td class="text-center" ><?=!empty($row['revestido'] )? '<strong>SI</strong>' : '-'?></td>
						<td><?=!empty($row['motivo'])? $row['motivo'] : '-'?></td>
						<td><?=!empty($row['comentario'])? $row['comentario'] : '-'?></td>
						<!--<td class="text-center">
							<a href="javascript:;" class="lk-foto" data-fotoUrl="<?='http://movil.visualimpact.com.pe/fotos/impactTrade_Android/seguimientoPlan/'.$row->foto?>"  >
							<?=($row->foto!=0)?'<img src="http://movil.visualimpact.com.pe/fotos/impactTrade_Android/seguimientoPlan/'.$row->foto.'" style="width:96px;border: 2px solid #CCC;" />':'-';?></a>
						</td>-->
					</tr>
				<? } ?>
			</tbody>
		</table>
	</div>
<?}?>