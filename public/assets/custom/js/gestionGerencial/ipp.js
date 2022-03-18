var Ipp={

	idForm: 'form-ipp',
	idDiv: 'idContentResumenNews',
	url: 'gestionGerencial/ipp/',
    urlActivo: 'resumen_nuevo',

	load: function(){
		$('select[name="sl-cuenta"]').html(Fn.selectOption('cuentas'));
		$('select[name="sl-departamento"]').html(Fn.selectOption('departamentos')).select2({width: '100%'});
		$('select[name="sl-encargado"]').html(Fn.selectOption('encargado',[$('#cuenta_filtro').val(),$('#proyecto_filtro').val()])).select2({width: '100%'});
		$('select[name="sl-cuenta"]').change();
		$('select[name="sl-proyecto"]').change();
		$( document ).ready(function() {
			$(".flt_grupoCanal").change();
			$("#btn-ipp-consultar").click();
		});
        $(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            Ipp.urlActivo = control.data('url');
			Ipp.idDiv = control.data('contentdetalle');

        });
        $(document).on('click', '#btn-mas-filtros', function (e) {
			setTimeout(function(){
				$('.modal-backdrop').css('z-index','1024');
			}, 500);
        });
		$(document).on('change','select[name="sl-departamento"]', function(){
			var idDepartamento=$('select[name="sl-departamento"]').val();
			$('select[name="sl-provincia"]').html(Fn.selectOption('provincias',[idDepartamento])).select2({width: '100%'});
			$('select[name="sl-distrito"]').html(Fn.selectOption('distritos')).select2({width: '100%'});
		})
		
		$(document).on('change','select[name="sl-provincia"]', function(){
			var idDepartamento=$('select[name="sl-departamento"]').val();
			var idProvincia=$(this).val();
			$('select[name="sl-distrito"]').html(Fn.selectOption('distritos',[idDepartamento,idProvincia])).select2({width: '100%'});
		})
		

		$(document).on('change','input[name="tipo-reporte"]:checked', function(){
			var valor = $(this).val();
			if( valor == 5  ){
				$('.anio').removeClass('hide');
				$('.mes').removeClass('hide');
				$('.fechas').addClass('hide');
			} else if(valor == 4){
				$('.anio').removeClass('hide');
				$('.mes').addClass('hide');
				$('.fechas').addClass('hide');
			} else {
				$('.anio').addClass('hide');
				$('.mes').addClass('hide');
				$('.fechas').removeClass('hide');
			}
		});
		
		$(document).on('change','select[name="sl-canal"]', function(){
			if ( document.getElementById("sl-hfs").length > 2 ) { 
				$('#tabTradicionales').removeClass('hidden');
				$('#tab-tradicionales').removeClass('hidden');
			};
		});

		$(document).on('change','select[name="sl-banner"]', function(){
			var obj = $(this);
			Ipp.sendSelect( obj );
		});

		$(document).on('change','input[name="tipo-reporte"]:checked', function(){
			var obj = $(this);
			console.log(obj.val());
			if (obj.val()==4) {
				$('#sl-anio').attr('patron', 'requerido');
			} if (obj.val()==5) {
				$('#sl-anio').attr('patron', 'requerido');
				$('#sl-mes').attr('patron', 'requerido');
			} else{
				
			}
		});

		//FILTROS MODERNOS
		$(".filtrosModerno").on("change",function(e){
			e.preventDefault();
			
			var banner=$('#sl-banner').val();
			var cadena=$('#sl-cadena').val();
			
			if(banner!='' && cadena!='' ){
				var data={"idBanner":banner,"idCadena":cadena};
				var jsonString={ 'data':JSON.stringify( data ) };
				var url= Ipp.url+"obtener_clientesFiltro";

				$.when(
					Fn.ajax( {'url':url,'data':jsonString} )
				).then(function( a ){
					$("#sl-tienda").empty();
					var contenido='<option value="" class="label label-success" >PDV</option>';
					$.each(a.data.clientes,function(im,vm){
						contenido+='<option value="'+vm.idCliente+'" >'+vm.razonSocial+'</option>';
					});
					$("#sl-tienda").append(contenido).select2({width: '100%'});;
				});
			}
		});
		
		$(document).on("click",".lk-row-1",function(e){
			var indicador = $(this).attr("data-indicador");
			var show = $(this).attr("data-show");
			if(show == "false"){
				$(this).html('<i class="fa fa-minus-circle" ></i>');
				$(this).attr("data-show","true");
				//
				$(".row-2-"+indicador).removeClass("hide");
				//$(".row-21-"+indicador).removeClass("hide");
			} else {
				$(this).html('<i class="fa fa-plus-circle" ></i>');
				$(this).attr("data-show","false");
				//
				$(".lk-row21-"+indicador).attr("data-show","false");
				$(".lk-row21-"+indicador).html('<i class="fa fa-plus-circle" ></i>');
				console.log(".lk-row21-"+indicador);
				//
				$(".row-2-"+indicador).addClass("hide");
				$(".row-21-"+indicador).addClass("hide");
			}
			console.log(indicador);
		});

		$(document).on('click','#btn-ipp-consultar', function(e){
			e.preventDefault();

			var data = Fn.formSerializeObject(Ipp.idForm);

			var jsonString={ 'data':JSON.stringify(data) };
			var method=$('#'+Ipp.idForm+' input[name="tipo-reporte"]:checked').attr('url');
			var config={'url':Ipp.url+Ipp.urlActivo,'data':jsonString};
			
			$.when( Fn.ajax(config)).then(function(a){
				$("#msg-storecheckVirtual").remove();
				if( a.result==0 ){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=[];
					btn[0]={ title:'Aceptar', fn: fn};

					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.msg.content,btn:btn });

				} else if( a.result==1 ){
					$('#'+Ipp.idDiv).html(a.data);
					View.showTable('#tb-detalle');
				} else {
					var obj = $('input[name="tipo-reporte"]:checked').val();
					
					if (obj==4) {
						$("#"+Ipp.idForm).append( '<div id="msg-storecheckVirtual" class="label label-danger label-space" ></div>' );
						$("#msg-storecheckVirtual").append( '<i class="fa fa-exclamation-circle" ></i> SELECCIONE UN AÑO.' ).trigger("create");
					} if (obj==5) {
						$("#"+Ipp.idForm).append( '<div id="msg-storecheckVirtual" class="label label-danger label-space" ></div>' );
						$("#msg-storecheckVirtual").append( '<i class="fa fa-exclamation-circle" ></i> SELECCIONE UN AÑO Y MES.' ).trigger("create");
					} else{
						$("#"+Ipp.idForm).append( '<div id="msg-storecheckVirtual" class="label label-danger label-space" ></div>' );
						$("#msg-storecheckVirtual").append( '<i class="fa fa-exclamation-circle" ></i> DEBE SELECCIONAR UN TIENDA.' ).trigger("create");
					}
					
					//$("#"+Ipp.idForm).append( '<div id="msg-storecheckVirtual" class="label label-danger label-space" ></div>' );
					//$("#msg-storecheckVirtual").append( '<i class="fa fa-exclamation-circle" ></i> DEBE SELECCIONAR UN TIENDA.' ).trigger("create");
				}
			})			
		});

        $(document).on('dblclick', '.card-body > ul > li > a', function (e) {
    		$("#btn-ipp-consultar").click();
        });


		$("#btn-filtrar-modal").on("click", function(e){ $("#btn-ipp-consultar").click(); })
	},
	


	sendSelect: function(obj){
		data = Fn.formSerializeObject( Ipp.idForm );

	},
	
	
	
}

Ipp.load();