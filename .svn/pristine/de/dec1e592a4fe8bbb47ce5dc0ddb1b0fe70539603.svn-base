var Reprogramacion = {

    secciones: ['Reprogramacion'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Reprogramacion.eventos();
            Gestion.urlActivo = 'configuraciones/administracion/Reprogramacion/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Reprogramacion.tabSeleccionado = Reprogramacion.secciones[indiceSeccion];

            Reprogramacion.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Reprogramacion.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Reprogramacion.tabSeleccionado).removeClass('d-none');
            if (typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Reprogramacion.customDataTable;
            Gestion.seccionActivo = Reprogramacion.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Reprogramacion.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Reprogramacion.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Reprogramacion.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Reprogramacion.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Reprogramacion.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Reprogramacion.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Reprogramacion.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Reprogramacion.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Reprogramacion.tabSeleccionado) {
            case 'Reprogramacion':
                Reprogramacion.customDataTable = function () {
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

        //Evento general para mostrar formulario de actualización.
        $(document).on("click", ".btn-Reprogramar", function (e) {
            e.preventDefault();

            var data = { 'id': $(this).closest('tr').data('id'), 'seccionActivo': Gestion.seccionActivo };
            var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);

            Object.assign(data, serialize);
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "getFormReprogramacion", 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {
                if (a.result === 2) return false;
                ++modalId;
                Gestion.idModalPrincipal = modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var fn1 = 'Fn.showConfirm({ fn:"Reprogramacion.rechazar()",content:"¿Esta seguro de rechazar la solicitud de reprogramación?" });';
                var fn2 = 'Fn.showConfirm({ fn:"Reprogramacion.reprogramar()",content:"¿Esta seguro de reprogramar la visita?" });';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                btn[1] = { title: 'Rechazar', fn: fn1, class: 'btn-danger'};
                btn[2] = { title: 'Reprogramar', fn: fn2 };
                Fn.showModal({ id: modalId, show: true, class: a.data.class, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
            });
        });

        $(document).on('click', '.btn-verFoto', function (e) {
			e.preventDefault();

			var linkFoto = $(this).data('urlfoto');

			var content = '';
			content += '<div class="row">';
			content += '<div class="col-md-12 text-center">';
			content += '<img src="' + linkFoto + '" class="img-fluid">';
			content += '</div>';
			content += '</div>';

			var idModal = ++modalId;
			var btn = new Array();
			btn[0] = { title: 'Cerrar', fn: 'Fn.showModal({ id:' + idModal + ',show:false });' };
			Fn.showModal({ id: idModal, show: true, title: 'Imagen', content: content, btn: btn, width: '40%' });
        });
        
        //Evento cuando modal de Carga Masiva se termina de mostrar completamente (usado para renderizado de handsontable.)
		$(document).on('shown.bs.modal', '.formReprogramacion', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es'
            });
            calendar.render();
		});


    },

    rechazar: function () {
        var data = Fn.formSerializeObject('formReprogramacion');
        data.seccionActivo = Gestion.seccionActivo;
        var jsonString = { 'data': JSON.stringify(data) };
        var config = { 'url': Gestion.urlActivo + "rechazar", 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formReprogramacion', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-Consultar").click();';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
        });
    },

    reprogramar: function () {
        var data = Fn.formSerializeObject('formReprogramacion');
        data.seccionActivo = Gestion.seccionActivo;
        var jsonString = { 'data': JSON.stringify(data) };
        var config = { 'url': Gestion.urlActivo + "reprogramar", 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formReprogramacion', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-Consultar").click();';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
        });
    },


}

Reprogramacion.load();