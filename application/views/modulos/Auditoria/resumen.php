<div class="card-datatable">
	<table id="tb-resumen" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
				<th rowspan="3" class="text-center noVis">#</th>
				<th rowspan="3" class="text-center">CIUDAD</th>
				<th rowspan="3"  class="text-center">DISTRITO</th>
				<th rowspan="3"  class="text-center">PERFIL USUARIO</th>
				<th rowspan="3"  class="text-center">NOMBRE USUARIO</th>
				<th rowspan="1" colspan="<?=count($fechas)*3;?>"  class="text-center">RANGO DE FECHAS CONSULTADO</th>
				<th rowspan="3"  class="text-center">TOTAL PROGRAMADOS</th>
				<th rowspan="3"  class="text-center">TOTAL REALIZADOS</th>
				<th rowspan="3"  class="text-center">TOTAL EFECTIVOS</th>
            </tr>
            <tr>
			    <? foreach($fechas as $fila){ ?>
					<th rowspan="1" colspan="3"><?=$fila['fecha'];?></th>
				<? } ?>
			</tr>
			<tr>
			    <? foreach($fechas as $fila){ ?>
					<th rowspan="1" colspan="1" class="tooltipTipsy" title="VISITAS PROGRAMADAS">VP</th>
					<th rowspan="1" colspan="1" class="tooltipTipsy" title="VISITAS REALIZADAS <br> (VISITAS INICIADAS)">VR</th>
					<th rowspan="1" colspan="1" class="tooltipTipsy" title="VISITAS EFECTIVAS <br> (VISITAS FINALIZADAS <br> SIN INCIDENCIA)">VE</th>
				<? } ?>
			</tr>
        </thead>
		<tbody>
        <?
		$i=1;
		foreach($usuarios as $fila){
		?> 
		    <tr>
                <td><?=$i++;?></td>
                <td><?= verificarEmpty($fila['ciudad'], 3); ?></td>
                <td><?= verificarEmpty($fila['distrito'], 3); ?></td>
                <td><?= verificarEmpty($fila['tipoUsuario'], 3); ?></td>
                <td><?= verificarEmpty($fila['nombreUsuario'], 3); ?></td>
				<? foreach($fechas as $fila2){ ?>
				<?
                    $vp=isset($vProgramadas[$fila['idUsuario']][$fila2['fecha']]['vProg'])?$vProgramadas[$fila['idUsuario']][$fila2['fecha']]['vProg']:'-';
                    $vr=isset($vRealizadas[$fila['idUsuario']][$fila2['fecha']]['vReal'])?$vRealizadas[$fila['idUsuario']][$fila2['fecha']]['vReal']:'-';
                    $ve=isset($vEfectivas[$fila['idUsuario']][$fila2['fecha']]['vEfec'])?$vEfectivas[$fila['idUsuario']][$fila2['fecha']]['vEfec']:'-';
                    if($vp!="-"){ $classDetalle = "class='text-right verDetalleVisitas'"; } else { $classDetalle = "class='text-right'"; }
				?>
                    <td <?=$classDetalle;?> data-tipo="vp"  data-empleado="<?=$fila['idUsuario'];?>" data-fecha="<?=$fila2['fecha'];?>"><?=$vp;?></td>
                    <td <?=$classDetalle;?> data-tipo="vr"  data-empleado="<?=$fila['idUsuario'];?>" data-fecha="<?=$fila2['fecha'];?>"><?=$vr;?></td>
                    <td <?=$classDetalle;?> data-tipo="ve"  data-empleado="<?=$fila['idUsuario'];?>" data-fecha="<?=$fila2['fecha'];?>"><?=$ve;?></td>
                <? } ?>
                <?
                $vpTotalEmpleado=isset($vProgramadasTotalEmpleado[$fila['idUsuario']]['vProgTotalEmpleado'])?$vProgramadasTotalEmpleado[$fila['idUsuario']]['vProgTotalEmpleado']:'-';
                $vrTotalEmpleado=isset($vRealizadasTotalEmpleado[$fila['idUsuario']]['vRealTotalEmpleado'])?$vRealizadasTotalEmpleado[$fila['idUsuario']]['vRealTotalEmpleado']:'-';
                $veTotalEmpleado=isset($vEfectivasTotalEmpleado[$fila['idUsuario']]['vEfecTotalEmpleado'])?$vEfectivasTotalEmpleado[$fila['idUsuario']]['vEfecTotalEmpleado']:'-';
				?>
                <td class="text-right"><?=$vpTotalEmpleado;?></td>
				<td class="text-right"><?=$vrTotalEmpleado;?></td>
				<td class="text-right"><?=$veTotalEmpleado;?></td>
	        </tr>
           <?}?>	
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">TOTAL GENERAL</th>
                <? $vpTotalGeneral=0; $vrTotalGeneral=0; $veTotalGeneral=0; foreach($fechas as $fila){ ?>
				<?
				$vpTotalFecha=isset($vProgramadasTotalFecha[$fila['fecha']]['vProgTotalFecha'])?$vProgramadasTotalFecha[$fila['fecha']]['vProgTotalFecha']:'-';
				$vrTotalFecha=isset($vRealizadasTotalFecha[$fila['fecha']]['vRealTotalFecha'])?$vRealizadasTotalFecha[$fila['fecha']]['vRealTotalFecha']:'-';
				$veTotalFecha=isset($vEfectivasTotalFecha[$fila['fecha']]['vEfecTotalFecha'])?$vEfectivasTotalFecha[$fila['fecha']]['vEfecTotalFecha']:'-';
				if($vpTotalFecha!="-"){ $vpTotalGeneral += $vpTotalFecha; }
				if($vrTotalFecha!="-"){ $vrTotalGeneral += $vrTotalFecha; }
				if($veTotalFecha!="-"){ $veTotalGeneral += $veTotalFecha; }
				?>
                <th class="text-right"><?=$vpTotalFecha;?></th>
				<th class="text-right"><?=$vrTotalFecha;?></th>
				<th class="text-right"><?=$veTotalFecha;?></th>
                <? } ?>
				<th class="text-right"><?=$vpTotalGeneral;?></th>
				<th class="text-right"><?=$vrTotalGeneral;?></th>
				<th class="text-right"><?=$veTotalGeneral;?></th>
            </tr>
        </tfoot>
    </table>
</div>