<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('TOTAL_DECIMALES', 2);
define('IGV', 1.18); 

class Presellers extends MY_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_presellers', 'model');
	}

	function moneda( $valor, $in_igv, $dec = TOTAL_DECIMALES  ){
		if( $in_igv == 1 ) $valor = $valor/VAL_IGV;
		if( $in_igv == 2 ) $valor = $valor;
		if( is_string( $valor ) ) return $valor;
		else {
			$valor = number_format( $valor, TOTAL_DECIMALES, '.', ',' );
			return 'S/. '.$valor;
		}
	}

	public function index(){
		$this->aSessTrack[] = [ 'idAccion' => 4 ];

		$config = array();
		$config['nav']['menu_active']='72';
		$config['css']['style'] = array('assets/libs/datatables/dataTables.bootstrap4.min', 'assets/libs/datatables/buttons.bootstrap4.min','assets/custom/css/presellers');
		$config['js']['script'] = array( 'assets/libs/datatables/datatables','assets/libs/datatables/responsive.bootstrap4.min','assets/custom/js/core/datatables-defaults', 'assets/custom/js/presellers');

		$config['data']['icon'] = 'fa fa-dollar-sign';
		$config['data']['title'] = 'Presellers';
		$config['data']['message'] = 'Módulo para el presellers';
		$config['view'] = 'modulos/presellers/index';

		$this->view($config);
	}

	public function ventas(){
		$result['msg']['title'] = 'Detalle Ventas';

		$data = json_decode($this->input->post('data'), true);

		$params = array( 'txtFechas' => $data['fechas'] );
		if(empty($params['txtFechas']))$result['msg']['content']='Debe seleccionar un rango de fechas.';

        $filtros = '';

		$data = array();
			$array['qry_ventas'] = $this->model->getDetalleVenta($params, $filtros)->result();
			$array['qry_ncomprobante'] = $this->model->getDetalleVentaComprobante($params, $filtros)->result();

			$this->aSessTrack = $this->model->aSessTrack;

        if( count($array['qry_ventas']) < 1 ) {
			$result['result']=1;
			$result['data']='<div class="col-lg-12 "><div class="mb-3 card"><div class="card-body"><p class="p-info"><i class="fa fa-info-circle"></i> No se ha generado ningun resultado.</p></div></div></div>';
		}
		else{
			$result['result']=1;
			$result['data']=$this->load->view("modulos/presellers/ventas", $array, true);
		}
		echo json_encode($result);
	}

	public function preventas(){
		$data = json_decode($this->input->post('data'), true);

		$params = array( 'txtFechas'=>$data['fechas'] );
		if(empty($params['txtFechas']))$result['msg']['content']='Debe seleccionar un rango de fechas.';

		$filtros = '';

		$data = array();
			$array['qry_ventas'] = $this->model->getDetallePreVenta($params, $filtros)->result();
			$this->aSessTrack = $this->model->aSessTrack;

        if( count($array['qry_ventas']) < 1 ){ 
			$result['result']=1;
			$result['data']='<div class="col-lg-12 "><div class="mb-3 card"><div class="card-body"><p class="p-info"><i class="fa fa-info-circle"></i> No se ha generado ningun resultado.</p></div></div></div>';
		}
		else{
			$result['result']=1;
			$result['data']=$this->load->view("modulos/presellers/preventas", $array, true);
		} 
		echo json_encode($result);
	}
	
	public function adpp(){
		$data = json_decode($this->input->post('data'), true);

		$params = array( 'txtFechas'=>$data['fechas'] );

		$data = array();
		$filtros = $filtros_join='';
		$array['qry_surte'] = $this->model->getSurte($params)->result();
		$array['qry_surte_data'] = $this->model->getSurteData($params, $filtros, $filtros_join)->result();
		$array['qry_surte_conf'] = $this->model->getSurteConfiguracion($params)->result();
		$array['qry_conf'] = $this->model->get_modulo_configuracion($params,1)->result();

		$this->aSessTrack = $this->model->aSessTrack;

		if( count($array['qry_surte']) < 1 && count($array['qry_surte_data']) < 1){ 
			$result['result']=1;
			$result['data']='<div class="col-lg-12 "><div class="mb-3 card"><div class="card-body"><p class="p-info"><i class="fa fa-info-circle"></i> No se ha generado ningun resultado.</p></div></div></div>';
		}
		else{
			$result['result']=1;
			$data['igv'] = 1.18 ;

			foreach($array['qry_conf'] as $row_cf){
				$data['monto_gana_surte'] = $row_cf->monto_gana;
				if($row_cf->idTipo == 1) 
					$data['valor1'] = $row_cf->valor;
				else
					$data['valor2'] = $row_cf->valor;
			}

			foreach($array['qry_surte'] as $row_su){
				$data['tipo_surte'][$row_su->idTipoSurte] = $row_su->tipoSurte;
				$data['surte'][$row_su->idTipoSurte][$row_su->idLineaSurte]['nombre'] = $row_su->surte;
				$data['surte'][$row_su->idTipoSurte][$row_su->idLineaSurte]['cantidad'] = $row_su->cantidad;
			}

			$data['data_surte'] = array();
			foreach($array['qry_surte_data'] as $row_sd){
				$data['data_surte'][$row_sd->idSucursal]['cod_visual'] = $row_sd->idSucursal;
				$data['data_surte'][$row_sd->idSucursal]['plaza'] = $row_sd->nombrePlaza;
				$data['data_surte'][$row_sd->idSucursal]['cod_pg'] = $row_sd->codigoPG;
				$data['data_surte'][$row_sd->idSucursal]['tipo_cliente'] = $row_sd->nombreTipoPlan;
				$data['data_surte'][$row_sd->idSucursal]['cliente'] = $row_sd->nombreCliente;
				$data['data_surte'][$row_sd->idSucursal]['sucursal'] = $row_sd->nombreSucursal;
				$data['data_surte'][$row_sd->idSucursal]['cuota'] = $row_sd->cuota;
				$data['data_surte'][$row_sd->idSucursal]['visibilidad'] = $row_sd->por_visibilidad;
				if(!empty($row_sd->idVenta)) $data['data_surte'][$row_sd->idSucursal]['ventas'][$row_sd->idVenta] = $row_sd->total_real;
				if(!empty($row_sd->idDetVenta)) $data['data_surte'][$row_sd->idSucursal]['surte'][$row_sd->idTipoSurte][$row_sd->idLineaSurte][$row_sd->idDetVenta] = $row_sd->subTotal_real;
				if(!empty($row_sd->idDetVenta)) $data['data_surte'][$row_sd->idSucursal]['cantidad'][$row_sd->idTipoSurte][$row_sd->idLineaSurte] = $row_sd->subTotal_real;
			}

			foreach($array['qry_surte_conf'] as $row_sc){
				$data['data_conf'][$row_sc->montoEscala]['porcentajeVenta'] = $row_sc->porcentajeVenta;
				$data['data_conf'][$row_sc->montoEscala]['montoEscala'] = $row_sc->montoEscala;
				$data['data_conf'][$row_sc->montoEscala]['porcentajeEscala'] = $row_sc->porcentajeEscala;
			}
			$result['data']=$this->load->view("modulos/presellers/adpp", $data, true);
		}
		echo json_encode($result);
	}

	public function cobranzas(){
		$data = json_decode($this->input->post('data'), true);

		$params = array( 'txtFechas'=>$data['fechas'] );
		if(empty($params['txtFechas']))$result['msg']['content']='Debe seleccionar un rango de fechas.';

        $filtros = '';

		$data = array();
			$array['qry_ventas'] = $this->model->getDetalleCobranzas($params, $filtros)->result();

        if( count($array['qry_ventas']) < 1 ) {
			$result['result']=2;
			$result['data']='	<div class="col-lg-12 "><div class="mb-3 card"><div class="card-body"><p class="p-info"><i class="fa fa-info-circle"></i> No se ha generado ningun resultado.</p></div></div></div>';
		}
		else{
			$result['result']=1;
			$filtros='';
			
			$filtro_ventas = '';
			$num=1;
			$total = count($array['qry_ventas']);
			foreach($array['qry_ventas'] as $row ){
				if($num==1 && $num!=$total){
					$filtro_ventas.=' AND ve.idVenta IN ('.$row->codVenta.',';
				}else if($num==1 && $num==$total){
					$filtro_ventas.=' AND ve.idVenta IN ('.$row->codVenta.')';
				}else if($num!=1 && $num!=$total){
					$filtro_ventas.=$row->codVenta.',';
				}else if($num!=1 && $num==$total){
					$filtro_ventas.=$row->codVenta.')';
				}
				$num++;
			}

			$array['qry_ncomprobante'] = $this->model->getDetalleVentaComprobante2($filtro_ventas)->result();
			$result['data']=$this->load->view("modulos/presellers/cobranzas", $array, true);
		}

		$this->aSessTrack = $this->model->aSessTrack;
		echo json_encode($result);
	}
	
	public function lomito(){
		$data = json_decode($this->input->post('data'), true);

		$params = array( 'txtFechas'=>$data['fechas'] );

        $filtros = '';

		$data = array();
		$array['qry_surte'] = $this->model->getSurte($params)->result();
		$array['qry_surte_data'] = $this->model->getLomitoData($params, $filtros)->result();
		$data['total_lomitos'] = count($array['qry_surte']);

		$this->aSessTrack = $this->model->aSessTrack;

		if( count($array['qry_surte']) < 1 || count($array['qry_surte_data']) < 1){ 
			$result['result']=2;
			$result['data']='<div class="col-lg-12 "><div class="mb-3 card"><div class="card-body"><p class="p-info"><i class="fa fa-info-circle"></i> No se ha generado ningun resultado.</p></div></div></div>';
		}
		else{
			$result['result']=1;
			$data['igv'] = 1.18;

			foreach($array['qry_surte'] as $row_su){
				$data['tipo_surte'][$row_su->idTipoSurte] = $row_su->tipoSurte;
				$data['surte'][$row_su->idTipoSurte][$row_su->idLineaSurte] = $row_su->surte;
			}

			$data['data_surte'] = array();
			foreach($array['qry_surte_data'] as $row_sd){
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['plaza'] = $row_sd->plaza;
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['usuario'] = $row_sd->usuario;
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['idUsuario'] = $row_sd->idUsuario;
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['idSucursal'] = $row_sd->idSucursal;
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['sucursal'] = $row_sd->nombreSucursal;
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['ventas'] = $row_sd->total_real;
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['presentes'] = $row_sd->total_presentes;
				$data['data_surte'][$row_sd->idUsuario][$row_sd->idSucursal]['surte'][$row_sd->idTipoSurte][$row_sd->idLineaSurte] = $row_sd->cant_surte;

				$data['resumen'][$row_sd->idPlaza][$row_sd->idUsuario] = $row_sd;
			}

			$total_surte = 0;
			foreach($data['resumen'] as $ix => $row){
				$data['plazas'][$ix] = count($row);
			}

			$result['data']=$this->load->view("modulos/presellers/lomito", $data, true);
		} 
		echo json_encode($result);
	}

	public function avance(){
		$data = json_decode($this->input->post('data'), true);

		$params = array( 'txtFechas'=>$data['fechas'] );

        $filtros = ''; $filtros_join = ''; $filtros_join2 = '';

		$data = array();
		$array = array();
		$array['qry_topesxusuario'] = $this->model->getTopesxUsuario1($params, $filtros, $filtros_join)->result();
		$array['qry_p3m'] = $this->model->p3m($params, $filtros)->result();
		$array['qry_ventas'] = $this->model->avance_ventas($params, $filtros, $filtros_join2)->result();
		$result_tiempo = $this->model->getTiempo($params)->result();

		$this->aSessTrack = $this->model->aSessTrack;

		$result['result']=1;

		foreach( $result_tiempo as $row ) {
			$data['diasUtil'] = $row->diasUtiles;
			$data['diaUtilActual'] = $row->diaUtilActual;
		}
		foreach( $array['qry_topesxusuario'] as $row){
			if(!empty($row->idUsuario)){
				$data['unidades'][$row->idUnidad]['nombre'] = $row->unidad;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['nombre'] = $row->ciudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['nombre'] = $row->plaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['nombre'] = $row->sucursal;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['nombre'] = $row->usuario;
				
				$data['unidades'][$row->idUnidad]['cuota'] = $row->cuota_unidad;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['cuota'] = $row->cuota_ciudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['cuota'] = $row->cuota_plaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['cuota'] = $row->cuota_sucursal;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['cuota'] = $row->cuota;
				
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['idUsuario'] = $row->idUsuario;
			}
		}

		foreach( $array['qry_p3m'] as $row){
			if(!empty($row->idUsuario) && isset($data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]) ){
				$data['unidades'][$row->idUnidad]['p3m'] = $row->ventaUnidad;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['p3m'] = $row->ventaCiudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['p3m'] = $row->ventaPlaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['p3m'] = $row->ventaTope;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['p3m'] = $row->ventaUsuario;
			}
		}

		foreach( $array['qry_ventas'] as $row){
			if(!empty($row->idUsuario) && isset($data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario])){
				$data['unidades'][$row->idUnidad]['ventas'] = $row->ventaUnidad;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['ventas'] = $row->ventaCiudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['ventas'] = $row->ventaPlaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['ventas'] = $row->ventaTope;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['ventas'] = $row->ventaUsuario;
			}
		}
		if(count($array['qry_topesxusuario'])==0){
			$data['mensaje']='NO SE ENCONTRO INFORMACION CON LOS FILTROS SELECCIONADOS.';
		}else{
			$data['mensaje']='';
		}
		$data['igv'] = 1.18;
		$result['result']=1;
		$result['msg']['tipo']=2;
		$result['data']=$this->load->view("modulos/presellers/avance", $data, true);

		echo json_encode($result);
	}

	public function summary(){
		$post = json_decode($this->input->post('data'), true);

		$params = array( 'txtFechas'=>$post['fechas'] );

        $filtros = ''; $filtros_join = '';

		$array['qry_topesxusuario'] = $this->model->getTopesxUsuario1($params, $filtros, $filtros_join)->result();
		$array['qry_p3m'] = $this->model->p3m($params, $filtros)->result();
		$array['qry_ventas'] = $this->model->avance_ventas($params, $filtros,$filtros_join)->result();
		$array['categorias'] = $this->model->categorias($params)->result();

		$result_tiempo = $this->model->getTiempo($params)->result();

		foreach( $result_tiempo as $row ) {
			$data['diasUtil'] = $row->diasUtiles;
			$data['diaUtilActual'] = $row->diaUtilActual;
		}

		foreach( $array['qry_topesxusuario'] as $row){
			if(!empty($row->idUsuario)){
				$data['unidades'][$row->idUnidad]['nombre'] = $row->unidad;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['nombre'] = $row->ciudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['nombre'] = $row->plaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['nombre'] = $row->sucursal;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['nombre'] = $row->usuario;
				$data['unidades'][$row->idUnidad]['cuota'] = $row->cuota_unidad;
				$data['cuotaTotal'] = $row->cuota_total;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['cuota'] = $row->cuota_ciudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['cuota'] = $row->cuota_plaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['cuota'] = $row->cuota_sucursal;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['cuota'] = $row->cuota;
				$data['top_ofender'][$row->idSucursal]['nombre'] = $row->sucursal;
				$data['top_performance'][$row->idSucursal]['nombre'] = $row->sucursal;
				$data['top_ofender'][$row->idSucursal]['cuota'] = $row->cuota_sucursal;
				$data['top_performance'][$row->idSucursal]['cuota'] = $row->cuota_sucursal;
			}
		}

		foreach( $array['qry_p3m'] as $row){
			if(!empty($row->idUsuario) && isset($data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario])){
				$data['unidades'][$row->idUnidad]['p3m'] = $row->ventaUnidad;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['p3m'] = $row->ventaCiudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['p3m'] = $row->ventaPlaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['p3m'] = $row->ventaTope;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['p3m'] = $row->ventaUsuario;
				$data['top_ofender'][$row->idSucursal]['p3m'] = $row->ventaTope;
				$data['top_performance'][$row->idSucursal]['p3m'] = $row->ventaTope;
			}
		}
		foreach( $array['qry_ventas'] as $row){
			if(!empty($row->idUsuario) && isset($data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]) ){
				$data['unidades'][$row->idUnidad]['ventas'] = $row->ventaUnidad;
				$data['ciudades'][$row->idUnidad][$row->idCiudad]['ventas'] = $row->ventaCiudad;
				$data['plazas'][$row->idUnidad][$row->idCiudad][$row->idPlaza]['ventas'] = $row->ventaPlaza;
				$data['topes'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal]['ventas'] = $row->ventaTope;
				$data['usuarios'][$row->idUnidad][$row->idCiudad][$row->idPlaza][$row->idSucursal][$row->idUsuario]['ventas'] = $row->ventaUsuario;
				$data['top_ofender'][$row->idSucursal]['ventas'] = $row->ventaTope;
				$data['top_performance'][$row->idSucursal]['ventas'] = $row->ventaTope;
			}
		}

		foreach($array['qry_ventas'] as $row){
			$data['ventas'][$row->idSucursal]['idSucursal'] = $row->idSucursal;
			$data['ventas'][$row->idSucursal]['venta'] = $row->ventaTope;
		}

		foreach($this->model->getFechas($params)->result() as $fila){
            $data['cabeceraAnioMes'][$fila->anio][$fila->idMes]=$fila->mes;
			$data['fechas'][$fila->anio][$fila->idMes]['anio'] = $fila->anio;
			$data['fechas'][$fila->anio][$fila->idMes]['mes'] = $fila->mes;
			$data['anioActual'] = $fila->anio;
			$data['mesActual'] = $fila->mes;
        }

		foreach($array['categorias'] as $fila) {
            $data['categoria'][$fila->comparteCuota]['nombre'][]= $fila->categoria;
            $data['categoria'][$fila->comparteCuota]['cuota']= $fila->porcentajeCuota;
            $data['categoria'][$fila->comparteCuota]['idProductoCategoria'][] = $fila->idProductoCategoria;
        }

		 foreach($this->model->ventas_x_categoria($params, $filtros)->result() as $fila) {
            $data['ventaCategoriaXMesAnio'][$fila->anio][$fila->mes] = $fila->ventaXMesAnio;     
        }
		$fechas = $params['txtFechas'];
		$arrayFechas = explode("-",$fechas);
		$fec = explode('/',$arrayFechas[1]);
		$mes= (int)$fec[1];
		foreach($this->model->promedio_ventas($params, $filtros)->result() as $row){
			$data['ventaCategoria'][$row->anio][$row->mes][$row->idCategoria] = $row->ventaCategoria;
			if($row->mes != $mes){
				$data['promedioVentaXCategoria'][$row->idCategoria][] = $row->ventaCategoria;
			}

		}

		$this->aSessTrack = $this->model->aSessTrack;

		$data['fechaInicial'] = $arrayFechas[0];
		$data['fechaFinal'] = $arrayFechas[1];

		$data['igv'] = 1.18;
		$result['result']=1;
		$result['msg']['tipo']=2;
		$result['data']=$this->load->view("modulos/presellers/summary", $data, true);

		echo json_encode($result);
	}

}
