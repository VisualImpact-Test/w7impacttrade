<!doctype html>
<html lang="es">
  <head>
	<meta charset="utf-8">
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="es">
	<title>:.:.: Visual Impact - ImpactTrade :.:.:</title>
	<meta name="description" content="coming soom.">
	<meta name="msapplication-tap-highlight" content="no">
	<base href="<?=base_url().'public/';?>" site_url="<?=site_url();?>">
	<!-- Bootstrap core CSS -->
	<link href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- -->
	<link rel="icon" href="assets/images/icono.png">
	<link href="assets/custom/css/sidebar-right.css?v=<?=$this->version;?>" rel="stylesheet">
	<!-- -->
	<link href="assets/custom/css/main.css?v=<?=$this->version;?>" rel="stylesheet">
	<link href="assets/custom/css/circle-progress.css?v=<?=$this->version;?>" rel="stylesheet">
	<!-- -->
	<!-- <script src="https://kit.fontawesome.com/5ea7d43f0c.js" crossorigin="anonymous"></script> -->

	<script>function initMap(){}</script>
	<link href="assets/libs/font-awesome/5.15.3/css/all.min.css?v=<?=$this->version;?>" rel="stylesheet">
	<link href="assets/libs/daterangepicker/daterangepicker.css?v=<?=$this->version;?>" rel="stylesheet">
	<link href="assets/libs/select2/4.0.13/css/select2.min.css?v=<?=$this->version;?>" rel="stylesheet">
	<!-- <link href="assets/libs/semanticui/semantic.min.css?v=<?=$this->version;?>" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">
	
	<!-- <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet"> -->

	<!-- <link href="assets/libs/dataTables-1.10.25/DataTables-1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
	

	<link href="assets/libs/datatables/datatables.bootstrap4.min.css" rel="stylesheet">


	<?foreach($style as $css){?>
		<link href="<?=$css?>.css?v=<?=$this->version;?>" rel="stylesheet">
	<?}?>
	<!-- -->
	<!--CSS PERSONALIZADO POR CUENTA -->
	<?$cssCuenta = $this->session->userdata('cssCuenta');?>
		<?if(!empty($cssCuenta)){?>
		<link href="assets/custom/css/<?=$cssCuenta?>?v=<?=$this->version;?>" rel="stylesheet">
		<?}?>
		
	
</head>