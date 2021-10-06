var Usuarios = {

    secciones: ['Usuarios'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Usuarios.eventos();
            Gestion.urlActivo = 'gestion/usuarios/';
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
                Usuarios.customDataTable = Gestion.defaultDT;
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
            var data = { 'idUsuario': fila.data('idusuario'), 'idUsuarioHistorico': fila.data('idusuariohistorico'), 'idCuenta': fila.data('idcuenta'), 'idProyecto': fila.data('idproyecto'), 'menu': $(this).data('menu') };
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

        $(document).on("change", "#formEditarHistorico select[name='grupoCanal']", function (e) {
            e.preventDefault();
            var idGrupoCanalSeleccionado = $(this).val();
            var selectCanal = $("#formEditarHistorico select[name='canal']")
            var opcionesCanal = "<option value=''>-- Seleccionar --</option>";

            if (typeof canales[idGrupoCanalSeleccionado] !== 'undefined') {
                $.each(canales[idGrupoCanalSeleccionado], function (i, v) {
                    opcionesCanal += "<option value='" + v['idCanal'] + "'>" + v['canal'] + "</option>";
                });
            }
            selectCanal.html(opcionesCanal);
        });

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
}

Usuarios.load();