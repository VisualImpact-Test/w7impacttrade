var Archivos = {

    secciones: ['Archivos'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Archivos.eventos();
            Gestion.urlActivo = 'gestionOperativa/Archivos/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Archivos.tabSeleccionado = Archivos.secciones[indiceSeccion];

            Archivos.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Archivos.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones button[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Archivos.tabSeleccionado).removeClass('d-none');
            if (typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Archivos.customDataTable;
            Gestion.seccionActivo = Archivos.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Archivos.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Archivos.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Archivos.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Archivos.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Archivos.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Archivos.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Archivos.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Archivos.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Archivos.tabSeleccionado) {
            case 'Archivos':
                Archivos.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {

        $(document).on("click", ".btn-NewArchivo", function (e) {
            e.preventDefault();
            var data = { 'seccionActivo': "seccionArchivos" };

            var dataExtra = $(this).data('extra');
            var serialize = Fn.formSerializeObject("seccionArchivos");

            serialize.seccionActivo = "Archivos";

            Object.assign(serialize, { "dataExtra": dataExtra });
            var jsonString = { 'data': JSON.stringify(serialize) };
            var config = { 'url': Gestion.urlActivo + "getFormNewArchivos", 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;

                ++modalId;
                Gestion.idModalPrincipal = modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var fn1 = 'Archivos.confirmarRegistrarArchivo();';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                btn[1] = { title: 'Registrar', fn: fn1 };

                Fn.showModal({ id: modalId, show: true, class: 'modalNewArchivo', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });

            });
        });

        $(document).on("change", "#formNewArchivo select[name='grupo']", function (e) {
            e.preventDefault();
            var idGrupoSeleccionado = $(this).val();
            var form = ($("#formNewArchivo").length == 1) ? "#formNewArchivo" : "#formUpdateArchivo";
            var selectCarpeta = $(form).find("select[name='carpeta']");
            var opcionesCarpeta = "<option value=''>-- Seleccionar --</option>";
            if (typeof carpetas[idGrupoSeleccionado] !== 'undefined') {
                $.each(carpetas[idGrupoSeleccionado], function (i, v) {
                    opcionesCarpeta += "<option value='" + v['idCarpeta'] + "'>" + v['nombreCarpeta'] + "</option>";
                });
            }
            selectCarpeta.html(opcionesCarpeta);
        });

        $(document).on('click', '.btn-DescargarArchivo', function () {

			// alert('a');
			var file = $(this).attr("data-file");
			var extension = $(this).attr("data-extension");
			var name = $(this).attr("data-name");

			var params = [];
			params['file'] = file;
			params['extension'] = extension;
			params['name'] = name;

			Archivos.download_file(params);
        });
        
        $(document).on('click', '.btn-EliminarArchivo', function (e) {
			e.preventDefault();
			++modalId;
            var idArchivo = $(this).closest('tr').data('id');

			var btn = [];
			var data = {
				id: idArchivo,
			};

			var fn0 = 'Archivos.eliminarArchivo("' + modalId + '", ' + JSON.stringify(data) + ');';
            var fn1 = 'Fn.showModal({ id:' + modalId + ', show:false });';
			btn[0] = { title: 'No', fn: fn1 };
			btn[1] = { title: 'Si', fn: fn0 };
			Fn.showModal({ id: modalId, show: true, title: 'Eliminar archivo', content: '¿Esta seguro que desea eliminar el archivo seleccionado? Esta acción será permanente.', btn: btn });
		});

    },

    confirmarRegistrarArchivo: function () {
        ++modalId;
        var idGrupo = $("#formNewArchivo select[name='grupo']").val();
        var archivosSubidos = true;
        var file = document.getElementById('archivo').files[0];

        //Verificar nombre
        var grupo = $('#grupo').val();
        if (grupo == "") {
            var title = "Subir Archivo";
            var content = "Debe seleccionar un grupo";
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            var btn = new Array();
            btn[0] = { title: 'Continuar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: title, content: content, btn: btn });
            return;
        }

        //Verificar nombre
        var grupo = $('#carpeta').val();
        if (grupo == "") {
            var title = "Subir Archivo";
            var content = "Debe seleccionar una carpeta";
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            var btn = new Array();
            btn[0] = { title: 'Continuar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: title, content: content, btn: btn });
            return;
        }

        //Verificar si se selecciono un archivo.
        if (document.getElementById('archivo').files.length == 0) {
            var title = "Subir Archivo";
            var content = "Debe de seleccionar un archivo";
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            var btn = new Array();
            btn[0] = { title: 'Continuar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: title, content: content, btn: btn });
            return;
        }

        //Verificar peso
        if (file && file.size > (30 * 1024 * 1024)) {
            var title = "Subir Archivo";
            var content = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> No puede subir archivos que pesen más de 30MB.';

            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            var btn = new Array();
            btn[0] = { title: 'Continuar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: title, content: content, btn: btn });
            return;
        }

        //Verificar nombre
        var nombre = $('#nombreArchivo').val();
        if (nombre.length > 125) {
            var title = "Subir Archivo";
            var content = "El nombre del archivo no debe ser mayor a 125 caracteres.";
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            var btn = new Array();
            btn[0] = { title: 'Continuar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: title, content: content, btn: btn });
            return;
        }

        // Verificar nombre permitido - Regex
        var regex = /^[a-z\d\-_\s]+$/i;
        var nombrePermitido = regex.test(nombre);
        if (!nombrePermitido) {
            var title = "Subir Archivo";
            var content = '<a href="javascript:;"><i class="fa fa-times-circle" ></i></a> El nombre del archivo solo puede tener caracteres alfanumericos, guiones(-) y guiones abajo(_).';
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            var btn = new Array();
            btn[0] = { title: 'Continuar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: title, content: content, btn: btn });
            return;
        }

        //Verificar duplicado
        var nombreRegistrado = $("#nombreArchivo").val();
        var idCategoria = $("#carpeta").val();
        var dataSend = { 'nombreRegistrado': nombreRegistrado, 'idCategoria': idCategoria, 'size': file.size, 'idGrupo': idGrupo };
        var jsonString = { 'data': JSON.stringify(dataSend) };
        var config = { 'url': Gestion.urlActivo + "verificarCondicionesDb", 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {
            ++modalId;
            if (a.result == 0) {
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = new Array();
                btn[0] = { title: 'Continuar', fn: fn };
                Fn.showModal({ id: modalId, show: true, title: a.msg.title, content: a.msg.content, btn: btn });
            } else {
                var btn = [];
                var fn0 = 'Archivos.guardarArchivo("' + modalId + '");';
                var fn1 = 'Fn.showModal({ id:' + modalId + ', show:false });';
                btn[0] = { title: 'No', fn: fn1 };
                btn[1] = { title: 'Si', fn: fn0 };
                Fn.showModal({ id: modalId, show: true, title: 'Subir Archivo', content: '¿Esta seguro de que desea subir el archivo?', btn: btn });
            }
        });

        // var data = Fn.formSerializeObject('formNew');
        // data.seccionActivo = Gestion.seccionActivo; 

        // var jsonString = { 'data': JSON.stringify(data) };
        // var config = { 'url': Gestion.urlActivo + Gestion.funcionRegistrarActivo, 'data': jsonString };

        // $.when(Fn.ajax(config)).then(function (a) {

        // 	if (a.result === 2) return false;
        // 	if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formNew', a.data.validaciones);

        // 	++modalId;
        // 	var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

        // 	if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-Consultar").click();';

        // 	var btn = [];
        // 	btn[0] = { title: 'Cerrar', fn: fn };
        // 	Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
        // });
    },

    guardarArchivo: function (modalId) {
        var data = {};
        var data = Fn.formSerializeObject("formNewArchivo");

        var form_data = new FormData();
        form_data.append('idCategoria', data.carpeta);
        form_data.append('nombreRegistrado', data.nombreArchivo);

        if (($('#archivo').prop('files') == null) && ($('#archivo').prop('files')[0] == null)) {
            form_data.append('file', "");
        }
        else {
            var file_data = $('#archivo').prop('files')[0];
            form_data.append('file', file_data);
        }

        var config = { 'url': Gestion.urlActivo + "registrarArchivos", 'data': form_data };

        $.when(Fn.ajaxFormData(config)).then(function (b) {
            ++modalId;
            if (b.result == 1) {
                var fn = 'Fn.showModal({ id:' + (modalId - 1) + ',show:false });Fn.showModal({ id:' + modalId + ',show:false });$(".btn-Consultar").click();';
            }
            else {
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            }
            var btn = new Array();
            btn[0] = { title: 'Continuar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: b.msg.title, content: b.msg.content, btn: btn });
        });
    },

    download_file: function (params) {
		var jsonString = { 'data': JSON.stringify({ file: params['file'], extension: params['extension'], name: params['name'] , enviarCorreo : '0' }) };
		var url =  site_url + 'gestionOperativa/archivos/descargar';
		Fn.download(url, jsonString);
    },
    
    eliminarArchivo: function (modalId_, data) {

		var jsonString = { 'data': JSON.stringify(data) };
        var config = { 'url': Gestion.urlActivo + "eliminarArchivo", 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (b) {
			++modalId;
			if (b.result == 1) {
				var fn = 'Fn.showModal({ id:' + (modalId - 1) + ',show:false });Fn.showModal({ id:' + modalId + ',show:false });$(".btn-Consultar").click();';
			}
			else {
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
			}
			var btn = new Array();
			btn[0] = { title: 'Continuar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: b.msg.title, content: b.msg.content, btn: btn });
		});
	},

}

Archivos.load();