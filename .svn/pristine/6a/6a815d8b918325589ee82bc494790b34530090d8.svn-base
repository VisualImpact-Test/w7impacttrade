<style>
	.color-C { color: #5cb85c; }
	.color-I { color: #f6ea67; }
	.color-F { color: #d9534f; }
	.color-O { color: #6063d7; }
	.color-V { color: #95cbe7; }
	.color-Fe { color: #666; }

	.page-item{
		/*border: 5px solid red;*/
	}

	.page-item div.item-li{
		position: relative;
		display: block;
		padding: .5rem .75rem;
		margin-left: -1px;
		line-height: 1.25;
		background-color: #fff;
		border: 1px solid #dee2e6;
		min-height: inherit;
	}
	.textCondicion{
		height: 35px;
	}
</style>
<form id="formNewPublicacion">
	<div class="row">
		<div class="col-lg-3">
		</div>
		<div class="col-lg-6">
			<div class="main-card mb-3 card" style="padding:10;">
				<div class="card-body">
					<div class='form-row'>
						<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
							<label for='titulo'>Titulo</label><br>
							<input id='titulo' name='titulo' type='text' class='form-control form-control-sm' placeholder='Titulo'>
						</div>
					</div>

					<div class='form-row'>
						<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
							<label for='comentario'>Contenido</label><br>
							<textarea id='comentario' name='comentario' type='text' class='form-control form-control-sm' placeholder='Contenido'></textarea>
						</div>
					</div>
					<div class='form-row'>
						<input type="button" id="btn-agregar-foto" value="+ Foto">
						<input type="file" id="btn-file-foto" style="display: none;" accept="image/jpeg">
					</div>
					<div class='form-row' id="listaFotos">
					</div>

					<div class='form-row'>
						<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
							<input type="button" class='form-control form-control-sm' id="btn-descartar-publicacion" value="Reestablecer">
						</div>
						<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
						</div>
						<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
							<input type="button" class='form-control form-control-sm' id="btn-enviar-publicacion" value="Guardar">
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</form>

<div class="row">
	<div class="col-lg-3">
	</div>
	<div class="col-lg-6">
	    <div class="main-card mb-3 card">
	        <div class="card-body">
	            <div id="idContentPublicaciones" class="row" >
	            	<div class="alert alert-info" role="alert">
						<i class="fas fa-info-circle"></i> NO HAY PUBLICACIONES
					</div>
	            </div>
				<div id="mensajeCargandoFilas" class="col-lg-12" style="text-align:center;">
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-lg-3">
	</div>
</div>

<!--script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-base.min.js" type="text/javascript"></script-->
<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>
<script type="text/javascript">
	var usuario_=<?=JSON_ENCODE($usuario)?>;	
</script>