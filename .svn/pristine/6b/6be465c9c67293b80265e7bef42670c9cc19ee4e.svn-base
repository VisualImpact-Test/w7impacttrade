var Precios = {

	idFormFiltros: 'formFiltrosPrecios',
	url: 'precios/',
	idContent: 'contentPrecios',

	load: function () {

		$('.btn-detalladoExcel').on('click', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Precios.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var url = Precios.url + "exportarDetalladoExcel";

			Fn.download(url, jsonString);
		});

		$('.btn-testPdf').on('click', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Precios.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var url = Precios.url + "testPdf";

			Fn.download(url, jsonString);
		});
		
		$('.btn-detallado').on('click', function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Precios.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Precios.url + 'getVisitasPrecios', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				$('#' + Precios.idContent).html(a.data.html);
				$('#tablaVisitasPrecios').DataTable();
			});
		});

		$('.btn-reporteFinanzas').on('click', function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Precios.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Precios.url + 'getReporteFinanzas', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$('#' + Precios.idContent).html(a.data.html);
				$('#tablaReporteFinanzas').DataTable();
			});
		});

		// $(".seccion").on("click", function () {
		// 	var seccionSeleccionada = $("input[type='radio'][name='rd-seccion']:checked").val();
		// 	if (seccionSeleccionada == "detallado") {
		// 		$.disable("#" + Precios.idFormFiltros + ' .seccionReporteFinanzas');
		// 		$.disable("#" + Precios.idFormFiltros + ' .seccionReporteDetallado', false);
		// 	} else if (seccionSeleccionada == "reporteFinanzas") {
		// 		$.disable("#" + Precios.idFormFiltros + ' .seccionReporteFinanzas', false);
		// 		$.disable("#" + Precios.idFormFiltros + ' .seccionReporteDetallado');
		// 	}
		// });

		$("#seccion").on("change", function () {
			var seccionSeleccionada = $(this).val();
			if (seccionSeleccionada == "detallado") {
				$.disable("#" + Precios.idFormFiltros + ' .seccionReporteFinanzas');
				$.disable("#" + Precios.idFormFiltros + ' .seccionReporteDetallado', false);
			} else if (seccionSeleccionada == "reporteFinanzas") {
				$.disable("#" + Precios.idFormFiltros + ' .seccionReporteFinanzas', false);
				$.disable("#" + Precios.idFormFiltros + ' .seccionReporteDetallado');
			}
		});

		$('#marca, #categoria').on("change", function () {
			var marcaSeleccionada = $("#marca").val();
			var categoriaSeleccionada = $("#categoria").val();

			var data = { "marca": marcaSeleccionada, "categoria": categoriaSeleccionada };
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Precios.url + 'getProductosForSelect', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				var selectContent = '<option value="">Seleccionar</option>';
				$.each(a.data.productos, function (i, producto) {
					selectContent += '<option value="' + producto.idProducto + '">' + producto.nombre + '</option>';
				});

				$("#" + Precios.idFormFiltros + ' #producto').html(selectContent);
			});
		});

		$("input[type='checkbox'][name='ch-competencia']").on("change", function () {

			var checksCompetencia = $("input[type='checkbox'][name='ch-competencia']:checked");
			var seleccionados = {};
			$.each(checksCompetencia, function (i, v) {
				seleccionados[i] = v.value;
			});

			var data = seleccionados;
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Precios.url + 'getMarcasForSelect', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				var selectContent = '<option value="">Seleccionar</option>';
				$.each(a.data.marcas, function (i, marca) {
					selectContent += '<option value="' + marca.idMarca + '">' + marca.nombre + '</option>';
				});

				$("#" + Precios.idFormFiltros + ' #marca').html(selectContent);
			});
		});

		$(document).ready(function () {
			$(".btn-detallado").click();
		});
	},

}
Precios.load();