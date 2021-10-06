<nav class="navbar navbar-expand-lg navbar-light bg-light k sticky-top flex-md-nowrap p-0 shadow header-text-dark fixed-top ">
	<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3 a-href" href="javascript:;" page="home">
		<div class="logo-src"></div>
	</a>
	<button class="btn btn-trade-visual" id="btn-toggle-menu" data-show="false" ><i class="fal fa-window-maximize" ></i></button>
	<button class="text-dark navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="navbar-collapse collapse show" id="navbarsExample09" style="">
		<form id="frm-sidebarMenu" class="form-inline col-md-5 my-2 my-md-0">
			<!-- <div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-search"></i></span>
				</div>
				<input type="text" class="form-control" placeholder="Buscar en impactTrade">
			</div> -->
			<div class="ui category search">
				<div class="ui icon input">
					<input class="prompt" type="text" placeholder="Buscar en ImpactTrade...">
					<i class="search icon"></i>
				</div>
				<div class="results"></div>
			</div>
		
		
		</form>
		<!-- -->
		<ul class="navbar-nav ml-auto" style="display: table;">
			<!-- <li  class="nav-item" ></li> -->
			<li style="display: table-cell;">
				<div class="input-group" style="transform: translateY(-20%);">
					<span class="input-group-text text-capitalize border-0 pt-0 text-left" style="background-color: #f8f9fa; font-size:12px"> Cuenta: <?=$this->sessNomCuenta?> <br> Proyecto: <?=$this->sessNomProyecto?></span>
					<!-- <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2"> -->
					<div class="input-group-append">
						<!-- <button type="button" class="btn btn-outline-trade-visual btn-change" onclick="$('#a-cambiarcuenta').click();" ><i class="fad fa-sync" ></i></button> -->
					</div>
				</div>
			</li>
			<?$logoCuenta = $this->session->userdata('logoCuenta');?>
			<?if(!empty($logoCuenta)){?>
			<li style="display: table-cell;"><img src="assets/images/logos/<?=$logoCuenta?>" class="logo-cuenta" /></li>
			<?}?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?
				if( strlen($header_foto)==0 ) echo '<img class="user-profile" src="assets/images/avatars/'.rand(1,4).'.png" alt="" />';
				else echo '<img class="user-profile" src="https://www.visualimpact.com.pe/intranet/files/empleado/'.$header_foto.'" alt=""  />';
				?>
				<?
				if( strlen($header_usuario)==0 ) echo 'USUARIO TI';
				else echo $header_usuario;
				?></a>
				<div class="dropdown-menu item-right" aria-labelledby="dropdown09">
					<a class="dropdown-item btn-anuncios" href="javascript:;"  data-target="#modalAvisoConfidencialidad" data-toggle="modal"><i class="fa fa-bullhorn pull-left"></i> Anuncios</a>
					<a class="dropdown-item" href="<?=base_url()."Perfil"?>"><i class="nav-link-icon fa fa-cog"></i> Mi Perfil</a>
					<?
					if(
						isset($this->permisos['cuenta']) &&
						isset($this->permisos['proyecto']) && (
						count($this->permisos['cuenta']) > 1 ||
						empty($this->permisos['proyecto']) ||
						count($this->permisos['proyecto']) > 1
					)){
					?>
						<a class="dropdown-item" href="javascript:;" id="a-cambiarcuenta"><i class="nav-link-icon fas fa-filter"></i> Cuenta / Proyecto</a>
					<?}?>
					<a class="dropdown-item" href="<?=base_url().'Recover'?>"><i class="fa fa-unlock" ></i> Cambiar Clave</a>
					<a class="dropdown-item" href="javascript:Fn.logOut('home/logout');"><i class="fa fa-sign-out"></i> Salir</a>
				</div>
				<button id="btn-anuncios" style="display:none;"></button>
			</li>
		</ul>
	</div>
</nav>