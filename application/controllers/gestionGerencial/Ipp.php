<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipp extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gestionGerencial/m_ipp','model');
    }

    public function index(){
		$idMenu = '138';
		$config['nav']['menu_active'] = $idMenu;
    	$config['body_nav']['activeGrupo']['gestionGerencial']=true;
		$config['body_nav']['activePage']['ipp']=true;
		$config['js']['script']=array(
            'assets/libs/datatables/responsive.bootstrap4.min',
			'assets/libs/tableHeadFixer',
			'assets/custom/js/core/datatables-defaults',
			'assets/custom/js/gestionGerencial/ipp',
        );
		$config['data']['title']='Filtros IPP';
        $config['data']['icon'] = 'fa fa-list';
		$config['data']['tienda'] = $this->model->obtener_cliente()->result_array();
        $config['view']='modulos/gestionGerencial/ipp/index';
		$this->view($config);
    }

    public function tienda(){
    	//
    	$data=json_decode($this->input->post('data'));
    	$fechas=explode(" - ",$data->{'txt-fechas'});
    	//
    	$input = array(
    		'fecIni' => $fechas[0]
				, 'fecFin' => $fechas[1]
				, 'idCliente' => !empty($data->{'sl-tienda'}) ? $data->{'sl-tienda'} : '58'
				, 'idUsuarioEnc' => $data->{'sl-encargado'}
    	);

    	$result=array();
		$result['result']=0;
		$result['url']='';
		$result['data']='';
		$result['msg']['title']='Alerta';
		$result['msg']['content']='';	
		//
		if ( empty($input['idCliente']) ) {
			$result['data'] = getMensajeGestion('custom',['icono'=>'fal fa-exclamation-circle','class'=>'alert alert-danger m-3','message'=>'Debe seleccionar una tienda']);
			$result['result'] = 1;
			echo json_encode($result);
			exit();
		}
		//
		$puntajeGlobal=0;
		$result['result']=1;
		$array = array();
		//
		$data = $this->model->obtener_data()->result_array();
		//
		if ( count($data)>0 ) {
			foreach ($data as $key => $row) {
				$array['preguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['preguntas'][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$array['preguntas'][$row['idPregunta']]['idCriterio'] = $row['idCriterio'];
				$array['preguntas'][$row['idPregunta']]['criterio'] = $row['criterio'];
				$array['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['idAlternativa'] = $row['idAlternativa'];
				$array['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['alternativa'] = $row['alternativa'];
				$array['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['puntaje'] = $row['puntaje'];
			}
		}
		//
		$dataTienda = $this->model->obtener_tienda($input)->result_array();
		if ( count($dataTienda)>0 ) {
			foreach ($dataTienda as $key => $row) {
				$array['visitas'][$row['idVisita']] = $row;
				$puntajeGlobal = $puntajeGlobal + ((is_null($row['puntaje'])) ? 0 : $row['puntaje']);
				$array['visitas'][$row['idVisita']]['puntajeGlobal'] = $puntajeGlobal;
				$array['pregAlternativas'][$row['idVisita']]['idVisita'] = $row['idVisita'];
				$array['pregAlternativas'][$row['idVisita']]['preguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['pregAlternativas'][$row['idVisita']]['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['idAlternativa']= $row['idAlternativa'];

				$array['criterios'][$row['idCriterio']]['idCriterio'] = $row['idCriterio'];
				$array['criterios'][$row['idCriterio']]['puntaje'] = ((isset($array['criterios'][$row['idCriterio']]['puntaje']))? $array['criterios'][$row['idCriterio']]['puntaje'] :0 )  + ( (is_null($row['puntaje'])) ? 0 :$row['puntaje']);
			}
		}
		//
		if (count($dataTienda)==0) {
			$result['data']= getMensajeGestion('noRegistros');
		} else {
			$result['data'] = $this->load->view("modulos/gestionGerencial/ipp/especifico", $array, true);
		}
		//

		echo json_encode($result);
    }

	public function resumen(){
		//
    	$data = json_decode($this->input->post('data'));
    	$fechas=explode(" - ",$data->{'txt-fechas'});
    	//
    	$input = array(
			  'fecIni' => $fechas[0]
			, 'fecFin' => $fechas[1]
			, 'sl-cuenta' => $this->sessIdCuenta
    		, 'sl-proyecto' => $this->sessIdProyecto
    		, 'sl-grupoCanal' => $data->{'grupoCanal_filtro'}
    		, 'sl-canal' => $data->{'canal_filtro'}
			, 'subCanal' => $data->{'subcanal_filtro'}
    		, 'sl-tienda' => !empty($data->{'sl-tienda'}) ? $data->{'sl-tienda'} : ''
    		, 'sl-departamento' => $data->{'sl-departamento'}
    		, 'sl-provincia' => $data->{'sl-provincia'}
    		, 'sl-distrito' => $data->{'sl-distrito'}
    		, 'sl-cadena' => !empty($data->{'cadena_filtro'}) ? $data->{'cadena_filtro'} : ''
    		, 'sl-banner' => !empty($data->{'banner_filtro'}) ? $data->{'banner_filtro'} : ''
    		, 'sl-hfs' => $data->{'sl-hfs'}
			, 'sl-whls' => $data->{'sl-whls'}
			, 'idUsuarioEnc' => $data->{'sl-encargado'}
		);
		//
    	$result=array();
		$result['result']=0;
		$result['url']='';
		$result['data']='';
		$result['msg']['title']='Alerta';
		$result['msg']['content']='';	
		//
		$result['result']=1;
		$array = array();
		//
		$data = $this->model->obtener_data()->result_array();

		if ( count($data)>0 ) {
			$array['puntaje_maximo'] = 0;
			foreach ($data as $key => $row) {
				if($row['puntaje'] > 0){
					$array['criterios'][$row['idCriterio']] = $row;
					$array['preguntas'][$row['idCriterio']][$row['idPregunta']] = $row;
					$array['puntaje_maximo'] = 6;
				}
			}
		}
		//
		$data = $this->model->obtener_detallado($input)->result_array();
		//
		$unq_ix = 0;
		$puntajes = array();
		foreach ($data as $key => $row) {
			$array['canal'][$row['idCanal']] = $row;
			$array['banner'][$row['idCanal']][$row['idBanner']] = $row;
			//
			$unq_ix++;
			$puntajes[$row['idBanner']][$row['idCriterio']][$row['idPregunta']][$unq_ix] = $row['puntaje'];
			$array['encuestas'][$row['idBanner']][$row['idVisita']] = $row;
		}
		foreach($puntajes as $ix_ba => $row_ba){
			$sum__ = 0;
			foreach($row_ba as $ix_cr => $row_cr){
				$sum_ = 0;
				foreach($row_cr as $ix_p => $row_p){
					$sum = 0; $count=0;
					foreach($row_p as $ix_ => $row_){
						$sum = $sum + $row_;
						$count++;
					}
					$prom = ($count>0)? round($sum/$count,2) : 0; 
					$sum_ = $sum_ + $prom;
					$array['puntos_pregunta'][$ix_ba][$ix_cr][$ix_p] = $prom;
				}
				
				$array['puntos_criterio'][$ix_ba][$ix_cr] = $sum_;
				$sum__ = $sum__ + $sum_;
			}
			$array['puntos_banner'][$ix_ba] = $sum__;
		}
		//
		if (count($data)==0) {
			$result['data']=getMensajeGestion('noRegistros');
		} else {
			$result['data'] = $this->load->view("modulos/gestionGerencial/ipp/resumen", $array, true);
		}
		//
		echo json_encode($result);
		
	}
	
    public function detallado(){
    	//
    	$data = json_decode($this->input->post('data'));
    	$fechas=explode(" - ",$data->{'txt-fechas'});
    	//
    	$input = array(
			'fecIni' => $fechas[0]
			, 'fecFin' => $fechas[1]
			, 'sl-cuenta' => $this->sessIdCuenta
    		, 'sl-proyecto' => $this->sessIdProyecto
    		, 'sl-grupoCanal' => $data->{'grupoCanal_filtro'}
    		, 'sl-canal' => $data->{'canal_filtro'}
			, 'subCanal' => $data->{'subcanal_filtro'}
    		, 'sl-tienda' => !empty($data->{'sl-tienda'}) ? $data->{'sl-tienda'} : ''
    		, 'sl-departamento' => $data->{'sl-departamento'}
    		, 'sl-provincia' => $data->{'sl-provincia'}
    		, 'sl-distrito' => $data->{'sl-distrito'}
    		, 'sl-cadena' => !empty($data->{'cadena_filtro'}) ? $data->{'cadena_filtro'} : ''
    		, 'sl-banner' => !empty($data->{'banner_filtro'}) ? $data->{'banner_filtro'} : ''
    		, 'sl-hfs' => $data->{'sl-hfs'}
			, 'sl-whls' => $data->{'sl-whls'}
			, 'idUsuarioEnc' => $data->{'sl-encargado'}
		);
		//
    	$result=array();
		$result['result']=0;
		$result['url']='';
		$result['data']='';
		$result['msg']['title']='Alerta';
		$result['msg']['content']='';	
		//
		$result['result']=1;
		$array = array();
		//
		$data = $this->model->obtener_data()->result_array();

		if ( count($data)>0 ) {
			foreach ($data as $key => $row) {
				$array['preguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
				$array['preguntas'][$row['idPregunta']]['pregunta'] = $row['pregunta'];
				$array['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['idAlternativa'] = $row['idAlternativa'];
				$array['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['alternativa'] = $row['alternativa'];
				$array['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['puntaje'] = $row['puntaje'];
			}
		}
		//
		$data = $this->model->obtener_detallado($input)->result_array();
		//
		foreach ($data as $key => $row) {
			$array['visitas'][$row['idVisita']] = $row;
			$array['pregAlternativas'][$row['idVisita']]['idVisita'] = $row['idVisita'];
			$array['pregAlternativas'][$row['idVisita']]['preguntas'][$row['idPregunta']]['idPregunta'] = $row['idPregunta'];
			$array['pregAlternativas'][$row['idVisita']]['preguntas'][$row['idPregunta']]['alternativas'][$row['idAlternativa']]['idAlternativa']= $row['idAlternativa'];
		}
		//
		if (count($data)==0) {
			$result['data']= getMensajeGestion('noRegistros');
		} else {
			$result['data'] = $this->load->view("modulos/gestionGerencial/ipp/detallado", $array, true);
		}
		//
		echo json_encode($result);
    }

   public function obtener_clientesFiltro(){
		$post=json_decode($this->input->post('data'));

		$params = array(
			'idCadena' => $post->{'idCadena'}
			,'idBanner' => $post->{'idBanner'}
		);
		$rs_modelo=$this->model->obtenerFiltro_clientesModerno($params)->result_array();
	
		$data['data']['clientes']=$rs_modelo;
		
		echo json_encode($data);
	}

	
	public function resumen_nuevo(){
		//
    	$data = json_decode($this->input->post('data'));

    	$fechas=explode(" - ",$data->{'txt-fechas'});
    	//
    	$input = array(
			  'anio' => $data->{'sl-anio'}
			, 'mes' => $data->{'sl-mes'}
			, 'fecIni' => $fechas[0]
			, 'fecFin' => $fechas[1]
			, 'sl-cuenta' => $this->sessIdCuenta
    		, 'sl-proyecto' => $this->sessIdProyecto
    		, 'sl-grupoCanal' => $data->{'grupoCanal_filtro'}
    		, 'sl-canal' => $data->{'canal_filtro'}
			, 'subCanal' => $data->{'subcanal_filtro'}
    		, 'sl-tienda' => !empty($data->{'sl-tienda'}) ? $data->{'sl-tienda'} : ''
    		, 'sl-departamento' => $data->{'sl-departamento'}
    		, 'sl-provincia' => $data->{'sl-provincia'}
    		, 'sl-distrito' => $data->{'sl-distrito'}
    		, 'sl-cadena' => !empty($data->{'cadena_filtro'}) ? $data->{'cadena_filtro'} : ''
    		, 'sl-banner' => !empty($data->{'banner_filtro'}) ? $data->{'banner_filtro'} : ''
    		, 'sl-hfs' => $data->{'sl-hfs'}
			, 'sl-whls' => $data->{'sl-whls'}
			, 'idUsuarioEnc' => $data->{'sl-encargado'}
		);
		//
    	$result=array();
		$result['result']=0;
		$result['url']='';
		$result['data']='';
		$result['msg']['title']='Alerta';
		$result['msg']['content']='';	
		//
		$data = array();
		if(!empty($input['anio'])){
			$result['result']=1;
			$array = array();
			//
			$data = $this->model->obtener_data()->result_array();
			$array['meses'] = $this->model->obtener_meses()->result_array();

			if ( count($data)>0 ) {
				$array['puntaje_maximo'] = 0;
				foreach ($data as $key => $row) {
					if($row['puntaje'] > 0){
						$array['criterios'][$row['idCriterio']] = $row;
						$array['preguntas'][$row['idCriterio']][$row['idPregunta']] = $row;
						$array['puntaje_maximo'] = 6;
					}
				}
			}
			//
			$data_puntajes = $this->model->obtener_mensual($input)->result_array();
			$data_encuestas = $this->model->obtener_encuestas_resumen($input)->result_array();
			//
			$unq_ix = 0;
			$puntajes = array();
			foreach ($data_puntajes as $key => $row) {
				$array['puntajes'][$row['anio']][$row['mes']][$row['idCriterio']][$row['idPregunta']]['puntaje'] = $row['promPuntajePregunta'];
				$array['totalCriterio'][$row['anio']][$row['mes']][$row['idCriterio']]['totalCriterio'] = $row['totalCriterio'];
				$array['totalGeneral'][$row['anio']][$row['mes']]['totalGeneral'] = $row['totalGeneral'];
				$array['totalGeneral'][$row['anio']][$row['mes']]['objetivo'] = $row['objetivo'];
				//$array['totalGeneral'][$row['anio']][$row['mes']]['encuestas'] = $row['encuestas'];
			}
			
			foreach ($data_encuestas as $key => $row) {
				$array['totalGeneral'][$row['anio']][$row['mes']]['encuestas'] = $row['encuestas'];
			}
		}
		$array['anio'] = $input['anio'];
		//
		if (count($data)==0) {
			$result['msg']['content']= getMensajeGestion('noRegistros');
		} else {
			$result['data'] = $this->load->view("modulos/gestionGerencial/ipp/resumen_nuevo", $array, true);
		}
		//
		echo json_encode($result);
	}
	
	public function detallado_nuevo(){
		//
		

    	$data = json_decode($this->input->post('data'));
    	$fechas=explode(" - ",$data->{'txt-fechas'});
    	//
    	$input = array(
			  'anio' => $data->{'sl-anio'}
			, 'mes' => $data->{'sl-mes'}
			, 'fecIni' => $fechas[0]
			, 'fecFin' => $fechas[1]
			, 'sl-cuenta' => $this->sessIdCuenta
    		, 'sl-proyecto' => $this->sessIdProyecto
    		, 'sl-grupoCanal' => $data->{'grupoCanal_filtro'}
    		, 'sl-canal' => $data->{'canal_filtro'}
			, 'subCanal' => $data->{'subcanal_filtro'}
    		, 'sl-tienda' => !empty($data->{'sl-tienda'}) ? $data->{'sl-tienda'} : ''
    		, 'sl-departamento' => $data->{'sl-departamento'}
    		, 'sl-provincia' => $data->{'sl-provincia'}
    		, 'sl-distrito' => $data->{'sl-distrito'}
    		, 'sl-cadena' => !empty($data->{'cadena_filtro'}) ? $data->{'cadena_filtro'} : ''
    		, 'sl-banner' => !empty($data->{'banner_filtro'}) ? $data->{'banner_filtro'} : ''
    		, 'sl-hfs' => $data->{'sl-hfs'}
			, 'sl-whls' => $data->{'sl-whls'}
			, 'idUsuarioEnc' => $data->{'sl-encargado'}
		);
		//
    	$result=array();
		$result['result']=0;
		$result['url']='';
		$result['data']='';
		$result['msg']['title']='Alerta';
		$result['msg']['content']='';	
		//
		$data = array();

		if(!empty($input['anio']) && !empty($input['mes'])){
			
			$result['result']=1;
			$array = array();
			//
			$data = $this->model->obtener_data()->result_array();
			$array['banner'] = $this->model->obtener_banner($input)->result_array();

			if ( count($data)>0 ) {
				$array['puntaje_maximo'] = 0;
				foreach ($data as $key => $row) {
					if($row['puntaje'] > 0){
						$array['criterios'][$row['idCriterio']] = $row;
						$array['preguntas'][$row['idCriterio']][$row['idPregunta']] = $row;
						$array['puntaje_maximo'] = 6;
					}
				}
			}
			//
			$data_puntajes = $this->model->obtener_data_semanal($input)->result_array();
			$data_encuestas = $this->model->obtener_encuestas_semanal($input)->result_array();
			//
			$unq_ix = 0;
			$puntajes = array();
			foreach ($data_puntajes as $key => $row) {
				$array['puntajes'][$row['idBanner']][$row['semana']][$row['idCriterio']][$row['idPregunta']]['puntaje'] = $row['promPuntajePregunta'];
				$array['totalCriterio'][$row['idBanner']][$row['semana']][$row['idCriterio']]['totalCriterio'] = $row['totalCriterio'];
				$array['totalGeneral'][$row['idBanner']][$row['semana']]['totalGeneral'] = $row['totalGeneral'];
				$array['totalGeneral'][$row['idBanner']][$row['semana']]['objetivo'] = $row['objetivo'];
				//$array['totalGeneral'][$row['anio']][$row['mes']][$row['idBanner']]['encuestas'] = $row['encuestas'];
			}
			
			foreach ($data_encuestas as $key => $row) {
				$array['totalGeneral'][$row['idBanner']][$row['semana']]['encuestas'] = $row['encuestas'];
			}
		}
		//
		if (count($data)==0) {
			$result['msg']['content']= getMensajeGestion('noRegistros');
		} else {
			$result['data'] = $this->load->view("modulos/gestionGerencial/ipp/detallado_nuevo", $array, true);
		}
		//
		echo json_encode($result);
	}
}

?>