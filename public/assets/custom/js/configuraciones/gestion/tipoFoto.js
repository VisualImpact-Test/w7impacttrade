var TipoFoto = {
    idEncuesta:0,
    idPregunta:0,
    secciones: ['TipoFoto'],
    tabSeleccionado: '',
    grupoCanal:null,
    idCuenta:0,
    customDataTable: function () { },

    dataTipoPregunta: [],
    dataObligatorio: [],

    handsontable : '',

    load: function () {

        $(document).ready(function (e) {
            TipoFoto.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/tipoFoto/';
            $(".card-body > ul > li > a[class*='active']").click();

         
            
        });
  
          $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            TipoFoto.tabSeleccionado = TipoFoto.secciones[indiceSeccion];

            if(TipoFoto.secciones[indiceSeccion] == 'TipoFoto'){
                $('#btn-CargaMasivaTipoFoto').show(); 
            }

            TipoFoto.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;

            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = TipoFoto.customDataTable;
            Gestion.seccionActivo = TipoFoto.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + TipoFoto.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + TipoFoto.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + TipoFoto.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + TipoFoto.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + TipoFoto.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + TipoFoto.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + TipoFoto.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + TipoFoto.tabSeleccionado

            if($("#"+Gestion.idContentActivo).find('.noResultado').length > 0){
                $('.btn-Consultar').click()
            }
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);

        });

        $('#idTipoUsuario').select2();

    },

    cambiarSeccionActivo: function () {
        switch (TipoFoto.tabSeleccionado) {
            case 'TipoFoto':
                TipoFoto.customDataTable = Gestion.defaultDT;
                break;
            
        }
    },

    eventos: function () {
  
        $(document).on("click", ".btn-clickToAgregar", function (e) {
            $('.btn-AgregarElemento').click();
        });
		
    },
    resetActivo: function(){
        Gestion.btnConsultar= ".btn-Consultar";
        Gestion.seccionActivo= "TipoFoto";

    },
    close_all_modal: function($id_active){
        for (let index = 0; index <= $id_active; index++) {
            Fn.showModal({id:index,show:false});
        }
    },
   
    
}

TipoFoto.load();