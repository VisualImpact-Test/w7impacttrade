var Modulacion = {

	frmModulacion: 'frm-modulacion',
	contentDetalle: 'idDetalleModulacion',
	idTableDetalle : 'tb-modulacion',
	url : 'configuraciones/master/rutasAuditoria/',
	handsontable : '',
	
	load: function(){

		$(document).on('click','#btn-nuevoModulacion', function(e){
			e.preventDefault();
			
			var control = $(this);
			var ruta = control.data('url');
			//
			var data = {};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Modulacion.url + ruta, 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var fn1='Modulacion.registrar();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					btn[1]={title:'Registrar',fn:fn1};
				var html = '';
					html += a.data;
				Fn.showModal({ id:modalId,show:true,title:'Nuevo',content:html,btn:btn, width:"40%"});
			});
		});
		
		$(document).on("click",".btn-nueva-ruta",function(e){
			e.preventDefault();
			var divHtml = '';
			var data={};
			//var data={'id':$(this).attr('data-id'),'fecIni':$(this).attr('data-fecIni'),'fecFin':$(this).attr('data-fecFin')};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'form_nueva_ruta','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				//a.data
				if( a.result==0 ){
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
	
					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				} else if( a.result==1 ){
					++modalId;
					var fn='Modulacion.registrar_ruta();';
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Registrar',fn:fn};
						btn[1]={title:'Cancelar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:"NUEVA RUTA",frm:a.data,btn:btn,width:'900px'});  
				}
				
			});
		});
		
		$(document).on("click",".btn-add-clientes",function(e){
			e.preventDefault();
			var divHtml = '';
			var data={};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'form_add_clientes','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				if( a.result==0 ){
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
	
					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				} else if( a.result==1 ){
					++modalId;
					var fn='Modulacion.agregar_clientes();';
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Registrar',fn:fn};
						btn[1]={title:'Cancelar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:"AGREGAR CLIENTES",frm:a.data,btn:btn,width:'900px'});  
				}
				
			});
		});
		
		$(document).on("click",".btn-editar-rutas",function(e){
			e.preventDefault();
			var divHtml = '';
			var data={'id':$(this).attr('data-id'),'fecIni':$(this).attr('data-fecIni'),'fecFin':$(this).attr('data-fecFin')};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'form_editar_rutas','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				//a.data
				if( a.result==0 ){
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
	
					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn });
				} else if( a.result==1 ){
					++modalId;
					var fn='Modulacion.actualizar_ruta();';
					var fn1='Fn.showModal({ id:'+modalId+',show:false });$(".modal-stack").removeClass("modal-backdrop")';
					var btn=new Array();
						btn[0]={title:'Actualizar',fn:fn};
						btn[1]={title:'Cancelar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:"EDITAR RUTAS",frm:a.data,btn:btn,width:'90%'});  
					
					////
				}
				
			});
		});
		
		$(document).on("click",".btn-rutas-eliminar",function(e){
			e.preventDefault();
			var divHtml = '';
			var data={'id':$(this).attr('data-id'),'fecIni':$(this).attr('data-fecIni'),'fecFin':$(this).attr('data-fecFin')};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'form_eliminar_rutas','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				//a.data
				if( a.result==0 ){
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
	
					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn });
				} else if( a.result==1 ){
					++modalId;
					var fn='Modulacion.eliminar_ruta();';
					var fn1='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Eliminar',fn:fn};
						btn[1]={title:'Cancelar',fn:fn1};
					Fn.showModal({ id:modalId,show:true,title:"EDITAR RUTAS",frm:a.data,btn:btn,width:'900px'});  
				}
				
			});
		});
		
		$(document).on("click","#add_clientes",function(e){
			e.preventDefault();
			var divHtml = '';
			var idCliente=$('#idCliente').val();
			var lunes=$('#lunes:checked').val();
			var martes=$('#martes:checked').val();
			var miercoles=$('#miercoles:checked').val();
			var jueves=$('#jueves:checked').val();
			var viernes=$('#viernes:checked').val();
			var sabado=$('#sabado:checked').val();
			var domingo=$('#domingo:checked').val();
			var data={'idCliente':idCliente,'lunes':lunes,'martes':martes,'miercoles':miercoles,'jueves':jueves,'viernes':viernes,'sabado':sabado,'domingo':domingo};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'agregar_clientes','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				if(a.result==1){
					$('.table tr:last').after(a.html);
				}else if(a.result==2){
					++modalId;
					//
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				}
			});
		});
		
		$(document).on("click","#busca_clientes",function(e){
			e.preventDefault();
			var divHtml = '';
			var idCliente=$('#idCliente').val();
			var idRutaProg=$('#idRutaProg').val();

			var data={'idCliente':idCliente,'idRutaProg':idRutaProg};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'filtrar_clientes','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				if(a.result==1){
					$('.rutas tbody').html('');
					$('.rutas tbody').html(a.data);
				}else if(a.result==2){
					++modalId;
					//
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				}
			});
		});
		
		$(document).on("click","#busca_clientes_eliminar",function(e){
			e.preventDefault();
			var divHtml = '';
			var idCliente=$('#idCliente').val();
			var idRutaProg=$('#idRutaProg').val();

			var data={'idCliente':idCliente,'idRutaProg':idRutaProg};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'filtrar_clientes_eliminar','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				if(a.result==1){
					$('.rutas tbody').html('');
					$('.rutas tbody').html(a.data);
				}else if(a.result==2){
					++modalId;
					//
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				}
			});
		});
		
		
		$(document).on("click",".btn-rutas-editar-usuarios-tradicional",function(e){
			e.preventDefault();
			var divHtml = '';
			var data={'id':$(this).attr('data-id'),'idCanalGrupo':$(this).attr('data-idCanalGrupo')};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'form_editar_usuarios_rutas_tradicional','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				//a.data
				if( a.result==0 ){
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
	
					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });
				} else if( a.result==1 ){
					++modalId;

					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();

						btn[0]={title:'Cancelar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:"EDITAR USUARIOS RUTAS",frm:a.data,btn:btn,width:'600px'});  
				}
				
			});
		});
		
		$(document).on("click","#agregar_usuario_ruta",function(e){
			e.preventDefault();
			var data=Fn.formSerializeObject( 'nuevo_usuario' );
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'agregar_usuario_ruta','data':jsonString};
			$.when( Fn.ajax(config) ).then(function(a){
				if( a.result==1 ){
					$('#content-usuarios').html(a.data);
				}
			});
		});
		
		
		
		$(document).on('click','#btn-filtrarModulacion', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Modulacion.frmModulacion
				,'url': Modulacion.url + control.data('url')
				,'contentDetalle': Modulacion.contentDetalle
			};

			Fn.loadReporte(config);
		});
		
		$(document).on('click','#btn-registrar-modulacion',function(e){
			e.preventDefault();

			var rows = $('#tb-modulacion').DataTable().rows({ 'search': 'applied' }).nodes();
			var datos = {};

			$.each(rows, function(ir,vr){
			   var input = $(vr).find('input');

			   if( typeof(datos[ir]) == 'undefined' ){
				   datos[ir] = { 'idCliente': 0, 'modulacion': [] };
			   }

			$.each(input, function(ii, vi){
			if( $(vi).attr('type') == 'checkbox' ){
			if( $(vi).is(':checked') ){
			datos[ir]['modulacion'].push($(vi).val());
			}
			}
			else{
			datos[ir]['idCliente'] = $(vi).val();
			}
			});
			});
			
			datos['fecIni']='11/07/2020' ;  //$('#fecIni_lista').val();
			datos['fecFin']='11/08/2020';//$('#fecFin_lista').val();

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
		})

		$(document).on('click','#btn-generarRutasManual', function(e){
        	e.preventDefault();
				var fn1="Modulacion.generarRutasManual();";
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea generar las Rutas/Visitas del dia de hoy?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Visitas.idModal = modalId;
		});
	
		$(document).on('click','#btn-cargaMasivaRutas',function(e){
			e.preventDefault();

        	var data ={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = { 'url': Modulacion.url+'cargaMasivaRuta', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Modulacion.GuardarNuevoPuntoMasivo();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});
				
			//////

			var container = document.getElementById('cargaMasivaRutas');

			var settings = {
					licenseKey: 'non-commercial-and-evaluation',

					colHeaders: ['NOMBRE RUTA', 'IDGTM', 'IDCLIENTE', 'FECHA'],
					startRows: 10,
					//startCols: 4,
					columns: [
						{data: 'nombreRuta', allowEmpty: false},
						{data: 'idGtm', type:'numeric', allowEmpty: false},
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'fecha', type:'date'}
					],
					minSpareCols: 1, //always keep at least 1 spare row at the right
					minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
					rowHeaders: true, //n° contador de las filas
					contextMenu: true,
					dropdownMenu: true, //desplegable en la columna, ofrece oopciones
					height: 300,
					stretchH: 'all', //Expande todas las columnas al 100%
					maxRows: 1000, //cantidad máxima de filas
					manualColumnResize: true
				};
				Modulacion.handsontable = new Handsontable(container, settings);

				setTimeout(function(){
					Modulacion.handsontable.render(); 
				}, 1000);
			});
			
			/////
		});
		
		$(document).on('click','#btn-importar',function(e){
			e.preventDefault();

        	var data ={'idRuta':$('#idRuta').val()};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = { 'url': Modulacion.url+'importarRuta', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				$('#cargaMasivaRutas').html(a.data.html);
			});
		});
		
		$("#btn-descargar").on("click",function(e){
			e.preventDefault();
			var url =site_url+"configuraciones/master/rutas/descargar_data/";
			Fn.download(url);
		});
		
		$(document).on('click','#btn-clonarRutas',function(e){
			e.preventDefault();

        	var data ={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = { 'url': Modulacion.url+'clonarRuta', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Modulacion.clonarRuta();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});
				
			//////
			var container = document.getElementById('cargaMasivaRutas');

			var settings = {
					licenseKey: 'non-commercial-and-evaluation',

					colHeaders: ['NOMBRE RUTA', 'IDGTM', 'IDCLIENTE', 'FECHA' ],
					startRows: 10,
					//startCols: 4,
					columns: [
						{data: 'nombreRuta', allowEmpty: false},
						{data: 'idGtm', type:'numeric', allowEmpty: false},
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'fecha', type:'myDate'},
						
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
					manualColumnResize: true,
					//FUNCIONES
					 
				};

				Modulacion.handsontable = new Handsontable(container, settings);
				setTimeout(function(){
					Modulacion.handsontable.render(); 
				}, 1000);
			});
			
			/////
		});
	
	
	},

	validar_nombre: function (value){
		return true;
	},

	registrar_ruta: function(){
		var data=Fn.formSerializeObject('nueva_ruta');
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': Modulacion.url + 'registrar_ruta', 'data': jsonString };

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
	
	agregar_clientes: function(){
		var data=Fn.formSerializeObject('form_agregar_visitas');
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': Modulacion.url + 'agregar_visitas', 'data': jsonString };

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
	
	actualizar_ruta: function(){
		var arrayDataClientes = [];
		for (var ix = 0; ix < Modulacion.handsontable.countRows(); ix++) {
			if (!Modulacion.handsontable.isEmptyRow(ix)) {
				arrayDataClientes.push(Modulacion.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataClientes;
		var data = {'clientes':dataArrayCargaMasiva,'fecIni':$('#fecha_ini').val(),'fecFin':$('#fecha_fin').val(),'nombre_ruta':$('#nombreRuta').val(),'idRutaProg':$('#idRutaProg').val()}
		
		//var data=Fn.formSerializeObject('actualizar_ruta');
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': Modulacion.url + 'actualizar_ruta', 'data': jsonString };

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
	
	eliminar_ruta: function(){
		var data=Fn.formSerializeObject('eliminar_ruta');
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': Modulacion.url + 'eliminar_ruta', 'data': jsonString };

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
	
	GuardarNuevoPuntoMasivo: function(){
		var arrayDataClientes = [];
		for (var ix = 0; ix < Modulacion.handsontable.countRows(); ix++) {
			if (!Modulacion.handsontable.isEmptyRow(ix)) {
				arrayDataClientes.push(Modulacion.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataClientes;
		var data = {'clientes':dataArrayCargaMasiva,'fecIni':$('#fecha_ini').val(),'fecFin':$('#fecha_fin').val()}
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Modulacion.url+'registrarMasivo', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+(modalId--)+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	},
	
	clonarRuta: function(){
		var arrayDataClientes = [];
		for (var ix = 0; ix < Modulacion.handsontable.countRows(); ix++) {
			if (!Modulacion.handsontable.isEmptyRow(ix)) {
				arrayDataClientes.push(Modulacion.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataClientes;
		var data = {'clientes':dataArrayCargaMasiva,'fecIni':$('#fecha_ini_2').val(),'fecFin':$('#fecha_fin_2').val(),'nombreRuta':$('#nombreRuta').val(),'idGtm':$('#idGtm').val()}
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url':Modulacion.url+'registrarClonacion', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	},
	
	table_excel: function(){
		var data_visitas = visitas;
		var container = document.getElementById('editarRutasMasiva');
		var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: [ data_visitas ], 
					colHeaders: ['IDCLIENTE', 'FECHA'],
					startRows: 10,
					columns: [
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'fecha', type:'myDate'},
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
					maxRows: 50, //cantidad máxima de filas
					manualColumnResize: true,
					//FUNCIONES
				};

				Modulacion.handsontable = new Handsontable(container, settings);
				setTimeout(function(){
					Modulacion.handsontable.render(); 
				}, 1000);
			
		
	},
	generarRutasManual: function(){
		var data = { };
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url':Modulacion.url+'generar_rutas_manual', 'data': jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
			
		});
	},
	
}

Modulacion.load();