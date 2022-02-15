var categoryVision = {

    secciones: ['Detallado'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            categoryVision.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/categoryVision/';
            $(".card-body > ul > li > a[class*='active']").click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            categoryVision.tabSeleccionado = categoryVision.secciones[indiceSeccion];


            categoryVision.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + categoryVision.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = categoryVision.customDataTable;
            Gestion.seccionActivo = categoryVision.tabSeleccionado
            Gestion.idFormSeccionActivo = 'frmFiltrocategoryVision'

        });
    },

    cambiarSeccionActivo: function () {
        switch (categoryVision.tabSeleccionado) {
            case 'Lista_sos':
                categoryVision.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista_sod':
                categoryVision.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
        $(document).on('click',".btn-agregar-elemento-lista",function(){
            var data = {};
            data['id'] = $("#elemento").val();
            data['marca'] = $('#marca').val();

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getElementoLista', 'data': jsonString };

            if(data.id != '' && data.marca !=''){

                $.when(Fn.ajax(config)).then(function (a) {
                    $('#tabla_elemento_lista').append(a.data.html);
                    
                    $('body').attr('class',"modal-open");
                });
            }
            
        });

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
    },
}

categoryVision.load();