<? $verClientesActivar = ($htmlClienteActivar) ? '': 'd-none'; ?>
<div class="card-datatable">
<table id="tb-maestrosBasemadreDetalle" class="table table-striped table-bordered nowrap" width="100%">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">#</th>
			<th class="text-center <?=$verClientesActivar;?>" colspan="3">OPCIONES</th>
			<th class="text-center" colspan="5">DATOS GENERALES</th>
			<th class="text-center" colspan="7">DATOS HISTÓRICOS</th>
			<th class="text-center" colspan="4">DATOS UBICACIÓN</th>
		</tr>
		<tr>
			<th class="text-center <?=$verClientesActivar;?>">TODOS<br><input type="checkbox" id="chkb-deBajaAllBasemadre" name="chkb-deBajaAllBasemadre" class="dataDeBajaTodo"></th>
			<th class="text-center <?=$verClientesActivar;?>">ESTADO<br>FECHA<br>FIN</th>
			<th class="text-center <?=$verClientesActivar;?>">EDITAR</th>

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
			<th class="text-center">CLIENTE TIPO</th>

			<th class="text-center">DIRECCIÓN</th>
			<th class="text-center">DEPARTAMENTO</th>
			<th class="text-center">PROVINCIA</th>
			<th class="text-center">DISTRITO</th>
			
		</tr>
	</thead>
	<tbody>
		<? $ix=1; $estiloBloqueado=''; $estadoPDV=''; $estadoPDVChkb='-';?>
		<? foreach ($listaBasemadre as $klb => $basemadre): ?>
			<?
				if ( empty($basemadre['fecFin'])) {
					$estadoPDV='<a href="javascript:;" id="ch-'.$basemadre['idClienteHist'].'" class="btn btn-outline-secondary border-0 cambiarEstado" title="Activado" data-cliente="'.$basemadre['idCliente'].'" data-clienteHistorico="'.$basemadre['idClienteHist'].'" data-estado="1" data-tabla="basemadre"><i class="fas fa-toggle-on fa-lg"></i></a>';
					$estiloBloqueado='';
					$estadoPDVChkb='<input type="checkbox" name="deBaja" class="dataDeBaja" data-cliente="'.$basemadre['idCliente'].'" data-clienteHistorico="'.$basemadre['idClienteHist'].'">';
				} else {
					$estadoPDV='<a href="javascript:;" id="ch-'.$basemadre['idClienteHist'].'" class="btn btn-outline-secondary border-0 cambiarEstado" title="Desactivado" data-cliente="'.$basemadre['idCliente'].'" data-clienteHistorico="'.$basemadre['idClienteHist'].'" data-estado="0" data-tabla="basemadre"><i class="fas fa-toggle-off fa-lg"></i></a>';
					$estiloBloqueado='tdBloqueado';
					$estadoPDVChkb='<span>-</span>';
				}
			?>
			<tr id="tr-<?=$basemadre['idClienteHist']?>" class="<?=$estiloBloqueado?>" data-clienteHistorico="<?=$basemadre['idClienteHist']?>">
				<td class="text-center"><?=$ix++;?></td>
				<td class="text-center <?=$verClientesActivar;?>" id="chkb-<?=$basemadre['idClienteHist']?>"><?=$estadoPDVChkb;?></td>
				<td class="text-center <?=$verClientesActivar;?>" id="btn-<?=$basemadre['idClienteHist']?>"><?=$estadoPDV;?></td>
				<td class="text-center <?=$verClientesActivar;?>">
					<button class="btn btn-outline-secondary border-0 editarClienteHistorico" title="Editar PDV" data-cliente="<?=$basemadre['idCliente']?>" data-clienteHistorico="<?=$basemadre['idClienteHist']?>" data-tabla="basemadre"><i class="fas fa-edit fa-lg"></i></button>
				</td>
				<td class="text-center"><?=$basemadre['idCliente'];?></td>
				<td class=""><?=(!empty($basemadre['razonSocial'])?$basemadre['razonSocial']:'-');?></td>
				<td class=""><?=(!empty($basemadre['nombreComercial'])?$basemadre['nombreComercial']:'-');?></td>
				<td class="text-center"><?=(!empty($basemadre['dni'])?$basemadre['dni']:'-');?></td>
				<td class="text-center"><?=(!empty($basemadre['ruc'])?$basemadre['ruc']:'-');?></td>
				<td class="text-center"><?=(!empty($basemadre['codCliente'])?$basemadre['codCliente']:'-');?></td>
				<td class="text-center"><?=(!empty($basemadre['fecIni'])?$basemadre['fecIni']:'-');?></td>
				<td class="text-center" id="tdFf-<?=$basemadre['idClienteHist']?>"><span><?=(!empty($basemadre['fecFin'])?$basemadre['fecFin']:'-');?></span></td>
				<td class="text-center"><?=(!empty($basemadre['cuenta'])?$basemadre['cuenta']:'-');?></td>
				<td class="text-center"><?=(!empty($basemadre['proyecto'])?$basemadre['proyecto']:'-');?></td>
				<td class="text-center"><?=(!empty($basemadre['canal'])?$basemadre['canal']:'-');?></td>
				<td class="text-center"><?=(!empty($basemadre['clienteTipo'])?$basemadre['clienteTipo']:'-');?></td>
				<td class=""><?=(!empty($basemadre['direccion'])?$basemadre['direccion']:'-');?></td>
				<td class=""><?=(!empty($basemadre['departamento'])?$basemadre['departamento']:'-');?></td>
				<td class=""><?=(!empty($basemadre['provincia'])?$basemadre['provincia']:'-');?></td>
				<td class=""><?=(!empty($basemadre['distrito'])?$basemadre['distrito']:'-');?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>