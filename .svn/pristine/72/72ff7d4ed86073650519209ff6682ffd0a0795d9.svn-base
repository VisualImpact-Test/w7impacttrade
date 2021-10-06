var Modulacion = {

	frmModulacion: 'frm-modulacion',
	contentDetalleAntigua: 'idDetalleModulacionAntigua',
	contentDetalleActual: 'idDetalleModulacionActual',
	contDetActualCliente: 'idDetalleClienteActual',
	contDetAntiguoCliente: 'idDetalleClienteAntigua',
	tbPermisosActuales:'tb-permisosActuales',
	idTableDetalle : 'tb-modulacion',
	url : 'configuraciones/master/modulacion/',
	idModal: 0,

	frmEditarModCliente: 'frm-modulacionCliente',
	frmCargaMasiva: 'frm-registrarModulacionMasiva',
	dataListaClientes: [],
	dataListaClientesMinimos:[],
	dataListaElementos: [],
	dataElementosVisibilidadMasiva:[],
	handsontable : '',

	load: function(){


		$(".card-body > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion=$(this).data('value');
            if(indiceSeccion == 1){
                $('#btn-filtrarModulacion-antes').show();
				$('#btn-filtrarModulacion-actual').hide();
				$('#btn-generarListas').hide();
				$('#btn-cargaMasivaAlternativa').hide();

				$('#idDetalleModulacionAntigua').show();
				$('#idDetalleModulacionActual').hide();
				$('#tipoModulacion').val("antigua");
				$('#btn-filtrarModulacion-antes').click();
				$('#idDetalleClienteActual').hide();
				
            }else if(indiceSeccion == 2){
				$('#btn-filtrarModulacion-antes').hide();
				$('#btn-filtrarModulacion-actual').show();
				$('#btn-generarListas').show();
				$('#btn-cargaMasivaAlternativa').show();

				$('#idDetalleModulacionAntigua').hide();
				$('#idDetalleModulacionActual').show();
				$('#tipoModulacion').val("actual");
				$('#btn-filtrarModulacion-actual').click();
				$('#idDetalleClienteAntigua').hide();

				
            } 
        });




		/*==FILTRAR LA INFORMACIÓN==*/
		$(document).on('click','.btn-filtrarModulacion', function(e){
			e.preventDefault();

			var control=$(this);
			var tipoModulacion=control.data('modulacion');
			console.log(tipoModulacion);
			switch(tipoModulacion){
				case 'antigua':
					var data = Fn.formSerializeObject(Modulacion.frmModulacion);
					var contentDetalle = Modulacion.contentDetalleAntigua;
					break;
				case 'actual':
					var data = Fn.formSerializeObject(Modulacion.frmModulacion);
					var contentDetalle = Modulacion.contentDetalleActual;
					break;
				case 'default': 
					var data = {}; 
					break;
			}

			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Modulacion.url+control.data('url'), 'data':jsonString};

			$.when(Fn.ajax(configAjax)).then( function(a){
				if ( a['status'] == null) {
					return false;
				}

				//GRAFICAMOS LA TABLA DE DETALLE EN SU RESPECTIVO CONTENEDOR
				$('#'+contentDetalle).html(a.data.html);
				if (a.result==1) {
					if ( typeof a.data.datatable !== 'undefined') {
						$('#'+a.data.datatable).DataTable();
						Modulacion.botonesAccion();
					}
				}
			});
		});

		$(document).on('click','.verModulacion', function(e){
			e.preventDefault();

			var control=$(this);
			var data={'usuario':control.data('usuario'),'permiso':control.data('permiso'), 'lista':control.data('lista')};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Modulacion.url+'verPermisoModulacion', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				if ( a['status']==null) {
					return false;
				}

				//GRAFICAMOS LA TABLA DE DETALLE DE PERMISOS MODULACIÓN CLIENTE
				$('#'+Modulacion.contDetActualCliente).show();
				$('#'+Modulacion.contDetActualCliente).html(a.data.html);
				if (a.result==1) {
					$('#'+a.data.datatable).DataTable();
				}
			});
		});

		$(document).on('click', '.verModulacionAntigua', function(e){
			e.preventDefault();

			var control=$(this);
			var data={'usuario':control.data('usuario'),'permiso':control.data('permiso'), 'lista':control.data('lista')};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': Modulacion.url+'verPermisoModulacion', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				if ( a['status']==null) {
					return false;
				}

				//GRAFICAMOS LA TABLA DE DETALLE DE PERMISOS MODULACIÓN CLIENTE
				$('#idDetalleClienteAntigua').show();
				$('#'+Modulacion.contDetAntiguoCliente).html(a.data.html);
				if (a.result==1) {
					$('#'+a.data.datatable).DataTable();
				}
			});
		});

		//$(document).on('click','#btn-registrarModulacion', function(e){
		$(document).on('click','.cargarModulacion', function(e){
			e.preventDefault();
			
			var control = $(this);
			var ruta = control.data('url');
			//
			var data = {'usuario':control.data('usuario'),'permiso': control.data('permiso')};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Modulacion.url + ruta, 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var fn1='Modulacion.confirmarRegistrarModulacion();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					btn[1]={title:'Registrar',fn:fn1};
				
				var html='';
					html+=a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
				Modulacion.idModal = modalId;

				//GENERAMOS LA VENTANA
				Modulacion.ventanaCargaMasiva();
			});
		});


		$(document).on('click','.cargarMasiva', function(e){
			e.preventDefault();
			
			var control = $(this);
			var ruta = control.data('url');
			//
			var data = {'usuario':control.data('usuario'),'permiso': control.data('permiso')};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Modulacion.url + ruta, 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var fn1='Modulacion.confirmarRegistrarModulacion();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				
				var html='';
					html+=a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
				Modulacion.idModal = modalId;

			});
		});

		$(document).on('click','.generarLista', function(e){
			e.preventDefault();

			var control= $(this);
			var permiso = control.data('permiso');
			var data={permiso: permiso};
			var jsonString = {data: JSON.stringify(data)};
			var configAjax = {url: Modulacion.url + 'clientesModulacion', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Modulacion.generarListasElementos('+permiso+');Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
					message += a.data.html;

				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});
			});
		});
			
		$(document).on('click','.editarPermisoClienteMod', function(e){
			e.preventDefault();

			var control=$(this);
			var data={'permiso':control.data('permiso'), 'cliente':control.data('cliente')};
			var jsonString = { 'data': JSON.stringify(data)};
			var configAjax = { 'url':Modulacion.url + 'editarPermisoClienteMod', 'data':jsonString};

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var fn1='Modulacion.confirmarActualizarModulacion();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					btn[1]={title:'Actualizar',fn:fn1};
				
				var html='';
					html+=a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
				Modulacion.idModal = modalId;
			});
		});

		$(document).on('keyup','.ipCantidadElemento', function(){
			var control=$(this);
			if (control.val()>0) {
				control.addClass('ip-data');
			} else {
				control.removeClass('ip-data');
			}
		});

		$(document).on('click','#btn-registrar-listas', function(e){
			e.preventDefault();
			var jsonString={  };
			var config={'url':Modulacion.url+'/generar_listas','data':jsonString}; 
			$.when( Fn.ajax(config) ).then(function(a){
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
					
			});			
		});
		
		$(document).on('keyup','.cantidad', function(){
			var num = parseInt($(this).val());
			var idCliente = parseInt($(this).attr('idCliente'));
			var idElemento = parseInt($(this).attr('idElemento'));
			if(num>0){
				$('input:checkbox[name=modulacion_'+idCliente+'_'+idElemento+']').prop("checked", true);  
			}else{
				$('input:checkbox[name=modulacion_'+idCliente+'_'+idElemento+']').prop("checked", false);  
			}
		});
		
		$(document).on('click','#btn-registrar-modulacion',function(e){
			e.preventDefault();

			var rows = $('#tb-modulacion').DataTable().rows({ 'search': 'applied' }).nodes();
			var datos = {};

			$.each(rows, function(ir,vr){
			   var input = $(vr).find('input');

				if( typeof(datos[ir]) == 'undefined' ){
				   datos[ir] = { 'idCliente': 0, 'modulacion': [], 'cantidad':[] };
				}

				$.each(input, function(ii, vi){
					if( $(vi).attr('type') == 'checkbox' ){
						if( $(vi).is(':checked') ){
							datos[ir]['modulacion'].push($(vi).val());
						}
					}
					else if( $(vi).attr('type') == 'hidden' && $(vi).attr('tipo') == 'cliente'  ){
						datos[ir]['idCliente'] = $(vi).val();
					}else if( $(vi).attr('type') == 'number' && $(vi).attr('tipo') == 'cantidad'  ){
						var num = parseInt($(vi).val());
						if(num>0){
							datos[ir]['cantidad'].push($(vi).val());
						}
					}
				});

			});
			
			datos['fechas']=$('#fechas').val();

			var jsonString={ 'data':JSON.stringify( datos ) };
			var config={'url':Modulacion.url+'/registrar_modulacion','data':jsonString}; 
			$.when( Fn.ajax(config) ).then(function(a){
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';//$("#btn-elementos").click();';
					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
					
			});			
		});

		$(document).on('click','#chkb-checkAllPermisos', function(e){
			var input=$(this);

			if (input.is(':checked')) {
				$('#'+Modulacion.tbPermisosActuales).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.generarListaPermiso').prop('checked', true);
				});
			} else {
				$('#'+Modulacion.tbPermisosActuales).DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.generarListaPermiso').prop('checked', false);
				});
			}

			Modulacion.botonesAccion();
		});

		$(document).on('click','input[name="generarListaPermiso"]', function(){
			var control=$(this);
			Modulacion.botonesAccion();
		});

		$(document).on('click','#btn-generarListas', function(e){
			e.preventDefault();

			var arrayPermisos=[];
			var cont=0;

			$('#'+Modulacion.tbPermisosActuales).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);

				if ( tr.find('input[name="generarListaPermiso"]').is(':checked') ) {
					var input = tr.find('input[name=generarListaPermiso]');

					//INSERTAMOS EL PERMISO DENTRO DEL ARRAY
					arrayPermisos.push(input.val());
					cont++;
				}
			});

			if (arrayPermisos.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': '<strong>No</strong> se ha <strong>seleccionado</strong> ningún <strong>permiso</strong> a cambiar' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Modulacion.generarAllListas('+JSON.stringify(arrayPermisos)+'); Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};

				var message = '';
					msgText = '¿Desea generar las listas del registro seleccionado?';
					if( cont > 1 ) msgText = '¿Desea generar las listas de los <strong>' + cont + '</strong> registros seleccionados?';

					message += '<div class="row">';
						message += '<div class="col-md-12">';
							message += Fn.message({ 'type': 3, 'message': msgText });
						message += '</div>';
						message += '<div class="col-md-12">';
							message += '<div class="form-check mb-3 ml-3 pl-5">';
								message += '<input type="checkbox" id="chk-visib-auditoria" class="form-check-input cursor-pointer" name="chk-visib-auditoria" value="1" style="width: 17px; height: 17px;" checked>';
								message += '<label class="form-check-label cursor-pointer font-weight-bold pt-1" for="chk-visib-auditoria">';
									message += 'Registrar Visibilidad para Auditoria';
								message += '</label>';
							message += '</div>';
						message += '</div>';
					message += '</div>';

				
				Fn.showModal({ id: modalId, title: 'Alerta', frm: message, btn: btn, show: true });
			}
		});

		$(document).on('click','#btn-saveModulacion', function(e){
			e.preventDefault();

			++modalId;
			var fn1='Modulacion.guardarAsistencia();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Guardar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			Fn.showModal({ id:modalId,show:true,title:'Guardar',content:'¿Desea guardar los datos modificados?',btn:btn, width:"70%" });
		});
		
		$(document).on('click','#btn-descargarModulacionFormato', function(e){
			e.preventDefault();
			if(Modulacion.handsontable!=null){
				const exportPlugin = Modulacion.handsontable.getPlugin('exportFile');
				exportPlugin.downloadFile('csv', {
						filename: 'FormatoModulacion',
						exportHiddenRows: true,     
						exportHiddenColumns: true,  
						columnHeaders: true,        
						rowHeaders: true,           
						columnDelimiter: ';'
				});
			}
		});

		$(document).on('click','.saveUsuarioAsistencia', function(e){
			e.preventDefault();

			var dataAsistencias = [];
			var arrayAsistencia = [];
			var cont=0;

			var control = $(this);
			var usuario = control.data('usuario');
			var nombreUsuario = control.data('nombreusuario');
			var fecha = control.data('fecha');
			var tipoUsuario = control.data('tipousuario');
			var perfil = control.data('perfil');
			var numDocumento = control.data('numdocumento');

			$('.ipUsuarioHora-'+usuario).each( function(ix,val){
				var input = $(this);
				var hora = input.val();
				var tipoAsistencia = input.data('tipoasistencia');
				var ocurrencia = $("select[name=sl-ocurrencias-"+usuario+"-"+tipoAsistencia+"]").val();
				var ocurrenciaText  = $("select[name=sl-ocurrencias-"+usuario+"-"+tipoAsistencia+"] option:selected").text();
				if ( typeof ocurrencia === 'undefined' ) { ocurrencia=""; }

				if ( hora!==''&& ocurrencia!=='' ) {
					//INSERTAMOS ELEMENTO
					arrayAsistencia = {
						'hora': hora
						,'tipoAsistencia': tipoAsistencia
						,'ocurrencia': ocurrencia
						,'ocurrenciaText': ocurrenciaText
						,'fecha': fecha
						,'nombreUsuario': nombreUsuario
						,'tipoUsuario': tipoUsuario
						,'perfil': perfil
						,'numDocumento': numDocumento
					};
					dataAsistencias.push(arrayAsistencia);
					cont++;
				}
			});

			if ( dataAsistencias.length==0 ) {
				++modalId;
				var fn3='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn3};
				var message = Fn.message({ 'type': 2, 'message': 'Tiene que completar los datos de hora y ocurrencia para poder guardar' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				var data = { usuario:usuario, 'dataAsistencias':dataAsistencias }
				var jsonString = { 'data': JSON.stringify(data) };
				var configAjax = { 'url': Modulacion.url + 'guardarUsuarioAsistencia', 'data': jsonString };

				$.when( Fn.ajax(configAjax) ).then(function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });

					if (a.result==1) {
						$.each(a.data, function(ixTipoAsist,val){
							$("#tdHora-"+usuario+"-"+ixTipoAsist).html(val.hora);
							$("#tdSlocurrencias-"+usuario+"-"+ixTipoAsist).html(val.textOcurrencia);
							$("#tdMedio-"+usuario+"-"+ixTipoAsist).html(val.tipo);
						})
					}
				});
			}
		});	
		
		$(document).on('click','#btn-cargaMasivaAlternativa', function(e){
			e.preventDefault();

			var control= $(this);
			var data={};
			var jsonString = {data: JSON.stringify(data)};
			var configAjax = {url: Modulacion.url + 'cargaMasivaAlternativa', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn1};
				var message = a.data.html;
				Fn.showModal({ id:modalId,title:a.msg.title,frm:message,btn:btn,show:true, width:a.data.htmlWidth});
			});
		});

		$(document).ready(function () {
			$('#btn-filtrarModulacion-antes').click();
		});
	},

	botonesAccion: function(){
		var cont=0;

		$('#'+Modulacion.tbPermisosActuales).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			if ( tr.find('input[name="generarListaPermiso"]').is(':checked') ) {
				var input = tr.find('input[name=generarListaPermiso]');
				cont++;
			}
		});

		if (cont>0) {
			$('#btn-generarListas').removeClass('btn-outline-trade-visual');
			$('#btn-generarListas').addClass('btn-outline-success');
			$('#btn-generarListas').find('span').remove();
			$('#btn-generarListas').append('<span> ('+cont+')</span>');
		} else {
			$('#btn-generarListas').removeClass('btn-outline-success');
			$('#btn-generarListas').find('span').remove();
			$('#btn-generarListas').addClass('btn-outline-primary');
		}
	},

	ventanaCargaMasiva: function(){
		//LIMPIAMOS EL ARRAY DE ELEMENTOS DE VISIBILIDAD
		Modulacion.dataElementosVisibilidadMasiva=[];

		//SOURCES QUE VAMOS A UTILIZAR
		var sourceClientes = Modulacion.dataListaClientes;
		var sourceElementos = Modulacion.dataListaElementos;

		//CREAMOS LOS SCHEMAS,HEADERS Y COLUMNAS 
		var arraySchema=[]; 
			arraySchema={IDCLIENTE:null};
		var arrayColumna=[]; 
			arrayColumna= {data:'IDCLIENTE', type:'autocomplete', source: sourceClientes, strict:true, validator :function(value, callback) {
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
								
			},};
		var stringHeader=''; 
			stringHeader='IDCLIENTE';
		
		//SOURCES DATAS
		var sourceSchemas = []; 
			sourceSchemas.push(arraySchema);
		var sourceColumnas = []; 
			sourceColumnas.push(arrayColumna);
		var sourceHeaders=[]; 
			sourceHeaders.push(stringHeader);
		//
		Modulacion.dataElementosVisibilidadMasiva.push(0);

		//POR CADA ELEMENTO
		$.each(sourceElementos, function(ix,vx){
			//DATA SCHEMAS
			arraySchema={ix:null}; 
			sourceSchemas.push(arraySchema);
			//DATA HEADERS
			stringHeader=vx.elemento; 
			sourceHeaders.push(stringHeader);
			//DATA IDELEMENTOVISIBILIDAD
			Modulacion.dataElementosVisibilidadMasiva.push(vx.idElementoVis);
			
			//DATA COLUMNAS
			arrayColumna={data:vx.elemento, type:'numeric'}; 
			sourceColumnas.push(arrayColumna);
		});

		//COLUMNAS ADICIONALES DE VALIDACIONES DE MÍNIMO Y MÁXIMO
		// arraySchema={minCategoria:null}; sourceSchemas.push(arraySchema);
		// arraySchema={minElemento:null}; sourceSchemas.push(arraySchema);

		// arrayColumna={data:'minCategoria', type:'numeric',readOnly: true};	sourceColumnas.push(arrayColumna);
		// arrayColumna={data:'minElemento', type:'numeric',readOnly: true};	sourceColumnas.push(arrayColumna);

		//stringHeader='MIN CATEGORÍA';sourceHeaders.push(stringHeader);
		//stringHeader='MIN ELEMENTO';sourceHeaders.push(stringHeader);
		//

		var data=[];
		var container = document.getElementById('registrarModulacionMasivo');

		var settings={
			licenseKey: 'non-commercial-and-evaluation',
			data: null,
			dataSchema: sourceSchemas,
			colHeaders: sourceHeaders, //Titulos visibles, en las cabeceras
			startRows: 10,
			//startCols: 4,
			columns: sourceColumnas,
			minSpareCols: 1, //always keep at least 1 spare row at the right
			minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
			rowHeaders: true, //n° contador de las filas
			//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
			contextMenu: true,
			dropdownMenu: true, //desplegable en la columna, ofrece oopciones
			height: 300,
			width: '100%',
			//colWidths: [47, 47, 47, 47, 47, 47, 47, 47, 47, 47, 47],
			stretchH: 'all', //Expande todas las columnas al 100%
			maxRows: 1000, //cantidad máxima de filas
			manualColumnResize: true,
			allowHtml: true,
			className: "htCenter",
			placeholder: '0',
			cell: function(row,col, prop){
				//
			},
			afterChange: function(changes, source){
				var celda = $(this);
			}
		};

		Modulacion.handsontable = new Handsontable(container, settings);

		//RENDERIZAR LA VENTANA
		setTimeout(function(){
			Modulacion.handsontable.render(); 
		}, 1000);
	},

	confirmarRegistrarModulacion: function(){
		var validacionMinMaximo = 0;
		var contColsInvalid = 0;
			contColsInvalid = $('#registrarModulacionMasivo .htInvalid').length;
		var arrayDataElementos = [];
		for (var ix = 0; ix < Modulacion.handsontable.countRows(); ix++) {
			if (!Modulacion.handsontable.isEmptyRow(ix)) {
				var arrayCategoria=[];
				var cantidadElementos=0;
				//INSERTAMOS EN EL ARRAY GENERAL DE LA DATA, ESTE ARRAY ENVIARA LA DATA AL SERVIDOR
				arrayDataElementos.push(Modulacion.handsontable.getDataAtRow(ix));
				//VALIDACIONES DE MINIMO DE CATEGORIAS Y ELEMENTOS
				
				// for (var ixc=1; ixc < Modulacion.handsontable.getDataAtRow(ix).length - 2; ixc++) {
				// 	//VALIDACIÓN DE ELEMENTOS
				// 	if (Modulacion.handsontable.getDataAtRow(ix)[ixc] != null && Modulacion.handsontable.getDataAtRow(ix)[ixc]>0) {
				// 		//VALIDACIÓN DE LOS ELEMENTOS
				// 		cantidadElementos++;
				// 		//VALIDACIÓN DE CATEGORÍAS
				// 		var elementoProvisional = Modulacion.dataElementosVisibilidadMasiva[ixc];
				// 		if (!arrayCategoria.includes(Modulacion.dataListaElementos[elementoProvisional]['idCategoria'] )) {
				// 			arrayCategoria.push(Modulacion.dataListaElementos[elementoProvisional]['idCategoria']);
				// 		}
				// 	}
				// }
				//
				// var minimoCategoriaColumna = Modulacion.handsontable.getDataAtRow(ix).length-2;
				// if ( arrayCategoria.length < Modulacion.handsontable.getDataAtRow(ix)[minimoCategoriaColumna] ) {
				// 	Modulacion.handsontable.setCellMeta(ix,minimoCategoriaColumna,'className','td-false');
				// 	validacionMinMaximo++;
				// } else {
				// 	Modulacion.handsontable.setCellMeta(ix,minimoCategoriaColumna,'className','td-true');
				// }
				// //
				// var minimoElementoColumna = Modulacion.handsontable.getDataAtRow(ix).length-1;
				// if (cantidadElementos < Modulacion.handsontable.getDataAtRow(ix)[minimoElementoColumna]) {
				// 	Modulacion.handsontable.setCellMeta(ix,minimoElementoColumna,'className','td-false');
				// 	validacionMinMaximo++;
				// } else {
				// 	Modulacion.handsontable.setCellMeta(ix,minimoElementoColumna,'className','td-true');
				// }
				//RENDERIZAMOS LA VISTA
				Modulacion.handsontable.render(); 
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
		} else if ( validacionMinMaximo>0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Se ha detectado <strong>incongruencias</strong> al momento de registrar los <strong>valores mínimos</strong> de las <strong>categorías y elementos</strong>, verificar dicha información' });
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
			var fn1='Modulacion.registrarElementosMasivo();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},

	registrarElementosMasivo: function(){
		var arrayDataElementos = [];
		for (var ix = 0; ix < Modulacion.handsontable.countRows(); ix++) {
			if (!Modulacion.handsontable.isEmptyRow(ix)) {
				arrayDataElementos.push(Modulacion.handsontable.getDataAtRow(ix));
			}
		}

		var permiso = $('#masivoPermiso').val();
		var dataArrayCargaMasiva = arrayDataElementos;
		var dataFormElementos = Modulacion.dataElementosVisibilidadMasiva;
		var data = {'permiso':permiso, 'dataElementos':dataFormElementos, 'dataArray': dataArrayCargaMasiva};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Modulacion.url+'registrarElementosMasivo', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then( function(a){
			++modalId;
			if (a.result==1) {
				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+Modulacion.idModal+', show:false});';
			} else {
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
			}
			
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

			//if (a.result==1) {
				//Fn.showModal({ id:Modulacion.idModal, show:false});
				//$('#btn-filtrarModulacion').click();
			//}
		});
	},

	generarListasElementos: function(permiso){
		var auditoria = $('#chk-visib-auditoria:checked').length ? 1 : 0;
		var data={'permiso': permiso, 'auditoria': auditoria};
		var jsonString = {'data':JSON.stringify(data)};
		var configAjax = {'url': Modulacion.url+'generarListasElementos', 'data':jsonString};

		$.when( Fn.ajax(configAjax) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			
			var html='';
				html+=a.data.html;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
		});
	},

	confirmarActualizarModulacion: function(){
		++modalId;
		var fn1='Modulacion.actualizarModulacion();Fn.showModal({ id:'+modalId+',show:false });';
		var fn2='Fn.showModal({ id:'+modalId+',show:false });';
		var btn=new Array();
			btn[0]={title:'Continuar',fn:fn1};
			btn[1]={title:'Cerrar',fn:fn2};
		var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
		Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
	},

	actualizarModulacion: function(){
		var data = Fn.formSerializeObject(Modulacion.frmEditarModCliente)
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Modulacion.url+'actualizarModulacion', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};

			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

			if (a.result==1) {
				Fn.showModal({ id:Modulacion.idModal, show:false});
				//$('#btn-filtrarModulacion').click();
			}
		});
	},

	registrar: function(){
		var data=Fn.formSerializeObject('registrar_permiso');
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': Modulacion.url + 'registrar_permiso', 'data': jsonString };

		$.when( Fn.ajax(configAjax) ).then( function(a){
			++modalId;
			var title='Confirmacion';
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var html = '';
				html += a.data;
			Fn.showModal({ id:modalId,show:true,title:title,content:html,btn:btn, width:"40%"});
		});
	},

	generarAllListas: function(arrayPermisos){
		var data ={'permiso':arrayPermisos};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Modulacion.url+'generarListasElementos', 'data':jsonString };

		$.when(Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn,width:a.data.htmlWidth});

			if (a.result==1) {
				$('#opciones-2 .btn-filtrarModulacion').click();
			}
		});
	},

	cargaMasivaModulacion: function() {
		var file_data = $('#archivo').prop('files')[0];
		var file_name = file_data.name;
        var formato = file_name.split(".");		
        var idPermiso = $('#masivoPermiso').val();		
        var fecIni = $('#fecIniLista').val();		
        var fecFin = $('#fecFinLista').val();		
	
		var form_data = new FormData();             
		form_data.append('file', file_data); 
		form_data.append('idPermiso', idPermiso); 
		form_data.append('fecIni', fecIni); 
		form_data.append('fecFin', fecFin); 

		if((formato[1]=='csv')||(formato[1]=='CSV')){	
			$.ajax({
				url: site_url+'index.php/configuraciones/master/modulacion/cargaMasivaModulacion',
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
					setTimeout(Modulacion.ejecutarBat, 0 )
				},
			});
		} else {

		} 
	},
	ejecutarBat: function(){
		$.ajax({
			type: "POST",
			url: site_url+'bat.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},


	cargaMasivaAlternativa: function() {
		var file_data = $('#archivo').prop('files')[0];
		
		var validar=true;
		var data = Fn.formSerializeObject("frm-registrarModulacionMasiva");
		var cantUsuario=data['cantUsuarios'];

		var fechaLista=data['fechaLista'];
		var auditoria = data['chk-visib-auditoria'] ? data['chk-visib-auditoria'] : 0;
		
		if(file_data==undefined){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Modulacion",content:"Se requiere la carga del archivo.",btn:btn});
			validar=false;
		}

		if(cantUsuario<=0){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Modulacion",content:"Se requiere seleccionar usuarios a asignar.",btn:btn});
			validar=false;
		}

		if(validar){
			var file_name = file_data.name;
			var formato = file_name.split(".");		
			
			var form_data = new FormData();      
			form_data.append('file', file_data);        
			form_data.append('fechaLista', fechaLista); 
			form_data.append('auditoria', auditoria);

			if((formato[1]=='csv')||(formato[1]=='CSV')){	
				$.ajax({
					url: site_url+'index.php/configuraciones/master/modulacion/carga_masiva_alternativa',
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
						setTimeout(Modulacion.ejecutarPermisosBat, 0 );
						Modulacion.limpiarCargaMasivaAlternativa();
					},
				});
			} else {

				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Modulacion",content:"Solo se permite archivos con formato .csv",btn:btn});
				validar=false;

			} 

		}
	
		
	},
	ejecutarPermisosBat: function(){
		$.ajax({
			type: "POST",
			url: site_url+'public/bat/bat_permisos.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},
	limpiarCargaMasivaAlternativa: function(){
		$("#archivo").val("");
		$('#chk-visib-auditoria').prop('checked', true);
	},

	validarCargaModulacion: function(){
		var file_data = $('#archivo').prop('files')[0];
		var file_name = file_data.name;
        var formato = file_name.split(".");		
        var idPermiso = $('#masivoPermiso').val();		
        var fecIni = $('#fecIniLista').val();		
        var fecFin = $('#fecFinLista').val();		
	
		var form_data = new FormData();             
		form_data.append('file', file_data); 
		form_data.append('idPermiso', idPermiso); 
		form_data.append('fecIni', fecIni); 
		form_data.append('fecFin', fecFin); 
		
		$.ajax({
			url: site_url+'index.php/configuraciones/master/modulacion/validar_carga',
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
				
				var total = a.data;
				console.log(total);
				if(total==0){
					Modulacion.cargaMasivaModulacion();
				}else{
					Fn.showLoading(false);
					++modalId;
					var fn1='Modulacion.cargaMasivaModulacion();Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					var message = Fn.message({ 'type': 3, 'message': 'Ya se realizo una carga si continua se reemplazara la informacion anterior por la actual.' });
					Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true}); 
				}
				/* $("#cargas_detalles").empty();
				$("#cargas_detalles").html(a.data);
				$('#btn-sellin-filter').click();
				Fn.showLoading(false);
				Modulacion.cargaMasivaModulacion(); */
			},
		});
		
		/* */
	},


}

Modulacion.load();