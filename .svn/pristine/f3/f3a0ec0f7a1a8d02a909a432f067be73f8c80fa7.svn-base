<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_iniciativatrad extends My_Model
{

	var $aSessTrack = [];

	public function __construct()
	{
		parent::__construct();

		$this->tablas = [
			'elemento' => ['tabla' => 'trade.iniciativaTrad', 'id' => 'idIniciativa'],
			'lista' => ['tabla' => 'trade.list_iniciativaTrad', 'id' => 'idListIniciativaTrad'],
			'listaDet' => ['tabla'=>'trade.list_iniciativaTradDet','id'=>'idListIniciativaTradDet'],
			'tipoElemento' => ['tabla'=>'trade.competencia_tipo','id'=>'idTipoCompetencia'],
			'elementoIniciativa' => ['tabla'=>'trade.elementoVisibilidadTrad','id'=>'idElementoVis'],
			'motivoIniciativa' => ['tabla'=>'trade.estadoIniciativaTrad','id'=>'idEstadoIniciativa'],
			'listaDetElemento' =>['tabla'=>'trade.list_iniciativaTradDetElemento','id'=>'idListIniciativaTradDetEle'],
			'motivoElementoVisibilidad' => ['tabla'=>'trade.motivoElementoVisibilidadTrad','id'=>'idMotivoElementoVis'],

			'iniciativaTradElemento' => ['tabla'=>'trade.iniciativaTradElemento','id'=>'idIniciativaTradElemento'],


		];
	}

	// SECCION ELEMENTO
	public function getElementos($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elemento']['id']." = " . $post['id'];
			if (!empty($post['cuenta'])) $filtros .= " AND  idCuenta = " . $post['cuenta'];
		}

		$sql = "
                SELECT 
                p.*
                FROM
                ".$this->tablas['elemento']['tabla']." p
                {$filtros}
				ORDER BY p.estado DESC
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function getMotivos($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['motivoIniciativa']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT 
                p.*
                FROM
                ".$this->tablas['motivoIniciativa']['tabla']." p
                {$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['motivoIniciativa']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function getElementosIniciativa($post = 'nulo')
	{
		$filtros = "WHERE p.idTipoElementoVisibilidad=2 ";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elementoIniciativa']['id']." = " . $post['id'];
			if (!empty($post['cuenta'])) $filtros .= " AND  p.idCuenta = " . $post['cuenta'];
		}

		$sql = "
                SELECT 
				p.*
                FROM
				".$this->tablas['elementoIniciativa']['tabla']." p
				
                {$filtros}
				ORDER BY p.estado DESC,p.nombre
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['elementoIniciativa']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function getListaElementosIniciativa($post= 'nulo')
	{
		$filtros = " AND det.idTipoElementoVisibilidad=2 ";
		if ($post == 'nulo') {
			$filtros .= " AND det.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND e.".$this->tablas['elemento']['id']." = " . $post['id'];
			if (!empty($post['cuenta'])) $filtros .= " AND  det.idCuenta = " . $post['cuenta'];
		}
		$sql = "
			SELECT
				e.idIniciativa
				, e.idElementoVis 
				, det.nombre
				from  trade.iniciativaTradElemento e 
				JOIN trade.elementoVisibilidadTrad det ON e.idElementoVis = det.idElementoVis
				WHERE 1=1 {$filtros}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.elementoVisibilidadTrad', 'id' => null ];
		return $this->db->query($sql);
	}
	

	public function getTiposElemento($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['tipo'])) $filtros .= " AND ".$this->tablas['tipoElemento']['id']." = " . $post['tipo'];
		}

		$sql = "
                SELECT *
                FROM
                ".$this->tablas['tipoElemento']['tabla']." t
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['tipoElemento']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function registrarElemento($post)
	{
		$insert = [
			'nombre' => trim($post['nombre']),
			'descripcion' => trim($post['descripcion']),
			'FecIni' => trim($post['fechaInicio']),
			'fechaCreacion' => getActualDateTime(),
			'idCuenta' => trim($post['cuenta'])
        ];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['descripcion'])){$insert['descripcion']=$post['descripcion'];}

		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}
	
	public function registrarDetalleLista($post,$idLista)
	{
		$aSessTrack = [];
		$insert=null;
		//segun elemento registrar iniciativa y luego elemento, igual como en generacion de lista modulacion iniciativa
		$this->db->delete($this->tablas['listaDet']['tabla'],array('idListIniciativaTrad'=>$idLista));
		$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $idLista ];

		if(is_array($post['elemento_lista'])){

			foreach($post['elemento_lista'] as $index => $value){
				if($value!=""){
					//$rs_iniciativa = $this->db->get_where('trade.elementoVisibilidadTrad',array('idElementoVis'=>$value))->row_array();
					if( !empty($post['elemento_iniciativa'][$index])){
						$idIniciativa= $post['elemento_iniciativa'][$index];


						$arrayDetalle=array();
						$arrayDetalle['idIniciativa'] = $idIniciativa;
						$arrayDetalle['idListIniciativaTrad'] = $idLista;
						$arrayDetalle['estado'] = 1;
	
						//validar existencia
						$rs = $this->db->get_where('trade.list_iniciativaTradDet',$arrayDetalle)->result_array();
						if($rs!=null){
							if(count($rs) >=1){
								//si existe iniciativa agregar detalle elemento
								$idListDetalle=$rs[0]['idListIniciativaTradDet'];

								$arrayDetalleElemento=array();
								$arrayDetalleElemento['idListIniciativaTradDet']=$idListDetalle;
								$arrayDetalleElemento['idElementoVis']=$value;
								$arrayDetalleElemento['estado']=1;

								//validar existencia
								$rs_elemento = $this->db->get_where('trade.list_iniciativaTradDetElemento',$arrayDetalleElemento)->result_array();
								if($rs_elemento==null){

									$table = 'trade.list_iniciativaTradDetElemento';
									$this->db->trans_begin();
		
										$insert = $this->db->insert($table, $arrayDetalleElemento);
										$id = $this->db->insert_id();
		
										$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
		
									if ( $this->db->trans_status()===FALSE ) {
										$this->db->trans_rollback();
									} else {
										$this->db->trans_commit();
										$this->aSessTrack[] = $aSessTrack;
									}
								}
								
							}else{
								//insertar la iniciativa
								$table = 'trade.list_iniciativaTradDet';
								$this->db->trans_begin();
	
									$insert = $this->db->insert($table, $arrayDetalle);
									$id = $this->db->insert_id();
	
									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
									
	
									//detalle elemento
									$idListDetalle=$this->db->insert_id();
									$arrayDetalleElemento=array();
									$arrayDetalleElemento['idListIniciativaTradDet']=$idListDetalle;
									$arrayDetalleElemento['idElementoVis']=$value;
									$arrayDetalleElemento['estado']=1;
	
									$table = 'trade.list_iniciativaTradDetElemento';
									$this->db->trans_begin();
	
										$insert = $this->db->insert($table, $arrayDetalleElemento);
										$id = $this->db->insert_id();
	
										$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
									if ( $this->db->trans_status()===FALSE ) {
										$this->db->trans_rollback();
									} else {
										$this->db->trans_commit();
										$this->aSessTrack[] = $aSessTrack;
									}
								}
							}
						}else{
							//insertar la iniciativa
							$table = 'trade.list_iniciativaTradDet';
							$this->db->trans_begin();
	
								$insert = $this->db->insert($table, $arrayDetalle);
								$id = $this->db->insert_id();
	
								$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
							if ( $this->db->trans_status()===FALSE ) {
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
								$this->aSessTrack[] = $aSessTrack;
	
								//detalle elemento
								$idListDetalle=$this->db->insert_id();
								$arrayDetalleElemento=array();
								$arrayDetalleElemento['idListIniciativaTradDet']=$idListDetalle;
								$arrayDetalleElemento['idElementoVis']=$value;
								$arrayDetalleElemento['estado']=1;
	
								$table = 'trade.list_iniciativaTradDetElemento';
								$this->db->trans_begin();
	
									$insert = $this->db->insert($table, $arrayDetalleElemento);
									$id = $this->db->insert_id();
	
									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
								}
							}
						}
					}
					

				}
				
 
			}
		}
 
		return $insert;
	}


	public function deleteMasivoDetalleLista($idLista)
	{
		$delete=null;
		$sql="
			DELETE trade.list_iniciativaTradDetElemento where idListIniciativaTradDet IN(
				SELECT idListIniciativaTradDet from trade.list_iniciativaTradDet WHERE idListIniciativaTrad=$idLista
			);
		";
		$delete=$this->db->query($sql);
		if($delete){
			$sql="
				DELETE trade.list_iniciativaTradDet WHERE idListIniciativaTrad=$idLista
			";
			$delete=$this->db->query($sql);

			$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.list_iniciativaTradDetElemento', 'id' => arrayToString([ 'idListIniciativaTrad' => $idLista ]) ];
			$this->aSessTrack[] = [ 'idAccion' => 8, 'tabla' => 'trade.list_iniciativaTradDet', 'id' => arrayToString([ 'idListIniciativaTrad' => $idLista ]) ];
		}
		return $delete;
	}
    
	public function registrarElementoIniciativa($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
			'idProyecto' => trim($post['proyecto']),
			'idCuenta' => trim($post['cuenta']),
			'idTipoElementoVisibilidad'=>2
        ];

		$insert = $this->db->insert($this->tablas['elementoIniciativa']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elementoIniciativa']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
	public function registrarMotivoIniciativa($post)
	{
		$insert = [
            'nombre' => trim($post['nombre']),
        ];

		$insert = $this->db->insert($this->tablas['motivoIniciativa']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['motivoIniciativa']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }
    
    public function actualizarElemento($post)
	{

		$update = [
            'nombre' => trim($post['nombre']),
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
        ];
		if(!empty($post['descripcion'])){$update['descripcion']=$post['descripcion'];}
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
        
		$where = [
			$this->tablas['elemento']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elemento']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

    public function actualizarElementoIniciativa($post)
	{

		$update = [
            'nombre' => trim($post['nombre'])
        ];
        
		$where = [
			$this->tablas['elementoIniciativa']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['elementoIniciativa']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elementoIniciativa']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

    public function actualizarMotivoIniciativa($post)
	{

		$update = [
            'nombre' => trim($post['nombre'])
        ];
        
		$where = [
			$this->tablas['motivoIniciativa']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['motivoIniciativa']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['motivoIniciativa']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}

	public function registrarLista($post)
	{

		$insert = [
			'idProyecto' => trim($post['proyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'idGrupoCanal' =>trim($post['grupoCanal']),
			//'idIniciativaTrad'=>trim($post['iniciativa'])
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['cliente'])){$insert['idCliente']=$post['cliente'];}
		if(!empty($post['canal'])){$insert['idCanal']= trim($post['canal']);}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}
	
	public function registrarListaDetalle($idLista,$idEncuesta,$idMarca)
	{

		$insert = [
			$this->tablas['lista']['id'] => $idLista,
			$this->tablas['elemento']['id'] => $idEncuesta,
		];
		$where = [
			$this->tablas['lista']['id'] => $idLista,
			$this->tablas['elemento']['id'] => $idEncuesta,
			$this->tablas['marca']['id']=> $idMarca

		];

		$encuesta_repetida = $this->db->get_where($this->tablas['listaDet']['tabla'],$where)->row_array();

		if(count($encuesta_repetida)<1){
			$insert = $this->db->insert($this->tablas['listaDet']['tabla'], $insert);
			$this->insertId = $this->db->insert_id();

			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['listaDet']['tabla'], 'id' => $this->insertId ];
		}else{
			$insert = false;
		}

		return $insert;
	}

	public function actualizarLista($post)
	{
		
		$update = [
			'FecIni' => trim($post['fechaInicio']),
			'fechaModificacion' => getActualDateTime(),
		];
		if(!empty($post['fechaFin'])){$update['fecFin']=$post['fechaFin'];}
		if(!empty($post['canal'])){$update['idCanal']= trim($post['canal']);}
		if(!empty($post['Cliente'])){$update['idCanal']= trim($post['canal']);}

		$where = [
			$this->tablas['lista']['id'] => $post['idlst']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['lista']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $post['idlst'] ];
		return $update;
	}

	public function actualizarMasivoLista($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['listaDet']['id'] => $value['id'],
					$this->model->tablas['elemento']['id'] =>$value['elemento_lista'],
	
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['listaDet']['tabla'], $input, $this->model->tablas['listaDet']['id']);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['listaDet']['tabla'] ];
		return $update;
	}

	public function actualizarMasivoIniciativaElemento($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					$this->model->tablas['listaDet']['id'] => $value['id'],
					$this->model->tablas['elemento']['id'] =>$value['elemento_iniciativa'],
	
					
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->model->tablas['elementoIniciativa']['tabla'], $input, $this->model->tablas['elementoIniciativa']['id']);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['elementoIniciativa']['tabla'] ];
		return $update;
	}

	public function guardarMasivoLista($multiDataRefactorizada, $idLista)
	{
		$aSessTrack = [];

		//Pasar a la vista
		$new_array = array();
			$input = [];

			foreach($multiDataRefactorizada as $index => $row){
	
					$arrayDetalle=array();
					$arrayDetalle['idIniciativa'] = $row['iniciativa_lista'];
					$arrayDetalle['idListIniciativaTrad'] =  $idLista;
					$arrayDetalle['estado'] = 1;

				
	
					//validar existencia
					$rs = $this->db->get_where('trade.list_iniciativaTradDet',$arrayDetalle)->result_array();
					if($rs!=null){
						if(count($rs) >=0){
							//si existe iniciativa agregar detalle elemento
							$idListDetalle=$rs[0]['idListIniciativaTradDet'];

							$arrayDetalleElemento=array();
							$arrayDetalleElemento['idListIniciativaTradDet']=$idListDetalle;
							$arrayDetalleElemento['idElementoVis']=$row['elemento_lista'];
							$arrayDetalleElemento['estado']=1;

							$rs_elementos = $this->db->get_where('trade.list_iniciativaTradDetElemento', $arrayDetalleElemento)->result_array();
							if( empty($rs_elementos)){
								$table = 'trade.list_iniciativaTradDetElemento';
								$this->db->trans_begin();

									$insert = $this->db->insert($table, $arrayDetalleElemento);
									$id = $this->db->insert_id();

									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
								}
							}
							
						}else{
							//insertar la iniciativa
							$table = 'trade.list_iniciativaTradDet';
							$this->db->trans_begin();

								$insert = $this->db->insert($table, $arrayDetalle);
								$idListDetalle = $this->db->insert_id();
								$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $idListDetalle ];

							if ( $this->db->trans_status()===FALSE ) {
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
								$this->aSessTrack[] = $aSessTrack;
	
								//detalle elemento


								$arrayDetalleElemento=array();
								$arrayDetalleElemento['idListIniciativaTradDet']=$idListDetalle;
								$arrayDetalleElemento['idElementoVis']=$row['elemento_lista'];
								$arrayDetalleElemento['estado']=1;
	
								$table = 'trade.list_iniciativaTradDetElemento';
								$this->db->trans_begin();

									$insert = $this->db->insert($table, $arrayDetalleElemento);
									$id = $this->db->insert_id();

									$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];
	
								if ( $this->db->trans_status()===FALSE ) {
									$this->db->trans_rollback();
								} else {
									$this->db->trans_commit();
									$this->aSessTrack[] = $aSessTrack;
								}
							}
						}
					}else{
						//insertar la iniciativa
						$table = 'trade.list_iniciativaTradDet';
						$this->db->trans_begin();

							$insert = $this->db->insert($table, $arrayDetalle);
							$idListDetalle = $this->db->insert_id();
							$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $idListDetalle ];

						if ( $this->db->trans_status()===FALSE ) {
							$this->db->trans_rollback();
						} else {
							$this->db->trans_commit();
							$this->aSessTrack[] = $aSessTrack;

							//detalle elemento


							$arrayDetalleElemento=array();
							$arrayDetalleElemento['idListIniciativaTradDet']=$idListDetalle;
							$arrayDetalleElemento['idElementoVis']=$row['elemento_lista'];
							$arrayDetalleElemento['estado']=1;

							$table = 'trade.list_iniciativaTradDetElemento';
							$this->db->trans_begin();

								$insert = $this->db->insert($table, $arrayDetalleElemento);
								$id = $this->db->insert_id();

								$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $id ];

							if ( $this->db->trans_status()===FALSE ) {
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
								$this->aSessTrack[] = $aSessTrack;
							}
						}
					}
			}
			
		
		return $insert;
	}


	public function guardarMasivoIniciativaElementoMotivos($multiDataRefactorizada, $idLista)
	{
		$aSessTrack = [];

		$new_array = array();
		$insert=true;
		$input = [];

			foreach($multiDataRefactorizada as $index => $row){
				$arrayDetalle=array();
				$arrayDetalle['idElementoVis'] = $row['elemento_lista'];
				$arrayDetalle['idEstadoIniciativa'] =$row['motivo_lista'];
				$arrayDetalle['idIniciativa'] =  $idLista;
				$arrayDetalle['estado'] = 1;

				//validar existencia
				$rs = $this->db->get_where('trade.motivoElementoVisibilidadTrad',$arrayDetalle)->result_array();
				if($rs==null){ 
					//insertar la motivo a elemento
					$table = 'trade.motivoElementoVisibilidadTrad';
					$this->db->trans_begin();

						$insert = $this->db->insert($table, $arrayDetalle);
						$idListDetalle = $this->db->insert_id();
						$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $idListDetalle ];

					if ( $this->db->trans_status()===FALSE ) {
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						$this->aSessTrack[] = $aSessTrack;
					}
				}
			}


			foreach($multiDataRefactorizada as $index => $row){
				$arrayDetalle=array();
				$arrayDetalle['idElementoVis'] = $row['elemento_lista'];
				$arrayDetalle['idIniciativa'] =  $idLista;
				$arrayDetalle['estado'] = 1;

				//validar existencia
				$rs = $this->db->get_where('trade.iniciativaTradElemento',$arrayDetalle)->result_array();
				if($rs==null){ 
					//insertar la elemento a iniciativa
					$table = 'trade.iniciativaTradElemento';
					$this->db->trans_begin();

						$insert = $this->db->insert($table, $arrayDetalle);
						$idListDetalle = $this->db->insert_id();
						$aSessTrack = [ 'idAccion' => 6, 'tabla' => $table, 'id' => $idListDetalle ];

					if ( $this->db->trans_status()===FALSE ) {
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						$this->aSessTrack[] = $aSessTrack;
					}
				}
			}
		
		return $insert;
	}
	
	public function guardarMasivoIniciativaElemento($multiDataRefactorizada, $idLista)
	{

		//Pasar a la vista
		$new_array = array();
        $repetidos = false;
        
		if(!$repetidos){

			$input = [];
			foreach ($multiDataRefactorizada as $value) {
				if (empty($value['id'])) {

					$rs = $this->db->get_where($this->model->tablas['elementoIniciativa']['tabla'],array($this->model->tablas['elementoIniciativa']['id']=>$idLista,$this->model->tablas['elementoIniciativa']['id']=>$value['elemento_iniciativa']))->row_array();
					$nombre=$rs['nombre'];
					$input[] = [
						$this->model->tablas['elemento']['id'] => $idLista,
						'nombre' =>$nombre,
					];
					

				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->model->tablas['elementoIniciativa']['tabla'], $input);
			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['elementoIniciativa']['tabla'] ];
		
		}else{
            $insert = 'repetido';
        }
		return $insert;
	}
	
	public function checkNombreElementoRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['elemento']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['elemento']['tabla'], $where);
	}

	public function checkNombreElementoIniciativaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['elementoIniciativa']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['elementoIniciativa']['tabla'], $where);
	}

	public function checkNombreMotivoniciativaRepetido($post)
	{
		$where = "nombre = '" . trim($post['nombre']) . "'";
		if (!empty($post['idx'])) $where .= " AND " . $this->tablas['motivoIniciativa']['id'] . " != " . $post['idx'];
		return $this->verificarRepetido($this->tablas['motivoIniciativa']['tabla'], $where);
	}

	// SECCION LISTA
	public function getListas($post)
	{
		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND lst.".$this->tablas['lista']['id']." = " . $post['id'];
		
		/*Filtros */
		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['grupoCanal'];
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];
		/*=====*/

		$sql = "
				SELECT 
				distinct
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.nombreComercial
				,cli.razonSocial
                ,cli.codCliente
				,gc.nombre grupoCanal
				FROM ".$this->tablas['lista']['tabla']." lst
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
                LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
				{$filtros}
				ORDER BY lst.estado DESC,lst.fecIni ASC
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['lista']['tabla'] ];
		return $this->db->query($sql);
	}

	public function getListasDet($post)
	{
		$filtros = " WHERE 1 = 1";
		if (!empty($post['id'])) $filtros .= " AND lst.".$this->tablas['lista']['id']." = " . $post['id'];
		
		/*Filtros */
		if(!empty($post['proyecto']))$filtros .= " AND p.idProyecto=".$post['proyecto'];
		if(!empty($post['grupoCanal']))$filtros .= " AND gc.idGrupoCanal=".$post['grupoCanal'];
		if(!empty($post['canal']))$filtros .= " AND c.idCanal=".$post['canal'];
		/*=====*/

		$sql = "
				SELECT 
				lst.*
				,p.nombre proyecto
				,c.nombre canal 
				,cli.nombreComercial
				,cli.razonSocial
                ,cli.codCliente
				,gc.nombre grupoCanal
				,ini.nombre iniciativa
				FROM ".$this->tablas['lista']['tabla']." lst
				JOIN trade.list_iniciativaTradDet lstd ON lstd.idListIniciativaTrad = lst.idListIniciativaTrad
				JOIN trade.proyecto p ON p.idProyecto  = lst.idProyecto
				LEFT JOIN trade.canal c ON c.idCanal = lst.idCanal
                LEFT JOIN trade.cliente cli ON cli.idCliente = lst.idCliente
				LEFT JOIN trade.grupoCanal gc ON gc.idGrupoCanal = lst.idGrupoCanal
				LEFT JOIN trade.iniciativaTrad ini ON ini.idIniciativa = lstd.idIniciativa 
				{$filtros}
				ORDER BY lst.estado DESC,lst.fecIni ASC
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['lista']['tabla'] ];
		return $this->db->query($sql);
	}

	public function getListaElementos($post)
	{
	
		$sql = "
			SELECT 
			e.idIniciativa,
			e.nombre as iniciativa,
			lstd.idListIniciativaTradDet,
			lstd.idIniciativa,
			ev.idElementoVis,
			ev.nombre 		
			FROM 
			trade.iniciativaTrad e
			JOIN trade.list_iniciativaTradDet lstd ON lstd.idIniciativa = e.idIniciativa
			JOIN trade.list_iniciativaTradDetElemento lstdet On lstdet.idListIniciativaTradDet=lstd.idListIniciativaTradDet
			JOIN trade.elementoVisibilidadTrad ev ON ev.idElementoVis=lstdet.idElementoVis
			WHERE lstd.idListIniciativaTrad = ".$post['id'].";
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.iniciativaTrad' ];
		return $this->db->query($sql);
	}

	public function getClientes($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.estado=1 AND ch.idProyecto = " . $post['id'];
		}

		$sql = "
			DECLARE @fecha DATE=GETDATE();
			SELECT --TOP 6000
			c.idCliente, c.razonSocial
			FROM trade.cliente c
			JOIN ".getClienteHistoricoCuenta()." ch ON ch.idCliente = c.idCliente
			WHERE 1=1 AND ch.estado=1
			AND @fecha BETWEEN ch.fecIni AND ISNULL(ch.fecFin,@fecha)
			{$filtros}
			ORDER BY c.idCliente DESC";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cliente' ];
		return $this->db->query($sql);
	}

	public function getSegCliente($post){
		$sql = "
		DECLARE @fecha DATE=getdate();
		SELECT 
			c.idCliente
			,c.razonSocial
		FROM trade.cliente c
		JOIN ".getClienteHistoricoCuenta()." ch ON c.idCliente = ch.idCliente
		JOIN trade.segmentacionNegocio seg ON ch.idSegNegocio = seg.idSegNegocio
		WHERE 
		@fecha between ch.fecIni and ISNULL(ch.fecFin,@fecha)
		AND seg.idCanal= {$post['idCanal']}";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.segmentacionNegocio' ];
		return $this->db->query($sql);
	}

	public function getElementosPoriniciativa($post){
		
		if(empty($post['idIniciativa'])) $post['idIniciativa'] ='0';

		$sql = "
		SELECT 
		e.* 
		FROM 
		trade.elementoVisibilidadTrad e 
		WHERE e.idIniciativa= {$post['idIniciativa']}";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.elementoVisibilidadTrad' ];
		return $this->db->query($sql);
	}

	public function getElementosDestino($post){
		if(empty($post['idIniciativaTrad'])) $post['idIniciativaTrad'] ='0';
		$sql = "

		SELECT 
		e.* 
		FROM  trade.[list_iniciativaTrad] lst
		JOIN trade.[list_iniciativaTradDet] det ON det.idListIniciativaTrad = lst.idListIniciativaTrad
		JOIN trade.[list_iniciativaTradDetElemento] detEle ON detEle.idListIniciativaTradDet = det.idListIniciativaTradDet
		JOIN trade.elementoVisibilidadTrad e ON e.idElementoVis=detEle.idElementoVis
		WHERE det.idIniciativa= {$post['idIniciativaTrad']} AND det.idListIniciativaTrad = {$post['idListIniciativaTrad']}
		";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.list_iniciativaTrad' ];
		return $this->db->query($sql);
	}

	public function getCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND c.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.idCanal = " . $post['id'];
			if (!empty($post['idProyecto'])) $filtros .= " AND pgc.idProyecto = " . $post['idProyecto'];
		}

		$sql = "
				SELECT c.*, 
					gc.nombre grupoCanal
				FROM trade.canal c
				JOIN trade.grupoCanal gc ON gc.idGrupoCanal=c.idGrupoCanal
				JOIN  trade.Proyectogrupocanal pgc 
				ON pgc.idGrupoCanal=gc.idGrupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.canal' ];
		return $this->db->query($sql);
	}


	public function getGrupoCanales($post = 'nulo')
	{
		$filtros = "WHERE 1 = 1";
		if ($post == 'nulo') {
			$filtros .= " AND gc.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND idGrupoCanal = " . $post['id'];
			if (!empty($post['idProyecto'])) $filtros .= " AND pgc.idProyecto = " . $post['idProyecto'];
		}

		$sql = "
			SELECT 
				gc.*
					FROM trade.grupoCanal gc
			JOIN  trade.Proyectogrupocanal pgc 
			ON pgc.idGrupoCanal=gc.idGrupoCanal
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.grupoCanal' ];
		return $this->db->query($sql);
	}

	public function registrarLista_HT($post)
	{

		$insert = [
			'idProyecto' => trim($post['idProyecto']),
			'FecIni' => trim($post['fechaInicio']),
			'idGrupoCanal' =>trim($post['idGrupoCanal']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['idCliente'])){$insert['idCliente']=$post['idCliente'];}
		if(!empty($post['idCanal'])){$insert['idCanal']= trim($post['idCanal']);}

		$insert = $this->db->insert($this->tablas['lista']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['lista']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

	public function validar_filas_unicas_HT($post){
		$listas = array();
		foreach($post as $index => $value){
			$listas[$index] = $value['idLista'];
		}

		if(count($listas) != count(array_unique($listas))){
			return false;
		}else{
			return true;
		}

	}

	public function validar_elementos_unicos_HT($post){
		$elementos = array();

		foreach($post as $index => $value){
			$elementos[$index] = $value['iniciativa'];
		}

		if(count($elementos) != count(array_unique($elementos))){
			return false;
		}else{
			return true;
		}
	}

	public function registrar_elementos_HT($input){

		if (empty($input)) return true;
		$insert = $this->db->insert_batch($this->model->tablas['elemento']['tabla'], $input);

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['elemento']['tabla'] ];
		return $insert;
	}

	public function getProyectos($post)
	{
		$filtros = " ";
		if (!empty($post['nombre'])) $filtros .= " AND p.nombre =  '" . $post['nombre']."'";
		if (!empty($post['id'])) $filtros .= " AND p.idProyecto = " . $post['id'];
		if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario = " . $post['idUsuario'];

		$sql = "
				DECLARE @fecha date=getdate();
				select p.idProyecto,p.nombre AS proyecto
				from  trade.usuario_historico uh 
				JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
				where uh.estado=1 
				and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
				{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.proyecto' ];
		return $this->db->query($sql);
	}

	public function getCuentas($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND c.idCuenta = " . $post['id'];
			if (!empty($post['idUsuario'])) $filtros .= " AND uh.idUsuario = " . $post['idUsuario'];
		}

		$sql = "
			DECLARE @fecha date=getdate();
			select c.idCuenta,c.nombre from  trade.usuario_historico uh 
			JOIN trade.proyecto p On p.idProyecto=uh.idProyecto
			JOIN trade.cuenta c On c.idCuenta=p.idCuenta
			where uh.estado=1 
			and @fecha between uh.fecIni and ISNULL(uh.fecFin,@fecha)
			{$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.cuenta' ];
		return $this->db->query($sql);
	}

	public function getIniciativas($post='nulo'){

		//poner el idcuenta para filtrar las iniciativas
		$filtros="";
		if ($post == 'nulo') {

		} else {
			if (!empty($post['cuenta'])) $filtros .= " AND  idCuenta = " . $post['cuenta'];
		}

		$sql = "
			DECLARE @fecha as date=getdate();
			select idIniciativa,nombre from trade.iniciativaTrad
			where @fecha between fecIni and ISNULL(fecFin,@fecha) and estado=1
			 {$filtros}
			";

		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.iniciativaTrad' ];
		return $this->db->query($sql);
	}

	public function registrarElemento_HT($post)
	{
		$array=array();
		$array['idCuenta']  = $post['idCuenta'];
		$array['idTipoElementoVisibilidad'] = 2;
		$array['nombre'] = trim($post['elemento']);

		//validar existencia

		$sql = "
			SELECT t.* from ".$this->tablas['elementoIniciativa']['tabla']." t
			JOIN trade.proyecto c On c.idProyecto=t.idProyecto
			WHERE c.idCuenta=".$array['idCuenta']."
			AND t.idTipoElementoVisibilidad=".$array['idTipoElementoVisibilidad']."
			AND t.nombre='".$array['nombre']."' ";
		$rs=$this->db->query($sql)->result_array();
		if($rs==null){
			
			$insert = [
				'idCuenta' => $post['idCuenta'],
				'idProyecto' => $post['idProyecto'],
				'idTipoElementoVisibilidad' => 2,
				'nombre'=>trim($post['elemento']),
				'estado'=>1
			];
			$insert = $this->db->insert($this->tablas['elementoIniciativa']['tabla'], $insert);
			$this->insertId = $this->db->insert_id();
		}
		else{
			$insert = 'repetido';
		}
		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elementoIniciativa']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}



	public function getMotivoElementoVisibilidad($post = 'nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND p.estado = 1";
		} else {
			if (!empty($post['id'])) $filtros .= " AND ".$this->tablas['elementoIniciativa']['id']." = " . $post['id'];
		}

		$sql = "
                SELECT 
				p.*
				,eev.nombre
                FROM
				".$this->tablas['motivoElementoVisibilidad']['tabla']." p
				JOIN trade.estadoIniciativaTrad eev ON eev.idEstadoIniciativa = p.idEstadoIniciativa
				WHERE 1=1
                {$filtros}
				ORDER BY p.estado DESC,eev.nombre
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => $this->tablas['motivoElementoVisibilidad']['tabla'], 'id' => null ];
		return $this->db->query($sql);
	}

	public function registrarMotivoElementoVisibilidad($post)
	{
		$insert = [
            'idElementoVis' => $post['idElementoVis'],
			'idEstadoIniciativa' => $post['idEstadoIniciativa'],
			'estado' => 1
        ];

		$insert = $this->db->insert($this->tablas['motivoElementoVisibilidad']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['motivoElementoVisibilidad']['tabla'], 'id' => $this->insertId ];
		return $insert;
    }

	public function actualizarMotivoElementoVisibilidad($post)
	{

		$update = [
            'idEstadoIniciativa' => trim($post['idEstadoIniciativa'])
        ];
        
		$where = [
			$this->tablas['motivoElementoVisibilidad']['id'] => $post['idx']
		];

		$this->db->where($where);
		$update = $this->db->update($this->tablas['motivoElementoVisibilidad']['tabla'], $update);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['motivoElementoVisibilidad']['tabla'], 'id' => $post['idx'] ];
		return $update;
	}


	public function actualizarMasivoMotivoElementoVisibilidad($multiDataRefactorizada)
	{
		$input = [];
		foreach ($multiDataRefactorizada as $value) {
			if (!empty($value['id'])) {
				$input[] = [
					'idEstadoIniciativa' => $value['id']
				];
			}
		}
		if (empty($input)) return true;
		$update =  $this->actualizarMasivo($this->tablas['motivoElementoVisibilidad']['tabla'], $input, $this->tablas['motivoElementoVisibilidad']['id']);

		$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['motivoElementoVisibilidad']['tabla'] ];$this->aSessTrack[] = [ 'idAccion' => 7, 'tabla' => $this->tablas['motivoElementoVisibilidad']['tabla'] ];
		return $update;
	}

	public function guardarMasivoMotivoElementoVisibilidad($multiDataRefactorizada, $idElementoVis)
	{

		//Pasar a la vista
		$new_array = array();
		$repetidos = false;
		foreach($multiDataRefactorizada as $index => $row){
			$new_array[] = $row['elemento_lista'];
			$rs = $this->db->get_where($this->tablas['motivoElementoVisibilidad']['tabla'],array('idElementoVis'=>$idElementoVis,'idEstadoIniciativa'=>$row['elemento_lista']))->row_array();
			if($rs!=null){
				if(count($rs) >=1){
					$repetidos = true;
	
				}
			}
		}
		$elementos =  count($new_array);

		if($elementos > 0){

			if($elementos != count(array_unique($new_array))){
				$repetidos = true;
			}
		}
			
		if($repetidos == false){

			$input = [];
			foreach ($multiDataRefactorizada as $value) {
				if (empty($value['id'])) {
					$input[] = [
						'idElementoVis' => $idElementoVis,
						'idEstadoIniciativa' =>$value['elemento_lista'],
						'estado'=>1
					];
				}
			}
			if (empty($input)) return true;
			$insert = $this->db->insert_batch($this->tablas['motivoElementoVisibilidad']['tabla'], $input);
			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['motivoElementoVisibilidad']['tabla'] ];
		
		}else{
			$insert = 'repetido';
		}
		return $insert;
	}

	

	public function getMotivosElementosIniciativa($post='nulo')
	{
		$filtros = "";
		if ($post == 'nulo') {
			$filtros .= " AND e.estado = 1";
		} else {
			$filtros .= " AND e.estado = 1";
			if (!empty($post['idIniciativa'])) $filtros .= " AND e.idIniciativa = " . $post['idIniciativa'];
			if (!empty($post['idElementoVis'])) $filtros .= " AND e.idElementoVis = " . $post['idElementoVis'];
		}

		$sql = "
			
			SELECT
				e.idEstadoIniciativa 
				, det.nombre
				from  trade.motivoElementoVisibilidadTrad e 
				JOIN trade.estadoIniciativaTrad det ON e.idEstadoIniciativa = det.idEstadoIniciativa
				WHERE 1=1 {$filtros}  
			";
		$this->aSessTrack[] = [ 'idAccion' => 5, 'tabla' => 'trade.motivoElementoVisibilidadTrad', 'id' => null ];
		return $this->db->query($sql);
	}

	public function deleteMasivoIniciativaElementos($params)
	{
		$this->db->where_in($this->tablas['elementoIniciativa']['id'], $params['elementosEliminados']);
		$this->db->where_in($this->tablas['elemento']['id'], $params['idIniciativa']);
		$delete = $this->db->delete($this->tablas['iniciativaTradElemento']['tabla']);
		return $delete;
	}

	public function guardarIniciativaElemento($params)
	{
		$insert=true;
		$rs = $this->db->get_where(
			$this->model->tablas['iniciativaTradElemento']['tabla'],
			array(
			$this->model->tablas['elementoIniciativa']['id']=>$params['idElementoVis'],
			$this->model->tablas['elemento']['id']=>$params['idIniciativa']
			))->row_array();

		if (!empty($rs)) return 'repetido';
	
		
		$input = [
			'idIniciativa' => $params['idIniciativa'],
			'idElementoVis' => $params['idElementoVis'],
			'estado' => 1
		];
		$insert = $this->db->insert($this->tablas['iniciativaTradElemento']['tabla'], $input);
		$this->insertId = $this->db->insert_id();
		
		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['iniciativaTradElemento']['tabla'] ];

		return $insert;
	}


	public function guardarMotivoIniciativaElemento($params)
	{
		$insert=true;
			$input = [];
			$rs = $this->db->get_where(
				$this->model->tablas['motivoElementoVisibilidad']['tabla'],
				array(
				$this->model->tablas['elementoIniciativa']['id']=>$params['idElementoVis'],
				$this->model->tablas['elemento']['id']=>$params['idIniciativa'],
				$this->model->tablas['motivoIniciativa']['id']=>$params['idEstadoIniciativa']
				))->row_array();

			if (!empty($rs)) return 'repetido';
		
			
			$input = [
				'idIniciativa' => $params['idIniciativa'],
				'idElementoVis' => $params['idElementoVis'],
				'idEstadoIniciativa' => $params['idEstadoIniciativa'],
				'estado' => 1
			];
			$insert = $this->db->insert($this->tablas['motivoElementoVisibilidad']['tabla'], $input);
			$this->insertId = $this->db->insert_id();
			
			$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->model->tablas['motivoElementoVisibilidad']['tabla'] ];
		
		return $insert;
	}


	public function deleteMasivoIniciativaElementoMotivo($params)
	{
		$this->db->where_in($this->tablas['motivoIniciativa']['id'], $params['elementosEliminados']);
		$this->db->where_in($this->tablas['elementoIniciativa']['id'], $params['idElementoVis']);
		$this->db->where_in($this->tablas['elemento']['id'], $params['idIniciativa']);

		$delete = $this->db->delete($this->tablas['motivoElementoVisibilidad']['tabla']);
		return $delete;
	}

	public function deleteMasivoIniciativaElementoMotivoPorElementos($params)
	{
		$this->db->where_in($this->tablas['elementoIniciativa']['id'], $params['elementosEliminados']);
		$this->db->where_in($this->tablas['elemento']['id'], $params['idIniciativa']);

		$delete = $this->db->delete($this->tablas['motivoElementoVisibilidad']['tabla']);
		return $delete;
	}





	public function obtener_estado_carga(){
		$sql =" 
			SELECT 
					*
				, convert(varchar,fecIni,103) fecI
				, convert(varchar,fecFin,103) fecF
				, convert(varchar,fechaRegistro,103) fecRegistro
				, convert(varchar,fechaRegistro,108) horaRegistro 
				, convert(varchar,finRegistro,108) horaFin
				, (SELECT COUNT(*) FROM  trade.cargaIniciativaNoProcesados WHERE idCarga=cm.idCarga  ) noProcesados
				,(
					SELECT count(*) FROM trade.cargaIniciativaNoProcesados WHERE idCarga=cm.idCarga
				) error
			FROM 
				trade.cargaIniciativa cm
				order by cm.idCarga DESC

		";
		return $this->db->query($sql)->result_array();
	}

	////ERRORES
	public function obtener_iniciativas_no_procesado($id){
		$sql="SELECT * FROM trade.cargaIniciativaNoProcesados where idCarga= $id";
		return $this->db->query($sql)->result_array();
	}

	public function registrarIniciativa_HT($post)
	{
		$insert = [
			'nombre' => trim($post['iniciativa']),
			'descripcion' => trim($post['descripcion']),
			'fecIni' =>trim($post['fechaInicio']),
		];
		if(!empty($post['fechaFin'])){$insert['fecFin']=$post['fechaFin'];}
		if(!empty($post['idCuenta'])){$insert['idCuenta']=$post['idCuenta'];}

		$insert = $this->db->insert($this->tablas['elemento']['tabla'], $insert);
		$this->insertId = $this->db->insert_id();

		$this->aSessTrack[] = [ 'idAccion' => 6, 'tabla' => $this->tablas['elemento']['tabla'], 'id' => $this->insertId ];
		return $insert;
	}

}
