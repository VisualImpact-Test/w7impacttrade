var Encuestas = {

    secciones: ['Encuesta', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Encuestas.eventos();
            Gestion.urlActivo = 'gestion/encuestas/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Encuestas.tabSeleccionado = Encuestas.secciones[indiceSeccion];

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
            
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
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
				Fn.showModal({ id: modalId, show: true, title: "Editar Preguntas", frm: a.data.html, btn: btn,large:true });
			});
		});
        $(document).on("click", ".btn-Consultar-pregunta", function (e) {
			e.preventDefault();
            Gestion.seccionActivo= "Pregunta";
            Gestion.btnConsultar= ".btn-Consultar-pregunta";
            var data = { 'id':$('#idEncuesta').val() };
            
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
				Fn.showModal({ id: modalId, show: true, title: "EDITAR PREGUNTAS", frm: a.data.html, btn: btn,large:true });
			});
		});

    },
    resetActivo: function(){
        Gestion.btnConsultar= ".btn-Consultar";
        Gestion.seccionActivo= "Encuesta";

    },

    actualizar_preguntas: function () {
		var data = Fn.formSerializeObject('formUpdatePregunta');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + "actualizarPreguntas", 'data': jsonString };
        

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;

			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });$(".btn-Consultar-pregunta").click();';

			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-Consultar-pregunta").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
    },



    close_all_modal: function($id_active){
        for (let index = 0; index <= $id_active; index++) {
            Fn.showModal({id:index,show:false});
        }
    },
    
}

Encuestas.load();