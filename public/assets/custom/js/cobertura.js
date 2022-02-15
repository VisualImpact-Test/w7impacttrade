var Cobertura = {
	idFormFiltros: 'formFiltrosCobertura',
	url: 'cobertura/',
	idDivContent: 'encuestaContent',
	tabSeleccionado: 1,
	estadoConsulta: 0,

	load: function () {
		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
        });
		
		$(document).on('click','#btn-filtrarCobertura', function(e){
			e.preventDefault();
			var idTipoFormato = $('#idTipoFormato').val();
			if (idTipoFormato == 1) {
				var data = Fn.formSerializeObject(Cobertura.idFormFiltros);
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url': Cobertura.url + 'detallado', 'data': jsonString };

				$.when(Fn.ajax(config)).then(function (a) {
					$('#idDetalleHorizontal').html(a.data.html);
					$('#tablaDetalladoCobertura').DataTable(a.data.configTable);
					Fn.showLoading(false);
				});
			}
		});

		$('.btnReporte').on('click', function (e) {
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			Cobertura.tabSeleccionado = opcion;
			$(".div-para-ocultar").addClass('card');
			$("#tipoFormato").val(opcion);
			if (opcion == 1) {
				$('#idTipoFormato').val(1);
			} else if (opcion == 2) {
				$('#idTipoFormato').val(2);
				if(Cobertura.estadoConsulta == 1){
					$(".div-para-ocultar").removeClass('card');
				}
			} else if (opcion == 3) {
				$('#idTipoFormato').val(3);
			}
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarCobertura').click();
        });

		$(document).ready(function () {
			$('#btn-filtrarCobertura').click();
			$(".flt_grupoCanal").change();
			//$('#idEncuesta').selectpicker();
		});
	},
}
Cobertura.load();