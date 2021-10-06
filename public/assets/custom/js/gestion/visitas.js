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

	load: function(){
		$('.dvDetalleVisitas').hide(300);

		

		$(document).on('click','#btn-filtrarRutasVisitas', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Visitas.frmRutasVisitas
				,'url': Visitas.url + control.data('url')
				,'contentDetalle': Visitas.contentDetalleFiltrar
			};

			Fn.loadReporte(config);

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
					$(data).find('.chkb-ruta').prop('checked', false);
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
				});
			} else {
				$('#tb-gestorReporteVisitas').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.chkb-visitaActivo').prop('checked', false);
					var visita = $(data).find('.chkb-visitaActivo').val();
					if ( typeof visita !== 'undefined') {
						Visitas.dataListaVisitasActivo = Visitas.dataListaVisitasActivo.filter(listaVisita => listaVisita!=visita);
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
				Visitas.dataListaRutasInactivo = Visitas.dataListaRutasInactivo.filter(listaRuta => listaRuta!=ruta);
			} else{
				Visitas.dataListaRutasInactivo.push(ruta);
			}
		});

		$(document).on('click','.chkb-visitaActivo', function(){
			var control = $(this);
			var visita = control.val();

			if (control.is(':checked')) {
				Visitas.dataListaVisitasActivo.push(visita);
			} else{
				Visitas.dataListaVisitasActivo = Visitas.dataListaVisitasActivo.filter(listaVisita => listaVisita!=visita);
			}
		});

		$(document).on('click','.chkb-visitaInactivo', function(){
			var control = $(this);
			var visita = control.val();

			if (control.is(':checked')) {
				Visitas.dataListaVisitasInactivo = Visitas.dataListaVisitasInactivo.filter(listaVisita => listaVisita!=visita);
			} else{
				Visitas.dataListaVisitasInactivo.push(visita);
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
        	if ( typeof Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto] !== 'undefined') {
	        	$.each( Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto]['listaTipoUsuario'] , function(ix,val){
	        		option+='<option value="'+val.idTipoUsuario+'">'+val.tipoUsuario+'</option>';
	        	});
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
        			if ( typeof Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto]['listaTipoUsuario'][tipoUsuario] !== 'undefined') {
			        	$.each( Visitas.dataListaCuentaProyectoTipoUsuarioUsuario[cuenta][proyecto]['listaTipoUsuario'][tipoUsuario]['listaUsuario'] , function(ix,val){
			        		option+='<option value="'+val.idUsuario+'">'+val.nombreUsuario+'</option>';
			        	});
			        }
        		}
	        $('#usuario option').remove();
        	$('#usuario').append(option).trigger("create");
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
				var sourceUsuarios = Visitas.dataListaUsuariosNombres;
				var container = document.getElementById('nuevoPuntoMasivoRuta');

				var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: null,
					dataSchema: {idUsuario:null, usuario:null, fecha:null},
					colHeaders: ['CÓDIGO USUARIO(*)','COLABORADOR','FECHA'],
					startRows: 10,
					columns: [
						{ data: 'idUsuario' 
							, readOnly: true
							, type:'numeric'
							, numericFormat:{
								pattern: '0'
							}
						},
						{ data: 'usuario'
							, type: 'dropdown'
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
					//FUNCIONES
					afterChange: function(changes, source){
						var elemento = this;
						if ( changes!= null ) {
							changes.forEach(function(item){
								if (item[1]=='usuario') {
									var usuarioResultado = Visitas.dataListaUsuarios.find( itemUsuario => itemUsuario.nombreUsuario===item[3]);

									if ( typeof usuarioResultado !== 'undefined') {
										Visitas.handsontable.setDataAtCell(item[0],0,usuarioResultado['idUsuario']);
										elemento.setCellMeta(item[0],0,'className','changeTrue');
									} else {
										Visitas.handsontable.setDataAtCell(item[0],0,'*');
										elemento.setCellMeta(item[0],0,'className','changeFalse');
									}
								}
							});
						}
					}
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
				var fn1='Visitas.confirmarGuardarNuevaVisitaMasivo()';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});

				//HANDSONTABLE
				var sourceUsuarios = Visitas.dataListaUsuariosNombres;
				var sourceClientes = Visitas.dataListaClientesNombres;
				var container = document.getElementById('nuevoPuntoMasivoVisita');

				var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: null,
					dataSchema: {idUsuario:null, usuario:null, fecha:null, cliente:null},
					colHeaders: ['CÓDIGO USUARIO(*)','COLABORADOR','FECHA','CLIENTE'],
					startRows: 10,
					columns: [
						{ data: 'idUsuario' 
							, readOnly: true
							, type:'numeric'
							, numericFormat:{
								pattern: '0'
							}
						},
						{ data: 'usuario'
							, type: 'dropdown'
							, source: sourceUsuarios
						},
						{ data: 'fecha'
							, type:'date'
							, dateFormat: 'DD/MM/YYYY'
							, allowEmpty: false
						},
						{ data: 'cliente'
							, type: 'dropdown'
							, source: sourceClientes
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
					//FUNCIONES
					afterChange: function(changes, source){
						var elemento = this;
						if ( changes!= null ) {
							changes.forEach(function(item){
								if (item[1]=='usuario') {
									var usuarioResultado = Visitas.dataListaUsuarios.find( itemUsuario => itemUsuario.nombreUsuario===item[3]);

									if ( typeof usuarioResultado !== 'undefined') {
										Visitas.handsontable.setDataAtCell(item[0],0,usuarioResultado['idUsuario']);
										elemento.setCellMeta(item[0],0,'className','changeTrue');
									} else {
										Visitas.handsontable.setDataAtCell(item[0],0,'*');
										elemento.setCellMeta(item[0],0,'className','changeFalse');
									}
								}
							});
						}
					}
				};

				Visitas.handsontable = new Handsontable(container,settings);
				setTimeout(function(){
					Visitas.handsontable.render();
				}, 1000);
			});
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
			var fechaNueva = tr.find('input[name="fecha"]').val();
			var usuarioNuevo = tr.find('select[name="usuario"]').val();
			var usuarioNuevoText = tr.find('select[name="usuario"] option:selected').text();
			var cliente = tr.find('input[name="cliente"]').val();
			var clienteText = tr.find('input[name="clienteTexto"]').val();

			arrayVisita = {
				'ruta': ruta
				,'visita': visita
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
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	}
}
Visitas.load();