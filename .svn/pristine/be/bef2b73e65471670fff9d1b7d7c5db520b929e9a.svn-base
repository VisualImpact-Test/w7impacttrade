var Carpetas = {

    secciones: ['Carpetas'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Carpetas.eventos();
            Gestion.urlActivo = 'configuraciones/maestros/Carpetas/';
            $(".card-body > ul > li > a[class*='active']").click();
            $('.btn-Consultar').click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Carpetas.tabSeleccionado = Carpetas.secciones[indiceSeccion];

            Carpetas.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            // $('.contentGestion').addClass('d-none');
            // $('#' + Gestion.idContentActivo).removeClass('d-none');
            // $(".funciones button[class*='btn-seccion-']").addClass('d-none');
            // $('.funciones .btn-seccion-' + Carpetas.tabSeleccionado).removeClass('d-none');
            if (typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Carpetas.customDataTable;
            Gestion.seccionActivo = Carpetas.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Carpetas.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Carpetas.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Carpetas.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Carpetas.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Carpetas.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Carpetas.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Carpetas.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Carpetas.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Carpetas.tabSeleccionado) {
            case 'Carpetas':
                Carpetas.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

    },

}

Carpetas.load();