var TipoPremiacion = {

    secciones: ['TipoPremiacion'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            TipoPremiacion.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/TipoPremiacion/';
            $(".card-body > ul > li > a[class*='active']").click();
            $('.btn-Consultar').click();
        });

        $(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            TipoPremiacion.tabSeleccionado = TipoPremiacion.secciones[indiceSeccion];

            TipoPremiacion.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = TipoPremiacion.customDataTable;
            Gestion.seccionActivo = TipoPremiacion.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccionFiltros'
            Gestion.getTablaActivo = 'getTabla' + TipoPremiacion.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + TipoPremiacion.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + TipoPremiacion.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + TipoPremiacion.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + TipoPremiacion.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + TipoPremiacion.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + TipoPremiacion.tabSeleccionado

            //Ajustar columnas
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });
    },

    cambiarSeccionActivo: function () {
        $('.btn-CargaMasiva').addClass('d-none');
        switch (TipoPremiacion.tabSeleccionado) {
            case 'TipoPremiacion':
                TipoPremiacion.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

    },
}

TipoPremiacion.load();