var Filtros = {

    secciones: ['Distribuidora','DistribuidoraSucursal','Zona','Plaza'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Filtros.eventos();
            Gestion.urlActivo = 'configuraciones/maestros/Filtros/';
            $(".card-body > ul > li > a[class*='active']").click();
            $('.btn-Consultar').click();
        });

        $(document).on('click', '.card-body > ul > li > a', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Filtros.tabSeleccionado = Filtros.secciones[indiceSeccion];

            Filtros.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Filtros.customDataTable;
            Gestion.seccionActivo = Filtros.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccionFiltros'
            Gestion.getTablaActivo = 'getTabla' + Filtros.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Filtros.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Filtros.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Filtros.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Filtros.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Filtros.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Filtros.tabSeleccionado

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
        switch (Filtros.tabSeleccionado) {
            case 'Distribuidora':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
            case 'DistribuidoraSucursal':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
            case 'Zona':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
            case 'Plaza':
                Filtros.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

    },
}

Filtros.load();