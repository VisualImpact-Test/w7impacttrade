<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_liveStorecheckEnc extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function consultar($input){
		$filtro = "";
			$filtro .= !empty($input['idCuenta']) ? " AND cu.idCuenta = {$input['idCuenta']}" : "";
		$sql = "
			SELECT
				cu.idCuenta,
				cu.nombre AS cuenta,
				enc.idEncuesta,
				enc.nombre,
				(
					SELECT COUNT(1)
					FROM lsck.tipoEncuestaPreg
					WHERE idEncuesta = enc.idEncuesta
				) AS numPreg,
				enc.estado
			FROM lsck.tipoEncuesta enc
			JOIN trade.cuenta cu ON enc.idCuenta = cu.idCuenta
			WHERE 1 = 1{$filtro}
			ORDER BY enc.fechaReg DESC, enc.horaReg DESC
			";
		return $this->db->query($sql)->result_array();
	}

	public function estado($input = array()){
		$status = false;
			$this->db->trans_begin();

				foreach($input['idEncuesta'] as $idEncuesta){
					$uEncuesta = array('estado' => $input['estado']);
					$wEncuesta = array('idEncuesta' => $idEncuesta);
					$this->db->update('lsck.tipoEncuesta', $uEncuesta, $wEncuesta);
				}

			if( !$this->db->trans_status() ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$status = true;
			}

		return $status;
	}

	public function listTipo($input = array()){
		$sql = "
SELECT
	enpt.idTipoPregunta AS id,
	enpt.nombre
FROM master.tipoPregunta enpt
WHERE enpt.estado = 1
ORDER BY nombre
";
		return $this->db->query($sql)->result_array();
	}

	public function listEncuesta($input = array()){
		$sql = "
	SELECT
		en.idEncuesta,
		en.nombre AS encuesta,
		enp.idPregunta,
		enp.nombre AS pregunta,
		enpt.idTipoPregunta AS idTipo,
		enpt.nombre AS tipo,
		enpa.idAlternativa,
		enpa.nombre AS alternativa,
		enp.idExtAudTipo,
		aut.nombre tipoAuditoria
	FROM lsck.tipoEncuesta en
	JOIN lsck.tipoEncuestaPreg enp ON en.idEncuesta = enp.idEncuesta
	JOIN master.tipoPregunta enpt ON enp.idTipoPregunta = enpt.idTipoPregunta
	LEFT JOIN lsck.tipoEncuestaPregAlt enpa ON enp.idPregunta = enpa.idPregunta
	LEFT JOIN lsck.ext_auditoriaTipo aut ON aut.idExtAudTipo = enp.idExtAudTipo
WHERE en.idEncuesta = {$input['idEncuesta']}
";
		return $this->db->query($sql)->result_array();
	}

	public function guardar($input = array()){
		$return['status'] = false;
		$return['msg'] = '';

			$error = false;
			$this->db->trans_begin();

				$iEncuesta = array(
						'idCuenta' => $input['idCuenta'],
						'nombre' => trim($input['encuesta']),
						'idUsuarioReg' => $this->idUsuario
					);
				$this->db->insert('lsck.tipoEncuesta', $iEncuesta);
				$idEncuesta = $this->db->insert_id();

				if( !is_array($input["aPregunta"]) ){
					$input["aPregunta"] = array($input["aPregunta"]);
				}

				foreach($input["aPregunta"] as $num){
					$iPregunta = array(
							'idEncuesta' => $idEncuesta,
							'idTipoPregunta' => $input["tipo[{$num}]"],
							'nombre' => $input["pregunta[{$num}]"],
					);
					!empty($input["tipoAuditoria[{$num}]"]) ? $iPregunta['idExtAudTipo'] = $input["tipoAuditoria[{$num}]"] : '';
					!empty($input["presencia[{$num}]"]) &&  $input["presencia[{$num}]"] == "SI" ?  $iPregunta['extAudPresencia'] = 1: $iPregunta['extAudPresencia'] =  0;
					!empty($input["checkDetalle[{$num}]"] )  &&  $input["checkDetalle[{$num}]"] == "on"? $iPregunta['extAudDetalle'] = 1 : $iPregunta['extAudDetalle'] = 0;
					
					$this->db->insert('lsck.tipoEncuestaPreg', $iPregunta);
					$idPregunta = $this->db->insert_id();

					if(empty($input["tipoAuditoria[{$num}]"])){
						if( in_array($input["tipo[{$num}]"], array(2,3)) &&
						empty($input["alternativa[{$num}]"])
						
						){
							$error = true;
							$return['msg'] = 'Se identificó una pregunta(cerrada o múltiple) <b>sin alternativas</b>';
							break;
						}
					}

					if( !empty($input["alternativa[{$num}]"]) ){
						if( !is_array($input["alternativa[{$num}]"]) ){
							$input["alternativa[{$num}]"] = array($input["alternativa[{$num}]"]);
						}

						foreach($input["alternativa[{$num}]"] as $alt){
							$iAlternativa = array(
									'idPregunta' => $idPregunta,
									'nombre' => $alt,
								);
							$this->db->insert('lsck.tipoEncuestaPregAlt', $iAlternativa);
						}
					}
				}

			if( !$this->db->trans_status() || $error ){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
				$return['status'] = true;
			}

		return $return;
	}

}