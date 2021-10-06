
<form id="formCargaMasiva" role="form">
    <div class="row">
        <div class="col-md-12" id="divTablaCargaMasiva">

            <ul class="nav nav-tabs" role="tablist">
                <?php foreach ($hojas as $key => $row) { ?>
                    <li class="nav-item">
                        <a class="tabCargaMasiva nav-link <?= ($key == 0) ? 'active' : '' ?>" id="hoja<?= $key ?>-tab" data-nrohoja="<?= $key ?>" data-toggle="tab" href="#hoja<?= $key ?>" role="tab" aria-controls="hoja<?= $key ?>" aria-selected="true"><?= $row ?></a>
                    </li>
                <?php } ?>
            </ul>
                              

            <div class="tab-content mt-4 text-white">
            <div class='form-row'>
                <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
                    <label for='sl_plazas'>Plazas</label><br>    
                    <select  patron="requerido"  class="my_select2_modal form-control" name="sl_plazas" id="sl_plazas">
                        <?=htmlSelectOptionArray($plazas)?>
                    </select>
                </div>
                <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
                    <label for='sl_cliente'>Cliente</label><br>    
                    <select  patron="requerido"  class="my_select2_modal form-control" name="sl_cliente" id="sl_cliente">
                        
                    </select>
                </div>
                <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
                    <label for='codCliente'>Codigo Cliente</label><br>    
                    <div class="input-group">
                        <input type="text" class="form-control" id="codCliente" placeholder="Código Cliente">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary fa fa-copy copiarCod" onclick="setClipboardText('AA')" type="button" title="Copiar Código"></button>
                        </div>
                    </div>
                </div>
            </div>
                <?php foreach ($hojas as $key => $row) { ?>
                    <div class="tab-pane <?= ($key == 0) ? 'show active' : '' ?>" id="hoja<?= $key ?>" role="tabpanel" aria-labelledby="hoja<?= $key ?>-tab">
  
                        <div class="row">
                            <div class="col-md-12">
                                <div id="divHT<?= $key ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</form>
<script>
    $('.my_select2_modal').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
    $('#sl_confClienteAud').on('change',function(){
        if($(this).val()!= ''){
            $('#codConfCliente').val(Fn.generarCorrelativo($(this).val(),6));
        };
    });
    $('#sl_cliente').on('change',function(){
        if($(this).val()!= ''){
            $('#codCliente').val(Fn.generarCorrelativo($(this).val(),8));
        };
    });
    $('#sl_plazas').on('change',function(){
        if($(this).val()!= ''){
			var data = { 'id': $(this).val() };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getClientesByPlaza', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

                $('#sl_cliente').html(a.data.clientes);
                $('#codCliente').val('');
            });
        };
    });
  
    function setClipboardText(text){
    var id = "el-id-del-textarea";
    var existsTextarea = document.getElementById(id);

    if(!existsTextarea){
        console.log("Creando textarea");
        var textarea = document.createElement("textarea");
        textarea.id = id;
        // Coloca el textarea en el borde superior izquierdo
        textarea.style.position = 'fixed';
        textarea.style.top = 0;
        textarea.style.left = 0;

        // Asegurate que las dimensiones del textarea son minimas, normalmente 1px 
        // 1em no funciona porque esto generate valores negativos en algunos exploradores
        textarea.style.width = '1px';
        textarea.style.height = '1px';

        // No se necesita el padding
        textarea.style.padding = 0;

        // Limpiar bordes
        textarea.style.border = 'none';
        textarea.style.outline = 'none';
        textarea.style.boxShadow = 'none';

        // Evitar el flasheo de la caja blanca al renderizar
        textarea.style.background = 'transparent';
        document.querySelector("body").appendChild(textarea);
        console.log("The textarea now exists :)");
        existsTextarea = document.getElementById(id);
    }else{
        console.log("El textarea ya existe")
    }

    existsTextarea.value = text;
    existsTextarea.select();

    try {
        var status = document.execCommand('copy');
        if(!status){
            console.error("No se pudo copiar el texto");
        }else{
            console.log("El texto ahora está en el portapapeles");
        }
    } catch (err) {
        console.log('Uy, no se pudo copiar');
    }
}
</script>