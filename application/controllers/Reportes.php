<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends MY_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function load($link){
		$config = array();
		$indice = explode("1n",$link);
		$config['nav']['menu_active']= $indice[1] ;
		$config['css']['style']=array();
		$config['js']['script'] = array();
		
		$array_report =  array(
			99 =>'eyJrIjoiNDE0MDAxYTAtMjk5Yy00NmRjLWE4YTktZTM0NmE0ZDg3MmExIiwidCI6IjJhNDU5MjEwLTczMzMtNDhlNC1iNzIzLTZhMjVmMmMyOTdjZCIsImMiOjR9'//"eyJrIjoiMDMxMDI2MzYtYWU1My00ZjJkLThlNjUtNjEzOTA3NDI3ZjdlIiwidCI6IjJhNDU5MjEwLTczMzMtNDhlNC1iNzIzLTZhMjVmMmMyOTdjZCIsImMiOjR9"
			, 100 => 'eyJrIjoiYWUwOTRhODQtY2E0MC00ZmI4LTlhY2EtMzMzMWI1OThjNmM2IiwidCI6IjJhNDU5MjEwLTczMzMtNDhlNC1iNzIzLTZhMjVmMmMyOTdjZCIsImMiOjR9'
			, 103 => 'eyJrIjoiOGQ1MTM0YmMtYTI1Ny00N2ZmLWEzYjYtYTY5NDQ3NjNmMGNiIiwidCI6IjJhNDU5MjEwLTczMzMtNDhlNC1iNzIzLTZhMjVmMmMyOTdjZCIsImMiOjR9'
		);
		
		$config['data']['report'] = $array_report[intval($indice[1])];
		$config['noTitle'] = true;
		$config['view']='modulos/powerbi/index';
		
		$this->view($config);
	}

}
?>