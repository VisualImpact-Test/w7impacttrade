var Recover = {
	idForm: 'form-recover',
	idForm2: 'form-reset-clave',
	load: function () {

		// $("#nuevaClave2_view").on("click",function(){
		// 	$("#nuevaClave2").attr('type',"text");
		// 	$("#nuevaClave2_view").attr('id','nuevaClave2_hide');
		// })
		// $("#nuevaClave2_hide").on("click",function(){
		// 	$("#nuevaClave2").attr('type',"password");
		// 	$("#nuevaClave2_hide").attr('id','nuevaClave2_view');
		// })
		// $("#nuevaClave_view").on("click",function(){
		// 	alert('');
		// })
		// $("#claveActual_view").on("click",function(){
		// 	alert('');
		// })

		$("#btnRecuperarContrasenna").on("click", function (e) {
			e.preventDefault();
			$.when(Fn.validateForm({ id: Recover.idForm })).then(function (a) {
				if (a === true) {
					var data = {};
					data = Fn.formSerializeObject(Recover.idForm);
					var jsonString = { 'data': JSON.stringify(data) };
					var url = "recover/mail";
					var config = { url: url, data: jsonString };

					$.when(Fn.ajax(config)).then(function (b) {

						++modalId;

						if (b.result == 1) {
							var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Fn.loadPage("' + b.url + '");';
						}
						else var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

						var btn = new Array();
						btn[0] = { title: 'Continuar', fn: fn };
						Fn.showModal({ id: modalId, show: true, title: b.msg.title, content: b.msg.content, btn: btn });

					});
				}
			});

		});

		$("#btnCambiarClave").on("click", function (e) {
			e.preventDefault();

			$.when(Fn.validateForm({ id: Recover.idForm2 })).then(function (a) {
				if (a === true) {
					var data = {};
					data = Fn.formSerializeObject(Recover.idForm2);
					var jsonString = { 'data': JSON.stringify(data) };
					var url = "recover/cambiarClave";
					var config = { url: url, data: jsonString };

					$.when(Fn.ajax(config)).then(function (b) {

						++modalId;
						
						if (b.result == 1) {
							var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Fn.loadPage("' + b.url + '");';
						}
						else var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

						var btn = new Array();
						btn[0] = { title: 'Continuar', fn: fn };
						Fn.showModal({ id: modalId, show: true, title: b.msg.title, content: b.msg.content, btn: btn });

					});
				}
			});

		});

		$("#btnCambiarClaveUsuario").on("click", function (e) {
			e.preventDefault();

			$.when(Fn.validateForm({ id: Recover.idForm2 })).then(function (a) {
				if (a === true) {
					var data = {};
					data = Fn.formSerializeObject(Recover.idForm2);
					var jsonString = { 'data': JSON.stringify(data) };
					var url = "recover/cambiarClaveUsuario";
					var config = { url: url, data: jsonString };

					$.when(Fn.ajax(config)).then(function (b) {

						++modalId;
						
						if (b.result == 1) {
							var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Fn.loadPage("' + b.url + '");';
						}
						else var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

						var btn = new Array();
						btn[0] = { title: 'Continuar', fn: fn };
						Fn.showModal({ id: modalId, show: true, title: b.msg.title, content: b.msg.content, btn: btn });

					});
				}
			});

		});

		$("#menuPrincipal").on("click", function (e) {
			e.preventDefault();

		});

	}

}
Recover.load();