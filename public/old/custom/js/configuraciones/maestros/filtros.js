var Filtros = {

    secciones: ['Cuenta', 'Proyecto', 'GrupoCanal', 'Canal', 'SubCanal'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Filtros.eventos();
            Gestion.urlActivo = 'configuraciones/maestros/Filtros/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Filtros.tabSeleccionado = Filtros.secciones[indiceSeccion];

            Filtros.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Filtros.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones button[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Filtros.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Filtros.customDataTable;
            Gestion.seccionActivo = Filtros.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Filtros.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Filtros.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Filtros.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Filtros.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Filtros.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Filtros.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Filtros.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Filtros.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Filtros.tabSeleccionado) {
            case 'Cuenta':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
            case 'Proyecto':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
            case 'GrupoCanal':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
            case 'Canal':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
            case 'SubCanal':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

    },
}

Filtros.load();