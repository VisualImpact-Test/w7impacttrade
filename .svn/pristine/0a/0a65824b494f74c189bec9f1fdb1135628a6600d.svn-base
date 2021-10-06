<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_bi', 'model');
	}
	
	public function index(){
		session_destroy();
		$this->load->view('modulos/BI/global/head');
		$this->load->view("modulos/BI/index");
		$this->load->view('modulos/BI/global/footer');
				
	}
	
	public function validarToken(){
		$token = $this->input->post('token');
		if(!empty($token)){
			$res = $this->model->obtener_data_token($token);
			if(count($res)>0){
				$result['result']=1;
				$this->session->set_userdata('token', $token);
				//redirect('BI/reportes');
			}else{
				$result['result']=2;
				$result['html'] ='<div style="margin-left:20px;color:white;font-weight:bold;border:1px solid;padding:15px;background:red;">EL TOKEN INGRESADO NO TIENE DATA PARA MOSTRAR.</div>';
			}
		}else{
			$result['result']=3;
			$result['html'] ='<div style="margin-left:20px;color:white;font-weight:bold;border:1px solid;padding:15px;background:red;">INGRESE UN TOKEN.</div>';
			session_destroy();
		}
		echo json_encode($result);
	}
	
	public function reportes(){
		$token = $this->session->userdata('token');
		if(empty($token)){
			redirect('bi','refresh');
		}else{
			$res = $this->model->obtener_data_token($token);
			$array['data'] = $res;
			$this->load->view('modulos/BI/global/head');
			$this->load->view('modulos/BI/reportes',$array);
			$this->load->view('modulos/BI/global/footer');
		}
	}

}	
?>