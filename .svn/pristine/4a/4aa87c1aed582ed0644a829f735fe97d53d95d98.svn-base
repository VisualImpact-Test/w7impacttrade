var auditoria = {
    idForm: 'form-auditoria',
    url: 'auditoriabd/',

    load: function(){

        $('.btn-consultar').on('click', function(e){
            e.preventDefault();

            var tabla = [];
			tabla[0] = 'div-ajax-auditoria';
			
            var data = Fn.formSerializeObject(auditoria.idForm);
			var jsonString = { 'data': JSON.stringify(data) };
			var url = auditoria.url+'listaAuditoria';
			var config = { url:url, data:jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if( a.result == 0 ){
					++modalId;
					var btn = [];
                    var fn = 'Fn.showModal({ id:'+modalId+',show:false });';
                    
					btn[0] = {title:'Aceptar', fn:fn};
					Fn.showModal({ id:modalId, show:true, title:a.msg.title, content:a.msg.content, btn:btn });
				}
				else if( a.result == 1 ){
                        Fn.replaceContentHtml(tabla[0], a.data.html);
				}
			});
        });
		$('.btn-consultar').click();
    }
}
auditoria.load();