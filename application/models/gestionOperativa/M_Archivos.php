<?php

use function Complex\rho;

defined('BASEPATH') or exit('No direct script access allowed');

class M_Archivos extends MY_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'archivos' => ['tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo", 'id' => 'idArchivo'],
		];
	}

	public function getArchivos($post)
	{
		$idCuenta = $this->sessIdCuenta;
		$filtros = " AND pc.idUsuario = " . $post['idUsuario'];
		if (empty($post['flagGestorDeArchivos'])) $filtros .= " AND a.idUsuarioCreador = " . $post['idUsuario'];
		!empty($idCuenta) ? $filtros .= " AND g.idCuenta = {$idCuenta}": '';

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
			FROM {$this->sessBDCuenta}.trade.gestorArchivos_archivo a
				JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON a.idCarpeta = c.idCarpeta
				JOIN {$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta pc ON pc.idCarpeta = c.idCarpeta
				JOIN {$this->sessBDCuenta}.trade.gestorArchivos_grupo g ON c.idGrupo = g.idGrupo
				JOIN trade.usuario u ON a.idUsuarioCreador = u.idUsuario
				JOIN {$this->sessBDCuenta}.trade.gestorArchivos_tipoArchivo ta ON a.idTipoArchivo = ta.idTipoArchivo
				LEFT JOIN trade.usuario u2 ON a.idUsuarioEditor = u2.idUsuario
			WHERE pc.estado = 1
				AND a.eliminado = 0
				AND c.estado = 1
				{$filtros}
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo" ];
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
					FROM {$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta pc
						JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON pc.idCarpeta = c.idCarpeta
						JOIN {$this->sessBDCuenta}.trade.gestorArchivos_grupo g ON g.idGrupo = c.idGrupo
						LEFT JOIN {$this->sessBDCuenta}.trade.gestorArchivos_archivo a ON c.idCarpeta = a.idCarpeta)
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
		$filtros = "";
		$idUsuario = $post['idUsuario'];
		
		$idCuenta = $this->sessIdCuenta;
		!empty($idCuenta) ? $filtros .= " AND g.idCuenta = {$idCuenta}": '';

		$sql = "
			SELECT g.idGrupo, 
				g.nombre nombreGrupo, 
				c.idCarpeta, 
				c.nombre nombreCarpeta
			FROM {$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta pc
				JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON c.idCarpeta = pc.idCarpeta AND pc.estado = 1
				JOIN {$this->sessBDCuenta}.trade.gestorArchivos_grupo g ON g.idGrupo = c.idGrupo
			WHERE pc.idUsuario = $idUsuario {$filtros}
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta" ];
		return $this->db->query($sql);
	}

	public function getTiposDeArchivos()
	{
		$sql = "
			SELECT *
			FROM {$this->sessBDCuenta}.trade.gestorArchivos_tipoArchivo
			WHERE estado = 1;
		";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_tipoArchivo" ];
		return $this->db->query($sql);
	}

	public function getLastIdArchivo()
	{
		$sql = "
            SELECT
                TOP 1 idArchivo
            FROM {$this->sessBDCuenta}.trade.gestorArchivos_archivo
            ORDER BY
                idArchivo DESC;
        ";
		$lastIdArchivo = $this->db->query($sql);

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo" ];
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
            {$this->sessBDCuenta}.trade.gestorArchivos_extension
        WHERE extension = '" . $extension . "';
                ";

		$idTipoArchivo = $this->db->query($sql);

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_extension" ];
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
        FROM {$this->sessBDCuenta}.trade.gestorArchivos_grupo g
        LEFT JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON g.idGrupo = c.idGrupo
        LEFT JOIN {$this->sessBDCuenta}.trade.gestorArchivos_archivo a ON a.idCarpeta = c.idCarpeta
        WHERE
        g.idGrupo = $idGrupo
        ";

		$espacioGrupo = $this->db->query($sql);
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_grupo" ];
		return $espacioGrupo;
	}

	public function getArchivo($idArchivo)
	{
		$sql = "
        SELECT *
        FROM {$this->sessBDCuenta}.trade.gestorArchivos_archivo WHERE idArchivo = $idArchivo
        ";

		$archivo = $this->db->query($sql);
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.gestorArchivos_archivo" ];
		return $archivo;
	}

	public function agregarEstadoEliminado($idArchivo)
	{
		$aSessTrack = [];
		$this->db->trans_begin();

		$tabla = "{$this->sessBDCuenta}.trade.gestorArchivos_archivo";
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

	public function getCarpetas($params = []){
		$filtros = "WHERE 1 = 1";
		$idCuenta = $this->sessIdCuenta;
        if (isset($params['idGrupo']) and !empty($params['idGrupo'])) $filtros .= "AND g.idGrupo = " . $params['idGrupo'];
		!empty($idCuenta) ?  $filtros.= " AND g.idCuenta = {$idCuenta}": '';
		if (!empty($post['id'])) $filtros .= " AND c.idCarpeta = " . $post['id'];

        $sql = "
		SELECT DISTINCT g.orden, c.idCarpeta, c.idGrupo, c.nombre nombreCategoria, c.estado, c.fechaCreacion, c.fechaModificacion, g.nombre nombreGrupo, SUM(a.peso) OVER (PARTITION BY c.idCarpeta) espacioOcupado
		FROM {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c
        JOIN {$this->sessBDCuenta}.trade.gestorArchivos_grupo g ON c.idGrupo = g.idGrupo
        LEFT JOIN {$this->sessBDCuenta}.trade.gestorArchivos_archivo a ON c.idCarpeta = a.idCarpeta
        $filtros
		ORDER by c.estado DESC , c.nombre;
		";

        $categoriasGrupos = $this->db->query($sql);

        return $categoriasGrupos;
	}

	public function getGrupos($params = [])
	{
		$filtros = "WHERE g.estado = 1";
		$idCuenta = $this->sessIdCuenta;

		!empty($idCuenta) ?  $filtros.= " AND g.idCuenta = {$idCuenta}": '';
 		
		$sql = "
		SELECT 
		g.idGrupo
		,g.idCuenta
		,g.nombre nombreGrupo
		,g.espacioConcedido
		,g.estado
		FROM 
		{$this->sessBDCuenta}.trade.gestorArchivos_grupo g
		{$filtros}
		";

		return $this->db->query($sql);
	}
	public function checkCarpetaGrupoRepetida($params = [])
	{	
		$where = [
			'idGrupo' => $params['grupo'],
			'nombre' => $params['nombre']
		];
		if(!empty($params['idx'])) $this->db->where_not_in('idCarpeta',$params['idx']);
		$carpetas = $this->db->get_where("{$this->sessBDCuenta}.trade.gestorArchivos_carpeta",$where)->result_array();


		if(!empty($carpetas)){
			return true;
		}
		return false;
	}
	public function registrarCarpetas($post)
	{
		$idUsuarioCreador = $this->idUsuario;
        $ip = $this->ip = $_SERVER['REMOTE_ADDR'];

		$insert = [
            'nombre' => trim($post['nombre']),
			'idGrupo' => $post['grupo'],
			"fechaCreacion" => getActualDateTime(),
            "idUsuarioCreador" => $idUsuarioCreador,
            "ipUsuarioCreador" => $ip,
            "estado" => 1,
        ];

		$insert = $this->db->insert("{$this->sessBDCuenta}.trade.gestorArchivos_carpeta", $insert);
		$this->insertId = $this->db->insert_id();
		return $insert;
    }
	public function actualizarCarpetas($post)
	{

		$update = [
			'nombre' => trim($post['nombre']),
			'idGrupo' => $post['grupo'],
        ];
        
		$where = [
			'idCarpeta' => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update("{$this->sessBDCuenta}.trade.gestorArchivos_carpeta", $update);
		return $update;
    }
	public function getUsuarios($params = array())
    {
        $filtros = " WHERE 1 = 1 ";
        $tipoUsuario = $this->session->userdata('idTipoUsuario');
		$idCuenta = $this->sessIdCuenta;
        if(($tipoUsuario == '4')){
            $filtros .= " AND u.estado = 1";
        }else{
            $filtros .= "  AND u.demo = 0 AND p.idCuenta = {$idCuenta} AND u.estado = 1";

        }
        
        if (isset($params['idUsuarioTipo']) and !empty($params['idUsuarioTipo'])) $filtros .= "AND ut.idTipoUsuario = " . $params['idUsuarioTipo'];

        $sql = "
        DECLARE @fecha DATE = GETDATE();
        SELECT DISTINCT
          u.idUsuario,
          u.numDocumento nroDocumento,
          u.nombres,
          u.apeMaterno,
          u.apePaterno,
          u.email,
          ut.idTipoUsuario idUsuarioTipo,
          ut.nombre tipo,
		  u.estado
        FROM trade.usuario u
        JOIN trade.usuario_historico uh ON uh.idUsuario = u.idUsuario
		  AND General.dbo.fn_fechaVigente(Uh.fecIni,uh.fecFin,GETDATE(),GETDATE()) = 1
          AND uh.idAplicacion = 2
        LEFT JOIN trade.usuario_tipo ut ON uh.idTipoUsuario = ut.idTipoUsuario
        LEFT JOIN trade.proyecto p ON uh.idProyecto = p.idProyecto 
        $filtros
		";

        $usuarios = $this->db->query($sql);


        return $usuarios;
    }
	public function getPermisosDeUnUsuario($idUsuario)
    {
        $sql = "
		SELECT *
		FROM {$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta pc
			JOIN {$this->sessBDCuenta}.trade.gestorArchivos_carpeta c ON pc.idCarpeta = c.idCarpeta
		WHERE idUsuario = $idUsuario AND pc.estado = 1
		";

        $permisosDeUnUsuario = $this->db->query($sql);

        // echo $this->db->last_query(); exit();

        return $permisosDeUnUsuario;
    }

	public function guardarPermisos($permisosAgregados = array(), $permisosRemovidos = array())
    {
        $this->db->trans_begin();

        //Guardado manualmente porque el update_batch no tiene para multiples where.
        if (count($permisosRemovidos) > 0) {
            foreach ($permisosRemovidos as $permiso) {
                $this->db->set('idUsuarioEditor', $permiso['idUsuarioEditor']);
                $this->db->set('ipUsuarioEditor', $permiso['ipUsuarioEditor']);
                $this->db->set('fechaModificacion', $permiso['fechaModificacion']);
                $this->db->set('estado', '0');
                $this->db->where('idUsuario', $permiso['idUsuario']);
                $this->db->where('idCarpeta', $permiso['idCarpeta']);
                $this->db->where('estado', '1');
                $updateResult = $this->db->update("{$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta");

                if ($this->db->trans_status() === false || !$updateResult) {
                    $this->db->trans_rollback();
                    return 0;
                }
            }
        }

        $insertDatos = true;
        if (count($permisosAgregados) > 0) {
            $insertDatos = $this->db->insert_batch("{$this->sessBDCuenta}.trade.gestorArchivos_permisoCarpeta", $permisosAgregados);
        }

        if ($this->db->trans_status() === false || !$insertDatos) {
            $this->db->trans_rollback();
            return 0;
        }

        $this->db->trans_commit();
        return 1;
    }
}
