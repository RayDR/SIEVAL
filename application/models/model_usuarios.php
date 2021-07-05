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

    // ------------------------- SETTERS

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