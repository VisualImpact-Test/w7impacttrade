<?
$aUsuario = [1,4,5,6,171,148,466,482,483,485,394];
$col_1 = 4; $col_2 = 8; $col_3 = 0;

if( in_array($this->idUsuario, $aUsuario) ){
	$col_1 = 3;
	$col_2 = 6;
	$col_3 = 3;
}
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
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte" url="visibilidad">
						<a data-toggle="tab" href="#contentPremiaciones" class="active nav-link" data-value="1">&nbsp;</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-<?=$col_1?> col-md-12 d-flex">
		<div class="main-card mb-3 card main-cobertura col-md-12 px-0">
			<div class="card-header bg-trade-visual-grad-right text-white" style="width: 100%;">
				<h5 class="card-title">
					<i class="fas fa-store-alt fa-lg"></i> COBERTURA
				</h5>
			</div>
			<div class="card-body centrarContenidoDiv vista-cobertura" style="width: 100%;">
				<i class="fas fa-spinner-third fa-spin icon-load"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-<?=$col_2?> col-md-12 d-flex">
		<div class="main-card mb-3 card main-efectividad col-md-12 px-0">
			<div class="card-header bg-trade-visual-grad-left text-white" style="width: 100%;">
				<h5 class="card-title">
					<i class="fas fa-tasks fa-lg"></i> EFECTIVIDAD<sup>Visitas</sup>
				</h5>
			</div>
			<div class="card-body centrarContenidoDiv vista-efectividad" style="width: 100%;">
				<i class="fas fa-spinner-third fa-spin icon-load"></i>
			</div>
		</div>
	</div>
	<?if( $col_3 ){?>
	<div class="col-lg-<?=$col_3?> col-md-12 d-flex">
		<div class="card-muro card mb-3 col-md-12 px-0">
			<div class="card-header  bg-trade-visual-grad-left-gray text-white" style="width: 100%;">
				<h5 class="card-title">
					<i class="fas fa-bullhorn fa-lg"></i> PUBLICACIONES
					<!-- i class="far fa-newspaper fa-lg"></i> MURO-->
				</h5>
			</div>
			<div id="card-muro-body" class="card-body p-3" style="height: 170px; overflow-y: auto;">
				<ul id="list-muro" class="list-group list-group-flush"></ul>
			</div>
			<div class="card-footer text-center">
				<a class="btn btn-link" href="<?=site_url('muro')?>" >Leer mas ...</a>
			</div>
		</div>
	</div>
	<?}?>
</div>
<!--div class="row" >
	<div class="col-lg-12 col-md-12">
		<div class="main-card mb-3 card main-fotos">
			<div class="card-body vista-fotos">
				<div class="row" >
					<img src="+<?//=base_url().'public/assets/images/load3.gif'?>" alt="" width="auto" height="50px">
				</div>
			</div>
		</div>
	</div>
</div-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>
<script type="text/javascript">
	var $usuario=<?=json_encode($usuario)?>;
</script>