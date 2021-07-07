 <?php
/* ================================================================================================================
 *  @Filename:  Controllers/Configurador.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  07-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Configurador extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_catalogos');
        
        if ( !$this->session->estatus_usuario_sesion() ){
            print(json_encode(array('estatus' => 'sess_expired', 'mensaje' => 'Su sesión ha caducado. Por favor, recargue la página.')));
            redirect(base_url('index.php/Home/login'),'refresh');
        }
    }

/*--------------------------------------------------------------------------*
* ---- VISTAS 
* --------------------------------------------------*/

    public function programas()
    {
        $data = array(
            'titulo'        => 'Configuración - Programas '  . ' | ' . EMPRESA,
            'menu'          => $this->model_catalogos->get_menus(),
            'view'          => 'configurador/programas/index'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
    }

    public function proyectos()
    {
        $data = array(
            'titulo'        => 'Configuración - Proyectos '  . ' | ' . EMPRESA,
            'menu'          => $this->model_catalogos->get_menus(),
            'view'          => 'configurador/proyectos/index'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
    }

    public function usuarios()
    {
        $data = array(
            'titulo'        => 'Configuración - Usuarios '  . ' | ' . EMPRESA,
            'menu'          => $this->model_catalogos->get_menus(),
            'view'          => 'configurador/usuarios/index'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
    }

//  ------- FIN DE VISTAS ------

/*--------------------------------------------------------------------------*
* ---- FUNCIONES AJAX 
* --------------------------------------------------*/

    /*------------------------------
    * -- VISTAS AJAX
    * ---------------------*/

    public function registrar($opcion){
        $json  = array('exito' => TRUE);
        if ( is_string($opcion) ){
            switch ($opcion) {
                case 'Proyecto':
                    $titulo = 'Registrar Proyecto';
                    $data   = array(
                        'titulo'    => $titulo  . ' | ' . EMPRESA,
                        'menu'      => $this->model_catalogos->get_menus(),
                        'programas' =>  $this->model_catalogos->get_programas(),
                        'l_accion'  =>  $this->model_catalogos->get_lineas_accion(),
                        'f_financia'=>  $this->model_catalogos->get_fuentes_financiamiento(),
                        'g_benef'   =>  $this->model_catalogos->get_grupos_beneficiados(),
                        'view'      => 'configurador/proyectos/registrar'
                    );
                    break;
                case 'ProgramaPresupuestario':
                    $titulo = 'Registrar Programa Presupuestario';
                    $data   = array(
                        'titulo'    => $titulo  . ' | ' . EMPRESA,
                        'menu'      => $this->model_catalogos->get_menus(),
                        'view'      => 'configurador/programas/registrar'
                    );
                    break;
                case 'Usuario':
                    $titulo = 'Registrar Usuario';
                    $data   = array(
                        'titulo'    => $titulo  . ' | ' . EMPRESA,
                        'menu'      => $this->model_catalogos->get_menus(),
                        'view'      => 'configurador/usuarios/registrar'
                    );
                    break;
                default:
                    $opcion = NULL;
                    $json   = array('exito' => FALSE, 'error' => 'Se ha recibido una opción inválida');
                    break;
            }
            // Abrir la vista
            if ( $opcion ){
                $this->load->view( RUTA_TEMA . 'body', $data, FALSE);
            }
        } else 
            $json  = array('exito' => FALSE, 'error' => 'Opción inválida.');
        
        if ( !$json['exito'] )
            redirect(base_url(), 'refresh');
        
    }

    /*------------------------------
    * --- DATOS AJAX
    * ---------------------*/

    public function registrar_proyecto(){

    }

    /*------------------------------
    * --- CATALOGOS AJAX
    * ---------------------*/
    
    // Catálogo de Áreas - SELECT2
    public function get_areas_select2(){
        $json  = array('exito' => FALSE);
        $areas = $this->model_catalogos->get_areas();

        if ( $areas ){
            $json['exito']  = TRUE;
            $resultados     = [];

            $direccion      = $areas[0]->direccion;
            $children       = [];
            $guardar_dir    = TRUE;
            // Asignar los hijos
            foreach ($areas as $key => $grupos_areas) {
                if ( $direccion != $grupos_areas->direccion ){
                    // Guardar en resultados
                    array_push($resultados, array(
                        'text'      => $direccion,
                        'children'  => $children
                    ));
                    // Reiniciar
                    $children       = [];
                    $direccion      = $grupos_areas->direccion;
                    $guardar_dir    = TRUE;
                }
                // Almacenar el hijo
                if ( $guardar_dir ){
                    array_push($children, array(
                        'id'    => $grupos_areas->combinacion_area_id,
                        'text'  => $grupos_areas->direccion
                    ));
                    $guardar_dir = FALSE;
                } else {
                    array_push($children, array(
                        'id'    => $grupos_areas->combinacion_area_id,
                        'text'  => trim($grupos_areas->subdireccion . ' ' . 
                                   $grupos_areas->departamento . ' ' . 
                                   $grupos_areas->area)
                    ));
                }
            }
        } else 
            $json['mensaje'] = 'No se encontraron datos.';

        $json['result'] = $resultados;
        return print(json_encode($json));
    }

    // Catálogo de Proyectos - SELECT2
    public function get_proyectos_select2(){
        $json  = array('exito' => FALSE);
        $areas = $this->model_catalogos->get_areas();

        if ( $areas ){
            $json['exito']  = TRUE;
            $resultados     = [];

            $direccion      = $areas[0]->direccion;
            $children       = [];
            $guardar_dir    = TRUE;
            // Asignar los hijos
            foreach ($areas as $key => $grupos_areas) {
                if ( $direccion != $grupos_areas->direccion ){
                    // Guardar en resultados
                    array_push($resultados, array(
                        'text'      => $direccion,
                        'children'  => $children
                    ));
                    // Reiniciar
                    $children       = [];
                    $direccion      = $grupos_areas->direccion;
                    $guardar_dir    = TRUE;
                }
                // Almacenar el hijo
                if ( $guardar_dir ){
                    array_push($children, array(
                        'id'    => $grupos_areas->combinacion_area_id,
                        'text'  => $grupos_areas->direccion
                    ));
                    $guardar_dir = FALSE;
                } else {
                    array_push($children, array(
                        'id'    => $grupos_areas->combinacion_area_id,
                        'text'  => trim($grupos_areas->subdireccion . ' ' . 
                                   $grupos_areas->departamento . ' ' . 
                                   $grupos_areas->area)
                    ));
                }
            }
        } else 
            $json['mensaje'] = 'No se encontraron datos.';

        $json['result'] = $resultados;
        return print(json_encode($json));
    }

    // Catálogo de Unidades de Medida - SELECT2
    public function get_ums_select2(){
        $json  = array('exito' => FALSE);

        $area_usuario   = array('combinacion_area_id' => $this->input->post('combinacion_area'));
        $combinacion    = $this->model_catalogos->get_areas( $area_usuario );

        $condicion  = array( 'direccion_id' => $combinacion->direccion_id );
        $resultados = []; // Inicializar el array SELECT2
        $ums        = $this->model_catalogos->get_unidades_medida($condicion);

        if ( !$ums )
            $ums = $this->model_catalogos->get_unidades_medida();

        if ( $ums ){
            $json['exito'] = TRUE;
            foreach ($ums as $key => $um) {
                array_push($resultados, array(
                    'id'    => $um->unidad_medida_id,
                    'text'  => $um->cve_medida . ' - ' . $um->descripcion
                ));
            } 
        } else // Sin datos
            $json['mensaje'] = 'No se encontraron datos.';
        $json['result'] = $resultados;

        return print(json_encode($json));
    }

    // ----------- DATATABLES

    public function datatable_programas(){
        return print(json_encode($this->model_catalogos->get_programas()));
    }

    public function datatable_proyectos(){
        return print(json_encode($this->model_catalogos->get_proyectos()));
    }

    public function datatable_usuarios(){
        $this->load->model('model_usuarios');
        return print(json_encode($this->model_usuarios->get_usuarios()));
    }

    public function datatable_areas(){
        return print(json_encode($this->model_catalogos->get_areas()));
    }

/*--------------------------------------------------------------------------*
* ---- FUNCIONES PRIVADAS 
* --------------------------------------------------*/

    private function inputs_proyecto(){
        return array(
            [
                'nombre'=> 'nombre_proyecto',
                'texto' => 'Nombre del Proyecto',
            ],
            [
                'nombre'=> 'area_responsable',
                'texto' => 'Área Responsable',
                'tipo'  => 'select'
            ],
            [
                'nombre'=> 'programa_presupuestario',
                'texto' => 'Programa Presupuestario',
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
            ]
        );
    }

}

/* End of file Configurador.php */
/* Location: ./application/controllers/Configurador.php */