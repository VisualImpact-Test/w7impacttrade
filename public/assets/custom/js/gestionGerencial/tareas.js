var Tareas = {

	frmRutas: 'frm-tareas',
	contentDetalle: 'idContentTareas',
	url : 'gestionGerencial/tarea/',
	urlActivo : 'filtrar',

	load: function(){
		$( document ).ready(function() {
			$(".flt_grupoCanal").change();
			$('#btn-filtrar').click();

		});

		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            Tareas.urlActivo = control.data('url');
			Tareas.contentDetalle = control.data('contentdetalle');
			$('.dv_tipoUsuario').show();
			$('.dv_usuario').show();
			
        });

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrar').click();
        });

		$(document).on('click','#btn-filtrar', function(e){
			e.preventDefault();

			var config = {
				'idFrm' : Tareas.frmRutas
				,'url': Tareas.url + Tareas.urlActivo
				,'contentDetalle': Tareas.contentDetalle
			};
			console.log(config)
			Fn.loadReporte_validado(config);
		});

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);

			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Tareas.url + 'mostrarFotos', 'data': jsonString };

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
				var data=Fn.formSerializeObject( Tareas.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+Tareas.url+'visibilidad_pdf';
				Fn.download(url,jsonString);
			}
		});

		$(document).on("click",".lk-tarea-foto",function(){
			var control = $(this);

			var data = { idVisitaFotos: control.data('fotos') , cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Tareas.url + 'mostrarFotos', 'data': jsonString };

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

Tareas.load();