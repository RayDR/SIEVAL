<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acuerdos extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('model_catalogos');
        $this->load->model('model_acuerdos');
    }


/*
|--------------------------------------------------------------------------
| VISTAS 
|--------------------------------------------------------------------------
*/

	public function index()
	{
		$data = array(
            'titulo'    => 'Acuerdos ' . APLICACION  . ' | ' . EMPRESA,
            'menu'      => $this->model_catalogos->get_menus(),
            'view'      => 'acuerdos/index'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
	}

    public function registrar()
    {
        $json = array('exito' => TRUE);
        $data = array(
            'titulo'    =>  'Registrar',
            'areas'     =>  $this->model_catalogos->get_areas(),
            'view'      => 'acuerdos/registrar'
        );
        $json['html'] = $this->load->view( $data['view'], $data, TRUE );
        return print(json_encode($json));
    }

/*
|--------------------------------------------------------------------------
| AJAX 
|--------------------------------------------------------------------------
*/
    
    // -------------- VISTAS


    // -------------- DATOS

    public function datatable_acuerdos(){
        return print(json_encode( $this->model_acuerdos->get_acuerdos_master() ));
    }

    public function registrar_acuerdo(){
        $json           = array('exito' => TRUE);

        $area_origen    = $this->input->post('area_origen');
        $area_destino   = $this->input->post('area_destino');
        $acuerdos       = $this->input->post('acuerdos');

        if ( ! $area_origen || ! $area_destino || ! $acuerdos ){
            $json['exito']   = FALSE;
            $json['mensaje'] = 'Falló al recibir los datos del acuerdo';
        } else {
            if ( is_string($area_destino) ){                
                $datos_acuerdo  = array(
                    'area_origen'   => explode(',', $area_origen),
                    'area_destino'  => explode(',', $area_destino),
                    'acuerdos'      => $acuerdos,
                    'ejercicio'     => 2021,
                    'usuario_id'    => 1
                );
                $resultado     = $this->model_acuerdos->set_nuevo_acuerdo($datos_acuerdo);
                $json['exito'] = $resultado['exito'];
                if ( $json['exito'] == FALSE )
                    $json['mensaje'] = $resultado['error'];
            } else {
                $json['exito']   = FALSE;
                $json['mensaje'] = 'Configuración incorrecta en <b>Área a Turnar</b>.';
            }
        }

        return print(json_encode($json));
    }

}

/* End of file Acuerdos.php */
/* Location: ./application/controllers/Acuerdos.php */