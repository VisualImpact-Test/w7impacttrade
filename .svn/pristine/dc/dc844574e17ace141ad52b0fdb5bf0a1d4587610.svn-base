var Permisos = {

	frmPermisos: 'frm-permisos',
	frmNuevoPermisos: 'registrar_permiso',
	contentDetalle: 'idDetallePermisos',
	idTableDetalle : 'tb-permisoDetalle',
	url : 'configuraciones/master/permisos/',
	idModal : 0,

	load: function(){

		$(".card-body > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion=$(this).data('value');
            if(indiceSeccion == 1){
                $('#btn-filtrarPermisos').click();
				
            }
        });

		$(document).on('click','#btn-nuevoPermiso', function(e){
			e.preventDefault();
			
			var control = $(this);
			var ruta = control.data('url');
			//
			var data = {};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Permisos.url + ruta, 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var fn1='Permisos.confirmarNuevoPermisos();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					btn[1]={title:'Registrar',fn:fn1};
				var html = '';
					html += a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
				Permisos.idModal=modalId;
			});
		});

		$(document).on('click','.btnCambiarEstado', function(e){
			e.preventDefault();

			var control=$(this);
			var data={permiso: control.data('permiso'), estado: control.data('estado'), flagEditar: control.data('flagEditar')};

			++modalId;
			var fn1='Permisos.guardarCambiarEstado('+JSON.stringify(data)+');Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				message+='<span>Se procedera a <strong>'+control.data('titleCambio')+'</strong> el registro.</span>';
				message+='<div class="divider"></div>'
				message+='<div class="row m-3">';
				message+='<div class="col-md-12">';
					message+='<div class="alert alert-primary" role="alert">';
						message+='<i class="fas fa-toggle-on fa-lg"></i> <strong>ACTIVAR:</strong> <br>- Dicha acción permitirá que el <strong>permiso de carga</strong> asignado al <strong>usuario</strong> con los <strong>rangos de fechas</strong> se active en los procesos internos del sistema.';
					message+='</div>';
					message+='<div class="alert alert-danger" role="alert">';
						message+='<i class="fas fa-toggle-off fa-lg"></i> <strong>DESACTIVAR:</strong> <br>- Dicha acción <strong>bloqueará</strong> el uso de dicho <strong>permiso de carga</strong> asignado al <strong>usuario</strong> con los <strong>rangos de fechas</strong> asignados (es el equivalente a eliminar).';
					message+='</div>';
				message+='</div>';
				message+='</div>';
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true,width:'50%'});
		});

		$(document).on('click','.btnHabilitarEditar', function(e){
			e.preventDefault();

			var control=$(this);
			var data={permiso:control.data('permiso'), estado:control.data('estado')};

			++modalId;
			var fn1='Permisos.guardarCambiarEstadoEditar('+JSON.stringify(data)+');Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				message+='<span>Se procedera a <strong>'+control.data('titleCambio')+'</strong> del registro.</span>';
				message+='<div class="divider"></div>'
				message+='<div class="row m-3">';
				message+='<div class="col-md-12">';
					message+='<div class="alert alert-success" role="alert">';
						message+='<i class="fas fa-bell fa-lg"></i> <strong>HABILITAR:</strong> Dicha <strong>acción</strong> otorgará al <strong>usuario</strong>, las capacidades de:<br>';
							message+='- <strong>Cargar la modulacion</strong>, aplicando el método de carga masiva.<br>';
							message+='- <strong>Editar modulación - cliente</strong>, podrá editar la modulación de cada cliente de manera individual.<br>';
							message+='- <strong>Generar listas</strong>, permitirá la generación de las listas de los clientes asignados al usuario. '
					message+='</div>';
					message+='<div class="alert alert-danger" role="alert">';
						message+='<i class="fas fa-bell-slash fa-lg"></i> <strong>DESHABILITAR:</strong> Dicha <strong>acción</strong> negará al <strong>usuario</strong> las siguientes capacidades:<br>';
							message+='- <strong>Cargar la modulación</strong>, no podrá cargar la modulación de los clientes de manera masiva.<br>';
							message+='- <strong>Editar modulación</strong>, no tendrá acceso a editar la modulación de cada cliente.<br>';
							message+='- <strong>Generar listas</strong>, se denegará la acción de generar las listas de clientes del usuario.'
					message+='</div>';
				message+='</div>';
				message+='</div>';
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true, width:'50%'});
		});
		
		$(document).on('click','.editarPermiso', function(e){
			e.preventDefault();
			
			var control = $(this);
			var ruta = control.data('url');
			var permiso = control.data('permiso');
			//
			var data = {'idPermiso':permiso};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Permisos.url + 'editar', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var fn1='Permisos.confirmarEditarPermiso();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					btn[1]={title:'actualizar',fn:fn1};
				
				var html = '';
					html += a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:a.data.htmlWidth});
				Permisos.idModal=modalId;
			});
		});
		
		$(document).on('click','#btn-filtrarPermisos', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Permisos.frmPermisos
				,'url': Permisos.url + control.data('url')
				,'contentDetalle': Permisos.contentDetalle
			};

			Fn.loadReporte(config);
		});

		$(document).on('click','#btn-savePermisos', function(e){
			e.preventDefault();

			++modalId;
			var fn1='Permisos.guardarAsistencia();Fn.showModal({ id:'+modalId+',show:false });';
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
				var configAjax = { 'url': Permisos.url + 'guardarUsuarioAsistencia', 'data': jsonString };

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

		$('#btn-filtrarPermisos').click();
	},

	confirmarNuevoPermisos: function(){
		var cantidadModulos = $('input[name="modulos"]:checked').length;
		var cantidadUsuarios = $('input[name="idUsuario"]').length;
		
		if ( cantidadModulos==0 ) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'No se ha detectado la <strong>selección</strong> de algún <strong>modulo</strong>, por favor ingrese la información solicitada' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		}else if ( cantidadUsuarios==0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'No se ha detectado la <strong>selección</strong> de algún <strong>usuario</strong>, por favor ingrese la información solicitada' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			$.when( Fn.validateForm({'id':Permisos.frmNuevoPermisos})).then( function(a){
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
					var fn1='Permisos.guardarNuevosPermisos();Fn.showModal({ id:'+modalId+',show:false });';
					var fn2='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
					Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				}
			});
		}
	},

	guardarNuevosPermisos: function(){
		var data = Fn.formSerializeObject(Permisos.frmNuevoPermisos);
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url':Permisos.url+'registrar_permiso', 'data': jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};

			var message = a.data.html;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});

			if (a.result==1) {
				Fn.showModal({ id:Permisos.idModal, show:false});
				$('#btn-filtrarPermisos').click();
			}
		});
	},

	confirmarEditarPermiso: function(){
		++modalId;
		var fn1='Permisos.guardarNuevosPermisos();Fn.showModal({ id:'+modalId+',show:false });';
		var fn2='Fn.showModal({ id:'+modalId+',show:false });';
		var btn=new Array();
			btn[0]={title:'Continuar',fn:fn1};
			btn[1]={title:'Cerrar',fn:fn2};
		var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
		Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
	},

	registrar: function(){
		var data=Fn.formSerializeObject(Permisos.frmNuevoPermisos);
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': Permisos.url + 'registrar_permiso', 'data': jsonString };

		$.when( Fn.ajax(configAjax) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			
			var message = '';
				message += a.data.html;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});

			if (a.result==1) {
				Fn.showModal({ id:Permisos.idModal, show:false});
				$('#btn-filtrarPermisos').click();
			}
		});
	},

	guardarCambiarEstado: function(dataPermiso){
		var data = dataPermiso;
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': Permisos.url + 'cambiarEstado', 'data': jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				var tdBtnEstado = $('#tdEstado-'+data.permiso);
				var tdBtnEstadoChildren = tdBtnEstado.children().remove();
				tdBtnEstado.html(a.data.htmlEstado);

				var tdBtnHabEditar = $('#tdHabEditar-'+data.permiso);
				var tdBtnHabEditarChildren = tdBtnHabEditar.children().remove();
				tdBtnHabEditar.html(a.data.htmlHabilitarEditar);

				var tdEditar = $('#tdEditar-'+data.permiso);
				var tdEditarChildren = tdEditar.children().remove();
				tdEditar.html(a.data.htmlEditar);
			}
		});
	},

	guardarCambiarEstadoEditar: function(dataPermiso){
		var data = dataPermiso;
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': Permisos.url + 'cambiarEstadoEditar', 'data': jsonString };

		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				var tdBtnHabEditar = $('#tdHabEditar-'+data.permiso);
				var tdBtnHabEditarChildren = tdBtnHabEditar.children().remove();
				tdBtnHabEditar.html(a.data.htmlHabilitarEditar);
			}
		});
	}
}

Permisos.load();