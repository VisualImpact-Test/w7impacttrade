var Usuarios = {

    secciones: ['Usuarios'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Usuarios.eventos();
            Gestion.urlActivo = 'configuraciones/administracion/Usuarios/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Usuarios.tabSeleccionado = Usuarios.secciones[indiceSeccion];

            Usuarios.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Usuarios.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Usuarios.tabSeleccionado).removeClass('d-none');
            if (typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Usuarios.customDataTable;
            Gestion.seccionActivo = Usuarios.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Usuarios.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Usuarios.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Usuarios.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Usuarios.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Usuarios.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Usuarios.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Usuarios.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Usuarios.tabSeleccionado
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
                        // order: [[3, 'asc']],
                        buttons: ['pageLength', 'selectAll',
                            'selectNone'],
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

            var opcionesAplicacion = "<option value=''>-- Seleccionar --</option>";
            if (typeof aplicaciones[idCuenta] !== 'undefined') {
                $.each(aplicaciones[idCuenta], function (i, v) {
                    opcionesAplicacion += "<option value='" + v['idAplicacion'] + "'>" + v['nombre'] + "</option>";
                });
            }

            var opcionesProyecto = "<option value=''>-- Seleccionar --</option>";
            if (typeof proyectos[idCuenta] !== 'undefined') {
                $.each(proyectos[idCuenta], function (i, v) {
                    opcionesProyecto += "<option value='" + v['idProyecto'] + "'>" + v['nombre'] + "</option>";
                });
            }

            selectAplicacion.html(opcionesAplicacion);
            selectProyecto.html(opcionesProyecto);
        });

        $(document).on("change", "input[type=radio][name='tieneEncargado']", function () {
            var valor = ($(this).val() == 1) ? false : true;
            var form = ($("#formNew").length == 1) ? "#formNew" : "#formUpdate";
            var inputs = $(form).find(":input[data-radio='tieneEncargado']");
            $.each(inputs, function (i, v) {
                $(this).attr('disabled', valor);
            });
        });

        $(document).on("click", ".btn-FindSuperior", function (e) {
            e.preventDefault();

            var form = ($("#formNew").length == 1) ? "#formNew" : "#formUpdate";
            var idTipoDocumento = $(form).find(":input[data-radio='tieneEncargado'][name='tipoDocumentoSuperior']").val();
            var numDocumento = $(form).find(":input[data-radio='tieneEncargado'][name='numDocSuperior']").val();
            var data = { 'idTipoDocumento': idTipoDocumento, 'numDocumento': numDocumento };
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + 'findSuperior', 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {
                if (a.result === 2) return false;

                var nombreSuperior = $(form).find(":input[data-radio='tieneEncargado'][name='superiorEncontrado']");
                var inputIdSuperior = $(form).find(":input[data-radio='tieneEncargado'][name='idUsuarioSuperior']");
                
                if (a.result === 0) {
                    $(nombreSuperior).val("");
                    $(inputIdSuperior).val("");
                    
                    ++modalId;
                    var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                    var btn = [];
                    btn[0] = { title: 'Cerrar', fn: fn };
                    Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.msg.content, btn: btn });
                    return false;
                }

                $(nombreSuperior).val(a.data.superior.nombreSuperior);
                $(inputIdSuperior).val(a.data.superior.idUsuario);
            });
        });

    },

    agregarHistorico: function () {
        var data = Fn.formSerializeObject('formEditarHistoricosDeUsuario');
        var jsonString = { 'data': JSON.stringify(data) };
        var config = { 'url': Gestion.urlActivo + 'registrarHistoricoUsuario', 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            if (a.result === 2) return false;

            if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formEditarHistoricosDeUsuario', a.data.validaciones);

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
            if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formEditarHistorico', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
        });
    },
}

Usuarios.load();