var OrdenTrabajo = {

	frmOrdenTrabajo: 'frm-ordenTrabajo',
	contentDetalle: 'idContentOrdenTrabajo',
	url : 'gestionGerencial/ordenTrabajo/', 

	load: function(){

		$(document).on('click','#btn-filtrarOrdenTrabajo', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : OrdenTrabajo.frmOrdenTrabajo
				,'url': OrdenTrabajo.url + control.data('url')
				,'contentDetalle': OrdenTrabajo.contentDetalle
			}; 
			Fn.loadReporte_new(config);
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarOrdenTrabajo').click();
        });

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);

			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': OrdenTrabajo.url + 'mostrarFotos', 'data': jsonString };

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

		$(document).on("click",".check_habilitar",function(){
			var idVisitaVisibilidad = $(this).attr("data-idVisitaVisibilidad")
			var idElemento = $(this).attr("data-idElemento")
			var estado_ini = $(this).attr("data-estado")
			var value= $(this).prop("checked"); 
			var id=$(this).attr("id");
			var msg="";
			var estado=0;

			if(value==1){
				msg="Desea habilitar la Orden de Trabajo para el elemento seleccionado?";
				estado=1;
			}else{
				estado=0;
				msg="Desea inhabilitar la Orden de Trabajo para el elemento seleccionado? ";
			}
			++modalId;
			var fn='OrdenTrabajo.actualizar_habilitar('+idVisitaVisibilidad+','+idElemento+','+estado+');';
			var fn1='Fn.showModal({ id:'+modalId+',show:false });$(".modal-stack").removeClass("modal-backdrop");$("#'+id+'").prop("checked",'+estado_ini+');';
			var btn=new Array();
				btn[0]={title:'Actualizar',fn:fn};
				btn[1]={title:'Cancelar',fn:fn1};
			Fn.showModal({ id:modalId,show:true,title:"Actualizar Anulacion",frm:msg,btn:btn,width:'50%'});  
		});

		$(document).on("click",".check_validar",function(){
			var idVisitaOrdenTrabajoDet = $(this).attr("data-idVisitaOrdenTrabajoDet")
			var estado_ini = $(this).attr("data-estado")
			var value= $(this).prop("checked"); 
			var id=$(this).attr("id");
			var msg="";
			var estado=0;
			console.log(value==1);
			if(value==1){
				msg="Desea validar el elemento visibilidad auditoria para el cliente seleccionado?";
				estado=1;
			}else{
				estado=0;
				msg="Desea habilitar la validacion del elemento visibilidad auditoria para el cliente seleccionado? ";
			}
			
			++modalId;
			var fn='OrdenTrabajo.actualizar_validar('+idVisitaOrdenTrabajoDet+','+estado+');';
			var fn1='Fn.showModal({ id:'+modalId+',show:false });$(".modal-stack").removeClass("modal-backdrop");$("#'+id+'").prop("checked",'+estado_ini+');';
			var btn=new Array();
				btn[0]={title:'Actualizar',fn:fn};
				btn[1]={title:'Cancelar',fn:fn1};
			Fn.showModal({ id:modalId,show:true,title:"Actualizar Anulacion",frm:msg,btn:btn,width:'50%'});  
		});

		$(document).on('click','#btn-ordenTrabajo-pdf', function(e){
			e.preventDefault();

			var elementos = new Array();
			$("input[name='check_pdf[]']:checked").each(function(){
				var idVisitaVisibilidad= $(this).attr("data-idVisitaVisibilidad")
				var idElemento = $(this).attr("data-idElemento")
				elementos.push( idVisitaVisibilidad+'_'+idElemento ); 
			});

			if(elementos == ""){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'ALERTA',content:'Debe seleccionar por lo menos un registro para poder descargar el PDF',btn:btn });
			} else {
				var data=Fn.formSerializeObject( OrdenTrabajo.frmOrdenTrabajo );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+OrdenTrabajo.url+'ordenTrabajo_pdf';
				Fn.download(url,jsonString);
			}
		});

		$(document).ready(function () {
			$('#btn-filtrarOrdenTrabajo').click();
			$(".flt_grupoCanal").change();
		});
	}
	,
	actualizar_habilitar: function(idVisitaVisibilidad,idElemento,estado){
		var data = {'idVisitaVisibilidad':idVisitaVisibilidad,'idElemento':idElemento,'estado':estado }
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': OrdenTrabajo.url + 'habilitarOrdenTrabajo', 'data': jsonString };

		$.when( Fn.ajax(configAjax) ).then( function(a){
			console.log(a);
			++modalId;
			var fn='Fn.showModal({ id:'+(modalId)+',show:false });Fn.showModal({ id:'+(modalId--)+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn, width:"40%"});
		});
	},
	actualizar_validar: function(idVisitaOrdenTrabajoDet,estado){
		var data = {'idVisitaOrdenTrabajoDet':idVisitaOrdenTrabajoDet,'estado':estado }
		var jsonString={ 'data':JSON.stringify( data )  };
		var configAjax = { 'url': OrdenTrabajo.url + 'validarOrdenTrabajo', 'data': jsonString };

		$.when( Fn.ajax(configAjax) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+(modalId)+',show:false });Fn.showModal({ id:'+(modalId--)+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn, width:"40%"});
		});
	},
}

OrdenTrabajo.load();