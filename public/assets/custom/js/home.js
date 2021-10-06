var Home={
	url: "home/",
	load: function(){

		// var flag_anuncio_visto = localStorage.getItem('flag_anuncio_visto');
        // if(flag_anuncio_visto == 0){
           
        // }

		$(document).on('click', '.lk-show-gps1', function(){
			var control =  $(this);
			var latitud = control.data('latitud');
		    var longitud = control.data('longitud');
		    var latitud_cliente = control.data('latitud-cliente');
		    var longitud_cliente = control.data('longitud-cliente');

			var cliente = control.data('cliente');
			var usuario = control.data('usuario');
			var perfil = control.data('perfil');

		    var type = control.data('type');

		    var data = { type:type, latitud:latitud, longitud:longitud,latitud_cliente:latitud_cliente,longitud_cliente:longitud_cliente, cliente:cliente, usuario:usuario, perfil:perfil };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Home.url + 'mostrarMapa', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn, width:"90%" });
			});
		});

		$(document).ready(function(){

			$('.main-cobertura').css('align-items','center');
			$('.main-efectividad').css('align-items','center');
			$('.main-fotos').css('align-items','center');

			$.when(Home.mostrar_cartera(),Home.mostrar_efectividad()).then(function(){
				$('#btn-anuncios').click();
			});
			// Home.mostrar_cartera();
			// Home.mostrar_efectividad();
		});

		if(localStorage.getItem('modalCuentaProyecto') == 0){
			$('#a-cambiarcuenta').click();
		}
	},

	mostrar_cartera:function(){

		var ad = $.Deferred();
		var data = {};
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Home.url + 'get_cobertura', 'data': jsonString };

		$.when(Fn.ajaxNoLoad(config)).then(function(a){
			$('.vista-cobertura').html(a.data.html);
			$('.vista-cobertura').removeClass('centrarContenidoDiv');

			ad.resolve(true);
		});

		return ad.promise();
	},

	mostrar_efectividad:function(){

		var ad = $.Deferred();
		var data = {};
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Home.url + 'get_efectividad', 'data': jsonString };

		$.when(Fn.ajaxNoLoad(config)).then(function (a) {
			
			$('.vista-efectividad').html(a.data.html);
			$('.vista-efectividad').removeClass('centrarContenidoDiv');

			ad.resolve(true);

		});

		return ad.promise();

	},

	mostrar_fotos:function(){

		var ad = $.Deferred();
		var data = {};
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Home.url + 'get_fotos', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			
			$('.vista-fotos').html(a.data.html);
			$('.vista-fotos').removeClass('centrarContenidoDiv');

			ad.resolve(true);

		});
		return ad.promise();
	}

}
Home.load();

var MuroMini = {
	ws: null,
	load: function(){
		if( $('.card-muro').length == 0 ) return false;
		if( !'WebSocket' in window ) return false;

		

		var params = {
				idGrupo: null,
				idUsuario: $usuario['idUsuario'],
				usuario: $usuario['usuario'],
				estado: $usuario['estado'],
				device: $usuario['device']
			};
			
		if($usuario['idGrupo']!=null){
			params['idGrupo']=$usuario['idGrupo'];
		}
		
		MuroMini.ws = new WebSocket('ws://190.223.68.212:5555?' + $.param(params));

		MuroMini.ws.onmessage = function(e){
			var received = JSON.parse(e.data);

			if( received['estado'] == 'sincronizar' ){
				MuroMini.publicacion();
			}
			else if( received['tabla'] == 'publicacion' ){
				MuroMini.publicacionMostrar(received['data'], false);
			}
		};

		MuroMini.ws.onopen = function(){
			MuroMini.publicacion();
		};

	},
	publicacion: function(){
		var config = {
				accion: 'obtener_publicaciones',
				idGrupoCanal: $usuario['idGrupoCanal'],
				idCanal: $usuario['idCanal'],
				idProyecto: ($usuario['idProyecto']==null) ? null : $usuario['idProyecto'],
				idCuenta: ($usuario['idCuenta']==null) ? null : $usuario['idCuenta'],
				index_min: 0,
				index_max: 5
			};
		MuroMini.ws.send(JSON.stringify(config));
	},
	publicacionMostrar: function(data){
		var html = '';
			data.forEach(function(v, i){
				var fechaPub = v['fecha_p'];
				var aFechaPub = fechaPub.split('-');

				fechaPub = aFechaPub.slice().reverse().join('/');

				var hoy = new Date();
				var aFecha = [
						hoy.getFullYear(),
						hoy.getMonth() + 1,
						hoy.getDate() < 10 ? '0' + hoy.getDate() : hoy.getDate()
					];

				var fecha = aFecha.reverse().join('/');

				var hora = v['hora_p'].substring(0, 8);
				var aHora = hora.split(':');

				var d = new Date();
					d.setDate(aFechaPub[2]);
					d.setMonth(aFechaPub[1] - 1);
					d.setFullYear(aFechaPub[0]);

					d.setHours(aHora[0]);
					d.setMinutes(aHora[1]);
					d.setSeconds(aHora[2]);

				var diff = hoy.getTime() - d.getTime();
					var segundos = Math.round(diff / 1000);
					var minutos = Math.round(diff / (1000 * 60));
					var horas = Math.round(diff / (1000 * 60 * 60));
					var dias = Math.round(diff / (1000 * 60 * 60 * 24));

				var tiempo = '';
				if( fecha == fechaPub || dias < 1 ){
					if( segundos < 59 ) tiempo = 'Hace un momento';
					else if( minutos < 59 ) tiempo = minutos + ' min';
					else tiempo = horas + ' h';
				}
				else if( dias < 16 ) tiempo = dias + ' d';
				else tiempo = fechaPub;

				html += '<li class="list-group-item">';
					html += '<div class="row">';
						html += '<div id="content-public-' + v['idPublicacion'] +'" class="col-12 text-truncate">';

							var txtContent = '';
							if( v['titulo'] ) txtContent = v['titulo'];
							else if( v['comentario'] ) txtContent = v['comentario'];

							var txtFoto = '';
							if( v['fotos'] ){
								txtFoto = '<small class="font-weight-bold">' + v['fotos'] + ' ' + (v['fotos'] > 1 ? 'fotos' : 'foto') + '</small>';
							}

							if( txtContent.length == 0 && txtFoto.length > 0 ) html += txtFoto;
							else if( txtContent.length > 0 && txtFoto.length == 0 ) html += txtContent;
							else html += txtFoto + ' - ' + txtContent;

						html += '</div>';
					html += '</div>';
					html += '<small class="text-muted">';
						html += '<span><i class="far fa-user fa-lg"></i> ' + v['nombre_usuario'] + '</span>';
						html += '<span class="float-right">' + tiempo + '<span>';
					html += '</small>';
				html += '</li>';

				$('#list-muro').html(html).show('slow');
			});

	}
};
MuroMini.load();