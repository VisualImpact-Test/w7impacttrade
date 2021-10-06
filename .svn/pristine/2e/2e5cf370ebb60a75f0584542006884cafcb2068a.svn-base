var Asistencia = {

	frmAsistencia: 'frm-asistencia',
	contentDetalle: 'idDetalleHorizontal',
	idTableDetalle : 'tb-asistenciaDetalle',
	url : 'asistencia/',

	load: function(){

		$(document).on('click','#btn-filtrarAsistencia', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Asistencia.frmAsistencia
				,'url': Asistencia.url + control.data('url')
				,'contentDetalle': Asistencia.contentDetalle
			};

			Fn.loadReporte(config);
		});

		$('.btnReporte').on('click', function(e){
			e.preventDefault();

			var opcion  = $(this).children('input').val();
			if (opcion==1) {
				$('#dv-leyenda').show();
				$('#idDivForm').removeClass().addClass('col-md-8');
				$('.filtroCondicion').each(function(ev){ $(this).show(); });
				$('.dividerCondicion').each(function(ev){ $(this).show(); });
				$('#filtro-todos').show();
				//
				$('.tipoGrafica').hide(1000);
				$('.tipoDetalladoVertical').hide(1000);
				$('.tipoDetallado').show(1000);
			} else if (opcion==2) {
				$('#dv-leyenda').show();
				$('#idDivForm').removeClass().addClass('col-md-8');
				$('.filtroCondicion').each(function(ev){ $(this).hide(); });
				$('.dividerCondicion').each(function(ev){ $(this).hide(); });
				$('#filtro-todos').hide();
				//
				$('.tipoGrafica').hide(1000);
				$('.tipoDetalladoVertical').show(1000);
				$('.tipoDetallado').hide(1000);
			} else if (opcion==3) {
				$('#dv-leyenda').hide();
				$('#idDivForm').removeClass().addClass('col-md-12');
				//
				$('.tipoGrafica').show(1000);
				$('.tipoDetalladoVertical').hide(1000);
				$('.tipoDetallado').hide(1000);
			}
		});

		$('#ckb-todos').on('click', function(e){
			var checked = $(this).prop('checked');

			if ( checked==false) {
				$('.filtroCondicion').each(function(ev){
					var control = $(this);
					var opcion = control.val();

					control.prop("checked",false).change();
					if ( $('#'+Asistencia.idTableDetalle).length > 0) {
						$('#tb-asistenciaDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
							var data = this.node();
							$(data).find('.'+opcion).parent('tr').hide();
						});

						var page = Math.floor((Math.random() * 10) + 1);
						$('#tb-asistenciaDetalle').DataTable().page.len(page).draw();
						$('#tb-asistenciaDetalle').DataTable().page.len(20).draw();
					}
				});
			} else {
				$('.filtroCondicion').each(function(ev){
					var control = $(this);
					var opcion = control.val();

					control.prop("checked",true).change();
					if ( $('#'+Asistencia.idTableDetalle).length > 0) {
						$('#tb-asistenciaDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
							var data = this.node();
							$(data).find('.'+opcion).parent('tr').show();
						});

						var page = Math.floor((Math.random() * 10) + 1);
						$('#tb-asistenciaDetalle').DataTable().page.len(page).draw();
						$('#tb-asistenciaDetalle').DataTable().page.len(20).draw();
					}
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

		$(document).on("click",".lk-show-foto", function(){
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
	}
}

Asistencia.load();