<?php
/* ================================================================================================================
 *  @Filename:  Models/Model_programas.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  08-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_programas extends CI_Model {

   /**
      * Obtener el listado de programas presupuestales
      *
      * @access public
      * @param  array   $filtros          filtros a iterar
      * @param  boolean $tipo_retorno     Modo de retonro: 
      *                                       TRUE - Objeto
      *                                       FALSE - Array
      * @return usuarios
    */
   public function get_programas($filtros = NULL, $tipo_retorno = TRUE){
      try {
         if ( is_array($filtros) ){
            foreach ($filtros as $key => $filtro) {
               $this->db->where($key, $filtro);
            }
         } else 
            $this->db->where('estatus', 1);

         $usuarios = $this->db->get('programas_presupuestarios');

         if ( $tipo_retorno )
            return $usuarios->result();
         else
            return $usuarios->result_array();
      } catch (Exception $e) {
         return [];
      }
   }

   /**
      * Obtener un programa presupuestal por su ID
      *
      * @access public
      * @param  integer $programa_id      ID
      * @param  array   $filtros          filtros a iterar
      * @param  boolean $tipo_retorno     Modo de retonro: 
      *                                       TRUE - Objeto
      *                                       FALSE - Array
      * @return usuarios
    */
   public function get_programa($programa_id, $filtros = NULL, $tipo_retorno = TRUE){
      try {
         if ( is_array($filtros) ){
            foreach ($filtros as $key => $filtro) {
               $this->db->where($key, $filtro);
            }
         } else 
            $this->db->where('estatus', 1);
         
         $this->db->where('programa_presupuestario_id', $programa_id);

         $usuarios = $this->db->get('programas_presupuestarios');

         if ( $tipo_retorno )
            return $usuarios->row();
         else
            return $usuarios->row_array();
      } catch (Exception $e) {
         return [];
      }
   }

    /**
        * Registrar un programa
        *
        * @access public
        * @param  array   $datos                Datos de programa
        *
        * @return resultado[]
    */
    public function set_programa($datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                // REGISTRO DE PROYECTO
                $db_datos = array(
                );
                $this->db->insert('programas_presupuestarios', $db_datos);
                $programa = $this->db->insert_id();
            } else
                throw new Exception('La estructura de los datos es incorrecta.');

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e;
        }
        return $resultado;
    }

    /**
        * Actualizar un programa
        *
        * @access public
        * @param  integer $id                   ID
        * @param  array   $datos                Datos de programa
        *
        * @return resultado[]
    */
    public function update_programa($programa_id, $datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                // REGISTRO DE PROYECTO
                $db_datos = array(
                  'cve_programa'    => $datos['clave'],
                  'nombre'          => $datos['nombre'],
                  'descripcion'     => $datos['descripcion'],
                  'objetivo'        => $datos['objetivo'],
                  'techo_financiero'=> $datos['techo_financiero']
               );
                $this->db->where('programa_presupuestario_id', $programa_id);
                $this->db->update('programas_presupuestarios', $db_datos);
            } else
                throw new Exception('La estructura de los datos es incorrecta.');

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e;
        }
        return $resultado;
    }

}

/* End of file Model_programas.php */
/* Location: ./application/models/Model_programas.php */