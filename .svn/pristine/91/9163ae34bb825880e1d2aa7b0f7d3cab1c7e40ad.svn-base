<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlFoto extends MY_Controller{

	public function __construct(){
		parent::__construct();
    }

    public function index()
    {
        print_r('hola');
    }
    
    public function obtener_foto($foto){
        header('Content-Type: image/jpg');
        readfile(RUTA_MOVIL_FOTOS.$foto);
    
    }
	
	public function obtener_carpeta_foto($carpeta,$foto){
        header('Content-Type: image/jpg');
        // $ruta = "http://movil.visualimpact.com.pe/fotos/impactTrade/".$carpeta."/".$foto;

        // $carpeta = 'checklist';
        // $foto = '188767207420200930172746_102_CHECKLIST.jpg';

        // echo($ruta);
        // exit();
        readfile(RUTA_MOVIL_FOTOS.$carpeta.'/'.$foto.'');
        // readfile(obtener_url_sistema().'/fotos/impactTrade_android/'.$carpeta.'/'.$foto.'');
        // readfile('http://movil.visualimpact.com.pe/fotos/impactTrade_android/checklist/188767207420200930172746_102_CHECKLIST.jpg');
    }
 
	public function obtener_carpeta_foto_v2($foto){
        header('Content-Type: image/jpg');
        // $ruta = "http://movil.visualimpact.com.pe/fotos/impactTrade/".$carpeta."/".$foto;
        // $carpeta = 'checklist';
        // $foto = '188767207420200930172746_102_CHECKLIST.jpg';
        $carpetas = ["accionesCotingencia/","asistencia/","checklist/","checklistExhibiciones/","despachos/","encartes/","encuestas/","encuestasPremio/","exhibicion/","incidencias/","iniciativa/","inteligencia/","ipp/","moduloFotos/","orden/","promociones/","prospeccion/","reprogramaciones/","seguimientoPlan/","sod/","sos/","surtido/","visibilidad/","visibilidadAuditoria/"];
        foreach ($carpetas as $v) {
            $url = 'http://movil.visualimpact.com.pe/fotos/impactTrade_android/'.$v.$foto.'';
            if(getimagesize($url) !== false){
                break;
            }
        }
        echo $url;
        // readfile($url);
        
    
    }
}