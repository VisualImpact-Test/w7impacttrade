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

			if($("input[name=chk-reporte]:checked").val() == "vertical") $("#btn-encuesta-pdf").addClass("d-none")
			else $("#btn-encuesta-pdf").removeClass("d-none")
				
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
			} else if (idTipoFormato == 3) {
				var data = Fn.formSerializeObject(Encuesta.idFormFiltros);
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url': Encuesta.url + 'getTablaEncuestasConsolidado', 'data': jsonString };

				$.when(Fn.ajax(config)).then(function (a) {
					$('#idDetalleHorizontalConsolidado').html(a.data.html);
					$('#tablaDetalladoEncuestaConsolidado').DataTable(a.data.configTable);
					Fn.showLoading(false);
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
			} else if (opcion == 3) {
				$('#idTipoFormato').val(3);
			}
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarEncuesta').click();
        });

		$(document).ready(function () {
			$('#btn-filtrarEncuesta').click();
			$(".flt_grupoCanal").change();
			//$('#idEncuesta').selectpicker();
		});

		$(document).on('click','#btn-encuesta-pdf', function(e){
			e.preventDefault();
			//
			var elementos = new Array();

			$('#tablaDetalladoEncuesta').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
				var data = this.node();
				if( $(data).find('.check').prop('checked')==true){
					elementos.push($(data).find('.check').val());
				}
			});
			//$("input[name='check[]']:checked").each(function(){ elementos.push($(this).val()); });
			//
			if(elementos == ""){
				++modalId;
				var fns='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fns};
				Fn.showModal({ id:modalId,show:true,title:'ALERTA',content:'Debe seleccionar por lo menos un registro para poder descargar el PDF',btn:btn });
			} else {
				var data=Fn.formSerializeObject( Encuesta.idFormFiltros );
				data['elementos_det']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+Encuesta.url+'encuesta_pdf';
				Fn.download(url,jsonString);
			}
		});

		$(document).on('click','#chkb-habilitarTodos', function(){
			var input = $(this);
			
			if (input.is(':checked')) {
				$('#tablaDetalladoEncuesta').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.check').prop('checked', true);
				});
			} else {
				$('#tablaDetalladoEncuesta').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.check').prop('checked', false);
				});
			}

		});

		$(document).on('click','#btn-descargarExcel', function(e){
			e.preventDefault();
			var data = Fn.formSerializeObject(Encuesta.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Encuesta.url + 'descargarExcel', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				let fechas = $('#txt-fechas').val();
				fechas = fechas.replace(/\//g, '');
				fechas = fechas.replace(/\ /g, '');
	
				Fn.exportarTablaAExcelXLSX_Directo(a.data.tablaExcel, 'Encuestas '+fechas, 'Encuestas');
			});
		});

		$(document).on("click", ".lk-encuesta-foto", function () {
			var control = $(this);

			var data = { idVisitaEncuesta: control.data('idvisitaencuesta') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Encuesta.url + 'mostrarFotos', 'data': jsonString };

			$.when(Fn.ajax(configAjax)).then(function (a) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data, btn: btn });
			});
		});

		$(document).on("click", ".lk-alternativa-foto", function () {
			var control = $(this);

			var data = { idVisitaEncuesta: control.data('idvisitaencuesta'), idPregunta: control.data('idpregunta') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Encuesta.url + 'mostrarFotosAlternativas', 'data': jsonString };

			$.when(Fn.ajax(configAjax)).then(function (a) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data, btn: btn });
			});
		});
		$(document).on("click", ".lk-pregunta-foto", function () {
			var control = $(this);

			var data = { idVisitaEncuesta: control.data('idvisitaencuesta'), idPregunta: control.data('idpregunta') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Encuesta.url + 'mostrarFotosPreguntas', 'data': jsonString };

			$.when(Fn.ajax(configAjax)).then(function (a) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data, btn: btn });
			});
		});



	},
}
Encuesta.load();