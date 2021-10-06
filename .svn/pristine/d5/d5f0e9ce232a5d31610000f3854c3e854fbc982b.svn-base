var Surtido = {

	frmRutas: 'frm-surtido',
	contentDetalle: 'idContentSurtido',
	url : 'gestionGerencial/surtido/', 

	load: function(){

		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
        });

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrar').click();
        });

		$(document).on('click','#btn-filtrar', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Surtido.frmRutas
				,'url': Surtido.url + control.data('url')
				,'contentDetalle': Surtido.contentDetalle
			}; 
			Fn.loadReporte_new(config);
		});

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);
			//
			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Surtido.url + 'mostrarFotos', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn});
			});
		});

	

		$(document).on("click",".lk-foto",function(){
			var control = $(this);
			var fotoUrl = control.data('fotourl');
			//var hora=control.data('hora');
			//var html_content = control.data('html');
			var img='<img src="'+fotoUrl+'" class="img-responsive center-block img-thumbnail" />';
			var html = img;
			
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"ZOOM FOTO",content:html,btn:btn});
		});

		$(document).on('click','#btn-visibilidad-pdf', function(e){
			e.preventDefault();
			//
			var elementos = new Array();
			$("input[name='check[]']:checked").each(function(){ elementos.push($(this).val()); });
			//
			if(elementos == ""){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'ALERTA',content:'Debe seleccionar por lo menos un registro para poder descargar el PDF',btn:btn });
			} else {
				var data=Fn.formSerializeObject( Surtido.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+Surtido.url+'visibilidad_pdf';
				Fn.download(url,jsonString);
				
				// var configAjax = { 'url': Surtido.url + 'visibilidad_pdf', 'data': jsonString };
				// $.when( Fn.ajax(configAjax) ).then( function(a){

				// });
			}
		});
		
		setTimeout(
					function(){
						$('#btn-filtrar').click();
					}
					, 1000);
	}
}

Surtido.load();