<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_adt_pdf extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getCompetenciaAuditoria($idAuditoria){
		$sql = "SELECT 
		m.* 
		FROM trade.live_auditoriaComp auComp
		JOIN dbo.marca m 
		ON m.idMarca = auComp.idMarca
		WHERE auComp.idAuditoria = $idAuditoria";

		return $this->db->query($sql);
		
	}
    public function getIdLastAuditoria($idTienda){
        $sql = "SELECT 
		TOP 1 *
		FROM  trade.live_auditoria au
        WHERE idCliente = $idTienda
        ORDER BY au.fecha desc, horaReg desc";
    	return $this->db->query($sql);
    }
    public function getIdTienda($idAuditoria){
        $sql = "SELECT TOP 1 
        * 
        FROM trade.live_auditoria
        WHERE idAuditoria = $idAuditoria
        ";
	    return $this->db->query($sql);

    }
	public function getInfoAuditoria($idAuditoria){
		$sql =
		"SELECT 
		evald.idEvaluacionDet idEvald,
		pcat.idCategoria idCat,
		eval.idEvaluacion catEval,
		pcat.nombre categoria,
		eval.nombre evaluacion_categoria, 
		evald.nombre evaluacion_nombre,
		aue.nota nota_eval,
		aue.estrellas,
		aue.comentario,
		au.nota nota_final
		FROM trade.live_tipoEvaluacion eval
		JOIN trade.live_tipoEvaluacionDet evald
		ON evald.idEvaluacion = eval.idEvaluacion
		JOIN trade.live_auditoriaEval aue
		ON aue.idEvaluacionDet = evald.idEvaluacionDet
		JOIN  trade.live_auditoriaCat auc
		ON auc.idAuditoriaCat = aue.idAuditoriaCat
		JOIN trade.producto_categoria pcat
		ON pcat.idCategoria = auc.idCategoria
		JOIN trade.live_auditoria au 
		ON au.idAuditoria = auc.idAuditoria
		WHERE auc.idAuditoria = $idAuditoria
		;";
	return $this->db->query($sql);

	}

	public function getCategoriaAuditoria(){
		$sql = "SELECT * FROM trade.producto_categoria";
		return $this->db->query($sql);
	}

	public function getFotoEval($idAuditoria,$idCategoria,$idEvaluacion){
		$sql = "SELECT * FROM trade.live_auditoriaFoto
		WHERE idAuditoria = '".$idAuditoria."' AND idCategoria = '".$idCategoria."' AND idEvaluacion ='". $idEvaluacion."' AND estado=1;";
		return $this->db->query($sql);
	}
	public function getTipoEvaluacion($idCuenta = ''){
		$filtro = "";
			$filtro .= !empty($idCuenta) ? " AND idCuenta = {$idCuenta}" : "";
		$sql = "SELECT * FROM trade.live_tipoEvaluacion WHERE 1 = 1{$filtro}";
		return $this->db->query($sql);
	}
	public function getCategoriaByAuditoria($idAuditoria){
		$sql = "SELECT * FROM trade.producto_categoria pcat
		JOIN trade.live_auditoriaCat auc
		ON pcat.idCategoria = auc.idCategoria
		WHERE idAuditoria = $idAuditoria
		;";
		return $this->db->query($sql);
	}

	public function getInfoVisita($idTienda,$idAuditoria){
		$sql = "SELECT * FROM trade.cliente t 
		JOIN trade.live_auditoria au
		ON t.idCliente = au.idCliente
		WHERE t.idCliente=$idTienda AND au.idAuditoria = $idAuditoria;";
		return $this->db->query($sql);

    }

	public function getCuentaCliente($idAuditoria){
		$sql = "
SELECT
	ctg.idCuenta
FROM trade.live_auditoria aud
JOIN trade.live_listCategoria ctg ON aud.idListCategoria = ctg.idListCategoria
WHERE aud.idAuditoria = {$idAuditoria}
";
		return $this->db->query($sql)->row()->idCuenta;

    }

	public function getInfoTienda($idTienda){
		$sql = "SELECT 
        tpi.idInfo,
        ti.valor valor,
        tpi.nombre nombre_info 
        
        FROM trade.live_clienteInfo ti
        JOIN trade.live_tipoInfo tpi
        ON ti.idInfo = tpi.idInfo
        WHERE idCliente = $idTienda;";
		return $this->db->query($sql);

    }
    
    public function getInfoLastVisita($idTienda,$idAuditoria){
        $sql = "WITH T1 AS(
            SELECT	ROW_NUMBER() OVER (ORDER BY au.fecha desc,au.horaReg desc) orden , au.* FROM trade.cliente t 
                    JOIN trade.live_auditoria au
                    ON t.idCliente = au.idCliente
                    WHERE t.idCliente=$idTienda AND au.idAuditoria <=$idAuditoria
            )
            SELECT *
            FROM T1
            WHERE Orden = 2";
		return $this->db->query($sql);

    }

}
?>