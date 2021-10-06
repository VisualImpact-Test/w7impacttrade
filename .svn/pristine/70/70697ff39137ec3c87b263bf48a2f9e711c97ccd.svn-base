var Aplicaciones = {

    secciones: ['Aplicaciones','GrupoModulo','Modulos','Menu','MenuCuenta'],
    tabSeleccionado: '',
    proyectos:null,
    grupoCanal:null,
    tipoUsuario:null,
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Aplicaciones.eventos();
            Gestion.urlActivo = 'configuraciones/maestros/Aplicaciones/';
            $(".card-body > ul > li > a[class*='active']").click();
            $('.btn-Consultar').click();
        });

        $(document).on('click', '.card-body > ul > li > a', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Aplicaciones.tabSeleccionado = Aplicaciones.secciones[indiceSeccion];

            Aplicaciones.cambiarSeccionActivo();
            
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Aplicaciones.customDataTable;
            Gestion.seccionActivo = Aplicaciones.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccionFiltros'
            Gestion.getTablaActivo = 'getTabla' + Aplicaciones.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Aplicaciones.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Aplicaciones.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Aplicaciones.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Aplicaciones.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Aplicaciones.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Aplicaciones.tabSeleccionado

            //Ajustar columnas
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });


        $(document).on('change', '#idCuenta', function (e) {
            var idCuenta=$("#idCuenta").val();

            var html=' <select class="form-control form-control-sm my_select2" name="idProyecto" id="idProyecto" patron="requerido">';
            html+="<option value=''>-- Seleccione --</option>";
            if(idCuenta!=null && idCuenta!=undefined){
                if(Aplicaciones.proyectos[idCuenta]!=null && Aplicaciones.proyectos[idCuenta]!=undefined){
                    Object.keys(Aplicaciones.proyectos[idCuenta]).forEach(key => (html+="<option value="+key+">"+Aplicaciones.proyectos[idCuenta][key]+"</option>")  );
                }
            }
            html+="</select>";
            $("#idProyecto_select").html(html);


            var html='<select class="form-control form-control-sm my_select2" name="idGrupoCanal" id="idGrupoCanal">';
            html+="<option value=''>-- Seleccione --</option>";
            if(idCuenta!=null  && idCuenta!=undefined){
                if(Aplicaciones.grupoCanal[idCuenta]!=null && Aplicaciones.grupoCanal[idCuenta]!=undefined){
                    Object.keys(Aplicaciones.grupoCanal[idCuenta]).forEach(key => (html+="<option value="+key+">"+Aplicaciones.grupoCanal[idCuenta][key]+"</option>")  );
                }
            }
            html+="</select>";
            $("#idGrupoCanal_select").html(html);


            var html='<select class="form-control form-control-sm my_select2" name="idTipoUsuario" id="idTipoUsuario">';
            html+="<option value=''>-- Seleccione --</option>";
           if(idCuenta!=null  && idCuenta!=undefined){
                if(Aplicaciones.tipoUsuario[idCuenta]!=null && Aplicaciones.tipoUsuario[idCuenta]!=undefined){
                    Object.keys(Aplicaciones.tipoUsuario[idCuenta]).forEach(key => (html+="<option value="+key+">"+Aplicaciones.tipoUsuario[idCuenta][key]+"</option>")  );
                }
            }
            html+="</select>";
            $("#idTipoUsuario_select").html(html);
            
        });


    },

    cambiarSeccionActivo: function () {
        $('.btn-CargaMasiva').addClass('d-none');
        switch (Aplicaciones.tabSeleccionado) {
            case 'Aplicaciones':
                Aplicaciones.customDataTable = Gestion.defaultDT;
                break;
            case 'GrupoModulo':
                Aplicaciones.customDataTable = Gestion.defaultDT;
                break;
            case 'Menu':
                Aplicaciones.customDataTable = Gestion.defaultDT;
                break;
            case 'MenuCuenta':
                Aplicaciones.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

    },
}

Aplicaciones.load();