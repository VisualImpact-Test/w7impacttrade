var Fotos = {

	idFormFiltros: 'formFiltrosFotos',
	idFormExportarPdf: 'formExportarPdf',
	url: 'fotos/',
	fotosContenido: 'fotosContent',
	paginacionFotos: 'paginacionFotos',
	contenedorPaginacionFotos: 'contentPaginacionFotos',

	load: function () {

		$('.btn-buscar').on('click', function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Fotos.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Fotos.url + 'getFotosClientes', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				$('#' + Fotos.fotosContenido).html(a.data.html);

				if(typeof a.data.fotosClientes !== 'undefined'){
					Fotos.llenarPaginacionFotos(a.data.fotosClientes);
				}
			});
		});

		$(document).on('click', '.btn-getFormExportarPdf', function (e) {
			e.preventDefault();

			var jsonString = { 'data': ''};
			var config = { 'url': Fotos.url + 'getFormExportarPdf', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				++modalId;
				var fn1 = 'Fotos.exportarPDF();';
				var fn2 = 'Fn.showModal({ id:' + modalId + ',show:false });';

				var btn = [];
				btn[0] = { title: 'Exportar PDF', fn: fn1 };
				btn[1] = { title: 'Cerrar', fn: fn2 };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});

		$(document).on('click', '.btn-verMasFotos', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Fotos.idFormFiltros);
			data['fotosClientes'] = $(this).data('objectfotos');
			data['tipoUsuario'] = $(this).data('tipousuario');
			data['usuario'] = $(this).data('usuario');
			data['fecha'] = $(this).data('fecha');

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Fotos.url + 'getVistaMasFotos', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});

		$( document ).ready(function() {
			$( ".btn-buscar" ).click();
		});		
	},

	llenarPaginacionFotos: function (fotosClientes) {
		var paginacion = $('#paginacionFotos');
		var contenedorPaginacion = $('#contentPaginacionFotos');
		var contenido = [];

		$.each(fotosClientes, function (i, v) {
			contenido.push(v);
		});

		var options = {
			pageSize: 3,
			showGoInput: true,
			showGoButton: true,
			goButtonText: 'Ir',
			dataSource: contenido,
			callback: function (response, pagination) {
				var dataHtml = '';

				$.each(response, function (indexCliente, cliente) {

					dataHtml+="<div class='col-md-12 clienteFotos mt-4'>";
						dataHtml+="<div class='main-card card'>";
							dataHtml+="<div class='card-body'>";
								dataHtml+="<div class='row mb-2'>";
									dataHtml+="<div class='col-md-12'>";
										dataHtml+="<h2 class='font-weight-bold'>" + cliente.razonSocial +"</h2>";
									dataHtml+="</div>";
								dataHtml+="</div>";
								dataHtml+="<div class='row mb-2'>";
									dataHtml+="<div class='col-md-2'><label><span class='font-weight-bold'>COD VI: </span>"+ cliente.idCliente +"</label><br><label><span class='font-weight-bold'>COD PDV: </span>"+ cliente.codCliente +"</label></div>";
									dataHtml+="<div class='col-md-5'><label><span class='font-weight-bold'>Dirección: </span>"+ cliente.direccion +"</label><br><label><span class='font-weight-bold'>Ubicación: </span>"+ cliente.departamento + " - " + cliente.provincia + " - " + cliente.distrito +"</label></div>";
									dataHtml+="<div class='col-md-3'><label><span class='font-weight-bold'>Distribuidora: </span>Demo</label><br><label><span class='font-weight-bold'>Sucursal: </span>Demo</label></div>";
									dataHtml+="<div class='col-md-2'><label><span class='font-weight-bold'>Canal: </span>"+ cliente.canal +"</label></div>";
								dataHtml+="</div>";
								dataHtml+="<div class='row'>";

									$.each(cliente.visitas, function (indexVisita, visita) { 
										var fotoPreview = visita.fotos[Object.keys(visita.fotos)[0]].imgRef;
										var cantidadFotos = Object.keys(visita.fotos).length;
										var stringFoto = (cantidadFotos > 1) ? ' fotos' : ' foto';
										var urlFoto = 'http://movil.visualimpact.com.pe/fotos/impactTrade_android/moduloFotos/' + fotoPreview;
										var objectFotos = JSON.stringify(visita.fotos);

										dataHtml+="<div class='col-md-4 fotoPorVisita mb-3'>";
											dataHtml+="<div class='main-card card text-center'><img class='card-img' src='" + urlFoto +"' alt='Card image'>";
												dataHtml+="<div class='card-img-overlay'>";
													dataHtml+="<a href='#' data-usuario='" + visita.usuario +"' data-tipousuario='"+ visita.tipoUsuario +"' data-fecha='"+ visita.fecha +"' data-objectfotos='" + objectFotos +"' class='btn-verMasFotos btn btn-secondary'>Ver " + cantidadFotos + stringFoto +"</a>";
												dataHtml+="</div>";
												dataHtml+="<div class='card-body p-2'>";
													dataHtml+="<p class='card-text'>Fecha: " + visita.fecha +" | " + visita.tipoUsuario +": " + visita.usuario +"</p>";
												dataHtml+="</div>";
											dataHtml+="</div>";
										dataHtml+="</div>";

									});

								dataHtml+="</div>";
							dataHtml+="</div>";
						dataHtml+="</div>";
					dataHtml+="</div>";

				});

				contenedorPaginacion.html(dataHtml);
			}
		}
		
		paginacion.pagination(options);
	},

	exportarPDF: function () {
		var data1 = Fn.formSerializeObject(Fotos.idFormFiltros);
		var data2 = Fn.formSerializeObject(Fotos.idFormExportarPdf);
		var data = $.extend({}, data1, data2);

		var jsonString = { 'data': JSON.stringify(data) };
		var url = Fotos.url + "exportarPdf";

		Fn.download(url, jsonString);
	}

}
Fotos.load();