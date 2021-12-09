<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<?$i=1; $ot=array(); $in=array();?>
		<table style="border-collapse:collapse; width:100%;">
			<thead>
				<tr style="background-color:#f2f2f2;">
					<th colspan="18" style="font-size:11px; border-bottom:1pt solid black;padding:8px;text-align:center;">RESUMEN</th>
				</tr>
				<tr>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">N</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">ID</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">FECHA</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">CIUDAD</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">PLAZA</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">CLIENTE</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">DIRECCION</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">AUDITOR</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">ORDEN TRABAJO</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">INCIDENCIA</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">OBS</th>
					<th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">POST</th>
					<th rowspan="1" colspan="4" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">GTM</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">RESULTADO GTM</th>
					<th rowspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">RESULTADO POST</th>
				</tr>
				<tr>
				    <th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">VISIBILIDAD(100%)</th>
					<th rowspan="1" colspan="3" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">VISIBILIDAD(80%)</th>
					<th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">PRECIOS MARCADOS(20%)</th>
				</tr>
				<tr>
				    <th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">EO(100%)</th>
					<th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">EO(60%)</th>
					<th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">INI(30%)</th>
					<th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">EA(10%)</th>
					<th rowspan="1" colspan="1" style="font-size:9px; border-bottom:1pt solid black;padding:8px;text-align:center;">PM(100%)</th>
				</tr>
			</thead>
			<tbody><?
				foreach($data as $k_v=>$v_v){
					if(!empty($v_v['vD']) && strlen($v_v['vD'])>0) $vD=number_format($v_v['vD'],2).'%'; else $vD='-';
					if(!empty($v_v['vL']) && strlen($v_v['vL'])>0) $vL=number_format($v_v['vL'],2).'%'; else $vL='-';
					if(!empty($v_v['vV']) && strlen($v_v['vV'])>0) $vV=number_format($v_v['vV'],2).'%'; else $vV='-';
					if(!empty($v_v['vP']) && strlen($v_v['vP'])>0) $vP=number_format($v_v['vP'],2).'%'; else $vP='-';

					$style_ini="style='font-size:9px; padding:8px; text-align:left; ";
					$cD=$cL=$cV=$cP='';
					if(empty($v_v['vD']) && $vD<>'-') $cD="color:#FF6666; font-weight:bold; ";
					elseif(!empty($v_v['vD']) &&$v_v['vD']>=100) $cD="color:#1FD14E; font-weight:bold; ";

					if(empty($v_v['vL']) && $vL>'-') $cL="color:#FF6666; font-weight:bold; ";
					elseif(!empty($v_v['vL']) && $v_v['vL']>=100) $cL="color:#1FD14E; font-weight:bold; ";

					if(empty($v_v['vV']) && $vV<>'-') $cV="color:#FF6666; font-weight:bold; ";
					elseif(!empty($v_v['vV']) && $v_v['vV']>=100) $cV="color:#1FD14E; font-weight:bold; ";

					if(empty($v_v['vP']) && $vP<>'-') $cP="color:#FF6666; font-weight:bold; ";
					elseif(!empty($v_v['vP']) && $v_v['vP']>=100) $cP="color:#1FD14E; font-weight:bold; ";
					
					$style_fin="'";

?>
				<tr style="<?=($i%2<>0?'background-color:#f2f2f2':'');?>">
					<td <?=$style_ini.$style_fin;?>><?=$i++;?></td>
					<td <?=$style_ini.$style_fin;?>><?=$v_v['idVisita'];?></td>
					<td <?=$style_ini.$style_fin;?>><?=strtoupper(utf8_decode($v_v['fecha']));?></td>
					<td <?=$style_ini.$style_fin;?>><?=strtoupper(utf8_decode($v_v['ciudadPlaza']));?></td>
					<td <?=$style_ini.$style_fin;?>><?=strtoupper(utf8_decode($v_v['plaza']));?></td>
					<td <?=$style_ini.$style_fin;?>><?=strtoupper(utf8_decode($v_v['razonSocial']));?></td>
					<td <?=$style_ini.$style_fin;?>><?=strtoupper(utf8_decode($v_v['direccion']));?></td>
					<td <?=$style_ini.$style_fin;?>><?=strtoupper(utf8_decode($v_v['usuario']));?></td>
					<td <?=$style_ini.$style_fin;?>><?=(empty($v_v['orden'])?'-':strtoupper(utf8_decode($v_v['orden'])));?></td>
					<td <?=$style_ini.$style_fin;?>><?=(empty($v_v['nombreIncidencia'])?'-':strtoupper(utf8_decode($v_v['nombreIncidencia'])));?></td>
					<td <?=$style_ini.$style_fin;?>><?=(empty($v_v['observacionIncidencia'])?'-':strtoupper(utf8_decode($v_v['observacionIncidencia'])));?></td>
					<td <?=$style_ini.$cP.$style_fin?>><?=$resultados[$v_v['idVisita']]['porcentajeEO'];?></td>
					<td <?=$style_ini.$cP.$style_fin?>><?=$resultados[$v_v['idVisita']]['porcentajeEO'];?></td>
					<td <?=$style_ini.$cP.$style_fin?>><?=$resultados[$v_v['idVisita']]['porcentajeINI'];?></td>
					<td <?=$style_ini.$cP.$style_fin?>><?=$resultados[$v_v['idVisita']]['porcentajeEA'];?></td>
					<td <?=$style_ini.$cP.$style_fin?>><?=$resultados[$v_v['idVisita']]['porcentajePM'];?></td>
					<?
						$resultadoPOST = $resultados[$v_v['idVisita']]['porcentajeEO']*1;
						$resultadoGTM = ($resultados[$v_v['idVisita']]['porcentajeEO']*0.6 + $resultados[$v_v['idVisita']]['porcentajeINI']*0.3 + $resultados[$v_v['idVisita']]['porcentajeEA']*0.1)*0.8 + ($resultados[$v_v['idVisita']]['porcentajePM']*1)*0.2;
					?>
					<td style="font-size:9px; padding:8px; text-align:left;"><?=$resultadoGTM;?> %</td>
					<td style="font-size:9px; padding:8px; text-align:left;"><?=$resultadoPOST;?> %</td>
				</tr>
			<?}?>
			</tbody>
		</table>
		</br>
	</body>
</html>