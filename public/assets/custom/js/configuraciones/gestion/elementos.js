var Elementos = {
	tipoListaVisibilidad:'',
	url : 'configuraciones/gestion/elementosVisibilidad/',
	frmElementosVisibilidad : 'frm-elementosVisibilidad',
	frmVisibilidadObligatoria : 'frm-AudVisibilidadOblig',
	frmVisibilidadIniciativa : 'frm-AudVisibilidadInic',
	frmVisibilidadAdicional : 'frm-AudVisibilidadAdic',
	frmNuevoEditar : 'frm-elementoNuevoEditar',
	contentDetalleElementos : 'idResumenElementos',
	contentDetalleObligatorio : 'idDetalleAuditVisibilidadOblig',
	tbListaObligatoria : 'tb-detalleObligatorio',
	contentDetalleIniciativa : 'idDetalleAuditVisibilidadInic',
	tbListaIniciativa : 'tb-detalleIniciativa',
	contentDetalleAdicional : 'idDetalleAuditVisibilidadAdic',
	tbListaAdicional : 'tb-detalleAdicional',
	idModal: 0,

	dataListaTipoElementosNombre: [],
	dataListaCategoriaNombre: [],

	handsontable : '',

	load: function(){
		$('#opciones-2').hide();
		$('#divDetalleAuditVisibilidadOblig').hide();
		$('#opciones-3').hide();
		$('#divDetalleAuditVisibilidadInic').hide();
		$('#opciones-4').hide();
		$('#divDetalleAuditVisibilidadAdic').hide();

		$(document).on('click','.btnOpcionTab', function(e){
			e.preventDefault();

			var opcion=$(this).data('value');
			switch(opcion){
				case 1:
					$('#opciones-1').show(500); $('#divDetalleElementos').show(500);
					$('#opciones-2').hide(500); $('#divDetalleAuditVisibilidadOblig').hide(500);
					$('#opciones-3').hide(500); $('#divDetalleAuditVisibilidadInic').hide(500);
					$('#opciones-4').hide(500); $('#divDetalleAuditVisibilidadAdic').hide(500);
					Elementos.tipoListaVisibilidad='elementos';
				break;
				case 2:
					$('#opciones-1').hide(500); $('#divDetalleElementos').hide(500);
					$('#opciones-2').show(500); $('#divDetalleAuditVisibilidadOblig').show(500);
					$('#opciones-3').hide(500); $('#divDetalleAuditVisibilidadInic').hide(500);
					$('#opciones-4').hide(500); $('#divDetalleAuditVisibilidadAdic').hide(500);
					Elementos.tipoListaVisibilidad='obligatoria';
				break;
				case 3:
					$('#opciones-1').hide(500); $('#divDetalleElementos').hide(500);
					$('#opciones-2').hide(500); $('#divDetalleAuditVisibilidadOblig').hide(500);
					$('#opciones-3').show(500); $('#divDetalleAuditVisibilidadInic').show(500);
					$('#opciones-4').hide(500); $('#divDetalleAuditVisibilidadAdic').hide(500);
					Elementos.tipoListaVisibilidad='iniciativa';
				break;
				case 4:
					$('#opciones-1').hide(500); $('#divDetalleElementos').hide(500);
					$('#opciones-2').hide(500); $('#divDetalleAuditVisibilidadOblig').hide(500);
					$('#opciones-3').hide(500); $('#divDetalleAuditVisibilidadInic').hide(500);
					$('#opciones-4').show(500); $('#divDetalleAuditVisibilidadAdic').show(500);
					Elementos.tipoListaVisibilidad='adicional';
				break;
			}
		});

		/*==Elementos de Visibilidad==*/
		$(document).on('click','#btn-filtrarElementosVisibilidad', function(e){
			e.preventDefault();

			var control=$(this);
			var data = Fn.formSerializeObject(Elementos.frmElementosVisibilidad);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Elementos.url+control.data('url'), 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				if ( a['status'] == null) {
					return false;
				}

				$('#'+Elementos.contentDetalleElementos).html(a.data.html);
				if (a.result==1) {
					$('#'+a.data.datatable).DataTable();
				}
				//LIMPIAMOS EL BOTON DE DESACTIVAR
				Elementos.limpiarBotonesAccion();
			})
		});

		$(document).on('click','#chkb-estadoAllElementos', function(){
			var input=$(this);

			if (input.is(':checked')) {
				$('#tb-elementosDetalle').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstado').prop('checked', true);
				});
			} else {
				$('#tb-elementosDetalle').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstado').prop('checked', false);
				});
			}

			Elementos.botonesAccion();
		});

		$(document).on('click','input[name="cambiarEstado"]', function(){
			var control=$(this);
			Elementos.botonesAccion();
		});

		$(document).on('click','.btnCambiarEstado', function(e){
			e.preventDefault();

			var control = $(this);
			var data = {elementosVisibilidad: control.data('elemento'), estado: control.data('estado')};

			++modalId;
			var fn1='Elementos.guardarCambiarEstado('+JSON.stringify(data)+');Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				message+='<span>Se procedera a <strong>'+control.data('titleCambio')+'</strong> el registro.</span>';
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		});

		$(document).on('click','#btn-cambiarEstadoElementos', function(e){
			e.preventDefault();

			var dataElementos=[];
			var arrayElementos=[];
			var cont=0;

			$('#tb-elementosDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var elementosVisibilidad = '';
				var estado = '';

				if ( tr.find('input[name="cambiarEstado"]').is(':checked') ) {
					var input = tr.find('input[name=cambiarEstado]');
					elementosVisibilidad = input.data('elemento');
					estado = $('#aElemento-'+elementosVisibilidad).data('estado');

					//INSERTAMOS ARRAY
					arrayElementos = {'elementosVisibilidad':elementosVisibilidad, 'estado':estado};
					dataElementos.push(arrayElementos);
					cont++;
				}
			});

			if (dataElementos.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': '<strong>No</strong> se ha <strong>seleccionado</strong> ningún <strong>elemento</strong> a cambiar' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Elementos.guardarCambiarEstadoMasivo('+JSON.stringify(dataElementos)+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+cont+'</strong> registros?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Elementos.idModal = modalId;
			}
		});

		$(document).on('click','.editarElemento', function(e){
			e.preventDefault();

			var control=$(this);
			var elementosVisibilidad = control.data('elemento');
			var data = {'elementosVisibilidad':elementosVisibilidad};
			var jsonString = {'data':JSON.stringify(data)};
        	var configAjax = {'url':Elementos.url+'editarElemento', 'data':jsonString};

        	$.when(Fn.ajax(configAjax)).then( function(a){
        		++modalId;
        		var fn1='Elementos.confirmarActualizarElemento();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Actualizar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
				Elementos.idModal = modalId;
        	});
		});

		$(document).on('click','#btn-nuevoElemento', function(e){
			var data={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url':Elementos.url+'nuevoElemento', 'data':jsonString};

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Elementos.confirmarGuardarNuevoElemento();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
				Elementos.idModal = modalId;
			});
		});

		$(document).on('click','#btn-cargaMasivaElemento', function(e){
			var data={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url':Elementos.url+'nuevoElementoMasivo', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Elementos.confirmarGuardarNuevoElementoMasivo();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar', fn:fn1};
					btn[1]={title:'Cerrar', fn:fn2};
					
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
				Elementos.idModal = modalId;

				//Generamos la VENTANA
				Elementos.ventanaCargaMasiva();
			});
		});

		/*==Lista Auditoria Visibilidad==*/
		$(document).on('click','.btn-filtrarAuditoriaVisibilidad', function(e){
			e.preventDefault();

			var control=$(this);
			var tipoAuditoria = control.data('visibilidad');
			switch(tipoAuditoria){
				case 'obligatoria': 
					var data = Fn.formSerializeObject(Elementos.frmVisibilidadObligatoria);
					var contentDetalle = Elementos.contentDetalleObligatorio;
					break;
				case 'iniciativa': 
					var data = Fn.formSerializeObject(Elementos.frmVisibilidadIniciativa); 
					var contentDetalle = Elementos.contentDetalleIniciativa;
					break;
				case 'adicional': 
					var data = Fn.formSerializeObject(Elementos.frmVisibilidadAdicional);
					var contentDetalle = Elementos.contentDetalleAdicional;
					break;
				case 'default': 
					var data = {}; 
					break;
			}
			
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Elementos.url+control.data('url'), 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				if ( a['status'] == null) {
					return false;
				}

				//GRAFICAMOS LA TABLA DE DETALLE EN SU RESPECTIVO CONTENEDOR
				$('#'+contentDetalle).html(a.data.html);
				if (a.result==1) {
					$('#'+a.data.datatable).DataTable();
					switch(Elementos.tipoListaVisibilidad){
						case 'obligatoria':
							Elementos.botonesAccionObligatoria();
							break;
						case 'iniciativa': 
							Elementos.botonesAccionIniciativa();
							break;
						case 'adicional': 
							Elementos.botonesAccionAdicional();
							break;
					}
				}
				//LIMPIAMOS EL BOTON DE DESACTIVAR
				Elementos.limpiarBotonesAccion();
			})
		});

		$(document).on('click','.btnCambiarListaFechaFin', function(e){
			e.preventDefault();

			var control=$(this);
			var data={tipoListaVisibilidad:Elementos.tipoListaVisibilidad, lista: control.data('lista'), estado: control.data('estado')};

			++modalId;
			var fn1='Elementos.guardarCambiarEstadoLista('+JSON.stringify(data)+');Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				message+='<span>Se procedera a <strong>'+control.data('titleCambio')+'</strong> el registro.</span>';
				message+='<div class="divider"></div>'
				message+='<div class="row m-3">';
					message+='<div class="alert alert-success" role="alert"><i class="fas fa-calendar-day"></i> <strong>ACTIVAR:</strong> Se <strong>retirará</strong> el valor de la <strong>fecha fin</strong>, haciendo la lista activa.</div>';
					message+='<div class="alert alert-danger" role="alert"><i class="fas fa-calendar-day"></i> <strong>DESACTIVAR:</strong> Mediante esta opción se le asignará la <strong>fecha de fin</strong>, el valor del <strong>día de hoy</strong>.</div>';
				message+='</div>';
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		});

		$(document).on('click','input[name="cambiarEstadoLista"]', function(){
			var control=$(this);
			var tipoListaAuditoria = control.data('tipoVisibilidad');

			switch(tipoListaAuditoria){
				case 'obligatoria': Elementos.botonesAccionObligatoria(); break;
				case 'iniciativa': Elementos.botonesAccionIniciativa(); break;
				case 'adicional': Elementos.botonesAccionAdicional(); break;
			}
		});

		$(document).on('click','#chkb-estadoAllObligatorios', function(){
			var input=$(this);

			if (input.is(':checked')) {
				$('#'+Elementos.tbListaObligatoria).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstadoLista').prop('checked', true);
				});
			} else {
				$('#'+Elementos.tbListaObligatoria).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstadoLista').prop('checked', false);
				});
			}

			Elementos.botonesAccionObligatoria();
		});

		$(document).on('click','#chkb-estadoAllIniciativas', function(){
			var input=$(this);

			if (input.is(':checked')) {
				$('#'+Elementos.tbListaIniciativa).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstadoLista').prop('checked', true);
				});
			} else {
				$('#'+Elementos.tbListaIniciativa).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstadoLista').prop('checked', false);
				});
			}

			Elementos.botonesAccionIniciativa();
		});

		$(document).on('click','#chkb-estadoAllAdicionales', function(){
			var input=$(this);

			if (input.is(':checked')) {
				$('#'+Elementos.tbListaAdicional).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstadoLista').prop('checked', true);
				});
			} else {
				$('#'+Elementos.tbListaAdicional).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.cambiarEstadoLista').prop('checked', false);
				});
			}

			Elementos.botonesAccionAdicional();
		});

		$(document).on('click','#btn-deBajaAuditoriaObligatoria', function(){
			Elementos.confirmarGuardarCmabiarFecFinMasivo(Elementos.tbListaObligatoria);
		});

		$(document).on('click','#btn-deAltaAuditoriaObligatoria', function(){
			Elementos.confirmarGuardarDeAltaMasivo(Elementos.tbListaObligatoria);
		});

		$(document).on('click','#btn-deBajaAuditoriaIniciativa', function(){
			Elementos.confirmarGuardarCmabiarFecFinMasivo(Elementos.tbListaIniciativa);
		});

		$(document).on('click','#btn-deAltaAuditoriaIniciativa', function(){
			Elementos.confirmarGuardarDeAltaMasivo(Elementos.tbListaIniciativa);
		});

		$(document).on('click','#btn-deBajaAuditoriaAdicional', function(){
			Elementos.confirmarGuardarCmabiarFecFinMasivo(Elementos.tbListaAdicional);
		});

		$(document).on('click','#btn-deAltaAuditoriaAdicional', function(){
			Elementos.confirmarGuardarDeAltaMasivo(Elementos.tbListaAdicional);
		});
	},

	botonesAccion: function(){
		var cont=0;

		$('#tb-elementosDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="cambiarEstado"]').is(':checked') ) {
				var input = tr.find('input[name=cambiarEstado]');
				cont++;
			}
		});

		if (cont>0) {
			$('#btn-cambiarEstadoElementos').removeClass('btn-outline-primary');
			$('#btn-cambiarEstadoElementos').addClass('btn-success');
			$('#btn-cambiarEstadoElementos').find('span').remove();
			$('#btn-cambiarEstadoElementos').append('<span> ('+cont+')</span>');
		} else {
			Elementos.limpiarBotonesAccion();
		}
	},

	limpiarBotonesAccion: function(){
		$('#btn-cambiarEstadoElementos').removeClass('btn-success');
		$('#btn-cambiarEstadoElementos').find('span').remove();
		$('#btn-cambiarEstadoElementos').addClass('btn-outline-primary');
	},

	guardarCambiarEstado: function(dataElementos){
		var data = dataElementos;
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': Elementos.url + 'cambiarEstado', 'data': jsonString };
		
		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				var tdBtnEstado = $('#tdBtn-'+data.elementosVisibilidad);
				var tdBtnEstadoChildren = tdBtnEstado.children().remove();
				tdBtnEstado.html(a.data.htmlEstado);

				var tdBtnEditar = $('#tdEditar-'+data.elementosVisibilidad);
				var tdBtnEditarChildren = tdBtnEditar.children().remove();
				tdBtnEditar.html(a.data.htmlBtnEditar);

				var tdVistaEstado = $('#tdEstado-'+data.elementosVisibilidad);
				var tdVistaEstadoChildren = tdVistaEstado.children().remove();
				tdVistaEstado.html(a.data.htmlVistaEstado);
			}
		});
	},

	guardarCambiarEstadoMasivo: function(dataElementos){
		var data={'dataElementos':dataElementos};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Elementos.url+'cambiarEstadoMasivo', 'data':jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				Fn.showModal({ id:Elementos.idModal, show:false});
				//Limpiamos los botones Accion
				Elementos.limpiarBotonesAccion();
				//Hacemos un filtrado
				$('#btn-filtrarElementosVisibilidad').click();
			}
		});
	},

	confirmarActualizarElemento: function(){
		$.when( Fn.validateForm({'id':Elementos.frmNuevoEditar})).then( function(a){
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
				var fn1='Elementos.actualizarElemento();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		});
	},

	actualizarElemento: function(){
		var data= Fn.formSerializeObject(Elementos.frmNuevoEditar);
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':Elementos.url+'actualizarElemento', 'data': jsonString };

		$.when( Fn.ajax(config)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});

			if (a.result==1) {
				Fn.showModal({ id:Elementos.idModal, show:false});
				$('#btn-filtrarElementosVisibilidad').click();
			}
		});
	},

	confirmarGuardarNuevoElemento: function(){
		$.when( Fn.validateForm({'id':Elementos.frmNuevoEditar})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró <strong>datos obligatorios</strong> que no fueron ingresados, verificar los <strong>datos</strong> remarcados en <strong>rojo</strong>' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Elementos.guardarNuevoElemento();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				
			}
		});
	},

	guardarNuevoElemento: function(){
		var data = Fn.formSerializeObject(Elementos.frmNuevoEditar);
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':Elementos.url+'guardarNuevoElemento', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};

			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});

			if (a.result==1) {
				Fn.showModal({ id:Elementos.idModal, show:false});
				$('#btn-filtrarElementosVisibilidad').click();
			}
		});
	},

	ventanaCargaMasiva: function(){
		var sourceTipoElementos = Elementos.dataListaTipoElementosNombre;
		var sourceCategorias = Elementos.dataListaCategoriaNombre;

		var data = [];
		var container = document.getElementById('nuevoElementoMasivo');

		var settings={
			licenseKey: 'non-commercial-and-evaluation',
			data: null,
			dataSchema: {nombre:null, tipoElemento:null, categoria:null },
			colHeaders: ['NOMBRE ELEMENTO(*)', 'TIPO ELEMENTO(*)', 'CATEGORÍA'],
			startRows: 10,
			//startCols: 4,
			columns:[
				{data: 'nombre'},
				{data: 'tipoElemento'
					,type: 'dropdown'
					, source: sourceTipoElementos
				},
				{data: 'categoria'
					,type: 'dropdown'
					, source: sourceCategorias
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
			maxRows: 250, //cantidad máxima de filas
			manualColumnResize: true,
			afterChange: function(changes, source){
				var celda = this;
				if (changes!=null) {
					changes.forEach( function(item){
						if (item[1]=='nombre') {
							var tipo = Elementos.handsontable.getDataAtCell(item[0],1);

							if (tipo=="" || tipo==null || tipo==" ") {
								Elementos.handsontable.setDataAtCell(item[0],1,'*');
							}
						}

						if (item[1]=='tipoElemento') {
							var nombre = Elementos.handsontable.getDataAtCell(item[0],0);
							if (item[3]==null && nombre!=null) {
								Elementos.handsontable.setDataAtCell(item[0],1,'*');
							}
						}
					});
				}
			}
		};

		Elementos.handsontable = new Handsontable(container, settings);

		//Renderizar la ventana
		setTimeout(function(){
			Elementos.handsontable.render(); 
		}, 1000);
	},

	confirmarGuardarNuevoElementoMasivo: function(){
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoElementoMasivo .htInvalid').length;
		var arrayDataElementos = [];
		for (var ix = 0; ix < Elementos.handsontable.countRows(); ix++) {
			if (!Elementos.handsontable.isEmptyRow(ix)) {
				arrayDataElementos.push(Elementos.handsontable.getDataAtRow(ix));
			}
		}

		if ( arrayDataElementos.length==0) {
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
			var fn1='Elementos.guardarNuevoElementoMasivo();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},

	guardarNuevoElementoMasivo: function(){
		var arrayDataElementos = [];
		for (var ix = 0; ix < Elementos.handsontable.countRows(); ix++) {
			if (!Elementos.handsontable.isEmptyRow(ix)) {
				arrayDataElementos.push(Elementos.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataElementos;
		var data = {'dataArray': dataArrayCargaMasiva};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Elementos.url+'guardarNuevoElementoMasivo', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

			if (a.result==1) {
				Fn.showModal({ id:Elementos.idModal, show:false});
				$('#btn-filtrarElementosVisibilidad').click();
			}
		});
	},

	/*==Listas de Auditoria Visibilidad==*/
	guardarCambiarEstadoLista: function(dataListas){
		var data=dataListas;
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': Elementos.url + 'cambiarEstadoLista', 'data': jsonString };
		
		$.when(Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				var tablaLista='';
				switch(Elementos.tipoListaVisibilidad){
					case 'obligatoria': tablaLista=Elementos.tbListaObligatoria; break;
					case 'iniciativa': tablaLista=Elementos.tbListaIniciativa; break;
					case 'adicional': tablaLista=Elementos.tbListaAdicional; break;
				}

				//REEMPLAMOS LOS BOTONES Y LA VISTA ESTADO
				var tdCheckBox = $('#'+tablaLista+' #tdChkb-'+data.lista);
				var tdCheckBoxChildren = tdCheckBox.children().remove();
				tdCheckBox.html(a.data.htmlCheckBox);

				var tdEstado = $('#'+tablaLista+' #tdEstado-'+data.lista);
				var tdEstadoChildren = tdEstado.children().remove();
				tdEstado.html(a.data.htmlEstado);

				var tdEditar = $('#'+tablaLista+' #tdEditar-'+data.lista);
				var tdEditarChildren = tdEditar.children().remove();
				tdEditar.html(a.data.htmlEditar);

				var tdFecFin = $('#'+tablaLista+' #tdFecFin-'+data.lista);
				var tdFecFinChildren = tdFecFin.children().remove();
				tdFecFin.html(a.data.htmlFecFin);

				var tdVistaEstado = $('#'+tablaLista+' #tdVistaEstado-'+data.lista);
				var tdVistaEstadoChildren = tdVistaEstado.children().remove();
				tdVistaEstado.html(a.data.htmlVistaEstado);
			}
		});
	},

	botonesAccionObligatoria: function(){
		var contDesactivar=0;
		var contActivar=0;

		$('#'+Elementos.tbListaObligatoria).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="cambiarEstadoLista"]').is(':checked') ) {
				var input = tr.find('input[name=cambiarEstadoLista]');
				if (input.val()==0) {
					contDesactivar++;
				} else if (input.val()==1){
					contActivar++;
				}
			}
		});

		//LISTAS A DAR DE BAJA
		if (contDesactivar>0) {
			$('#btn-deBajaAuditoriaObligatoria').removeClass('btn-outline-primary');
			$('#btn-deBajaAuditoriaObligatoria').addClass('btn-success');
			$('#btn-deBajaAuditoriaObligatoria').find('span').remove();
			$('#btn-deBajaAuditoriaObligatoria').append('<span> ('+contDesactivar+')</span>');
		} else{
			$('#btn-deBajaAuditoriaObligatoria').removeClass('btn-success');
			$('#btn-deBajaAuditoriaObligatoria').find('span').remove();
			$('#btn-deBajaAuditoriaObligatoria').addClass('btn-outline-primary');
		}

		//LISTAS A DAR DE ALTA
		if (contActivar>0) {
			$('#btn-deAltaAuditoriaObligatoria').removeClass('btn-outline-primary');
			$('#btn-deAltaAuditoriaObligatoria').addClass('btn-success');
			$('#btn-deAltaAuditoriaObligatoria').find('span').remove();
			$('#btn-deAltaAuditoriaObligatoria').append('<span> ('+contActivar+')</span>');
		}
		else {
			$('#btn-deAltaAuditoriaObligatoria').removeClass('btn-success');
			$('#btn-deAltaAuditoriaObligatoria').find('span').remove();
			$('#btn-deAltaAuditoriaObligatoria').addClass('btn-outline-primary');
		}
	},

	botonesAccionIniciativa: function(){
		var contDesactivar=0;
		var contActivar=0;

		$('#'+Elementos.tbListaIniciativa).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="cambiarEstadoLista"]').is(':checked') ) {
				var input = tr.find('input[name=cambiarEstadoLista]');
				if (input.val()==0) {
					contDesactivar++;
				} else if (input.val()==1){
					contActivar++;
				}
			}
		});

		//LISTAS A DAR DE BAJA
		if (contDesactivar>0) {
			$('#btn-deBajaAuditoriaIniciativa').removeClass('btn-outline-primary');
			$('#btn-deBajaAuditoriaIniciativa').addClass('btn-success');
			$('#btn-deBajaAuditoriaIniciativa').find('span').remove();
			$('#btn-deBajaAuditoriaIniciativa').append('<span> ('+contDesactivar+')</span>');
		} else{
			$('#btn-deBajaAuditoriaIniciativa').removeClass('btn-success');
			$('#btn-deBajaAuditoriaIniciativa').find('span').remove();
			$('#btn-deBajaAuditoriaIniciativa').addClass('btn-outline-primary');
		}

		//LISTAS A DAR DE ALTA
		if (contActivar>0) {
			$('#btn-deAltaAuditoriaIniciativa').removeClass('btn-outline-primary');
			$('#btn-deAltaAuditoriaIniciativa').addClass('btn-success');
			$('#btn-deAltaAuditoriaIniciativa').find('span').remove();
			$('#btn-deAltaAuditoriaIniciativa').append('<span> ('+contActivar+')</span>');
		}
		else {
			$('#btn-deAltaAuditoriaIniciativa').removeClass('btn-success');
			$('#btn-deAltaAuditoriaIniciativa').find('span').remove();
			$('#btn-deAltaAuditoriaIniciativa').addClass('btn-outline-primary');
		}
	},

	botonesAccionAdicional: function(){
		var contDesactivar=0;
		var contActivar=0;

		$('#'+Elementos.tbListaAdicional).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="cambiarEstadoLista"]').is(':checked') ) {
				var input = tr.find('input[name=cambiarEstadoLista]');
				if (input.val()==0) {
					contDesactivar++;
				} else if (input.val()==1){
					contActivar++;
				}
			}
		});

		//LISTAS A DAR DE BAJA
		if (contDesactivar>0) {
			$('#btn-deBajaAuditoriaAdicional').removeClass('btn-outline-primary');
			$('#btn-deBajaAuditoriaAdicional').addClass('btn-success');
			$('#btn-deBajaAuditoriaAdicional').find('span').remove();
			$('#btn-deBajaAuditoriaAdicional').append('<span> ('+contDesactivar+')</span>');
		} else{
			$('#btn-deBajaAuditoriaAdicional').removeClass('btn-success');
			$('#btn-deBajaAuditoriaAdicional').find('span').remove();
			$('#btn-deBajaAuditoriaAdicional').addClass('btn-outline-primary');
		}

		//LISTAS A DAR DE ALTA
		if (contActivar>0) {
			$('#btn-deAltaAuditoriaAdicional').removeClass('btn-outline-primary');
			$('#btn-deAltaAuditoriaAdicional').addClass('btn-success');
			$('#btn-deAltaAuditoriaAdicional').find('span').remove();
			$('#btn-deAltaAuditoriaAdicional').append('<span> ('+contActivar+')</span>');
		}
		else {
			$('#btn-deAltaAuditoriaAdicional').removeClass('btn-success');
			$('#btn-deAltaAuditoriaAdicional').find('span').remove();
			$('#btn-deAltaAuditoriaAdicional').addClass('btn-outline-primary');
		}
	},

	confirmarGuardarCmabiarFecFinMasivo: function(tableAuditoria){
		var dataListas=[];
		var arrayLista=[];
		var cont=0;

		$('#'+tableAuditoria).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="cambiarEstadoLista"]').is(':checked') ) {
				var input = tr.find('input[name=cambiarEstadoLista]');
				var tabla = input.data('tipoVisibilidad');
				var lista = input.data('lista');
				var estado = input.val();

				if (estado==0) {
					//INSERTAMOS ARRAY
					arrayLista = {'tabla':tabla, 'lista':lista, 'estado':estado};
					dataListas.push(arrayLista);
					cont++;
				}
			}
		});

		if (dataListas.length==0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+', show:false});';
			var btn = new Array();
				btn[0]={title:'Cerrar', fn:fn};
			var message = Fn.message({ 'type': 2, 'message': '<strong>No</strong> se ha <strong>seleccionado</strong> ningún <strong>elemento</strong> a cambiar' });
			Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
		} else {
			++modalId;
			var fn1='Elementos.guardarCambiarFecFinMasivo('+JSON.stringify(dataListas)+');';
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
					message+='</div></form></div></div>';
				message+='</div>';
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			Elementos.idModal = modalId;
		}
	},

	confirmarGuardarDeAltaMasivo: function(tableAuditoria){
		var dataListas=[];
		var arrayLista=[];
		var cont=0;

		$('#'+tableAuditoria).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="cambiarEstadoLista"]').is(':checked') ) {
				var input = tr.find('input[name=cambiarEstadoLista]');
				var tabla = input.data('tipoVisibilidad');
				var lista = input.data('lista');
				var estado = input.val();

				if (estado==1) {
					//INSERTAMOS ARRAY
					arrayLista = {'tabla':tabla, 'lista':lista, 'estado':estado};
					dataListas.push(arrayLista);
					cont++;
				}
			}
		});

		if (dataListas.length==0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+', show:false});';
			var btn = new Array();
				btn[0]={title:'Cerrar', fn:fn};
			var message = Fn.message({ 'type': 2, 'message': '<strong>No</strong> se ha <strong>seleccionado</strong> ningún <strong>elemento</strong> a cambiar' });
			Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
		} else {
			++modalId;
			var fn1='Elementos.guardarCambiarFecFinMasivo('+JSON.stringify(dataListas)+');';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+cont+'</strong> registros?' });
				message+='<div class="themeWhite p-3 hide">';
					message+='<div class="card"><div class="card-body">';
					message+='<form id="frm-fechaFinDeBaja"><div>';
						message+='<h5 class="card-title">INGRESAR FECHA FIN</h5>';
						message+='<input class="form-control text-center ipWidth" type="date" placeholder="Fecha Fin" id="fecFinDeBaja" name="fecFinDeBaja">';
					message+='</div></form></div></div>';
				message+='</div>';
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			Elementos.idModal = modalId;
		}
	},

	guardarCambiarFecFinMasivo: function(dataListas){
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
				var data ={'fecFin':fecha, 'dataListas':dataListas};
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Elementos.url+'cambiarEstadoFecFinMasivo', 'data':jsonString };

				$.when(Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.msg.content;
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

					if (a.result==1) {
						Fn.showModal({ id:Elementos.idModal, show:false});
						switch(Elementos.tipoListaVisibilidad){
							case 'obligatoria':
								$('#opciones-2 .btn-filtrarAuditoriaVisibilidad').click();
								Elementos.botonesAccionObligatoria();
								break;
							case 'iniciativa': 
								$('#opciones-3 .btn-filtrarAuditoriaVisibilidad').click();
								Elementos.botonesAccionIniciativa();
								break;
							case 'adicional': 
								$('#opciones-4 .btn-filtrarAuditoriaVisibilidad').click();
								Elementos.botonesAccionAdicional();
								break;
						}
					}
				});
			}
		});
	}
}
Elementos.load();