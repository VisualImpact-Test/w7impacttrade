var TipoPremiacion = {

    secciones: ['Premiacion','Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            TipoPremiacion.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Premiacion/';
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

            if(indiceSeccion != 1){
                $(".listPremiacion").addClass("d-none");
                $(".btn-CargaMasiva").removeClass("d-none");
                $(".btn-New").removeClass("d-none");

            }

            if(indiceSeccion == 1){
                $(".listPremiacion").removeClass("d-none");
                $(".btn-CargaMasiva").addClass("d-none");
                $(".btn-New").addClass("d-none");
            }

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
            Gestion.funcionActualizarCargaMasivaActivo = 'actualizarCargaMasiva' + TipoPremiacion.tabSeleccionado
            
            //Ajustar columnas
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });
    },

    cambiarSeccionActivo: function () {
        switch (TipoPremiacion.tabSeleccionado) {
            case 'Premiacion':
                TipoPremiacion.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                TipoPremiacion.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

        $(document).on("click", ".btn-CargaMasivaListas", function (e) {
			e.preventDefault();

			var config = { 'url': Gestion.urlActivo + Gestion.getFormCargaMasivaActivo };
			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Gestion.confirmarGuardarCargaMasiva();';
				var fn2 = 'Gestion.confirmarActualizarCargaMasiva();';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn2 };
				btn[2] = { title: 'Guardar', fn: fn1 };

				Fn.showModal({ id: modalId, show: true, class: 'modalCargaMasiva', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
				HTCustom.llenarHTObjectsFeatures(a.data.ht);
			});
		});

        $(document).on("click", ".tabCargaMasiva", function (e) {
            let hoja = $(".tabCargaMasiva.active").data("nrohoja");
            
            if(hoja == 1){
                $(".msgCargaElementos").removeClass("d-none");
            }else{
                $(".msgCargaElementos").addClass("d-none");
            }
		});
        $(document).on("change", ".my_select2EditarLista", function (e) {
            let control = $(this);
            
            $.each($(".premiacionestxt"), (i,v) => {
                
                if($(".premiacionestxt").eq(i).data("id") == control.val()){
                    ++modalId;
                    var fn='Fn.showModal({ id:'+modalId+',show:false });';
                    var btn=new Array();
                        btn[0]={title:'Cerrar',fn:fn};
                    var message = Fn.message({ 'type': 2, 'message': 'Ya existe la premiación dentro de la lista' });
                    Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
                    control.val("");
                    $(".my_select2EditarLista").select2();
                }
            });
           

            $.each($(".my_select2EditarLista"), (i,v) => {
                if(control.index() == i) {
                    return;
                }
                else if($(".my_select2EditarLista").eq(i).val() != "" && $(".my_select2EditarLista").eq(i).val() == control.val()){
                    ++modalId;
                    var fn='Fn.showModal({ id:'+modalId+',show:false });';
                    var btn=new Array();
                        btn[0]={title:'Cerrar',fn:fn};
                    var message = Fn.message({ 'type': 2, 'message': 'Ya se ha seleccionado la premiación' });
                    Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
                    control.val("");
                    $(".my_select2EditarLista").select2();
                }
            });
            
		});


    },
}

TipoPremiacion.load();