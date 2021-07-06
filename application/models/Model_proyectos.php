<?php
/* ================================================================================================================
 *  @Filename:  Models/Model_proyectos.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  07-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_proyectos extends CI_Model {

    /**
        * Obtener el listado de proyectos
        *
        * @access public
        * @param  array   $filtros          filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return proyectos
    */
    public function get_proyectos($filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }

            $proyectos = $this->db->get('vw_proyectos');

            if ( $tipo_retorno )
                return $proyectos->result();
            else
                return $proyectos->result_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener proyecto por id
        *
        * @access public
        * @param  int     $proyecto_id     ID
        * @param  array   $filtros          filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return proyecto
    */
    public function get_proyecto($proyecto_id, $filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }
            $this->db->where('proyecto_id', $proyecto_id);
            $proyectos = $this->db->get('vw_proyectos');

            if ( $tipo_retorno )
                return $proyectos->row();
            else
                return $proyectos->row_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener listado de actividades dado un proyecto
        *
        * @access public
        * @param  int     proyecto_id     Identificador de proyecto
        * @param  array   $filtros          Filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return proyectos
    */
    public function get_actividades_proyecto($proyecto_id, $filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }
            $this->db->where('proyecto_id', $proyecto_id);

            $proyectos = $this->db->get('vw_proyectos_actividades');

            if ( $tipo_retorno )
                return $proyectos->result();
            else
                return $proyectos->result_array();
        } catch (Exception $e) {
            return [];
        }
    }

}

/* End of file Model_proyectos.php */
/* Location: ./application/models/Model_proyectos.php */