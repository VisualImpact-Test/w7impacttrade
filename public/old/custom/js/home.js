var Home={
	
	
	
	load: function(){

			$('#tb-list').DataTable({
						//order: [[ 1, 'asc' ]],
						buttons: {
							buttons: [
								{ extend: 'excel', className: 'btn btn-danger', title: 'pedidos_pendientes', text: 'Exportar <i class="fa fa-file-excel-o"></i>',exportOptions: {
							columns: 'th:not(:first-child):not(:nth-child(2))'
						 } }
							]
						}
					});
	}

}
Home.load();