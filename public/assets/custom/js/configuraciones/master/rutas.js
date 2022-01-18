var Modulacion = {

	frmModulacion: 'frm-modulacion',
	contentDetalle: 'idDetalleModulacion',
	idTableDetalle : 'tb-modulacion',
	url : 'configuraciones/master/rutas/',
	handsontable : '',
	idModalCargaMasiva:null,
	fullCalendar: [],
	
	load: function(){

		$(".card-body > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion=$(this).data('value');
            if(indiceSeccion == 1){
                $('#btn-filtrarModulacion').click();
            }
        });


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

		$(document).on("click",".btn-rutas-generada",function(e){
			e.preventDefault();
			var divHtml = '';
			var data={'id':$(this).attr('data-id'),'fecIni':$(this).attr('data-fecIni'),'fecFin':$(this).attr('data-fecFin')};
			var jsonString={ 'data':JSON.stringify( data ) };
			var config={'url':Modulacion.url+'formRutaGenerada','data':jsonString};

			$.when( Fn.ajax(config) ).then(function(a){
				//a.data
				++modalId;
				var btn=[];
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				console.log(a);
				btn[0]={title:'Continuar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data.html,btn:btn,width:a.data.width });
				Modulacion.fullCalendar = a.data.fullCalendar;
				
				var calendarEl = document.getElementById('calendar');
				var calendar = new FullCalendar.Calendar(calendarEl, {
					initialView: 'dayGridMonth',
					locale: 'es',
					aspectRatio: 1,
					events: Modulacion.fullCalendar.events,
					validRange: {
						start: Modulacion.fullCalendar.startDate,
					},
					// ,
					// eventClick: function (info) {
					// 	// if (typeof info.event.extendedProps.epIdRuta !== "undefined") {
					// 	//     var idRuta = info.event.extendedProps.epIdRuta;
					// 	//     var fecha = info.event.extendedProps.epFecha;
					// 	//     var inputRutaReprogramacion = $("#formReprogramacion input[name='idRutaReprogramacion']");
					// 	//     var inputFechaReprogramacion = $("#formReprogramacion input[name='fechaReprogramacion']");
					// 	//     $(inputRutaReprogramacion).val(idRuta);
					// 	//     $(inputFechaReprogramacion).val(Global.formatDate(fecha));
					// 	// }
					// },
				});
				setTimeout(function(){
					calendar.render();
				}, 1000);
				
			});
		});

		$(document).on('shown.bs.modal', '#formRutaGenerada', function () {
            
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
			//datos['idGrupoCanal']= 1; //$('#idGrupoCanal').val();

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
				Modulacion.idModalCargaMasiva=modalId;
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

					colHeaders: ['NOMBRE RUTA', 'IDGTM', 'IDCLIENTE', 'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO'],
					startRows: 10,
					//startCols: 4,
					columns: [
						{data: 'nombreRuta', allowEmpty: false},
						{data: 'idGtm', type:'numeric', allowEmpty: false},
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'lunes', type:'numeric'},
						{data: 'martes', type:'numeric'},
						{data: 'miercoles', type:'numeric'},
						{data: 'jueves', type:'numeric'},
						{data: 'viernes', type:'numeric'},
						{data: 'sabado', type:'numeric'},
						{data: 'domingo', type:'numeric'},
						
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
					cells: function(row,col, prop){
						if (col==3) {
							//
						}
					},
					afterChange: function(changes, source){
						var elemento = this; 
					}
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

		$(document).on('click','#btn-descargarRutasFormato', function(e){
			e.preventDefault();
			if(Modulacion.handsontable!=null){
				const exportPlugin = Modulacion.handsontable.getPlugin('exportFile');
				exportPlugin.downloadFile('csv', {
						filename: 'FormatoRutas',
						exportHiddenRows: true,     
						exportHiddenColumns: true,  
						columnHeaders: true,        
						rowHeaders: true,           
						columnDelimiter: ';'
				});
			}
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

					colHeaders: ['NOMBRE RUTA', 'IDGTM', 'IDCLIENTE', 'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO'],
					startRows: 10,
					//startCols: 4,
					columns: [
						{data: 'nombreRuta', allowEmpty: false},
						{data: 'idGtm', type:'numeric', allowEmpty: false},
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'lunes', type:'numeric'},
						{data: 'martes', type:'numeric'},
						{data: 'miercoles', type:'numeric'},
						{data: 'jueves', type:'numeric'},
						{data: 'viernes', type:'numeric'},
						{data: 'sabado', type:'numeric'},
						{data: 'domingo', type:'numeric'},
						
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
					cells: function(row,col, prop){
						if (col==3) {
							//
						}
					},
					afterChange: function(changes, source){
						var elemento = this; 
					}
				};

				Modulacion.handsontable = new Handsontable(container, settings);
				setTimeout(function(){
					Modulacion.handsontable.render(); 
				}, 1000);
			});
		});

		$(document).on('click','#btn-cargaMasivaAlternativa', function(e){
			e.preventDefault();

			var control= $(this);
			var data={};
			var jsonString = {data: JSON.stringify(data)};
			var configAjax = {url: Modulacion.url + 'rutasCargaMasivaAlternativa', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn1};
				var message = a.data.html;
				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});
			});
		});

		$(document).ready(function () {
			$('#btn-filtrarModulacion').click();
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

		var generacion=$('input[name="ch-generacion"]:checked').val();
		var fechaFin=$('#fecha_fin').val();

		if(generacion==undefined || generacion==null ){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = "Seleccione un tipo de generacion de ruta";
			Fn.showModal({ id:modalId,title: "REGISTRAR RUTA MASIVO",content:message,btn:btn,show:true,width:'40%'});
		}else{
			if(generacion=="completa" && fechaFin==""){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = "El campo Fecha Fin es obligatorio para el tipo de generacion Completa";
				Fn.showModal({ id:modalId,title: "REGISTRAR RUTA MASIVO",content:message,btn:btn,show:true,width:'40%'});
			}else{
				var arrayDataClientes = [];
				for (var ix = 0; ix < Modulacion.handsontable.countRows(); ix++) {
					if (!Modulacion.handsontable.isEmptyRow(ix)) {
						arrayDataClientes.push(Modulacion.handsontable.getDataAtRow(ix));
					}
				}
				let tipoUsuario = $('#tipo').val();
				var dataArrayCargaMasiva = arrayDataClientes;
				var data = {'generacion':generacion,'clientes':dataArrayCargaMasiva,'fecIni':$('#fecha_ini').val(),'fecFin':$('#fecha_fin').val(),tipoUsuario}
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Modulacion.url+'registrarMasivo', 'data':jsonString};
		
				$.when(Fn.ajax(configAjax)).then(function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+Modulacion.idModalCargaMasiva+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.msg.content;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
				});

			}

			
		}
		
		
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
					colHeaders: ['IDCLIENTE', 'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO'],
					startRows: 10,
					columns: [
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'lunes', type:'numeric'},
						{data: 'martes', type:'numeric'},
						{data: 'miercoles', type:'numeric'},
						{data: 'jueves', type:'numeric'},
						{data: 'viernes', type:'numeric'},
						{data: 'sabado', type:'numeric'},
						{data: 'domingo', type:'numeric'},
						
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
					cells: function(row,col, prop){
						if (col==3) {
							//
						}
					},
					
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


	cargaMasivaAlternativa: function() {
		var file_data = $('#archivo').prop('files')[0];
		var generado = $('input[name="generado"]:checked').val();
		var fecFin = $('#fecha_fin').val();
		var tipoUsuario = $('#tipo').val();
		var validar=true;
		
		console.log(file_data);
		console.log(generado);
		console.log(fecFin);
		console.log(fecFin==null);

		if(file_data==undefined){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Ruta",content:"Se requiere la carga del archivo.",btn:btn});
			validar=false;
		}
		
		if(generado==1){
			if(fecFin==null){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Ruta",content:"Se requiere el ingreso de fecha fin para la generacion completa.",btn:btn});
				validar=false;
			}
		}

		if(validar){
			
			var file_name = file_data.name;
			var formato = file_name.split(".");		
			var fecIni = $('#fecha_ini').val();		
			
			
			var form_data = new FormData();             
			form_data.append('file', file_data); 
			form_data.append('fecIni', fecIni); 
			form_data.append('fecFin', fecFin); 
			form_data.append('tipoUsuario', tipoUsuario); 
			form_data.append('generado', generado); 

			if((formato[1]=='csv')||(formato[1]=='CSV')){	
				$.ajax({
					url: site_url+'index.php/configuraciones/master/rutas/carga_masiva_alternativa',
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
						setTimeout(Modulacion.ejecutarBat, 0 );
					},
				});
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Ruta",content:"Solo se permite archivos con formato .csv",btn:btn});
				validar=false;
			} 

		}
	
		
	},
	ejecutarBat: function(){
		$.ajax({
			type: "POST",
			dataType: 'json',
			data: {
				tipoUsuario:$('#tipo').val(),
				idCuenta: $("#sessIdCuenta").val(), 
				idProyecto: $("#sessIdProyecto").val(),	
			},   
			url: site_url+'control/bat_rutas',
			success: function(data) {
				console.log('listo');
			}
		});
	},
	
}

Modulacion.load();