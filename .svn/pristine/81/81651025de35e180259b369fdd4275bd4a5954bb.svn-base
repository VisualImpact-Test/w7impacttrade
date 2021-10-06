var Gestorx = {

    secciones: ['TipoCliente'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Gestorx.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/tipoCliente/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Gestorx.tabSeleccionado = Gestorx.secciones[indiceSeccion];

            if(Gestorx.secciones[indiceSeccion] == 'Categoria'){
                $('.btn-CargaMasiva').show();
            }else if(Gestorx.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Gestorx.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Gestorx.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
            $('.funciones .btn-seccion-' + Gestorx.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Gestorx.customDataTable;
            Gestion.seccionActivo = Gestorx.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Gestorx.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Gestorx.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Gestorx.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Gestorx.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Gestorx.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Gestorx.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Gestorx.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Gestorx.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Gestorx.tabSeleccionado) {
            case 'TipoCliente':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

    },
}

Gestorx.load();