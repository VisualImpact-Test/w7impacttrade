<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Archivos extends MY_Model
{
	var $aSessTrack = [];
	
	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'archivos' => ['tabla' => 'trade.gestorArchivos_archivo', 'id' => 'idArchivo'],
		];
	}

	public function getArchivos($post)
	{
		$filtros = " AND pc.idUsuario = " . $post['idUsuario'];
		if (empty($post['flagGestorDeArchivos'])) $filtros .= " AND a.idUsuarioCreador = " . $post['idUsuario'];

		$sql = "
			SELECT DISTINCT 
				a.idArchivo, 
				a.nombre nombreRegistrado, 
				a.nombreArchivo, 
				a.peso, 
				a.extension, 
				ta.nombre tipoArchivo, 
				a.fechaCreacion, 
				a.fechaModificacion, 
				a.eliminado, 
				a.estado, 
				u.idUsuario idUsuarioCreador, 
				c.idCarpeta, 
				c.nombre nombreCarpeta, 
				g.idGrupo, 
				g.nombre nombreGrupo, 
				u.nombres + ' ' + u.apePaterno + ' ' + u.apeMaterno nombreUsuarioCreador, 
				u2.idUsuario idUsuarioEditor, 
				u2.nombres + ' ' + u2.apePaterno + ' ' + u2.apeMaterno nombreUsuarioEditor
			FROM trade.gestorArchivos_archivo a
				JOIN trade.gestorArchivos_carpeta c ON a.idCarpeta = c.idCarpeta
				JOIN trade.gestorArchivos_permisoCarpeta pc ON pc.idCarpeta = c.idCarpeta
				JOIN trade.gestorArchivos_grupo g ON c.idGrupo = g.idGrupo
				JOIN trade.usuario u ON a.idUsuarioCreador = u.idUsuario
				JOIN trade.gestorArchivos_tipoArchivo ta ON a.idTipoArchivo = ta.idTipoArchivo
				LEFT JOIN trade.usuario u2 ON a.idUsuarioEditor = u2.idUsuario
			WHERE pc.estado = 1
				AND a.eliminado = 0
				AND c.estado = 1
				$filtros
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.gestorArchivos_archivo' ];
		return $this->db->query($sql);
	}

	public function getInformacionParasubirArchivo($post)
	{
		$sql = "
			WITH lista
				AS (SELECT pc.idUsuario, 
							pc.estado, 
							g.idGrupo, 
							g.nombre nombreGrupo, 
							c.idCarpeta, 
							c.nombre nombreCarpeta, 
							SUM(CASE
									WHEN a.eliminado = 0
									THEN a.peso
									ELSE 0
								END) OVER(PARTITION BY g.idGrupo) espacioOcupado, 
							g.espacioConcedido, 
							g.espacioConcedido - SUM(CASE
														WHEN a.eliminado = 0
														THEN a.peso
														ELSE 0
													END) OVER(PARTITION BY g.idGrupo) espacioRestante, 
							a.eliminado
					FROM trade.gestorArchivos_permisoCarpeta pc
						JOIN trade.gestorArchivos_carpeta c ON pc.idCarpeta = c.idCarpeta
						JOIN trade.gestorArchivos_grupo g ON g.idGrupo = c.idGrupo
						LEFT JOIN trade.gestorArchivos_archivo a ON c.idCarpeta = a.idCarpeta)
				SELECT idUsuario, 
						idGrupo, 
						nombreGrupo, 
						idCarpeta, 
						nombreCarpeta, 
						espacioOcupado, 
						espacioConcedido, 
						espacioRestante
				FROM lista
				WHERE estado = 1
					AND idUsuario = 1;
		";
	}

	public function getGruposCarpetasDeUsuario($post)
	{
		$idUsuario = $post['idUsuario'];

		$sql = "
			SELECT g.idGrupo, 
				g.nombre nombreGrupo, 
				c.idCarpeta, 
				c.nombre nombreCarpeta
			FROM trade.gestorArchivos_permisoCarpeta pc
				INNER JOIN trade.gestorArchivos_carpeta c ON c.idCarpeta = pc.idCarpeta
				INNER JOIN trade.gestorArchivos_grupo g ON g.idGrupo = c.idGrupo
			WHERE pc.idUsuario = $idUsuario
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.gestorArchivos_permisoCarpeta' ];
		return $this->db->query($sql);
	}

	public function getTiposDeArchivos()
	{
		$sql = "
			SELECT *
			FROM trade.gestorArchivos_tipoArchivo
			WHERE estado = 1;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.gestorArchivos_tipoArchivo' ];
		return $this->db->query($sql);
	}

	public function getLastIdArchivo()
	{
		$sql = "
            SELECT
                TOP 1 idArchivo
            FROM trade.gestorArchivos_archivo
            ORDER BY
                idArchivo DESC;
        ";
		$lastIdArchivo = $this->db->query($sql);

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.gestorArchivos_archivo' ];
		return $lastIdArchivo;
	}

	public function guardar($table, $input)
	{
		$aSessTrack = [];

		$this->db->trans_begin();

			$this->db->set($input);		
			$insert = $this->db->insert($table, $input);
			$id = $this->db->insert_id();

			$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}
		$db_error = $this->db->error();

		if (empty($db_error) || $db_error['code'] == 0) {
			return $insert;
		} else {
			return false;
		}
	}

	public function getTipoArchivo($extension)
	{

		$sql = "
        SELECT
            idTipoArchivo
        FROM
            trade.gestorArchivos_extension
        WHERE extension = '" . $extension . "';
                ";

		$idTipoArchivo = $this->db->query($sql);

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.gestorArchivos_extension' ];
		return $idTipoArchivo;
	}

	public function duplicado($table, $filtros)
	{
		$duplicado = false;
		$sql = "SELECT * FROM " . $table . " WHERE 1 =  1" . $filtros;
		$rs = $this->db->query($sql)->result();
		if (count($rs) > 0) {
			$duplicado = true;
		}
		return $duplicado;
	}

	public function getEspacioGrupo($idGrupo)
	{
		$sql = "
        SELECT
        DISTINCT g.espacioConcedido,
        g.espacioConcedido - SUM(
          CASE
            WHEN a.eliminado = 0 THEN a.peso
            ELSE 0
          END
        ) OVER(PARTITION BY g.idGrupo) espacioRestante
        FROM trade.gestorArchivos_grupo g
        LEFT JOIN trade.gestorArchivos_carpeta c ON g.idGrupo = c.idGrupo
        LEFT JOIN trade.gestorArchivos_archivo a ON a.idCarpeta = c.idCarpeta
        WHERE
        g.idGrupo = $idGrupo
        ";

		$espacioGrupo = $this->db->query($sql);
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.gestorArchivos_grupo' ];
		return $espacioGrupo;
	}

	public function getArchivo($idArchivo)
	{
		$sql = "
        SELECT *
        FROM trade.gestorArchivos_archivo WHERE idArchivo = $idArchivo
        ";

		$archivo = $this->db->query($sql);
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.gestorArchivos_archivo' ];
		return $archivo;
	}

	public function agregarEstadoEliminado($idArchivo)
	{
		$aSessTrack = [];

		$this->db->trans_begin();

			$tabla = "trade.gestorArchivos_archivo";
			$columna = "idArchivo";

			$data = array(
				'eliminado' => 1,
				'estado' => 0
			);

			$this->db->where($columna, $idArchivo);
			$eliminado = $this->db->update($tabla, $data);

			$aSessTrack = [ 'idAccion' => 7, 'tabla' => $tabla, 'id' => $idArchivo ];

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->aSessTrack[] = $aSessTrack;
		}

		return $eliminado;
	}

}
