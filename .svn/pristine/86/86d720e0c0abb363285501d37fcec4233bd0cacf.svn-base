<div class="card-datatable">
<table id="tb-maestrosBasemadreDeBaja" class="table table-striped table-bordered nowrap" width="100%">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">#</th>
			<th class="text-center" colspan="2">OPCIONES</th>
			<th class="text-center" colspan="5">DATOS GENERALES</th>
			<th class="text-center" colspan="6">DATOS HISTÓRICOS</th>
			<th class="text-center" colspan="4">DATOS UBICACIÓN</th>
		</tr>
		<tr>
			<th class="text-center">ALL<br><input type="checkbox" id="chkb-deAltaAllBasemadre" name="chkb-deAltaAllBasemadre" class="dataDeAltaTodo"></th>
			<th class="text-center">ESTADO<br>FECHA<br>FIN</th>

			<th class="text-center">ID<br>CLIENTE</th>
			<th class="text-center">RAZÓN<br>SOCIAL</th>
			<th class="text-center">NOMBRE<br>COMERCIAL</th>
			<th class="text-center">DNI</th>
			<th class="text-center">RUC</th>

			<th class="text-center">COD<br>CLIENTE</th>
			<th class="text-center">FECHA<br>INICIO</th>
			<th class="text-center">FECHA<br>FIN</th>
			<th class="text-center">CUENTA</th>
			<th class="text-center">PROYECTO</th>
			<th class="text-center">CANAL</th>

			<th class="text-center">DIRECCIÓN</th>
			<th class="text-center">DEPARTAMENTO</th>
			<th class="text-center">PROVINCIA</th>
			<th class="text-center">DISTRITO</th>
			
		</tr>
	</thead>
	<tbody>
		<? $ix=1; $estiloBloqueado=''; $estadoPDV=''; $estadoPDVChkb='-';?>
		<? foreach ($listaClientes as $kldb => $cliente): ?>
			<?
				if ( empty($cliente['fecFin'])) {
					$estadoPDV='<a href="javascript:;" id="ch-'.$cliente['idClienteHist'].'" class="btn btn-primary cambiarEstado" title="ACTIVADO" data-cliente="'.$cliente['idCliente'].'" data-clienteHistorico="'.$cliente['idClienteHist'].'" data-estado="1" data-tabla="clienteDeBaja"><i class="fas fa-toggle-on fa-lg"></i></a>';
					$estiloBloqueado='';
					$estadoPDVChkb='<span>-</span>';
				} else {
					$estadoPDV='<a href="javascript:;" id="ch-'.$cliente['idClienteHist'].'" class="btn btn-danger cambiarEstado" title="DESACTIVADO" data-cliente="'.$cliente['idCliente'].'" data-clienteHistorico="'.$cliente['idClienteHist'].'" data-estado="0" data-tabla="clienteDeBaja"><i class="fas fa-toggle-off fa-lg"></i></a>';
					$estiloBloqueado='tdBloqueado';
					$estadoPDVChkb='<input type="checkbox" name="deAlta" class="dataDeAlta" data-cliente="'.$cliente['idCliente'].'" data-clienteHistorico="'.$cliente['idClienteHist'].'">';
				}
			?>
			<tr id="tr-<?=$cliente['idClienteHist']?>" class="<?=$estiloBloqueado?>" data-clienteHistorico="<?=$cliente['idClienteHist']?>">
				<td class="text-center"><?=$ix++;?></td>
				<td class="text-center" id="chkb-<?=$cliente['idClienteHist']?>"><?=$estadoPDVChkb;?></td>
				<td class="text-center" id="btn-<?=$cliente['idClienteHist']?>"><?=$estadoPDV;?></td>
				<td class="text-center"><?=$cliente['idCliente'];?></td>
				<td class=""><?=(!empty($cliente['razonSocial'])?$cliente['razonSocial']:'-');?></td>
				<td class=""><?=(!empty($cliente['nombreComercial'])?$cliente['nombreComercial']:'-');?></td>
				<td class="text-center"><?=(!empty($cliente['dni'])?$cliente['dni']:'-');?></td>
				<td class="text-center"><?=(!empty($cliente['ruc'])?$cliente['ruc']:'-');?></td>
				<td class="text-center"><?=(!empty($cliente['codCliente'])?$cliente['codCliente']:'-');?></td>
				<td class="text-center"><?=(!empty($cliente['fecIni'])?$cliente['fecIni']:'-');?></td>
				<td class="text-center" id="tdFf-<?=$cliente['idClienteHist']?>"><span><?=(!empty($cliente['fecFin'])?$cliente['fecFin']:'-');?></span></td>
				<td class="text-center"><?=(!empty($cliente['cuenta'])?$cliente['cuenta']:'-');?></td>
				<td class="text-center"><?=(!empty($cliente['proyecto'])?$cliente['proyecto']:'-');?></td>
				<td class="text-center"><?=(!empty($cliente['canal'])?$cliente['canal']:'-');?></td>
				<td class=""><?=(!empty($cliente['direccion'])?$cliente['direccion']:'-');?></td>
				<td class=""><?=(!empty($cliente['departamento'])?$cliente['departamento']:'-');?></td>
				<td class=""><?=(!empty($cliente['provincia'])?$cliente['provincia']:'-');?></td>
				<td class=""><?=(!empty($cliente['distrito'])?$cliente['distrito']:'-');?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>