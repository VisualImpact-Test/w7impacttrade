var Rutas = {

	frmRutas: 'frm-rutas',
	contentDetalle: 'idContentRutas',
	url : 'rutas/',

	load: function(){

		$('.tipoGrafica').hide();

		$(document).on('click','#btn-filtrarRutas', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Rutas.frmRutas
				,'url': Rutas.url + control.data('url')
				,'contentDetalle': Rutas.contentDetalle
			};

			Fn.loadReporte(config);
		});

		$('.btnReporte').on('click', function(e){
			var opcion = $(this).children('input').val();

			if ( opcion==1 ) {
				$('.tipoGrafica').hide(1000);
				$('.tipoDetallado').show(1000);
			} else if ( opcion==2 ) {
				$('.tipoGrafica').show(1000);
				$('.tipoDetallado').hide(1000);
			}
		});

		$(document).on('click', '.lk-show-gps1', function(){
			var control =  $(this);
			var latitud = control.data('latitud');
		    var longitud = control.data('longitud');
		    var latitud_cliente = control.data('latitud-cliente');
		    var longitud_cliente = control.data('longitud-cliente');
			//
			var cliente = control.data('cliente');
			var usuario = control.data('usuario');
			var perfil = control.data('perfil');
			//
		    var type = control.data('type');

		    var data = { type:type, latitud:latitud, longitud:longitud,latitud_cliente:latitud_cliente,longitud_cliente:longitud_cliente, cliente:cliente, usuario:usuario, perfil:perfil };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Rutas.url + 'mostrarMapa', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn, width:"90%" });
			});
		});

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);
			//
			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Rutas.url + 'mostrarFotos', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn});
			});
		});

		$(document).on("click",".lk-incidencia-foto",function(){
			//
			var cliente = $(this).attr('data-cliente');
			var usuario = $(this).attr('data-usuario');
			var perfil = $(this).attr('data-perfil');
			//
			var fotoUrl=$(this).attr('data-fotoUrl');
			var hora=$(this).attr('data-hora');
			var html_content = $(this).attr('data-html');
			var img='<img src="'+(fotos_url+'/incidencias/'+fotoUrl)+'" class="img-responsive center-block img-thumbnail" />';
			var html = '';
					html += '<h4><strong>'+cliente+'</strong></h4>';
					html += '<p class="user-name">Perfil: '+perfil+' <br />';
					html += 'Usuario: '+usuario+'</p>';				
				html += '<div class="row" >'
				html += '<div class="col-md-6" >Incidencia: <strong>'+html_content+'</strong></div>';
				html += '<div class="col-md-6" >Hora: <strong>'+hora+'</strong></div>';
				html += '</div>';
			html += '<hr />';
			html += img;
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"FOTO INCIDENCIA",content:html,btn:btn});
		});

		$(document).on('click', '.lk-detalle', function(){
			var control = $(this);
			var idVisita = control.data('visita');
			var title = control.data('title');
			var modulo = control.data('modulo');
			//
			var cliente = control.data('cliente');
			var usuario = control.data('usuario');
			var perfil = control.data('perfil');
			//
			var data = { idVisita:idVisita, modulo: modulo };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Rutas.url + 'detalle', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var html = '';
					html += '<h4><strong>'+cliente+'</strong></h4>';
					html += '<p class="user-name">Perfil: '+perfil+' <br />';
					html += 'Usuario: '+usuario+'</p>';
					html += a.data;
				Fn.showModal({ id:modalId,show:true,title:title,content:html,btn:btn, width:"80%"});
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
	}
}

Rutas.load();