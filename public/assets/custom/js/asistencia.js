var Asistencia = {

	frmAsistencia: 'frm-asistencia',
	contentDetalle: 'idDetalleHorizontal',
	idTableDetalle : 'tb-asistenciaDetalle',
	url : 'asistencia/',
	tabSeleccionado: 1,
	estadoConsulta: 0,

	load: function(){
		
		$( document ).ready(function() {
			$('#btn-filtrarAsistencia').click();

			let botones_filtro =  $('.txt_filtro').length;
			if(botones_filtro > 3){
				$('.txt_filtro').hide(500);
			}else{
				$('.txt_filtro').show(500);
			}
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarAsistencia').click();
        });

		$(document).on('click','#btn-filtrarAsistencia', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Asistencia.frmAsistencia
				,'url': Asistencia.url + control.data('url')
				,'contentDetalle': Asistencia.contentDetalle
				
			};

			$.when(Fn.loadReporte_new(config)).then( () => {
				if(Asistencia.tabSeleccionado == 3){
					Asistencia.estadoConsulta = 1;
					$(".div-para-ocultar").removeClass('card');
				}
			});
		});

		$('.btnReporte').on('click', function(e){
			e.preventDefault();
			var opcion  = $(this).attr("data-value");
			Asistencia.tabSeleccionado = opcion;
			$("#tipoFormato").val(opcion);
			$(".div-para-ocultar").addClass('card');
			if (opcion==1) {
				$('#dv-leyenda').show(500);
				if ( $(".detalle-primera").length > 0   ) {
					$('#btn-filtrarAsistencia').click();
				}
			} else if (opcion==2) {
				$('#dv-leyenda').hide(500);
				if ( $(".resumen-primera").length > 0  ) {
					$('#btn-filtrarAsistencia').click();
				}

			} else if (opcion==3) {
				$('#dv-leyenda').hide(500);
				if ( $(".grafica-primera").length > 0  ) {
					$('#btn-filtrarAsistencia').click();
				}
				if(Asistencia.estadoConsulta == 1){
					$(".div-para-ocultar").removeClass('card');
				}
			}
		});

		$('#ckb-todos').on('click', function(e){
			var checked = $(this).prop('checked');
			if ( checked==false) {
				$('.filtroCondicion').each(function(ev){
					var control = $(this);
					var opcion = control.val();

					control.prop("checked",false);
					// if ( $('#'+Asistencia.idTableDetalle).length > 0) {
					// 	$('#tb-asistenciaDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
					// 		var data = this.node();
					// 		$(data).find('.'+opcion).parent('tr').hide();
					// 	});

					// 	var page = Math.floor((Math.random() * 10) + 1);
					// 	$('#tb-asistenciaDetalle').DataTable().page.len(page).draw();
					// 	$('#tb-asistenciaDetalle').DataTable().page.len(20).draw();
					// }
				});
			} else {
				$('.filtroCondicion').each(function(ev){
					var control = $(this);
					var opcion = control.val();

					control.prop("checked",true);
					// if ( $('#'+Asistencia.idTableDetalle).length > 0) {
					// 	$('#tb-asistenciaDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
					// 		var data = this.node();
					// 		$(data).find('.'+opcion).parent('tr').show();
					// 	});

					// 	var page = Math.floor((Math.random() * 10) + 1);
					// 	$('#tb-asistenciaDetalle').DataTable().page.len(page).draw();
					// 	$('#tb-asistenciaDetalle').DataTable().page.len(20).draw();
					// }
				});


			}
			Asistencia.filtrar_leyenda();
		});

		$('.filtroCondicion').on('click', function(e) {
			Asistencia.filtrar_leyenda();
		});
	


		$(document).on("click",".lk-row-1",function(e){
			var indicador = $(this).attr("data-indicador");
			var show = $(this).attr("data-show");
			if(show == "false"){
				$(this).html('<i class="fa fa-minus-circle" ></i>');
				$(this).attr("data-show","true");

				$(".row-2-"+indicador).removeClass("hide");
			} else {
				$(this).html('<i class="fa fa-plus-circle" ></i>');
				$(this).attr("data-show","false");
				//
				$(".lk-row21-"+indicador).attr("data-show","false");
				$(".lk-row21-"+indicador).html('<i class="fa fa-plus-circle" ></i>');
			
				//
				$(".row-2-"+indicador).addClass("hide");
				$(".row-21-"+indicador).addClass("hide");
			}
		});

		$(document).on("click",".lk-show-gps1", function(){
			var control = $(this);
			var data = { type: control.data('type'), latitud: control.data('latitud'), longitud: control.data('longitud') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Asistencia.url + 'mostrarMapa', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then(function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn, width:"90%" });
			});
		});

		$(document).on("click",".fotoMiniatura", function(){
			var control = $(this);
			var data = { type: control.data('type'), idUsuario: control.data('idusuario'), fecha: control.data('fecha') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Asistencia.url + 'mostrarFoto', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then(function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"FOTOS",content:a.data,btn:btn});
			});
		});

		
		$('.tipoDetalladoVertical').hide();
		$('.tipoGrafica').hide();
	},
	filtrar_leyenda: function(){
		let condiciones = [];
		$('.filtroCondicion').each(function(ev) {
				var control = $(this);
				var opcion = control.val();
				var checked = control.prop('checked');
				
				if (checked == true) {
					let name = (control.data('name'));
					condiciones.push(name);
				}
		});
		let str_condiciones = condiciones.join('|');
		if(str_condiciones == ''){
			str_condiciones = "NO CONDICIONES";
		}
		
		$('#tb-asistenciaDetalle').DataTable().column(28).search(str_condiciones,true,false).draw();		
	},
}

Asistencia.load();