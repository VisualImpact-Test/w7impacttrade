<div class="tab-content">
    <div id="tab_vigencia_listas" class="tab-pane fade in active">
        <div style="padding:20px; border: 1px solid #E6E9ED;">
            <form name="formVigenciaListasIniciativas" id="formVigenciaListasIniciativas" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label>FECHA FIN</label>
                            <input type="text" id="li-fecha-fin-vigencia" name="li-fecha-fin-vigencia" class="form-control fecha_fin_vigencia" value="">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>TIPO ACTUALIZACIÓN</label>
                        <div class="btn-group btn-group-toggle w-100 " data-toggle="buttons" >
							<label class="btn btn-outline-secondary custom_tooltip"> 
								<span class="tooltiptextButton">Actualizar Seleccionados</span>
								<input type="radio" value="1" name="chk_tipoActualizar"  id="chk_tipoActualizarSeleccion" autocomplete="off"> Selección</i>
							</label>
							<label class="btn btn-outline-secondary  custom_tooltip active">
								<span class="tooltiptextButton">Actualizar Todos</span>
								<input type="radio"  value="2" name="chk_tipoActualizar"  id="chk_tipoActualizarTodos" autocomplete="off"  checked="checked"> Todos
							</label>
						</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.fecha_fin_vigencia').daterangepicker({
        locale: {
            "format": "DD/MM/YYYY",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cerrar",
            "daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            "monthNames": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
            "firstDay": 1
        },
        singleDatePicker: true,
        showDropdowns: false,
        autoApply: true,
        minDate: moment(),
    });
 
</script>