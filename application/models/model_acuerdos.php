<?php
/* ================================================================================================================
 *  @Filename:  Models/Model_acuerdos.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  07-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_acuerdos extends CI_Model {

	/**
		* Obtener el listado de acuerdos
		*
		* @access public
		* @param  array   $filtros 			filtros a iterar
		* @param  boolean $tipo_retorno 	Modo de retonro: 
		*								 		TRUE - Objeto
		*								 		FALSE - Array
		* @return acuerdos
	*/
	public function get_acuerdos($filtros = NULL, $tipo_retorno = TRUE){
		try {
			if ( is_array($filtros) ){
				foreach ($filtros as $key => $filtro) {
					$this->db->where($key, $filtro);
				}
			}
			$acuerdos = $this->db->get('vw_acuerdos');

			if ( $tipo_retorno )
				return $acuerdos->result();
			else
				return $acuerdos->result_array();
		} catch (Exception $e) {
			return [];
		}
	}

	/**
		* Obtener el listado de acuerdos maestros
		*
		* @access public
		* @param  array   $filtros 			filtros a iterar
		* @param  boolean $tipo_retorno 	Modo de retonro: 
		*								 		TRUE - Objeto
		*								 		FALSE - Array
		* @return acuerdos
	*/
	public function get_acuerdos_master($filtros = NULL, $tipo_retorno = TRUE){
		try {
			if ( is_array($filtros) ){
				foreach ($filtros as $key => $filtro) {
					$this->db->where($key, $filtro);
				}
			} else if ( is_string( $filtros ) )
				$this->db->where($filtros);
			
			$acuerdos = $this->db->get('vw_ultimo_seguimiento');

			if ( $tipo_retorno )
				return $acuerdos->result();
			else
				return $acuerdos->result_array();
		} catch (Exception $e) {
			return [];
		}
	}

	/**
		* Obtener el listado de acuerdos detallados
		*
		* @access public
		* @param  array   $filtros 			filtros a iterar
		* @param  boolean $tipo_retorno 	Modo de retonro: 
		*								 		TRUE - Objeto
		*								 		FALSE - Array
		* @return acuerdos
	*/
	public function get_acuerdos_detalle($acuerdo_id, $filtros = NULL, $tipo_retorno = TRUE){
		try {
			if ( is_array($filtros) ){
				foreach ($filtros as $key => $filtro) {
					$this->db->where($key, $filtro);
				}
			}
			$this->db->where('acuerdo_id', $acuerdo_id);

			$acuerdos = $this->db->get('vw_seguimiento_acuerdo_ag');

			if ( $tipo_retorno )
				return $acuerdos->result();
			else
				return $acuerdos->result_array();
		} catch (Exception $e) {
			return [];
		}
	}

	/**
		* Obtener el listado de acuerdos para el planificador
		*
		* @access public
		* @param  array   $usuario_id 		Usado para crear filtros
		* @param  boolean $tipo_retorno 	Modo de retonro: 
		*								 		TRUE - Objeto
		*								 		FALSE - Array
		* @return acuerdos
	*/
	public function get_acuerdos_planificador($usuario_id, $tipo_retorno = TRUE){		
		$this->db->where('usuario_id', $usuario_id);
		$db_usuario = $this->db->get('vw_usuarios', 1)->row();

		if ( $db_usuario ){
			if ( $db_usuario->tipo_usuario_id != 1 ){
				if ( 
					$db_usuario->subdireccion_id == 1 && 
					$db_usuario->departamento_id == 1 && 
					$db_usuario->area_id == 1 
				){
					$this->db->where( 'direccion_id_acuerdo', $db_usuario->direccion_id );
					$this->db->or_where( 'direccion_id_seguimiento', $db_usuario->direccion_id );
				} else {
					$this->db->where( 'combinacion_area_acuerdo_id', $db_usuario->combinacion_area_usuario_id );
					$this->db->or_where( 'combinacion_area_seguimiento_id', $db_usuario->direccion_id );
				}
			}
			$this->db->select('acuerdo_id, asunto, estatus_seguimiento, area_acuerdo, area_seguimiento, tema_id, tema, fecha_creacion_acuerdo, fecha_actualizacion_seguimiento, fecha_respuesta');

			$resultado = $this->db->get('vw_ultimo_seguimiento');
			if ( $tipo_retorno )
				return $resultado->result();
			else
				return $resultado->result_array();
		}
		return [];
	}

	public function get_archivos_acuerdo($acuerdo_id){
		$this->db->where('acuerdo_id', $acuerdo_id);
		$this->db->where('estatus_acuerdo_id <>', 0);
		$db_seguimientos = $this->db->get('seguimientos_acuerdos');

		$archivos = array();
		if ( $db_seguimientos->num_rows() > 0 ){
			foreach ($db_seguimientos->result() as $key => $seguimiento) {
				if ( $seguimiento->archivo_anexo ){
					$files = explode(',', $seguimiento->archivo_anexo);
					foreach ($files as $key => $file) {
						$archivo['seguimiento_acuerdo_id'] = $seguimiento->seguimiento_acuerdo_id;
						$archivo['archivo'] = $file;
						array_push($archivos, $archivo);
					}
				}
			}
		}
		return $archivos;
	}

	//  ------------------------------------------------------- SETTERS


	/**
		* Registrar un nuevo acuerdo
		*
		* @access public
		* @param  array   $datos 		Datos a almacenar en acuerdos
		*
		* @return resultado[]
	*/
	public function set_nuevo_acuerdo($datos){
		$resultado = array('exito' => TRUE);
		try {
			$this->db->trans_begin();

			if ( is_array($datos) ){
				$datos_db = array(
					'asunto' 					=> $datos['acuerdos'],
					'combinacion_area_id' 		=> $datos['area_origen'],
					'usuario_registra_id' 		=> $datos['usuario_id'],
					'tema_id' 					=> $datos['tema'],
					'ejercicio' 				=> $datos['ejercicio'],
					'estatus' 					=> 1
				);
				$this->db->insert('acuerdos', $datos_db);

				$acuerdo_id = $this->db->insert_id();

				$datos_db = array(
					'acuerdo_id'				=> $acuerdo_id,
					'seguimiento' 				=> $datos['acuerdos'],
					'combinacion_area_id' 		=> $datos['area_destino'],
					'usuario_acuerda_id' 		=> $datos['usuario_id'],
					'ejercicio' 				=> $datos['ejercicio'],
					'estatus_acuerdo_id' 		=> 1
				);

				$this->db->insert('seguimientos_acuerdos', $datos_db);

				$seguimiento_id = $this->db->insert_id();

				$resultado['acuerdo_id'] 	 = $acuerdo_id;
				$resultado['seguimiento_id'] = $seguimiento_id;

			} else
				throw new Exception('La estructura de los datos es incorrecta.');

			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$resultado['exito'] = FALSE;
			$resultado['error'] = $e->getMessage();
		}
		return $resultado;
	}


	/**
		* Registrar el seguimiento del acuerdo
		*
		* @access public
		* @param  array   $datos 		Datos a almacenar en acuerdos
		*
		* @return resultado[]
	*/
	public function set_seguimiento_acuerdo($acuerdo_id, $datos){
		$resultado = array('exito' => TRUE);
		try {
			$this->db->trans_begin();
			if ( $acuerdo_id ){		
				$folio = $this->db->get_where('seguimientos_acuerdos', ['acuerdo_id' => $acuerdo_id]);
				if ( is_array($datos) ){
					// Actualizar datos seguimiento anterior
					$datos_db = array(
						'usuario_recibe_id'         => $datos['usuario_id']
					);
					$seguimiento_acuerdo_id = $this->db->get_where('vw_ultimo_seguimiento', ['acuerdo_id' => $acuerdo_id]);
					if ( $seguimiento_acuerdo_id->num_rows() > 0 ){
						$this->db->where('seguimiento_acuerdo_id', $seguimiento_acuerdo_id->row('seguimiento_acuerdo_id'));
						$this->db->update('seguimientos_acuerdos', $datos_db);
					}
					// Crear nuevo seguimiento
					$datos_db = array(
						'acuerdo_id'				=> $acuerdo_id,
						'seguimiento' 				=> $datos['acuerdos'],
						'combinacion_area_id' 		=> $datos['area_destino'],
						'usuario_acuerda_id' 		=> $datos['usuario_id'],
						'ejercicio' 				=> $datos['ejercicio'],
						'estatus_acuerdo_id' 		=> $datos['estatus_acuerdo'],
						'usuario_recibe_id'			=> ( $datos['estatus_acuerdo'] == 3)? 
														 $datos['usuario_id']: NULL,
						'folio'						=> ( $folio->num_rows() > 0 )? 
														 $folio->num_rows() + 1 : 1
					);

					$this->db->insert('seguimientos_acuerdos', $datos_db);

					$seguimiento_id = $this->db->insert_id();

					$resultado['acuerdo_id'] 	 = $acuerdo_id;
					$resultado['seguimiento_id'] = $seguimiento_id;
				} else 
					throw new Exception('La estructura de los datos es incorrecta.');
			} else 
				throw new Exception('No se recibió el número del acuerdo.');

			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$resultado['exito'] = FALSE;
			$resultado['error'] = $e->getMessage();
		}
		return $resultado;
	}
	

	/**
		* Actualizar el acuerdo y su seguimiento
		*
		* @access public
		* @param  array   $datos 		Datos a iterar para actualizar
		*
		* @return resultado[]
	*/
	public function update_acuerdo($datos){
		$resultado = array('exito' => TRUE);
		try {
			$this->db->trans_begin();

			if ( is_array($datos) ){
				$datos_db = array(
					'asunto' 					=> $datos['acuerdos'],
					'tema_id' 					=> $datos['tema']
				);
				$this->db->where('acuerdo_id', $datos['acuerdo_id']);
				$this->db->update('acuerdos', $datos_db);

				$datos_db = array(
					'acuerdo_id'				=> $datos['acuerdo_id'],
					'seguimiento' 				=> $datos['acuerdos'],
					'combinacion_area_id' 		=> $datos['area_destino'],
					'usuario_acuerda_id' 		=> $datos['usuario_id'],
					'ejercicio' 				=> $datos['ejercicio'],
					'estatus_acuerdo_id' 		=> $datos['estatus_acuerdo']
				);
				$this->db->where('seguimiento_acuerdo_id', $datos['seguimiento_id']);
				$this->db->update('seguimientos_acuerdos', $datos_db);
			} else 
				throw new Exception('La estructura de los datos es incorrecta.');

			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$resultado['exito'] = FALSE;
			$resultado['error'] = $e->getMessage();
		}
		return $resultado;
	}

	/**
		* Actualizar el seguimiento
		*
		* @access public
		* @param  array   $datos 		Datos a iterar para actualizar
		*
		* @return resultado[]
	*/
	public function update_seguimiento($datos){
		$resultado = array('exito' => TRUE);
		try {
			$this->db->trans_begin();

			if ( is_array($datos) ){
				$datos_db = array(
					'seguimiento' 				=> $datos['acuerdos'],
					'combinacion_area_id' 		=> $datos['area_destino'],
					'usuario_acuerda_id' 		=> $datos['usuario_id'],
					'ejercicio' 				=> $datos['ejercicio'],
					'estatus_acuerdo_id' 		=> $datos['estatus_acuerdo']
				);
				$this->db->where('seguimiento_acuerdo_id', $datos['seguimiento_id']);
				$this->db->update('seguimientos_acuerdos', $datos_db);
			} else 
				throw new Exception('La estructura de los datos es incorrecta.');

			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$resultado['exito'] = FALSE;
			$resultado['error'] = $e->getMessage();
		}
		return $resultado;
	}

	/**
		* Actualizar el usuario que recibe de seguimiento
		*
		* @access public
		* @param  array   $datos 		Datos a actualizar
		*
		* @return resultado[]
	*/
	public function asignar_usuario_seguimiento($seguimiento_id, $usuario_id){
		$resultado = array('exito' => TRUE);
		try {
			$this->db->trans_begin();
			
			$datos_db = array(
				'usuario_recibe_id' => $usuario_id
			);
			$this->db->where('seguimiento_acuerdo_id', $seguimiento_id);
			$this->db->update('seguimientos_acuerdos', $datos_db);

			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$resultado['exito'] = FALSE;
			$resultado['error'] = $e->getMessage();
		}
		return $resultado;
	}

	/**
		* Función para agregar nombre de documentos para un seguimiento
		*
		* @access public
		* @param  array   $datos 		Datos a actualizar
		*
		* @return resultado[]
	*/
	public function anexos_acuerdos_seguimiento($seguimiento_id, $archivo, $modo_edicion = FALSE){
		$resultado = array('exito' => TRUE);
		try {
			$this->db->trans_begin();

			$this->db->where('seguimiento_acuerdo_id', $seguimiento_id);
			$archivos_existentes = $this->db->get('seguimientos_acuerdos')->row('archivo_anexo');

			if ( $archivos_existentes && !$modo_edicion )
				$archivo = $archivo . ',' . $archivos_existentes; // Separar por coma
						
			$datos_db = array(
				'archivo_anexo' => $archivo
			);
			$this->db->where('seguimiento_acuerdo_id', $seguimiento_id);
			$this->db->update('seguimientos_acuerdos', $datos_db);

			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$resultado['exito'] = FALSE;
			$resultado['error'] = $e->getMessage();
		}
		return $resultado;
	}
}

/* End of file model_acuerdos.php */
/* Location: ./application/models/model_acuerdos.php */