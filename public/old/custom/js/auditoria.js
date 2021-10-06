var Auditoria = {

	frmAuditoria: 'frm-auditoria',
	contentDetalle: 'idContentAuditoria',
	url : 'auditoria/',

	load: function(){

		$(document).on('click','#btn-filtrarAuditoria', function(){
			var ruta = $('input:radio[name=tipoReporte]:checked').attr('url');
			var control = $(this);
			var config = {
				'idFrm' : Auditoria.frmAuditoria
				,'url': Auditoria.url + ruta
				,'contentDetalle': Auditoria.contentDetalle
			};

			Fn.loadReporte(config);
		});

		$('.btnReporte').on('click', function(e){
			e.preventDefault();

			var opcion  = $(this).children('input').val();
			if (opcion==1) {
				$('#dv-leyenda').show();
				$('.filtroCondicion').each(function(ev){ $(this).show(); });
				$('.dividerCondicion').each(function(ev){ $(this).show(); });
				$('#filtro-todos').show();
			} else if (opcion==2) {
				$('#dv-leyenda').show();
				$('.filtroCondicion').each(function(ev){ $(this).hide(); });
				$('.dividerCondicion').each(function(ev){ $(this).hide(); });
				$('#filtro-todos').hide();
			} else if (opcion==3) {
				$('#dv-leyenda').hide();
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
	}
}

Auditoria.load();