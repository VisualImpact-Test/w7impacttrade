<table class="mb-0 table table-bordered table-sm text-nowrap">
	<thead>
		<tr>
			<th class="text-center align-middle" rowspan="2" colspan="1"></th>
			<th class="text-center align-middle" rowspan="2" colspan="1">CANAL</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">CLIENTE</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">ENCUESTA</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">IPP</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">CHECKLIST PRODUCTOS</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">PRECIOS</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">PROMOCIONES</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">SOS</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">SOD</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">ENCARTES</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">SEG DE PLAN</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">DESPACHOS</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">FOTOS</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">INVENTARIO</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">VISIBILIDAD</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">MANTENIMIENTO<BR>CLIENTE</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">INICIATIVAS</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">INTELIGENCIA<BR>COMPETITIVA</th>
			<th class="text-center align-middle" rowspan="2" colspan="1">ORDEN<BR>DE TRABAJO</th>
			<th class="text-center align-middle" rowspan="1" colspan="3">VISIBILIDAD<BR> AUDITORIA</th>
		</tr>
		<tr>
			<th class="text-center align-middle" rowspan="1" colspan="1">OBLIGATORIO</th>
			<th class="text-center align-middle" rowspan="1" colspan="1">INICIATIVA</th>
			<th class="text-center align-middle" rowspan="1" colspan="1">ADICIONAL</th>
		</tr>
	</thead>
	<tbody class="tb-cargarData">

		<? foreach($visitas as $idVisita => $row){?>
			<tr>
				<td class="text-center"><input type="checkbox" class="check_visita"></td>
				<td class="text-center"><?=$row['canal'] ?></td>
				<td ><?=$row['razonSocial'] ?></td>

				<td class="text-center">
					<?=isset($visita_encuesta[$idVisita]['estado']) ?  (($visita_encuesta[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_encuesta" name="mod_encuesta_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_encuesta" name="mod_encuesta_'.$idVisita.'">' ; ?>
					(<?=isset($visita_encuesta[$idVisita]['cant']) ? $visita_encuesta[$idVisita]['cant']." registro(s)" : "0 registros"  ?> )
					<?=isset($visita_encuesta[$idVisita]['estado']) ?  (($visita_encuesta[$idVisita]['estado']==1) ? "<label style='color:#73c14b'> <label style='color:#73c14b'>Registrado</label></label>" : "<label style='color:#ff4040'> <label style='color:#ff4040'>Sin registrar</label></label>" ): "<label style='color:#ff4040'><label style='color:#ff4040'>Sin registrar</label></label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_ipp[$idVisita]['estado']) ?  (($visita_ipp[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_ipp" name="mod_ipp_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_ipp" name="mod_ipp_'.$idVisita.'">' ; ?>
					(<?=isset($visita_ipp[$idVisita]['cant']) ? $visita_ipp[$idVisita]['cant']." registro(s)" : "0 registros"  ?> )
					<?=isset($visita_ipp[$idVisita]['estado']) ?  (($visita_ipp[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_producto[$idVisita]['estado']) ?  (($visita_producto[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_producto" name="mod_producto_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_producto" name="mod_producto_'.$idVisita.'">' ; ?>
					(<?=isset($visita_producto[$idVisita]['cant']) ? $visita_producto[$idVisita]['cant']." registro(s)" : "0 registros"  ?> )
					<?=isset($visita_producto[$idVisita]['estado']) ?  (($visita_producto[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_precio[$idVisita]['estado']) ?  (($visita_precio[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_precio" name="mod_precio_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_precio" name="mod_precio_'.$idVisita.'">' ; ?>
					(<?=isset($visita_precio[$idVisita]['cant']) ? $visita_precio[$idVisita]['cant']." registro(s)" : "0 registros"  ?>  )
					<?=isset($visita_precio[$idVisita]['estado']) ?  (($visita_precio[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_promocion[$idVisita]['estado']) ?  (($visita_promocion[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_promocion" name="mod_promocion_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_promocion" name="mod_promocion_'.$idVisita.'">' ; ?>
					(<?=isset($visita_promocion[$idVisita]['cant']) ? $visita_promocion[$idVisita]['cant']." registro(s)" : "0 registros"  ?>  )
					<?=isset($visita_promocion[$idVisita]['estado']) ?  (($visita_promocion[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_sos[$idVisita]['estado']) ?  (($visita_sos[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_sos" name="mod_sos_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_sos" name="mod_sos_'.$idVisita.'">' ; ?>
					(<?=isset($visita_sos[$idVisita]['cant']) ? $visita_sos[$idVisita]['cant']." registro(s)" : "0 registros"  ?>  )
					<?=isset($visita_sos[$idVisita]['estado']) ?  (($visita_sos[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_sod[$idVisita]['estado']) ?  (($visita_sod[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_sod" name="mod_sod_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_sod" name="mod_sod_'.$idVisita.'">' ; ?>
					(<?=isset($visita_sod[$idVisita]['cant']) ? $visita_sod[$idVisita]['cant']." registro(s)" : "0 registros"  ?>  )
					<?=isset($visita_sod[$idVisita]['estado']) ?  (($visita_sod[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_encarte[$idVisita]['estado']) ?  (($visita_encarte[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_encarte" name="mod_encarte_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_encarte" name="mod_encarte_'.$idVisita.'">' ; ?>
					(<?=isset($visita_encarte[$idVisita]['cant']) ? $visita_encarte[$idVisita]['cant']." registro(s)" : "0 registros"  ?>  )
					<?=isset($visita_encarte[$idVisita]['estado']) ?  (($visita_encarte[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_seguimiento_plan[$idVisita]['estado']) ?  (($visita_seguimiento_plan[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_seguimiento_plan" name="mod_seguimiento_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_seguimiento_plan" name="mod_seguimiento_'.$idVisita.'">' ; ?>
					(<?=isset($visita_seguimiento_plan[$idVisita]['cant']) ? $visita_seguimiento_plan[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_seguimiento_plan[$idVisita]['estado']) ?  (($visita_seguimiento_plan[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_despacho[$idVisita]['estado']) ?  (($visita_despacho[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_despacho" name="mod_despacho_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_despacho" name="mod_despacho_'.$idVisita.'">' ; ?>
					(<?=isset($visita_despacho[$idVisita]['cant']) ? $visita_despacho[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_despacho[$idVisita]['estado']) ?  (($visita_despacho[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_foto[$idVisita]['estado']) ?  (($visita_foto[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_foto" name="mod_foto_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_foto" name="mod_foto_'.$idVisita.'">' ; ?>
					(<?=isset($visita_foto[$idVisita]['cant']) ? $visita_foto[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_foto[$idVisita]['estado']) ?  (($visita_foto[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
				<td class="text-center">
					<?=isset($visita_inventario[$idVisita]['estado']) ?  (($visita_inventario[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_inventario" name="mod_inventario_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_inventario" name="mod_inventario_'.$idVisita.'">' ; ?>
					(<?=isset($visita_inventario[$idVisita]['cant']) ? $visita_inventario[$idVisita]['cant']." registro(s)" : "0 registros"  ?> )
					<?=isset($visita_inventario[$idVisita]['estado']) ?  (($visita_inventario[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_visibilidad_trad[$idVisita]['estado']) ?  (($visita_visibilidad_trad[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_trad" name="mod_visibilidad_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_trad" name="mod_visibilidad_'.$idVisita.'">' ; ?>
					(<?=isset($visita_visibilidad_trad[$idVisita]['cant']) ? $visita_visibilidad_trad[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_visibilidad_trad[$idVisita]['estado']) ?  (($visita_visibilidad_trad[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>

				<td class="text-center">
					<?=isset($visita_mantenimiento_cliente[$idVisita]['estado']) ?  (($visita_mantenimiento_cliente[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_mantenimiento_cliente" name="mod_mantenimiento_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_mantenimiento_cliente" name="mod_mantenimiento_'.$idVisita.'">' ; ?>
					(<?=isset($visita_mantenimiento_cliente[$idVisita]['cant']) ? $visita_mantenimiento_cliente[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_mantenimiento_cliente[$idVisita]['estado']) ?  (($visita_mantenimiento_cliente[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
				<td class="text-center">
					<?=isset($visita_iniciativa[$idVisita]['estado']) ?  (($visita_iniciativa[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_iniciativa" name="mod_iniciativa_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_iniciativa" name="mod_iniciativa_'.$idVisita.'">' ; ?>
					(<?=isset($visita_iniciativa[$idVisita]['cant']) ? $visita_iniciativa[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_iniciativa[$idVisita]['estado']) ?  (($visita_iniciativa[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
				<td class="text-center">
					<?=isset($visita_inteligencia[$idVisita]['estado']) ?  (($visita_inteligencia[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_inteligencia" name="mod_inteligencia_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_inteligencia" name="mod_inteligencia_'.$idVisita.'">' ; ?>
					(<?=isset($visita_inteligencia[$idVisita]['cant']) ? $visita_inteligencia[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_inteligencia[$idVisita]['estado']) ?  (($visita_inteligencia[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
				<td class="text-center">
					<?=isset($visita_orden[$idVisita]['estado']) ?  (($visita_orden[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_orden" name="mod_orden_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_orden" name="mod_orden_'.$idVisita.'">' ; ?>
					(<?=isset($visita_orden[$idVisita]['cant']) ? $visita_orden[$idVisita]['cant']." registro(s)" : "0 registros"  ?> )
					<?=isset($visita_orden[$idVisita]['estado']) ?  (($visita_orden[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
				<td class="text-center">
					<?=isset($visita_visibilidad_obligatorio[$idVisita]['estado']) ?  (($visita_visibilidad_obligatorio[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_obligatorio" name="mod_visibilidad_obligatorio_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_obligatorio" name="mod_visibilidad_obligatorio_'.$idVisita.'">' ; ?>
					(<?=isset($visita_visibilidad_obligatorio[$idVisita]['cant']) ? $visita_visibilidad_obligatorio[$idVisita]['cant']." registro(s)" : "0 registros"  ?>  )
					<?=isset($visita_visibilidad_obligatorio[$idVisita]['estado']) ?  (($visita_visibilidad_obligatorio[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
				<td class="text-center">
					<?=isset($visita_visibilidad_iniciativa[$idVisita]['estado']) ?  (($visita_visibilidad_iniciativa[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_iniciativa" name="mod_visibilidad_iniciativa_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_iniciativa" name="mod_visibilidad_iniciativa_'.$idVisita.'">' ; ?>
					(<?=isset($visita_visibilidad_iniciativa[$idVisita]['cant']) ? $visita_visibilidad_iniciativa[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_visibilidad_iniciativa[$idVisita]['estado']) ?  (($visita_visibilidad_iniciativa[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
				<td class="text-center">
					<?=isset($visita_visibilidad_adicional[$idVisita]['estado']) ?  (($visita_visibilidad_adicional[$idVisita]['estado']==1) ? "" : '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_adicional" name="mod_visibilidad_adicional_'.$idVisita.'">' ): '<input type="checkbox" class="check_carga" data-idVisita="'.$idVisita.'" data-modulo="visita_visibilidad_adicional" name="mod_visibilidad_adicional_'.$idVisita.'">' ; ?>
					(<?=isset($visita_visibilidad_adicional[$idVisita]['cant']) ? $visita_visibilidad_adicional[$idVisita]['cant']." registro(s)" : "0 registros"  ?>   )
					<?=isset($visita_visibilidad_adicional[$idVisita]['estado']) ?  (($visita_visibilidad_adicional[$idVisita]['estado']==1) ? "<label style='color:#73c14b'>Registrado</label>" : "<label style='color:#ff4040'>Sin registrar</label>" ): "<label style='color:#ff4040'>Sin registrar</label>" ; ?>
				</td>
				
			</tr>
	
		<? }?>
	</tbody>
</table>

<script>
var arr_fotos=<?= isset($array_fotos) ?  JSON_ENCODE($array_fotos) :"null" ?>
</script>