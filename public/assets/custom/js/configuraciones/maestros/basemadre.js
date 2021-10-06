var Basemadre = {
	frmMaestrosResumen: 'frm-maestrosResumen',
	frmMaestrosBasemadre: 'frm-maestrosBasemadre',
	frmMaestrosAgregados: 'frm-maestrosAgregados',
	frmBasemadreSeleccionarPunto: 'frm-basemadreSeleccionarPunto',
	frmBasemadreNuevoEditarPunto: 'frm-basemadreNuevoEditarPunto',
	frmBasemadreSeleccionarSegmentacionCliente: 'frm-basemadreSeleccionarSegmentacionCliente',
	contentResumen: 'idResumenBasemadre',
	contentDetalle: 'idDetalleMaestrosBasemadre',
	contentDetalleAgregados: 'idDetalleMaestrosClientesAgregados',
	url : 'configuraciones/maestros/basemadre/',
	idModal: 0,
	grupoCanalGlobal:0,

	dataListaRegiones : [],
	dataListaCuentaProyecto : [],
	dataListaCuentaGrupoCanalCanalSubCanalClienteTipo: [],
	dataListaCadenaBanner: [],
	dataListaCuentaProyectoZona: [],
	dataListaPlazaTodo: [],
	dataListaPlazaMayorista: [],

	dataListaRegionesNombre: [],
	dataListaRegionesDepartamentoProvinciaDistrito: [],
	dataListaProvinciasNombre: [],
	dataListaDistritosNombre: [],
	dataListaZonaPeligrosaNombre: [],
	dataListaCuentaNombre: [],
	dataListaProyectoNombre: [],
	dataListaFrecuenciaNombre: [],
	dataListaZonaNombre: [],
	dataListaGrupoCanalNombre: [],
	dataListaCanalNombre: [],
	daataListaClienteTipoNombre: [],
	dataListaCadenaNombre: [],
	dataListaBannerNombre: [],
	dataListaPlazaNombre: [],
	dataListaDistribuidoraSucursalNombre: [],

	handsontable : '',
	tipoSegmentacion: 0,

	contentSeleccionado:"tab-content-0",

	load: function(){
		$(document).on('click','.nav-link', function(e){
			e.preventDefault();
			var opcion=$(this).data('value');
			switch(opcion){
				case 1:
					$('#btn-filtrarMaestrosBasemadre').show();
					$("#btn-deBajaMaestrosBasemadre").show();
					$("#btn-cargaMasivaHistorico").show();
					$("#btn-cargaMasivaAlternativa").show();
					$("#btn-cargaMasivaAlternativaClienteProyecto").show();
					$("#btn-verDeBajaMaestrosBasemadre").show();
					$("#btn-activarMaestrosBasemadre").show();


					$("#btn-filtrarMaestrosClientesAgregados").hide();
					$("#btn-nuevoMaestrosBasemadre").hide();
					$("#btn-cargaMasivaMaestrosBasemadre").hide();
					$("#btn-deBajaMaestrosAgregados").hide();
					$("#btn-rechazarClientesAgregados").hide();
					$("#btn-transferirClientesAgregados").hide();

					$("#filter-content-0").show();
					$("#filter-content-1").hide();

					Basemadre.contentSeleccionado="tab-content-0";

					$('#btn-filtrarMaestrosBasemadre').click();
					
                    break;
                case 2:
					$('#btn-filtrarMaestrosBasemadre').hide();
					$("#btn-deBajaMaestrosBasemadre").hide();
					$("#btn-cargaMasivaHistorico").hide();
					$("#btn-cargaMasivaAlternativa").hide();
					$("#btn-cargaMasivaAlternativaClienteProyecto").hide();
					$("#btn-verDeBajaMaestrosBasemadre").hide();
					$("#btn-activarMaestrosBasemadre").hide();

					$("#btn-filtrarMaestrosClientesAgregados").show();
					$("#btn-nuevoMaestrosBasemadre").show();
					$("#btn-cargaMasivaMaestrosBasemadre").show();
					$("#btn-deBajaMaestrosAgregados").show();
					$("#btn-rechazarClientesAgregados").show();
					$("#btn-transferirClientesAgregados").show();

					$("#filter-content-0").hide();
					$("#filter-content-1").show();

					Basemadre.contentSeleccionado="tab-content-1";
					$('#btn-filtrarMaestrosClientesAgregados').click();
					
                    break;
				default:
			}


		});

		/*==Resumen==*/
		$(document).on('click','#btn-resumenMaestrosBasemadre', function(e){
			e.preventDefault();

			var control=$(this);

			var data = Fn.formSerializeObject(Basemadre.frmMaestrosResumen);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Basemadre.url+control.data('url'), 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				if ( a['status'] == null) {
					return false;
				}
				$('#'+Basemadre.contentResumen).html(a.data.html);
			});
		});

		/*==Basemadre==*/
		$(document).on('click','#btn-filtrarMaestrosBasemadre', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Basemadre.frmMaestrosBasemadre
				,'url': Basemadre.url + control.data('url')
				,'contentDetalle': Basemadre.contentSeleccionado
			};
			Fn.loadReporte(config);
		});

		$(document).on('click','#btn-deBajaMaestrosBasemadre', function(e){
			e.preventDefault();

			var dataClienteHistorico = [];
			var arrayClienteHistorico=[];
			var cont=0;

			$('#tb-maestrosBasemadreDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var cliente = '';
				var clienteHistorico = '';

				if ( tr.find('input[name="deBaja"]').is(':checked') ) {
					var input = tr.find('input[name=deBaja]');
					cliente = input.data('cliente')
					clienteHistorico = input.data('clientehistorico');

					//INSERTAMOS ARRAY
					arrayClienteHistorico = {'cliente':cliente, 'clienteHistorico':clienteHistorico};
					dataClienteHistorico.push(arrayClienteHistorico);
					cont++;
				}
			});
			
			if (dataClienteHistorico.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Basemadre.guardarCambiarEstadoMasivo('+JSON.stringify(dataClienteHistorico)+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+cont+'</strong> registros?' });
					message+='<div class="themeWhite p-3">';
						message+='<div class="card"><div class="card-body">';
						message+='<form id="frm-fechaFinDeBaja"><div>';
							message+='<h5 class="card-title">INGRESAR FECHA FIN</h5>';
							message+='<input class="form-control text-center ipWidth" type="date" placeholder="Fecha Fin" id="fecFinDeBaja" name="fecFinDeBaja" patron="requerido">';
							message+='<input class="hide" type="hidden" id="tablaDeBaja" name="tablaDeBaja" value="basemadre">'
						message+='</div></form></div></div>';
					message+='</div>';
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Basemadre.idModal = modalId;
			}
		});

		$(document).on('click','input[name="deBaja"]', function(){
			var control = $(this);
			Basemadre.botonesAccion();
		});

		$(document).on('click','#chkb-deBajaAllBasemadre', function(){
			var input = $(this);
			
			if (input.is(':checked')) {
				$('#tb-maestrosBasemadreDetalle').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataDeBaja').prop('checked', true);
				});
			} else {
				$('#tb-maestrosBasemadreDetalle').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataDeBaja').prop('checked', false);
				});
			}

			Basemadre.botonesAccion();
		});

		$(document).on('click','.editarClienteHistorico', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var tabla = control.data('tabla');
        	var cliente = control.data('cliente');
        	var clienteHistorico = control.data('clientehistorico');

        	var data = { 'tabla':tabla, 'cliente':cliente,'clienteHistorico':clienteHistorico };
        	var jsonString = {'data':JSON.stringify(data)};
        	var configAjax = {'url':Basemadre.url+'editarPunto', 'data':jsonString};

        	$.when(Fn.ajax(configAjax)).then( function(a){
        		++modalId;
        		var fn1='Basemadre.confirmarActualizarPunto();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Actualizar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});

				$('#cuenta').val(a.data.cuenta).change();
				$('#proyecto').val(a.data.proyecto).change();
				$('#zona').val(a.data.zona).change();
				$('#grupoCanal').val(a.data.grupoCanal).change();
				$('#canal').val(a.data.canal).change();
				$('#clienteTipo').val(a.data.clienteTipo).change();
				$('#plaza').val(a.data.plaza).change();
				$('#cadena').val(a.data.cadena).change();
				$('#banner').val(a.data.banner).change();

				$.each(a.data.distribuidoraSucursal, function(ix,val){
					var fila='';
		        		fila+='<tr>';
		        			fila+='<td>'+val.distribuidoraSucursal;
		        				fila+='<div class="hide"><input type="text" name="distribuidoraSucursalSelected" value="'+val.idDistribuidoraSucursal+'"></div>';
		        			fila+='</td>'
		        			fila+='<td class="text-center">';
		        				fila+='<button type="button" class="btn-deleteRow btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
		        			fila+='</td>';
		        		fila+='</tr>';

		        	$('#tb-distribuidoraSucursal tbody').append(fila).trigger("create");
				});

	        	Basemadre.idModal = modalId;
        	});
        });

        $(document).on('click','#btn-verDeBajaMaestrosBasemadre', function(e){
        	e.preventDefault();

        	var control = $(this);
			var data = Fn.formSerializeObject(Basemadre.frmMaestrosBasemadre);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Basemadre.url+control.data('url'), 'data':jsonString };

			$.when( Fn.ajax(configAjax)).then( function(a){
				if ( a['status'] == null) {
					return false;
				}

				$('#'+Basemadre.contentDetalle).html(a.data.html);
				if (a.result==1) {
					$('#'+a.data.datatable).DataTable();
				}
			});
        });

        $(document).on('click','#chkb-deAltaAllBasemadre', function(e){
        	var input = $(this);

        	if (input.is(':checked')) {
				$('#tb-maestrosBasemadreDeBaja').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataDeAlta').prop('checked', true);
				});
			} else {
				$('#tb-maestrosBasemadreDeBaja').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataDeAlta').prop('checked', false);
				});
			}
			Basemadre.botonesAccionAlta();
        });

        $(document).on('click','input[name="deAlta"]', function(){
        	var control = $(this);
        	Basemadre.botonesAccionAlta();
        });

        $(document).on('click','#btn-activarMaestrosBasemadre', function(e){
        	e.preventDefault();

        	var dataClienteHistorico = [];
			var arrayClienteHistorico=[];
			var cont=0;

			$('#tb-maestrosBasemadreDeBaja').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var cliente = '';
				var clienteHistorico = '';

				if ( tr.find('input[name="deAlta"]').is(':checked') ) {
					var input = tr.find('input[name=deAlta]');
					cliente = input.data('cliente')
					clienteHistorico = input.data('clientehistorico');

					//INSERTAMOS ARRAY
					arrayClienteHistorico = {'cliente':cliente, 'clienteHistorico':clienteHistorico};
					dataClienteHistorico.push(arrayClienteHistorico);
					cont++;
				}
			});

			if (dataClienteHistorico.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Basemadre.guardarCambiarEstadoMasivo('+JSON.stringify(dataClienteHistorico)+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la activación de los <strong>'+cont+'</strong> clientes históricos?<br>Esta acción eliminara el registro de fecha fin del cliente histórico.' });
					message+='<div class="themeWhite p-3 hide">';
						message+='<div class="card"><div class="card-body">';
						message+='<form id="frm-fechaFinDeBaja"><div>';
							message+='<h5 class="card-title">INGRESAR FECHA FIN</h5>';
							message+='<input class="form-control text-center ipWidth" type="date" placeholder="Fecha Fin" id="fecFinDeBaja" name="fecFinDeBaja" value="">';
							message+='<input class="hide" type="hidden" id="tablaDeBaja" name="tablaDeBaja" value="clienteDeBaja">'
						message+='</div></form></div></div>';
					message+='</div>';
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Basemadre.idModal = modalId;
			}
        });

		/*==Agregados==*/
		$(document).on('click','#btn-filtrarMaestrosClientesAgregados', function(e){
			e.preventDefault();

			var control = $(this);
			
			var data = Fn.formSerializeObject(Basemadre.frmMaestrosBasemadre);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Basemadre.url+control.data('url'), 'data':jsonString };

			$.when( Fn.ajax(configAjax)).then( function(a){
				if ( a['status'] == null) {
					return false;
				}

				$('#'+Basemadre.contentSeleccionado).html(a.data.html);
				if (a.result==1) {
					$('#'+a.data.datatable).DataTable();
				}
			});
		});

		$(document).on('click','#btn-cargaMasivaMaestrosBasemadre', function(e){
        	e.preventDefault();

        	var data ={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Basemadre.url+'seleccionarSegmentacionCliente', 'data': jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Basemadre.continuarSegmentacionCliente();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				switch( a.data.htmlButtons ){
					case 1:
						btn[0]={title:'Cerrar', fn:fn2};
					break;
					case 2:
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					break;
					default:
						btn[0]={title:'Cerrar', fn:fn2};
					break;
				}
					
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'50%'});
				Basemadre.idModal = modalId;
			});
        });

		$(document).on('click','#btn-cargaMasivaHistorico', function(e){
        	e.preventDefault();

        	var data ={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Basemadre.url+'seleccionarSegmentacionCliente', 'data': jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Basemadre.continuarSegmentacionClienteHistorico();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				switch( a.data.htmlButtons ){
					case 1:
						btn[0]={title:'Cerrar', fn:fn2};
					break;
					case 2:
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					break;
					default:
						btn[0]={title:'Cerrar', fn:fn2};
					break;
				}
					
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'50%'});
				Basemadre.idModal = modalId;
			});
        });

		$(document).on('click','#btn-deBajaMaestrosAgregados', function(e){
			e.preventDefault();

			var dataClienteHistorico = [];
			var arrayClienteHistorico=[];
			var cont=0;

			$('#tb-maestrosClientesAgregados').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var cliente = '';
				var clienteHistorico = '';

				if ( tr.find('input[name="solicitudRegistro"]').is(':checked') ) {
					var input = tr.find('input[name=solicitudRegistro]');
					cliente = input.data('cliente')
					clienteHistorico = input.data('clientehistorico');

					//INSERTAMOS ARRAY
					arrayClienteHistorico = {'cliente':cliente, 'clienteHistorico':clienteHistorico};
					dataClienteHistorico.push(arrayClienteHistorico);
					cont++;
				}
			});
			
			if (dataClienteHistorico.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Basemadre.guardarCambiarEstadoMasivo('+JSON.stringify(dataClienteHistorico)+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+cont+'</strong> registros?' });
					message+='<div class="themeWhite p-3">';
						message+='<div class="card"><div class="card-body">';
						message+='<form id="frm-fechaFinDeBaja"><div>';
							message+='<h5 class="card-title">INGRESAR FECHA FIN</h5>';
							message+='<input class="form-control text-center ipWidth" type="date" placeholder="Fecha Fin" id="fecFinDeBaja" name="fecFinDeBaja" patron="requerido">';
							message+='<input class="hide" type="hidden" id="tablaDeBaja" name="tablaDeBaja" value="pg_v1">';
						message+='</div></form></div></div>';
					message+='</div>';
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Basemadre.idModal = modalId;
			}
		});

		$(document).on('click','#btn-transferirClientesAgregados', function(e){
			e.preventDefault();

			var dataClienteHistorico = [];
			var arrayClienteHistorico=[];
			var cont=0;

			$('#tb-maestrosClientesAgregados').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var cliente = '';
				var clienteHistorico = '';

				if ( tr.find('input[name="solicitudRegistro"]').is(':checked') ) {
					var input = tr.find('input[name=solicitudRegistro]');
					cliente = input.data('cliente')
					clienteHistorico = input.data('clientehistorico');

					//INSERTAMOS ARRAY
					arrayClienteHistorico = {'cliente':cliente, 'clienteHistorico':clienteHistorico};
					dataClienteHistorico.push(arrayClienteHistorico);
					cont++;
				}
			});
			
			if (dataClienteHistorico.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cliente seleccionado' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Basemadre.guardarClientesAgregados('+JSON.stringify(dataClienteHistorico)+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la transferencia de los <strong>'+cont+'</strong> clientes agregados?' });
					message+='<div class="hide">';
						message+='<input class="hide" type="hidden" id="tablaTransferir" name="tablaTransferir" value="pg_v1">';
					message+='</div>';
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Basemadre.idModal = modalId;
			}
		});

		$(document).on('click','#chkb-deBajaAllAgregados', function(){
			var input = $(this);
			
			if (input.is(':checked')) {
				$('#tb-maestrosClientesAgregados').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataSolicitudRegistro').prop('checked', true);
				});
			} else {
				$('#tb-maestrosClientesAgregados').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataSolicitudRegistro').prop('checked', false);
				});
			}
			Basemadre.botonesAccionSolicitud();
		});

		$(document).on('click','.cambiarEstado', function(e){
			e.preventDefault();
			var control = $(this);
			var data = { tabla:control.data('tabla'),cliente:control.data('cliente'), clienteHistorico: control.data('clientehistorico'), estado:control.data('estado') };

			++modalId;
			var fn1='Basemadre.guardarCambiarEstado('+JSON.stringify(data)+');Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		});

		$(document).on('click','.editarClienteHistoricoAgregado', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var tabla = control.data('tabla');
        	var cliente = control.data('cliente');
        	var clienteHistorico = control.data('clientehistorico');

        	var data = { 'tabla':tabla, 'cliente':cliente,'clienteHistorico':clienteHistorico };
        	var jsonString = {'data':JSON.stringify(data)};
        	var configAjax = {'url':Basemadre.url+'editarPunto', 'data':jsonString};

        	$.when(Fn.ajax(configAjax)).then( function(a){
        		++modalId;
        		var fn1='Basemadre.confirmarActualizarPuntoAgregado();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Actualizar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});

				$('#cuenta').val(a.data.cuenta).change();
				$('#proyecto').val(a.data.proyecto).change();
				$('#zona').val(a.data.zona).change();
				$('#grupoCanal').val(a.data.grupoCanal).change();
				$('#canal').val(a.data.canal).change();
				$('#clienteTipo').val(a.data.clienteTipo).change();
				$('#plaza').val(a.data.plaza).change();
				$('#cadena').val(a.data.cadena).change();
				$('#banner').val(a.data.banner).change();

				$.each(a.data.distribuidoraSucursal, function(ix,val){
					var fila='';
		        		fila+='<tr>';
		        			fila+='<td>'+val.distribuidoraSucursal;
		        				fila+='<div class="hide"><input type="text" name="distribuidoraSucursalSelected" value="'+val.idDistribuidoraSucursal+'"></div>';
		        			fila+='</td>'
		        			fila+='<td class="text-center">';
		        				fila+='<button type="button" class="btn-deleteRow btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
		        			fila+='</td>';
		        		fila+='</tr>';

		        	$('#tb-distribuidoraSucursal tbody').append(fila).trigger("create");
				});

	        	Basemadre.idModal = modalId;
        	});
        });

        $(document).on('click','.rechazarSolicitud', function(e){
        	var control = $(this);

        	++modalId;
        	var fn1='Basemadre.guardarRechazarSolicitud();';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con el rechazo de la solicitud de agregar el cliente?' });
				message+='<div class="themeWhite p-3">';
					message+='<div class="card"><div class="card-body">';
					message+='<form id="frm-rechazarClienteAgregado"><div>';
						message+='<h5 class="card-title">SELECCIONAR MOTIVO DE RECHAZO</h5>';
						message+='<textarea class="form-control " id="motivoRechazo" name="motivoRechazo" rows="4" cols="50" placeholder="Ingrese motivo" patron="requerido"></textarea>';
						message+='<input class="hide" type="hidden" id="tablaDeBaja" name="tablaDeBaja" value="'+control.data('tabla')+'">';
						message+='<input class="hide" type="hidden" id="clienteRechazado" name="clienteRechazado" value="'+control.data('cliente')+'">';
						message+='<input class="hide" type="hidden" id="clienteHistoricoRechazado" name="clienteHistoricoRechazado" value="'+control.data('clientehistorico')+'">';
					message+='</div></form></div></div>';
				message+='</div>';
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			Basemadre.idModal = modalId;
        });

        $(document).on('click','.verRechazo', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var tabla = control.data('tabla');
        	var cliente = control.data('cliente');
        	var clienteHistorico = control.data('clientehistorico');

        	var data = { 'tabla':tabla, 'cliente':cliente,'clienteHistorico':clienteHistorico };
        	var jsonString = {'data':JSON.stringify(data)};
        	var configAjax = {'url':Basemadre.url+'verRechazo', 'data':jsonString};

        	$.when(Fn.ajax(configAjax)).then( function(a){
        		++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn1};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'50%'});
        	});
        });

        $(document).on('click','#btn-rechazarClientesAgregados', function(e){
        	var dataClienteHistorico = [];
			var arrayClienteHistorico=[];
			var cont=0;

			$('#tb-maestrosClientesAgregados').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var cliente = '';
				var clienteHistorico = '';

				if ( tr.find('input[name="solicitudRegistro"]').is(':checked') ) {
					var input = tr.find('input[name=solicitudRegistro]');
					cliente = input.data('cliente')
					clienteHistorico = input.data('clientehistorico');

					//INSERTAMOS ARRAY
					arrayClienteHistorico = {'cliente':cliente, 'clienteHistorico':clienteHistorico};
					dataClienteHistorico.push(arrayClienteHistorico);
					cont++;
				}
			});

			if (dataClienteHistorico.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cliente seleccionado' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Basemadre.guardarRechazarSolicitudMasivo('+JSON.stringify(dataClienteHistorico)+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con el rechazo de los <strong>'+cont+'</strong> solicitud(es) de cliente(s)?' });
					message+='<div class="themeWhite p-3">';
						message+='<div class="card"><div class="card-body">';
						message+='<form id="frm-rechazarClienteAgregado"><div>';
							message+='<h5 class="card-title">SELECCIONAR MOTIVO DE RECHAZO</h5>';
							message+='<textarea class="form-control " id="motivoRechazo" name="motivoRechazo" rows="4" cols="50" placeholder="Ingrese motivo" patron="requerido"></textarea>';
							message+='<input class="hide" type="hidden" id="tablaDeBaja" name="tablaDeBaja" value="pg_v1">';
						message+='</div></form></div></div>';
					message+='</div>';
					
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Basemadre.idModal = modalId;
			}
        });

        $(document).on('click','input[name="solicitudRegistro"]', function(){
        	var control = $(this);
        	Basemadre.botonesAccionSolicitud();
        })

		/*==NUEVO PDV CLIENTE==*/
		$(document).on('click','#btn-nuevoMaestrosBasemadre', function(e){
			e.preventDefault();

			var data={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = { 'url': Basemadre.url+'seleccionarPunto', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Basemadre.confirmarTipoRegistroPunto();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'70%'});

				$('.dvListaCliente').hide();
				$('#clienteRegistro').select2();
				$('#clienteRegistro').parent().find('span.select2').addClass('allWidth');
				Basemadre.idModal = modalId;
			})
		});

		$(document).on('change','input[name=tipoRegistro]', function(){
			var control = $(this);
			var value = control.val();

			if (value==1) {
				$('.dvListaCliente').show(300);
				$('#clienteRegistro').attr('patron','requerido');
			} else {
				$('.dvListaCliente').hide(300);
				$('#clienteRegistro').removeAttr('patron','requerido');
			}

			$('#clienteRegistro').val('');
		})

		/**GEOLOCALIZACIÓN**/
		$(document).on('change','#departamento', function(){
			var control = $(this);
        	var cod_departamento = control.val();

        	var option='';
        	option +='<option value="">-- Provincias --</option>';
        	if ( typeof Basemadre.dataListaRegiones[cod_departamento] !== 'undefined') {
	        	$.each(Basemadre.dataListaRegiones[cod_departamento]['listaProvincias'], function(ix,val){
	        		option +='<option value="'+val.cod_provincia+'">'+val.provincia+'</option>';
	        	});
	        }

        	$('#provincia option').remove();
        	$('#provincia').append(option).trigger("create");
        	$('#distrito option').remove();
        	$('#distrito').append('<option value="">-- Distritos --</option>').trigger("create");
        	$('#cod_ubigeo').val('');
		});

		$(document).on('change','#provincia', function(){
        	var control = $(this);
        	var cod_departamento = $('#departamento').val();
        	var cod_provincia = control.val();

        	var option='';
        	option +='<option value="">-- Distritos --</option>';
        	if ( typeof Basemadre.dataListaRegiones[cod_departamento]['listaProvincias'][cod_provincia] !== 'undefined') {
	        	$.each(Basemadre.dataListaRegiones[cod_departamento]['listaProvincias'][cod_provincia]['listaDistritos'], function(ix,val){
	        		option +='<option value="'+val.cod_distrito+'" data-ubigeo="'+val.cod_ubigeo+'">'+val.distrito+'</option>';
	        	});
	        }

        	$('#distrito option').remove();
        	$('#distrito').append(option).trigger("create");
        	$('#cod_ubigeo').val('');
        });

        $(document).on('change','#distrito', function(){
        	var control = $('#distrito option:selected');
        	var cod_ubigeo = control.data('ubigeo');

        	$('#cod_ubigeo').val(cod_ubigeo);
        });

        $(document).on('click','#buscarDireccionMapa', function(e){
        	e.preventDefault();

        	var departamento = $('#departamento option:selected').text();
        	var provincia = $('#provincia option:selected').text();
        	var distrito = $('#distrito option:selected').text();
        	var direccion = $('#direccion').val();
        	/*Algunas variables fueron creado en la vista*/
        	var address = departamento+'-'+provincia+'-'+distrito+'-'+direccion;
        	geocoder.geocode({'address':address}, function(results, status){
        		if (status=='OK') {
        			Basemadre.clearMarkers();
        			map.setCenter(results[0].geometry.location);
        			var marker = new google.maps.Marker({
        				map:map,
        				position: results[0].geometry.location
        			});

        			markers.push(marker);

        			$('#latitud').val(results[0].geometry.location.lat());
        			$('#longitud').val(results[0].geometry.location.lng());

        			google.maps.event.addListener(marker,'dragend', function(){ Basemadre.openInfoWindow(marker); Basemadre.codeLatLng(); })
        			google.maps.event.addListener(marker,'click', function(){ Basemadre.openInfoWindow(marker); Basemadre.codeLatLng(); })
        		} else {
        			alert('Geocode was not successful for the following reason: ' + status);
        		}
        	})
        });
        /**FIN GEOLOCALIZACIÓN**/

        // $(document).on('change','#cuenta', function(){
        // 	var control = $(this);
        // 	var cuenta = control.val();
        // 	var option='';

        // 	/**PROYECTO**/
        // 	option+='<option value="">-- Proyecto --</option>';
        // 	if ( typeof Basemadre.dataListaCuentaProyecto[cuenta] !== 'undefined') {
	    //     	$.each(Basemadre.dataListaCuentaProyecto[cuenta]['listaProyectos'], function(ix,val){
	    //     		option+='<option value="'+val.idProyecto+'">'+val.proyecto+'</option>';
	    //     	});
	    //     }
        // 	$('#proyecto option').remove();
        // 	$('#proyecto').append(option).trigger("create");
        // 	$('#proyecto').change();

        // 	/**GRUPO CANAL**/
        // 	option='';
        // 	option+='<option value="">-- Grupo Canal --</option>';
        // 	if ( typeof Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta] !== 'undefined') {
        // 		$.each(Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta]['listaGrupoCanal'], function(ix,val){
        // 			option+='<option value="'+val.idGrupoCanal+'">'+val.grupoCanal+'</option>';
        // 		})
        // 	}
        // 	$('#grupoCanal option').remove();
        // 	$('#grupoCanal').append(option).trigger("create");
        // 	$('#grupoCanal').change();

        // 	/**CANAL**/
        // 	//$('#canal option').remove();
        // 	//$('#canal').append('<option value="">-- Canal --</option>').trigger("create");
        // 	//$('#canal').change();
        // });

        // $(document).on('change','#proyecto', function(){
        // 	var control = $(this);
        // 	var cuenta = $('#cuenta').val();
        // 	var proyecto = control.val();

        // 	var option='';
        // 		option+='<option value="">-- Zonas --</option>';
        // 	if ( typeof Basemadre.dataListaCuentaProyectoZona[cuenta] !== 'undefined') {
        // 		if ( typeof Basemadre.dataListaCuentaProyectoZona[cuenta][proyecto] !== 'undefined') {
		//         	$.each(Basemadre.dataListaCuentaProyectoZona[cuenta][proyecto]['listaZonas'], function(ix,val){
		//         		option+='<option value="'+val.idZona+'">'+val.zona+'</option>';
		//         	});
		//         }
	    // 	}

        // 	$('#zona option').remove();
        // 	$('#zona').append(option).trigger("create");
        // 	$('#zona').change();
        // });

        $(document).on('change','#grupoCanal', function(){
        	var control = $(this);
        	var cuenta = $('#cuenta').val();
        	var grupoCanal = control.val();
        	
        	/**CANAL**/
        	var option='';
        		option='<option value="">-- Canal --</option>';
        	if ( typeof Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta] !== 'undefined') {
	        	if ( typeof Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta]['listaGrupoCanal'][grupoCanal] !== 'undefined') {
		        	$.each(Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta]['listaGrupoCanal'][grupoCanal]['listaCanal'], function(ix,val){
		        		option+='<option value="'+val.idCanal+'">'+val.canal+'</option>';
		        	});
		        }
		    }
        	$('#canal option').remove();
        	$('#canal').append(option).trigger("create");
        	$('#canal').change();

        	/**SEGMENTACIÓN CLIENTE**/
        	//GrupoCanal-Tradicionales:: 1=>Tradicional, 4=>HFS, 5=>WHLS
        	//GrupoCanal-Modernos:: 2=>Moderno
        	if (['1','4','5'].includes(grupoCanal)) {
        		$('.segmentacionCliente').hide(200);
        		$('.segmentacionClienteTradicional').show(500);
        		$('.segmentacionClienteModerno').hide(500);
        		//
        		//PLAZA O DISTRIBUIDORA SUCURSAL
        		var opcionPlaza='<option value="">-- Plaza --</option>';
        		if (['4'].includes(grupoCanal)) {
        			//PLAZAS
	    			$.each(Basemadre.dataListaPlazaTodo, function(ix,val){
	    				opcionPlaza+='<option value="'+val.idPlaza+'">'+val.plaza+'</option>';	
	    			});
	    			$('#plaza').removeAttr("patron","requerido");
	    			//DISTRIBUIDORA SUCURSAL
	    			$('.divDistribuidoraSucursal').show(300);
        			$('#distribuidoraSucursal').attr("patron","requerido");
        		} else {
        			//PLAZAS
	    			$.each(Basemadre.dataListaPlazaMayorista, function(ix,val){
	    				opcionPlaza+='<option value="'+val.idPlaza+'">'+val.plaza+'</option>';	
	    			});
	    			$('#plaza').attr("patron","requerido");
	    			//DISTRIBUIDORA SUCURSAL
	    			$('.divDistribuidoraSucursal').hide(300);
        			$('#distribuidoraSucursal').removeAttr("patron","requerido");
        		}
        		$('#plaza option').remove();
        		$('#plaza').append(opcionPlaza).trigger("create");
        		//
        		
        		$('#clienteTipo').attr("patron","requerido");
        		$('#banner').removeAttr("patron","requerido");
        	} else if (['2'].includes(grupoCanal)) {
        		$('.segmentacionCliente').hide(200);
        		$('.segmentacionClienteTradicional').hide(500);
        		$('.segmentacionClienteModerno').show(500);
        		//
        		$('#banner').attr("patron","requerido");
        		$('#plaza').removeAttr("patron","requerido");
        		$('#distribuidoraSucursal').removeAttr("patron","requerido");
        		$('#clienteTipo').removeAttr("patron","requerido");
        	} else {
        		$('.segmentacionCliente').show(200);
        		$('.segmentacionClienteTradicional').hide(300);
        		$('.segmentacionClienteModerno').hide(300);
        		//
        		$('#plaza').removeAttr("patron","requerido");
        		$('#distribuidoraSucursal').removeAttr("patron","requerido");
        		$('#banner').removeAttr("patron","requerido");
        		$('#clienteTipo').removeAttr("patron","requerido");
        	}

			$('#cadena').val('').change();
        	$('#plaza').val('').change();
        	$('#distribuidoraSucursal').val('').change();
        	$('.btn-deleteRow').click();
        });

        $(document).on('change','#canal', function(){
        	var control = $(this);
        	var cuenta = $('#cuenta').val();
        	var grupoCanal = $('#grupoCanal').val();
        	var canal = control.val();

        	var option='';
        		option='<option value="">-- Cliente Tipo --</option>';
        	if ( typeof Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta] !== 'undefined') {
	        	if ( typeof Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta]['listaGrupoCanal'][grupoCanal] !== 'undefined') {
	        		if ( typeof Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta]['listaGrupoCanal'][grupoCanal]['listaCanal'][canal] !== 'undefined' ) {
	        			$.each(Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo[cuenta]['listaGrupoCanal'][grupoCanal]['listaCanal'][canal]['listaClienteTipo'] , function(ix,val){
		        			option+='<option value="'+val.idClienteTipo+'">'+val.clienteTipo+'</option>';
		        		});
	        		}
		        }
		    }
        	$('#clienteTipo option').remove();
        	$('#clienteTipo').append(option).trigger("create");
        	$('#clienteTipo').change();

        });

        $(document).on('change','#cadena', function(){
        	var control = $(this);
        	var cadena = control.val();

        	var option='';
        		option='<option value="">-- Banner --</option>';
        	if ( typeof Basemadre.dataListaCadenaBanner[cadena] !== 'undefined') {
	        	$.each(Basemadre.dataListaCadenaBanner[cadena]['listaBanner'], function(ix,val){
	        		option+='<option value="'+val.idBanner+'">'+val.banner+'</option>';
	        	});
	        }

        	$('#banner option').remove();
        	$('#banner').append(option).trigger("create");
        	$('#banner').change();
        });

        $(document).on('click','#addDistribuidoraSucursal', function(e){
        	e.preventDefault();

        	var distribuidoraSucursal = $('#distribuidoraSucursal').val();
        	if (distribuidoraSucursal.length>0) {
	        	var distribuidoraSucursalText = $('#distribuidoraSucursal option:selected').text();

	        	var fila='';
	        		fila+='<tr>';
	        			fila+='<td>'+distribuidoraSucursalText;
	        				fila+='<div class="hide"><input type="text" name="distribuidoraSucursalSelected" value="'+distribuidoraSucursal+'"></div>';
	        			fila+='</td>'
	        			fila+='<td class="text-center">';
	        				fila+='<button type="button" class="btn-deleteRow btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
	        			fila+='</td>';
	        		fila+='</tr>';

	        	$('#tb-distribuidoraSucursal tbody').append(fila).trigger("create");
	        	$('#distribuidoraSucursal').val('').change();
	        }
        });

        $(document).on('click','.btn-deleteRow', function(e){
        	e.preventDefault();

        	var control = $(this);
        	control.parents('tr').remove();
        });

		$(document).on('click','#btn-addColumnaCargaMasiva', function(e){
			e.preventDefault();

			var contColumna = parseInt($('#contColumnasDistribuidora').val()) + 1;
			var sourceDistribuidoraSucursal = Basemadre.dataListaDistribuidoraSucursalNombre;

			var settings = Basemadre.handsontable.getSettings();
			var indexColumna = parseInt(Basemadre.handsontable.getSettings().columns.length) + 1;

			var clmDistribuidoraSucursal = {};
				clmDistribuidoraSucursal["data"] = "distribuidoraSucursal"+contColumna;
				clmDistribuidoraSucursal["type"] = "dropdown";
				clmDistribuidoraSucursal["source"] = sourceDistribuidoraSucursal;

			var columnsArray = Basemadre.handsontable.getSettings().columns;
				columnsArray.push(clmDistribuidoraSucursal);

			settings["columns"] = columnsArray;

			var colHeadersArray = Basemadre.handsontable.getSettings().colHeaders;
				colHeadersArray.push("DISTRIBUIDORA SUCURSAL " + contColumna);

			settings["colHeaders"] = colHeadersArray;

			Basemadre.handsontable.updateSettings(settings);
			$("#contColumnasDistribuidora").val(contColumna);
		});	

		$(document).on('click','#btn-cargaMasivaCliente', function(e){
			e.preventDefault();

			var control= $(this);
			var data={};
			var jsonString = {data: JSON.stringify(data)};
			var configAjax = {url: Basemadre.url + 'clienteCargaMasivaAlternativa', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Basemadre.generarListasElementos();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
					message += a.data.html;

				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});
			});
		});

		$(document).on('click','#btn-cargaMasivaAlternativa', function(e){
			e.preventDefault();

			var control= $(this);
			var data={};
			var jsonString = {data: JSON.stringify(data)};
			var configAjax = {url: Basemadre.url + 'clienteCargaMasivaAlternativa', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn1};
				var message = a.data.html;
				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});
			});
		});

		$(document).on('click','#btn-cargaMasivaAlternativaClienteProyecto', function(e){
			e.preventDefault();

			var control= $(this);
			var data={};
			var jsonString = {data: JSON.stringify(data)};
			var configAjax = {url: Basemadre.url + 'clienteProyectoCargaMasivaAlternativa', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn1};
				var message = a.data.html;
				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});
			});
		});

		$(document).on('change','.ch-tipo', function(e){
			e.preventDefault();
			var tipo=$('input[name="ch-tipo"]:checked').val();
			if(tipo=="1"){
				$("#div_formato_trad").show();
				$("#div_formato_moder").hide();
			}else{
				$("#div_formato_trad").hide();
				$("#div_formato_moder").show();
			}

		});

		$(document).ready(function () {
			$('#btn-filtrarMaestrosBasemadre').click();
		});
	},

	initialize: function() {
		var latitud = $('#latitud').val();
			latitud = latitud.length>0 ? latitud : -9.189967;
		var longitud = $('#longitud').val();
			longitud = longitud.length>0 ? longitud : -75.015152;

		geocoder = new google.maps.Geocoder();
		//
		var latlng = new google.maps.LatLng(latitud, longitud);
		var mapOptions = {
			zoom: 4,
			center: latlng
		}
		map = new google.maps.Map(document.getElementById('map_canvas_inicio'), mapOptions);

		google.maps.event.addListenerOnce(map, 'idle', function(){
			var currentCenter = map.getCenter();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(currentCenter);
			map.setZoom(6);
			var marker = new google.maps.Marker({
				map:map,
				draggable: true,
				position: currentCenter
			});

			google.maps.event.addListener(marker, 'dragend', function(){ Basemadre.openInfoWindow(marker);Basemadre.codeLatLng(); });
			google.maps.event.addListener(marker, 'click', function(){ Basemadre.openInfoWindow(marker);Basemadre.codeLatLng(); });
		})
	},

	clearMarkers: function(){
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
	},

	openInfoWindow: function(marker){
		var markerLatLng = marker.getPosition();
		$('#latitud').val(markerLatLng.lat());
		$('#longitud').val(markerLatLng.lng());
	},

	codeLatLng: function(){
		var latitud = parseFloat($('#latitud').val());
		var longitud = parseFloat($('#longitud').val());

		var latlng = new google.maps.LatLng(latitud,longitud);

		geocoder.geocode({'latLng':latlng}, function(results, status){
			if (status=='OK') {
				if (results[0]) {
					$('#direccion').val(results[0].formatted_address);
				} else {
					alert('No se generó un registro');
				}
			} else {
				alert('Geolocalización falló debido a: ' + status);
			}
		})
	},

	botonesAccion: function(){
		var cont=0;

		$('#tb-maestrosBasemadreDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="deBaja"]').is(':checked') ) {
				var input = tr.find('input[name=deBaja]');
				cont++;
			}
		});

		if (cont>0) {
			$('#btn-deBajaMaestrosBasemadre').removeClass('btn-outline-primary');
			$('#btn-deBajaMaestrosBasemadre').addClass('btn-success');
			$('#btn-deBajaMaestrosBasemadre').find('span').remove();
			$('#btn-deBajaMaestrosBasemadre').append('<span> ('+cont+')</span>');
		} else {
			$('#btn-deBajaMaestrosBasemadre').removeClass('btn-success');
			$('#btn-deBajaMaestrosBasemadre').find('span').remove();
			$('#btn-deBajaMaestrosBasemadre').addClass('btn-outline-primary');
		}
	},

	botonesAccionAlta: function(){
		var cont=0;

		$('#tb-maestrosBasemadreDeBaja').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="deAlta"]').is(':checked') ) {
				var input = tr.find('input[name=deAlta]');
				cont++;
			}
		});

		if (cont>0) {
			$('#btn-activarMaestrosBasemadre').removeClass('btn-outline-primary');
			$('#btn-activarMaestrosBasemadre').addClass('btn-success');
			$('#btn-activarMaestrosBasemadre').find('span').remove();
			$('#btn-activarMaestrosBasemadre').append('<span> ('+cont+')</span>');
		} else {
			$('#btn-activarMaestrosBasemadre').removeClass('btn-success');
			$('#btn-activarMaestrosBasemadre').find('span').remove();
			$('#btn-activarMaestrosBasemadre').addClass('btn-outline-primary');
		}
	},

	botonesAccionSolicitud: function(){
		var cont=0;

		$('#tb-maestrosClientesAgregados').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="solicitudRegistro"]').is(':checked') ) {
				var input = tr.find('input[name=solicitudRegistro]');
				cont++;
			}
		});

		if (cont>0) {
			/*=Botón dar de Baja=*/
			$('#btn-deBajaMaestrosAgregados').removeClass('btn-outline-primary');
			$('#btn-deBajaMaestrosAgregados').addClass('btn-success');
			$('#btn-deBajaMaestrosAgregados').find('span').remove();
			$('#btn-deBajaMaestrosAgregados').append('<span> ('+cont+')</span>');
			/*=Botón dar de Baja=*/
			$('#btn-rechazarClientesAgregados').removeClass('btn-outline-primary');
			$('#btn-rechazarClientesAgregados').addClass('btn-success');
			$('#btn-rechazarClientesAgregados').find('span').remove();
			$('#btn-rechazarClientesAgregados').append('<span> ('+cont+')</span>');
			/*=Botón de Transferir=*/
			$('#btn-transferirClientesAgregados').removeClass('btn-outline-primary');
			$('#btn-transferirClientesAgregados').addClass('btn-success');
			$('#btn-transferirClientesAgregados').find('span').remove();
			$('#btn-transferirClientesAgregados').append('<span> ('+cont+')</span>');
		} else {
			/*=Botón dar de Baja=*/
			$('#btn-deBajaMaestrosAgregados').removeClass('btn-success');
			$('#btn-deBajaMaestrosAgregados').find('span').remove();
			$('#btn-deBajaMaestrosAgregados').addClass('btn-outline-primary');
			/*=Botón dar de Baja=*/
			$('#btn-rechazarClientesAgregados').removeClass('btn-success');
			$('#btn-rechazarClientesAgregados').find('span').remove();
			$('#btn-rechazarClientesAgregados').addClass('btn-outline-primary');
			/*=Botón de Transferir=*/
			$('#btn-transferirClientesAgregados').removeClass('btn-success');
			$('#btn-transferirClientesAgregados').find('span').remove();
			$('#btn-transferirClientesAgregados').addClass('btn-outline-primary');
		}
	},

	guardarCambiarEstado: function(dataCliente){
		var data = dataCliente;
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': Basemadre.url + 'cambiarEstado', 'data': jsonString };
		
		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				switch(a.data.tabla) {
					case 'basemadre':
						var tdButton = $('#ch-'+data.clienteHistorico);
						var td = tdButton.parent();
						tdButton.remove();
						td.html(a.data.html);
						/**CheckBox opciones**/
						var tdChkb = $('#chkb-'+data.clienteHistorico);
						var tdChkbChildren = tdChkb.children().remove();
						tdChkb.html(a.data.htmlChkb);
						/**Fecha Fin**/
						var tdFcFin = $('#tdFf-'+data.clienteHistorico);
						var tdFcFinChildren = tdFcFin.children().remove();
						tdFcFin.html(a.data.htmlFechaFin);

						if (data.estado==1) { $('#tr-'+data.clienteHistorico).addClass('tdBloqueado'); } 
						else {	$('#tr-'+data.clienteHistorico).removeClass('tdBloqueado');	}
					break;
					case 'pg_v1':
						var tdButton = $('#ch-ca-'+data.clienteHistorico);
						var td = tdButton.parent();
						tdButton.remove();
						td.html(a.data.html);
						/**CheckBox opciones**/
						var tdChkb = $('#chkb-ca-'+data.clienteHistorico);
						var tdChkbChildren = tdChkb.children().remove();
						tdChkb.html(a.data.htmlChkb);
						/**Fecha Fin**/
						var tdFcFin = $('#tdFf-ca-'+data.clienteHistorico);
						var tdFcFinChildren = tdFcFin.children().remove();
						tdFcFin.html(a.data.htmlFechaFin);

						if (data.estado==1) { $('#tr-ca-'+data.clienteHistorico).addClass('tdBloqueado'); } 
						else {	$('#tr-ca-'+data.clienteHistorico).removeClass('tdBloqueado');	}
					break;
					case 'clienteDeBaja':
						var tdButton = $('#ch-'+data.clienteHistorico);
						var td = tdButton.parent();
						tdButton.remove();
						td.html(a.data.html);
						/**CheckBox opciones**/
						var tdChkb = $('#chkb-'+data.clienteHistorico);
						var tdChkbChildren = tdChkb.children().remove();
						tdChkb.html(a.data.htmlChkb);
						/**Fecha Fin**/
						var tdFcFin = $('#tdFf-'+data.clienteHistorico);
						var tdFcFinChildren = tdFcFin.children().remove();
						tdFcFin.html(a.data.htmlFechaFin);

						if (data.estado==1) { $('#tr-'+data.clienteHistorico).addClass('tdBloqueado'); } 
						else {	$('#tr-'+data.clienteHistorico).removeClass('tdBloqueado');	}
					break;
				}
			}
		});
	},

	guardarCambiarEstadoMasivo: function(dataClientes){
		$.when( Fn.validateForm({'id':'frm-fechaFinDeBaja'}) ).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				var fecha = $('#fecFinDeBaja').val();
				var tabla = $('#tablaDeBaja').val();
				var data ={'tabla':tabla, 'fecFin':fecha, 'dataClienteHistorico':dataClientes};
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Basemadre.url+'cambiarEstadoMasivo', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.msg.content;
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
					
					if (a.result==1) {
						Fn.showModal({ id:Basemadre.idModal, show:false});
						switch (a.data.tabla){
							case 'basemadre': 
								$('#btn-filtrarMaestrosBasemadre').click();
								$('#btn-deBajaMaestrosBasemadre').removeClass('btn-success');
								$('#btn-deBajaMaestrosBasemadre').find('span').remove();
								$('#btn-deBajaMaestrosBasemadre').addClass('btn-outline-primary');
							break;
							case 'pg_v1': 
								$('#btn-filtrarMaestrosClientesAgregados').click(); 
								/*=Botón dar de Baja=*/
								$('#btn-deBajaMaestrosAgregados').removeClass('btn-success');
								$('#btn-deBajaMaestrosAgregados').find('span').remove();
								$('#btn-deBajaMaestrosAgregados').addClass('btn-outline-primary');
								/*=Botón dar de Baja=*/
								$('#btn-rechazarClientesAgregados').removeClass('btn-success');
								$('#btn-rechazarClientesAgregados').find('span').remove();
								$('#btn-rechazarClientesAgregados').addClass('btn-outline-primary');
								/*=Botón de Transferir=*/
								$('#btn-transferirClientesAgregados').removeClass('btn-success');
								$('#btn-transferirClientesAgregados').find('span').remove();
								$('#btn-transferirClientesAgregados').addClass('btn-outline-primary');
							break;
							case 'clienteDeBaja': 
								$('#btn-verDeBajaMaestrosBasemadre').click();
								$('#btn-activarMaestrosBasemadre').removeClass('btn-success');
								$('#btn-activarMaestrosBasemadre').find('span').remove();
								$('#btn-activarMaestrosBasemadre').addClass('btn-outline-primary');
							break;
						}
					}
				});
			}
		});
	},

	confirmarTipoRegistroPunto: function(){
		$.when( Fn.validateForm({ 'id':Basemadre.frmBasemadreSeleccionarPunto} ) ).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Basemadre.registrarNuevoPuntoHistorico();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	registrarNuevoPuntoHistorico: function(){
		var data =  Fn.formSerializeObject(Basemadre.frmBasemadreSeleccionarPunto);
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = { 'url': Basemadre.url+'nuevoPunto', 'data':jsonString};

		$.when( Fn.ajax(configAjax)).then( function(a){
			Fn.showModal({ id: Basemadre.idModal, show:false });

			++modalId;
			var fn1='Basemadre.confirmarGuardarNuevoPunto();';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Guardar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = a.data.html;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});
			//
			Basemadre.idModal = modalId;
		})
	},

	confirmarGuardarNuevoPunto: function(){
		Basemadre.verificarGrupoCanalDistribuidoraSucursal();
		$.when( Fn.validateForm({'id':Basemadre.frmBasemadreNuevoEditarPunto})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Basemadre.guardarNuevoPunto();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		});
	},

	guardarNuevoPunto: function(){
		var data = Fn.formSerializeObject(Basemadre.frmBasemadreNuevoEditarPunto);
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':Basemadre.url+'guardarNuevoPunto', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				if (a.data.htmlButtons==1) {
					btn[0]={title:'Cerrar',fn:fn};
				} else if (a.data.htmlButtons==2) {
					$('#deTodosModos').val(1);
					btn[0]={title:'Guardar DE TODOS MODOS',fn:fn+a.data.htmlGuardar};
					btn[1]={title:'Cerrar',fn:fn+'Basemadre.cambiarEstadoGuardar();'};
				} else {
					btn[0]={title:'Cerrar',fn:fn};
				}
				
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.width});

			if (a.result==1) {
				Fn.showModal({ id:Basemadre.idModal,show:false });
				$("#btn-filtrarMaestrosClientesAgregados").click();
			}
		});
	},

	cambiarEstadoGuardar: function(){
		$('#deTodosModos').val(0);
	},

	confirmarActualizarPunto: function(){
		Basemadre.verificarGrupoCanalDistribuidoraSucursal();
		$.when( Fn.validateForm({'id':Basemadre.frmBasemadreNuevoEditarPunto})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Basemadre.actualizarPunto();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	confirmarActualizarPuntoAgregado: function(){
		Basemadre.verificarGrupoCanalDistribuidoraSucursal();
		$.when( Fn.validateForm({'id':Basemadre.frmBasemadreNuevoEditarPunto})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Basemadre.actualizarPunto();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	actualizarPunto: function(){
		$('#'+Basemadre.frmBasemadreNuevoEditarPunto).find('select').prop('disabled',false);
		var data = Fn.formSerializeObject(Basemadre.frmBasemadreNuevoEditarPunto);
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':Basemadre.url+'actualizarPunto', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
				
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.width});

			if (a.result==1) {
				$('#'+Basemadre.frmBasemadreNuevoEditarPunto).find('select').prop('disabled',true);
				Fn.showModal({ id:Basemadre.idModal,show:false });
			} else {
				//
			}
		});
	},

	continuarSegmentacionClienteHistorico: function(){
		var tipoSegmentacion = $('input:radio[name="tipoSegmentacion"]:checked').val();
		if ( typeof tipoSegmentacion == 'undefined' || tipoSegmentacion=='' || tipoSegmentacion==null) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Debe de seleccionar un tipo de segmentació cliente' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			var data = Fn.formSerializeObject(Basemadre.frmBasemadreSeleccionarSegmentacionCliente);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Basemadre.url+'nuevoPuntoMasivo', 'data':jsonString};

			$.when(Fn.ajax(configAjax)).then( function(a){
				Fn.showModal({ id:Basemadre.idModal, show:false});

				++modalId;
				var fn1='Basemadre.confirmarGuardarHistoricoMasivo();';
				var fn2='Fn.showModal({id:'+modalId+', showModal:false});';
				var btn=new Array();
					btn[0]={title:'Confirmar', fn:fn1};
					btn[1]={title:'Cerrar', fn:fn2};					
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:"ACTUALIZAR CLIENTE HISTORICO",content:message,btn:btn, width:'90%'});
				
				/*Mostramos la ventana de acuerdo al tipo de Segmentacion*/
				switch (tipoSegmentacion){
					case '1': Basemadre.ventanaCargaMasivaHistoricoTradicional(); break;
					case '2': Basemadre.ventanaCargaMasivaHistoricoModerno(); break;
				}
				//
				Basemadre.idModal = modalId;
			});
		}
	},

	continuarSegmentacionCliente: function(){
		var tipoSegmentacion = $('input:radio[name="tipoSegmentacion"]:checked').val();
		if ( typeof tipoSegmentacion == 'undefined' || tipoSegmentacion=='' || tipoSegmentacion==null) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Debe de seleccionar un tipo de segmentació cliente' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			var data = Fn.formSerializeObject(Basemadre.frmBasemadreSeleccionarSegmentacionCliente);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Basemadre.url+'nuevoPuntoMasivo', 'data':jsonString};

			$.when(Fn.ajax(configAjax)).then( function(a){
				Fn.showModal({ id:Basemadre.idModal, show:false});

				++modalId;
				var fn1='Basemadre.confirmarGuardarNuevoPuntoMasivo();';
				var fn2='Fn.showModal({id:'+modalId+', showModal:false});';
				var btn=new Array();
					btn[0]={title:'Confirmar', fn:fn1};
					btn[1]={title:'Cerrar', fn:fn2};					
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});
				
				/*Mostramos la ventana de acuerdo al tipo de Segmentacion*/
				Basemadre.tipoSegmentacion=tipoSegmentacion;
				switch (tipoSegmentacion){
					case '1': Basemadre.ventanaCargaMasivaTradicional(); break;
					case '2': Basemadre.ventanaCargaMasivaModerno(); break;
				}
				//
				Basemadre.idModal = modalId;
			});
		}
	},

	ventanaCargaMasivaTradicional: function(){
		var sourceDepartamentos = Basemadre.dataListaRegionesNombre;
		var sourceProvincias = Basemadre.dataListaProvinciasNombre;
		var sourceDistritos = Basemadre.dataListaDistritosNombre;
		var sourceZonaPeligrosa = Basemadre.dataListaZonaPeligrosaNombre;
		var sourceFrecuencia = Basemadre.dataListaFrecuenciaNombre;
		var sourceZona = Basemadre.dataListaZonaNombre;
		var sourceGrupoCanal = Basemadre.dataListaGrupoCanalNombre;
		var sourceCanal = Basemadre.dataListaCanalNombre;
		var sourceClienteTipo = Basemadre.daataListaClienteTipoNombre;
		//var sourceCadena = Basemadre.dataListaCadenaNombre;
		//var sourceBanner = Basemadre.dataListaBannerNombre;
		var sourcePlaza = Basemadre.dataListaPlazaNombre;
		var sourceDistribuidoraSucursal = Basemadre.dataListaDistribuidoraSucursalNombre;

		var data = [];
		var container = document.getElementById('nuevoPuntoMasivo');
		
		var settings = {
			licenseKey: 'non-commercial-and-evaluation',
			data: null,
			dataSchema: {nombreComercial:null, razonSocial:null, number:{ruc:null, dni:null}, ubigeo:{departamento:null,provincia:null,distrito:null}, direccion:null, referencia:null, latitud:null, longitud:null, zonaPeligrosa:null, codCliente:null, flagCartera:null, fechas:{inicio:null, fin:null}, frecuencia:null, zona:null, segNegocio:{grupoCanal:null, canal:null, clienteTipo:null}, segClienteTradicional:{plaza:null, distribuidoraSucursal:null} },
			colHeaders: ['NOMBRE COMERCIAL', 'RAZÓN SOCIAL(*)', 'RUC', 'DNI','DEPARTAMENTO(**)','PROVINCIA(**)','DISTRITO(**)','DIRECCIÓN(*)','REFERENCIA','LATITUD','LONGITUD','ZONA PELIGROSA', 'CÓDIGO CLIENTE','CLIENTE CARTERA','FECHA INICIO(**)','FECHA FIN','FRECUENCIA','ZONA','GRUPO CANAL(**)','CANAL(**)','CLIENTE TIPO','PLAZA','DISTRIBUIDORA SUCURSAL 1'],
			startRows: 10,
			//startCols: 4,
			columns: [
				{data: 'nombreComercial'},
				{data: 'razonSocial',allowEmpty:false
					, validator :function(value, callback) {
						if(value=='' || value==null){
							Basemadre.handsontable.setCellMeta(this.row,1,'className','changeFalse');
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,1,'className','');
						}
						callback(true);
					}
				
				},
				{ data: 'number.ruc'
					, type:'numeric'
					, validator :function(value, callback) {
						let valueToValidate = value;
						if (valueToValidate === null || valueToValidate === void 0) {
							valueToValidate = '';
						}
						if (this.allowEmpty && valueToValidate === '') {
							callback(true);
		
						} else if (valueToValidate === '') {
							callback(true);
						} else {
							callback(true);
						}
										
					}
				},
				{ data: 'number.dni'
					, type:'numeric'
					, validator :function(value, callback) {
						let valueToValidate = value;
						if (valueToValidate === null || valueToValidate === void 0) {
							valueToValidate = '';
						}
						if (this.allowEmpty && valueToValidate === '') {
							callback(true);
		
						} else if (valueToValidate === '') {
							callback(true);
						} else {
							callback(true);
						}
										
					}
				},
				{ data: 'ubigeo.departamento'
					, type: 'dropdown'
					, source: sourceDepartamentos
				},
				{ data: 'ubigeo.provincia'
					, type: 'dropdown'
					, source: sourceProvincias
				},
				{ data: 'ubigeo.distrito'
					, type: 'dropdown'
					, source: sourceDistritos
				},
				{ data: 'direccion'
					, allowEmpty:false
					, validator :function(value, callback) {
						if(value=='' || value==null){
							Basemadre.handsontable.setCellMeta(this.row,8,'className','changeFalse');
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,8,'className','');
						}
						callback(true);
					}
				},
				{ data: 'referencia'},
				{ data: 'latitud'},
				{ data: 'longitud'},
				{ data: 'zonaPeligrosa'
					, type:'dropdown'
					, source: sourceZonaPeligrosa
				},
				{ data: 'codCliente'},
				{ data: 'flagCartera'
					, type:'dropdown'
					, source: ['SI','NO']
					, placeholder: 'NO'
				},
				{ data: 'fechas.inicio'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: false
					, placeholder: moment().format('DD/MM/YYYY')
					, defaultDate: moment().toDate()
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'fechas.fin'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: true
					, placeholder: moment().format('DD/MM/YYYY')
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'frecuencia'
					, type:'dropdown'
					, source: sourceFrecuencia
				},
				{ data: 'zona'
					, type:'dropdown'
					, source: sourceZona
				},
				{ data: 'segNegocio.grupoCanal'
					, type:'dropdown'
					, source: sourceGrupoCanal

					, validator :function(value, callback) {
						if(value=='' || value==null){
							callback(true);
						}else{
							console.log(value);
							if(value=='HFS'){
								Basemadre.handsontable.setCellMeta(this.row,20,'allowEmpty',false);
								Basemadre.handsontable.setCellMeta(this.row,21,'allowEmpty',true);
								Basemadre.handsontable.setCellMeta(this.row,22,'allowEmpty',false);

								if(Basemadre.handsontable.getDataAtCell(this.row,20)== null || Basemadre.handsontable.getDataAtCell(this.row,20)==""){
									Basemadre.handsontable.setCellMeta(this.row,20,'className','changeFalse');
								}
								Basemadre.handsontable.setCellMeta(this.row,21,'className','');
								if(Basemadre.handsontable.getDataAtCell(this.row,22)== null || Basemadre.handsontable.getDataAtCell(this.row,22)==""){
									Basemadre.handsontable.setCellMeta(this.row,22,'className','changeFalse');
								}
							}
							else if(value=='WHLS'){
								Basemadre.handsontable.setCellMeta(this.row,20,'allowEmpty',true);
								Basemadre.handsontable.setCellMeta(this.row,21,'allowEmpty',false);
								Basemadre.handsontable.setCellMeta(this.row,22,'allowEmpty',true);
								
								Basemadre.handsontable.setCellMeta(this.row,20,'className','');
								Basemadre.handsontable.setCellMeta(this.row,22,'className','');
								if(Basemadre.handsontable.getDataAtCell(this.row,21)== null || Basemadre.handsontable.getDataAtCell(this.row,21)==""){
									Basemadre.handsontable.setCellMeta(this.row,21,'className','changeFalse');
								}

							}else{
								Basemadre.handsontable.setCellMeta(this.row,20,'allowEmpty',true);
								Basemadre.handsontable.setCellMeta(this.row,21,'allowEmpty',true);
								Basemadre.handsontable.setCellMeta(this.row,22,'allowEmpty',true);
							}
							//Basemadre.handsontable.setCellMeta(this.row,18,'className','');
						}
						callback(true);
					}
				},
				{ data: 'segNegocio.canal'
					, type:'dropdown'
					, source: sourceCanal
				},
				{ data: 'segNegocio.clienteTipo'
					, type:'dropdown'
					, source: sourceClienteTipo
					, validator :function(value, callback) {
						if(value=='' || value==null){
							if(this.allowEmpty==true){
								Basemadre.handsontable.setCellMeta(this.row,20,'className','');
							}else{
								Basemadre.handsontable.setCellMeta(this.row,20,'className','changeFalse');
							}
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,20,'className','');
						}
						callback(true);
					}
				},
				{ data: 'segClienteTradicional.plaza'
					, type:'dropdown'
					, source: sourcePlaza
					, validator :function(value, callback) {
						if(value=='' || value==null){
							if(this.allowEmpty==true){
								Basemadre.handsontable.setCellMeta(this.row,21,'className','');
							}else{
								Basemadre.handsontable.setCellMeta(this.row,21,'className','changeFalse');
							}
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,21,'className','');
						}
						callback(true);
					}
				},
				{ data: 'segClienteTradicional.distribuidoraSucursal'
					, type:'dropdown'
					, source: sourceDistribuidoraSucursal
					, validator :function(value, callback) {
						if(value=='' || value==null){
							if(this.allowEmpty==true){
								Basemadre.handsontable.setCellMeta(this.row,22,'className','');
							}else{
								Basemadre.handsontable.setCellMeta(this.row,22,'className','changeFalse');
							}
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,22,'className','');
						}
						callback(true);
					}
				}
			],
			minSpareCols: 1, //always keep at least 1 spare row at the right
			minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
			rowHeaders: true, //n° contador de las filas
			//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
			contextMenu: true,
			dropdownMenu: true, //desplegable en la columna, ofrece oopciones
			height: 300,
			//width: '100%',
			stretchH: 'all', //Expande todas las columnas al 100%
			maxRows: 1000, //cantidad máxima de filas
			manualColumnResize: true
		};

		Basemadre.handsontable = new Handsontable(container, settings);

		setTimeout(function(){
			Basemadre.handsontable.render(); 
		}, 1000);
	},

	ventanaCargaMasivaModerno: function(){
		var sourceDepartamentos = Basemadre.dataListaRegionesNombre;
		var sourceProvincias = Basemadre.dataListaProvinciasNombre;
		var sourceDistritos = Basemadre.dataListaDistritosNombre;
		var sourceZonaPeligrosa = Basemadre.dataListaZonaPeligrosaNombre;
		var sourceFrecuencia = Basemadre.dataListaFrecuenciaNombre;
		var sourceZona = Basemadre.dataListaZonaNombre;
		var sourceGrupoCanal = Basemadre.dataListaGrupoCanalNombre;
		var sourceCanal = Basemadre.dataListaCanalNombre;
		var sourceClienteTipo = Basemadre.daataListaClienteTipoNombre;
		var sourceCadena = Basemadre.dataListaCadenaNombre;
		var sourceBanner = Basemadre.dataListaBannerNombre;

		var data = [];
		var container = document.getElementById('nuevoPuntoMasivo');
		
		var settings = {
			licenseKey: 'non-commercial-and-evaluation',
			data: null,
			dataSchema: {nombreComercial:null, razonSocial:null, number:{ruc:null, dni:null}, ubigeo:{departamento:null,provincia:null,distrito:null}, direccion:null, referencia:null, latitud:null, longitud:null, zonaPeligrosa:null, codCliente:null, flagCartera:null, fechas:{inicio:null, fin:null}, frecuencia:null, zona:null, segNegocio:{grupoCanal:null, canal:null, clienteTipo:null}, segClienteModerno:{cadena:null, banner:null}},
			colHeaders: ['NOMBRE COMERCIAL', 'RAZÓN SOCIAL(*)', 'RUC', 'DNI','DEPARTAMENTO(**)','PROVINCIA(**)','DISTRITO(**)','DIRECCIÓN(*)','REFERENCIA','LATITUD','LONGITUD','ZONA PELIGROSA', 'CÓDIGO CLIENTE','CLIENTE CARTERA','FECHA INICIO(**)','FECHA FIN','FRECUENCIA','ZONA','GRUPO CANAL(**)','CANAL(**)', 'CLIENTE TIPO','CADENA(**)','BANNER(**)'],
			startRows: 10,
			//startCols: 4,
			columns: [
				{data: 'nombreComercial'},
				{data: 'razonSocial'
					,allowEmpty:false
					, validator :function(value, callback) {
						if(value=='' || value==null){
							Basemadre.handsontable.setCellMeta(this.row,1,'className','changeFalse');
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,1,'className','');
						}
						callback(true);
					}
				},
				{ data: 'number.ruc'
					, type:'numeric'
				},
				{ data: 'number.dni'
					, type:'numeric'
				},
				{ data: 'ubigeo.departamento'
					, type: 'dropdown'
					, source: sourceDepartamentos
				},
				{ data: 'ubigeo.provincia'
					, type: 'dropdown'
					, source: sourceProvincias
				},
				{ data: 'ubigeo.distrito'
					, type: 'dropdown'
					, source: sourceDistritos
				},
				{ data: 'direccion'
					, allowEmpty:false
					, validator :function(value, callback) {
						if(value=='' || value==null){
							Basemadre.handsontable.setCellMeta(this.row,8,'className','changeFalse');
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,8,'className','');
						}
						callback(true);
					}
				},
				{ data: 'referencia'},
				{ data: 'latitud'},
				{ data: 'longitud'},
				{ data: 'zonaPeligrosa'
					, type:'dropdown'
					, source: sourceZonaPeligrosa
				},
				{ data: 'codCliente'},
				{ data: 'flagCartera'
					, type:'dropdown'
					, source: ['SI','NO']
					, placeholder: 'NO'
				},
				{ data: 'fechas.inicio'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: false
					, placeholder: moment().format('DD/MM/YYYY')
					, defaultDate: moment().toDate()
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'fechas.fin'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: true
					, placeholder: moment().format('DD/MM/YYYY')
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'frecuencia'
					, type:'dropdown'
					, source: sourceFrecuencia
				},
				{ data: 'zona'
					, type:'dropdown'
					, source: sourceZona
				},
				{ data: 'segNegocio.grupoCanal'
					, type:'dropdown'
					, source: sourceGrupoCanal
				},
				{ data: 'segNegocio.canal'
					, type:'dropdown'
					, source: sourceCanal
				},
				{ data: 'segNegocio.clienteTipo'
					, type:'dropdown'
					, source: sourceClienteTipo
				},
				{ data: 'segClienteModerno.cadena'
					, type:'dropdown'
					, source: sourceCadena
				},
				{ data: 'segClienteModerno.banner'
					, type:'dropdown'
					, source: sourceBanner
				}
			],
			minSpareCols: 1, //always keep at least 1 spare row at the right
			minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
			rowHeaders: true, //n° contador de las filas
			//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
			contextMenu: true,
			dropdownMenu: true, //desplegable en la columna, ofrece oopciones
			height: 300,
			//width: '100%',
			stretchH: 'all', //Expande todas las columnas al 100%
			maxRows: 1000, //cantidad máxima de filas
			manualColumnResize: true
		};

		Basemadre.handsontable = new Handsontable(container, settings);

		setTimeout(function(){
			Basemadre.handsontable.render(); 
		}, 1000);
	},

	ventanaCargaMasivaHistoricoTradicional: function(){
		var sourceDepartamentos = Basemadre.dataListaRegionesNombre;
		var sourceProvincias = Basemadre.dataListaProvinciasNombre;
		var sourceDistritos = Basemadre.dataListaDistritosNombre;
		var sourceZonaPeligrosa = Basemadre.dataListaZonaPeligrosaNombre;
		var sourceFrecuencia = Basemadre.dataListaFrecuenciaNombre;
		var sourceZona = Basemadre.dataListaZonaNombre;
		var sourceGrupoCanal = Basemadre.dataListaGrupoCanalNombre;
		var sourceCanal = Basemadre.dataListaCanalNombre;
		var sourceClienteTipo = Basemadre.daataListaClienteTipoNombre;
		//var sourceCadena = Basemadre.dataListaCadenaNombre;
		//var sourceBanner = Basemadre.dataListaBannerNombre;
		var sourcePlaza = Basemadre.dataListaPlazaNombre;
		var sourceDistribuidoraSucursal = Basemadre.dataListaDistribuidoraSucursalNombre;

		var data = [];
		var container = document.getElementById('nuevoPuntoMasivo');
		
		var settings = {
			licenseKey: 'non-commercial-and-evaluation',
			data: null,
			dataSchema: {idCliente:null,nombreComercial:null, razonSocial:null, number:{ruc:null, dni:null}, ubigeo:{departamento:null,provincia:null,distrito:null,codigo:null}, direccion:null, referencia:null, latitud:null, longitud:null, zonaPeligrosa:null, codCliente:null, flagCartera:null, fechas:{inicio:null, fin:null}, frecuencia:null, zona:null, segNegocio:{grupoCanal:null, canal:null, clienteTipo:null}, segClienteTradicional:{plaza:null, distribuidoraSucursal:null} },
			colHeaders: ['ID CLIENTE','NOMBRE COMERCIAL', 'RAZÓN SOCIAL(*)', 'RUC', 'DNI','DEPARTAMENTO(**)','PROVINCIA(**)','DISTRITO(**)','CÓDIGO UBIGEO(**)','DIRECCIÓN(*)','REFERENCIA','LATITUD','LONGITUD','ZONA PELIGROSA', 'CÓDIGO CLIENTE','CLIENTE CARTERA','FECHA INICIO(**)','FECHA FIN','FRECUENCIA','ZONA','GRUPO CANAL(**)','CANAL(**)','CLIENTE TIPO','PLAZA','DISTRIBUIDORA SUCURSAL 1'],
			startRows: 10,
			//startCols: 4,
			columns: [
				{data: 'idCliente'
					, validator :function(value, callback) {
						if(value=='' || value==null){
							Basemadre.handsontable.setCellMeta(this.row,0,'className','changeFalse');
							callback(true);
						}else{
							Basemadre.handsontable.setCellMeta(this.row,0,'className','');
						}
						callback(true);
					}
				},
				{data: 'nombreComercial'},
				{data: 'razonSocial'},
				{ data: 'number.ruc'},
				{ data: 'number.dni'},
				{ data: 'ubigeo.departamento'
					, type: 'dropdown'
					, source: sourceDepartamentos
				},
				{ data: 'ubigeo.provincia'
					, type: 'dropdown'
					, source: sourceProvincias
				},
				{ data: 'ubigeo.distrito'
					, type: 'dropdown'
					, source: sourceDistritos
				},
				{ data: 'ubigeo.codigo'
					, type:'numeric'
				},
				{ data: 'direccion'	},
				{ data: 'referencia'},
				{ data: 'latitud'},
				{ data: 'longitud'},
				{ data: 'zonaPeligrosa'
					, type:'dropdown'
					, source: sourceZonaPeligrosa
				},
				{ data: 'codCliente'},
				{ data: 'flagCartera'
					, type:'dropdown'
					, source: ['SI','NO']
					, placeholder: 'NO'
				},
				{ data: 'fechas.inicio'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: true
					, placeholder: moment().format('DD/MM/YYYY')
					, defaultDate: moment().toDate()
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'fechas.fin'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: true
					, placeholder: moment().format('DD/MM/YYYY')
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'frecuencia'
					, type:'dropdown'
					, source: sourceFrecuencia
				},
				{ data: 'zona'
					, type:'dropdown'
					, source: sourceZona
				},
				{ data: 'segNegocio.grupoCanal'
					, type:'dropdown'
					, source: sourceGrupoCanal
				},
				{ data: 'segNegocio.canal'
					, type:'dropdown'
					, source: sourceCanal
				},
				{ data: 'segNegocio.clienteTipo'
					, type:'dropdown'
					, source: sourceClienteTipo
				},
				{ data: 'segClienteTradicional.plaza'
					, type:'dropdown'
					, source: sourcePlaza
				},
				{ data: 'segClienteTradicional.distribuidoraSucursal'
					, type:'dropdown'
					, source: sourceDistribuidoraSucursal
				}
			],
			minSpareCols: 1, //always keep at least 1 spare row at the right
			minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
			rowHeaders: true, //n° contador de las filas
			//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
			contextMenu: true,
			dropdownMenu: true, //desplegable en la columna, ofrece oopciones
			height: 300,
			//width: '100%',
			stretchH: 'all', //Expande todas las columnas al 100%
			maxRows: 1000, //cantidad máxima de filas
			manualColumnResize: true
		};

		Basemadre.handsontable = new Handsontable(container, settings);

		setTimeout(function(){
			Basemadre.handsontable.render(); 
		}, 1000);
	},

	ventanaCargaMasivaHistoricoModerno: function(){
		var sourceDepartamentos = Basemadre.dataListaRegionesNombre;
		var sourceProvincias = Basemadre.dataListaProvinciasNombre;
		var sourceDistritos = Basemadre.dataListaDistritosNombre;
		var sourceZonaPeligrosa = Basemadre.dataListaZonaPeligrosaNombre;
		var sourceFrecuencia = Basemadre.dataListaFrecuenciaNombre;
		var sourceZona = Basemadre.dataListaZonaNombre;
		var sourceGrupoCanal = Basemadre.dataListaGrupoCanalNombre;
		var sourceCanal = Basemadre.dataListaCanalNombre;
		var sourceClienteTipo = Basemadre.daataListaClienteTipoNombre;
		var sourceCadena = Basemadre.dataListaCadenaNombre;
		var sourceBanner = Basemadre.dataListaBannerNombre;

		var data = [];
		var container = document.getElementById('nuevoPuntoMasivo');
		
		var settings = {
			licenseKey: 'non-commercial-and-evaluation',
			data: null,
			dataSchema: {idCliente:null,nombreComercial:null, razonSocial:null, number:{ruc:null, dni:null}, ubigeo:{departamento:null,provincia:null,distrito:null,codigo:null}, direccion:null, referencia:null, latitud:null, longitud:null, zonaPeligrosa:null, codCliente:null, flagCartera:null, fechas:{inicio:null, fin:null}, frecuencia:null, zona:null, segNegocio:{grupoCanal:null, canal:null, clienteTipo:null}, segClienteModerno:{cadena:null, banner:null}},
			colHeaders: ['ID CLIENTE','NOMBRE COMERCIAL', 'RAZÓN SOCIAL(*)', 'RUC', 'DNI','DEPARTAMENTO(**)','PROVINCIA(**)','DISTRITO(**)','CÓDIGO UBIGEO(**)','DIRECCIÓN(*)','REFERENCIA','LATITUD','LONGITUD','ZONA PELIGROSA', 'CÓDIGO CLIENTE','CLIENTE CARTERA','FECHA INICIO(**)','FECHA FIN','FRECUENCIA','ZONA','GRUPO CANAL(**)','CANAL(**)', 'CLIENTE TIPO','CADENA(**)','BANNER(**)'],
			startRows: 10,
			//startCols: 4,
			columns: [
				{data: 'idCliente'
				},
				{data: 'nombreComercial'
				},
				{data: 'razonSocial'}
				,
				{ data: 'number.ruc'
					, type:'numeric'
				},
				{ data: 'number.dni'
					, type:'numeric'
				},
				{ data: 'ubigeo.departamento'
					, type: 'dropdown'
					, source: sourceDepartamentos
				},
				{ data: 'ubigeo.provincia'
					, type: 'dropdown'
					, source: sourceProvincias
				},
				{ data: 'ubigeo.distrito'
					, type: 'dropdown'
					, source: sourceDistritos
				},
				{ data: 'ubigeo.codigo'
					, type:'numeric'
				},
				{ data: 'direccion'},
				{ data: 'referencia'},
				{ data: 'latitud'},
				{ data: 'longitud'},
				{ data: 'zonaPeligrosa'
					, type:'dropdown'
					, source: sourceZonaPeligrosa
				},
				{ data: 'codCliente'},
				{ data: 'flagCartera'
					, type:'dropdown'
					, source: ['SI','NO']
					, placeholder: 'NO'
				},
				{ data: 'fechas.inicio'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: true
					, placeholder: moment().format('DD/MM/YYYY')
					, defaultDate: moment().toDate()
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'fechas.fin'
					, type:'date'
					, dateFormat: 'DD/MM/YYYY'
					, allowEmpty: true
					, placeholder: moment().format('DD/MM/YYYY')
					, datePickerConfig: {
						firstDay: 1,
						showWeekNumber: true,
						numberOfMonths: 1,
						i18n: {
							previousMonth: 'Anterior',
							nextMonth: 'Siguiente',
							months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
						},
					}
				},
				{ data: 'frecuencia'
					, type:'dropdown'
					, source: sourceFrecuencia
				},
				{ data: 'zona'
					, type:'dropdown'
					, source: sourceZona
				},
				{ data: 'segNegocio.grupoCanal'
					, type:'dropdown'
					, source: sourceGrupoCanal
				},
				{ data: 'segNegocio.canal'
					, type:'dropdown'
					, source: sourceCanal
				},
				{ data: 'segNegocio.clienteTipo'
					, type:'dropdown'
					, source: sourceClienteTipo
				},
				{ data: 'segClienteModerno.cadena'
					, type:'dropdown'
					, source: sourceCadena
				},
				{ data: 'segClienteModerno.banner'
					, type:'dropdown'
					, source: sourceBanner
				}
			],
			minSpareCols: 1, //always keep at least 1 spare row at the right
			minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
			rowHeaders: true, //n° contador de las filas
			//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
			contextMenu: true,
			dropdownMenu: true, //desplegable en la columna, ofrece oopciones
			height: 300,
			//width: '100%',
			stretchH: 'all', //Expande todas las columnas al 100%
			maxRows: 1000, //cantidad máxima de filas
			manualColumnResize: true
		};

		Basemadre.handsontable = new Handsontable(container, settings);

		setTimeout(function(){
			Basemadre.handsontable.render(); 
		}, 1000);
	},

	confirmarGuardarNuevoPuntoMasivo: function(){
		var valoresNecesarios=0;
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoPuntoMasivo .htInvalid').length;
		var arrayDataClientes = [];
		
		for (var ix = 0; ix < Basemadre.handsontable.countRows(); ix++) {
			if (!Basemadre.handsontable.isEmptyRow(ix)) {
				var columnaRazonSocial = Basemadre.handsontable.getDataAtCell(ix,1); if ( columnaRazonSocial==null) { valoresNecesarios++; }
				//	var columnaCodigoUbigeo = Basemadre.handsontable.getDataAtCell(ix,7); if ( columnaCodigoUbigeo==null) { valoresNecesarios++; }
				var columnaDireccion = Basemadre.handsontable.getDataAtCell(ix,7); if( columnaDireccion==null || columnaDireccion=="" ) { valoresNecesarios++; }
				var columnaFechaInicio = Basemadre.handsontable.getDataAtCell(ix,14); if ( columnaFechaInicio==null) { valoresNecesarios++; }
				var columnaGrupoCanal = Basemadre.handsontable.getDataAtCell(ix,18); if ( columnaGrupoCanal==null) { valoresNecesarios++; }
				
				if(Basemadre.tipoSegmentacion=='1'){

					if(columnaGrupoCanal=='HFS'){
						if(Basemadre.handsontable.getDataAtCell(ix,20)== null || Basemadre.handsontable.getDataAtCell(ix,20)==""){
							Basemadre.handsontable.setCellMeta(ix,20,'className','changeFalse');
							valoresNecesarios++;
						}
						if(Basemadre.handsontable.getDataAtCell(ix,22)== null || Basemadre.handsontable.getDataAtCell(ix,22)==""){
							Basemadre.handsontable.setCellMeta(ix,22,'className','changeFalse');
							valoresNecesarios++;
						}
					}else if(columnaGrupoCanal=='WHLS'){
						if(Basemadre.handsontable.getDataAtCell(ix,21)== null || Basemadre.handsontable.getDataAtCell(ix,21)==""){
							Basemadre.handsontable.setCellMeta(ix,21,'className','changeFalse');
							valoresNecesarios++;
						}
					}

				}else if(Basemadre.tipoSegmentacion=='2'){
					var columnaCadena = Basemadre.handsontable.getDataAtCell(ix,21); if ( columnaCadena==null) { valoresNecesarios++; }
					var columnaBanner = Basemadre.handsontable.getDataAtCell(ix,22); if ( columnaBanner==null) { valoresNecesarios++; }
				}
				

				var columnaCanal = Basemadre.handsontable.getDataAtCell(ix,19); if ( columnaCanal==null) { valoresNecesarios++; }
				//AÑADIMOS LA ROW AL ARRAY
				arrayDataClientes.push(Basemadre.handsontable.getDataAtRow(ix));
			}
		}
		
		if ( valoresNecesarios>0 ) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Se encontrarón valores necesarios a completar' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else if ( arrayDataClientes.length==0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'No se ha detectado el llenado de la data, por favor ingrese la información solicitada' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else if ( contColsInvalid>0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresadoso o datos erróneos, verificar los datos remarcados en rojo' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			++modalId;
			var fn1='Basemadre.guardarNuevoPuntoMasivo();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},
	confirmarGuardarHistoricoMasivo: function(){
		var valoresNecesarios=0;
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoPuntoMasivo .htInvalid').length;
		
		for (var ix = 0; ix < Basemadre.handsontable.countRows(); ix++) {
			if (!Basemadre.handsontable.isEmptyRow(ix)) {
				//var columnaIdCliente = Basemadre.handsontable.getDataAtCell(ix,1); if ( columnaIdCliente==null) { valoresNecesarios++; }
				//AÑADIMOS LA ROW AL ARRAY
			}
		}
		
		if ( valoresNecesarios>0 ) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Se encontrarón valores necesarios a completar' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else if ( contColsInvalid>0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresadoso o datos erróneos, verificar los datos remarcados en rojo' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			++modalId;
			var fn1='Basemadre.guardarHistoricoMasivo();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},

	guardarNuevoPuntoMasivo: function(){
		var arrayDataClientes = [];
		for (var ix = 0; ix < Basemadre.handsontable.countRows(); ix++) {
			if (!Basemadre.handsontable.isEmptyRow(ix)) {
				arrayDataClientes.push(Basemadre.handsontable.getDataAtRow(ix));
			}
		}

		var tipoSegmentacion = $('#tipoSegmentacion').val();
		var dataArrayCargaMasiva = arrayDataClientes;
		
		var data = {'tipoSegmentacion': tipoSegmentacion,'dataArray': dataArrayCargaMasiva};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Basemadre.url+'guardarNuevoPuntoMasivo', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});

			if (a.result==1) {
				Fn.showModal({ id:Basemadre.idModal,show:false });
				$('#btn-filtrarMaestrosClientesAgregados').click();
			}
		});
	},

	guardarHistoricoMasivo: function(){
		var arrayDataClientes = [];
		for (var ix = 0; ix < Basemadre.handsontable.countRows(); ix++) {
			if (!Basemadre.handsontable.isEmptyRow(ix)) {
				arrayDataClientes.push(Basemadre.handsontable.getDataAtRow(ix));
			}
		}

		var tipoSegmentacion = $('#tipoSegmentacion').val();
		var dataArrayCargaMasiva = arrayDataClientes;
		
		var data = {'tipoSegmentacion': tipoSegmentacion,'dataArray': dataArrayCargaMasiva};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Basemadre.url+'guardarHistoricoMasivo', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});

			if (a.result==1) {
				Fn.showModal({ id:Basemadre.idModal,show:false });
				$('#btn-filtrarMaestrosBasemadre').click();

			}
		});
	},


	guardarClientesAgregados: function(dataClientes){
		var tabla = $('#tablaTransferir').val();
		var data = {'tabla':tabla, 'dataClienteHistorico': dataClientes};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Basemadre.url+'transferirClientesAgregados', 'data':jsonString };

		$.when(Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				Fn.showModal({ id:Basemadre.idModal, show:false});
				switch(a.data.tabla){
					case 'pg_v1': $('#btn-filtrarMaestrosClientesAgregados').click(); break;
				}
			}
		});
	},

	guardarRechazarSolicitud: function(){
		$.when( Fn.validateForm({'id':'frm-rechazarClienteAgregado'})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				var cliente = $('#clienteRechazado').val();
				var clienteHistorico = $('#clienteHistoricoRechazado').val();
				var motivoRechazo = $('#motivoRechazo').val();
				var tabla = $('#tablaDeBaja').val();

				var data ={'tabla':tabla, 'cliente':cliente, 'clienteHistorico':clienteHistorico, 'motivoRechazo':motivoRechazo};
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Basemadre.url+'rechazarSolicitud', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.msg.content;
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

					if (a.result==1) {
						Fn.showModal({ id:Basemadre.idModal, show:false});
						switch(a.data.tabla){
							case 'pg_v1':
								/**CheckBox opciones**/
								var tdChkb = $('#chkb-ca-'+data.clienteHistorico);
								var tdChkbChildren = tdChkb.children().remove();
								tdChkb.html(a.data.htmlEstadoChkb);
								/*Estado Transferir*/
								var tdEstTrans = $('#lb-estTransferir-'+data.clienteHistorico);
								var tdEstTransChildren = tdEstTrans.children().remove();
								tdEstTrans.html(a.data.htmlEstadoTransferir);
								/*Estado Rechazar*/
								var tdEstRechazar = $('#btn-rechazar-'+data.clienteHistorico);
								var tdEstRechazarChildren = tdEstRechazar.children().remove();
								tdEstRechazar.html(a.data.htmlEstadoRechazar);
								/*Estado Pdv*/
								var tdBtnEstadoCa = $('#btn-ca-'+data.clienteHistorico);
								var tdBtnEstadoCaChildren = tdBtnEstadoCa.children().remove();
								tdBtnEstadoCa.html(a.data.htmlEstadoPdv);
								/*Estado Editar*/
								var tdEditarCa = $('#btn-editar-ca-'+data.clienteHistorico);
								var tdEditarCaChildren = tdEditarCa.children().remove();
								tdEditarCa.html(a.data.htmlEditarPdv);
							break;
						}
					}
				});
			}
		});
	},

	guardarRechazarSolicitudMasivo: function(dataClientes){
		$.when( Fn.validateForm({'id':'frm-rechazarClienteAgregado'})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				var motivoRechazo = $('#motivoRechazo').val();
				var tabla = $('#tablaDeBaja').val();

				var data = {'tabla':tabla, 'motivoRechazo':motivoRechazo, 'dataClienteHistorico': dataClientes};
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Basemadre.url+'rechazarSolicitudMasiva', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.msg.content;
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

					if (a.result==1) {
						Fn.showModal({ id:Basemadre.idModal, show:false});
						switch(a.data.tabla){
							case 'pg_v1': $('#btn-filtrarMaestrosClientesAgregados').click(); break;
						}
					}
				});
			}
		});
	},

	verificarGrupoCanalDistribuidoraSucursal: function(){
		//GRUPOCANAL:: 4 => HFS
		var grupoCanal = $('#grupoCanal').val();
		if (['4'].includes(grupoCanal)) {
    		if ( $('input[name="distribuidoraSucursalSelected"]').length==0 ) {
				$('#distribuidoraSucursal').attr("patron","requerido");
			} else {
				$('#distribuidoraSucursal').removeAttr("patron","requerido");
			}
			$('#distribuidoraSucursal').val('').change();
    	}
	},

	cargaMasivaAlternativa: function() {
		var file_data = $('#archivo').prop('files')[0];
		var validar=true;
		

		if(file_data==undefined){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Clientes",content:"Se requiere la carga del archivo.",btn:btn});
			validar=false;
		}

		if(validar){
			var file_name = file_data.name;
			var formato = file_name.split(".");		
			var tipo=$('input[name="ch-tipo"]:checked').val();
			
			var form_data = new FormData();             
			form_data.append('file', file_data); 
			form_data.append('tipo', tipo); 

			if((formato[1]=='csv')||(formato[1]=='CSV')){	
				$.ajax({
					url: site_url+'index.php/configuraciones/maestros/basemadre/carga_masiva_alternativa',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					beforeSend: function(){
						Fn.showLoading(true,'Procesando');
					},
					success: function(a){
						$("#cargas_detalles").empty();
						$("#cargas_detalles").html(a.data);
						$('#btn-sellin-filter').click();
						Fn.showLoading(false);
						setTimeout(Basemadre.ejecutarBat, 0 );
					},
				});
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Clientes",content:"Solo se permite archivos con formato .csv",btn:btn});
				validar=false;
			} 

		}
	
		
	},
	ejecutarBat: function(){
		$.ajax({
			type: "POST",
			url: site_url+'public/bat/bat_clientes.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},

	cargaMasivaAlternativaClienteProyecto: function() {
		var file_data = $('#archivo').prop('files')[0];
		var validar=true;
		

		if(file_data==undefined){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Clientes",content:"Se requiere la carga del archivo.",btn:btn});
			validar=false;
		}

		if(validar){
			var file_name = file_data.name;
			var formato = file_name.split(".");		
			
			var form_data = new FormData();             
			form_data.append('file', file_data); 

			if((formato[1]=='csv')||(formato[1]=='CSV')){	
				$.ajax({
					url: site_url+'index.php/configuraciones/maestros/basemadre/carga_masiva_alternativa_cliente_proyecto',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					beforeSend: function(){
						Fn.showLoading(true,'Procesando');
					},
					success: function(a){
						$("#cargas_detalles").empty();
						$("#cargas_detalles").html(a.data);
						$('#btn-sellin-filter').click();
						Fn.showLoading(false);
						setTimeout(Basemadre.ejecutarBatClienteProyecto, 0 );
					},
				});
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Clientes",content:"Solo se permite archivos con formato .csv",btn:btn});
				validar=false;
			} 

		}
	
		
	},
	ejecutarBatClienteProyecto: function(){
		$.ajax({
			type: "POST",
			url: site_url+'public/bat/bat_clientes_proyecto.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},
}

Basemadre.load();