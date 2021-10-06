var VerArchivos = {

	search_files: function (url, idContent, folder) {
		var data = {};
		if (folder > 0) data.folder = folder;

		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': 'gestionOperativa/VerArchivos/' + url, 'data': jsonString };
		if (folder > 0) {
			$("#content-files").show("slow");
			

		}
		$.when(Fn.ajax(config)).then(function (a) {
			if (a.result == 0) {
				++modalId;
				var btn = [];
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

				btn[0] = { title: 'Aceptar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, content: a.msg.content, btn: btn });
			} else if (a.result == 1) {
				var content = $("#" + idContent);
				content.html('<center><img src="assets/images/load_e.gif" style="width: 72px" /></center>');
				
				setTimeout(function () {
					content.html(a.data);
					
					var $datatable = $('#data-table');
					$datatable.dataTable();
					$('html,body').animate({ scrollTop: $("#content-files").offset().top }, 1000);
				}
					, 1000);

			}
		});
	},

	download_file: function (params) {

		var jsonString = { 'data': JSON.stringify({ idFile: params['idFile'], file: params['file'], extension: params['extension'], name: params['name'], usuarioDescarga: params['usuarioDescarga'], usuarioAutor: params['usuarioAutor'], usuarioCorreo: params['usuarioCorreo'], nombreGrupo: params['nombreGrupo'], nombreCategoria: params['nombreCategoria'], enviarCorreo: '1' }) };
		var url = site_url + 'gestionOperativa/VerArchivos/descargar';
		Fn.download(url, jsonString);
	},

	load: function () {

		$(document).ready(function () {
			VerArchivos.search_files('getRoot', 'root-left', 0);
			VerArchivos.search_files('getFolder', 'folder', 0);
		});

		$(document).on('click', '.lk-download', function () {
			var idFile = $(this).attr('data-idfile');
			var file = $(this).attr("data-file");
			var extension = $(this).attr("data-extension");
			var name = $(this).attr("data-name");
			var usuarioDescarga = $("#usuarioDescarga").val();
			var usuarioAutor = $(this).attr("data-usuarioautor");
			var usuarioCorreo = $(this).attr("data-usuarioautorcorreo");
			var nombreGrupo = $(this).attr("data-nombregrupo");
			var nombreCategoria = $(this).attr("data-nombrecategoria");

			var params = [];
			params['idFile'] = idFile;
			params['file'] = file;
			params['extension'] = extension;
			params['name'] = name;
			params['usuarioDescarga'] = usuarioDescarga;
			params['usuarioAutor'] = usuarioAutor;
			params['usuarioCorreo'] = usuarioCorreo;
			params['nombreGrupo'] = nombreGrupo;
			params['nombreCategoria'] = nombreCategoria;

			VerArchivos.download_file(params);
		});

		$(document).on('click', '.lk-folder', function () {
			var folder = $(this).attr("data-folder");
			VerArchivos.search_files('getFiles', 'files', folder);
		});

		$(document).on('click', '.lk-refresh-files', function () {
			var folder = $(this).attr("data-folder");
			VerArchivos.search_files('getFiles', 'files', 0);
		});

		$(".lk-format").on("click", function (e) {
			var type = $(this).attr("data-type");
			if (type == 'detail') {
				$(this).html('<i class="fa fa-th-large" aria-hidden="true"></i>');
				$(this).attr("data-type", "miniature");
				$(this).attr("title", "Miniaturas");

				$("#vista-detalle").hide("slow");
				$("#vista-miniatura").show("slow");
			} else {
				$(this).html('<i class="fa fa-th" aria-hidden="true"></i>');
				$(this).attr("data-type", "detail");
				$(this).attr("title", "Detalles");

				$("#vista-miniatura").hide("slow");
				$("#vista-detalle").show("slow");
			}

		});
	},

}
VerArchivos.load();