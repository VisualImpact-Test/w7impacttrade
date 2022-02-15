var mapeoMuebles = {

	frmRutas: 'frm-mapeoMuebles',
	contentDetalle: 'idContentMapeoMuebles',
	url: 'gestionGerencial/mapeoMuebles/',
	urlActivo: 'filtrar',

	load: function () {
		$(document).ready(function (e) {
			mapeoMuebles.urlActivo = $(".card-body > ul > li > .active").data("url");
			mapeoMuebles.contentDetalle = $(".card-body > ul > li > .active").data("contentdetalle");

			$('#btn-filtrarMapeoMuebles').click();
			$('.flt_grupoCanal').change();
		});

		$(document).on('click', '.card-body > ul > li > a', function () {
			var control = $(this);
			mapeoMuebles.urlActivo = control.data('url');
			mapeoMuebles.contentDetalle = control.data('contentdetalle');
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function () {
			$('#btn-filtrarMapeoMuebles').click();
		});

		$(document).on('click', '#btn-filtrarMapeoMuebles', function (e) {
			e.preventDefault();

			var config = {
				'idFrm': 'frm-mapeoMuebles'
				, 'url': mapeoMuebles.url + mapeoMuebles.urlActivo
				, 'contentDetalle': mapeoMuebles.contentDetalle
			};
			Fn.loadReporte_new(config);
		});
	}
}

mapeoMuebles.load();