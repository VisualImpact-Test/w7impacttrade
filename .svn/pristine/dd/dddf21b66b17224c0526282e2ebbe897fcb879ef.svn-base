var Iniciativa = {

    secciones: ['Elemento', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Iniciativa.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/auditoria/Iniciativa/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Iniciativa.tabSeleccionado = Iniciativa.secciones[indiceSeccion];

            if(Iniciativa.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva').show();
            }else if(Iniciativa.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Iniciativa.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Iniciativa.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Iniciativa.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Iniciativa.customDataTable;
            Gestion.seccionActivo = Iniciativa.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Iniciativa.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Iniciativa.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Iniciativa.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Iniciativa.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Iniciativa.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Iniciativa.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Iniciativa.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Iniciativa.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Iniciativa.tabSeleccionado) {
            case 'Elemento':
                Iniciativa.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Iniciativa.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
       
    },
}

Iniciativa.load();