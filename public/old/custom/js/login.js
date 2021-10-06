var Login={

	enviocorreo_changepwd: function(){

		var data={};
		data=Fn.formSerializeObject("frm_mail_recover");
		var jsonString={ 'data':JSON.stringify(data) };
		var url="recover/mail";
		var config={ url:url,data:jsonString };

		$.when( Fn.ajax(config) ).then(function(b){
			if( b.result!=2 ){
				++modalId;

				var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+'login'+'");';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
			}
		});
	},

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

								var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.loadPage("'+b.url+'");';//
								
							}
							else var fn='Fn.showModal({ id:'+modalId+',show:false });';

							var btn=new Array();
							btn[0]={title:'Continuar',fn:fn};
							Fn.showModal({ id:modalId,show:true,title:b.msg.title,content:b.msg.content,btn:btn });
						}
					});
				}
			});
		});

		$("#btn_cambiar_clave").on("click",function(e){
			// alert('');
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


		
	}

}
Login.load();

if(typeof document.cookie.split(';')[0].split('=')[1] != 'undefined'){

	$('#user').val(document.cookie.split(';')[0].split('=')[1]) ;
	$("#password").val(document.cookie.split(';')[1].split('=')[1]) ;
	$('#exampleCheck').prop('checked',true);
	
}else{
	$('#user').val('');
	$('#password').val('');
}
