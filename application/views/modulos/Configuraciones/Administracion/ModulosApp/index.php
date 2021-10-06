<?
$idCuenta = $this->sessIdCuenta;
?>
<div class="row mt-4">
	<div class="col-lg-2 d-flex justify-content-center align-items-center">
		<h3 class="card-title mb-3">
			<i class="<?= $icon ?>"></i>
			<?= $title ?>
		</h3>
	</div>
	<div class="col-lg-10 d-flex">
		<div class="card w-100 mb-3 p-0">
			<div class="card-body p-0">
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a class="nav-link active btnReporte" data-toggle="tab" href="#contentPermisos" data-value="1">Permisos</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
	<a href="javascript:;" class="customizer-close" ><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-moduloApp-filtro">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button">
                <button type="button" id="btn-moduloApp-consultar" class="btn btn-outline-trade-visual border-0" title="Consultar"><i class="fa fa-search"></i></button>
                <button type="button" id="btn-moduloApp-nuevo" class="btn btn-outline-trade-visual border-0" title="Nuevo"><i class="fa fa-plus"></i></button>
                <button type="button" id="btn-moduloApp-eliminar" class="btn btn-outline-trade-visual border-0" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<input type="hidden" name="tipoFormato" id="tipoFormato" value="1" />
					<div class="col-md-12">
                        <div class="mb-2 mr-sm-2  position-relative form-group ">
                            <select class="slt-cuenta form-control" name="idCuenta" data-title="Cuenta">
                                <option value=""></option>
                                <?foreach($aListCuenta as $vcue){?>
                                    <option value="<?=$vcue['idCuenta']?>" <?=	($this->idTipoUsuario != 4 ) ? 'selected' : '';?>><?=$vcue['nombre']?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group ">
                            <select class="slt-aplicacion form-control" name="idAplicacion" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2  position-relative form-group ">
                            <select class="form-control slt-tipoUsuario" name="idTipoUsuario" >
                                <option value=""></option>
                                <?foreach($aListTipoUsuario as $vtu){?>
                                    <option value="<?=$vtu['idTipoUsuario']?>"><?=$vtu['nombre']?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2  position-relative form-group ">
                            <select class="slt-canal form-control" name="idCanal" >
                                <option value=""></option>
                            </select>
                        </div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="main-card mb-3 card div-para-ocultar">
    <div class="card-body p-0">
        <div class="tab-content" id="content-permisos-app">
            <div class="tab-pane fade show active " id="contentPermisos" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>

<script>

</script>
