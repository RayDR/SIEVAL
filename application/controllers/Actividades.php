<?php
/* ================================================================================================================
 *  @Filename:  Controllers/Actividades.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  07-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Actividades extends CI_Controller {

    private $rootPathRemoto = 'C:/SvrArchivos/sieval/Actividades/'; // PATH a archivos locales ( Dentro de la app )
    private $rootPathLocal  = FCPATH . 'uploads/Actividades/';      // PATH para guardarlo en otro directorio ( Fuera de la app )

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_catalogos');
        $this->load->model('model_actividades');
        
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

    // Listado
    public function index()
    {
        $data = array(
            'titulo'        => 'Actividades ' . APLICACION  . ' | ' . EMPRESA,
            'menu'          => $this->model_catalogos->get_menus(),
            'view'          => 'actividades/index'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
    }

    // Vista de Registro
    public function registrar()
    {
        $json = array('exito' => TRUE);

        // Área usuario
        $area_usuario   = array('combinacion_area_id' => $this->session->userdata('combinacion_area'));
        $combinacion    = $this->model_catalogos->get_areas( $area_usuario );

        $condicion = ( $this->session->userdata('tuser') == 1 )? NULL : 
                     array( 'direccion_id' => $combinacion->direccion_id );
                     
        $data = array(
            'titulo'    => 'Registrar',
            'programas' =>  $this->model_catalogos->get_programas(),
            'proyectos' =>  $this->model_catalogos->get_proyectos(),
            'l_accion'  =>  $this->model_catalogos->get_lineas_accion(),
            'f_financia'=>  $this->model_catalogos->get_fuentes_financiamiento(),
            'u_medida'  =>  $this->model_catalogos->get_unidades_medida($condicion),
            'g_benef'   =>  $this->model_catalogos->get_grupos_beneficiados(),
            'mediciones'=>  $this->model_catalogos->get_mediciones(),
            'inputs'    =>  $this->inputs_registro(),
            'view'      => 'actividades/registrar'
        );
        $json['html'] = $this->load->view( $data['view'], $data, TRUE );
        return print(json_encode($json));    
    }

    // Vista de Edición de Actividad
    public function editar()
    {
        $json = array('exito' => TRUE);
        $actividad_id = $this->input->post('actividad');

        // Área usuario
        $area_usuario   = array('combinacion_area_id' => $this->session->userdata('combinacion_area'));
        $combinacion    = $this->model_catalogos->get_areas( $area_usuario );

        $condicion = ( $this->session->userdata('tuser') == 1 )? NULL : 
                     array( 'direccion_id' => $combinacion->direccion_id );

        if ( $actividad_id ){
            $encabezado   = $this->model_actividades->get_actividad($actividad_id);
            $detalles     = $this->model_actividades->get_seguimiento_actividades($actividad_id);
            $data = array(
                'titulo'    => 'Registrar',
                'view'      => 'actividades/editar',
                'encabezado'=> $encabezado,
                'detalles'  => $detalles,
                'programas' => $this->model_catalogos->get_programas(),
                'proyectos' =>  $this->model_catalogos->get_proyectos(),
                'l_accion'  => $this->model_catalogos->get_lineas_accion(),
                'f_financia'=> $this->model_catalogos->get_fuentes_financiamiento(),
                'g_benef'   => $this->model_catalogos->get_grupos_beneficiados(),
                'mediciones'=> $this->model_catalogos->get_mediciones(),
                'u_medida'  => $this->model_catalogos->get_unidades_medida($condicion),
                'inputs'    => $this->inputs_registro()
            );
            $json['html'] = $this->load->view( $data['view'], $data, TRUE );
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se recibió el folio de la actividad.');
        return print(json_encode($json));    
    }

    // Vista de Reporte de Actividad - Seguimiento
    public function reporte()
    {
        $json = array('exito' => TRUE);
        $actividad_id = $this->input->post('actividad');
        if ( $actividad_id ){
            $encabezado   = $this->model_actividades->get_actividad($actividad_id);
            $detalles     = $this->model_actividades->get_seguimiento_actividades($actividad_id);
            if ( $encabezado && $detalles ){
                $data = array(
                    'titulo'    => 'Registrar',
                    'view'      => 'actividades/reporte',
                    'encabezado'=> $encabezado,
                    'detalles'  => $detalles,
                );
                $json['html'] = $this->load->view( $data['view'], $data, TRUE );
            } else 
                $json = array('exito' => FALSE, 'error' => 'No se recuperó información sobre esta actividad.');
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se recibió el folio de la actividad.');
        return print(json_encode($json));    
    }


    public function generar_reporte($actividad_id = NULL){
        $actividad_id = ( $actividad_id )? $actividad_id : $this->input->post('actividad');
        if ( $actividad_id ){
            $encabezado     = $this->model_actividades->get_actividad($actividad_id, NULL, FALSE);
            $detalles       = $this->model_actividades->get_seguimiento_actividades($actividad_id, NULL, FALSE);
            $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet    = $reader->load( FCPATH . 'uploads/FORMATO_PAT.xlsx' );

            $reporte    = "ReporteActividad_{$actividad_id}_".date('dmY_His').".xlsx";     
            $sheet      = $spreadsheet->getActiveSheet();

            $sheetMapping = array(
                'X4'  => 'mostrar_fecha',
                'E3'  => 'direccion',
                'E4'  => 'subdireccion',
                'E5'  => 'departamento',
                'E6'  => 'objetivo_programa',
                'E8'  => 'linea_accion',
                'E9'  => 'programa_presupuestario_clave',
                'M7'  => 'estrategia_programa',
                'A11' => 'actividad_id',
                'B11' => 'actividad_general',
                'F11' => 'programado_financiero',
                'G11' => 'proyecto_nombre',
                'O11' => 'unidad_medida',
                'X11' => 'cantidad_beneficiario'
            );

            foreach ($sheetMapping as $celda => $campo) {
                switch ($campo) {
                    case 'mostrar_fecha':
                        $valor = date('d-m-Y');
                        break;
                    
                    default:
                        $valor = $encabezado[$campo];
                        break;
                }
                if ( $valor )
                    $sheet->setCellValue($celda, $valor);
            }

            $presupuesto = array(); $metas = array();
            $programadoPresupuesto  = array();
            $ejercidoPresupuesto    = array();
            $programadoMetas        = array();
            $ejercidoMetas          = array();
            foreach ($detalles as $key => $detalle) {    
                array_push($programadoPresupuesto, ($detalle['programado_financiero'])? $detalle['programado_financiero'] : 0);
                array_push($ejercidoPresupuesto, ($detalle['realizado_financiero'])? $detalle['realizado_financiero'] : 0);

                array_push($programadoMetas, ($detalle['programado_fisico'])? $detalle['programado_fisico'] : 0);
                array_push($ejercidoMetas, ($detalle['realizado_fisico'])? $detalle['realizado_fisico'] : 0);
            }
            array_push($presupuesto, $programadoPresupuesto);
            array_push($presupuesto, $ejercidoPresupuesto);

            array_push($metas, $programadoMetas);
            array_push($metas, $ejercidoMetas);
            // print_r($presupuesto);

            // echo '<hr>';
            // print_r($metas);
            $sheet->fromArray($presupuesto, 0,'H15');
            $sheet->fromArray($metas, 0,'H18');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode($reporte).'"');
            $writer->save('php://output');
        } else {
            print(
                json_encode(
                    array('exito'   => FALSE, 
                          'error'   => 'No se pudo generar el reporte.',
                          'estatus' => 'error_reporte', 
                          'mensaje' => 'No se ha recibido el folio de la actividad.'
                    )
                )
            );
            redirect(base_url('index.php/Home/login'),'refresh');
        }

    }
//  ------- FIN DE VISTAS ------

/*--------------------------------------------------------------------------*
* ---- FUNCIONES AJAX 
* --------------------------------------------------*/

    /*------------------------------
    * -- VISTAS AJAX
    * ---------------------*/

    public function detalles_actividad(){
        $json = array('exito' => TRUE);
        $actividad_id = $this->input->post('actividad_id');
        if ( $actividad_id ){
            $data = array(
                'titulo'    => 'Detalle de Actividad',
                'encabezado'=> $this->model_actividades->get_actividad($actividad_id),
                'detalles'  => $this->model_actividades->get_seguimiento_actividades($actividad_id),
                'view'      => 'actividades/detalle_actividad'
            );
            $json['html'] = $this->load->view( $data['view'], $data, TRUE );
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se obtuvo el número de actividad.');
        return print(json_encode($json));
    }

    /*------------------------------
    * --- DATOS AJAX
    * ---------------------*/

    // Datatable
    public function datatable_actividades(){
        $condicion = array();
        if ( $this->session->userdata('tuser') != 1 ){
            $where       = array('combinacion_area_id' => $this->session->userdata('combinacion_area')); 
            $combinacion = $this->model_catalogos->get_areas( $where );
            if ( $combinacion ){
            } else
                return print(json_encode([]));
        } 
        return print(json_encode( $this->model_actividades->get_actividades($condicion) ));
    }

    // Función de Guardado
    public function guardar(){
        $json = array('exito' => TRUE);
        $area_origen                    = $this->input->post('area_origen');
        $linea_accion                   = $this->input->post('linea_accion');
        $fuente_financiamiento          = $this->input->post('fuente_financiamiento');
        $detalle_actividad              = $this->input->post('detalle_actividad');
        $unidad_medida                  = $this->input->post('unidad_medida');
        $tipo_medicion                  = $this->input->post('tipo_medicion');
        $grupo_beneficiado              = $this->input->post('grupo_beneficiado');
        $programa_presupuestario        = $this->input->post('programa_presupuestario');
        $programado_fisico              = $this->input->post('fisico_objetivo_anual');
        $programado_fisico_mensual      = $this->input->post('programado-fisico');
        $programado_financiero          = $this->input->post('financiero_objetivo_anual');
        $programado_financiero_mensual  = $this->input->post('programado-financiero');

        $datos  = array(
            'area_origen'                   => $area_origen,
            'programa_presupuestario'       => $programa_presupuestario,
            'linea_accion'                  => $linea_accion,
            'fuente_financiamiento'         => $fuente_financiamiento,
            'detalle_actividad'             => $detalle_actividad,
            'unidad_medida'                 => $unidad_medida,
            'tipo_medicion'                 => $tipo_medicion,
            'grupo_beneficiado'             => $grupo_beneficiado,
            'programado_fisico'             => $programado_fisico,
            'programado_fisico_mensual'     => $programado_fisico_mensual,
            'programado_financiero'         => $programado_financiero,
            'programado_financiero_mensual' => $programado_financiero_mensual,
            'usuario_id'                    => $this->session->userdata('uid'),
            'ejercicio'                     => date('Y')
        );

        $json = $this->model_actividades->set_nueva_actividad($datos);
        return print(json_encode($json));
    }

    public function guardar_edicion(){
        $json = array('exito' => TRUE);
        
        $proyecto_actividad_id  = $this->input->post('proyecto_id');
        $actividad_id           = $this->input->post('actividad_id');

        $area_origen                    = $this->input->post('area_origen');
        $linea_accion                   = $this->input->post('linea_accion');
        $fuente_financiamiento          = $this->input->post('fuente_financiamiento');
        $detalle_actividad              = $this->input->post('detalle_actividad');
        $unidad_medida                  = $this->input->post('unidad_medida');
        $tipo_medicion                  = $this->input->post('tipo_medicion');
        $grupo_beneficiado              = $this->input->post('grupo_beneficiado');
        $programa_presupuestario        = $this->input->post('programa_presupuestario');
        $programado_fisico              = $this->input->post('fisico_objetivo_anual');
        $programado_fisico_mensual      = $this->input->post('programado-fisico');
        $programado_financiero          = $this->input->post('financiero_objetivo_anual');
        $programado_financiero_mensual  = $this->input->post('programado-financiero');

        $datos  = array(
            'area_origen'                   => $area_origen,
            'programa_presupuestario'       => $programa_presupuestario,
            'linea_accion'                  => $linea_accion,
            'fuente_financiamiento'         => $fuente_financiamiento,
            'detalle_actividad'             => $detalle_actividad,
            'unidad_medida'                 => $unidad_medida,
            'tipo_medicion'                 => $tipo_medicion,
            'grupo_beneficiado'             => $grupo_beneficiado,
            'programado_fisico'             => $programado_fisico,
            'programado_fisico_mensual'     => $programado_fisico_mensual,
            'programado_financiero'         => $programado_financiero,
            'programado_financiero_mensual' => $programado_financiero_mensual,
            'usuario_id'                    => $this->session->userdata('uid'),
            'ejercicio'                     => date('Y')
        );

        $json = $this->model_actividades->update_proyecto_actividad($proyecto_actividad_id, $actividad_id, $datos);
        return print(json_encode($json));
    }

    // Registro de Reporte - Seguimiento
    public function registrar_reporte(){
        $json = array('exito' => TRUE);
        $actividad_detallada = $this->input->post('actividad_detallada');

        if ( $actividad_detallada ){
            $datos  = array(
                'mes'                   => $this->input->post('mes'),
                'realizado_fisico'      => $this->input->post('fisico'),
                'realizado_financiero'  => $this->input->post('financiero'),
                'descripcion'           => $this->input->post('narrativa'),
                'usuario_id'            => $this->session->userdata('uid'),
            );

            $reporte = $this->model_actividades->actualizar_reporte($actividad_detallada, $datos);
            if ( $reporte ){
                $json['exito'] = $reporte['exito'];
                if ( isset($reporte['error']) )
                    $json['error'] = $reporte['error'];
            } else
                $json = array('exito' => FALSE, 'error' => 'No se pudo realizar el reporte del mes.');
        } else 
            $json = array('exito' => FALSE, 'error' => 'No se recibió el mes a reportar.');
        return print(json_encode($json));
    }
    
    // Función ajax para cargar documentos
    public function anexar_documento(){
        $json           = array('exito' => TRUE, 'error' => '', 'fallidos' => '');
        $ejercicio      = date('Y');
        $actividad_id   = $this->input->post('actividad_id');

        if ( !empty($_FILES) ) {
            // Carga de documentos
            $uploadFolder  = "{$this->rootPathRemoto}/{$ejercicio}/{$actividad_id}/";
            $localUploads  = "{$this->rootPathLocal}/{$ejercicio}/{$actividad_id}/";

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
                    $this->model_actividades->registrar_documento( $actividad_id, $_FILES['file']['name'][$key] );
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
                'nombre'=> 'area_origen',
                'texto' => 'Área',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'programa_presupuestario',
                'texto' => 'Programa Presupuestario',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'proyecto',
                'texto' => 'Proyecto',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'linea_accion',
                'texto' => 'Línea de Acción',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'fuente_financiamiento',
                'texto' => 'Fuente de Financiamiento',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'detalle_actividad',
                'texto' => 'Detalle de la Actividad'
            ],
            [
                'nombre'=> 'unidad_medida',
                'texto' => 'Unidad de Análisis',
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
                'texto' => 'Población Objetivo'
            ],
            [
                'nombre'=> 'fisico_objetivo_anual',
                'texto' => 'Objetivo Anual (Físico)'
            ],
            [
                'nombre'=> 'programado-fisico',
                'texto' => 'Distribución Mensual Ponderada (Físico)'
            ],
            [
                'nombre'=> 'financiero_objetivo_anual',
                'texto' => 'Objetivo Anual (Financiero)'
            ],
            [
                'nombre'=> 'programado-financiero',
                'texto' => 'Distribución Mensual Ponderada (Financiero)'
            ]
        );
    }

}

/* End of file Actividades.php */
/* Location: ./application/controllers/Actividades.php */