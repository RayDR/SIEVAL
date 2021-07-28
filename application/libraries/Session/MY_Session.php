<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Session extends CI_Session
{
    protected $ci;
    /**
    | Contiene usuario_id activo
    | @var  int
    */
    protected $s_usuario;
    /**
    | Intentos de conexión fallidas
    | @var  int
    */
    protected $s_icon_fallida = array();
    
    public function __construct(array $params = array())
    {
        parent::__construct();
        $this->ci=& get_instance();
        $this->ci->load->model('model_usuarios');

        log_message('debug', "Librería de Sesión inicializada.");
    }
    
    public function establecer_sesion( $datos = array() ){
        $exito = TRUE;      
        // Eliminar intentos
        $this->var_sesion( 'intentos', FALSE );
        if ( $datos ){ 
            // Almacenar las variables enviadas
            $datos_usuario = array(
                'uid'               => $datos->usuario_id,
                'ulogin'            => TRUE,
                'usuario'           => $datos->usuario,
                'tuser'             => $datos->tipo_usuario_id,
                'sexo'              => $datos->sexo,
                'nombres'           => $datos->nombres,
                'primer_apellido'   => $datos->primer_apellido,
                'combinacion_area'  => $datos->combinacion_area_usuario_id
            );
            $this->var_sesion( $datos_usuario );
        }
        // Doble verificación de estatus de usuario
        $exito = $this->estatus_usuario_sesion();      

        return $exito; 
    }

    /**
    | Consulta el estatus del usuario (Estatus en BD y Conexión Local)
    | @return   bool
    **/
    public function estatus_usuario_sesion(){
        $sesion_activa = FALSE;
        if ( $this->has_userdata('uid') && $this->has_userdata('ulogin') )
            $sesion_activa = $this->userdata('ulogin'); // Validación del ulogin

        if ( $sesion_activa ){
            $usuario        = array('usuario_id' => $this->userdata('uid'));
            $estatus_usr    = $this->ci->model_usuarios->get_usuarios($usuario);
            if ( $estatus_usr ){
                if ( $estatus_usr->estatus == 1 ){
                    $sesion_activa = TRUE;
                    $datos_usuario = array(
                        'ulogin'            => $sesion_activa,
                        'usuario'           => $estatus_usr->usuario,
                        'tuser'             => $estatus_usr->tipo_usuario_id,
                        'sexo'              => $estatus_usr->sexo,
                        'nombres'           => $estatus_usr->nombres,
                        'primer_apellido'   => $estatus_usr->primer_apellido,
                        'combinacion_area'  => $estatus_usr->combinacion_area_usuario_id
                    );
                    $this->var_sesion( $datos_usuario );
                } else 
                    $sesion_activa = FALSE;
            } else 
                $sesion_activa = FALSE;
        }

        $this->var_sesion(['ulogin' => $sesion_activa]);
        return $sesion_activa;
    }

    /**
    | Establece/Elimina variables de sesión
    |
    | @param    mixed   $variables  Variable o arreglo de variables de sesión
    | @param    bool    $modo       Establecer(True)/Eliminar(False)
    | @return   void
    **/
    private function var_sesion($variables, $modo = TRUE){
        if ( $modo )
            $this->set_userdata( $variables );
        else
            $this->unset_userdata( $variables );
    }

}

/* End of file MY_Session.php */
/* Location: ./application/libraries/Session/MY_Session.php */
