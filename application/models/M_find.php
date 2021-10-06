
            <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_find extends MY_Model{


	public function __construct(){
		parent::__construct();
	}

	public function query($sql){
		$this->db->query($sql);
    }
    public function findMenuUsuario($idUsuario)
	{
        $sql = "
        SELECT 
				mo.*
				, gm.idGrupoMenu
				, gm.nombre grupoMenu
				, gm.cssIcono grupoIcono
				, gm.page grupoPage
				, sgm.idSubGrupoMenu
				, sgm.nombre subGrupoMenu
				, sgm.cssIcono subGrupoIcono
				, sgm.page subGrupoPage
			FROM 
				trade.usuario_menuOpcion amo
				JOIN trade.menuOpcion mo ON amo.idMenuOpcion = mo.idMenuOpcion AND mo.estado = 1
				JOIN trade.grupoMenu gm ON gm.idGrupoMenu = mo.idGrupoMenu AND gm.estado = 1
				LEFT JOIN trade.subGrupoMenu sgm ON sgm.idSubGrupoMenu = mo.idsubGrupoMenu AND sgm.estado = 1	
			WHERE
				amo.idUsuario = $idUsuario
				AND amo.estado = 1
            ORDER BY gm.idGrupoMenu,mo.nombre
            ;
		";
		return $this->db->query($sql);
	}
    public function filtrado_findMenuUsuario($params)
	{
        $sql = "
        SELECT DISTINCT
				mo.*
				, gm.idGrupoMenu
				, gm.nombre grupoMenu
				, gm.cssIcono grupoIcono
				, gm.page grupoPage
				, sgm.idSubGrupoMenu
				, sgm.nombre subGrupoMenu
				, sgm.cssIcono subGrupoIcono
				, sgm.page subGrupoPage
			FROM 
				trade.usuario_menuOpcion amo
				JOIN trade.menuOpcion mo ON amo.idMenuOpcion = mo.idMenuOpcion AND mo.estado = 1
				JOIN trade.grupoMenu gm ON gm.idGrupoMenu = mo.idGrupoMenu AND gm.estado = 1
				LEFT JOIN trade.subGrupoMenu sgm ON sgm.idSubGrupoMenu = mo.idsubGrupoMenu AND sgm.estado = 1	
			WHERE
				amo.idUsuario = ".$params['idUsuario']."
				AND amo.estado = 1
				AND mo.nombre like ('%".$params['filtro']."%') or mo.page like('%".$params['filtro']."%')
			ORDER BY gm.idGrupoMenu,mo.nombre
            ;
		";
		return $this->db->query($sql);
	}
}