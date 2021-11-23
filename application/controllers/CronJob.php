<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronJob extends MY_Controller{

	public function __construct(){
		parent::__construct();
        $this->load->model('M_cronjob', 'model');
    }

    function pg_ejecucion_total_hfs()
    {
        $fecha=date("d/m/Y");
        $distribuidoras=$this->model->get_distribuidoras_sucursal()->result_array();
        $contactos=$this->model->get_contactos_pg(['tradicional'=>true])->result_array();
        $visitas=$this->model->get_visitas_pg(['idGrupoCanal'=>4])->result_array();
        $resultados=$this->model->get_resultados_pg(['idGrupoCanal'=>4])->result_array();
        
        $email=array();
		$array=array();
		foreach($distribuidoras as $k_d=>$v_d){
			unset($email); unset($array);
			foreach($contactos as $k_c=>$v_c){
				if($v_d['id']==$v_c['idDistribuidoraSucursal']){
					$email[]=$v_c['email'];
				}
			}

			foreach($visitas as $k_v=>$v_v){
				if($v_d['id']==$v_v['idDistribuidoraSucursal']){
					$array['data'][]=$v_v;
				}
			}
			foreach($resultados as $v_r){
				if($v_d['id']==$v_r['idDistribuidoraSucursal']){
					$array['resultados'][$v_r['idVisita']]['porcentajeEO']=$v_r['porcentajeEO'];
					$array['resultados'][$v_r['idVisita']]['porcentajeINI']=$v_r['porcentajeINI'];
					$array['resultados'][$v_r['idVisita']]['porcentajeEA']=$v_r['porcentajeEA'];
					$array['resultados'][$v_r['idVisita']]['porcentajePM']=$v_r['porcentajePM'];
				}
			}

			if(!empty($array['data']) && isset($email) ){
				$contenido=$this->load->view('cronjob/ejecucion_total/hfs_correo',$array,true);
				// $correo['to']=implode(",",$email);
				$correo['to']='aaron.ccenta@visualimpact.com.pe';
				// $correo['cc']='team.sistemas@visualimpact.com.pe,cristihan.rivera@visualimpact.com.pe, ingrid.peralta@visualimpact.com.pe, walter.becerra@visualimpact.com.pe, proyectos.hfs@visualimpact.com.pe';
				$titulo='PG - Ejecucion Total HFS '.$v_d['nombre'].' '.$fecha;
				email(['to'=>$correo,'asunto'=>$titulo,'contenido'=>$contenido]);
			}
		}

    }
}
?>