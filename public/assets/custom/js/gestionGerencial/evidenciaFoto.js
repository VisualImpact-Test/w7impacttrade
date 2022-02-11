var EvidenciaFotografica = {

	frmRutas: 'frm-evidenciaFoto',
	contentDetalle: 'idContentEvidenciaFotografica',
	url : 'gestionGerencial/EvidenciaFoto/',
	urlActivo : 'filtrar',

	load: function(){
		$( document ).ready(function() {
			$(".flt_grupoCanal").change();
			$('#btn-filtrar').click();

		});

		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            EvidenciaFotografica.urlActivo = control.data('url');
			EvidenciaFotografica.contentDetalle = control.data('contentdetalle');
			$('.dv_tipoUsuario').show();
			$('.dv_usuario').show();
			
        });

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrar').click();
        });

		$(document).on('click','#btn-filtrar', function(e){
			e.preventDefault();

			var config = {
				'idFrm' : EvidenciaFotografica.frmRutas
				,'url': EvidenciaFotografica.url + EvidenciaFotografica.urlActivo
				,'contentDetalle': EvidenciaFotografica.contentDetalle
			};
			
			Fn.loadReporte_validado(config);
		});

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);

			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': EvidenciaFotografica.url + 'mostrarFotos', 'data': jsonString };

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

			var elementos = new Array();
			$("input[name='check[]']:checked").each(function(){ elementos.push($(this).val()); });

			if(elementos == ""){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'ALERTA',content:'Debe seleccionar por lo menos un registro para poder descargar el PDF',btn:btn });
			} else {
				var data=Fn.formSerializeObject( EvidenciaFotografica.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+EvidenciaFotografica.url+'visibilidad_pdf';
				Fn.download(url,jsonString);
			}
		});

		$(document).on("click",".lk-tarea-foto",function(){
			var control = $(this);

			var data = { idVisitaFotos: control.data('fotos') , cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': EvidenciaFotografica.url + 'mostrarFotos', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,frm:a.data,btn:btn});
			});
		});


	
	}
}

EvidenciaFotografica.load();