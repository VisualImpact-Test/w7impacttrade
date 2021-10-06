var Ejecucion = {

	frmEjecucion : 'frm-ejecucion',
	contentDetalle: 'idContentEjecucion-dvEjecucionVisibilidad',
	url : 'ejecucion/',

	load: function(){
		
		$('#dvEjecucionVisibilidadEO').hide(400);
		$('#dvEjecucionObservacionesEO').hide(400);

		$(document).on('click','#btn-filtrarEjecucion', function(){

			var control = $(this);
			var config = {
				'idFrm' : Ejecucion.frmEjecucion
				,'url': Ejecucion.url + control.data('url')
				,'contentDetalle': Ejecucion.contentDetalle
			};

			Fn.loadReporte_new(config);
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('.btn-Consultar').click();
        });

		$(document).on('click','a[name="tipoFormato"]', function(e){
			var control = $(this);
			var value = control.data('value');

			$("#tipoFormato").val(value);
			if ( value==1) {
				$('#dvEjecucionVisibilidad').show(400);
				$('#dvEjecucionVisibilidadEO').hide(400);
				$('#dvEjecucionObservacionesEO').hide(400);
				Ejecucion.contentDetalle = 'idContentEjecucion-dvEjecucionVisibilidad';
				$('#btn-filtrarEjecucion').click();

			} else if(value==2){
				$('#dvEjecucionVisibilidad').hide(400);
				$('#dvEjecucionVisibilidadEO').show(400);
				$('#dvEjecucionObservacionesEO').hide(400);
				Ejecucion.contentDetalle = 'idContentEjecucion-dvEjecucionVisibilidadEO';
				$('#btn-filtrarEjecucion').click();

			}else if(value==3){
				$('#dvEjecucionVisibilidad').hide(400);
				$('#dvEjecucionVisibilidadEO').hide(400);
				$('#dvEjecucionObservacionesEO').show(400);
				Ejecucion.contentDetalle = 'idContentEjecucion-dvEjecucionObservacionesEO';
				$('#btn-filtrarEjecucion').click();
			}
		});

		$('.btnReporte').on('click', function(e){
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			if ( opcion==1 ) {
				$('#idTipoFormato').val(1);
			} else if ( opcion==2 ) {
				$('#idTipoFormato').val(2);
			} else if ( opcion==3 ) {
				$('#idTipoFormato').val(3);
			}
		});

		$('.tipoCanal').on('click', function(e){
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			if ( opcion==1 ) {
				$('#idTipoCanal').val(1);
			} else if ( opcion==2 ) {
				$('#idTipoCanal').val(2);
			}
		});
		setTimeout(
			function(){
				$('#btn-filtrarEjecucion').click();
			}
		, 1000);
		

	}
}

Ejecucion.load();