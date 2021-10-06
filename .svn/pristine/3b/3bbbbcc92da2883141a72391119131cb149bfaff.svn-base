var Iniciativas = {

	frmIniciativas: 'frm-iniciativas',
	contentDetalleFiltrar: 'idDetalleDetallado',
	contentDetalleConsolidado: 'idDetalleConsolidado',
	url : 'gestionGerencial/iniciativas/',

	load: function(){
		$('.dvConsolidado').hide(300);
		$('.dvImplementacion').hide(300);

		

		$(document).on('click','a[name="tipoReporte"]', function(e){
			var control = $(this);
			var value = control.data('value');

			$("#tipoReporte").val(value);
			if ( value==1) {
				$('.dvDetallado').show(400);
				$('.dvConsolidado').hide(400);
			} else {
				$('.dvDetallado').hide(400);
				$('.dvConsolidado').show(400);
			}
		});

		$(document).on('change','input[name="tipoConsolidado"]', function(e){
			var  control = $(this);

			if ( control.val()==1 ) {
				$('.dvCobertura').show(400);
				$('.dvImplementacion').hide(400);
			} else {
				$('.dvCobertura').hide(400);
				$('.dvImplementacion').show(400);
			}
		});

		$(document).on('click','#btn-filtrarIniciativas', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Iniciativas.frmIniciativas
				,'url': Iniciativas.url + control.data('url')
				,'contentDetalle': Iniciativas.contentDetalleFiltrar
			};

			Fn.loadReporte(config);
		});

		$(document).on('click','.visitasDetallado', function(e){
			e.preventDefault();

			var control = $(this);
			var title = control.data('title');

			var data={ dataForm: Fn.formSerializeObject(Iniciativas.frmIniciativas), supervisor:control.data('supervisor'), usuario:control.data('usuario'), tipoVisita:control.data('tipovisita') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Iniciativas.url + 'visitasDetallado', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				
				var html = '';
					//html += '<h4><strong>'+elementoTexto+'</strong></h4>';
					//html += '<p class=""><strong>Supervisor :</strong> '+supervisorText+' <br />';
					//html += '<strong>GTM :</strong> '+usuarioText+'</p>';
					//html += '<div class="divider"></div>'
					html += a.data.html;
				Fn.showModal({ id:modalId,show:true,title:title,content:html,btn:btn, width:'90%'});

				if (a.result==1) {
					$('#tb-iniciativasConsolidadoVisitas').DataTable();
				}
			});
		})

		$(document).on('click','.elementoDetallado', function(e){
			e.preventDefault();

			var control = $(this);
			var elementoTexto = control.data('elementotexto');
			var supervisorText = control.data('supervisortext');
			var usuarioText = control.data('usuariotext');

			var data={ dataForm: Fn.formSerializeObject(Iniciativas.frmIniciativas), supervisor:control.data('supervisor'), usuario:control.data('usuario'), elemento:control.data('elemento') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Iniciativas.url + 'elementoDetallado', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				
				var html = '';
					html += '<h4><strong>'+elementoTexto+'</strong></h4>';
					html += '<p class=""><strong>Supervisor :</strong> '+supervisorText+' <br />';
					html += '<strong>GTM :</strong> '+usuarioText+'</p>';
					html += '<div class="divider"></div>'
					html += a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:'90%'});

				if (a.result==1) {
					$('#tb-iniciativasConsolidadoVisitas').DataTable();
				}
			});
		});


		$(document).on('click','#btn-iniciativas-pdf', function(e){
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
				var data=Fn.formSerializeObject( Iniciativas.frmIniciativas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+Iniciativas.url+'iniciativas_pdf';
				Fn.download(url,jsonString);
				
				// var configAjax = { 'url': Iniciativas.url + 'iniciativas_pdf', 'data': jsonString };
				// $.when( Fn.ajax(configAjax) ).then( function(a){

				// });
			}
		});


		$('#idDistribuidora').selectpicker( );
		$('#idCliente').select2( );
		$('#btn-filtrarIniciativas').click();
		
	}
}

Iniciativas.load();