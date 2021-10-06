<? $gestor = $this->flagGestorDeArchivos;
$tipoUsuario = $this->idTipoUsuario;
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
					<li class="nav-item btnReporte" ><a data-toggle="tab" href="#tab-content-0" class="active nav-link" > <i class="fad fa-file"></i> Archivos</a></li>
					<?if(!empty($gestor) || $tipoUsuario == 4){?>
						<li class="nav-item btnReporte" ><a data-toggle="tab" href="#tab-content-1" class="nav-link" > <i class="fad fa-folder"></i> Carpetas</a></li>
						<li class="nav-item btnReporte" ><a data-toggle="tab" href="#tab-content-2" class="nav-link" > <i class="fad fa-check"></i> Permisos</a></li>
					<?}?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-auditoria">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button">
                    <button class="btn btn-outline-trade-visual border-0 btn-Consultar" title="Buscar"><i class="fa fa-search"></i></button>
                    <button class="btn btn-outline-trade-visual border-0 btn-NewArchivo" title="Agregar"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-outline-trade-visual border-0 btn-New" title="Agregar" style="display: none;"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="0" title="Activar"><i class="fa fa-toggle-on"></i></button>
                    <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="1" title="Desactivar"><i class="fa fa-toggle-off"></i></button>
			</div>
		</form>
	</div>
</div>

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-archivos">
			<div class="tab-pane fade show active" id="tab-content-0" role="tabpanel" >
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade " id="tab-content-1" role="tabpanel" >
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade " id="tab-content-2" role="tabpanel" >
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>