var Obligatoria = {

    secciones: ['Elemento', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Obligatoria.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/auditoria/Obligatoria/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Obligatoria.tabSeleccionado = Obligatoria.secciones[indiceSeccion];

            if(Obligatoria.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva').show();
            }else if(Obligatoria.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }
            Obligatoria.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Obligatoria.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Obligatoria.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Obligatoria.customDataTable;
            Gestion.seccionActivo = Obligatoria.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Obligatoria.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Obligatoria.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Obligatoria.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Obligatoria.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Obligatoria.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Obligatoria.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Obligatoria.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Obligatoria.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Obligatoria.tabSeleccionado) {
            case 'Elemento':
                Obligatoria.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Obligatoria.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
       
    },
}

Obligatoria.load();