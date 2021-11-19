var PremiacionesSimple = {

	idFormFiltros: 'formFiltroPremiaciones',
	url: 'premiacionesSimple/',
	idDivContent: 'contentPremiaciones',
	idTableDetalle: 'tb-Premiaciones',

	load: function () {
		
		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
        });

		$('#btn-consultar').on('click', function (e) {
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm': PremiacionesSimple.idFormFiltros
				, 'url': PremiacionesSimple.url + 'lista_premiaciones'
				, 'contentDetalle': PremiacionesSimple.idDivContent
			};
			Fn.loadReporte_new(config);
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-consultar').click();
        });

		$("#btn-pdf").on("click", function (e) {
			e.preventDefault();

			var datos = {};

			var f = $('#txt-fechas').val();
			var fechas = f.split('-');

			//datos['fecIni'] = fechas[0];
			//datos['fecFin'] = fechas[1];
			var datos = Fn.formSerializeObject('formFiltroPremiaciones');
			datos['fecIni']= fechas[0];
			datos['fecFin']= fechas[1];
			
			var data = { 'data': JSON.stringify({ datos }) };
			var url = PremiacionesSimple.url + 'premiaciones_pdf';
			Fn.download(url, data);
		});

		$(document).on("change", "#sel-cargo-grupo-canal", () => {
			$('#sel-cargo-canal option')
				.hide() // hide all
				.filter('[data-grupocanal="' + $('#sel-cargo-grupo-canal').val() + '"]') // filter options with required value
				.show(); // and show them
		});

		$(document).on('click', '.prettyphoto', function (e) {
			e.preventDefault();

			++modalId;

			var foto = $(this).data('foto');

			Fn.showLoading(true);

			$.when($.post(site_url + "premiaciones/mostrarFoto", { foto: foto }, function (data) {
				dataBody = data;
			})).then(() => {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };

				Fn.showLoading(false);
				Fn.showModal({ id: modalId, show: true, title: "FOTOS", content: dataBody, btn: btn });
			});
		});

		$(document).ready(function () {
			$('#btn-consultar').click();
		});
	},
}
PremiacionesSimple.load();