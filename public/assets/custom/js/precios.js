var Precios = {

	idFormFiltros: 'formFiltrosPrecios',
	url: 'precios/',
	idContent: 'contentPrecios',
	urlActivo: '',
	myChart: '',
	myDatatable:'',
	load: function () {

		$(document).ready(function (e) {
			$(".card-body > ul > li > a[class*='active']").click();

			$('#sl_anio').select2({
				width: '100%',
			});
			$('#sl_semanas').select2({
				width: '100%',
				maximumSelectionLength: 12,
				minimumSelectionLength: 1,
				closeOnSelect: false

			});
		});

		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
			Precios.urlActivo = control.data('url');
			Precios.idContent = control.data('contentdetalle');

		});

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

			var config = {
				'idFrm': Precios.idFormFiltros
				, 'url': Precios.url + Precios.urlActivo
				, 'contentDetalle': Precios.idContent
			};
			Fn.loadReporte_new(config);
		});

		$('.btn-consultar').on('click', function (e) {
			e.preventDefault();

			$('.filtros_secundarios').show();
			var config = {
				'idFrm': Precios.idFormFiltros
				, 'url': Precios.url + Precios.urlActivo
				, 'contentDetalle': Precios.idContent
			};
			Fn.loadReporte_validado(config);
		});
		$('.btn-precio-variabilidad').on('click', function (e) {
			e.preventDefault();

			$('.filtros_secundarios').show();
			var config = {
				'idFrm': Precios.idFormFiltros
				, 'url': Precios.url + Precios.urlActivo
				, 'contentDetalle': Precios.idContent
			};

			Precios.loadReporte_validado_variabilidad(config);
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			let dataurl = $('.card-body > ul > li > a.active').data('url');

			switch (dataurl) {
				case 'getVisitasPrecios':
					$('.btn-detallado').click();
					break;
				case 'getReporteFinanzas':
					$('.btn-reporteFinanzas').click();
					break;
				case 'getDetalladoPrecios':
					$('.btn-consultar').click();
					break;
				case 'getVariabilidadPrecios':
					$('.btn-precio-variabilidad').click();
					break;
				default:
					$('.btn-detallado').click();
			}
		});

		$('.btn-reporteFinanzas').on('click', function (e) {
			e.preventDefault();

			var config = {
				'idFrm': Precios.idFormFiltros
				, 'url': Precios.url + 'getReporteFinanzas'
				, 'contentDetalle': 'contentFinanzas'
			};
			Fn.loadReporte_new(config);
		});

		$(".tabSeccion").on("click", function () {
			let control = $(this);
			let contenedor = control.attr('id');
			$('.secciones').hide();
			// $.disable("#" + Precios.idFormFiltros + '.secciones');
			// $.disable("#" + Precios.idFormFiltros + `.${contenedor}`, false);
			$(`.${contenedor}`).show();
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

		$(document).on('change', '#empresa_filtro', function (e) {
			let idEmpresa = $(this).val();
			$(".categoria_filtro_content").html('<option value=""> -- Categoria --</option>');
			if(idEmpresa != ''){
				let data = { "idEmpresa": idEmpresa };
				let jsonString = { 'data': JSON.stringify(data) };
				let config = { 'url': Precios.url + 'cargarCategorias', 'data': jsonString };
				$.when(Fn.ajax(config)).then(function (a) {
					$(".categoria_filtro_content").html(a.data.htmlcategorias);
				});
			}
		});

		$(document).ready(function () {
			// $(".btn-detallado").click();
			$(".flt_grupoCanal").change();
		});

		$(document).on('click', '.page-item', function (e) {
			Precios.generarGraficos();
		});
	},

	loadReporte_validado_variabilidad: function (config = {}) {
		var data = Fn.formSerializeObject(config.idFrm);
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': config.url, 'data': jsonString };

		$.when(Fn.ajax_new(configAjax)).then(function (a) {
			if (a['status'] == null) {
				return false;
			}

			if (typeof a.data.views !== 'undefined') {
				$.each(a.data.views, function (id, value) {
					$('#' + id).html('');
					$('#' + id).html(value.html);
					if (typeof value.datatable !== 'undefined') {
						// $('#'+value.datatable).DataTable(a.data.configTable);
						Precios.myDatatable = $('#' + value.datatable).on( 'page.dt',   function () { 
							Precios.myDatatable.columns.adjust(); 
							setTimeout(function(){
								if(Precios.myDatatable){
									Precios.myDatatable.columns.adjust(); 
								}
							}, 500);
						} ).DataTable({
							"columnDefs": [
								{ "visible": false, "targets": [2, 3, 4] },
								
							],
							"order": [[3, 'asc']],
							"ordering": false,
							"preDrawCallback": function( settings ) {
								$('#' + value.datatable + ' tbody').hide();
							},
							// "autoWidth": false,
							"displayLength": 25,
							"drawCallback": function (settings) {
								var api = this.api();
								var rows = api.rows({ page: 'current' }).nodes();
								var last = null;

								api.column(3, { page: 'current' }).data().each(function (group, i) {
									if (last !== group) {
										$(rows).eq(i).before(
											'<tr class="group table-secondary"><td colspan="100%"><b>' + group + '</b></td></tr>'
										);

										last = group;
									}
								});

								$('#' + value.datatable + ' tbody td').addClass("blurry");
								$('#' + value.datatable + ' tbody').fadeIn(1200);
								setTimeout(function(){
									$('#' + value.datatable + ' tbody td').removeClass("blurry");
								},600);
							},
							"fnInitComplete": function(oSettings, json) {
								Precios.generarGraficos();
							},
							"fnDrawCallback": function( oSettings ) {
								Precios.generarGraficos();
							}
						});
					}
					
					$('.filtros_gc').addClass('d-none');
					$('.filtros_gc').find('select').attr('disabled', true);
					
					if (typeof a.data.grupoCanal !== 'undefined') {
						$('.filtros_' + a.data.grupoCanal).removeClass('d-none');
						$('.filtros_' + a.data.grupoCanal).find('select').attr('disabled', false);
					}
				});

				setTimeout(function(){
					if(Precios.myDatatable){
						Precios.myDatatable.columns.adjust();
					}
				}, 500);

				Precios.myDatatable.on( 'search.dt',   function () {
					setTimeout(function(){
						if(Precios.myDatatable){
							Precios.generarGraficos();
							Precios.myDatatable.columns.adjust();
						}
					}, 500);
				});

			} else {
				$('#' + config.contentDetalle).html(a.data.html);
				if (a.result == 1) {
					if (typeof a.data.datatable !== 'undefined') {

						// $('#'+a.data.datatable).DataTable(a.data.configTable);
						$('#' + value.datatable).DataTable({
							"columnDefs": [
								{ "visible": false, "targets": [2, 3, 4] }
							],
							"order": [[3, 'asc']],
							"displayLength": 25,
							"drawCallback": function (settings) {
								var api = this.api();
								var rows = api.rows({ page: 'current' }).nodes();
								var last = null;

								api.column(3, { page: 'current' }).data().each(function (group, i) {
									if (last !== group) {
										$(rows).eq(i).before(
											'<tr class="group table-secondary"><td colspan="100%"><b>' + group + '</b></td></tr>'
										);

										last = group;
									}
								});
							}
						});
					}

					$('.filtros_gc').addClass('d-none');
					$('.filtros_gc').find('select').attr('disabled', true);

					if (typeof a.data.grupoCanal !== 'undefined') {
						$('.filtros_' + a.data.grupoCanal).removeClass('d-none');
						$('.filtros_' + a.data.grupoCanal).find('select').attr('disabled', false);
					}
				}

				if (a.result == 0) {
					++modalId;
					var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
					var btn = new Array();
					btn[0] = { title: 'Aceptar', fn: fn };
					Fn.showModal({ id: modalId, show: true, title: a.msg.title, content: a.msg.content, btn: btn });
				}

			}

			Fn.showLoading(false);
		});
	},

	generarGraficos: function () {
		$.each($(".divGrafico"), function (index, v) {
			$(v).parents('td').html('<canvas class="divGrafico text-right align-middle" style="width:250px; height:100px;">');
		});
		$.each($(".divGrafico"), function (index, v) {
			let labelsDiv = $(v).parents('td').data('semanas');
			let dataDivs = $(v).parents('td').data('valorxsemana');
			$(v).parents('td').html
			v.width = 400;
			miCanvas = v.getContext("2d");
			let skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
			let down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;

			let config = {
				type: 'line',
				data: {
					labels: labelsDiv,
					datasets: [{
						label: 'Tendencia',
						data: dataDivs,
						borderColor: 'rgb(75, 192, 192)',
						segment: {
							borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(192,75,75)'),
							borderDash: ctx => skipped(ctx, [4, 4]),
						},
						fill: false
					}]
				},
				options: {
					fill: false,
					responsive: false,
					maintainAspectRatio: false,
					interaction: {
						intersect: false
					},
					radius: 0,
					scales: {
						yAxes: [{
							display: true,
							ticks: {
								beginAtZero: true,
								min: 0
							},
							gridLines: {
								display: false
							}
						}],
						xAxes: [{
							display: true,
							gridLines: {
								display: false
							}
						}]
					},
					legend: {
						display: false
					},
					elements: {
                        line: {
                            tension: 0
                        }
                    }
				}
			};
			var myChart = new Chart(miCanvas, config);
		});
	},
}
Precios.load();