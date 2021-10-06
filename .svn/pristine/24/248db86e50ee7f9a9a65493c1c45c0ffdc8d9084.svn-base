var ContingenciaAsistencia = {

	frmAsistencia: 'frm-contingenciaAsistencia',
	contentDetalle: 'idDetalleContingenciaAsistencia',
	idTableDetalle : 'tb-contingenciaAsistenciaDetalle',
	url : 'configuraciones/contingencia/asistencia/',

	load: function(){

		$(document).on('click','#btn-filtrarContingenciaAsistencia', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : ContingenciaAsistencia.frmAsistencia
				,'url': ContingenciaAsistencia.url + control.data('url')
				,'contentDetalle': ContingenciaAsistencia.contentDetalle
			};

			Fn.loadReporte(config);
		});

		$(document).on('click','#btn-saveContingenciaAsistencia', function(e){
			e.preventDefault();

			++modalId;
			var fn1='ContingenciaAsistencia.guardarAsistencia();Fn.showModal({ id:'+modalId+',show:false });';
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
				var configAjax = { 'url': ContingenciaAsistencia.url + 'guardarUsuarioAsistencia', 'data': jsonString };

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

	guardarAsistencia: function(){
		var error=0;
		var data_hora = [];
		var row = [];

		$('#tb-contingenciaAsistenciaDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();

			var button = $(data).find('.saveUsuarioAsistencia');
			var usuario = button.data("usuario");
			var nombreUsuario = button.data("nombreusuario");
			var fecha = button.data("fecha");
			var tipoUsuario = button.data("tipousuario");
			var perfil = button.data("perfil");
			var numDocumento = button.data("numdocumento");

			$(data).find('.ipUsuarioHora-'+usuario).each( function(ix,val){
				var input = $(this);
				var hora = input.val();
				var tipoAsistencia = input.data('tipoasistencia');
				//FIND ELEMENTOS
				var ocurrencia  = $(data).find("select[name=sl-ocurrencias-"+usuario+"-"+tipoAsistencia+"]").val();
				var ocurrenciaText  = $(data).find("select[name=sl-ocurrencias-"+usuario+"-"+tipoAsistencia+"] option:selected").text();
			
				if ( hora !=="" ){
					if ( ocurrencia=="" ) {
						error++;
					} else {
						row = {
							'usuario': usuario
							,'hora': hora
							,'tipoAsistencia': tipoAsistencia
							,'ocurrencia': ocurrencia
							,'ocurrenciaText': ocurrenciaText
							,'fecha': fecha
							,'nombreUsuario': nombreUsuario
							,'tipoUsuario': tipoUsuario
							,'perfil': perfil
							,'numDocumento': numDocumento
						};
						data_hora.push(row);
					}
				}
			});
		});

		if ( error>0 ) {
			++modalId;
			var fn4='Fn.showModal({ id:'+modalId+', show:false});';
			var btn = new Array();
				btn[0]={title:'Cerrar', fn:fn4};
			var message = Fn.message({ 'type': 2, 'message': 'Faltan registrar los motivos en algunos registros' });
			Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			return;
		}

		if ( data_hora.length==0 ) {
			++modalId;
			var fn4='Fn.showModal({ id:'+modalId+', show:false});';
			var btn = new Array();
				btn[0]={title:'Cerrar', fn:fn4};
			var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
			Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			return;
		} else {
			var data = data_hora;
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ContingenciaAsistencia.url + 'guardarAsistencia', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then(function(a){
				++modalId;
				var fn5='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn5};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });

				if ( a.result==1 ) {
					$("#btn-filtrarContingenciaAsistencia").click();
				}
			});
		}
	}

}

ContingenciaAsistencia.load();