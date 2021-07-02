<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_actividades extends CI_Model {

    /**
        * Obtener el listado de actividades
        *
        * @access public
        * @param  array   $filtros          filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return actividades
    */
    public function get_actividades($filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }

            $actividades = $this->db->get('vw_proyecto_actividades');

            if ( $tipo_retorno )
                return $actividades->result();
            else
                return $actividades->result_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener actividad por id
        *
        * @access public
        * @param  int     $actividad_id     ID
        * @param  array   $filtros          filtros a iterar
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
            $this->db->where('actividad_id', $actividad_id);
            $actividades = $this->db->get('vw_proyecto_actividades');

            if ( $tipo_retorno )
                return $actividades->row();
            else
                return $actividades->row_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Obtener el seguimiento de las actividades
        *
        * @access public
        * @param  int     $actividad_id     Identificador de actividad
        * @param  array   $filtros          Filtros a iterar
        * @param  boolean $tipo_retorno     Modo de retonro: 
        *                                       TRUE - Objeto
        *                                       FALSE - Array
        * @return actividades
    */
    public function get_seguimiento_actividades($actividad_id, $filtros = NULL, $tipo_retorno = TRUE){
        try {           
            if ( is_array($filtros) ){
                foreach ($filtros as $key => $filtro) {
                    $this->db->where($key, $filtro);
                }
            }
            $this->db->where('actividad_id', $actividad_id);

            $actividades = $this->db->get('vw_seguimiento_actividades');

            if ( $tipo_retorno )
                return $actividades->result();
            else
                return $actividades->result_array();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
        * Registrar una activiad nueva
        *
        * @access public
        * @param  array   $datos                Datos a almacenar en actividades
        *
        * @return resultado[]
    */
    public function set_nueva_actividad($datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                // REGISTRO DE PROYECTO
                $db_datos = array(
                    'combinacion_area_id'           => $datos['area_origen'],
                    'linea_accion_id'               => $datos['linea_accion'],
                    'usuario_id'                    => $datos['usuario_id'],
                    'ejercicio'                     => $datos['ejercicio'],
                    'programa_presupuestario_id'    => $datos['programa_presupuestario'],
                    'fuente_financiamiento_id'      => $datos['fuente_financiamiento']
                );

                $this->db->insert('proyectos_actividades', $db_datos);
                $proyecto = $this->db->insert_id();
                $resultado['proyecto'] = $proyecto;
                
                // REGISTRO DE ACTIVIDAD
                $db_datos = array(
                    'descripcion'           => $datos['detalle_actividad'],
                    'proyecto_actividad_id' => $proyecto,
                    'unidad_medida_id'      => $datos['unidad_medida'],
                    'medicion_id'           => $datos['tipo_medicion'],
                    'beneficiado_id'        => $datos['grupo_beneficiado'],
                    'cantidad_beneficiario' => $datos['programado_fisico'],
                    'monto_presupuestado'   => $datos['programado_financiero'],
                    'usuario_id'            => $datos['usuario_id'],
                    'unidad_medida_id'      => $datos['unidad_medida'],
                    'ejercicio'             => $datos['ejercicio']
                );
                $this->db->insert('actividades', $db_datos);
                $actividad = $this->db->insert_id();
                $resultado['actividad'] = $actividad;

                // REGISTO DE DETALLE DE ACTIVIDAD
                $meses_financieros = $datos['programado_financiero_mensual'];
                foreach ($datos['programado_fisico_mensual'] as $key => $mes_fisico) {
                    $db_datos = array(
                        'actividad_id'          => $actividad,
                        'descripcion'           => $datos['detalle_actividad'],
                        'mes'                   => $key + 1,
                        'programado_fisico'     => $mes_fisico,
                        'programado_financiero' => $meses_financieros[$key],
                        'usuario_id'            => $datos['usuario_id']
                    );
                    $this->db->insert('actividades_detalladas', $db_datos);
                }
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
        * Actualizar Proyecto-Actividad
        *
        * @access public
        * @param  integer $proyecto_actividad_id    ID de Preproyecto
        * @param  integer $actividad_id             ID de Actividad
        * @param  array   $datos                    Datos a almacenar en actividades
        *
        * @return resultado[]
    */
    public function update_proyecto_actividad($proyecto_actividad_id, $actividad_id, $datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            if ( is_array($datos) ){
                // ACTUALIZAR PROYECTO
                $db_datos = array(
                    'combinacion_area_id'           => $datos['area_origen'],
                    'linea_accion_id'               => $datos['linea_accion'],
                    'usuario_id'                    => $datos['usuario_id'],
                    'ejercicio'                     => $datos['ejercicio'],
                    'programa_presupuestario_id'    => $datos['programa_presupuestario'],
                    'fuente_financiamiento_id'      => $datos['fuente_financiamiento']
                );
                $this->db->where('proyecto_actividad_id', $proyecto_actividad_id);
                $this->db->update('proyectos_actividades', $db_datos);
                
                // ACTUALIZAR ACTIVIDAD
                $db_datos = array(
                    'descripcion'           => $datos['detalle_actividad'],
                    'unidad_medida_id'      => $datos['unidad_medida'],
                    'medicion_id'           => $datos['tipo_medicion'],
                    'beneficiado_id'        => $datos['grupo_beneficiado'],
                    'cantidad_beneficiario' => $datos['programado_fisico'],
                    'monto_presupuestado'   => $datos['programado_financiero'],
                    'usuario_id'            => $datos['usuario_id'],
                    'unidad_medida_id'      => $datos['unidad_medida'],
                    'ejercicio'             => $datos['ejercicio']
                );
                $this->db->where('actividad_id', $actividad_id);
                $this->db->update('actividades', $db_datos);

                // REGISTO DE DETALLE DE ACTIVIDAD
                $meses_financieros = $datos['programado_financiero_mensual'];
                foreach ($datos['programado_fisico_mensual'] as $key => $mes_fisico) {
                    $db_datos = array(
                        'descripcion'           => $datos['detalle_actividad'],
                        'programado_fisico'     => $mes_fisico,
                        'programado_financiero' => $meses_financieros[$key],
                        'usuario_id'            => $datos['usuario_id']
                    );
                    $this->db->where('actividad_id', $actividad_id);
                    $this->db->where('mes', $key + 1);
                    $this->db->update('actividades_detalladas', $db_datos);
                }
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
        * Actualizar reporte
        *
        * @access public
        * @param  integer  $actividad_detallada_id      ID
        * @param  arrary   $datos                       Datos del documento
        *
        * @return resultado[]
    */
    function actualizar_reporte($actividad_detallada_id, $datos){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            $this->db->where( 'actividad_detallada_id', $actividad_detallada_id);
            $this->db->update('actividades_detalladas', $datos);

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e;
        }
        return $resultado;
    }

    /**
        * Registrar documento de actividad
        *
        * @access public
        * @param  integer  $actividad_detallada_id      ID
        * @param  string   $documento                   Nombre del documento
        *
        * @return resultado[]
    */
    function registrar_documento($actividad_detallada_id, $documento){
        $resultado = array('exito' => TRUE);
        try {
            $this->db->trans_begin();

            $db_datos = array(
                'documento' => $documento
            );
            $this->db->where('actividad_detallada_id', $actividad_detallada_id);
            $this->db->update('actividades_detalladas', $db_datos);

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $resultado['exito'] = FALSE;
            $resultado['error'] = $e;
        }
        return $resultado;
    }

}

/* End of file model_actividades.php */
/* Location: ./application/models/model_actividades.php */