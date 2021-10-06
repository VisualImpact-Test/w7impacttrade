<div id="content-muro" class="row mt-3">
	<div class="content-card col-lg-3 d-none d-lg-block order-1 position-fixed">

		<div id="card-grupo" class="card card-muro d-none d-lg-block mb-3">
			<div class="card-head py-2 px-3">
				<i class="align-middle fas fa-users-cog"></i>
				<span class="align-middle">Grupos</span>
				<button class="btn-card-hide btn btn-sm float-right d-lg-none d-xl-none" data-card="estado">
					<i class="fas fa-times fa-lg"></i>
				</button>
			</div>
			<div class="card-body">
				<div class="row">
					<label class="col-md-4 font-weight-bold">Cuenta: </label>
					<div class="col-md-12">
						<select id="idCuenta" class="form-control form-control-sm" >
						</select>
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 font-weight-bold">Proyecto: </label>
					<div class="col-md-12">
						<select id="idProyecto" class="form-control form-control-sm" >
						</select>
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 font-weight-bold">Grupo: </label>
					<div class="col-md-12">
						<select id="idGrupo" class="form-control form-control-sm" >
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<div id="card-estado" class="card card-muro d-none d-lg-block mb-3">
			<div class="card-head py-2 px-3">
				<i class="align-middle fas fa-user-tie mr-1"></i>
				<span class="align-middle">Mis Datos</span>
				<button class="btn-card-hide btn btn-sm float-right d-lg-none d-xl-none" data-card="estado">
					<i class="fas fa-times fa-lg"></i>
				</button>
			</div>
			<div class="card-body">
				<div class="row">
					<label class="col-md-4 font-weight-bold">Nombres: </label>
					<label class="col-md-6"><?=$usuario['nombres']?></label>
				</div>
				<div class="row">
					<label class="col-md-4 font-weight-bold">Apellidos: </label>
					<label class="col-md-6"><?=$usuario['apePaterno'].' '.$usuario['apeMaterno']?></label>
				</div>
				<div class="row">
					<label class="col-md-4 font-weight-bold">Cargo: </label>
					<label class="col-md-6"><?=$usuario['cargo']?></label>
				</div>
				<div class="row">
					<label class="col-md-4 font-weight-bold">Unidad: </label>
					<label class="col-md-6"><?=$usuario['unidad']?></label>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<label class="font-weight-bold">Estado: </label>
						<div class="input-group">
							<input type="text" id="estado" name="estado" class="keyupcount form-control form-control-sm" placeholder="Escribe un breve texto" maxlength="25">
							<div class="input-group-append">
								<button type="button" id="btn-publicacion-estado" class="btn btn-outline-primary btn-sm">
									<i class="far fa-bell"></i>
								</button>
							</div>
						</div>
						<div class="txt-count float-right">
							<small class="text-secondary">
								<span class="txt-current">0</span>
								<span>/ 25</span>
							</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content-card col-lg-3 offset-lg-9 d-none d-lg-block order-3 position-fixed">
		<div id="card-filtros" class="card card-muro d-none d-lg-block mb-3">
			<!--div class="card-head bg-purple-gradient text-white py-2 px-3"-->
			<div class="card-head py-2 px-3">
				<i class="align-middle fas fa-filter mr-1"></i>
				<span class="align-middle">Filtros</span>
				<button class="btn-card-hide btn btn-sm float-right d-lg-none d-xl-none" data-card="filtros">
					<i class="fas fa-times fa-lg"></i>
				</button>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Fechas:</label>
							<!--input type="text" name="fechas" value="<?=date('d/m/Y').' - '.date('d/m/Y')?>" id="buscar-fechas" class="form-control form-control-sm"-->
							<input type="text" name="fechas" value="" id="buscar-fechas" class="form-control form-control-sm">
						</div>
					</div>
					<div class="col-md-12">
						<label>Buscar por:</label>
						<div class="btn-group btn-group-toggle ml-1 mb-1 float-right" data-toggle="buttons">
							<label class="btn btn-outline-primary btn-sm active">
								<input type="radio" name="buscar-por" class="buscar-por" value="usuario" checked> <i class="fas fa-user-friends"></i> Personas
							</label>
							<label class="btn btn-outline-primary btn-sm">
								<input type="radio" name="buscar-por" class="buscar-por" value="lugares" > <i class="fas fa-map-signs"></i> Lugares
							</label>
						</div>
						<input type="autocomplete" name="buscar-texto" id="buscar-texto" class="form-control form-control-sm" placeholder="Ingrese una palabra" maxlength="100">
						<small id="buscar-resultado-vacio" class="text-danger hide">No se encontró coincidencias.</small>
						<input type="hidden" name="buscar-id" id="buscar-id" value="">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button id="buscar" class="btn btn-primary btn-sm mt-3 float-right"><i class="fas fa-search"></i> Buscar</button>
					</div>
				</div>
			</div>
		</div>
		<div id="card-online" class="card card-muro d-none d-lg-block mb-3">
			<!--div class="card-head bg-purple-gradient text-white py-2 px-3"-->
			<div class="card-head py-2 px-3">
				<i class="align-middle fas fa-user-friends mr-1"></i>
				<span class="align-middle">Online</span>
				<button class="btn-card-hide btn btn-sm float-right d-lg-none d-xl-none" data-card="online">
					<i class="fas fa-times fa-lg"></i>
				</button>
			</div>
			<div id="card-muro-usuarios" class="card-body pt-1 px-2"></div>
		</div>
	</div>
	<!--div class="col-lg-6 col-md-12 order-2"-->
	<div class="col-lg-6 col-md-12 offset-lg-3 order-2">
		<div class="row">
			<div class="col-lg-12 col-md-12 d-lg-none">
				<div class="text-center m-3">
					<button type="button" class="btn-card-show btn btn-primary btn-sm rounded-pill" data-card="estado" ><i class="fas fa-user-tie"></i> Estado</button>
					<button type="button" class="btn-card-show btn btn-primary btn-sm rounded-pill" data-card="filtros" ><i class="fas fa-filter"></i> Filtros</button>
					<button type="button" class="btn-card-show btn btn-primary btn-sm rounded-pill" data-card="online" ><i class="fas fa-user-friends"></i> Online</button>
				</div>
			</div>
			<div class="col-lg-12 col-md-12">
				<div class="card mb-3">
					<div class="card-head bg-purple-gradient text-white py-2 px-3">
						<i class="align-middle far fa-comment-dots mr-1"></i>
						<span class="align-middle">Empieza por aquí</span>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-2 align-content-center text-center">
								<img
									src="http://www.visualimpact.com.pe/intranet/files/empleado/<?=$this->foto?>"
									class="img-fluid rounded-circle"
									style="width: 50px; height: 50px;"
								>
							</div>
							<div class="col-md-10">
								<div class="form-group hide">
									<input type="hidden" name="titulo" id="titulo" placeholder="Titulo">
									<input type="file" id="file-publicacion-foto" class="hide" accept="image/jpeg">
								</div>
								<div class="form-group m-0">
									<textarea name="comentario" id="comentario" class="form-control keyupcount" placeholder="¿Tienes algo que comunicar?, escríbelo aquí..." rows="1" maxlength="250" autocomplete="off"></textarea>
									<div class="txt-count float-right">
										<small class="text-secondary">
											<span class="txt-current">0</span>
											<span>/ 250</span>
										</small>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div id="listaFotos"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<hr>
								<div class="form-group mb-0">
									<div class="d-flex justify-content-between">
										<button type="button" id="btn-publicacion-foto" class="btn btn-link text-decoration-none">
											<i class="align-middle fas fa-camera-retro fa-2x"></i>
											<span class="align-middle ml-1">Fotos</span>
										</button>
										<button type="button" id="btn-publicacion-enviar" class="btn btn-link text-decoration-none">
											<i class="align-middle fa fa-send fa-2x"></i>
											<span class="align-middle ml-1">Publicar</span>
										</button>
										<button type="button" id="btn-publicacion-limpiar" class="btn btn-link text-decoration-none">
											<i class="align-middle fas fa-eraser fa-2x"></i>
											<span class="align-middle ml-1">Borrar</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="content-publicacion" class="row"></div>
		<div class="row">
			<div id="content-publicacion-btn-load" class="col-lg-12 text-center hide">
				<button id="btn-publicacion-load" class="btn btn-primary w-75 mb-3">
					<i class="far fa-eye"></i> Mostrar más publicaciones
				</button>
			</div>
			<div id="content-publicacion-msg" class="col-lg-12"></div>
		</div>
	</div>
</div>
<div id="backdrop-static" class="modal-backdrop d-none fade" style="z-index: 2000;"></div>
<script>
/*
	var textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', autosize);
             
function autosize(){
  var el = this;
  setTimeout(function(){
    el.style.cssText = 'height:auto; padding:0';
    // for box-sizing other than "content-box" use:
    // el.style.cssText = '-moz-box-sizing:content-box';
    el.style.cssText = 'height:' + el.scrollHeight + 'px';
  },0);
}
*/
</script>
<script type="text/javascript">
	var $usuario=<?=json_encode($usuario)?>;	
	var $usuario_filtro=<?=json_encode($usuario_filtro)?>;	
</script>
