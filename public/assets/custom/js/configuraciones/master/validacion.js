var Modulacion = {

	frmModulacion: 'frm-modulacion',
	contentDetalle: 'idDetalleModulacion',
	idTableDetalle : 'tb-modulacion',
	url : 'configuraciones/master/validaciones/',

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
		
		$(document).on('click','.editar', function(e){
			e.preventDefault();
			
			var control = $(this);
			var idValidacion = control.data('permiso');
			//
			var data = {'idValidacion':idValidacion};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Modulacion.url + 'editar', 'data': jsonString };

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
}

Modulacion.load();