var Encuesta = {
	idFormFiltros: 'formFiltrosEncuesta',
	url: 'encuesta/',
	idDivContent: 'encuestaContent',
	tabSeleccionado: 1,
	estadoConsulta: 0,

	load: function () {
		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
        });
		
		$(document).on('click','#btn-filtrarEncuesta', function(e){
			e.preventDefault();
			var idTipoFormato = $('#idTipoFormato').val();
			if (idTipoFormato == 1) {
				var data = Fn.formSerializeObject(Encuesta.idFormFiltros);
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url': Encuesta.url + 'getTablaEncuestas', 'data': jsonString };

				$.when(Fn.ajax(config)).then(function (a) {
					$('#idDetalleHorizontal').html(a.data.html);
					$('#tablaDetalladoEncuesta').DataTable(a.data.configTable);
					Fn.showLoading(false);
				});
			} else if (idTipoFormato == 2) {
				var data = Fn.formSerializeObject(Encuesta.idFormFiltros);
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url': Encuesta.url + 'getVistaResumen', 'data': jsonString };

				$.when(Fn.ajax(config)).then(function (a) {
					$('#idDetalleGraficas').html(a.data.html);
					anyChartCustom.dataPieCharts = a.data.graficosPieAC;
					anyChartCustom.dataColumnCharts = a.data.graficosColumnAC;
					anyChartCustom.dataBarCharts = a.data.graficosBarAC;
					anyChartCustom.setPieCharts();
					anyChartCustom.setColumnCharts();
					anyChartCustom.setBarCharts();
					Fn.showLoading(false);

					if(a.result == 0){
						$(".div-para-ocultar").addClass('card');
					}
				});
			}
		});

		$('.btnReporte').on('click', function (e) {
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			Encuesta.tabSeleccionado = opcion;
			$(".div-para-ocultar").addClass('card');
			$("#tipoFormato").val(opcion);
			if (opcion == 1) {
				$('#idTipoFormato').val(1);
			} else if (opcion == 2) {
				$('#idTipoFormato').val(2);
				if(Encuesta.estadoConsulta == 1){
					$(".div-para-ocultar").removeClass('card');
				}
			}
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarEncuesta').click();
        });

		$(document).ready(function () {
			$('#btn-filtrarEncuesta').click();
			$(".flt_grupoCanal").change();
			$('#idEncuesta').selectpicker();
		});
	},
}
Encuesta.load();