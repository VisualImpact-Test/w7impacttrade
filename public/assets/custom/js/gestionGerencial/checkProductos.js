var CheckProductos = {

	frmRutas: 'frm-checklistproductos',
	contentDetalle: 'idContentChecklistProductos',
	url : 'gestionGerencial/checkProductos/',
	urlActivo : 'filtrar',

	load: function(){
		$( document ).ready(function() {
			$(".flt_grupoCanal").change();
			$('.chk_quiebres').hide();

		});
		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            CheckProductos.urlActivo = control.data('url');
			CheckProductos.contentDetalle = control.data('contentdetalle');
			$('.dv_tipoUsuario').show();
			$('.dv_usuario').show();
			
			if(CheckProductos.urlActivo == 'filtrar_quiebres'){
				$('.filtros_secundarios').show();
				$('.chk_quiebres').show();
				$('.dv_usuario').hide();
				$('.dv_tipoUsuario').hide();
			}

			if(CheckProductos.urlActivo == 'filtrar_fifo'){
				$('.filtros_secundarios').show();
				$('.chk_quiebres').hide();
				$('.dv_usuario').hide();
				$('.dv_tipoUsuario').hide();

			}
        });

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarVisibilidad').click();
        });

		$(document).on('click','#btn-filtrarVisibilidad', function(e){
			e.preventDefault();

			var config = {
				'idFrm' : CheckProductos.frmRutas
				,'url': CheckProductos.url + CheckProductos.urlActivo
				,'contentDetalle': CheckProductos.contentDetalle
			};

			Fn.loadReporte_validado(config);
		});

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);

			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': checkProductos.url + 'mostrarFotos', 'data': jsonString };

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
				var data=Fn.formSerializeObject( checkProductos.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+checkProductos.url+'visibilidad_pdf';
				Fn.download(url,jsonString);
			}
		});

		$(document).ready(function () {
			$(".flt_grupoCanal").change();
			$('#btn-filtrarVisibilidad').click();
		});
	}
}

CheckProductos.load();