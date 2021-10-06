var Encuestas = {
    idEncuesta:0,
    idPregunta:0,
    secciones: ['Encuesta', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Encuestas.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/encuestas/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Encuestas.tabSeleccionado = Encuestas.secciones[indiceSeccion];

            if(Encuestas.secciones[indiceSeccion] == 'Encuesta'){
                $('.btn-CargaMasiva').show();
            }else if(Encuestas.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Encuestas.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Encuestas.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Encuestas.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Encuestas.customDataTable;
            Gestion.seccionActivo = Encuestas.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Encuestas.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Encuestas.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Encuestas.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Encuestas.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Encuestas.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Encuestas.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Encuestas.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Encuestas.tabSeleccionado
        });

        $(document).on('click',"#eliminar_encuesta",function(){
            $("#tabla_encuesta_lista " +this).on('click', function() {
                var toma1 = "", toma2 = "", toma3 = ""; 
                        toma1 += $(this).find('td:eq(1)').html();
                        toma2 += $(this).find('td:eq(3)').html();
                        toma3 += $(this).find('td:eq(5)').html();
         
                $("#respuesta").text(toma1 + toma2 + toma3);
            });
            var data = {};
			data['id'] = $("#encuesta").val();
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getEncuesta', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
                var t = $('#tabla_encuesta_lista').DataTable();
                    t.row.add( a.data.html ).draw( false );
                $('#tabla_encuesta_lista').append(a.data.html);
			});
        });
    },

    cambiarSeccionActivo: function () {
        switch (Encuestas.tabSeleccionado) {
            case 'Encuesta':
                Encuestas.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Encuestas.customDataTable = Gestion.defaultDT;
                break;
            
        }
    },

    eventos: function () {
        $(document).on('click',".btn-agregar-encuesta-lista",function(){
            var data = {};
			data['id'] = $("#encuesta").val();
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getEncuesta', 'data': jsonString };
s
            if(data.id != ''){

                $.when(Fn.ajax(config)).then(function (a) {                    
                    $('#tabla_encuesta_lista').append(a.data.html);
                    
                    $('body').attr('class',"modal-open");
                });
            }
            
        });
        $(document).on('click',"#fila_temporal_encuesta",function(){
            $(this).remove();
        });

        $(document).on("click", ".btn-Preguntas", function (e) {
			e.preventDefault();
            Gestion.seccionActivo= "Pregunta";
            Gestion.btnConsultar= ".btn-Consultar-pregunta";
            var data = { 'id': $(this).closest('tr').data('id') };
            
			var serialize = Fn.formSerializeObject("formEditarPreguntas");
            Object.assign(data, serialize);
            

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getTablaPregunta', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
				var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_preguntas()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, class: a.data.class, show: true, title: "Editar Preguntas", frm: a.data.html, btn: btn,large:true });
			});
		});
        $(document).on("click", ".table .trHijo .btn-EditarAlternativas", function (e) {
			e.preventDefault();
			var tr = $(this).closest('tr');
			var table = $(this).closest('table');
			var lastTh = $(table).find('thead tr:first th:last');

			var idSeleccionado = $(tr).find("input[name|='id']").val();
	
            var data = { 'id': idSeleccionado };
			var serialize = Fn.formSerializeObject("formEditarAlternativas");
            Object.assign(data, serialize);
            

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getTablaAlternativa', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
				var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_alternativas()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, class: a.data.class, show: true, title: "Editar Alternativas", frm: a.data.html, btn: btn,large:true });
			});
	
		});
        $(document).on("click", ".btn-clickToAgregar", function (e) {
            $('.btn-AgregarElemento').click();
		});

    },
    resetActivo: function(){
        Gestion.btnConsultar= ".btn-Consultar";
        Gestion.seccionActivo= "Encuesta";

    },

    actualizar_preguntas: function () {
		var data = Fn.formSerializeObject('formEditarPreguntas');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + "actualizarPreguntas", 'data': jsonString };
        Encuestas.idEncuesta =$('#idEncuesta').val();

		$.when(Fn.ajax(config)).then(function (a) {

	
            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formEditarPreguntas', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });Encuestas.refrescar_pregunta()';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
    },

    actualizar_alternativas: function () {
		var data = Fn.formSerializeObject('formEditarAlternativas');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + "actualizarAlternativas", 'data': jsonString };
        Encuestas.idEncuesta =$('#idPregunta').val();

		$.when(Fn.ajax(config)).then(function (a) {

	
            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formEditarAlternativas', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
    },

    refrescar_pregunta: function(){
        Gestion.seccionActivo= "Pregunta";
        Gestion.btnConsultar= ".btn-Consultar-pregunta";
        var data = { 'id':Encuestas.idEncuesta};
        
        var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
        Object.assign(data, serialize);

        var jsonString = { 'data': JSON.stringify(data) };

        var config = { 'url': Gestion.urlActivo + 'getTablaPregunta', 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            Encuestas.close_all_modal(modalId);
            if (a.result === 2) return false;

            ++modalId;
            Gestion.idModalPrincipal = modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
            var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_preguntas()",content:"¿Esta seguro de actualizar los datos?" });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            btn[1] = { title: 'Actualizar', fn: fn1 };
            Fn.showModal({ id: modalId,class: a.data.class, show: true, title: "Editar Preguntas", frm: a.data.html, btn: btn,large:true });
        });
    },

    close_all_modal: function($id_active){
        for (let index = 0; index <= $id_active; index++) {
            Fn.showModal({id:index,show:false});
        }
    },
    
}

Encuestas.load();