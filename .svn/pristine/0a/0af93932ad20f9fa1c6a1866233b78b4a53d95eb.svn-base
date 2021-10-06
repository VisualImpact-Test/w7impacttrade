var Usuarios = {

    secciones: ['Usuarios','Usuarios'],
    tabSeleccionado: '',
    customDataTable: function () { },
	
	datatipoDocumento: [],
	dataProyecto: [],
	dataTipoUsuario: [],
	dataAplicacion: [],

    load: function () {

        $(document).ready(function (e) {
            Usuarios.eventos();
            Gestion.urlActivo = 'configuraciones/administracion/Usuarios/';
            $(".card-body > ul > li > a[class*='active']").click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Usuarios.tabSeleccionado = Usuarios.secciones[indiceSeccion];

            Usuarios.cambiarSeccionActivo();
            // Gestion.idContentActivo = 'content' + Usuarios.tabSeleccionado;
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if (typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Usuarios.customDataTable;
            Gestion.seccionActivo = Usuarios.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Usuarios.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Usuarios.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Usuarios.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Usuarios.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Usuarios.tabSeleccionado
            Gestion.getFormActualizacionMasivaActivo = 'getFormActualizacionMasivaPermisos' + Usuarios.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Usuarios.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Usuarios.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Usuarios.tabSeleccionado
            Gestion.funcionGuardarActualizacionMasivaActivo = 'guardarActualizacionMasivaPermisos' + Usuarios.tabSeleccionado

            if($("#"+Gestion.idContentActivo).find('.noResultado').length > 0){
                $('.btn-Consultar').click();
            }
        });
    },

    cambiarSeccionActivo: function () {
        switch (Usuarios.tabSeleccionado) {
            case 'Usuarios':
                Usuarios.customDataTable = function () {
                    Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
                        columnDefs: [
                            { targets: 0, orderable: false, className: 'select-checkbox tex-center' },
                            { targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
                            { targets: [-1, -2, -3], className: 'text-center' },
                            { targets: 'colNumerica', className: 'text-center' },
                        ],
                        select: { style: 'os', selector: 'td:first-child' },
                        // buttons: ['pageLength', 'selectAll',
                        //     'selectNone'],
                    });
                    Gestion.columnaOrdenDT = 1;
                }

                break;
        }
    },

    eventos: function () {

        $(document).on("click", ".btn-EditarHistoricosDeUsuario", function (e) {
            e.preventDefault();

            var data = { 'id': $(this).closest('tr').data('id') };
            var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
            Object.assign(data, serialize);

            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + 'getFormEditarHistoricosDeUsuario', 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;

                ++modalId;
                Gestion.idModalPrincipal = modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var fn1 = 'Fn.showConfirm({ fn:"Usuarios.agregarHistorico()",content:"¿Esta seguro de agregar el histórico?" });';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                btn[1] = { title: 'Agregar Histórico', fn: fn1 };
                Fn.showModal({ id: modalId, class: a.data.class, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
            });
        });

        $(document).on("click", ".btn-EditarHistorico", function (e) {
            e.preventDefault();

            var fila = $(this).closest('tr');
            var data = {
                'idUsuario': fila.data('idusuario'),
                'idUsuarioHistorico': fila.data('idusuariohistorico'),
                'idCuenta': fila.data('idcuenta'),
                'idAplicacion': fila.data('idaplicacion'),
                'idProyecto': fila.data('idproyecto'),
                'menu': $(this).data('menu')
            };
            var serialize = Fn.formSerializeObject('formEditarHistoricosDeUsuario');
            Object.assign(data, serialize);

            var jsonString = { 'data': JSON.stringify(data) };

            var config = { 'url': Gestion.urlActivo + 'getFormEditarHistorico', 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;

                ++modalId;
                Gestion.idModalPrincipal = modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var fn1 = 'Fn.showConfirm({ fn:"Usuarios.actualizarDatosDeHistorico()",content:"¿Esta seguro de actualizar los datos del histórico?" });';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                btn[1] = { title: 'Actualizar datos', fn: fn1 };
                Fn.showModal({ id: modalId, class: a.data.class, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
            });
        });

        $(document).on("change", "#formEditarHistorico select[name|='grupoCanal']", function (e) {
            e.preventDefault();
            var idGrupoCanalSeleccionado = $(this).val();
            var fila = $(this).closest('tr');
            var selectCanal = $(fila).find("select[name|='canal']");
            var opcionesCanal = "<option value=''>-- Seleccionar --</option>";

            if (typeof canales[idGrupoCanalSeleccionado] !== 'undefined') {
                $.each(canales[idGrupoCanalSeleccionado], function (i, v) {
                    opcionesCanal += "<option value='" + v['idCanal'] + "'>" + v['canal'] + "</option>";
                });
            }
            selectCanal.html(opcionesCanal);
        });

        $(document).on("change", "#formEditarHistorico select[name|='cadena']", function (e) {
            e.preventDefault();
            var idCadenaSeleccionada = $(this).val();
            var fila = $(this).closest('tr');
            var selectBanner = $(fila).find("select[name|='banner']");
            var opcionesBanner = "<option value=''>-- Seleccionar --</option>";

            if (typeof banners[idCadenaSeleccionada] !== 'undefined') {
                $.each(banners[idCadenaSeleccionada], function (i, v) {
                    opcionesBanner += "<option value='" + v['idBanner'] + "'>" + v['nombreBanner'] + "</option>";
                });
            }
            selectBanner.html(opcionesBanner);
        });

        $(document).on("change", "#formEditarHistorico select[name|='distribuidora']", function (e) {
            e.preventDefault();
            var idDistribuidoraSeleccionada = $(this).val();
            var fila = $(this).closest('tr');
            var selectSucursal = $(fila).find("select[name|='sucursal']");
            var opcionesSucursal = "<option value=''>-- Seleccionar --</option>";

            if (typeof sucursales[idDistribuidoraSeleccionada] !== 'undefined') {
                $.each(sucursales[idDistribuidoraSeleccionada], function (i, v) {
                    opcionesSucursal += "<option value='" + v['idDistribuidoraSucursal'] + "'>" + v['distribuidoraSucursal'] + "</option>";
                });
            }
            selectSucursal.html(opcionesSucursal);
        });

        $(document).on("change", "#cuentaHistorico", function (e) {
            e.preventDefault();
            var idCuenta = $(this).val();
            var selectAplicacion = $("#aplicacionHistorico");
            var selectProyecto = $("#proyectoHistorico");
            var selectTiposDeUsuario = $("#tipoUsuarioHistorico");

            var opcionesAplicacion = "<option value=''>-- Seleccionar --</option>";
            if (typeof aplicaciones[idCuenta] !== 'undefined') {
                $.each(aplicaciones[idCuenta], function (i, v) {
                    opcionesAplicacion += "<option value='" + v['idAplicacion'] + "'>" + v['nombre'] + "</option>";
                });
                //APLICACIONES GENERALES
                $.each(aplicaciones[0], function(i,v){
                    opcionesAplicacion += "<option value='" + v['idAplicacion'] + "'>" + v['nombre'] + "</option>";
                })
            }

            var opcionesProyecto = "<option value=''>-- Seleccionar --</option>";
            if (typeof proyectos[idCuenta] !== 'undefined') {
                $.each(proyectos[idCuenta], function (i, v) {
                    opcionesProyecto += "<option value='" + v['idProyecto'] + "'>" + v['nombre'] + "</option>";
                });
            }

            var opcionesTiposDeUsuario = "<option value=''>-- Seleccionar --</option>";
            if (typeof tiposDeUsuario[idCuenta] !== 'undefined') {
                $.each(tiposDeUsuario[idCuenta], function (i, v) {
                    opcionesTiposDeUsuario += "<option value='" + v['idTipoUsuario'] + "'>" + v['tipoUsuario'] + "</option>";
                });
            }

            selectAplicacion.html(opcionesAplicacion);
            selectProyecto.html(opcionesProyecto);
            selectTiposDeUsuario.html(opcionesTiposDeUsuario);
        });

        $(document).on("change", "input[type=radio][name='tieneEncargado']", function () {
            var seccionTieneEncargado = $(".seccionTieneEncargado");
            var valor = ($(this).val() == 1) ? false : true;
            var form = ($("#formNew").length == 1) ? "#formNew" : "#formUpdate";
            var inputs = $(form).find(":input[data-radio='tieneEncargado']");
            $.each(inputs, function (i, v) {
                $(this).attr('disabled', valor);
            });

            if (valor) {
                $(seccionTieneEncargado).hide("slow");
            } else {
                $(seccionTieneEncargado).show("slow");
            }
        });

        $(document).on("click", ".btn-FindSuperior", function (e) {
            e.preventDefault();

            var form = ($("#formNew").length == 1) ? "#formNew" : "#formUpdate";
            var idTipoDocumento = $(form).find(":input[data-radio='tieneEncargado'][name='tipoDocumentoSuperior']").val();
            var idCuentaHistorico = $(form).find("select[name='cuentaHistorico']").val();
            var idProyectoHistorico = $(form).find("select[name='proyectoHistorico']").val();
            var numDocumento = $(form).find(":input[data-radio='tieneEncargado'][name='numDocSuperior']").val();

            if (idCuentaHistorico === "" || idProyectoHistorico === "") {
                ++modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                Fn.showModal({ id: modalId, show: true, title: "Alerta", frm: "Primero tiene que seleccionar una cuenta y proyecto para el histórico", btn: btn });
                return false;
            }

            var data = { 'idTipoDocumento': idTipoDocumento, 'numDocumento': numDocumento, 'idCuenta' : idCuentaHistorico, 'idProyecto' : idProyectoHistorico };
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + 'findSuperior', 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {
                if (a.result === 2) return false;

                var nombreSuperior = $(form).find(":input[data-radio='tieneEncargado'][name='superiorEncontrado']");
                var inputIdSuperior = $(form).find(":input[data-radio='tieneEncargado'][name='idUsuarioSuperior']");

                if (a.result === 0) {
                    $(nombreSuperior).val("");
                    $(inputIdSuperior).val("");
                }else{
                    $(nombreSuperior).val(a.data.superior.nombreSuperior);
                    $(inputIdSuperior).val(a.data.superior.idUsuario);
                }

                ++modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.msg.content, btn: btn });
            });
        });

        $(document).on('shown.bs.modal', '.modalNew', function () {
            var botonGenerarClave = $("#formNew .btn-GenerarClave");
            $(botonGenerarClave).click();
        });
        
        $(document).on("click", ".btn-busqueda", function (e) {
			e.preventDefault();
			var data = {'documento':$('#numDocumento').val()};
		
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'buscar_rrhh', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				//console.log(a.data['nombres']);
				$('#nombres').val(a.data['nombres']);
				$('#apePaterno').val(a.data['apePaterno']);
				$('#apeMaterno').val(a.data['apeMaterno']);
			});
		});
		
        $(document).on("change", "#tipoExterno", function (e) {
			var id=$(this).val();
			if(id==1){
				$('.btn-New').attr('data-extra','1');
			}else{
				$('.btn-New').attr('data-extra','2');
			}
		});

		
        $(document).on("click", ".btn-GenerarUsuario", function (e) {
            e.preventDefault();
            var usuarioInput = $(this).parents('.input-group').find('input:first');
            var numDocumento = $("#formNew input[type='text'][name='numDocumento']").val();
            var nombres = $("#formNew input[type='text'][name='nombres']").val();
            var primerNombre = nombres.split(" ")[0];
            var apePaterno = $("#formNew input[type='text'][name='apePaterno']").val().split(" ")[0];

            if (primerNombre === "" || apePaterno === "") {
                ++modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                Fn.showModal({ id: modalId, show: true, title: "Alerta", frm: "Primero tiene que ingresar el nombre y apellido paterno.", btn: btn });
                return false;
            }

            if (numDocumento !== "") {
                $(usuarioInput).val(numDocumento);
            } else {
                var usuario = primerNombre + "." + apePaterno + "." + Math.floor(Math.random() * 90 + 10);
                usuario = usuario.replace(/\s/g, '').toLowerCase();
                $(usuarioInput).val(usuario);
            }
        });

        $(document).on("change", "#formNew input[type='text'][name='nombres'], #formNew input[type='text'][name='apePaterno'], #formNew input[type='text'][name='numDocumento']", function (e) {
            e.preventDefault();
            var inputUsuario = $("input[type='text'][name='usuario']");
            $(inputUsuario).val("");
        });

        $(document).on("click", ".btn-ClickBtnCarpetas", function (e) {
            e.preventDefault();
            var btnCarpetas = $("#formEditarHistoricosDeUsuario table tbody tr:first .btn-EditarHistorico[data-menu='PermisosCarpetas']");
            btnCarpetas.click();
        });
		
		
		//////
		$(document).on('click','#btn-usuarioNuevoMasivo', function(e){
        	e.preventDefault();

        	var data = {};//Fn.formSerializeObject(Visitas.frmRutasVisitas);
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url':Gestion.urlActivo + 'usuarioNuevoMasivo', 'data':jsonString };

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Usuarios.confirmarGuardarUsuarioMasivo()';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});

				//HANDSONTABLE
				var sourceTipoDocumento = Usuarios.datatipoDocumento;
				var sourceProyecto = Usuarios.dataProyecto;
				var sourceTipoUsuario = Usuarios.dataTipoUsuario;
				var sourceAplicacion = Usuarios.dataAplicacion;

				/* var sourceUsuarios = Usuarios.dataListaUsuariosNombres;
				var sourceClientes = Usuarios.dataListaClientesNombres;  */
				var container = document.getElementById('nuevoUsuarioMasivo');

				var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: null,
					dataSchema: {idUsuario:null, usuario:null, fecha:null, cliente:null},
					colHeaders: ['TIPO DOCUMENTO','DOCUMENTO','NOMBRES','APEPATERNO','APEMATERNO','EMAIL','USUARIO','CLAVE','FECHA','PROYECTO','TIPO USUARIO','APLICACION'],
					startRows: 10,
					columns: [
						{ data: 'tipoDocumento' 
						    , type: 'dropdown'
							, source: sourceTipoDocumento
						},
						{ data: 'documento'
							, type: 'text'
						},
						{ data: 'nombres'
							//, type: 'dropdown'
							//, source: sourceUsuarios
						},
						{ data: 'apePaterno'
							//, type: 'dropdown'
							//, source: sourceUsuarios
						},
						{ data: 'apeMaterno'
							//, type: 'dropdown'
							//, source: sourceUsuarios
						},
						{ data: 'email'
							//, type: 'dropdown'
							//, source: sourceUsuarios
						},
						{ data: 'usuario'
							//, type: 'dropdown'
							//, source: sourceUsuarios
						},
						{ data: 'clave'
							//, type: 'dropdown'
							//, source: sourceUsuarios
						},

						{ data: 'fecha'
							, type:'date'
							, dateFormat: 'DD/MM/YYYY'
							, allowEmpty: false
						},
						{ data: 'proyecto'
							, type: 'dropdown'
							, source: sourceProyecto
						},
						{ data: 'tipousuario'
							, type: 'dropdown'
							, source: sourceTipoUsuario
						},
						{ data: 'aplicacion'
							, type: 'dropdown'
							, source: sourceAplicacion
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
					/* afterChange: function(changes, source){
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
					} */
				};

				Usuarios.handsontable = new Handsontable(container,settings);
				setTimeout(function(){
					Usuarios.handsontable.render();
				}, 1000);
			});
        });
		
		//////
	},

		


    agregarHistorico: function () {
        var data = Fn.formSerializeObject('formEditarHistoricosDeUsuario');
        var jsonString = { 'data': JSON.stringify(data) };
        var config = { 'url': Gestion.urlActivo + 'registrarHistoricoUsuario', 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            if (a.result === 2) return false;

            if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formEditarHistoricosDeUsuario', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
        });
    },

    actualizarDatosDeHistorico: function () {
        var data = Fn.formSerializeObject('formEditarHistorico');
        var jsonString = { 'data': JSON.stringify(data) };
        var config = { 'url': Gestion.urlActivo + 'actualizarDatosDeHistorico', 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formEditarHistorico', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
        });
    },
	
	confirmarGuardarUsuarioMasivo: function(){
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoUsuarioMasivo .htInvalid').length;
		var arrayDataRutas = [];
		for (var ix = 0; ix < Usuarios.handsontable.countRows(); ix++) {
			if (!Usuarios.handsontable.isEmptyRow(ix)) {
				arrayDataRutas.push(Usuarios.handsontable.getDataAtRow(ix));
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
			var fn1='Usuarios.guardarNuevoUsuarioMasivo();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},
	
	guardarNuevoUsuarioMasivo: function(){
		var arrayDataRutas = [];
		for (var ix = 0; ix < Usuarios.handsontable.countRows(); ix++) {
			if (!Usuarios.handsontable.isEmptyRow(ix)) {
				arrayDataRutas.push(Usuarios.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataRutas;
		var jsonString = {'data': JSON.stringify(dataArrayCargaMasiva)};
		var configAjax = {'url':Gestion.urlActivo+'guardarNuevoUsuarioMasivo', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			console.log(a);
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	},
}

Usuarios.load();