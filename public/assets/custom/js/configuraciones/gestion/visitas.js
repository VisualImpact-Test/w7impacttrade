var Visitas = {

	frmRutasVisitas: 'frm-rutasVisitas',
	contentDetalleFiltrar: 'idDetalleRutas',
	url : 'configuraciones/gestion/visitas/',

	frmGestorNuevaRuta:'frm-gestorNuevaRuta',
	frmGestorDuplicarRuta:'frm-gestorDuplicarRuta',
	frmGestorReprogramarRutaVisita:'frm-gestorReprogramarRutaVisita',

	idModal: 0,
	dataListaRutasActivo: [],
	dataListaRutasInactivo: [],
	dataListaVisitasActivo: [],
	dataListaVisitasInactivo: [],

	dataListaCuentaProyecto: [],
	dataListaCuentaGrupoCanalCanal: [],
	dataListaCuentaProyectoTipoUsuarioUsuario: [],

	dataListaUsuarios: [],
	dataListaUsuariosNombres: [],

	dataListaClientesNombres: [],


	dataListaVisitasExcluido: [],
	dataListaVisitasIncluido: [],


	dataListaClientes: [],


	secciones: ['Rutas'	,'Visitas'],
	contentSeleccionado:"tab-content-0",

	load: function(){
		// $('#usuario').parent().find('span.select2-container').addClass('sl-width-250');
		$('#combo_ciudad_whls').hide();
		$('#combo_plaza').hide();
		$('#combo_zona').hide();
		$('#combo_distribuidora').hide();
		$('#combo_ciudad_hfs').hide();		
		$('#combo_cadena').hide();		
		$('#combo_banner').hide();		
		$("#cod_cliente").hide();	

		//$('#tipoUsuario').change(function(e){
		$(document).on('change','#tipoUsuario_filtro', function(){
        	var control = $(this);
        	var idTipoUsuario = control.val();
        	var idProyecto = $('#proyecto_filtro').val();

        	if ( idTipoUsuario!=='' ) {
        		var data = { 'idTipoUsuario':idTipoUsuario,'idProyecto':idProyecto };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'obtener_proyecto_general', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						var id = a.data.idProyecto;
						
						if(id==1){
							if(idTipoUsuario==1){
								$('#combo_zona').show();
								$('#combo_distribuidora').show();
								$('#combo_ciudad_hfs').show();	
								$('#usuario').show();	
								
								$('#combo_ciudad_whls').hide();
								$('#combo_plaza').hide();
								$('#combo_cadena').hide();		
								$('#combo_banner').hide();	
								
							}else if(idTipoUsuario==6){
								$('#combo_ciudad_whls').hide();
								$('#combo_plaza').hide();
								$('#combo_zona').hide();
								$('#combo_distribuidora').hide();
								$('#combo_ciudad_hfs').hide();		
								$('#usuario').hide();		
								$('#combo_cadena').hide();		
								$('#combo_banner').hide();	
							}
						}else if (id==2){
							$('#combo_zona').hide();
							$('#combo_distribuidora').hide();
							$('#combo_ciudad_hfs').hide();	
							$('#usuario').show();	
							
							$('#combo_ciudad_whls').hide();
							$('#combo_plaza').hide();
							$('#combo_cadena').hide();		
							$('#combo_banner').hide();	
						}else if (id==3){
							$('#combo_zona').hide();
							$('#combo_distribuidora').hide();
							$('#combo_ciudad_hfs').hide();	
							$('#usuario').show();	
							
							$('#combo_ciudad_whls').hide();
							$('#combo_plaza').hide();
							$('#combo_cadena').show();		
							$('#combo_banner').show();	
						}
					}
				
				});
        	}    
			
		});
		
		$('#grupo_filtro').change(function(e){
			var control = $(this);
        	var idGrupoCanal = control.val();
			var idTipoUsuario = $('#tipoUsuario_filtro').val();
        	if ( idGrupoCanal!=='' ) {
        		var data = { 'idGrupoCanal':idGrupoCanal };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'obtener_grupocanal_general', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						var id = a.data.idGrupoCanal;
						
						if(id == 1 && idTipoUsuario==1){
							$('#combo_ciudad_whls').hide();
							$('#combo_plaza').hide();
							$('#combo_cadena').hide();
							$('#combo_banner').hide();
						
							$('#combo_zona').show();
							$('#combo_distribuidora').show();
							$('#combo_ciudad_hfs').show();
						
						}else if (id == 2 && idTipoUsuario==1){
							$('#combo_ciudad_whls').show();
							$('#combo_plaza').show();
							
							$('#combo_cadena').hide();
							$('#combo_banner').hide();
							$('#combo_zona').hide();
							$('#combo_distribuidora').hide();
							$('#combo_ciudad_hfs').hide();
						}else if (id == 3 && idTipoUsuario==1){
							$('#combo_ciudad_whls').hide();
							$('#combo_plaza').hide();
							
							$('#combo_cadena').show();
							$('#combo_banner').show();
							$('#combo_zona').hide();
							$('#combo_distribuidora').hide();
							$('#combo_ciudad_hfs').hide();
						}
						
						
						
					}
				
				});
        	}    
		});
		
		$(document).on('change','#canal_f', function(){
        	var control = $(this);
        	var zona = control.val();

        	$('#distribuidora option').remove();
        	var option='';
        		option='<option value="">-- Distribuidora --</option>';

        	if ( zona!=='' ) {
        		var data = { 'zona':zona };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'obtener_distribuidora', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						$.each( a.data.zona, function(ix,val){
							option+='<option value="'+val.idDistribuidora+'" >'+val.nombre+'</option>';
						})
					}
					$('#distribuidora').append(option).trigger("create");
				});
        	}       		
        });
		
		$(document).on('change','#zona', function(){
        	var control = $(this);
        	var zona = control.val();

        	$('#distribuidora option').remove();
        	var option='';
        		option='<option value="">-- Distribuidora --</option>';

        	if ( zona!=='' ) {
        		var data = { 'zona':zona };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'obtener_distribuidora', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						$.each( a.data.zona, function(ix,val){
							option+='<option value="'+val.idDistribuidora+'" >'+val.nombre+'</option>';
						})
					}
					$('#distribuidora').append(option).trigger("create");
				});
        	}       		
        });
		
		$(document).on('change','#cadena', function(){
        	var control = $(this);
        	var idCadena = control.val();

        	$('#banner option').remove();
        	var option='';
        		option='<option value="">-- Banner --</option>';

        	if ( idCadena!=='' ) {
        		var data = { 'idCadena':idCadena };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'obtener_banner', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						$.each( a.data.banner, function(ix,val){
							option+='<option value="'+val.idBanner+'" >'+val.nombre+'</option>';
						})
					}
					$('#banner').append(option).trigger("create");
				});
        	}       		
        });
		
		$(document).on('change','#ciudad_whls', function(){
        	var control = $(this);
        	var ciudad = control.val();

        	$('#plaza option').remove();
        	var option='';
        		option='<option value="">-- Plaza --</option>';

        	if ( ciudad!=='' ) {
        		var data = { 'ciudad':ciudad };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'obtener_plazas', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						$.each( a.data.plazas, function(ix,val){
							option+='<option value="'+val.idPlaza+'" >'+val.nombre+'</option>';
						})
					}
					$('#plaza').append(option).trigger("create");
				});
        	}       		
        });
		
		
		$(document).on('change','#distribuidora', function(){
        	var control = $(this);
        	var distribuidora = control.val();
        	var zona = $('#zona').val();

        	$('#ciudad_hfs option').remove();
        	var option='';
        		option='<option value="">-- Ciudad --</option>';

        	if ( distribuidora!=='' && zona!=='' ) {
        		var data = { 'distribuidora':distribuidora,'zona':zona };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'obtener_distribuidora_sucursal', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						$.each( a.data.distribuidora, function(ix,val){
							option+='<option value="'+val.idDistribuidoraSucursal+'" >'+val.provincia+'</option>';
						})
					}
					$('#ciudad_hfs').append(option).trigger("create");
				});
        	}       		
        });
		
		$(document).on('click','#btn-cargaMasivaRutas', function(e){
			e.preventDefault();
			
			var control = $(this);
			var ruta = control.data('url');
			//
			var data = {};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Visitas.url + 'cargaMasivaExcel', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				
				var html='';
					html+=a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
				Visitas.idModal = modalId;

			});
		});
		
		$(document).on('click','#btn-cargaMasivaExclusiones', function(e){
			e.preventDefault();
			
			var control = $(this);
			var ruta = control.data('url');
			//
			var data = {};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Visitas.url + 'cargaMasivaExcelExclusiones', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				
				var html='';
					html+=a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
				Visitas.idModal = modalId;

			});
		});
																		 
		$(document).on('dblclick','.nav-link', function(e){
			var control = $(this);
			var value = control.data('value');
			
            switch (value) {
                case 1:
					$("#tipoGestor").attr("value","1");
					$("#btn-rutaCambiarEstado").show();
					$("#btn-rutaNuevo").show();
					$("#btn-rutaNuevoMasivo").show();
					$("#btn-rutaDuplicar").show();
					$("#btn-rutaReprogramar").show();

					$("#btn-visitaCambiarEstado").hide();
					$("#btn-visitaReprogramar").hide();
					$("#btn-visitaCargaMasiva").hide();
					$("#btn-visitaExcluir").hide();
					$("#btn-visitaExcluirActivar").hide();
					$("#btn-visitaContingencia").hide();
					$("#btn-visitaContingenciaDes").hide();					 						
					Visitas.contentSeleccionado="tab-content-0";
                    break;
                case 2:
					$("#tipoGestor").attr("value","2");
					$("#btn-rutaCambiarEstado").hide();
					$("#btn-rutaNuevo").hide();
					$("#btn-rutaNuevoMasivo").hide();
					$("#btn-rutaDuplicar").hide();
					$("#btn-rutaReprogramar").hide();
		
					$("#btn-visitaCambiarEstado").show();
					$("#btn-visitaReprogramar").show();
					$("#btn-visitaCargaMasiva").show();
					$("#btn-visitaExcluir").show();
					$("#btn-visitaExcluirActivar").show();
					$("#btn-visitaContingencia").show();
					$("#btn-visitaContingenciaDes").show();					 						
					Visitas.contentSeleccionado="tab-content-1";
                    break;
				default:
					break;
			}
			$('#btn-filtrarRutasVisitas').click();
		});
		$(document).on('click','.nav-link', function(e){
			var control = $(this);
			var value = control.data('value');
			
            switch (value) {
                case 1:
					$("#tipoGestor").attr("value","1");
					$("#btn-rutaCambiarEstado").show();
					$("#btn-rutaNuevo").show();
					$("#btn-rutaNuevoMasivo").show();
					$("#btn-rutaDuplicar").show();
					$("#btn-rutaReprogramar").show();

					$("#btn-visitaCambiarEstado").hide();
					$("#btn-visitaReprogramar").hide();
					$("#btn-visitaCargaMasiva").hide();
					$("#btn-visitaExcluir").hide();
					$("#btn-visitaExcluirActivar").hide();
					$("#btn-visitaContingencia").hide();
					$("#btn-visitaContingenciaDes").hide();	
					
					$("#cod_cliente").hide();	

					Visitas.contentSeleccionado="tab-content-0";
                    break;
                case 2:
					$("#tipoGestor").attr("value","2");
					$("#btn-rutaCambiarEstado").hide();
					$("#btn-rutaNuevo").hide();
					$("#btn-rutaNuevoMasivo").hide();
					$("#btn-rutaDuplicar").hide();
					$("#btn-rutaReprogramar").hide();
		
					$("#btn-visitaCambiarEstado").show();
					$("#btn-visitaReprogramar").show();
					$("#btn-visitaCargaMasiva").show();
					$("#btn-visitaExcluir").show();
					$("#btn-visitaExcluirActivar").show();
					$("#btn-visitaContingencia").show();
					$("#btn-visitaContingenciaDes").show();
					$("#cod_cliente").show();	

					Visitas.contentSeleccionado="tab-content-1";
                    break;
				default:
					break;
			}

			// if(Visitas.contentSeleccionado == 'tab-content-1'){
			// 	var grupoCanal = $("#grupo_filtro").val();
			// 	if(grupoCanal == ''){
			// 		grupoCanal = $("#grupo_filtro").prop("selectedIndex", 1).val();
			// 		$("#grupo_filtro").val(grupoCanal);
			// 		$("#grupo_filtro").select2("destroy");
			// 		$("#grupo_filtro").select2();
			// 	}
			// }else if(Visitas.contentSeleccionado == 'tab-content-1'){
			// 	var grupoCanal = $("#grupo_filtro").val();
			// 	if(grupoCanal != ''){
			// 		$("#grupo_filtro").val('');
			// 		$("#grupo_filtro").select2("destroy");
			// 		$("#grupo_filtro").select2();
			// 	}
			// }
		});


		$(document).on('click','#btn-filtrarRutasVisitas', function(e){
			e.preventDefault();

			
			var control = $(this);
			var config = {
				'idFrm' : Visitas.frmRutasVisitas
				,'url': Visitas.url + control.data('url')
				,'contentDetalle': Visitas.contentSeleccionado
			};
			Fn.loadReporte_validado(config);
			Visitas.dataListaRutasActivo = [];
			Visitas.dataListaRutasInactivo = [];
			Visitas.dataListaVisitasActivo = [];
			Visitas.dataListaVisitasInactivo = [];
		});

		$(document).on('click','#chkb-rutasAll', function(){
			var objeto = $(this);

			if (objeto.is(':checked')) {
				$('#tb-gestorReporteRutas').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.chkb-rutaActivo').prop('checked', true);
					var ruta = $(data).find('.chkb-rutaActivo').val();

					if ( typeof ruta !== 'undefined') {
						Visitas.dataListaRutasActivo.push(ruta);
					}
				});
			} else {
				$('#tb-gestorReporteRutas').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.chkb-rutaActivo').prop('checked', false);
					var ruta = $(data).find('.chkb-rutaActivo').val();

					if ( typeof ruta !== 'undefined') {
						Visitas.dataListaRutasActivo = Visitas.dataListaRutasActivo.filter(listaRuta => listaRuta!=ruta);
					}
				});
			}
		});

		$(document).on('click','#chkb-visitasAll', function(){
			var objeto = $(this);
			if (objeto.is(':checked')) {
				$('#tb-gestorReporteVisitas').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.chkb-visitaActivo').prop('checked', true);
					var visita = $(data).find('.chkb-visitaActivo').val();
					if ( typeof visita !== 'undefined') {
						Visitas.dataListaVisitasActivo.push(visita);
					}

					$(data).find('.chkb-visitaIncluido').prop('checked', true);
					var visita = $(data).find('.chkb-visitaIncluido').val();
					if ( typeof visita !== 'undefined') {
						Visitas.dataListaVisitasIncluido.push(visita);
					}
				});
			} else {
				$('#tb-gestorReporteVisitas').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.chkb-visitaActivo').prop('checked', false);
					var visita = $(data).find('.chkb-visitaActivo').val();
					if ( typeof visita !== 'undefined') {
						Visitas.dataListaVisitasActivo = Visitas.dataListaVisitasActivo.filter(listaVisita => listaVisita!=visita);
					}

					$(data).find('.chkb-visitaIncluido').prop('checked', false);
					var visita = $(data).find('.chkb-visitaIncluido').val();
					if ( typeof visita !== 'undefined') {
						Visitas.dataListaVisitasIncluido = Visitas.dataListaVisitasIncluido.filter(listaVisita => listaVisita!=visita);
					}
				});
			}
		});

		$(document).on('click','.chkb-rutaActivo', function(){
			var control = $(this);
			var ruta = control.val();

			if (control.is(':checked')) {
				Visitas.dataListaRutasActivo.push(ruta);
			} else{
				Visitas.dataListaRutasActivo = Visitas.dataListaRutasActivo.filter(listaRuta => listaRuta!=ruta);
			}
		});

		$(document).on('click','.chkb-rutaInactivo', function(){
			var control = $(this);
			var ruta = control.val();

			if (control.is(':checked')) {
				var rutaBuscada = Visitas.dataListaRutasInactivo.filter(listaRuta => listaRuta==ruta);
				if (rutaBuscada.length==0) {
					Visitas.dataListaRutasInactivo.push(ruta);
				}
			} else{
				var rutaBuscada = Visitas.dataListaRutasInactivo.filter(listaRuta => listaRuta==ruta);
				if (rutaBuscada.length>0) {
					const index = Visitas.dataListaRutasInactivo.indexOf(ruta);
					Visitas.dataListaRutasInactivo.splice(index,1);
				}
			}
		});

		$(document).on('click','.chkb-visitaActivo', function(){
			var control = $(this);
			var visita = control.val();
			var exclusion = control.attr("estadoexclusion");
			if (control.is(':checked')) {
				Visitas.dataListaVisitasActivo.push(visita);
			} else{
				Visitas.dataListaVisitasActivo = Visitas.dataListaVisitasActivo.filter(listaVisita => listaVisita!=visita);
			}

			if(exclusion == null || exclusion==''){
				if (control.is(':checked')) {
					Visitas.dataListaVisitasIncluido.push(visita);
				} else{
					Visitas.dataListaVisitasIncluido = Visitas.dataListaVisitasIncluido.filter(listaVisita => listaVisita!=visita);
				}
			}else{
				if (control.is(':checked')) {
					Visitas.dataListaVisitasExcluido.push(visita);
				} else{
					Visitas.dataListaVisitasExcluido = Visitas.dataListaVisitasExcluido.filter(listaVisita => listaVisita!=visita);
				}
			}
		});

		$(document).on('click','.chkb-visitaIncluido', function(){
			var control = $(this);
			var visita = control.val();

			if (control.is(':checked')) {
				Visitas.dataListaVisitasIncluido.push(visita);
			} else{
				Visitas.dataListaVisitasIncluido = Visitas.dataListaVisitasIncluido.filter(listaVisita => listaVisita!=visita);
			}
		});

		$(document).on('click','.chkb-visitaExcluido', function(){
			var control = $(this);
			var visita = control.val();

			if (control.is(':checked')) {
				Visitas.dataListaVisitasExcluido.push(visita);
			} else{
				Visitas.dataListaVisitasExcluido = Visitas.dataListaVisitasExcluido.filter(listaVisita => listaVisita!=visita);
			}
		});

		$(document).on('click','.chkb-visitaInactivo', function(){
			var control = $(this);
			var visita = control.val();
			var exclusion = control.attr("estadoexclusion"); 
			
			if (control.is(':checked')) {
				Visitas.dataListaVisitasInactivo.push(visita);
			} else{
				Visitas.dataListaVisitasInactivo = Visitas.dataListaVisitasInactivo.filter(listaVisita => listaVisita!=visita);
			}

			if(exclusion == null || exclusion==''){
				if (control.is(':checked')) {
					Visitas.dataListaVisitasIncluido.push(visita);
				} else{
					Visitas.dataListaVisitasIncluido = Visitas.dataListaVisitasIncluido.filter(listaVisita => listaVisita!=visita);
				}
			}else{
				if (control.is(':checked')) {
					Visitas.dataListaVisitasExcluido.push(visita);
				} else{
					Visitas.dataListaVisitasExcluido = Visitas.dataListaVisitasExcluido.filter(listaVisita => listaVisita!=visita);
				}
			}
		});

		$(document).on('click','#btn-rutaCambiarEstado', function(e){
			e.preventDefault();
			var gestor = 'rutas';

			if (Visitas.dataListaRutasActivo.length==0 && Visitas.dataListaRutasInactivo.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1="Visitas.guardarCambiarEstadoMasivo(\""+ gestor + "\");";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+(Visitas.dataListaRutasActivo.length + Visitas.dataListaRutasInactivo.length)+'</strong> registros?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Visitas.idModal = modalId;
			}
		});

		$(document).on('click','#btn-visitaCambiarEstado', function(e){
			e.preventDefault();
			var gestor = 'visitas';

			if (Visitas.dataListaVisitasActivo.length==0 && Visitas.dataListaVisitasInactivo.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1="Visitas.guardarCambiarEstadoMasivo(\""+ gestor + "\");";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+(Visitas.dataListaVisitasActivo.length + Visitas.dataListaVisitasInactivo.length)+'</strong> registros?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Visitas.idModal = modalId;
			}
		});
		$(document).on('click','#btn-visitaContingencia', function(e){
			e.preventDefault();
			var gestor = 'visitas';

			if (Visitas.dataListaVisitasActivo.length==0 && Visitas.dataListaVisitasInactivo.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1="Visitas.guardarContingencia(\""+ gestor + "\");";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+(Visitas.dataListaVisitasActivo.length + Visitas.dataListaVisitasInactivo.length)+'</strong> registros?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Visitas.idModal = modalId;
			}
		});
		
		$(document).on('click','#btn-visitaContingenciaDes', function(e){
			e.preventDefault();
			var gestor = 'visitas';

			if (Visitas.dataListaVisitasActivo.length==0 && Visitas.dataListaVisitasInactivo.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1="Visitas.guardarContingenciaDes(\""+ gestor + "\");";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+(Visitas.dataListaVisitasActivo.length + Visitas.dataListaVisitasInactivo.length)+'</strong> registros?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Visitas.idModal = modalId;
			}
		});
		
		$(document).on('click','#btn-rutaNuevo', function(e){
			e.preventDefault();

			var data = Fn.formSerializeObject(Visitas.frmRutasVisitas);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url':Visitas.url+'rutaNuevo', 'data':jsonString };

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Visitas.confirmarGuardarNuevaRuta()';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});
			});
		});

		$(document).on('change','#cuenta', function(){
        	var control = $(this);
        	var cuenta = control.val();
        	var option='';

        	/**PROYECTO**/
        	option+='<option value="">-- Proyecto --</option>';
        	if ( typeof Visitas.dataListaCuentaProyecto[cuenta] !== 'undefined') {
	        	$.each(Visitas.dataListaCuentaProyecto[cuenta]['listaProyectos'], function(ix,val){
	        		option+='<option value="'+val.idProyecto+'">'+val.proyecto+'</option>';
	        	});
	        }
        	$('#proyecto option').remove();
        	$('#proyecto').append(option).trigger("create");

        	/**GRUPO CANAL**/
        	option='';
        	option+='<option value="">-- Grupo Canal --</option>';
        	if ( typeof Visitas.dataListaCuentaGrupoCanalCanal[cuenta] !== 'undefined') {
        		$.each(Visitas.dataListaCuentaGrupoCanalCanal[cuenta]['listaGrupoCanal'], function(ix,val){
        			option+='<option value="'+val.idGrupoCanal+'">'+val.grupoCanal+'</option>';
        		})
        	}
        	$('#grupoCanal option').remove();
        	$('#grupoCanal').append(option).trigger("create");

        	/**CANAL**/
        	$('#canal option').remove();
        	$('#canal').append('<option value="">-- Canal --</option>').trigger("create");

        	/**TIPO USUARIO**/
        	$('#tipoUsuario option').remove();
        	$('#tipoUsuario').append('<option value="">-- Tipo Usuario --</option>').trigger("create");
        	$('#tipoUsuario').change();
        });

        $(document).on('change','#grupoCanal', function(){
        	var control = $(this);
        	var grupoCanal = control.val();
        	var cuenta = $('#cuenta').val();

        	var option='';
        		option='<option value="">-- Canal --</option>';
        	if ( typeof Visitas.dataListaCuentaGrupoCanalCanal[cuenta]['listaGrupoCanal'][grupoCanal] !== 'undefined') {
	        	$.each(Visitas.dataListaCuentaGrupoCanalCanal[cuenta]['listaGrupoCanal'][grupoCanal]['listaCanal'], function(ix,val){
	        		option+='<option value="'+val.idCanal+'">'+val.canal+'</option>';
	        	});
	        }
        	$('#canal option').remove();
        	$('#canal').append(option).trigger("create");
        });

        $(document).on('change','#proyecto', function(){
        	var control = $(this);
        	var proyecto = control.val();
        	var cuenta = $('#cuenta').val();

        	var option='';
        		option='<option value="">-- Tipo Usuario --</option>';
        	if ( typeof Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta] !== 'undefined') {
	        	if ( typeof Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto] !== 'undefined') {
		        	$.each( Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto]['listaTipoUsuario'] , function(ix,val){
		        		option+='<option value="'+val.idTipoUsuario+'">'+val.tipoUsuario+'</option>';
		        	});
		        }
		    }
	        $('#tipoUsuario option').remove();
        	$('#tipoUsuario').append(option).trigger("create");
        	$('#tipoUsuario').change();
        });

        $(document).on('change','#tipoUsuario', function(){
        	var control = $(this);
        	var tipoUsuario = control.val();
        	var cuenta = $('#cuenta').val();
        	var proyecto = $('#proyecto').val();

        	var option='';
        		option='<option value="">-- Usuario --</option>';
        		if ( cuenta!=='' && proyecto!=='' ) {
        			if ( typeof Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta] !== 'undefined') {
        				if ( typeof Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto]) {
		        			if ( typeof Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto]['listaTipoUsuario'][tipoUsuario] !== 'undefined') {
					        	$.each( Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto]['listaTipoUsuario'][tipoUsuario]['listaUsuario'] , function(ix,val){
					        		option+='<option value="'+val.idUsuario+'">'+val.nombreUsuario+'</option>';
					        	});
					        }
					    }
				    }
        		}
			$('.usuarioModal option').remove();
        	// $('#usuario').append(option).trigger("create");
        	$('.usuarioModal').append(option).trigger("create");
        });

        $(document).on('change','#canal', function(){
        	var control = $(this);
        	var canal = control.val();
        	var fecha = $('#fecha').val();
        	var cuenta = $('#cuenta').val();
        	var proyecto = $('#proyecto').val();

        	$('#cliente option').remove();
        	var option='';
        		option='<option value="">-- Lista de Clientes --</option>';

        	if ( fecha!=='' && cuenta!=='' ) {
        		var data = {'fecha':fecha, 'cuenta':cuenta,'proyecto':proyecto, 'canal':canal };
	        	var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'buscarClientes', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					if (a.result==1) {
						$.each( a.data.clientes, function(ix,val){
							option+='<option value="'+val.idCliente+'" data-direccion="'+val.direccion+'">'+val.razonSocial+'</option>';
						})
					}
					$('#cliente').append(option).trigger("create");
				});
        	}       		
        });

        $(document).on('click','#addCliente', function(e){
        	e.preventDefault();

        	var cliente = $('#cliente').val();
        	if (cliente.length>0) {
	        	var clienteText = $('#cliente option:selected').text();
	        	var clienteDireccion = $('#cliente option:selected').data('direccion');
	        	var contCliente = parseInt($('#contCliente').val())+1;

	        	var fila='';
	        		fila+='<tr class="tr-addClientes">';
	        			fila+='<td class="text-center">'+contCliente+'</td>';
	        			fila+='<td>'+clienteText;
	        				fila+='<div class="hide"><input type="text" name="clientesAnadidos" value="'+cliente+'"></div>';
	        			fila+='</td>'
	        			fila+='<td>'+clienteDireccion+'</td>';
	        			fila+='<td class="text-center">';
	        				fila+='<button type="button" class="btn-deleteRow btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
	        			fila+='</td>';
	        		fila+='</tr>';

	        	$('#tb-clientesAñadidos tbody tr.noData').remove();
	        	$('#tb-clientesAñadidos tbody').append(fila).trigger("create");
	        	$('#cliente').val('');

	        	$('#contCliente').val(contCliente);
	        }
        });

        $(document).on('click','.btn-deleteRow', function(e){
        	e.preventDefault();
        	var control = $(this);
        	control.parents('tr').remove();
        });

        $(document).on('click','#btn-rutaDuplicar', function(e){
        	e.preventDefault();

        	if (Visitas.dataListaRutasActivo.length==0) {
        		++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio, debe de seleccionar una <strong>ruta activa</strong>' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				var data={};
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'duplicarRuta', 'data':jsonString }; 

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn1="Visitas.guardarDuplicarRuta();";
					var fn2='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+(Visitas.dataListaRutasActivo.length)+'</strong> registros?' });
						message += a.data.html;
					Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
					Visitas.idModal = modalId;
				})
			}
        });

        $(document).on('click','#btn-rutaReprogramar', function(e){
        	e.preventDefault();

        	if (Visitas.dataListaRutasActivo.length==0) {
        		++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio, debe de seleccionar una <strong>ruta activa</strong>' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				var data={ dataListaRutas: Visitas.dataListaRutasActivo };
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'reprogramarRuta', 'data':jsonString }; 

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn1="Visitas.confirmarGuardarReprogramarRuta();";
					var fn2='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					//var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+(Visitas.dataListaRutasActivo.length)+'</strong> registros?' });
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
					Visitas.idModal = modalId;
					$('.dvFechaGrupal').hide(200);
				})
			}
        });

        $(document).on('change','input[name="asignarFecha"]', function(e){
        	e.preventDefault();
        	var control = $(this);

        	if ( control.val()==1 ) {
        		$('.dvFechaGrupal').hide(400);
        		$('#fechaNuevaGrupal').removeAttr('patron');

        		$('input[name="fecha"]').each( function(e){
        			$(this).val('');
        			$(this).attr('patron','requerido');
        			$(this).prop('readonly', false);
        		})
        	} else {
        		$('.dvFechaGrupal').show(400);
        		$('#fechaNuevaGrupal').attr('patron','requerido');
        		$('input[name="fecha"]').each( function(e){
        			$(this).val('');
        			$(this).removeAttr('patron');
        			$(this).prop('readonly', true);
        		})
        	}
        })

        $(document).on('click','.btnEditarRuta', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var ruta = control.data('ruta');

        	var data = { 'ruta':ruta };
        	var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url':Visitas.url+'editarRuta', 'data':jsonString }; 

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1="Visitas.confirmarActualizarEditarRuta();";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
				Visitas.idModal = modalId;
			})
        });

        $(document).on('click','#btn-visitaReprogramar', function(e){
        	e.preventDefault();

        	if (Visitas.dataListaVisitasActivo.length==0) {
        		++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio, debe de seleccionar una <strong>ruta activa</strong>' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				var data={ dataListaVisitas: Visitas.dataListaVisitasActivo };
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'reprogramarVisita', 'data':jsonString }; 

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn1="Visitas.confirmarGuardarReprogramarVisita();";
					var fn2='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
					Visitas.idModal = modalId;
					$('.dvFechaGrupal').hide(200);
				})
			}
        });

        $(document).on('click','#btn-rutaNuevoMasivo', function(e){
        	e.preventDefault();

        	var data = Fn.formSerializeObject(Visitas.frmRutasVisitas);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url':Visitas.url+'rutaNuevoMasivo', 'data':jsonString };

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Visitas.confirmarGuardarNuevaRutaMasivo()';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});

				//HANDSONTABLE
				var sourceUsuarios = Visitas.dataListaUsuarios;
				var container = document.getElementById('nuevoPuntoMasivoRuta');

				var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: null,
					dataSchema: {idUsuario:null, fecha:null},
					colHeaders: ['ID USUARIO(*)','FECHA'],
					startRows: 10,
					columns: [
						{ data: 'idUsuario' 
							, type:'dropdown'
							, source: sourceUsuarios
						},
						{ data: 'fecha'
							, type:'date'
							, dateFormat: 'DD/MM/YYYY'
							, allowEmpty: false
							
						}
					],
					//minSpareCols: 1, //always keep at least 1 spare row at the right
					minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
					rowHeaders: true, //n° contador de las filas
					//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
					contextMenu: true,
					dropdownMenu: true, //desplegable en la columna, ofrece opciones
					height: 300,
					//width: '100%',
					stretchH: 'all', //Expande todas las columnas al 100%
					maxRows: 500, //cantidad máxima de filas
					manualColumnResize: true,
				};

				Visitas.handsontable = new Handsontable(container,settings);
				setTimeout(function(){
					Visitas.handsontable.render();
				}, 1000);
			});
        });

        $(document).on('click','#btn-visitaCargaMasiva', function(e){
        	e.preventDefault();

        	var data = Fn.formSerializeObject(Visitas.frmRutasVisitas);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url':Visitas.url+'visitaNuevoMasivo', 'data':jsonString };

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Visitas.confirmarGuardarNuevaVisitaMasivo();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});
				//HANDSONTABLE
				var sourceUsuarios = Visitas.dataListaUsuarios;
				var sourceClientes = Visitas.dataListaClientes;
				var container = document.getElementById('nuevoPuntoMasivoVisita');

				Handsontable.renderers.registerRenderer('myDropdownRenderer', HTCustom.myDropdownRenderer);
				Handsontable.cellTypes.registerCellType('myDropdown', {
					renderer: Handsontable.renderers.getRenderer('myDropdownRenderer'),
					editor: Handsontable.editors.DropdownEditor,
					//validator: Handsontable.validators.DropdownValidator,
					validator: function(value, callback) {
						let valueToValidate = value;
						if (valueToValidate === null || valueToValidate === void 0) {
							valueToValidate = '';
						}
						if (this.allowEmpty && valueToValidate === '') {
							callback(true);

						} else if (valueToValidate === '') {
							callback(false);

						} else {

							if(this.source!=null){
								if( isNaN(value) ){
									if(this.source.includes(value)){
										callback(true);
									}else{
										callback(false);
									}
								}else{
									if(this.source.includes(Number(value))){
										callback(true);
									}else{
										callback(false);
									}
								}
								
							}else{
								callback(false);
							}
							
						}
										
					}, 
					source: [' '],
					dpdColumns: [],
					dpdData: [],
				});
				Handsontable.renderers.registerRenderer('myDateRenderer', HTCustom.myDateRenderer);
				
				Handsontable.cellTypes.registerCellType('myDate', {
			// renderer: Handsontable.renderers.DateRenderer,
			renderer: Handsontable.renderers.getRenderer('myDateRenderer'),
			editor: Handsontable.editors.DateEditor,
			validator: Handsontable.validators.DateValidator,
			dateFormat: 'DD/MM/YYYY',
			correctFormat: true,
			placeholder: moment().format('DD/MM/YYYY'),
			defaultDate: moment().toDate(),
			datePickerConfig: {
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

				// // Opcion para desactivar días
				// disableDayFn: function (date) {
				// 	return date.getDay() === 0 || date.getDay() === 6;
				// }
			}
		});

				var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: null,
					dataSchema: {idUsuario:null, fecha:null, cliente:null},
					colHeaders: ['FECHA','ID USUARIO(*)','ID CLIENTE'],
					startRows: 10,
					language: 'es-MX',
					allowInvalid: true,
					columns: [
						{ data: 'fecha'
							, type:'myDate'
							, dateFormat: 'DD/MM/YYYY'
							, allowEmpty: false
						},
						{ data: 'idUsuario' 
							, type:'myDropdown'
							, source: sourceUsuarios
							
						},
						{ data: 'cliente'
							, type: 'myDropdown'
							, source: sourceClientes
						}
					],
					//minSpareCols: 1, //always keep at least 1 spare row at the right
					minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
					rowHeaders: true, //n° contador de las filas
					//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
					contextMenu: true,
					dropdownMenu: false, //desplegable en la columna, ofrece opciones
					height: 300,
					//width: '100%',
					stretchH: 'all', //Expande todas las columnas al 100%
					maxRows: 500, //cantidad máxima de filas
					manualColumnResize: true,
					//FUNCIONES
					
				};

				Visitas.handsontable = new Handsontable(container,settings);
				setTimeout(function(){
					Visitas.handsontable.render();
				}, 1000);
			});
		});
		
		$(document).on('click','#btn-actualizarListas', function(e){
        	e.preventDefault();
			
				var fn1="Visitas.actualizarLista();";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea actualizar las listas de las visitas actuales?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Visitas.idModal = modalId;
		});
		

		$(document).on('click','#btn-visitaExcluir', function(e){
        	e.preventDefault();
        	if (Visitas.dataListaVisitasIncluido.length==0 && Visitas.dataListaVisitasExcluido.length==0) {
        		++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio, debe de seleccionar una <strong>visita activa</strong>' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				var data={   };
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Visitas.url+'excluirVisitas', 'data':jsonString }; 

				var cantIncluido=0;
				var cantExcluido=0;
				
				if(Visitas.dataListaVisitasIncluido!=null){
					cantIncluido=Visitas.dataListaVisitasIncluido.length;
				}
				if(Visitas.dataListaVisitasExcluido!=null){
					cantExcluido=Visitas.dataListaVisitasExcluido.length;
				}

				if(cantIncluido>0){
					$.when( Fn.ajax(configAjax)).then( function(a){
						++modalId;
						var fn1="Visitas.confirmarCambiarEstadoExclusionMasivo("+cantIncluido+","+cantExcluido+");";
						var fn2='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Continuar',fn:fn1};
							btn[1]={title:'Cerrar',fn:fn2};
						var message = a.data.html;
						Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'50%'});
						Visitas.idModal = modalId;
					});
				}else{
					Visitas.confirmarCambiarEstadoExclusionMasivo(cantIncluido,cantExcluido);
				}

				
			}
        });
		
		$(document).on('click','#btn-visitaExcluirActivar', function(e){
        	e.preventDefault();
			var gestor = 'visitas';

			if (Visitas.dataListaVisitasActivo.length==0 && Visitas.dataListaVisitasInactivo.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1="Visitas.activar_exluciones(\""+ gestor + "\");	Fn.showModal({ id:modalId, show:false});";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+(Visitas.dataListaVisitasActivo.length + Visitas.dataListaVisitasInactivo.length)+'</strong> registros?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Visitas.idModal
				
			}
        });

		$(document).ready(function () {
			$('#btn-filtrarRutasVisitas').click();
			$('#grupo_filtro').change();
			$('#tipoUsuario_filtro').change();
		});
	},
	guardarContingencia: function(tipoGestor){
		var data ={ 'tipoGestor': tipoGestor,'dataRutas':Visitas.dataListaRutasActivo, 'dataRutasInactivas':Visitas.dataListaRutasInactivo, 'dataVisitasActivas':Visitas.dataListaVisitasActivo, 'dataVisitasInactivas': Visitas.dataListaVisitasInactivo };
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Visitas.url+'cambiarContingenciaMasivo', 'data':jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
			if (a.result==1) {
				Fn.showModal({ id:Visitas.idModal, show:false});
				$('#btn-filtrarRutasVisitas').click();
				Visitas.dataListaRutasActivo = [];
				Visitas.dataListaRutasInactivo = [];
				Visitas.dataListaVisitasActivo = [];
				Visitas.dataListaVisitasInactivo = [];
			}
		});
	},

	guardarContingenciaDes: function(tipoGestor){
		var data ={ 'tipoGestor': tipoGestor,'dataRutas':Visitas.dataListaRutasActivo, 'dataRutasInactivas':Visitas.dataListaRutasInactivo, 'dataVisitasActivas':Visitas.dataListaVisitasActivo, 'dataVisitasInactivas': Visitas.dataListaVisitasInactivo };
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Visitas.url+'cambiarContingenciaMasivoDes', 'data':jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
			if (a.result==1) {
				Fn.showModal({ id:Visitas.idModal, show:false});
				$('#btn-filtrarRutasVisitas').click();
				Visitas.dataListaRutasActivo = [];
				Visitas.dataListaRutasInactivo = [];
				Visitas.dataListaVisitasActivo = [];
				Visitas.dataListaVisitasInactivo = [];
			}
		});
	},
	
	activar_exluciones: function(tipoGestor){
	
		var data ={ 'dataVisitasIncluido':Visitas.dataListaVisitasIncluido, 'dataVisitasExcluido': Visitas.dataListaVisitasExcluido, 'idTipoExclusion': $('#idTipoExclusion').val(),'comentarioExclusion' :$('#comentarioExclusion').val() };
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Visitas.url+'excluirVisitasActivar', 'data':jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
			if (a.result==1) {
				Fn.showModal({ id:Visitas.idModal, show:false});
				$('#btn-filtrarRutasVisitas').click();
				Visitas.dataListaVisitasIncluido = [];
				Visitas.dataListaVisitasExcluido = [];
			}
		});
	},
	
	
	
	guardarCambiarEstadoMasivo: function(tipoGestor){
		var data ={ 'tipoGestor': tipoGestor,'dataRutas':Visitas.dataListaRutasActivo, 'dataRutasInactivas':Visitas.dataListaRutasInactivo, 'dataVisitasActivas':Visitas.dataListaVisitasActivo, 'dataVisitasInactivas': Visitas.dataListaVisitasInactivo };
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Visitas.url+'cambiarEstadoMasivo', 'data':jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
			if (a.result==1) {
				Fn.showModal({ id:Visitas.idModal, show:false});
				$('#btn-filtrarRutasVisitas').click();
				Visitas.dataListaRutasActivo = [];
				Visitas.dataListaRutasInactivo = [];
				Visitas.dataListaVisitasActivo = [];
				Visitas.dataListaVisitasInactivo = [];
			}
		});
	},

	confirmarCambiarEstadoExclusionMasivo: function(cantIncluido,cantExcluido){
		++modalId;
		var fn1='Visitas.guardarCambiarEstadoExclusionMasivo();Fn.showModal({ id:'+modalId+',show:false });';
		var fn2='Fn.showModal({ id:'+modalId+',show:false });';
		var btn=new Array();
			btn[0]={title:'Continuar',fn:fn1};
			btn[1]={title:'Cerrar',fn:fn2};

		var message_="Se realizan los siguientes cambios: <br>";
		if(cantIncluido>0){
			message_+=" se excluiran "+cantIncluido+" visitas con los datos ingresados<br>";
		}
		if(cantExcluido>0){
			message_+=" se incluiran "+cantExcluido+" visitas <br>";
		}
		message_+="¿Desea continuar con la acción?"

		Fn.showModal({ id:modalId,title:'Alerta',content:message_,btn:btn,show:true});
	},

	guardarCambiarEstadoExclusionMasivo: function(){
		var data ={ 'dataVisitasIncluido':Visitas.dataListaVisitasIncluido, 'dataVisitasExcluido': Visitas.dataListaVisitasExcluido, 'idTipoExclusion': $('#idTipoExclusion').val(),'comentarioExclusion' :$('#comentarioExclusion').val() };
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Visitas.url+'cambiarEstadoExclusionMasivo', 'data':jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
			if (a.result==1) {
				Fn.showModal({ id:Visitas.idModal, show:false});
				$('#btn-filtrarRutasVisitas').click();
				Visitas.dataListaVisitasIncluido = [];
				Visitas.dataListaVisitasExcluido = [];
			}
		});
	},

	confirmarGuardarNuevaRuta: function(){
		$.when( Fn.validateForm({'id':Visitas.frmGestorNuevaRuta})).then( function(a){
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
				var fn1='Visitas.guardarNuevaRuta();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	guardarNuevaRuta: function(){
		var data = Fn.formSerializeObject(Visitas.frmGestorNuevaRuta);
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url':Visitas.url+'guardarNuevaRuta', 'data': jsonString };

		$.when( Fn.ajax(configAjax) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			

			if (a.result==1) {
				//Fn.showModal({ id:Visitas.idModal,show:false });
				$("#btn-filtrarRutasVisitas").click();
			}
		});
	},

	guardarDuplicarRuta: function(){
		$.when( Fn.validateForm({'id':Visitas.frmGestorDuplicarRuta})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				var data = { dataForm: Fn.formSerializeObject(Visitas.frmGestorDuplicarRuta), dataListaRutas: Visitas.dataListaRutasActivo };
				var jsonString = { 'data': JSON.stringify(data) };
				var configAjax = { 'url':Visitas.url+'guardarDuplicarRuta', 'data': jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.msg.content;
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
					
					if (a.result==1) {
						Fn.showModal({ id:Visitas.idModal, show:false});
						$('#btn-filtrarRutasVisitas').click();
						Visitas.dataListaRutasActivo = [];
					}
				});
			}
		})
	},

	confirmarGuardarReprogramarRuta: function(){
		$.when( Fn.validateForm({'id':Visitas.frmGestorReprogramarRutaVisita})).then( function(a){
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
				var fn1='Visitas.guardarReprogramarRuta();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	guardarReprogramarRuta: function(){
		var dataRutas = [];
		var arrayRuta = [];
		var cont=0;
		var asignarFecha = $('input[name="asignarFecha"]').val();
		var fechaGrupal = $('#fechaNuevaGrupal').val();

		$('.tr-reprogramarRuta').each( function(row){
			var tr = $(this);
			var ruta = tr.data('ruta');
			var fechaNueva = tr.find('input[name="fecha"]').val();
			var usuarioNuevo = tr.find('select[name="usuario"]').val();
			var usuarioNuevoText = tr.find('select[name="usuario"] option:selected').text();

			arrayRuta = {
				'ruta': ruta
				,'fecha':fechaNueva
				,'usuario':usuarioNuevo
				,'usuarioTexto':usuarioNuevoText
			};

			dataRutas.push(arrayRuta);
		})

		var data = { 'tipoAsignar':asignarFecha, 'fechaGrupal':fechaGrupal, 'dataRutas': dataRutas };
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url':Visitas.url+'guardarReprogramarRuta', 'data': jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
			if (a.result==1) {
				Fn.showModal({ id:Visitas.idModal, show:false});
				$('#btn-filtrarRutasVisitas').click();
				Visitas.dataListaRutasActivo = [];
			}
		});
	},

	confirmarActualizarEditarRuta: function(){
		++modalId;
		var fn1='Visitas.actualizarEditarRuta();Fn.showModal({ id:'+modalId+',show:false });';
		var fn2='Fn.showModal({ id:'+modalId+',show:false });';
		var btn=new Array();
			btn[0]={title:'Continuar',fn:fn1};
			btn[1]={title:'Cerrar',fn:fn2};
		var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
		Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
	},

	actualizarEditarRuta: function(){
		var dataClientesAdicionales = [];
		var dataClientesQuitar = [];
		var arrayVisita = [];
		var cont=0;
		var ruta = $('#ruta').val();

		$('.tr-listadoClientes').each( function(row){
			var tr = $(this);
			var input = tr.find('input[name="cliente"]');
			if (!input.is(':checked')) {

				arrayVisita = {
					'ruta' : ruta
					,'cliente': input.val()
				};

				dataClientesQuitar.push(arrayVisita);
			}
		});

		$('.tr-addClientes').each( function(row){
			var tr = $(this);
			var input = tr.find('input[name="clientesAnadidos"]');

			arrayVisita = {
				'ruta' : ruta
				,'cliente': input.val()
			};

			dataClientesAdicionales.push(arrayVisita);
		});


		$(document).on('click','.chkb-visitaInactivo', function(){
			var control = $(this);
			var visita = control.val();
			if (control.is(':checked')) {
				Visitas.dataListaVisitasExcluido.push(visita);
			} else{
				Visitas.dataListaVisitasExcluido = Visitas.dataListaVisitasExcluido.filter(listaVisita => listaVisita!=visita);
			}
		});

		

		if ( dataClientesAdicionales.length==0 && dataClientesQuitar.length==0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+', show:false});';
			var btn = new Array();
				btn[0]={title:'Cerrar', fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
			Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
		} else {
			var data = { 'ruta':ruta, 'dataClientesAdicionales':dataClientesAdicionales, 'dataClientesQuitar':dataClientesQuitar };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url':Visitas.url+'actualizarEditarRuta', 'data': jsonString };

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = a.msg.content;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
				
				if (a.result==1) {
					Fn.showModal({ id:Visitas.idModal, show:false});
					//$('#btn-filtrarRutasVisitas').click();
				}
			});
		}
	},

	confirmarGuardarReprogramarVisita: function(){
		$.when( Fn.validateForm({'id':Visitas.frmGestorReprogramarRutaVisita})).then( function(a){
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
				var fn1='Visitas.guardarReprogramarVisita();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	guardarReprogramarVisita: function(){
		var dataVisitas = [];
		var arrayVisita = [];
		var cont=0;
		var asignarFecha = $('input[name="asignarFecha"]').val();
		var fechaGrupal = $('#fechaNuevaGrupal').val();

		$('.tr-reprogramarVisita').each( function(row){
			var tr = $(this);
			var ruta = tr.data('ruta');
			var visita = tr.data('visita');
			var flagProgramar = tr.find('input[name="flagProgramar"]').val();
			var fechaNueva = tr.find('input[name="fecha"]').val();
			var usuarioNuevo = tr.find('select[name="usuario"]').val();
			var usuarioNuevoText = tr.find('select[name="usuario"] option:selected').text();
			var cliente = tr.find('input[name="cliente"]').val();
			var clienteText = tr.find('input[name="clienteTexto"]').val();

			arrayVisita = {
				'ruta': ruta
				,'visita': visita
				,'flagProgramar': flagProgramar
				,'fecha':fechaNueva
				,'usuario':usuarioNuevo
				,'usuarioTexto':usuarioNuevoText
				,'cliente':cliente
				,'clienteTexto':clienteText
			};

			dataVisitas.push(arrayVisita);
		})

		var data = { 'tipoAsignar':asignarFecha, 'fechaGrupal':fechaGrupal, 'dataVisitas': dataVisitas };
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url':Visitas.url+'guardarReprogramarVisita', 'data': jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn,width:'70%'});
			
			if (a.result==1) {
				Fn.showModal({ id:Visitas.idModal, show:false});
				$('#btn-filtrarRutasVisitas').click();
				Visitas.dataListaRutasActivo = [];
			}
		});
	},

	confirmarGuardarNuevaRutaMasivo: function(){
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoPuntoMasivoRuta .htInvalid').length;
		var arrayDataRutas = [];
		for (var ix = 0; ix < Visitas.handsontable.countRows(); ix++) {
			if (!Visitas.handsontable.isEmptyRow(ix)) {
				arrayDataRutas.push(Visitas.handsontable.getDataAtRow(ix));
			}
		}

		if ( arrayDataRutas.length==0) {
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
			var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			++modalId;
			var fn1='Visitas.guardarNuevoPuntoMasivoRuta();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},

	guardarNuevoPuntoMasivoRuta: function(){
		var arrayDataRutas = [];
		for (var ix = 0; ix < Visitas.handsontable.countRows(); ix++) {
			if (!Visitas.handsontable.isEmptyRow(ix)) {
				arrayDataRutas.push(Visitas.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataRutas;
		var jsonString = {'data': JSON.stringify(dataArrayCargaMasiva)};
		var configAjax = {'url':Visitas.url+'guardarNuevoPuntoMasivoRuta', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	},

	confirmarGuardarNuevaVisitaMasivo: function(){
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoPuntoMasivoVisita .htInvalid').length;
		var arrayDataRutasVisitas = [];
		for (var ix = 0; ix < Visitas.handsontable.countRows(); ix++) {
			if (!Visitas.handsontable.isEmptyRow(ix)) {
				arrayDataRutasVisitas.push(Visitas.handsontable.getDataAtRow(ix));
			}
		}

		if ( arrayDataRutasVisitas.length==0) {
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
			var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			++modalId;
			var fn1='Visitas.guardarNuevoPuntoMasivoVisita();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},

	guardarNuevoPuntoMasivoVisita: function(){
		var arrayDataRutasVisitas = [];
		for (var ix = 0; ix < Visitas.handsontable.countRows(); ix++) {
			if (!Visitas.handsontable.isEmptyRow(ix)) {
				arrayDataRutasVisitas.push(Visitas.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataRutasVisitas;
		var jsonString = {'data': JSON.stringify(dataArrayCargaMasiva)};
		var configAjax = {'url':Visitas.url+'guardarNuevoPuntoMasivoRutaVisita', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });$("#btn-filtrarRutasVisitas").click();';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	},

	actualizarLista: function(){
		var data = { };
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url':Visitas.url+'actualizarListas', 'data': jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
		});
	},
	cargaVisitasExcel: function(){
		var file_data = $('#archivo').prop('files')[0];
		var file_name = file_data.name;
        var formato = file_name.split(".");	
		var tipo = $('#tipo').val();				
		
		var form_data = new FormData();             
		form_data.append('file', file_data);
		form_data.append('tipoUsuario', tipo); 
		

		if((formato[1]=='csv')||(formato[1]=='CSV')){	
			$.ajax({
				url: site_url+'index.php/configuraciones/gestion/visitas/cargarArchivo',
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
					setTimeout(Visitas.ejecutarBat, 0 )
				},
			});
		} else {

		} 
	},
	
	cargaExclusionesExcel: function(){
		var file_data = $('#archivo').prop('files')[0];
		var file_name = file_data.name;
        var formato = file_name.split(".");	
		var tipo = $('#tipo').val();				
		
		var form_data = new FormData();             
		form_data.append('file', file_data);
		form_data.append('tipoUsuario', tipo); 
		

		if((formato[1]=='csv')||(formato[1]=='CSV')){	
			$.ajax({
				url: site_url+'index.php/configuraciones/gestion/visitas/cargarArchivoExclusiones',
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
					setTimeout(Visitas.ejecutarBatExclusiones, 0 )
				},
			});
		} else {

		} 
	},
	
	ejecutarBat: function(){
		$.ajax({
			type: "POST",
			url: site_url+'public/bat/bat_visitas.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},
	
	ejecutarBatExclusiones: function(){
		$.ajax({
			type: "POST",
			url: site_url+'public/bat/bat_exclusiones.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},
}
Visitas.load();