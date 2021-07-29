<?php
/* ================================================================================================================
 *  @Filename:  Models/Model_usuarios.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  07-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_usuarios extends CI_Model {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_actividades');
        $this->load->model('model_usuarios');
        $this->load->model('model_catalogos');
        $this->load->model('model_proyectos');       
    }
    

    /**
        * Obtener el listado de usuarios
        *
        * @access public
        * @param  array   $filtros          filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return usuarios
    */
    public function get_usuarios($filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            } else 
                $this->db->where('estatus', 1);

            $usuarios = $this->db->get('vw_usuarios');

            if ( $usuarios->num_rows() > 1 ){
                if ( $tipo_retorno )
                    return $usuarios->result();
                else
                    return $usuarios->result_array();
            }
            else {
                if ( $tipo_retorno )
                    return $usuarios->row();
                else
                    return $usuarios->row_array();
            }
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener usuario por id
        *
        * @access public
        * @param  integer $usuario_id       ID
        * @param  array   $filtros          filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return usuarios
    */
    public function get_usuario($usuario_id, $filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            } else 
                $this->db->where('estatus', 1);            
            
            $this->db->where('usuario_id', $usuario_id);            
            $usuarios = $this->db->get('vw_usuarios');

            if ( $tipo_retorno )
                return $usuarios->row();
            else
                return $usuarios->row_array();
        } catch (Exception $e) {
            return [];
        }
    }

    // ------------------------- SETTERS

    /**
        * Crear usuario
        *
        * @access public
        * @param  string   $datos        Datos del usuario
        * @return resultado
    */
    public function set_usuario($datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin(); 

            if ( !is_array($datos) )
                throw new Exception("No se recibieron datos");

            // Buscar si el usuario ya existe
            if ( !isset($datos['usuario']) )
                throw new Exception("Se requiere ingresar un número de cuenta válido.", 1);
                
            $this->db->where('usuario', $datos['usuario']);
            $_db_usuario = $this->db->get('usuarios')->row();
            if ( $_db_usuario )
                throw new Exception("Este número de cuenta ya se encuentra registrado.", 1);
            if ( !isset($datos['correo']) )
                throw new Exception("Un correo electrónico válido es requerido para la creación de la cuenta.", 1);
            
            // Buscar si el correo ya esta asociado a una cuenta
            $this->db->where('correo', $datos['correo']);
            $_db_usuario = $this->db->get('usuarios')->row();
            if ( $_db_usuario )
                throw new Exception("Este correo electrónico ya se encuentra ligado a otro número de cuenta.", 1);

            // Realizar la inserción
            $db_datos = array(
                'combinacion_area_id'=> $datos['area_usuaria'],
                'sexo'               => $datos['sexo'],
                'nombres'            => $datos['nombres'],
                'primer_apellido'    => $datos['primer_apellido'],
                'segundo_apellido'   => $datos['segundo_apellido'],
                'correo'             => $datos['correo'],
                'telefono'           => $datos['telefono'],
                'usuario'            => $datos['usuario'],
                'cve_cuenta'         => $datos['cve_cuenta'],
                'categoria_id'       => $datos['categoria'],
                'contrasena'         => password_hash($datos['password'], PASSWORD_DEFAULT),
                'tipo_usuario_id'    => 3,
            );

            $this->db->insert('usuarios', $db_datos);
            $usuario_id = $this->db->insert_id();

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e->getMessage();
        }
        return $resultado;
    }

    /**
        * Actualizar datos del usuario
        *
        * @access public
        * @param  string   $usuario_id      ID de usuario a actualizar
        * @param  string   $password        Contraseña a establecer
        * @return resultado
    */
    public function set_datos_usuario($usuario_id, $datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin(); 

            if ( !is_array($datos) )
                throw new Exception("No se recibieron datos");

            $db_datos = array(
                'sexo'              => $datos['sexo'],
                'nombres'           => $datos['nombres'],
                'primer_apellido'    => $datos['primer_apellido'],
                'segundo_apellido'   => $datos['segundo_apellido'],
            );

            $this->db->where('usuario_id', $usuario_id);
            $this->db->update('usuarios', $db_datos);

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e->getMessage();
        }
        return $resultado;
    }

    /**
        * Actualizar contraseña de usuario
        *
        * @access public
        * @param  string   $usuario_id      ID de usuario a actualizar
        * @param  string   $password        Contraseña a establecer
        * @return resultado
    */
    public function set_nueva_password($usuario_id, $password = NULL){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_null($password) )
                $password = 'Temporal' . date('Y');

            $this->db->where('usuario_id', $usuario_id);
            $this->db->update('usuarios', array('contrasena' => password_hash($password, PASSWORD_DEFAULT)));

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e->getMessage();
        }
        return $resultado;
    }

}

/* End of file model_usuarios.php */
/* Location: ./application/models/model_usuarios.php */