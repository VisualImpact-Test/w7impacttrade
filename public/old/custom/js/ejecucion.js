var Ejecucion = {

	frmEjecucion : 'frm-ejecucion',
	contentDetalle: 'idContentEjecucion',
	url : 'ejecucion/',

	load: function(){

		$(document).on('click','#btn-filtrarEjecucion', function(){

			var control = $(this);
			var config = {
				'idFrm' : Ejecucion.frmEjecucion
				,'url': Ejecucion.url + control.data('url')
				,'contentDetalle': Ejecucion.contentDetalle
			};

			Fn.loadReporte(config);
		});

	}
}

Ejecucion.load();