var Carga_masiva_general = {
	data: new Array(),
	load: function(){
		
		$(document).on('click','.form_carga_masiva_general', function(e){
        	e.preventDefault();
			var tipo = $(this).attr('data-tipo');
        	var data ={tipo:tipo};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = {'url': 'carga_masiva_general/form_carga', 'data': jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Basemadre.continuarSegmentacionCliente();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				switch( a.data.htmlButtons ){
					case 1:
						btn[0]={title:'Cerrar', fn:fn2};
					break;
					case 2:
						btn[0]={title:'Continuar',fn:fn1};
						btn[1]={title:'Cerrar',fn:fn2};
					break;
					default:
						btn[0]={title:'Cerrar', fn:fn2};
					break;
				}
					
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'50%'});
				Basemadre.idModal = modalId;
			});
        });					 
		$(document).on('click','.carga_masiva_general', function(e){
			var file_data = $('#archivo').prop('files')[0];
			var file_name = file_data.name;
			var formato = file_name.split(".");	
			var tipo =  $(this).attr('data-tipo');
			
			if(tipo==1){
				Carga_masiva_general.data['id'] = $(this).attr('data-id');
				Carga_masiva_general.data['fecIni'] = $(this).attr('data-fecIni');	
				Carga_masiva_general.data['fecFin'] = $(this).attr('data-fecFin');	
				Carga_masiva_general.data['tipo'] = $(this).attr('data-tipo');	
			}else if(tipo==2){
				Carga_masiva_general.data['tipo'] = $(this).attr('data-tipo');	
				Carga_masiva_general.data['grupocanal'] = $('#grupocanal').val();
			}
			var form_data = new FormData();             
				form_data.append('tipo', tipo); 
				form_data.append('id', Carga_masiva_general.data['id']); 
			$.ajax({
				url: site_url+'index.php/carga_masiva_general/validar_carga',
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				beforeSend: function(){
					Fn.showLoading(true,'Procesando');
				},
				success: function(a){
					
					var total = a.data;
					console.log(total);
					if(total==0){
						Carga_masiva_general.cargar_archivos(Carga_masiva_general.data);
						Fn.showLoading(false);
					}else{
						Fn.showLoading(false);
						++modalId;
						var fn1='Carga_masiva_general.cargar_archivos(Carga_masiva_general.data);Fn.showModal({ id:'+modalId+',show:false });';
						var fn2='Fn.showModal({ id:'+modalId+',show:false });';
						var btn=new Array();
							btn[0]={title:'Continuar',fn:fn1};
							btn[1]={title:'Cerrar',fn:fn2};
						var message = Fn.message({ 'type': 3, 'message': 'Ya se realizo una carga si continua se reemplazara la informacion anterior por la actual.' });
						Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true}); 
					}
				},
			});
		});
		
	},
	
	cargar_archivos: function(data) {
		var file_data = $('#archivo').prop('files')[0];
		var file_name = file_data.name;
        var formato = file_name.split(".");	
		var tipo = data['tipo'];
        var id = data['id'];	
        var fecIni = data['fecIni'];
        var fecFin = data['fecFin'];	
		var idGrupoCanal = data['grupocanal'];									   
	 
		var form_data = new FormData();             
			form_data.append('file', file_data); 
			form_data.append('id', id); 
			form_data.append('fecIni', fecIni); 
			form_data.append('fecFin', fecFin); 
			form_data.append('tipo', tipo);
			form_data.append('idGrupoCanal', idGrupoCanal);

		if((formato[1]=='csv')||(formato[1]=='CSV')){	
			$.ajax({
				url: site_url+'index.php/carga_masiva_general/cargar_archivos',
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				beforeSend: function(){
					Fn.showLoading(true,'Procesando');
				},
				success: function(a){
					$("#cargas_detalles").empty();
					$("#cargas_detalles").html(a.data);
					Fn.showLoading(false);
					setTimeout(Carga_masiva_general.ejecutarBat, 0 )
				},
			});
		} else {

		} 
	},
	ejecutarBat: function(){
		$.ajax({
			type: "POST",
			url: site_url+'bat_base_madre_solicitudes.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},
}
Carga_masiva_general.load();