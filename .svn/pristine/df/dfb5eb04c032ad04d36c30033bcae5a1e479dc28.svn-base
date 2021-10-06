<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
        <input type="hidden" name="idConfClienteAud" value="<?=$idConfClienteAud?>">
        <label for='sl_materiales'><?=$nombreLista?></label><br>    
            <!-- <select  patron="requerido"  class="my_select2_modal form-control" name="sl_materiales" id="sl_materiales">
            </select> -->
			<div id="sch-materiales" class="ui search category" >
					<input type="text" id="sch-tienda-input" class="prompt form-control" name="sch-tiendas" placeholder="Buscar " style="border-radius:0rem !important">
					<input type="hidden" id="sl_materiales" name="sl_materiales" >
			</div>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
        <label for='sl_presencia'>Presencia</label><br>    
            <select  patron="requerido"  class="my_select2_modal form-control" name="sl_presencia" id="sl_presencia">
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
        </div>
    </div>
</form>
<script>

var liveStorecheckForm = {
	idModal: 0,
	load: function(){

		$('#sch-materiales').search({
			apiSettings: {
			url: site_url+'configuraciones/gestion/liveStoreCheckConf/buscar_material/<?=$idExtAudTipo?>/{query}',
			},
			minCharacters : 3,
			fields: {
				results : 'items',
				title   : 'name',
				url     : 'html_url'
			},
			onSelect: function(item){
				$('#sl_materiales').val(item.id);
			},
		});
	},


}
liveStorecheckForm.load();
</script>
