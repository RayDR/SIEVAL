<?php
/* ================================================================================================================
 *  @Filename:  Controllers/Preproyectos.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  07-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Preproyectos extends CI_Controller {

    private $rootPathRemoto = 'C:/SvrArchivos/sieval/Preproyectos/'; // PATH a archivos locales ( Dentro de la app )
    private $rootPathLocal  = FCPATH . 'uploads/Preproyectos/';      // PATH para guardarlo en otro directorio ( Fuera de la app )

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_catalogos');
        $this->load->model('model_preproyectos');
        
        if ( !$this->session->estatus_usuario_sesion() ){
            print(
                json_encode(
                    array('exito'   => FALSE, 
                          'error'   => 'Sesión caducada. Recargue la página',
                          'estatus' => 'sess_expired', 
                          'mensaje' => 'Su sesión ha caducado. Por favor, recargue la página.'
                    )
                )
            );
            redirect(base_url('index.php/Home/login'),'refresh');
        }
    }

/*--------------------------------------------------------------------------*
* ---- VISTAS 
* --------------------------------------------------*/

    public function index()
    {
        $data = array(
            'titulo'        => 'Preproyectos ' . APLICACION  . ' | ' . EMPRESA,
            'menu'          => $this->model_catalogos->get_menus(),
            'view'          => 'preproyectos/index'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
    }

    public function registrar()
    {
        $json = array('exito' => TRUE);

        // Área usuario
        $area_usuario   = array('combinacion_area_id' => $this->session->userdata('combinacion_area'));
        $combinacion    = $this->model_catalogos->get_areas( $area_usuario );

        $condicion = ( $this->session->userdata('tuser') == 1 )? NULL : 
                     array( 'direccion_id' => $combinacion->direccion_id );
                     
        $data = array(
            'titulo'        => 'Registrar',
            'programas'     => $this->model_catalogos->get_programas(),
            'municipios'    => $this->model_catalogos->get_municipios(),
            'l_accion'      => $this->model_catalogos->get_lineas_accion(),
            'u_medida'      => $this->model_catalogos->get_unidades_medida($condicion),
            'inputs'        => $this->inputs_registro(),
            'view'          => 'preproyectos/registrar'
        );
        $json['html'] = $this->load->view( $data['view'], $data, TRUE );
        return print(json_encode($json));
    
    }

    public function editar()
    {
        $json = array('exito' => TRUE);
        $preproyecto_id = $this->input->post('preproyecto');
        if ( $preproyecto_id ){
            $preproyecto    = $this->model_preproyectos->get_preproyecto($preproyecto_id);
            $actividades    = $this->model_preproyectos->get_actividades_preproyecto($preproyecto_id);
            if ( $preproyecto ){
                // Área usuario
                $area_usuario   = array('combinacion_area_id' => $this->session->userdata('combinacion_area'));
                $combinacion    = $this->model_catalogos->get_areas( $area_usuario );

                $condicion = ( $this->session->userdata('tuser') == 1 )? NULL : 
                             array( 'direccion_id' => $combinacion->direccion_id );
                             
                $data = array(
                    'titulo'        => 'Editar Preproyecto',
                    'preproyecto'   => $preproyecto,
                    'programas'     => $this->model_catalogos->get_programas(),
                    'municipios'    => $this->model_catalogos->get_municipios(),
                    'l_accion'      => $this->model_catalogos->get_lineas_accion(),
                    'u_medida'      => $this->model_catalogos->get_unidades_medida($condicion),
                    'inputs'        => $this->inputs_registro(),
                    'view'          => 'preproyectos/editar'
                );
                $json['html'] = $this->load->view( $data['view'], $data, TRUE );
            } else 
                $json = array('exito' => FALSE, 'error' => 'No se recuperó información sobre este preproyecto.');
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se recibió el folio del preproyecto.');
        return print(json_encode($json));
    
    }

    public function actividades()
    {
        $json = array('exito' => TRUE);
        $preproyecto_id = $this->input->post('preproyecto');
        if ( $preproyecto_id ){
            $preproyecto    = $this->model_preproyectos->get_preproyecto($preproyecto_id);
            $actividades    = $this->model_preproyectos->get_actividades_preproyecto($preproyecto_id);
            if ( $preproyecto ){
                // Área usuario
                $area_usuario   = array('combinacion_area_id' => $this->session->userdata('combinacion_area'));
                $combinacion    = $this->model_catalogos->get_areas( $area_usuario );

                $condicion = ( $this->session->userdata('tuser') == 1 )? NULL : 
                             array( 'direccion_id' => $combinacion->direccion_id );
                             
                $data = array(
                    'titulo'        => 'Actividades - Preproyecto',
                    'preproyecto'   => $preproyecto,
                    'actividades'   => $actividades,
                    'programas'     => $this->model_catalogos->get_programas(),
                    'municipios'    => $this->model_catalogos->get_municipios(),
                    'l_accion'      => $this->model_catalogos->get_lineas_accion(),
                    'u_medida'      =>  $this->model_catalogos->get_unidades_medida($condicion),
                    'g_benef'       =>  $this->model_catalogos->get_grupos_beneficiados(),
                    'mediciones'    =>  $this->model_catalogos->get_mediciones(),
                    'inputs'        => $this->inputs_actividad(),
                    'view'          => 'preproyectos/actividades'
                );
                $json['html'] = $this->load->view( $data['view'], $data, TRUE );
            } else 
                $json = array('exito' => FALSE, 'error' => 'No se recuperó información sobre este preproyecto.');
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se recibió el folio del preproyecto.');
        return print(json_encode($json));    
    }

    public function editar_actividad()
    {
        $json = array('exito' => TRUE);
        $actividad_id = $this->input->post('actividad_id');
        if ( $actividad_id ){
            $actividad    = $this->model_preproyectos->get_actividad($actividad_id);
            if ( $actividad ){
                // Área usuario
                $preproyecto    = $this->model_preproyectos->get_preproyecto($actividad->preproyecto_id);
                $area_usuario   = array('combinacion_area_id' => $this->session->userdata('combinacion_area'));
                $combinacion    = $this->model_catalogos->get_areas( $area_usuario );

                $condicion = ( $this->session->userdata('tuser') == 1 )? NULL : 
                             array( 'direccion_id' => $combinacion->direccion_id );
                             
                $data = array(
                    'titulo'        => 'Actividades - Preproyecto',
                    'preproyecto'   => $preproyecto,
                    'actividad'     => $actividad,
                    'programas'     => $this->model_catalogos->get_programas(),
                    'municipios'    => $this->model_catalogos->get_municipios(),
                    'l_accion'      => $this->model_catalogos->get_lineas_accion(),
                    'u_medida'      =>  $this->model_catalogos->get_unidades_medida($condicion),
                    'g_benef'       =>  $this->model_catalogos->get_grupos_beneficiados(),
                    'mediciones'    =>  $this->model_catalogos->get_mediciones(),
                    'inputs'        => $this->inputs_actividad(),
                    'view'          => 'preproyectos/editar_actividades'
                );
                $json['html'] = $this->load->view( $data['view'], $data, TRUE );
            } else 
                $json = array('exito' => FALSE, 'error' => 'No se recuperó información sobre esta actividad.');
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se recibió el folio de la actividad.');
        return print(json_encode($json));    
    }

//  ------- FIN DE VISTAS ------

/*--------------------------------------------------------------------------*
* ---- FUNCIONES AJAX 
* --------------------------------------------------*/
    
    /*------------------------------
    * -- VISTAS AJAX
    * ---------------------*/

    public function detalles_preproyecto(){
        $json = array('exito' => TRUE);
        $preproyecto_id = $this->input->post('preproyecto_id');
        if ( $preproyecto_id ){
            $data = array(
                'titulo'        => 'Detalle de Preproyecto',
                'preproyecto'   => $this->model_preproyectos->get_preproyecto($preproyecto_id),
                'actividades'   => $this->model_preproyectos->get_actividades_preproyecto($preproyecto_id),
                'view'          => 'preproyectos/detalle_preproyecto'
            );
            $json['html'] = $this->load->view( $data['view'], $data, TRUE );
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se obtuvo el número de preproyecto.');
        return print(json_encode($json));
    }

    /*------------------------------
    * --- DATOS AJAX
    * ---------------------*/

    public function datatable_preproyectos(){
        return print(json_encode( $this->model_preproyectos->get_preproyectos() ));
    }

    public function guardar(){
        $json = array('exito' => TRUE);
        $datos  = array(
            'linea_accion'              => $this->input->post('linea_accion'),
            'detalle_preproyecto'       => $this->input->post('detalle_preproyecto'),
            'seccion'                   => $this->input->post('seccion'),
            'incluido'                  => $this->input->post('incluido'),
            'url'                       => $this->input->post('url'),
            'usuario_id'                => $this->session->userdata('uid'),
            'ejercicio'                 => date('Y')
        );

        $json = $this->model_preproyectos->set_nuevo_preproyecto($datos, FALSE);

        return print(json_encode($json));
    }

    public function guardar_edicion(){
        $json   = array('exito' => TRUE);

        $preproyecto_id = $this->input->post('preproyecto');
        $preproyecto    = $this->model_preproyectos->get_preproyecto($preproyecto_id);

        if ( $preproyecto ){
            $datos  = array(
                'linea_accion'              => $this->input->post('linea_accion'),
                'detalle_preproyecto'       => $this->input->post('detalle_preproyecto'),
                'seccion'                   => $this->input->post('seccion'),
                'incluido'                  => $this->input->post('incluido'),
                'url'                       => $this->input->post('url'),
                'usuario_id'                => $this->session->userdata('uid'),
                'ejercicio'                 => date('Y')
            );

            $json = $this->model_preproyectos->editar_preproyecto($preproyecto_id, $datos);
        } else
            $json   = array('exito' => FALSE, 'error' => 'No se recibió el fólio de preproyecto');

        return print(json_encode($json)); 
    }

    public function guardar_actividad(){
        $json   = array('exito' => TRUE);

        $preproyecto_id = $this->input->post('preproyecto');
        $preproyecto    = $this->model_preproyectos->get_preproyecto($preproyecto_id);

        if ( $preproyecto ){
            $datos  = array(
                'linea_accion'              => $this->input->post('linea_accion'),
                'municipio'                 => $this->input->post('municipio'),
                'localidad'                 => $this->input->post('localidad'),
                'detalle_preproyecto'       => $this->input->post('detalle_preproyecto'),
                'unidad_medida'             => $this->input->post('unidad_medida'),
                'tipo_medicion'             => $this->input->post('tipo_medicion'),
                'grupo_beneficiado'         => $this->input->post('grupo_beneficiado'),
                'cantidad_beneficiarios'    => $this->input->post('cantidad_beneficiarios'),
                'inversion'                 => $this->input->post('inversion'),
                'seccion'                   => $this->input->post('seccion'),
                'incluido'                  => $this->input->post('incluido'),
                'trimestre'                 => $this->input->post('trimestre'),
                'fecha_inicio'              => $this->input->post('fecha_inicio'),
                'fecha_termino'             => $this->input->post('fecha_termino'),
                'url'                       => $this->input->post('url'),
                'usuario_id'                => $this->session->userdata('uid'),
                'ejercicio'                 => date('Y')
            );

            $json = $this->model_preproyectos->registrar_actividad($preproyecto_id, $datos);
        } else
            $json   = array('exito' => FALSE, 'error' => 'No se recibió el fólio del preproyecto');

        return print(json_encode($json)); 
    }

    public function edicion_actividad(){
        $json   = array('exito' => TRUE);

        $actividad_id   = $this->input->post('actividad_id');
        $actividad      = $this->model_preproyectos->get_actividad($actividad_id);

        if ( $actividad ){
            $datos  = array(
                'linea_accion'              => $this->input->post('linea_accion'),
                'municipio'                 => $this->input->post('municipio'),
                'localidad'                 => $this->input->post('localidad'),
                'detalle_preproyecto'       => $this->input->post('detalle_preproyecto'),
                'unidad_medida'             => $this->input->post('unidad_medida'),
                'tipo_medicion'             => $this->input->post('tipo_medicion'),
                'grupo_beneficiado'         => $this->input->post('grupo_beneficiado'),
                'cantidad_beneficiarios'    => $this->input->post('cantidad_beneficiarios'),
                'inversion'                 => $this->input->post('inversion'),
                'seccion'                   => $this->input->post('seccion'),
                'incluido'                  => $this->input->post('incluido'),
                'trimestre'                 => $this->input->post('trimestre'),
                'fecha_inicio'              => $this->input->post('fecha_inicio'),
                'fecha_termino'             => $this->input->post('fecha_termino'),
                'url'                       => $this->input->post('url'),
                'usuario_id'                => $this->session->userdata('uid'),
                'ejercicio'                 => date('Y')
            );

            $json = $this->model_preproyectos->editar_actividad($actividad_id, $datos);
        } else
            $json   = array('exito' => FALSE, 'error' => 'No se recibió el fólio de la actividad');

        return print(json_encode($json)); 
    }

    public function registrar_reporte(){
        $json = array('exito' => TRUE);
        $preproyecto = $this->input->post('preproyecto');

        if ( $preproyecto ){
            $mes        = $this->input->post('mes');
            $fisico     = $this->input->post('fisico');
            $financiero = $this->input->post('financiero');

            $datos  = array(
                'mes'                   => $mes,
                'realizado_fisico'      => $fisico,
                'realizado_financiero'  => $financiero,
                'usuario_id'            => $this->session->userdata('uid'),
            );

            $reporte = $this->model_preproyectos->actualizar_reporte($preproyecto, $datos);
            if ( $reporte ){
                $json['exito'] = $reporte['exito'];
                if ( isset($reporte['error']) )
                    $json['error'] = $reporte['error'];
            } else
                $json = array('exito' => FALSE, 'error' => 'No se pudo crear la actividad.');
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se recibió el folio del preproyecto.');
        return print(json_encode($json));
    }

    public function select_localidades(){
        $json = array('exito' => TRUE);
        $condicion = array( 'municipio_id' => $this->input->post('municipio') );
        $json['localidades']  = $this->model_catalogos->get_localidades($condicion);
        return print(json_encode($json));
    }

    public function tipo_registro(){
        $json = array('exito' => TRUE);
        $tipo = $this->input->post('tipo');
        switch ($tipo) {
            case 'proyecto':
                $json = $this->registro_proyecto();
                break;
            case 'preproyecto':
                $json = $this->registro_preproyecto();
                break;
            default:
                $json = array('exito' => FALSE, 'mensaje' => 'Opción inválida');
                break;
        }
        return print(json_encode($json));
    }

    // Función ajax para cargar documentos
    public function anexar_documento(){
        $json           = array('exito' => TRUE, 'error' => '', 'fallidos' => '');
        $ejercicio      = date('Y');
        $preproyecto_id   = $this->input->post('preproyecto_id');

        if ( !empty($_FILES) ) {
            // Carga de documentos
            $uploadFolder  = "{$this->rootPathRemoto}/{$ejercicio}/{$preproyecto_id}/";
            $localUploads  = "{$this->rootPathLocal}/{$ejercicio}/{$preproyecto_id}/";

            // Configuración de Libreriía CI Upload
            $config['upload_path']   = $uploadFolder; 
            $config['allowed_types'] = '*';
            $config['overwrite']     = 1;

            // Checar directorios Raiz y sus configuraciones
            if ( !file_exists($this->rootPathRemoto) && !is_dir($this->rootPathRemoto) )
                mkdir( $this->rootPathRemoto, 0777 ); // Crear directorio si no existe
            if ( !file_exists($this->rootPathLocal) && !is_dir($this->rootPathLocal) )
                mkdir( $this->rootPathLocal, 0777 ); // Crear directorio si no existe

            if ( !file_exists($this->rootPathRemoto . "{$ejercicio}/") && !is_dir($this->rootPathRemoto . "{$ejercicio}/") )
                mkdir( $this->rootPathRemoto . "{$ejercicio}/", 0777 ); // Crear directorio si no existe
            if ( !file_exists($this->rootPathLocal . "{$ejercicio}/") && !is_dir($this->rootPathLocal . "{$ejercicio}/") )
                mkdir( $this->rootPathLocal . "{$ejercicio}/", 0777 ); // Crear directorio si no existe

            if ( !file_exists($uploadFolder) && !is_dir($uploadFolder) )
                mkdir( $uploadFolder, 0777 ); // Crear directorio si no existe
            if ( !file_exists($localUploads) && !is_dir($localUploads) )
                mkdir( $localUploads, 0777 ); // Crear directorio si no existe

            // Subir el archivo al servidor 
            // Modo Múltiple
            foreach($_FILES['file']['tmp_name'] as $key => $file) {
                $tempFile   = $_FILES['file']['tmp_name'][$key];
                $targetFile =  $uploadFolder. $_FILES['file']['name'][$key];
                if ( move_uploaded_file($tempFile,$targetFile) ){
                    // Mover el archivo a Uploads
                    $previsualizador            = $localUploads . $_FILES['file']['name'][$key];
                    $json['previsualizador']    = '';
                    if ( !copy($targetFile, $previsualizador) )
                        $json['previsualizador'] .= $_FILES['file']['name'][$key] . ',';
                    // Guardar info en BD
                    $this->model_preproyectos->registrar_documento( $preproyecto_id, $_FILES['file']['name'][$key] );
                }
                else
                    $json['fallidos'] .= $_FILES['file']['name'][$key] . ',';
            }
        } else {
            $json['exito'] = FALSE;
            $json['error'] = 'No se recibió ningún archivo.';
        }
        return print(json_encode( $json ));
    }

//  ------- FIN DE FUNCIONES AJAX ------

/*--------------------------------------------------------------------------*
* --- FUNCIONES DE ACCESO PRIVADO 
* --------------------------------------------------------------------------*/

    private function inputs_registro(){
        return array(
            [
                'nombre'=> 'linea_accion',
                'texto' => 'Línea de Acción',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'detalle_preproyecto',
                'texto' => 'Descripción/Propuesta'
            ],
            [
                'nombre'=> 'seccion',
                'texto' => 'Número de Sección'
            ],
            [
                'nombre'=> 'url',
                'texto' => 'URL'
            ],
            [
                'nombre'=> 'incluido',
                'texto' => '¿Incluído?'
            ]
        );
    }

    private function inputs_actividad(){
        return array(
            [
                'nombre'=> 'preproyecto',
                'texto' => 'Folio de Preproyecto'
            ],
            [
                'nombre'=> 'municipio',
                'texto' => 'Municipio',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'localidad',
                'texto' => 'Localidad',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'linea_accion',
                'texto' => 'Línea de Acción'
            ],
            [
                'nombre'=> 'detalle_preproyecto',
                'texto' => 'Detalle de la Actividad'
            ],
            [
                'nombre'=> 'unidad_medida',
                'texto' => 'Unidad de Medida',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'tipo_medicion',
                'texto' => 'Tipo de Medición',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'grupo_beneficiado',
                'texto' => 'Grupo Beneficiado',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'cantidad_beneficiarios',
                'texto' => 'Cantidad de Beneficiarios'
            ],
            [
                'nombre'=> 'inversion',
                'texto' => 'Inversión'
            ],
            [
                'nombre'=> 'trimestre',
                'texto' => 'Trimestre'
            ],
            [
                'nombre'=> 'fecha_inicio',
                'texto' => 'Fecha de Inicio'
            ],
            [
                'nombre'=> 'fecha_termino',
                'texto' => 'Fecha de Término'
            ],
            [
                'nombre'=> 'seccion',
                'texto' => 'Número de Sección'
            ],
            [
                'nombre'=> 'url',
                'texto' => 'URL'
            ],
            [
                'nombre'=> 'incluido',
                'texto' => '¿Incluído?'
            ]
        );
    }

}

/* End of file Preproyectos.php */
/* Location: ./application/controllers/Preproyectos.php */