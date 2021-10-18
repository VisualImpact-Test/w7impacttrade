var IniciativasSimple = {

	idFormFiltros: 'formFiltroIniciativas',
	url: 'IniciativasSimple/',
	idDivContent: 'contentIniciativas',
	idTableDetalle: 'tb-Iniciativas',

	load: function () {
		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
		});

		$('.btn-consultar').on('click', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(IniciativasSimple.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': IniciativasSimple.url + 'lista_iniciativas', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$('#' + IniciativasSimple.idDivContent).parent().removeClass("hide");
				$('#' + IniciativasSimple.idDivContent).html(a.data);
				var $datatable = $('#data-table');

				$datatable.DataTable();
			});
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('.btn-consultar').click();
		});

		$('.btnReporte').on('click', function (e) {
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			$('#idReporte').val(opcion);
			$('.btn-consultar').click();
		});
	}
}
IniciativasSimple.load();