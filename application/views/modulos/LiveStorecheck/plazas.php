<div class="row">
	<div class="col-md-12">
		<div id="content-live-plazas-lista" class="table-responsive mt-3">
			<table id="tb-lsck-plaza" class="table table-bordered table-striped" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>DISTRIBUIDORA</th>
						<th>PLAZA</th>
						<th># TIENDAS</th>
					</tr>
				</thead>
				<tbody>
					<?$i = 1;?>
					<?foreach($plaza as $row){?>
					<tr class="pointer" data-id="<?=$row['idPlaza']?>">
						<td><?=$i++;?></td>
						<td><?=$row['distribuidora']?></td>
						<td><?=$row['nombre']?></td>
						<td><?=$row['totalTienda']?></td>
					</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$('#tb-lsck-plaza').dataTable({
		scrollY: '40vh',
	});

    $(document).off('click', '#tb-lsck-plaza tbody tr').on('click', '#tb-lsck-plaza tbody tr', function(){
        if( $(this).hasClass('selected') ){
            $(this).removeClass('selected');
        }
        else {
            $('#tb-lsck-plaza').DataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
</script>