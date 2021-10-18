<?php
/* ================================================================================================================
 *  @Filename:  Models/Model_catalogos.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  08-2021
 * =====================================================================*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_indicadores extends CI_Model {

   /**
      * Devuelve el listado de indicadores
      *
      * @access public
      * @param  array   $filtros          filtros a iterar
      * @param  boolean $tipo_retorno  Modo de retonro: 
      *                             TRUE - Objeto
      *                             FALSE - Array
      * @return array
   */
   public function get_indicadores($filtros = NULL, $tipo_retorno = TRUE){
      try {           
         if ( is_array($filtros) ){
            foreach ($filtros as $key => $filtro) {
               $this->db->where($key, $filtro);
            }
         } else 
            $this->db->where('estatus', 1);

         $usuarios = $this->db->get('vw_indicadores');

         if ( $tipo_retorno )
            return $usuarios->result();
         else
            return $usuarios->result_array();
      } catch (Exception $e) {
         return [];
      }
   }

}

/* End of file Model_indicadores.php */
/* Location: ./application/models/Model_indicadores.php */