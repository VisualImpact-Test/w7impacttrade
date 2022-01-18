var Rutas = {

	frmRutas: 'frm-rutas',
	contentDetalle: 'idContentRutas',
	filas : [],
	url : 'rutas/',
	customTable: '',

	load: function(){

		$('.tipoGrafica').hide();
		$( document ).ready(function() {
			$(".flt_grupoCanal").change();
		});

		$(document).on('click','#btn-filtrarRutas', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Rutas.frmRutas
				,'url': Rutas.url + control.data('url')
				,'contentDetalle': Rutas.contentDetalle
			}; 

			$.when(Rutas.loadReporte_new(config)).then(function(){
				
			});
		});

		$('.btnReporte').on('click', function (e) {
			e.preventDefault();
			var opcion = $(this).attr("data-value");

			if (opcion == 1) {

				$('#idTipoFormato').val(1);
				$('.tipoGrafica').hide(500);
				$('.tipoDetallado').show(500);
				if ($(".tipoDetallado").find('.noResultado').length > 0) {
					$('#btn-filtrarRutas').click();
				}

			} else if (opcion == 2) {
				$('#idTipoFormato').val(2);
				$('.tipoGrafica').show(500);
				$('.tipoDetallado').hide(500);
				if ($(".tipoGrafica").find('.noResultado').length > 0) {
					$('#btn-filtrarRutas').click();
				}

			}
		});

		$(document).on('dblclick', '.btnReporte', function (e) {
            $('#btn-filtrarRutas').click();
        });

		$(document).on('click', '.lk-show-gps1', function(){
			var control =  $(this);
			var latitud = control.data('latitud');
			var longitud = control.data('longitud');
			var latitud_cliente = control.data('latitud-cliente');
			var longitud_cliente = control.data('longitud-cliente');

			var cliente = control.data('cliente');
			var usuario = control.data('usuario');
			var perfil = control.data('perfil');

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

		$(document).on("click",".lk-ruta-foto",function(){
			var control = $(this);

			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Rutas.url + 'mostrarFotos', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,frm:a.data,btn:btn});
			});
		});

		$(document).on("click",".lk-incidencia-foto",function(){
			var cliente = $(this).attr('data-cliente');
			var usuario = $(this).attr('data-usuario');
			var perfil = $(this).attr('data-perfil');

			var fotoUrl=$(this).attr('data-fotoUrl');
			var hora=$(this).attr('data-hora');
			var html_content = $(this).attr('data-html');
			var img='<img src="'+(fotos_url+'incidencias/'+fotoUrl)+'" class="img-responsive center-block img-thumbnail" />';
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

			var cliente = control.data('cliente');
			var usuario = control.data('usuario');
			var perfil = control.data('perfil');

			var data = { idVisita:idVisita, modulo: modulo };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Rutas.url + 'detalle', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var html = '';
					html += '<div class="text-center"><h2><strong>'+cliente+'</strong></h2><hr></div>';
					html += '<div style="margin-bottom:5px;">';
						html += '<label style="font-weight: bold;font-size: 15px;">Perfil: <label class="user-name" style="font-weight: 200;">'+perfil+'</label></label><br>';
						html += '<label style="font-weight: bold;font-size: 15px;">Usuario: <label style="font-weight: 200;">'+usuario+'</label></label><br>';
					html += '</div>';
					html += a.data;
				Fn.showModal({
					id: modalId,
					show: true,
					title: title,
					frm: html,
					btn: btn,
					width:"80%"
				});
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
			Fn.showModal({ id:modalId,show:true,title:"ZOOM FOTO",frm:html,btn:btn});
		});
		
		setTimeout(function(){
			$('#btn-filtrarRutas').click();
		}, 1000);

		$('#ckb-todos').on('click', function(e){
			var checked = $(this).prop('checked');
			if ( checked==false) {
				$('.filtroCondicion').each(function(ev){
					var control = $(this);
					var opcion = control.val();

					control.prop("checked",false);

				});
			} else {
				$('.filtroCondicion').each(function(ev){
					var control = $(this);
					var opcion = control.val();

					control.prop("checked",true);

				});
			}
			Rutas.filtrar_leyenda();
		});
		$('.rd-rutas').on('click', function(e){
			var inp=$(this);
			if (inp.is(".theone")) {
				inp.prop("checked",false).removeClass("theone");
			} else {
				$("input:radio[name='"+inp.prop("name")+"'].theone").removeClass("theone");
				inp.addClass("theone");
			}
		});

		$('.filtroCondicion').on('click', function(e) {
			Rutas.filtrar_leyenda();
		});


		$(document).on("click",".tabVerFotos",function(){
			var control = $(this);
			var id=control.data("value");
			if(id==1){
				$("#idModuloFotos").show();
				$("#idOtrosModulos").hide();
			}else{
				$("#idModuloFotos").hide();
				$("#idOtrosModulos").show();
			}
		});

		$(document).on("click",".tabCheckProductos",function(){
			var control = $(this);
			var id=control.data("value");
			if(id==1){
				$("#idCheckProductosCuenta").show();
				$("#idCheckProductosCuentaComp").hide();
			}else{
				$("#idCheckProductosCuenta").hide();
				$("#idCheckProductosCuentaComp").show();
			}
		});
		
	},
	loadReporte_new: function( config = {}){
		var data = Fn.formSerializeObject(config.idFrm);
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': config.url, 'data': jsonString };

		$.when( Fn.ajax_new(configAjax) ).then(function(a){
			if ( a['status'] == null) {
				return false;
			}

			if ( typeof a.data.views !== 'undefined' ) {
				$.each(a.data.views, function(id,value){
					$('#'+id).html('');
					$('#'+id).html(value.html);
					if ( typeof value.datatable !== 'undefined') {
			
					}
				});
			} else {
				$('#'+config.contentDetalle).html(a.data.html);
				if ( a.result==1 ) {
					if ( typeof a.data.datatable !== 'undefined') {
					
						Rutas.customTable = $('#'+a.data.datatable)
						.DataTable(
							{
								data:a.data.data,
								rowCallback: function(row, data, index) {
									// $(row).find('td:gt(27)').addClass('text-center');
									// $(row).find('td:gt(27)').addClass('tdDisabledRuta');
									$.each($(row).find('td'),function(i,v){
										if(($(this).find('p').length) >= 1 ){
											let classtd = ($(this).find('p').attr('class').split(' '));
											let clasessCelda = classtd.join(' ');
	
											$(this).addClass(clasessCelda);
										}
										if(($(this).find('custom').length) >= 1 ){
											let classtd = ($(this).find('custom').data('clases').split(' '));
											let clasessCelda = classtd.join(' ');
	
											$(this).addClass(clasessCelda);
										}
									});
								}
							}
						)
					}
				}
			}

			Fn.showLoading(false);
		});
	},
	filtrar_leyenda: function(){
		let condiciones = [];
		$('.filtroCondicion').each(function(ev) {
				var control = $(this);
				var opcion = control.val();
				var checked = control.prop('checked');
				
				if (checked == true) {
					let name = opcion;
					condiciones.push(name);
				}
		});
		let str_condiciones = condiciones.join('|');
		if(str_condiciones == ''){
			str_condiciones = "NO CONDICIONES";
		}
		let columnaCondicion = Rutas.customTable.columns('.colCondicion').indexes()[0];
		Rutas.customTable.column(columnaCondicion).search(str_condiciones,true,false).draw();
	},
}

Rutas.load();