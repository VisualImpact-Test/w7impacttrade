var Inteligencia = {

	frmInteligencia: 'frm-inteligencia',
	contentDetalle: 'idContentInteligencia',
	url : 'gestionGerencial/inteligencia/', 

	load: function(){


		$(document).on('click','#btn-filtrarInteligencia', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Inteligencia.frmInteligencia
				,'url': Inteligencia.url + control.data('url')
				,'contentDetalle': Inteligencia.contentDetalle
			}; 
			Fn.loadReporte_new(config);
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarInteligencia').click();
        });

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);

			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Inteligencia.url + 'mostrarFotos', 'data': jsonString };

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
		
		$('#idTipo').select2( );

		$(document).ready(function () {
			$('#btn-filtrarInteligencia').click();
			$(".flt_grupoCanal").change();
		});
	}
}

Inteligencia.load();