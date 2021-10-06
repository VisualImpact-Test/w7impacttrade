var Muro = {
	i: 0,
	ws : null,
	index_min:0,
	index_max:10,
	usuario: $usuario,

	estado_conexion: false,
	estado_cargando: false,
	estado_cargando_filas: false,
	estado_max_filas: false,

	anterior_publicaciones_cant:0,
	// indice_modal:0,

	oBuscar: {
		idCuenta: $usuario.idCuenta, //poner para otener el campo del arreglo actal no el q viene
		idProyecto: $usuario.idProyecto,
		index_min: 0,
		index_max: 10,
		fecha_ini: null,
		fecha_fin: null,
		idUsuario: null,
		direccion: null,
		idGrupoCanal: null,
		idCanal: null
	},
	usuario_filtro:null,
	grupos:null,
	conectar: function( config = {} ){
		var $default = { init: true };
			config = $.extend($default, config);

		var params = {
				idGrupo: Muro.usuario['idGrupo'],
				idUsuario: Muro.usuario['idUsuario'],
				usuario: Muro.usuario['usuario'],
				estado: Muro.usuario['estado'],
				device: Muro.usuario['device']
			};
			

		Muro.ws = new WebSocket('ws://190.223.68.212:5555?' + $.param(params));
		Muro.estado_conexion = true;

		Muro.ws.onmessage = function(e){
			Muro.estado_cargando = true;
			var received = JSON.parse(e.data);

			if( received['estado'] == 'sincronizar' ){
				if( received['sincronizar'] == 'publicacion_det_atributo' ){
					Muro.socket_buscar_publicacion_calificacion(received['idPublicacion']);
				}
				else if( received['sincronizar'] == 'publicacion_nueva' ){
					// REVISAR - condicional cuando realizo un filtro
					// Muro.socket_buscar_publicacion(received['idPublicacion']);

					Muro.oPendiente.publicacion_new.push(received['idPublicacion']);
					if( Muro.oPendiente.publicacion_new.length == 1 ){
						if( !Muro.ws_procesando )
							Muro.ws_ejecutar();
					}
				}
				else if( received['sincronizar'] == 'publicacion_comentario' ){
					if( !received['idComentario'] ){
						// Muro.socket_obtener_publicaciones_det(received['idPublicacion']);
						Muro.socket_buscar_publicacion_cant_comentarios(received['idPublicacion']);

						$('#publicacion-comentarios-' + received['idPublicacion']).empty();
						// Muro.socket_obtener_comentarios(received['idPublicacion']);
					}
					else{
						Muro.socket_buscar_publicacion_cant_comentarios(received['idPublicacion']);
						Muro.socket_obtener_sub_comentarios(received);
					}

				}
				else if( received['sincronizar'] == 'conexion_nueva' ){
					Muro.ws_conexiones();
				}
			}

			if( received['tabla'] ){
				if( received['tabla'] == 'conexiones' ){
					Muro.mostrar_conexiones(received);
				}
				else if(received['tabla'] == 'publicacion' ){
					if( received['data'] &&
						received['data'].length > 0
					){
						Muro.anterior_publicaciones_cant += received['data'].length;

						$('#content-publicacion-msg').hide();
						$('#content-publicacion-msg').empty();
					}
					else{
						Muro.estado_max_filas = true;
						if( Muro.anterior_publicaciones_cant == 0 ){
							var html = '';
								html += '<div class="alert alert-info" role="alert" style="text-align:center;">';
									html += '<i class="fas fa-exclamation-triangle fa-lg mr-2"></i><label class="mb-0">No se encontraron resultados</label>';
								html += '</div>';

							$('#content-publicacion-msg').html(html);
							$('#content-publicacion-msg').show();
							return false;
						}
					}

					Muro.mostrar_publicaciones(received['data'], false);
				}
				else if( received['tabla'] == 'publicacion_det' ){
					var idPublicacion = received['data'][0]['idPublicacion'];
					Muro.mostrar_publicaciones_det(received['data']);

					// Muro.dfd.resolve(idPublicacion);
					Muro.dfd.resolve({ pendiente: 'publicacion_det', idPublicacion: idPublicacion });
				}
				else if( received['tabla'] == 'comentario' ){
					if( received['data'].length == 0 ){
						$.notify(
							{ message: '<i class="far fa-surprise fa-lg"></i> ¡Esta publicación no tiene comentarios!' },
							{ type: 'info', placement: { from: 'bottom', align: 'right' }
						});
					}

					Muro.mostrar_comentario_publicacion(received['data']);
				}
				else if( received['tabla'] == 'comentario_det' ){
					Muro.mostrar_comentario_publicacion_det(received['data']);
				}
				else if( received['tabla'] == 'subcomentario' ){
					Muro.mostrar_subcomentario_publicacion(received['data']);
				}
				else if( received['tabla'] == 'busqueda_publicacion' ){
					// REVISAR - Nuevas publicaciones
					Muro.index_min+=1;
					Muro.index_max+=1;
					Muro.anterior_publicaciones_cant+=1;

					var idPublicacion = received['data'][0]['idPublicacion'];
					Muro.dfd.resolve({ pendiente: 'publicacion_new', idPublicacion: idPublicacion });

					Muro.mostrar_publicaciones(received['data'],true);
					$.notify(
						{ message: '<i class="far fa-surprise fa-lg"></i> ¡Nueva publicacion!' },
						{ type: 'info', placement: { from: 'bottom', align: 'right' }
					});

					
				}
				else if( received['tabla'] == 'busqueda_publicacion_calificacion' ){
					Muro.actualizar_publicacion_calificacion(received['data']);
				}
				else if( received['tabla'] == 'busqueda_publicacion_cant_comentarios' ){
					Muro.actualizar_publicacion_cant_comentario(received['data']);
				}
				else if( received['tabla'] == 'grupo' ){
					Muro.mostrar_grupos(received['data']);
					

				}
			}
		};

		Muro.ws.onopen = function(e){
			if( config['init'] ){
				Muro.ws_publicacion_buscar();
			}
		};

		Muro.ws.onclose = function(e){
			Muro.estado_conexion = false;

			if( e.code == 1006 ){ // Desconexion Desconocida
				Muro.conectar({ init: false });
			}
		};

		Muro.ws.onerror = function(e){
			Muro.estado_conexion = false;
		};

	},
	desconectar: function(){
		Muro.ws.close();
	},

	dfd: {},
	oPendiente: {
		'publicacion_det': [],
		'publicacion_new': []
	},
	oSocket: {
		'publicacion_det': 'Muro.socket_obtener_publicaciones_det(??)',
		'publicacion_new': 'Muro.socket_buscar_publicacion(??)',
	},
	ejecutar: function(){
		if( Muro.oPendiente.publicacion_det.length > 0 ){
			Muro.dfd = $.Deferred();
			var idPublicacion = Muro.oPendiente.publicacion_det[0];
			Muro.socket_obtener_publicaciones_det(idPublicacion);

			$.when( Muro.dfd ).then(function(vIdPublicacion){
				Muro.oPendiente.publicacion_det = jQuery.grep(Muro.oPendiente.publicacion_det, function(value){
						return value != vIdPublicacion;
					});

				Muro.ejecutar();
			})
		}
	},
	ws_ejecutar: function(){
		Muro.dfd = $.Deferred();
		var aPendiente = Object.keys(Muro.oPendiente);

		$.each(aPendiente, function(i, v){
			if( Muro.oPendiente[v].length > 0 ){
				var idPublicacion = Muro.oPendiente[v][0];
				var fnSocket = Muro.oSocket[v].replace('??', idPublicacion);

				eval(fnSocket);
				Muro.ws_procesando = true;
				return false;
			}
		});

		$.when( Muro.dfd ).then(function(obj){
			Muro.ws_procesando = false;
			Muro.oPendiente[obj['pendiente']] = jQuery.grep(Muro.oPendiente[obj['pendiente']], function(value){
					return parseInt(value) != parseInt(obj['idPublicacion']);
				});

			Muro.ws_ejecutar();
		});
	},
	ws_procesando: false,
	img_grid: 5,
	load: function(){

		if( !'WebSocket' in window ){
			$.notify(
				{ message: '<i class="far fa-tired fa-lg"></i> ¡No se ha logró establecer conexión, pruebe con otro navegador!'},
				{ type: 'danger', placement: { from: 'bottom', align: 'right' }
			});

			return false;
		}

		//cargar filtro grupo- cuenta
		Muro.usuario_filtro= $usuario_filtro;

		var html="<option value=''>--Seleccionar--</option>";
		Object.values(Muro.usuario_filtro).forEach(function(v, i) {
			html+="<option value='"+v['idCuenta']+"'  >"+v['cuenta']+"</option>";
		});
		$("#idCuenta").html(html);
		//		
		if($usuario.idGrupo==null){
			$('#card-grupo').attr('style','display: block !important');
		}else{
			$('#card-grupo').attr('style','display: none !important');
		}
		Muro.conectar();
		

		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) )
			$('#content-publicacion-btn-load').removeClass('hide');

		$('.btn-card-show, .btn-card-hide').off('click').on('click', function(){
			var control = $(this);
			var card = $('#card-' + control.data('card'));
			var content = card.parent();

			$('.card-muro').addClass('d-none');
			$('#backdrop-static').toggleClass('d-none show');

			content.toggleClass('d-none card-top');
			card.removeClass('d-none');

		});

		$('#btn-publicacion-estado').on('click', function(e){
			e.preventDefault();
			var estado = $.trim($('#estado').val());

			if( !estado ){
				$.notify(
					{ message: '<i class="far fa-meh fa-lg"></i> ¡Usted se encuentra sin estado!'},
					{ type: 'warning', placement: { from: 'bottom', align: 'right' }
				});
			}

			Muro.socket_guardar_estado(estado);
			$('#estado').val('');
		});

		$('#btn-publicacion-foto').on('click', function(e){
			e.preventDefault();
			$('#file-publicacion-foto').click();
		});

		$('#btn-publicacion-enviar').on('click', function(e){
			e.preventDefault();
			var titulo = $('#titulo').val();
			var comentario = $('#comentario').val();

			if( !comentario.length ){
				$.notify(
					{ message: '<i class="far fa-tired fa-lg"></i> ¡Escribe algo para publicar!'},
					{ type: 'danger', placement: { from: 'bottom', align: 'right' }
				});

				return false;
			}

			/* BORRAR
			var data = {
					titulo: titulo,
					comentario: comentario,
				};

			var fotos = [];
				$('.img-publicacion').each(function(i, v){
					fotos.push({
							idPublicacion: '',
							foto: $(v).attr('src')
						});
				});

			Muro.socket_guardar_publicacion(data, fotos);
			$('#btn-publicacion-limpiar').click();
			*/

			var data = {
					fecha: moment().format('YYYY-MM-DD'),
					hora: moment().format('HH:mm:ss'),
					titulo: titulo,
					comentario: comentario,
					fotos: []
				};

				$('.img-publicacion').each(function(i, v){
					data['fotos'].push({
							idPublicacion: '',
							foto: $(v).attr('src')
						});
				});

			Muro.ws_publicacion_guardar(data);
			$('#btn-publicacion-limpiar').click();
		});

		$('#btn-publicacion-limpiar').on('click', function(e){
			e.preventDefault();

			$('#titulo, #comentario').val('');
			$('#listaFotos').html('');
		});

		$('#file-publicacion-foto').on('change', function(e){
			var control = $(this);

			var file = control[0].files[0];
			if( !file ) return false;

			var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = function(er){
					var html = '';
						html += '<div class="position-relative float-left text-center">';
							html += '<button type="button" class="btn-publicacion-foto-eliminar btn btn-sm btn-link position-absolute p-0 text-danger text-decoration-none" title="Borrar">';
								html += '<i class="fa fa-times-circle fa-2x"></i>';
							html += '</button>';
							html += '<img class="img-publicacion" width="100" height="100" src="' + er.target.result + '">';
						html += '</div>';

					$("#listaFotos").append(html);
					control.val('');
				};
		});

        $('#comentario').on('input', function(){
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

		$('#buscar-fechas').daterangepicker({
			locale: {
					format: 'DD/MM/YYYY',
					daysOfWeek: [ 'Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa' ],
					monthNames: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
					firstDay: 1
				},
			opens: 'left',
			showDropdowns: false,
			autoApply: true,
			autoUpdateInput: false
		});

		$('#buscar-fechas').on('apply.daterangepicker', function(ev, picker){
			var control = $(this);

			var fecIni = moment(picker.startDate.format('YYYY-MM-DD'));
			var fecFin = moment(picker.endDate.format('YYYY-MM-DD'));

			var mesAnioIni = picker.startDate.format('MM-YYYY');
			var mesAnioFin = picker.endDate.format('MM-YYYY');

			if(
				mesAnioIni != mesAnioFin &&
				fecFin.diff(fecIni, 'days') + 1 > 30
			){
				$.notify(
					{ message: '<i class="far fa-meh fa-lg"></i> ¡Solo puede consultar máximo 30 dias!'},
					{ type: 'danger', placement: { from: 'bottom', align: 'right' }
				});

				control.val('');
			}
			else{
				control.val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			}
		});

		$('#buscar-texto').on('keydown', function(){
			var control = $(this);
			var data = control.data();

			$('#buscar-id').val('');
			control.autocomplete({
					appendTo: 'body',
					minLength: 3,
					source: function(request, response){
						var data = { 'data': JSON.stringify({
									'buscar': $('.buscar-por:checked').val(),
									'texto': request.term
								})
							};

						$.ajax({
							url: site_url + 'muro/buscar',
							dataType: 'json',
							data: data,
							success: function(data){
								response(data);
							}
						});
					},
					response: function(e, ui) {
						if( ui.content.length == 0 ){
							var icon = 'fa-map-signs';
								if( $('.buscar-por:checked').val() == 'usuario' )
									icon = 'fa-user-friends';

							$('#buscar-texto').val('');
							$('#buscar-resultado-vacio').show();

							setTimeout(function() {
								$('#buscar-resultado-vacio').hide();
							}, 2000);
						}
					},
					select: function(e, ui){
						if( $('.buscar-por:checked').val() == 'usuario' )
							$('#buscar-id').val(ui.item['id']);
						else
							$('#buscar-id').val('');

						$('#buscar-texto').val(ui.item['value']);

					},
					change: function(e, ui){
						if( !ui.item &&
							$('.buscar-por:checked').val() == 'usuario'
						){
							$('#buscar-texto, #buscar-id').val('');
						}
					}
				});
			
		});

		$('#buscar').on('click', function(){
			Muro.oPendiente.publicacion_det = [];

			var fechas = $('#buscar-fechas').val().split(' - ');
			var idUsuario = null;
			var direccion = null;

			if( $('.buscar-por:checked').val() == 'usuario' )
				idUsuario = $('#buscar-id').val() ? $('#buscar-id').val() : null;
			else
				direccion = $('#buscar-texto').val() ? $('#buscar-texto').val() : null;

			var params = {
					index_min: 0,
					index_max: 10,
					fecha_ini: fechas[0] ? moment(fechas[0], 'DD/MM/YYYY').format('YYYY-MM-DD') : null,
					fecha_fin: fechas[1] ? moment(fechas[1], 'DD/MM/YYYY').format('YYYY-MM-DD') : null,
					idUsuario: idUsuario,
					direccion: direccion
				}

			// Muro.index_min = 0;
			// Muro.index_max = 10;

			Muro.anterior_publicaciones_cant = 0;
			Muro.oBuscar = $.extend(Muro.oBuscar, params);

			// Muro.conectar({ init: false });

			var html = '';
				html += '<div class="alert alert-info" role="alert" style="text-align:center;">';
					html += '<i class="fas fa-spinner fa-lg fa-spin mr-2"></i><label>Cargando publicaciones...</label>';
				html += '</div>';

			$('#content-publicacion-msg').html(html);
			$('#content-publicacion-msg').show();

			Muro.ws_publicacion_buscar();
			$('#content-publicacion').html('');

			// $.when( Muro.conectar({ init: false }) ).then(function(){
				// Muro.ws_publicacion_buscar();
				// $('#content-publicacion').html('');
			// });

		});

		$(document).on('click', '.btn-publicacion-foto-eliminar', function(e){
			e.preventDefault();
			$(this).parent().remove();
		});

		$(document).on('click', '.mostrar-comentarios', function(e){
			e.preventDefault();
			var idPublicacion = $(this).data('id');
			var content = $('#publicacion-comentarios-' + idPublicacion);

			if( content.html().length > 0 )
				content.empty();
			else
				Muro.socket_obtener_comentarios(idPublicacion);

		});

		$(document).on('click', '.realizar-comentario', function(e){
			e.preventDefault();
			var idPublicacion = $(this).data('idPublicacion');

			if( $('#publicacion-comentar-' + idPublicacion).html().length > 0 ){
				$('#publicacion-comentar-' + idPublicacion).empty();
			}
			else{
				// Muro.i++;
				var html = '';
					html += '<div class="col-lg-12">';
						html += '<div class="row ml-4 mt-2">';
							html += '<div class="col-lg-1 align-content-center text-center px-0">';
								if( Muro.usuario['idEmpleado'] ){
									html += '<img ';
										html += 'src="http://www.visualimpact.com.pe/intranet/files/empleado/' + Muro.usuario['fotoEmpleado'] + '" ';
										html += 'class="img-fluid rounded-circle" ';
										html += 'style="width: 30px; height: 30px;" ';
									html += '>';
								}
								else
									html += '<i class="fas fa-user-circle fa-2x" style="width: 30px; height: 30px; color: #ececec;"></i>';
							html += '</div>';
							html += '<div class="col-lg-7">';
								html += '<div class="form-group">';
									html += '<textarea id="descripcion-comentar-' + idPublicacion + '" class="comentario form-control"  placeholder="Escribe un comentario..." autocomplete="off"></textarea>';
									html += '<input type="file" id="file-publicacion-foto-' + idPublicacion + '" class="file-publicacion-foto hide" data-id-publicacion="' + idPublicacion + '" accept="image/jpeg">';
								html += '</div>';
							html += '</div>';
							html += '<div class="col-lg-4">';
								html += '<div class="form-group">';
									html += '<div class="d-flex justify-content-between">';
										html += '<button type="button" class="btn-publicacion-foto btn btn-link text-decoration-none" data-id-publicacion="' + idPublicacion + '">';
											html += '<i class="align-middle fas fa-camera-retro fa-2x"></i>';
											html += '<span class="align-middle ml-1">Fotos</span>';
										html += '</button>';
										html += '<button type="button" id="btn-enviar-comentar-' + idPublicacion + '" class="btn-enviar-comentar btn btn-link text-decoration-none" data-id-publicacion="' + idPublicacion + '">';
											html += '<i class="align-middle fa fa-send fa-lg"></i>';
											html += '<span class="align-middle ml-1">Publicar</span>';
										html += '</button>';
									html += '</div>';
								html += '</div>';
							html += '</div>';
						html += '</div>';
						html += '<div class="row">';
							html += '<div class="col-lg-8 offset-lg-2">';
								html += '<div id="listaFotos-' + idPublicacion + '"></div>';
							html += '</div>';
						html += '</div>';
					html += '</div>';

				$('#publicacion-comentar-'+idPublicacion).html(html);
			}
		});

		$(document).on('click', '.mostrar-sub-comentarios', function(e){
			e.preventDefault();
			var data = $(this).data();
			Muro.socket_obtener_sub_comentarios(data);
		});

		$(document).on('click', '.realizar-sub-comentario', function(e){
			e.preventDefault();
			var control = $(this);

			var idPublicacion = control.data('idPublicacion');
			var idComentario = control.data('idComentario');

			Muro.i++;
			var html = '';
				html += '<div class="col-lg-12">';
					html += '<div class="row ml-4 mt-2">';
						html += '<div class="col-lg-1 align-content-center text-center px-0">';
							if( Muro.usuario['idEmpleado'] ){
								html += '<img ';
									html += 'src="http://www.visualimpact.com.pe/intranet/files/empleado/' + Muro.usuario['fotoEmpleado'] + '" ';
									html += 'class="img-fluid rounded-circle" ';
									html += 'style="width: 30px; height: 30px;" ';
								html += '>';
							}
							else
								html += '<i class="fas fa-user-circle fa-2x" style="width: 30px; height: 30px; color: #ececec;"></i>';
						html += '</div>';
						html += '<div class="col-lg-11">';
							html += '<div class="form-group mb-0">';
								html += '<textarea id="descripcion-comentar-' + idPublicacion + '-' + idComentario + '" class="subcomentario form-control"  placeholder="Escribe un comentario..." autocomplete="off"></textarea>';
								html += '<input type="file" id="file-publicacion-foto-' + idPublicacion + '-' + idComentario + '" class="file-publicacion-foto hide" data-id-publicacion="' + idPublicacion + '" data-id-comentario="' + idComentario + '" accept="image/jpeg">';
							html += '</div>';
						html += '</div>';
						html += '<div class="col-lg-12">';
							html += '<div class="form-group">';
								html += '<div class="d-flex justify-content-end">';
									html += '<button type="button" class="btn-publicacion-foto btn btn-link text-decoration-none" data-id-publicacion="' + idPublicacion + '" data-id-comentario="' + idComentario + '">';
										html += '<i class="align-middle fas fa-camera-retro"></i>';
										html += '<span class="align-middle ml-1">Fotos</span>';
									html += '</button>';
									html += '<button type="button" class="btn-enviar-comentar btn btn-link text-decoration-none" data-id-publicacion="' + idPublicacion + '" data-id-comentario="' + idComentario + '">';
										html += '<i class="align-middle fa fa-send"></i>';
										html += '<span class="align-middle ml-1">Publicar</span>';
									html += '</button>';
								html += '</div>';
							html += '</div>';
						html += '</div>';
					html += '</div>';
					html += '<div class="row">';
						html += '<div class="col-lg-8 offset-lg-2">';
							html += '<div id="listaFotos-' + idPublicacion + '-' + idComentario + '"></div>';
						html += '</div>';
					html += '</div>';
				html += '</div>';

			$('#publicacion-comentar-' + idPublicacion + '-' + idComentario).html(html);
		});

		$(document).on('click', '.btn-enviar-comentar', function(evt){
			evt.preventDefault();
			var control = $(this);
			
			var id = '';
			var data = control.data();
			if( data['idPublicacion'] )
				id += data['idPublicacion'];
			if( data['idComentario'] )
				id += '-' + data['idComentario'];

			var comentario = $('#descripcion-comentar-' + id).val();

			if( !comentario.length ){
				$.notify(
					{ message: '<i class="far fa-tired fa-lg"></i> ¡Primero ingresa un comentario antes de publicar!'},
					{ type: 'danger', placement: { from: 'bottom', align: 'right' }
				});

				return false;
			}

			var data = {
					idPublicacion: data['idPublicacion'],
					idComentario: data['idComentario'] ? data['idComentario'] : null,
					descripcion: comentario,
					fotos: []
				};

				$('.img-publicacion-' + id).each(function(i, v){
					data['fotos'].push({
							idPublicacion: '',
							foto: $(v).attr('src')
						});
				});

			if( !data['idComentario'] )
				Muro.socket_guardar_publicacion_comentario(data);
			else
				Muro.socket_guardar_publicacion_sub_comentario(data);

			$('#publicacion-comentar-' + id).empty();
		});

		$(document).on('click', '.btn-calificar-publicacion', function(evt){
			evt.preventDefault();

			if(Muro.usuario!=null){
				var idPublicacion=$(this).attr('data-id');
				var data=[];
				data["idPublicacion"]=idPublicacion;
				data["estado"]=1;
				data["idUsuario"]=Muro.usuario['idUsuario'];
				Muro.socket_guardar_publicacion_calificacion(data);
			}
		});

		$(document).on('click', '.btn-publicacion-foto', function(e){
			e.preventDefault();
			var data = $(this).data();

			var id = '';
			if( data['idPublicacion'] ) id += data['idPublicacion'];
			if( data['idComentario'] ) id += '-' + data['idComentario'];

			$('#file-publicacion-foto-' + id).click();
		});

		$(document).on('change', '.file-publicacion-foto', function(e){
			var control = $(this);
			var file = control[0].files[0];

			var id = '';
			var data = control.data();
			if( data['idPublicacion'] ) id += data['idPublicacion'];
			if( data['idComentario'] ) id += '-' + data['idComentario'];

			if( !file ) return false;

			var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = function(er){
					var html='';
					html += '<div class="position-relative float-left text-center">';
						html += '<button type="button" class="btn-publicacion-foto-eliminar btn btn-sm btn-link position-absolute p-0 text-danger text-decoration-none" title="Borrar">';
							html += '<i class="fa fa-times-circle fa-2x"></i>';
						html += '</button>';
						html += '<img class="img-publicacion-' + id + '" height="50" src="' + er.target.result + '">';
						/* REVISAR */
					html += '</div>';

					$('#listaFotos-' + id).append(html);
					control.val('');
				};
		});

		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ){
			$('#btn-publicacion-load').on('click', function(e){
				Muro.ws_publicacion_cargar();
			});
		}
		else{
			$(window).on('scroll', function(e){
				var target = e.currentTarget,
					scrollTop = target.scrollTop || window.pageYOffset,
					scrollHeight = target.scrollHeight || document.body.scrollHeight;

				if( scrollHeight - scrollTop == $(target).innerHeight() ){
					Muro.ws_publicacion_cargar();
				}
			});
		}

		$('.keyupcount').on('keyup', function(){
			var control = $(this);
			var content = control.parent();

			var txtCount = '';
			if( content.hasClass('form-group') )
				txtCount = content.find('.txt-count');
			else if( content.hasClass('input-group') )
				txtCount = content.next('.txt-count');

			var txtCurrent = txtCount.find('.txt-current');

			var maxLength = control.attr('maxLength');
			var num = control.val().length;

			txtCurrent.text(num);
			if( num == parseInt(maxLength) ){
				txtCount.find('small').removeAttr('class');
				txtCount.find('small').css('color', '#ff0018');
			}
			else{
				txtCount.find('small').removeAttr('style');
				txtCount.find('small').addClass('text-secondary');
			}
		});


		//seleccionar idCuenta
		$(document).on('change', '#idCuenta', function(e){
			if($("#idCuenta").val()!=null){
				var idCuenta=$("#idCuenta").val();
				Muro.usuario['idCuenta']=idCuenta;
				Muro.oBuscar['idCuenta']=idCuenta;
				
				var html="<option value=''>--Seleccionar--</option>";
				if( Muro.usuario_filtro[idCuenta] !=null){
					Object.values(Muro.usuario_filtro[idCuenta]['proyectos']).forEach(function(v, i) {
						html+="<option value='"+v['idProyecto']+"'>"+v['proyecto']+"</option>";
					});
				}
				$("#idProyecto").html(html);
			}
		});


		//seleccionar idProyecto
		$(document).on('change', '#idProyecto', function(e){
			if($("#idProyecto").val()!=null){
				var idProyecto=$("#idProyecto").val();
				Muro.usuario['idProyecto']=idProyecto;
				Muro.oBuscar['idProyecto']=idProyecto;
				var idCuenta=Muro.usuario['idCuenta'];

				if(Muro.usuario_filtro[idCuenta]['proyectos'][idProyecto]!=null){
					Muro.usuario['idTipoUsuario']=Muro.usuario_filtro[idCuenta]['proyectos'][idProyecto]['idTipoUsuario'];
					Muro.usuario['tipoUsuario']=Muro.usuario_filtro[idCuenta]['proyectos'][idProyecto]['tipoUsuario'];
					Muro.socket_obtener_grupos();
				}
			}
		});

		//seleccionar grupo
		$(document).on('change', '#idGrupo', function(e){
			if($("#idGrupo").val()!=null){
				Muro.usuario['idGrupo']=$("#idGrupo").val();
				if(Muro.grupos!=null){
					Muro.grupos.forEach(function(v , i){
						if(v['idGrupo']==$("#idGrupo").val()){
							Muro.usuario['idCanal']=v['idCanal'];
							Muro.usuario['idGrupoCanal']=v['idGrupoCanal'];
							Muro.oBuscar['idCanal']=v['idCanal'];
							Muro.oBuscar['idGrupoCanal']=v['idGrupoCanal'];
							$('#content-publicacion').html("");
							Muro.index_min=0;
							Muro.index_max=10;
							Muro.conectar();
							return false;
						}
					});
				}
				
				
			}
			
		});


		

	},

	ws_conexiones: function(){
		if( !Muro.usuario ) return false;

		var oData = { accion: 'obtener_conexiones',
				idGrupo: Muro.usuario['idGrupo'],
				device: Muro.usuario['device']
			};

		var message = JSON.stringify(oData);
		Muro.ws.send(message);
		Muro.estado_cargando = true;
	},
	ws_publicacion_guardar( data = {} ){
		var oPublicacion = {
				idProyecto: Muro.usuario['idProyecto'] ? Muro.usuario['idProyecto'] : 2,
				idCuenta: Muro.usuario['idCuenta'] ? Muro.usuario['idCuenta'] : 3,
				idGrupoCanal: (Muro.usuario['idGrupoCanal']!=null) ? Muro.usuario['idGrupoCanal'] : null,
				idCanal: (Muro.usuario['idCanal']!=null) ? Muro.usuario['idCanal'] : null,
				estado: 1,
				idUsuario: Muro.usuario['idUsuario'],
				idEmpleado: Muro.usuario['idEmpleado'],
				nombre_usuario: Muro.usuario['usuario'],
				idTipoUsuario: Muro.usuario['idTipoUsuario'],
				tipoUsuario: Muro.usuario['tipoUsuario'],
				idVisita: '',
				fecha_p: data['fecha'],
				hora_p: data['hora'],
				titulo: data['titulo'],
				comentario: data['comentario']
			};

		var oData = { accion: 'guardar_publicacion',
				idGrupo: Muro.usuario['idGrupo'],
				device: Muro.usuario['device'],
				objeto: JSON.stringify([ oPublicacion ])
			};

		if( data['fotos'].length > 0 ){
			oData['detalle_foto'] = JSON.stringify(data['fotos']);
		}

		var message = JSON.stringify(oData);
		Muro.ws.send(message);
		Muro.estado_cargando = true;

		$.notify(
			{ message: '<i class="far fa-smile-wink fa-lg"></i> ¡Publicación realizada!' },
			{ type: 'success', placement: { from: 'bottom', align: 'right' }
		});

	},
	ws_publicacion_buscar(){
		var oData = { accion: 'buscar_publicaciones' },
			oData = $.extend(oData, Muro.oBuscar);

		var message = JSON.stringify(oData);
		Muro.ws.send(message);
		Muro.estado_cargando = true;

	},
	ws_publicacion_cargar(){
		if( !Muro.estado_cargando &&
			!Muro.estado_cargando_filas
		){
			if( !Muro.estado_max_filas ){
				Muro.oBuscar.index_min += 11;
				Muro.oBuscar.index_max += 10;

				Muro.ws_publicacion_buscar();
				Muro.estado_cargando_filas = true;

				// REVISAR
				setTimeout(function(){
					Muro.estado_cargando_filas = false;
					$('#content-publicacion-msg').hide().empty();
				}, 5000);
			}
			else{
				var html='';
					html += '<div class="alert alert-info" role="alert" style="text-align:center;">';
						html += '<i class="fas fa-exclamation-triangle fa-lg mr-2"></i><label>No hay mas resultados</label>';
					html += '</div>';

				$('#content-publicacion-msg').html(html);
				$('#content-publicacion-msg').show();
			}
		}
		else{
			var html = '';
				html += '<div class="alert alert-info" role="alert" style="text-align:center;">';
					html += '<i class="fas fa-spinner fa-lg fa-spin mr-2"></i><label>Cargando publicaciones...</label>';
				html += '</div>';

			$('#content-publicacion-msg').html(html);
			$('#content-publicacion-msg').show();
		}
	},

	socket_buscar_publicacion: function(idPublicacion){
		var formato_json= {};
		formato_json['accion']="buscar_publicacion";
		formato_json['idPublicacion']=idPublicacion;
		var message=JSON.stringify(formato_json);
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_buscar_publicacion_calificacion: function(idPublicacion){
		var formato_json= {};
		formato_json['accion']="buscar_publicacion_calificacion";
		formato_json['idPublicacion']=idPublicacion;
		var message=JSON.stringify(formato_json);
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_buscar_publicacion_cant_comentarios: function(idPublicacion){
		var formato_json= {};
		formato_json['accion']="buscar_publicacion_cant_comentarios";
		formato_json['idPublicacion']=idPublicacion;
		var message=JSON.stringify(formato_json);
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_obtener_conexiones: function(){
		if( !Muro.usuario ) return false;

		var oData = { accion: 'obtener_conexiones',
				idGrupo: Muro.usuario['idGrupo'],
				device: Muro.usuario['device']
			}

		var message = JSON.stringify(oData);
		Muro.ws.send(message);
		Muro.estado_cargando = true;
	},
	socket_obtener_publicaciones: function(){
		if( Muro.usuario ){
			var formato_json = {};
			formato_json['accion'] = "obtener_publicaciones";
			formato_json['idGrupo'] = Muro.usuario['idGrupo'];
			formato_json['device'] = Muro.usuario['device'];
			formato_json['idGrupoCanal'] = Muro.usuario['idGrupoCanal'];
			formato_json['idCanal'] = Muro.usuario['idCanal'];
			formato_json['index_min'] = Muro.index_min;
			formato_json['index_max'] = Muro.index_max;

			// formato_json['fecIni'] = Muro.params.fecIni;
			// formato_json['fecFin'] = Muro.params.fecFin;
			// formato_json['idUsuario'] = Muro.params.idUsuario;
			// formato_json['direccion'] = Muro.params.direccion;

			if( Muro.usuario['idProyecto'] ){
				formato_json['idProyecto']=Muro.usuario['idProyecto'];
			}
			else{
				formato_json['idProyecto']="2";
			}

			if( Muro.usuario['idCuenta'] ){
				formato_json['idCuenta']=Muro.usuario['idCuenta'];
			}
			else{
				formato_json['idCuenta']="3";
			}

			var message = JSON.stringify(formato_json);
			Muro.ws.send(message);
			Muro.estado_cargando = true;
		}
	},
	socket_obtener_publicaciones_det: function(idPublicacion){
		var formato_json= {};
		formato_json['accion']="obtener_publicacion_det";
		formato_json['idPublicacion']=idPublicacion;

		var message=JSON.stringify(formato_json);
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_obtener_comentarios: function(idPublicacion){
		if(Muro.usuario!=null){
			var formato_json= {};
			formato_json['accion']="obtener_publicacion_comentario";
			formato_json['idPublicacion'] = idPublicacion;
			formato_json['idComentario'] = '';
			formato_json['idUsuario']=Muro.usuario['idUsuario'];
			var message=JSON.stringify(formato_json);
		}
		Muro.ws.send(message);
		Muro.estado_cargando = true;
	},
	socket_obtener_comentarios_det: function(idPublicacion, idComentario){
		var oData = {
				'accion': 'obtener_comentario_det',
				'idPublicacion': idPublicacion,
				'idComentario': idComentario
			};

		var message = JSON.stringify(oData);
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_obtener_sub_comentarios: function(data = {}){
		var oData = {
				'accion': 'obtener_publicacion_subcomentario',
				'idPublicacion': data['idPublicacion'],
				'idComentario': data['idComentario'],
				'idUsuario': Muro.usuario['idUsuario']
			};

		var message = JSON.stringify(oData);
		Muro.ws.send(message);
		Muro.estado_cargando = true;
	},
	socket_guardar_estado: function(estado){
		if( !Muro.usuario ) return false;

		var data = {
				accion: 'guardar_usuario_configuracion',
				idGrupo: Muro.usuario['idGrupo'],
				device: Muro.usuario['device'],
				idUsuario: Muro.usuario['idUsuario'],
				estado_usuario: estado,
				objeto: JSON.stringify([{
						idUsuario: Muro.usuario['idUsuario'],
						estado_usuario: estado
					}])
			};

		var message = JSON.stringify(data);
		Muro.ws.send(message);
		Muro.estado_cargando = true;

	},
	socket_guardar_publicacion: function(data,data_foto){
		if(Muro.usuario!=null){
			var formato_json= {};
			formato_json['accion']="guardar_publicacion";
			formato_json['idGrupo']=Muro.usuario['idGrupo'];
			formato_json['device'] = Muro.usuario['device'];
			
			
			var objeto=[];
			var arr_objeto={};
			arr_objeto['titulo']=data['titulo'];
			arr_objeto['comentario']=data['comentario'];
			var dat=new Date();
			arr_objeto['fecha_p']=dat.getFullYear()+"-"+(dat.getMonth()+1)+"-"+dat.getDate()

			arr_objeto['hora_p']=dat.getHours() + ':' + dat.getMinutes() + ':' + dat.getSeconds();

			if(Muro.usuario['idProyecto']!=null){
				arr_objeto['idProyecto']=Muro.usuario['idProyecto'];
			}else{
				arr_objeto['idProyecto']="2";
			}

			if(Muro.usuario['idCuenta']!=null){
				arr_objeto['idCuenta']=Muro.usuario['idCuenta'];
			}else{
				arr_objeto['idCuenta']="3";
			}

			if(Muro.usuario['idGrupoCanal']!=null){
				arr_objeto['idGrupoCanal']=Muro.usuario['idGrupoCanal'];
			}
			if(Muro.usuario['idCanal']!=null){
				arr_objeto['idCanal']=Muro.usuario['idCanal'];
			}

			arr_objeto['estado']="1";
			arr_objeto['idUsuario']=Muro.usuario['idUsuario'];
			arr_objeto['idEmpleado']=Muro.usuario['idEmpleado'];
			arr_objeto['nombre_usuario']=Muro.usuario['usuario'];
			arr_objeto['idTipoUsuario']=Muro.usuario['idTipoUsuario'];
			arr_objeto['tipoUsuario']=Muro.usuario['tipoUsuario'];

			arr_objeto['idVisita']="";
			arr_objeto['idGrupoCanal']="";
			arr_objeto['idCanal']="";

			objeto.push(arr_objeto);
			formato_json['objeto']=JSON.stringify(objeto);

			if(data_foto!=null){
				formato_json['detalle_foto']=JSON.stringify(data_foto);
			}
			var message=JSON.stringify(formato_json);
		}
		Muro.ws.send(message);
		Muro.estado_cargando=true;

		$.notify({
			// options
			message: '<i class="far fa-smile-wink fa-lg"></i> ¡Publicación realizada!' 
		},{
			// settings
			type: 'success',
			placement: {
				from: "bottom",
				align: "right"
			},
		});

	},
	socket_guardar_publicacion_calificacion: function(data){
		var formato_json= {};
		formato_json['accion']="guardar_publicacion_det_atributo";
		formato_json['idGrupo']=Muro.usuario['idGrupo'];
		formato_json['device'] = Muro.usuario['device'];

		var objeto=[];
			var arr_objeto={};
			arr_objeto['idPublicacion']=data['idPublicacion'];
			arr_objeto['idUsuario']=data['idUsuario'];
			arr_objeto['estado']=data['estado'];
			objeto.push(arr_objeto);
		formato_json['objeto']=JSON.stringify(objeto);
		
		var message=JSON.stringify(formato_json);
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_guardar_publicacion_comentario: function(data){
		if(Muro.usuario!=null){
			var formato_json= {};
			formato_json['accion']="guardar_publicacion_comentario";
			formato_json['idGrupo']=Muro.usuario['idGrupo'];
			formato_json['device'] = Muro.usuario['device'];
			
			var objeto=[];
			var arr_objeto={};
			arr_objeto['idPublicacion']=data['idPublicacion'];
			arr_objeto['descripcion']=data['descripcion'];
			arr_objeto['idComentarioRef']="";
			var dat=new Date();
			arr_objeto['fecha_p']=dat.getFullYear()+"-"+(dat.getMonth()+1)+"-"+dat.getDate()

			arr_objeto['hora_p']=dat.getHours() + ':' + dat.getMinutes() + ':' + dat.getSeconds();
			arr_objeto['estado']="1";
			arr_objeto['idUsuario']=Muro.usuario['idUsuario'];
			arr_objeto['idEmpleado']=Muro.usuario['idEmpleado'];
			arr_objeto['nombre_usuario']=Muro.usuario['usuario'];
			arr_objeto['idTipoUsuario']=Muro.usuario['idTipoUsuario'];
			arr_objeto['tipoUsuario']=Muro.usuario['tipoUsuario'];
			arr_objeto['estado_visibilidad']="true";

			objeto.push(arr_objeto);
			formato_json['objeto']=JSON.stringify(objeto);

			if( data['fotos'] ){
				formato_json['detalle_foto'] = JSON.stringify(data['fotos']);
			}

			var message=JSON.stringify(formato_json);
		}
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_guardar_publicacion_sub_comentario: function(data){
		if(Muro.usuario!=null){
			var formato_json= {};
			formato_json['accion']="guardar_publicacion_comentario";
			formato_json['idGrupo']=Muro.usuario['idGrupo'];
			formato_json['device'] = Muro.usuario['device'];
			
			var objeto=[];
			var arr_objeto={};
			arr_objeto['idPublicacion']=data['idPublicacion'];
			arr_objeto['descripcion']=data['descripcion'];
			arr_objeto['idComentarioRef'] = data['idComentario'];
			var dat=new Date();
			arr_objeto['fecha_p']=dat.getFullYear()+"-"+(dat.getMonth()+1)+"-"+dat.getDate()

			arr_objeto['hora_p']=dat.getHours() + ':' + dat.getMinutes() + ':' + dat.getSeconds();
			arr_objeto['estado']="1";
			arr_objeto['idUsuario']=Muro.usuario['idUsuario'];
			arr_objeto['idEmpleado']=Muro.usuario['idEmpleado'];
			arr_objeto['nombre_usuario']=Muro.usuario['usuario'];
			arr_objeto['idTipoUsuario']=Muro.usuario['idTipoUsuario'];
			arr_objeto['tipoUsuario']=Muro.usuario['tipoUsuario'];
			arr_objeto['estado_visibilidad']="true";

			objeto.push(arr_objeto);
			formato_json['objeto']=JSON.stringify(objeto);

			if( data['fotos'] ){
				formato_json['detalle_foto'] = JSON.stringify(data['fotos']);
			}

			var message=JSON.stringify(formato_json);
		}
		Muro.ws.send(message);
		Muro.estado_cargando=true;
	},
	socket_obtener_grupos: function(){
		var formato_json= {};
		
		if(Muro.usuario!=null){
			formato_json['accion']="obtener_grupos";
			formato_json['idCuenta']=Muro.usuario['idCuenta'];
			formato_json['idProyecto']=Muro.usuario['idProyecto'];
			formato_json['idUsuario']=Muro.usuario['idUsuario'];
			formato_json['idTipoUsuario']=Muro.usuario['idTipoUsuario'];
			formato_json['idGrupoCanal']=Muro.usuario['idGrupoCanal'];
			formato_json['idCanal']=Muro.usuario['idCanal'];
			
	
			var message=JSON.stringify(formato_json);
			Muro.ws.send(message);
			Muro.estado_cargando=true;
		}

		
	},

	mostrar_publicaciones: function(data,nuevo){
		var html="";
		var idPublicacion=null;
		data.forEach(function(v, i) {
			idPublicacion=v['idPublicacion'];
			var fecha_=v['fecha_p'];
			var fecha="";
			if(fecha_!=null){
				var fecha_array=fecha_.split("-");
				fecha= fecha_array[2]+"/"+fecha_array[1]+"/"+fecha_array[0];
			}

			var dat=new Date();
			var fecha_actual=(dat.getDate()<10? "0"+dat.getDate() : dat.getDate())+"/"+(dat.getMonth()+1)+"/"+dat.getFullYear();

			var hora_=v['hora_p'];
			var hora="";
		
			var campo_trans="";
			if(hora_!=null){
				hora=hora_.substring(0,8);
				var minutos_trans="";
				var horas_trans="";
				var dias_trans="";
				var d = new Date();
				var date_act = new Date();
				var hora_s=hora_.split(":")

				var fecha_array=fecha_.split("-");
				d.setDate(fecha_array[2]);
				d.setMonth(fecha_array[1]-1);
				d.setFullYear(fecha_array[0]);
				
				d.setHours(hora_s[0]);
				d.setMinutes(hora_s[1]);
				d.setSeconds(hora_s[2]);

				var res=date_act.getTime()-d.getTime();
				minutos_trans=Math.round(res/ (1000*60));
				horas_trans=Math.round(res/ (1000*60*60));
				dias_trans=Math.round(res/ (1000*60*60*24));
					
				if(fecha_actual==fecha){
					if(minutos_trans>59){
						campo_trans="Hace "+horas_trans+" hora(s)";
					}else{
						campo_trans="Hace "+minutos_trans+" minuto(s)";
					}
				}else{
					campo_trans="Hace "+dias_trans+" dias"
				}
			}

			html += '<div class="col-lg-12">';
				html += '<div class="card mb-3">';
					// html += '<div class="card-head bg-primary-gradient p-1"></div>';
					html += '<div class="card-body">';
						html += '<div class="row">';
							html += '<div class="col-md-2 align-content-center text-center">';
								if( v['fotoEmpleado'] ){
									html += '<img ';
										html += 'src="http://www.visualimpact.com.pe/intranet/files/empleado/' + v['fotoEmpleado'] + '" ';
										html += 'class="img-fluid rounded-circle" ';
										html += 'style="width: 50px; height: 50px;" ';
									html += '>';
								}
								else
									html += '<i class="fas fa-user-circle fa-3x" style="width: 50px; height: 50px; color: #ececec;"></i>';
							html += '</div>';

							html += '<div class="col-md-10 pl-lg-0">';
								html += '<div class="row">';
									html += '<div class="col-md-12 pl-lg-0">';
										html += '<span>' + v['nombre_usuario'] + '</span>';
										if( v['tipoUsuario'] && v['tipoUsuario'].length > 0 ){
											html += '<span> - ' + v['tipoUsuario'] + '</span>';
										}
									html += '</div>';
									html += '<div class="col-md-12 pl-lg-0">';
										html += '<small class="text-muted" title="' + fecha + ' ' + hora + '">' + campo_trans + '</small>';
									html += '</div>';
									if( v['lat'] && v['lon'] ){
										html += '<div class="col-md-12 pl-lg-0">';
											var map = 'https://www.google.com/maps/?q=' + v['lat'] + ',' + v['lon'];
											html += '<small class="text-muted"><a href="' + map + '" target="blank_" ><i class="fas fa-map-marker-alt fa-lg"></i> ' + v['direccionExt'] + '</a></small>';
										html += '</div>';
									}
								html += '</div>';
							html += '</div>';
						html += '</div>';
						html += '<div class="row">';
							html += '<div class="col-md-12">';
								html += '<div class="mt-4 mb-2">';
									if( v['titulo'] && v['titulo'].length > 0 )
										html += '<label class="h5 m-0">' + v['titulo'] + '</label>';
									if( v['comentario'] && v['comentario'].length > 0 )
										html += '<p>' + v['comentario'] + '</p>';
								html += '</div>';
							html += '</div>';
							html += '<div class="col-md-12">';
								html += '<div id="publicacion-det-'+v['idPublicacion']+'">';
									if( v['fotos'] ){
										html += '<div class="text-center">';
											html += '<span class="spinner-grow spinner-grow-sm text-primary" role="status" aria-hidden="true"></span>';
											html += '<span class="small ml-1">Cargando ' + v['fotos'] + ' ' + ( parseInt(v['fotos']) > 1 ? 'fotos' : 'foto') + '</span>';
										html += '</div>';
									}
								html += '</div>';
							html += '</div>';
						html += '</div>';
						html += '<div class="row">';
							html += '<div class="col-md-12">';
								html += '<hr>';
								html += '<div class="form-group">';
									html += '<div class="d-flex justify-content-between">';
										html += '<button type="button" id="calificar-publicacion-' + v['idPublicacion'] + '" data-id="' + v['idPublicacion'] + '" class="btn-calificar-publicacion btn btn-link text-decoration-none" title="Me gusta">';
											html += '<i class="align-middle far fa-thumbs-up fa-2x"></i>';
											html += '<span class="align-middle ml-1">' + ( v['calificacion'] ? v['calificacion'] : 0 ) + '</span>';
										html += '</button>';
										html += '<button type="button" id="mostrar-comentarios-' + v['idPublicacion'] + '" data-id="' + v['idPublicacion'] + '" class="mostrar-comentarios btn btn-link text-decoration-none" title="Comentarios">';
											html += '<i class="align-middle far fa-comment-alt fa-2x"></i>';
											html += '<span class="align-middle ml-1">' + ( v['comentarios'] ? v['comentarios'] : 0 ) + '</span>';
											// html += '<span class="align-middle ml-1">Comentarios</span>';
										html += '</button>';
										html += '<button type="button" class="realizar-comentario btn btn-link text-decoration-none" data-id-publicacion="' + v['idPublicacion'] + '"  title="Comentar">';
											html += '<i class="align-middle far fa-keyboard fa-2x"></i>';
											// html += '<span class="align-middle ml-1">Escribir</span>';
										html += '</button>';
									html += '</div>';
								html += '</div>';
							html += '</div>';
						html += '</div>';
						html += '<div class="row" id="publicacion-comentar-' + v['idPublicacion'] + '"></div>';
						html += '<div class="row" id="publicacion-comentarios-' + v['idPublicacion'] + '"></div>';
					html += '</div>';
				html += '</div>';
			html += '</div>';

			if( v['fotos'] ){
				Muro.oPendiente.publicacion_det.push(idPublicacion);
				// Muro.socket_obtener_publicaciones_det(v['idPublicacion']);
			}
		});
		Muro.estado_cargando=false;
		if(nuevo==true){
			$('#content-publicacion').prepend(html);
			setTimeout(function(){ 
				Muro.estado_cargando_filas=false; 
				$('#label-nuevo-publicacion-'+idPublicacion).remove();
			}, 30000);
		}else{
			$('#content-publicacion').append(html);
		}

		$.when.apply($, Muro.oPendiente.publicacion_det).then(function(){
			// Muro.ejecutar();
			if( !Muro.ws_procesando ) Muro.ws_ejecutar();
		});
	},
	mostrar_publicaciones_det : function(data){
		// if( !data.length ) return false;

		var aImages = [];
		var idPublicacion = data[0]['idPublicacion'];

		data.forEach(function(v, i){
			aImages.push('data:image/jpg;base64,' + v['foto']);
		});

		var cell = Muro.img_grid;
		$('#publicacion-det-' + idPublicacion).imagesGrid({
			images: aImages,
			align: true,
			cells: cell,
			loading: 'Cargando',
			getViewAllText: function(imgsCount){ return '+ ' + (imgsCount - cell).toString() },
			onModalOpen: function(){ $('body').addClass('overflow-hidden') },
			onModalClose: function(){ $('body').removeClass('overflow-hidden') }
		});

		Muro.estado_cargando = false;
	},
	mostrar_comentario_publicacion : function(data){
		var html="";
		var idPublicacion = "";
		var idComentario = "";

		data.forEach(function(v, i) {
			if( v['idComentarioRef'] ) return;

			idPublicacion=v['idPublicacion'];
			idComentario=v['idComentario'];
			var fecha_=v['fecha_p'];
			var fecha_array=fecha_.split("-");
			var fecha= fecha_array[2]+"/"+fecha_array[1]+"/"+fecha_array[0];
			
			var hora_=v['hora_p'];
			var hora="";
			if(hora_!=null){
				hora=hora_.substring(0,8);
			}


			var fecha_=v['fecha_p'];
			var fecha="";
			if(fecha_!=null){
				var fecha_array=fecha_.split("-");
				fecha= fecha_array[2]+"/"+fecha_array[1]+"/"+fecha_array[0];
			}

			var dat=new Date();
			var fecha_actual=(dat.getDate()<10? "0"+dat.getDate() : dat.getDate())+"/"+(dat.getMonth()+1)+"/"+dat.getFullYear();

			var hora_=v['hora_p'];
			var hora="";
		
			var campo_trans="";
			if(hora_!=null){
				hora=hora_.substring(0,8);
				var minutos_trans="";
				var horas_trans="";
				var dias_trans="";
				var d = new Date();
				var date_act = new Date();
				var hora_s=hora_.split(":")

				var fecha_array=fecha_.split("-");
				d.setDate(fecha_array[2]);
				d.setMonth(fecha_array[1]-1);
				d.setFullYear(fecha_array[0]);
				
				d.setHours(hora_s[0]);
				d.setMinutes(hora_s[1]);
				d.setSeconds(hora_s[2]);

				var res=date_act.getTime()-d.getTime();
				minutos_trans=Math.round(res/ (1000*60));
				horas_trans=Math.round(res/ (1000*60*60));
				dias_trans=Math.round(res/ (1000*60*60*24));
					
				if(fecha_actual==fecha){
					if(minutos_trans>59){
						campo_trans="Hace "+horas_trans+" hora(s)";
					}else{
						campo_trans="Hace "+minutos_trans+" minuto(s)";
					}
				}else{
					campo_trans="Hace "+dias_trans+" dias"
				}
			}

			html += '<div class="col-lg-12">';
				html += '<div class="row ml-4 mt-2">';
					html += '<div class="col-lg-1 align-content-center text-center px-0">';
						if( v['fotoEmpleado'] ){
							html += '<img ';
								html += 'src="http://www.visualimpact.com.pe/intranet/files/empleado/' + v['fotoEmpleado'] + '" ';
								html += 'class="img-fluid rounded-circle" ';
								html += 'style="width: 30px; height: 30px;" ';
							html += '>';
						}
						else
							html += '<i class="fas fa-user-circle fa-2x" style="width: 30px; height: 30px; color: #ececec;"></i>';
					html += '</div>';
					html += '<div class="col-lg-11">';
						html += '<div class="form-group comentario">';
							html += '<p class="font-weight-bold mb-0">' + v['nombre_usuario'] + ' - <small>' + campo_trans + '</small></p>';
							if( v['descripcion'] ){
								html += '<p>' + v['descripcion'] + '</p>';
							}
							html += '<div id="publicacion-comentario-' + v['idComentario'] + '" class="comentario-fotos">';
								if( v['fotos'] ){
									html += '<div class="text-center">';
										html += '<span class="spinner-grow spinner-grow-sm text-primary" role="status" aria-hidden="true"></span>';
										html += '<span class="small ml-1">Cargando ' + v['fotos'] + ' ' + ( parseInt(v['fotos']) > 1 ? 'fotos' : 'foto') + '</span>';
									html += '</div>';
								}
							html += '</div>';
							html += '<div class="col-lg-12 mt-3 px-0 text-right">';
								html += '<button type="button" id="mostrar-sub-comentarios-'+ idPublicacion +'-'+ idComentario +'" class="mostrar-sub-comentarios btn btn-link" data-id-publicacion="' + v['idPublicacion'] + '" data-id-comentario="' + v['idComentario'] + '">';
									html += '<i class="align-middle far fa-comment-alt"></i> Comentarios' + ( v['comentarios'] ? ' ' + v['comentarios'] : '' );
								html += '</button>';
								html += '<button type="button" class="realizar-sub-comentario btn btn-link" data-id-publicacion="' + v['idPublicacion'] + '" data-id-comentario="' + v['idComentario'] + '">';
									html += '<i class="align-middle far fa-keyboard"></i> Responder';
								html += '</button>';
							html += '</div>';
							html += '<div id="publicacion-comentar-' + v['idPublicacion'] + '-' + v['idComentario'] + '"></div>';
							html += '<div id="publicacion-comentarios-' + v['idPublicacion'] + '-' + v['idComentario'] + '"></div>';
						html += '</div>';
					html += '</div>';
				html += '</div>';
			html += '</div>';

			if( v['fotos'] ){
				Muro.socket_obtener_comentarios_det(v['idPublicacion'], v['idComentario']);
			}
		});

		Muro.estado_cargando=false;
		$('#publicacion-comentarios-'+idPublicacion).html(html);
	},
	mostrar_comentario_publicacion_det : function(data){
		// if( !data.length ) return false;

		var aImages = [];
		var idComentario = data[0]['idComentario'];

		data.forEach(function(v, i){
			aImages.push('data:image/jpg;base64,' + v['foto']);
		});

		var cell = Muro.img_grid;
		$('#publicacion-comentario-' + idComentario).imagesGrid({
			images: aImages,
			align: true,
			cells: cell,
			loading: 'Cargando',
			getViewAllText: function(imgsCount){ return '+ ' + (imgsCount - cell).toString() },
			onModalOpen: function(){ $('body').addClass('overflow-hidden') },
			onModalClose: function(){ $('body').removeClass('overflow-hidden') }
		});

		Muro.estado_cargando = false;

	},

	mostrar_subcomentario_publicacion: function(data){
		var html = "";
		var idPublicacion = "";
		var idComentario = "";
		var idComentarioRef = "";

		var numComentarios = 0;
		data.forEach(function(v, i){
			idPublicacion = v['idPublicacion'];
			idComentario = v['idComentario'];
			idComentarioRef = v['idComentarioRef'];

			var fecha_=v['fecha_p'];
			var fecha_array=fecha_.split("-");
			var fecha= fecha_array[2]+"/"+fecha_array[1]+"/"+fecha_array[0];
			
			var hora_=v['hora_p'];
			var hora="";
			if(hora_!=null){
				hora=hora_.substring(0,8);
			}


			var fecha_=v['fecha_p'];
			var fecha="";
			if(fecha_!=null){
				var fecha_array=fecha_.split("-");
				fecha= fecha_array[2]+"/"+fecha_array[1]+"/"+fecha_array[0];
			}

			var dat=new Date();
			var fecha_actual=(dat.getDate()<10? "0"+dat.getDate() : dat.getDate())+"/"+(dat.getMonth()+1)+"/"+dat.getFullYear();

			var hora_=v['hora_p'];
			var hora="";
		
			var campo_trans="";
			if(hora_!=null){
				hora=hora_.substring(0,8);
				var minutos_trans="";
				var horas_trans="";
				var dias_trans="";
				var d = new Date();
				var date_act = new Date();
				var hora_s=hora_.split(":")

				var fecha_array=fecha_.split("-");
				d.setDate(fecha_array[2]);
				d.setMonth(fecha_array[1]-1);
				d.setFullYear(fecha_array[0]);
				
				d.setHours(hora_s[0]);
				d.setMinutes(hora_s[1]);
				d.setSeconds(hora_s[2]);

				var res=date_act.getTime()-d.getTime();
				minutos_trans=Math.round(res/ (1000*60));
				horas_trans=Math.round(res/ (1000*60*60));
				dias_trans=Math.round(res/ (1000*60*60*24));
					
				if(fecha_actual==fecha){
					if(minutos_trans>59){
						campo_trans="Hace "+horas_trans+" hora(s)";
					}else{
						campo_trans="Hace "+minutos_trans+" minuto(s)";
					}
				}else{
					campo_trans="Hace "+dias_trans+" dias"
				}
			}

			html += '<div class="col-lg-12">';
				html += '<div class="row ml-4 mt-2">';
					html += '<div class="col-lg-1 align-content-center text-center px-0">';
						if( v['fotoEmpleado'] ){
							html += '<img ';
								html += 'src="http://www.visualimpact.com.pe/intranet/files/empleado/' + v['fotoEmpleado'] + '" ';
								html += 'class="img-fluid rounded-circle" ';
								html += 'style="width: 30px; height: 30px;" ';
							html += '>';
						}
						else
							html += '<i class="fas fa-user-circle fa-2x" style="width: 30px; height: 30px; color: #ececec;"></i>';
					html += '</div>';
					html += '<div class="col-lg-11">';
						html += '<div class="form-group comentario">';
							html += '<p class="font-weight-bold mb-0">' + v['nombre_usuario'] + ' - <small>' + campo_trans + '</small></p>';
							if( v['descripcion'] ){
								html += '<p>' + v['descripcion'] + '</p>';
							}
							html += '<div id="publicacion-comentario-' + v['idComentario'] + '" class="comentario-fotos">';
								if( v['fotos'] ){
									html += '<div class="text-center">';
										html += '<span class="spinner-grow spinner-grow-sm text-primary" role="status" aria-hidden="true"></span>';
										html += '<span class="small ml-1">Cargando ' + v['fotos'] + ' ' + ( parseInt(v['fotos']) > 1 ? 'fotos' : 'foto') + '</span>';
									html += '</div>';
								}
							html += '</div>';
						html += '</div>';
					html += '</div>';
				html += '</div>';
			html += '</div>';

			if( v['fotos'] ){
				Muro.socket_obtener_comentarios_det(idPublicacion, idComentario);
			}

			numComentarios++;
		});

		Muro.estado_cargando=false;
		
		$('#publicacion-comentarios-' + idPublicacion + '-' + idComentarioRef).html(html);
		$('#publicacion-comentarios-' + idPublicacion + '-' + idComentarioRef).html(html);

		var htmlNumComentarios = '<i class="align-middle far fa-comment-alt"></i> Comentarios' + ( numComentarios ? ' ' + numComentarios : '' );
		$('#mostrar-sub-comentarios-' + idPublicacion + '-' + idComentarioRef).html(htmlNumComentarios);
	},
	mostrar_conexiones: function(data = {}){
		var iconWeb = '<i class="fab fa-chrome" title="Navegador"></i>';
		var iconMobile = '<i class="fas fa-mobile-alt" title="Aplicación"></i>';

		var oUsuarios = {};
		if( Fn.obj_count(data['web_conexiones']) ){
			$.each(data['web_conexiones'], function(iw, vw){
				if( $.type(oUsuarios[iw]) != 'object' ){
					oUsuarios[iw] = { usuario: '', estado: '', device: '' };
				}

				oUsuarios[iw]['usuario'] = vw['usuario'];
				oUsuarios[iw]['estado'] = vw['estado'];
				oUsuarios[iw]['device'] = oUsuarios[iw]['device'] ? oUsuarios[iw]['device'] + ' ' + iconWeb : iconWeb;
			});
		}

		if( Fn.obj_count(data['movil_conexiones']) ){
			$.each(data['movil_conexiones'], function(im, vm){
				if( $.type(oUsuarios[im]) != 'object' ){
					oUsuarios[im] = { usuario: '', estado: '', device: '' };
				}

				oUsuarios[im]['usuario'] = vm['usuario'];
				oUsuarios[im]['estado'] = vm['estado'];
				oUsuarios[im]['device'] = oUsuarios[im]['device'] ? oUsuarios[im]['device'] + ' ' + iconMobile : iconMobile;
			});
		}

		var html = '';
			html += '<ul class="list-group list-group-flush" style="overflow-y: auto; height: 35vh;">';
				if( Fn.obj_count(oUsuarios) ){
					$.each(oUsuarios, function(idUsuario, v){
						html += '<li class="list-group-item">';
							html += '<p class="mb-0"><i class="far fa-user"></i> ' + v['usuario'] + '</p>';
							var txtMuted = v['estado'] ? 'text-muted' : 'text-muted-2';
							html += '<span class="'+ txtMuted +' ml-2 font-italic">' + v['device'] + ' ' + ( v['estado'] ? v['estado'] : 'Sin estado' ) + '</span>';
						html += '</li>';
					});
				}
				else{
					html += '<li class="list-group-item"><i class="fa fa-user-slash"></i><label class="ml-1">No hay usuarios conectados</li>';
				}
			html += '</ul>';

		$('#card-muro-usuarios').html(html);
		Muro.estado_cargando = false;
	},
	actualizar_publicacion_calificacion : function(data){
		var html="";
		data.forEach(function(v, i) {
			var idPublicacion=v['idPublicacion'];
			html += '<i class="align-middle far fa-thumbs-up fa-2x"></i>';
			html += '<span class="align-middle ml-1">' + ( v['calificacion'] ? v['calificacion'] : 0 ) + '</span>';
			$('#calificar-publicacion-'+idPublicacion).html(html);
		});
		Muro.estado_cargando=false;		
	},
	actualizar_publicacion_cant_comentario : function(data){
		var html="";
		var idPublicacion=null;
		data.forEach(function(v, i) {
			idPublicacion=v['idPublicacion'];
			// html='&nbsp;'+( (v['comentarios']!=null)? v['comentarios'] : 0 )+' Comentario(s) <i class="fas fa-comment-alt notification"> </i> <span class="badge badge-pill badge-info" id="label-nuevo-comentario-'+idPublicacion+'">Nuevo</span>';

			if( v['comentarios'] ){
				html += '<i class="align-middle far fa-comment-alt fa-2x"></i>';
				html += '<span class="align-middle ml-1">' + ( v['comentarios'] ? v['comentarios'] : 0 ) + '</span>';
				// html += '<span class="align-middle ml-1">Comentarios';
					html += '<sup id="label-nuevo-comentario-' + idPublicacion + '" class="text-warning">* Nuevo</sup>'
				html += '</span>';
			}

			$('#mostrar-comentarios-'+idPublicacion).html(html);
		});

		setTimeout(function(){ 
			Muro.estado_cargando_filas=false; 
			$('#label-nuevo-comentario-'+idPublicacion).remove();
		}, 10000);
		Muro.estado_cargando=false;
	},
	mostrar_grupos : function(data){
		var html="<option value=''>--Seleccionar--</option>";
		if( data.length != 0 ){

			Muro.grupos=data;
			data.forEach(function(v, i){
				html+="<option value='"+v['idGrupo']+"'>"+v['nombre']+"</option>";
			});
		}
		$("#idGrupo").html(html);
		Muro.estado_cargando = false;
	},

}
Muro.load();
