var Encuesta = {

	idFormFiltros: 'formFiltrosEncuesta',
	url: 'encuesta/',
	idDivContent: 'encuestaContent',

	load: function () {

		$('.btn-detallado').on('click', function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Encuesta.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Encuesta.url + 'getTablaEncuestas', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$('#' + Encuesta.idDivContent).html(a.data.html);
				$('#tablaDetalladoEncuesta').DataTable();
			});
		});

		$('.btn-resumen').on('click', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Encuesta.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Encuesta.url + 'getVistaResumen', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				$('#' + Encuesta.idDivContent).html(a.data.html);

				AnyChartCustom.setPieCharts(a.data.graficosPieAC);
				AnyChartCustom.setColumnCharts(a.data.graficosColumnAC);
				AnyChartCustom.setBarCharts(a.data.graficosColumnAC);
			});
		});

	},



}
Encuesta.load();