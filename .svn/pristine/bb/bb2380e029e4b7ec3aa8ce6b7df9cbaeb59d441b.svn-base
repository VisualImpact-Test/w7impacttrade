<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adt_pdf extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_adt_pdf', 'model');
	}
	
	public function auditoria_pdf(){
            $data = json_decode($this->input->post('data'), true);

            $filas_a_recorrer=0;

            if(isset($data['idAuditoria'])){
                $params = array();
                foreach ($data['idAuditoria'] as $row=>$value) {
                    $live_auditoria = $this->model->getIdTienda($value)->row();
                    $params['idAuditoria'.$filas_a_recorrer] =  $live_auditoria->idAuditoria;
                    $params['idTienda'.$filas_a_recorrer] = $live_auditoria->idCliente;
                   
                    $filas_a_recorrer++;
                }
            }
            else if(isset($data['idTienda']) ){
                $params = array();
                foreach ($data['idTienda'] as $row=>$value) {
                    $audt = $this->model->getIdLastAuditoria($value)->row();
                    $params['idAuditoria'.$filas_a_recorrer] = $audt->idAuditoria;
                    $params['idTienda'.$filas_a_recorrer] = $audt->idCliente;
                    
                    $filas_a_recorrer++;
                }
            }
          
		$style="
		<style>
				.head {
					background-color:#1370C5;
					padding: 5px;
					font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
					font-size: 15px;
                    width: 100%;
				}
				table{width: 100%;}
				.title { font-weight: bold; color: #FFFFFF !important; text-align: center; }
				img.foto{ border: 0.3em solid #0E7BEF; margin: 0.5em;}
				.subtitle { font-weight: bold; color: #FFFFFF !important; text-align: center; }
				img.foto{ border: 0.3em solid #0E7BEF; margin: 0.5em;font-size: 10px;}
				.item { 
					text-align: center;
					font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
					font-size: 12px;
                }
                .thead{
                    background-color:#002856;
                    color:white;
                }
                .center{
                    text-align:center;
                }
                .tabla_{
                    font-size:12px;
                }
               
		</style>
        ";

		require APPPATH . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
        $newPage = 0;

		$mpdf->imageVars['none'] = file_get_contents(FCPATH.'public/assets/images/iconos/none.png');
		$mpdf->imageVars['star'] = file_get_contents(FCPATH.'public/assets/images/iconos/star.png');
		$mpdf->imageVars['star_gray'] = file_get_contents(FCPATH.'public/assets/images/iconos/star_gray.png');

        for ($y=0; $y < $filas_a_recorrer ; $y++) { 

            $infoVisita = $this->model->getInfoVisita($params['idTienda'.$y],$params['idAuditoria'.$y])->row();
            $infoTienda = $this->model->getInfoTienda($params['idTienda'.$y])->result();
            $infoLastVisita = $this->model->getInfoLastVisita($params['idTienda'.$y],$params['idAuditoria'.$y])->row();
            $audt = $this->model->getInfoAuditoria($params['idAuditoria'.$y])->result();
            $catAudt = $this->model->getCategoriaByAuditoria($params['idAuditoria'.$y])->result();
            $compAudt = $this->model->getCompetenciaAuditoria($params['idAuditoria'.$y])->result();
            $competencias = '-';

			$idCuenta = $this->model->getCuentaCliente($params['idAuditoria'.$y]);
			$catEval =  $this->model->getTipoEvaluacion($idCuenta)->result();

            if(count($compAudt) >= 1){
                $competencias = '';

                foreach($compAudt as $comp){
                    $competencias = $competencias." / ".$comp->nombre;
                }
            }

            $html ='';

            $html .= '<div style="margin-left:80%";>
            <p style="font-size:10px">Nota Auditoria: '.number_format($infoVisita->nota, 2).'%</p>
            <p style="font-size:10px">Nota Anterior: '.(!empty($infoLastVisita->nota) ? number_format($infoLastVisita->nota, 2).'%' : '-').'</p>
            </div>';
			$html .= '
			<table class="head">';
				$html .= '<tr>';
					$html .= '<td class="title" style:"background-color: #002856" >LIVE STORECHECK</td>';
				$html .= '</tr>';
			$html .= '</table><br>';
			
			$html .= '<table class="head">';
				$html .= '<tr>';
					$html .= '<td class="title">Información de Tienda - <span style="text-transform: uppercase;">'.$infoVisita->razonSocial.'</span></td>';
				$html .= '</tr>';
			
			$html .= '</table><br>';
			$html .= '<div style="float:left;margin-right:30%">';
				$html .= "<label><p>Nombre: <b>".$infoVisita->razonSocial."</b></p></label>";

				$arr_infoTienda = array();
				foreach($infoTienda as $infotienda_){
					
					$arr_infoTienda[$infotienda_->idInfo] = $infotienda_->valor;

				}
				$html .= "<label><p>"."OSA Tienda".": <b>".(isset($arr_infoTienda['1'])?$arr_infoTienda['1']:' - ')."</b></p></label>";
				$html .= "<label><p>"."Avance/Proyeccion de Ventas".": <b>".(isset($arr_infoTienda['2'])?$arr_infoTienda['2']:' - ')."/".(isset($arr_infoTienda['3'])?$arr_infoTienda['3']:' - ')."</b></p></label>";
				$html .= "<label><p>"."Objetivo de Venta".": <b>".(isset($arr_infoTienda['4'])?$arr_infoTienda['4']:' - ')."</b></p></label>";
				$html .= "<label><p>"."R. HSM ".": <b>".(isset($arr_infoTienda['5'])?$arr_infoTienda['5']:' - ')."</b></p></label>";
				$html .= "<label><p>"."R. Cadena ".": <b>".(isset($arr_infoTienda['6'])?$arr_infoTienda['6']:' - ')."</b></p></label>";
				
			$html .= '</div>';
			$html .= '<div>';
		 
					$html .= "<label><p>"."NOS ".": ".(isset($arr_infoTienda['7'])?$arr_infoTienda['7']:' - ')."</b></p></label>";
					$html .= "<label><p>"."Perfect Store ".": <b>".(isset($arr_infoTienda['8'])?$arr_infoTienda['8']:' - ')."</b></p></label>";
					$html .= "<label><p>"."Principales Competidores ".": <b>".$competencias."</b></p></label>";
				$html .= '</div>';
		 
			foreach($catAudt as $categoria){
				$html .='<div id="Categoria_adt" style="float:left; width:100%;page-break-inside: avoid"><br>';
					$html .= '<div  style="float:left; width:100%;page-break-inside: avoid">';
						$html .= '<table class="head" style="page-break-inside: avoid">';
							$html .= '<tr>';
								$html .= '<td class="title" >Presentación  - '.$categoria->nombre.'</td>';
							$html .= '</tr>';
						$html .= '</table>';

						foreach ($catEval as $categoriaEval) {
							$html .= '<div style="float:left; width:31%"><br>';
								$html .= '<table class="" style="font-size:10px;page-break-inside: avoid">';
									$html .= '<tr style="height:100px;  ">';
										$fotoEval = $this->model->getFotoEval($params['idAuditoria'.$y],$categoria->idCategoria,$categoriaEval->idEvaluacion)->result();
										$padd_foto = '';
										$size_foto = '45px'; 

										$html.="<td style='width:50%'>";
											$none_image = " <img src='var:none' height='".$size_foto."'> " ;
											$none_image_min = " <img src='var:none' height='25px'> " ;
											$ft= 1;
											foreach ($fotoEval as $foto) {
												$mpdf->imageVars['auditoria_'.$foto->idAuditoriaFoto] = file_get_contents(FCPATH.'../_archivos/pg/livestorecheck/'.$foto->idAuditoriaFoto.'.png');
												$html.="<a ".$padd_foto." href='../_archivos/pg/livestorecheck/".$foto->idAuditoriaFoto."' target='_blank'> 
												<img src='var:auditoria_{$foto->idAuditoriaFoto}' height='".$size_foto."'>
												</a>";
												$ft++;
											}

											if(count($fotoEval) == 5){ "" ;}
											elseif(count($fotoEval) == 4){"";}
											elseif(count($fotoEval) == 3){$html.=
												$none_image.
												$none_image;}
											elseif(count($fotoEval) == 2){$html.=
												$none_image.
												$none_image.
												$none_image;}
											
											elseif(count($fotoEval) == 1){$html.=
												$none_image.
												$none_image.
												$none_image.
												$none_image;}
											elseif(count($fotoEval) == 0){$html.=
												$none_image.
												" <h4 style='color:red'>No hay fotos que mostrar</h4><br>".
											   $none_image_min
											   ;}
										$html .="</td>";
										

									$html .= '</tr><br>';
									$html .= '<tr>';
										$html .= '<td class="" style="font-size:20px;width:35%" >Evaluación - '.$categoriaEval->nombre.'</td>';
									$html .= '</tr><br>';
									
										$star="";
									$extra_stars='';
									foreach($audt as $auditoria){
											if($categoriaEval->idEvaluacion == $auditoria->catEval && $auditoria->idCat == $categoria->idCategoria){
												$html .="<tr>
													<td style='width:25%;'>".$auditoria->evaluacion_nombre."</td>
													";
												
													if(isset($auditoria->comentario)){
														$html.="
															<td style='width:15%;'>".$auditoria->comentario."</td>
														";
													}else{
														$html.="
														<td style='width:15%;text-align:center'></td>
													";
													}
												
													for ($i=0; $i<$auditoria->estrellas  ; $i++) { 
														$star .= "<img src='var:star' height='10px'>";
													}
													for ($e=$auditoria->estrellas; $e <=4 ; $e++) { 
														$extra_stars .= "<img src='var:star_gray' height='10px'>";
													}
													if($auditoria->estrellas == 0){$extra_stars = number_format($auditoria->nota_eval,2)."%";}
																$html.="
																<td style='color:red;width:30%'>".$star."<label style='color:black'>".$extra_stars."</label></td>
															</tr>";
											}
											$star="";
											$extra_stars='';
									}
								$html .= '</table><br>';
							$html.= '</div>';
						}
					$html.= '</div>';
				$html .='<div>';
			};

				$mpdf->setFooter('{PAGENO}');
				$mpdf->AddPage();
				$mpdf->WriteHTML($style);
				$mpdf->WriteHTML($html);
		}

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		$mpdf->Output('LiveStorecheck.pdf', \Mpdf\Output\Destination::DOWNLOAD);
	}

}
