<?php
/* ================================================================================================================
 *  @Filename:  Models/Model_preproyectos.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  07-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_preproyectos extends CI_Model {

    /**
        * Obtener el listado de preproyectos
        *
        * @access public
        * @param  array   $filtros          filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return preproyectos
    */
    public function get_preproyectos($filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }

            $preproyectos = $this->db->get('vw_preproyectos');

            if ( $tipo_retorno )
                return $preproyectos->result();
            else
                return $preproyectos->result_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener preproyecto por id
        *
        * @access public
        * @param  int     $preproyecto_id     ID
        * @param  array   $filtros          filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return preproyecto
    */
    public function get_preproyecto($preproyecto_id, $filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }
            $this->db->where('preproyecto_id', $preproyecto_id);
            $preproyectos = $this->db->get('vw_preproyectos');

            if ( $tipo_retorno )
                return $preproyectos->row();
            else
                return $preproyectos->row_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener listado de actividades dado un preproyecto
        *
        * @access public
        * @param  int     preproyecto_id     Identificador de preproyecto
        * @param  array   $filtros          Filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return preproyectos
    */
    public function get_actividades_preproyecto($preproyecto_id, $filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }
            $this->db->where('preproyecto_id', $preproyecto_id);

            $preproyectos = $this->db->get('vw_preproyectos_actividades');

            if ( $tipo_retorno )
                return $preproyectos->result();
            else
                return $preproyectos->result_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener los datos de una actividad de un preproyecto
        *
        * @access public
        * @param  int     actividad_id      Identificador de actividad
        * @param  array   $filtros          Filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return actividad
    */
    public function get_actividad($actividad_id, $filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }
            $this->db->where('preproyecto_actividad_id', $actividad_id);

            $actividad = $this->db->get('vw_preproyectos_actividades');

            if ( $tipo_retorno )
                return $actividad->row();
            else
                return $actividad->row_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Registrar una activiad nueva
        *
        * @access public
        * @param  array   $datos                Datos a almacenar en preproyectos
        *
        * @return resultado[]
    */
    public function set_nuevo_preproyecto($datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                $db_datos = array(
                    'linea_accion_id'           => $datos['linea_accion'],
                    'actividad'                 => $datos['detalle_preproyecto'],
                    'seccion'                   => $datos['seccion'],
                    'incluido'                  => ( $datos['incluido'] == 'true' )? 1 : 0,
                    'url'                       => $datos['url'],
                    'usuario_id'                => $datos['usuario_id'],
                );
                $this->db->insert('preproyectos', $db_datos);
                $preproyecto = $this->db->insert_id();
                $resultado['preproyecto'] = $preproyecto;
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
        * Editar preproyecto
        *
        * @access public
        * @param  integer  preproyecto_id       ID
        * @param  arrary   $datos               Datos del documento
        *
        * @return resultado[]
    */
    function editar_preproyecto($preproyecto_id, $datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                $db_datos = array(
                    'linea_accion_id'           => $datos['linea_accion'],
                    'actividad'                 => $datos['detalle_preproyecto'],
                    'seccion'                   => $datos['seccion'],
                    'incluido'                  => ( $datos['incluido'] == 'true' )? 1 : 0,
                    'url'                       => $datos['url'],
                    'usuario_id_modifica'       => $datos['usuario_id'],
                );
                $this->db->where('preproyecto_id', $preproyecto_id);
                $this->db->update('preproyectos', $db_datos);
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
        * Registra actividad de un preproyecto
        *
        * @access public
        * @param  array   $datos                Datos a almacenar en preproyectos
        *
        * @return resultado[]
    */
    public function registrar_actividad($preproyecto_id, $datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                $db_datos = array(
                    'preproyecto_id'            => $preproyecto_id,
                    'municipio_id'              => $datos['municipio'],
                    'localidad_id'              => $datos['localidad'],
                    'linea_accion_id'           => $datos['linea_accion'],
                    'actividad'                 => $datos['detalle_preproyecto'],
                    'unidad_medida_id'          => $datos['unidad_medida'],
                    'medicion_id'               => $datos['tipo_medicion'],
                    'beneficiario_id'           => $datos['grupo_beneficiado'],
                    'cantidad_beneficiarios'    => $datos['cantidad_beneficiarios'],
                    'inversion'                 => $datos['inversion'],
                    'trimestre'                 => $datos['trimestre'],
                    'seccion'                   => $datos['seccion'],
                    'incluido'                  => ( $datos['incluido'] == 'true' )? 1 : 0,
                    'fecha_inicio'              => $datos['fecha_inicio'],
                    'fecha_termino'             => $datos['fecha_termino'],
                    'url'                       => $datos['url'],
                    'usuario_id'                => $datos['usuario_id'],
                );
                $this->db->insert('preproyectos_actividades', $db_datos);
                $preproyecto = $this->db->insert_id();
                $resultado['preproyecto'] = $preproyecto;
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
        * Editar actividad de un preproyecto
        *
        * @access public
        * @param  array   $datos                Datos a almacenar en preproyectos
        *
        * @return resultado[]
    */
    public function editar_actividad($preproyecto_actividad_id, $datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                $db_datos = array(
                    'municipio_id'              => $datos['municipio'],
                    'localidad_id'              => $datos['localidad'],
                    'linea_accion_id'           => $datos['linea_accion'],
                    'actividad'                 => $datos['detalle_preproyecto'],
                    'unidad_medida_id'          => $datos['unidad_medida'],
                    'medicion_id'               => $datos['tipo_medicion'],
                    'beneficiario_id'           => $datos['grupo_beneficiado'],
                    'cantidad_beneficiarios'    => $datos['cantidad_beneficiarios'],
                    'inversion'                 => $datos['inversion'],
                    'trimestre'                 => $datos['trimestre'],
                    'seccion'                   => $datos['seccion'],
                    'incluido'                  => ( $datos['incluido'] == 'true' )? 1 : 0,
                    'fecha_inicio'              => $datos['fecha_inicio'],
                    'fecha_termino'             => $datos['fecha_termino'],
                    'url'                       => $datos['url'],
                    'usuario_id_modifica'       => $datos['usuario_id'],
                );
                $this->db->where('preproyecto_actividad_id', $preproyecto_actividad_id);
                $this->db->update('preproyectos_actividades', $db_datos);
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
        * Registrar documento de preproyecto
        *
        * @access public
        * @param  integer  preproyecto_actividad_id      ID
        * @param  string   $documento                   Nombre del documento
        *
        * @return resultado[]
    */
    function registrar_documento($preproyecto_actividad_id, $documento){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            $db_datos = array(
                'documento' => $documento
            );
            $this->db->where('preproyecto_actividad_id', $preproyecto_actividad_id);
            $this->db->update('preproyectos_actividades', $db_datos);

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e;
        }
        return $resultado;
    }

}

/* End of file model_preproyectos.php */
/* Location: ./application/models/model_preproyectos.php */