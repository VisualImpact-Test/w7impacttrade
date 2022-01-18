<style>
	th.product-propio { background-color: #29943f; color: #fff; }
</style>
<div class="card-datatable">
	<table id="tb-newdetalladoExcel" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
            <tr>
				<th class="text-center noVis" >#</th>
				<!-- <th class="text-center" >INHABILITAR / PDF</th> -->
				<th class="text-center" >FECHA</th>
				<th class="text-center <?=!empty($hideCol['tipoUsuario']) ? 'hideCol' : '' ?>" >PERFIL USUARIO</th>
				<th class="text-center" >NOMBRE USUARIO</th>
				<th class="text-center <?=!empty($hideCol['grupoCanal']) ? 'hideCol' : '' ?>" >GRUPO CANAL</th>
				<th class="text-center <?=!empty($hideCol['canal']) ? 'hideCol' : '' ?>" >CANAL</th>
				<th class="text-center hideCol" >SUBCANAL</th>
				<?$nroHeaders = 9;?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++;?>
                    <th class="text-center <?=!empty($hideCol[$v['columna']]) ? 'hideCol' : '' ?>" ><?= strtoupper($v['header']) ?></th>
                <? } ?>
				<th class="text-center hideCol" >DEPARTAMENTO</th>
				<th class="text-center hideCol" >PROVINCIA</th>
				<th class="text-center hideCol" >DISTRITO</th>
				<th class="text-center <?=!empty($hideCol['idCliente']) ? 'hideCol' : '' ?>" >COD VISUAL</th>
				<th class="text-center hideCol" >COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center hideCol" >COD PDV</th>
				<th class="text-center" >PDV</th>
				<th class="text-center" >COD PROD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center" >PRODUCTO</th>
				<th class="text-center" >PRESENCIA</th>
				<th class="text-center" >MOTIVO</th>
				<th class="text-center excel-borrar" >FOTO</th>
			</tr>
        </thead>
    </table>
</div>