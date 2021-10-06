var Login={

	load: function(){

		$("#btn-login").on("click",function(e){
			e.preventDefault();

			
			$.when( Fn.validateForm({ id:"frm-login" }) ).then(function(a){
				if( a===true ){

					$usuario = $('#user').val();
					$pwd = $("#password").val();
					if($('#exampleCheck').is(':checked')){
						$recordar = 1;
					}else{
						$recordar = 0;
					}

					var data={};
					data=Fn.formSerializeObject("frm-login");
					var jsonString={ 'data':JSON.stringify(data) };
					var url="login/acceder";
					var config={ url:url,data:jsonString };

					$.when( Fn.ajax(config) ).then(function(b){
						if( b.result!=2 ){
							++modalId;

							var btn = [];
							var fn = [];

							if(b.status==1){
								
								if($recordar == 1){
									document.cookie = "uid=" + encodeURIComponent( $usuario );
									document.cookie = "pwd=" + encodeURIComponent( $pwd );
								}else{
									document.cookie = "uid=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
									document.cookie = "uid=; max-age=0";
									document.cookie = "pwd=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
									document.cookie = "pwd=; max-age=0";
								}

								fn[0] = 'Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+b.url+'");';
								localStorage.setItem('flag_anuncio_visto',b.data.flag_anuncio_visto);
								localStorage.setItem('modalCuentaProyecto', 0);
								
							}else{
								fn[0] = 'Fn.showModal({ id:'+modalId+',show:false });grecaptcha.reset();';

								if(b.status == 3){
									fn[1] = 'Login.enviarCorreo("'+b.correo+'");';
	
									btn[1] = { title:'Enviar Correo', fn:fn[1] };
								}
							}

							btn[0] = { title:'Continuar', fn:fn[0] };
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
			
			
		});

		$(document).on("click", "#btn_cambiar_clave", function(e){
			e.preventDefault();
			var data={};
			var jsonString={ 'data':JSON.stringify(data) };
			var url="recover/frm_email_changepwd";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(b){
				if( b.result!=2 ){
					++modalId;

					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
					btn[0]={title:'Cancelar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.data.content,btn:btn });
				}
			});
		});

		$(document).on("click", ".btn-changepwd", function(e){
			e.preventDefault();
			var data={};
			data=Fn.formSerializeObject("frm_mail_recover");
			var jsonString={ 'data':JSON.stringify(data) };
			var url="recover/mail";
			var config={ url:url,data:jsonString };

			$.when( Fn.ajax(config) ).then(function(b){
				if( b.result!=2 ){
					++modalId;

					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
				}
			});
		});
		
	},

	enviarCorreo: function(correo){
		var data = { 'email':correo };
		var jsonString = {
			'data': JSON.stringify(data)
		};
		var url = "recover/mail";
		var config = {
			url: url,
			data: jsonString
		};

		$.when(Fn.ajax(config)).then(function (b) {

			var idModal = ++modalId;
			var url = 'index';
			var message = Fn.message({
				'type': 1,
				'message': 'Se ha enviado un mensaje con el link de recuperación al correo especificado. El enlace solo durará 5 minutos'
			});
			var btn = [{
				'title': 'Cerrar',
				'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });Fn.loadPage("login");'
			}];

			Fn.showModal({ id:idModal,show:true,title:b.msg.title,content:b.msg.content,btn:btn,width:'800px' });

			return false;
		});
	}

}
Login.load();

if(typeof document.cookie.split(';')[0].split('=')[1] != 'undefined'){

	let pwd = '';
	let uid = '';
	
	if(document.cookie.split(';')[0].split('=')[0] == "pwd"){
		 pwd = document.cookie.split(';')[0].split('=')[1];
		 uid = document.cookie.split(';')[1].split('=')[1];
	}else if(document.cookie.split(';')[0].split('=')[0] == "uid"){
		uid = document.cookie.split(';')[0].split('=')[1];
		pwd = document.cookie.split(';')[1].split('=')[1];
	}
	
	$('#user').val(uid) ;
	$("#password").val(pwd) ;
	$('#exampleCheck').prop('checked',true);
	
}else{
	$('#user').val('');
	$('#password').val('');
}