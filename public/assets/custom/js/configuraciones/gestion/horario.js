var Gestorx = {

    secciones: ['Elemento'],
    tabSeleccionado: '',
    matEnTabla : [],
    encEnTabla: [],
    tabActivo : '',
    tabSeleccionadoCeldas : [],
    nSheets : 0,
    hSheets : [],
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Gestorx.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/horario/';
            $(".card-body > ul > li > a[class*='active']").click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();
            $('.card-header > .scrollmenu > a').removeClass('active');
            var indiceSeccion = $(this).attr('href').split('-')[2];
            Gestorx.tabSeleccionado = Gestorx.secciones[indiceSeccion];

            Gestorx.hSheets = [];
            Gestorx.tabSeleccionadoCeldas = [];

            Gestorx.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
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

            if($("#"+Gestion.idContentActivo).find('.noResultado').length > 0){
                    $('.btn-Consultar').click()
            }

            //Ajustar columnas
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });
    },

    cambiarSeccionActivo: function () {
        switch (Gestorx.tabSeleccionado) {
            case 'Elemento':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
        
    },
}

Gestorx.load();