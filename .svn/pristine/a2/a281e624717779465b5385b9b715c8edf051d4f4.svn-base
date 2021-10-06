<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bi extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function obtener_data_token($token){
		$sql = "
				SELECT
					  r.reporte
					, r.urlReporte
					, r.idReporte
				FROM 
					BI.token_reportes tr
					JOIN BI.token t
						ON t.idToken = tr.idToken
					JOIN Bi.reportes r
						ON r.idReporte = tr.idReporte
				WHERE
					tr.estado=1
					AND r.estado=1
					AND t.estado=1
					AND t.token='".$token."'
			";
		return $this->db->query($sql)->result_array();
	}
}
