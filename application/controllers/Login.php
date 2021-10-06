<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_Login','model');
	}
	
	public function index()
	{
		$config['css']['style']=array();
		$config['js']['script']=array('assets/custom/js/login');
		$config['single'] = true;
		$this->view($config);
	}
	
	public function acceder(){
		$data = json_decode($this->input->post('data'));

		$captcha = $this->validar_captcha_v2($data->{'g-recaptcha-response'});
		if(!$captcha->{'success'}){
			$result['result'] = 0;
			$config_ = array( 'type' => 2, 'message' => "Debe completar el captcha");
			$result['msg']['content'] = createMessage($config_);
			goto responder;
		}

		$input = array(
			'usuario' => $data->user,
			'clave' => $data->password
		);
		$result = $this->result;
		$result['status'] = 0;

		$rs = $this->model->find_usuario($input);
		$this->aSessTrack[] = [ 'idAccion' => 1 ];

		$config_ = array( 'type' => 2, 'message' => "Ocurrió un error al validar sus datos, vuelva a intentarlo" );
		if( !$rs ){
			$result['msg']['content'] = createMessage($config_);
		}else{
			$num_rows = count($rs->result_array());
			$config_ = array( 'type' => 2, 'message' => "Los datos ingresados no permiten el acceso");

			if( $num_rows == 0 ){
				$result['msg']['content'] = createMessage($config_);

				$verifUsuario = $this->model->verificar_usuario($input);

				$this->db->trans_start();
				//Guardar Intentos fallidos
				$this->model->registrar_intentos($input);

				if(!empty($verifUsuario)){
					if($verifUsuario['intentos'] <= 2){
						$this->model->actualizar_intentos($verifUsuario);
						$config_ = array( 'type' => 2, 'message' => "La clave ingresada no es la correcta. Le quedan ".(2-$verifUsuario['intentos'])." intentos");
						$result['msg']['content'] = createMessage($config_);
					}else{
						$this->db->trans_rollback();

						$result['status'] = 3;

						$correo = empty($verifUsuario['email_corp']) ? $verifUsuario['email'] : $verifUsuario['email_corp'];
						$correo_oculto = ocultarEmail($correo);
						$result['correo'] = $correo;

						$config_ = array( 'type' => 2, 'message' => "Excedió el limite de intentos de ingreso permitidos. Por seguridad se ha desactivado su usuario. Puede enviar un enlace de recuperación al siguiente correo asociado a su usuario: <strong>".$correo_oculto."</strong>");
						$result['msg']['content'] = createMessage($config_);
					}
				}
			}else{
				$result['status'] = 1;
				
				$aPermisos = $this->crearPermisos($rs->result_array());
				$usuario = $rs->row_array();
				$menu = $this->model->find_menu($usuario)->result_array();
				$config_ = array( 'type' => 2, 'message' => 'Usted no tiene permisos asignados, comuniquese con el administrador' );
				if( count($menu) < 1 ){
					$result['msg']['content'] = createMessage($config_);
				}else{
					$result['result'] = 1;
					$result['url'] = 'home/';
					$result['msg']['title'] = "Login";
					$config_ = array( 'type' => 1, 'message' => "Bienvenido al sistema <strong>".$usuario['apeNom']."</strong>");
					$result['msg']['content'] = createMessage($config_);

					$sessionId = $usuario['idUsuario']."-".session_id();
					$this->session->set_userdata('sessionId', $sessionId);
					$this->aSessTrack[] = [ 'idAccion' => 2 ];

					$this->model->actualizar_intentos($usuario);
					if(empty($usuario['ultimo_cambio_pwd'])){
						//PRIMERA VEZ
						$result['result'] = 0;
						$result['url'] = 'recover/reestablecerClaveNoNav';
						$config_ = array( 'type' => 1, 'message' => "Bienvenido al sistema <strong>".$usuario['apeNom']."</strong>, debido a las nuevas políticas de seguridad debe cambiar su contraseña para poder continuar");
						$result['msg']['content'] = createMessage($config_);
						$this->session->set_userdata($usuario);
						goto responder;
					}else if($usuario['dias_pasados'] > 90){
						//VERIFICAR 90 DIAS
						$result['result'] = 0;
						$result['url'] = 'recover/reestablecerClaveNoNav';
						$config_ = array( 'type' => 1, 'message' => "Bienvenido al sistema <strong>".$usuario['apeNom']."</strong>, debido a las nuevas políticas de seguridad debe cambiar su contraseña cada 90 dias para poder continuar");
						$result['msg']['content'] = createMessage($config_);
						$this->session->set_userdata($usuario);
						goto responder;
					}else{
						$result['data']['flag_anuncio_visto'] = $usuario['flag_anuncio_visto'];
						$usuario['menu'] = $menu;
						$usuario['permisos'] = $aPermisos;

						if( count($aPermisos['cuenta']) > 1 ){
							$usuario['idCuenta'] = '';
							$usuario['idProyecto'] = '';
						}
						elseif( count($aPermisos['proyecto']) > 1 ){
							$usuario['idProyecto'] = '';
						}

						$this->session->set_userdata($usuario);
					}

					$qp = $this->model->navbar_permiso($usuario['idUsuario'])->result_array();
					
					$navbar_permiso['pages'] = array();
					foreach($qp as $index => $value){
						$navbar_permiso['pages'][$index] = $value['page']; 
					}

					$this->session->set_userdata($navbar_permiso);
					$this->session->set_userdata('anuncioVisto', 0);
				}

			}
		}
		$this->db->trans_complete();
		responder:
		echo json_encode($result);
	}

	public function crearPermisos($acceso){
		$aCuenta = array();
		$aCuentaProyecto = array();
		$aProyecto = array();
		$aGrupoCanal = array();
		$aCanal = array();
		$aSubCanal = array();
		$aZona = array();
		$aPlaza = array();
		$aDistribuidora = array();
		$aDistribuidoraSucursal = array();
		$aCadena = array();
		$aBanner = array();

		foreach($acceso as $row){
			// CUENTA
			if( !empty($row['idCuenta']) ){
				if( !in_array($row['idCuenta'], $aCuenta) ){
					array_push($aCuenta, $row['idCuenta']);
				}
			}

			// PROYECTO
			if( !empty($row['idProyecto']) ){
				if( !in_array($row['idProyecto'], $aProyecto) ){
					array_push($aProyecto, $row['idProyecto']);
				}

				if( empty($aCuentaProyecto[$row['idCuenta']]) ) $aCuentaProyecto[$row['idCuenta']] = [];

				if( !in_array($row['idProyecto'], $aCuentaProyecto[$row['idCuenta']]) ){
					array_push($aCuentaProyecto[$row['idCuenta']], $row['idProyecto']);
				}
			}

			// GRUPO CANAL
			if( !empty($row['idGrupoCanal']) ){
				if( !isset($aGrupoCanal[$row['idProyecto']]) ){
					$aGrupoCanal[$row['idProyecto']] = array();
				}

				if( !in_array($row['idGrupoCanal'], $aGrupoCanal[$row['idProyecto']]) ){
					array_push($aGrupoCanal[$row['idProyecto']], $row['idGrupoCanal']);
				}

				// CANAL
				if( !empty($row['idCanal']) ){
					if( !isset($aCanal[$row['idProyecto']][$row['idGrupoCanal']]) ){
						$aCanal[$row['idProyecto']][$row['idGrupoCanal']] = array();
					}

					if( !in_array($row['idCanal'], $aCanal[$row['idProyecto']][$row['idGrupoCanal']]) ){
						array_push($aCanal[$row['idProyecto']][$row['idGrupoCanal']], $row['idCanal']);
					}

					// SUB CANAL
					if( !empty($row['idSubCanal']) ){
						if( !isset($aSubCanal[$row['idProyecto']][$row['idGrupoCanal']][$row['idCanal']]) ){
							$aSubCanal[$row['idProyecto']][$row['idGrupoCanal']][$row['idCanal']] = array();
						}

						if( !in_array($row['idSubCanal'], $aSubCanal[$row['idProyecto']][$row['idGrupoCanal']][$row['idCanal']]) ){
							array_push($aSubCanal[$row['idProyecto']][$row['idGrupoCanal']][$row['idCanal']], $row['idSubCanal']);
						}
					}
				}
			}

			// ZONA
			if( !empty($row['idZona']) ){
				if( !isset($aZona[$row['idProyecto']]) ){
					$aZona[$row['idProyecto']] = array();
				}

				if( !in_array($row['idZona'], $aZona[$row['idProyecto']]) ){
					array_push($aZona[$row['idProyecto']], $row['idZona']);
				}
			}

			// PLAZA
			if( !empty($row['idPlaza']) ){
				if( !isset($aPlaza[$row['idProyecto']]) ){
					$aPlaza[$row['idProyecto']] = array();
				}

				if( !in_array($row['idPlaza'], $aPlaza[$row['idProyecto']]) ){
					array_push($aPlaza[$row['idProyecto']], $row['idPlaza']);
				}
			}

			// DISTRIBUIDORA
			if( !empty($row['idDistribuidora']) ){
				if( !isset($aDistribuidora[$row['idProyecto']]) ){
					$aDistribuidora[$row['idProyecto']] = array();
				}

				if( !in_array($row['idDistribuidora'], $aDistribuidora[$row['idProyecto']]) ){
					array_push($aDistribuidora[$row['idProyecto']], $row['idDistribuidora']);
				}

				// DISTRIBUIDORA SUCURSAL
				if( !empty($row['idDistribuidoraSucursal']) ){
					if( !isset($aDistribuidoraSucursal[$row['idProyecto']][$row['idDistribuidora']]) ){
						$aDistribuidoraSucursal[$row['idProyecto']][$row['idDistribuidora']] = array();
					}

					if( !in_array($row['idDistribuidoraSucursal'], $aDistribuidoraSucursal[$row['idProyecto']][$row['idDistribuidora']]) ){
						array_push($aDistribuidoraSucursal[$row['idProyecto']][$row['idDistribuidora']], $row['idDistribuidoraSucursal']);
					}
				}
			}

			// CADENA
			if( !empty($row['idCadena']) ){
				if( !isset($aCadena[$row['idProyecto']]) ){
					$aCadena[$row['idProyecto']] = array();
				}

				if( !in_array($row['idCadena'], $aCadena[$row['idProyecto']]) ){
					array_push($aCadena[$row['idProyecto']], $row['idCadena']);
				}

				// BANNER
				if( !empty($row['idBanner']) ){
					if( !isset($aBanner[$row['idProyecto']][$row['idCadena']]) ){
						$aBanner[$row['idProyecto']][$row['idCadena']] = array();
					}

					if( !in_array($row['idBanner'], $aBanner[$row['idProyecto']][$row['idCadena']]) ){
						array_push($aBanner[$row['idProyecto']][$row['idCadena']], $row['idBanner']);
					}
				}
			}

			// array_push($aPermisos, $permisos);
		}

		$aPermisos = array(
				'cuenta' => $aCuenta,
				'cuentaProyecto' => $aCuentaProyecto,
				'proyecto' => $aProyecto,
				'grupoCanal' => $aGrupoCanal,
				'canal' => $aCanal,
				'subCanal' => $aSubCanal,
				'zona' => $aZona,
				'plaza' => $aPlaza,
				'distribuidora' => $aDistribuidora,
				'distribuidoraSucursal' => $aDistribuidoraSucursal,
				'cadena' => $aCadena,
				'banner' => $aBanner
			);

		return $aPermisos;
	}

	public function validar_captcha_v3($post){
		define("RECAPTCHA_V3_SECRET_KEY", '6Le7INUaAAAAAEsBU33EfPneKHjz5OTSUHVRORdi');

		$token = $post->{'token'};
		$action = $post->{'action'};
		
		// call curl to POST request
		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
		// curl_setopt($ch, CURLOPT_POST, 1);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// $response = curl_exec($ch);
		// curl_close($ch);
		// $arrResponse = json_decode($response, true);
		
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_V3_SECRET_KEY."&response={$token}"); 
		$response = json_decode($response);

		$arrResponse = (array) $response;
		// verificar la respuesta
		if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
			// Si entra aqui, es un humano, puedes procesar el formulario
			$msj =  1;
		} else {
			// Si entra aqui, es un robot....
			$msj =  0;
		}

		return $msj;
	}

	function validar_captcha_v2($user_response) {

		if(!empty($user_response)){
			$secret = '6LdAotoaAAAAAONJyJaNn-SQS5wfVkQwfvyvQEe2';
			$ip = $_SERVER['REMOTE_ADDR'];

			$validation = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$user_response&remoteip=$ip");

			return json_decode($validation);
		}else {
			return (object)['success'=>0];
		}
    }



}
