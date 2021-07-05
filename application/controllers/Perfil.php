<?php
/* ================================================================================================================
 *  @Filename:  Controllers/Actividades.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  06-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('model_catalogos');
        $this->load->model('model_usuarios');
        
        if ( ! $this->session->estatus_usuario_sesion() ){
            print(json_encode(array('estatus' => 'sess_expired', 'mensaje' => 'Su sesión ha caducado. Por favor, recargue la página.')));
            redirect(base_url('index.php/Home/login'),'refresh');
        }
    }

/*--------------------------------------------------------------------------*
* ---- VISTAS 
* --------------------------------------------------*/

    public function index()
    {
        $mi_usuario = array('usuario_id' => $this->session->userdata('uid'));
        $data = array(
            'titulo'        => 'Mi Perfil | ' . APLICACION,
            'menu'          => $this->model_catalogos->get_menus(),
            'usuario'       => $this->model_usuarios->get_usuarios($mi_usuario),
            'view'          => 'perfil/perfil'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
    }

/*--------------------------------------------------------------------------*
* ---- FUNCIONES AJAX 
* --------------------------------------------------*/
    
    // -------------- VISTAS
    public function guardar_datos_perfil(){
        $json = array('exito' => TRUE);

        $datos = $this->input->post('datos');

        if ( is_array($datos) ){
            $respuesta = $this->model_usuarios->set_datos_usuario( $this->session->userdata('uid'), $datos);
            $json['exito'] = $respuesta['exito'];

            if ( isset($respuesta['error']) )
                $json['error'] = $respuesta['error'];
        }        
        return print(json_encode( $json ));
    }

    public function cambiar_password(){
        $json = array('exito' => TRUE);
        $password   = $this->input->post('actual');
        $nueva      = $this->input->post('nueva');

        $db_usuario = $this->model_usuarios->get_usuarios( array(
            'usuario_id' => $this->session->userdata('uid'), 'estatus' => 1 ) );
        if ( $db_usuario ){
            if ( password_verify( $password, $db_usuario->contrasena ) ){
                $respuesta = $this->model_usuarios->set_nueva_password( $this->session->userdata('uid'), $nueva );
                $json['exito'] = $respuesta['exito'];
                
                if ( isset($respuesta['error']) )
                    $json['error'] = $respuesta['error'];
            } else {
                $json['exito'] = FALSE;
                $json['error'] = 'Contraseña incorrecta.';
            }
        } else 
            $json['error'] = 'Usuario inválido. Por favor, recargue la página.';
        return print(json_encode( $json ));
    }

}

/* End of file Perfil.php */
/* Location: ./application/controllers/Perfil.php */