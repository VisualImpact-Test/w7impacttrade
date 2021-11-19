<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Aplicaciones extends My_Model
{

    var $CI;
    var $aSessTrack = [];

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

    public function getAplicaciones($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND app.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND app.idAplicacion = " . $post['id'];
        }

        $sql = "
				SELECT
                app.idAplicacion
                , app.nombre AS aplicacion
                , app.estado
                , app.flagAndroid
                , c.idCuenta
                , c.nombre AS cuenta
				FROM trade.aplicacion app
                LEFT JOIN trade.cuenta c ON app.idCuenta = c.idCuenta
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cuenta'];
        return $this->db->query($sql);
    }

    public function registrarAplicaciones($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'idCuenta' => $post['form_idCuenta'],
            'flagAndroid' => empty($post['flagAndroid']) ? 0 : 1
        ];

        $insert = $this->db->insert('trade.aplicacion', $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarAplicaciones($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'idCuenta' => trim($post['form_idCuenta']),
            'flagAndroid' => empty($post['flagAndroid']) ? 0 : 1,
            'fechaModificacion' => getActualDateTime()
        ];

        $where = [
            'idAplicacion' => $post['idAplicacion']
        ];

        $this->db->where($where);
        $update = $this->db->update('trade.aplicacion', $update);
        return $update;
    }

    public function checkAplicacionesRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "'";
        if (!empty($post['form_idCuenta'])) $where .= " AND idCuenta = " . $post['form_idCuenta'];
        if (!empty($post['idAplicacion'])) $where .= " AND idAplicacion != " . $post['idAplicacion'];
        return $this->verificarRepetido('trade.aplicacion', $where);
    }

    public function getCuentas($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND idCuenta = " . $post['id'];
        }

        $sql = "
				SELECT *
				FROM trade.cuenta
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.cuenta'];
        return $this->db->query($sql);
    }

    //GRUPO MODULO

    public function getGrupoModulo($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND appmg.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND appmg.idModuloGrupo = " . $post['id'];
        }

        $sql = "
				SELECT
                appmg.idModuloGrupo
                , appmg.nombre AS modulogrupo
                , appmg.estado
				FROM trade.aplicacion_modulo_grupo appmg
				{$filtros}
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.aplicacion_modulo_grupo'];
        return $this->db->query($sql);
    }

    public function registrarGrupoModulo($post)
    {
        $insert = [
            'nombre' => trim($post['nombre'])
        ];

        $insert = $this->db->insert('trade.aplicacion_modulo_grupo', $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarGrupoModulo($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'fechaModificacion' => getActualDateTime()
        ];

        $where = [
            'idModuloGrupo' => $post['idModuloGrupo']
        ];

        $this->db->where($where);
        $update = $this->db->update('trade.aplicacion_modulo_grupo', $update);
        return $update;
    }

    public function checkGrupoModuloRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "'";
        if (!empty($post['idModuloGrupo'])) $where .= " AND idModuloGrupo != " . $post['idModuloGrupo'];
        return $this->verificarRepetido('trade.aplicacion_modulo_grupo', $where);
    }

    //MODULO

    public function getModulo($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND appm.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND appm.idModulo = " . $post['id'];
        }

        $sql = "
				SELECT
                appm.idModulo
                , appm.nombre AS modulo
                , appm.orden
                , appm.estado
                , app.idAplicacion
                , app.nombre AS aplicacion
                , appgm.idModuloGrupo
                , appgm.nombre AS moduloGrupo
				FROM trade.aplicacion_modulo appm
                JOIN trade.aplicacion app ON appm.idAplicacion = app.idAplicacion
                JOIN trade.aplicacion_modulo_grupo appgm ON appm.idModuloGrupo = appgm.idModuloGrupo
				{$filtros}
                ORDER BY idAplicacion, orden, idModuloGrupo, modulo
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.aplicacion_modulo'];
        return $this->db->query($sql);
    }

    public function registrarModulo($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'orden' => trim($post['orden']),
            'idAplicacion' => $post['idAplicacion'],
            'idModuloGrupo' => $post['idModuloGrupo']
        ];

        $insert = $this->db->insert('trade.aplicacion_modulo', $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarModulo($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
            'orden' => trim($post['orden']),
            'idAplicacion' => $post['idAplicacion'],
            'idModuloGrupo' => $post['idModuloGrupo'],
            'fechaModificacion' => getActualDateTime()
        ];

        $where = [
            'idModulo' => $post['idModulo']
        ];

        $this->db->where($where);
        $update = $this->db->update('trade.aplicacion_modulo', $update);
        return $update;
    }

    public function checkModuloRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "'";
        if (!empty($post['idModulo'])) $where .= " AND idModulo != " . $post['idModulo'];
        if (!empty($post['idAplicacion'])) $where .= " AND idAplicacion = " . $post['idAplicacion'];
        if (!empty($post['idModuloGrupo'])) $where .= " AND idModuloGrupo = " . $post['idModuloGrupo'];
        return $this->verificarRepetido('trade.aplicacion_modulo', $where);
    }


    //MENUS

    public function getMenu($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND apm.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND apm.idMenu = " . $post['id'];
        }

        $sql = "
                select 
                apm.idMenu,apm.nombre,apm.estado
                from 
                trade.aplicacion_menu apm
				{$filtros}
                ORDER BY idMenu, nombre
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => 'trade.aplicacion_menu'];
        return $this->db->query($sql);
    }

    public function registrarMenu($post)
    {
        $insert = [
            'nombre' => trim($post['nombre']),
            'estado' => 1
        ];

        $insert = $this->db->insert('trade.aplicacion_menu', $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarMenu($post)
    {
        $update = [
            'nombre' => trim($post['nombre']),
        ];

        $where = [
            'idMenu' => $post['idMenu']
        ];

        $this->db->where($where);
        $update = $this->db->update('trade.aplicacion_menu', $update);
        return $update;
    }

    public function checkMenuRepetido($post)
    {
        $where = "nombre = '" . trim($post['nombre']) . "'";
        if (!empty($post['idMenu'])) $where .= " AND idMenu != " . $post['idMenu'];
        return $this->verificarRepetido('trade.aplicacion_menu', $where);
    }


    //MENU CUENTA

    public function getMenuCuenta($post = 'nulo')
    {
        $filtros = "WHERE 1 = 1";
        if ($post == 'nulo') {
            $filtros .= " AND lam.estado = 1";
        } else {
            if (!empty($post['id'])) $filtros .= " AND lam.idListAplicacionMenu = " . $post['id'];
        }

        $sql = "
            select 
                lam.idListAplicacionMenu,
                lam.idMenu,
                am.nombre as menu,
                lam.idAplicacion,
                a.nombre as aplicacion,
                lam.idCuenta,
                c.nombre as cuenta,
                lam.idProyecto,
                p.nombre as proyecto,
                lam.idGrupoCanal,
                gc.nombre as grupoCanal,
                lam.idTipoUsuario,
                tu.nombre as tipoUsuario,
                lam.estado
            from {$this->sessBDCuenta}.trade.list_aplicacion_menu lam
            JOIN trade.aplicacion_menu am ON am.idMenu=lam.idMenu
            JOIN trade.aplicacion a ON a.idAplicacion=lam.idAplicacion
            LEFT JOIN trade.cuenta c ON c.idCuenta=lam.idCuenta
            LEFT JOIN trade.proyecto p ON p.idProyecto=lam.idProyecto
            LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal=lam.idGrupoCanal
            LEFT JOIN trade.usuario_tipo tu ON tu.idTipoUsuario=lam.idTipoUsuario
				{$filtros}
                ORDER BY lam.idCuenta DESC, lam.idProyecto DESC ,lam.idGrupoCanal DESC, lam.idTipoUsuario DESC
			";

        $this->CI->aSessTrack[] = ['idAccion' => 5, 'tabla' => "{$this->sessBDCuenta}.trade.list_aplicacion_menu"];
        return $this->db->query($sql);
    }

    public function registrarMenuCuenta($post)
    {
        $insert = [
            'idAplicacion' => trim($post['idAplicacion']),
            'idMenu' => trim($post['idMenu']),
            'estado' => 1
        ];
        if (!empty($post['idCuenta'])) $insert['idCuenta'] = $post['idCuenta'];
        if (!empty($post['idProyecto'])) $insert['idProyecto'] = $post['idProyecto'];
        if (!empty($post['idGrupoCanal'])) $insert['idGrupoCanal'] = $post['idGrupoCanal'];
        if (!empty($post['idTipoUsuario'])) $insert['idTipoUsuario'] = $post['idTipoUsuario'];

        $insert = $this->db->insert("{$this->sessBDCuenta}.trade.list_aplicacion_menu", $insert);
        $this->insertId = $this->db->insert_id();
        return $insert;
    }

    public function actualizarMenuCuenta($post)
    {
        $update = [
            'idAplicacion' => trim($post['idAplicacion']),
            'idMenu' => trim($post['idMenu']) 
        ];
        if (!empty($post['idCuenta'])) $update['idCuenta'] = $post['idCuenta'];
        if (!empty($post['idProyecto'])) $update['idProyecto'] = $post['idProyecto'];
        if (!empty($post['idGrupoCanal'])){
            $update['idGrupoCanal'] = $post['idGrupoCanal'];
        }else{
            $update['idGrupoCanal'] = null;
        } 
        if (!empty($post['idTipoUsuario'])){
            $update['idTipoUsuario'] = $post['idTipoUsuario'];
        }else{
            $update['idTipoUsuario'] = null;
        } 

        $where = [
            'idListAplicacionMenu' => $post['idListAplicacionMenu']
        ];

        $this->db->where($where);
        $update = $this->db->update("{$this->sessBDCuenta}.trade.list_aplicacion_menu", $update);
        return $update;
    }


    public function getCuentasProyecto($input=array()){
		$filtros = "";

		$sql = "
		DECLARE @fecha DATE=GETDATE();
		SELECT
			c.idCuenta
			, UPPER(c.nombreComercial) AS cuenta
			, p.idProyecto
			, UPPER(p.nombre) AS proyecto
		FROM trade.cuenta c 
		JOIN trade.proyecto p ON p.idCuenta=c.idCuenta
		WHERE c.estado=1 AND p.estado=1
		AND @fecha BETWEEN p.fecIni AND ISNULL(p.fecFin,@fecha)";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql);
	}

    public function getGrupoCanal($input=array()){
		$sql = "
            SELECT distinct
                    cc.idCuenta
                , gc.idGrupoCanal, 
                UPPER(gc.nombre) AS grupoCanal
            FROM trade.cuenta_canal cc
            JOIN trade.canal c ON c.idCanal=cc.idCanal
            JOIN trade.grupoCanal gc ON gc.idGrupoCanal=c.idGrupoCanal
            WHERE cc.estado=1 AND c.estado=1 AND gc.estado=1
        ";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta_canal' ];
		return $this->db->query($sql);
	}

    public function getTipoUsuario($input=array()){
		$sql = "
            SELECT distinct 
            tuc.idCuenta,tuc.idTipoUsuario,ut.nombre as tipoUsuario
            FROM trade.tipoUsuarioCuenta tuc
            JOIN  trade.usuario_tipo ut ON ut.idTipoUsuario=tuc.idTipoUsuario
            WHERE tuc.estado=1 and ut.estado=1
        ";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.tipoUsuarioCuenta' ];
		return $this->db->query($sql);
	}

    public function checkMenuCuentaRepetido($post)
    {
        $where = "idMenu = '" . trim($post['idMenu']) . "'";
        $where .= " AND idAplicacion = " . $post['idAplicacion'];
        $where .= " AND idCuenta = " . $post['idCuenta'];

        if (!empty($post['idProyecto'])){
            $where .= " AND idProyecto = " . $post['idProyecto'];
        } else{
            $where .= " AND idProyecto IS NULL";
        }

        if (!empty($post['idGrupoCanal'])){
            $where .= " AND idGrupoCanal = " . $post['idGrupoCanal'];
        }else{
            $where .= " AND idGrupoCanal IS NULL";
        } 

        if (!empty($post['idTipoUsuario'])){
            $where .= " AND idTipoUsuario = " . $post['idTipoUsuario'];
        }else{
            $where .= " AND idTipoUsuario IS NULL";
        } 

        if (!empty($post['idListAplicacionMenu'])){
            $where .= " AND idListAplicacionMenu != " . $post['idListAplicacionMenu'];
        }
        
        return $this->verificarRepetido("{$this->sessBDCuenta}.trade.list_aplicacion_menu", $where);
    }

}
