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

      $this->load->model('model_proyectos');
      $this->load->model('model_programas');
      $this->load->model('model_usuarios');
      
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

   public function ums(){
      $data = array(
         'titulo'        => 'Configuración - Unidades de Medida '  . ' | ' . EMPRESA,
         'menu'          => $this->model_catalogos->get_menus(),
         'view'          => 'configurador/ums/index'
      );
      $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
   }

   public function areas(){
      $data = array(
         'titulo'        => 'Configuración - Asignación y Configuración de Áreas'  . ' | ' . EMPRESA,
         'menu'          => $this->model_catalogos->get_menus(),
         'view'          => 'configurador/areas/index'
      );
      $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
   }

   public function umbrales(){
      $data = array(
         'titulo'        => 'Configuración - Umbrales '  . ' | ' . EMPRESA,
         'menu'          => $this->model_catalogos->get_menus(),
         'view'          => 'configurador/umbrales/index'
      );
      $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
   }

   public function firmantes(){
      $data = array(
         'titulo'        => 'Configuración - Firmantes '  . ' | ' . EMPRESA,
         'menu'          => $this->model_catalogos->get_menus(),
         'view'          => 'configurador/firmantes/index'
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
                  'inputs'    => $this->inputs_proyecto(),
                  'view'      => 'configurador/proyectos/registrar'
               );
               break;
            case 'ProgramaPresupuestario':
               $titulo = 'Registrar Programa Presupuestario';
               $data   = array(
                  'titulo'    => $titulo  . ' | ' . EMPRESA,
                  'programas' => $this->model_catalogos->get_programas(),
                  'l_accion'  => $this->model_catalogos->get_lineas_accion(),
                  'f_financia'=> $this->model_catalogos->get_fuentes_financiamiento(),
                  'g_benef'   => $this->model_catalogos->get_grupos_beneficiados(),
                  'menu'      => $this->model_catalogos->get_menus(),
                  'inputs'    => $this->inputs_programas(),
                  'view'      => 'configurador/programas/registrar'
               );
               break;
            case 'Usuario':
               $titulo = 'Registrar Usuario';
               $data   = array(
                  'titulo'    => $titulo  . ' | ' . EMPRESA,
                  'menu'      => $this->model_catalogos->get_menus(),
                  'categorias'=> $this->model_catalogos->get_categorias(),
                  'inputs'    => $this->inputs_usuarios(),
                  'view'      => 'configurador/usuarios/registrar'
               );
               break;
            case 'Ums':
               $titulo = 'Registrar Unidad de Medida';
               $data   = array(
                  'titulo'    => $titulo  . ' | ' . EMPRESA,
                  'menu'      => $this->model_catalogos->get_menus(),
                  'inputs'    => $this->inputs_usuarios(),
                  'view'      => 'configurador/ums/registrar'
               );
               break;
            case 'Direccion':
               $titulo = 'Registrar Dirección';
               $data   = array(
                  'titulo'    => $titulo  . ' | ' . EMPRESA,
                  'menu'      => $this->model_catalogos->get_menus(),
                  'inputs'    => $this->inputs_direccion(),
                  'view'      => 'configurador/areas/registrar_direccion'
               );
               break;
            case 'Area':
               $titulo = 'Registrar Combinación de Área';
               $data   = array(
                  'titulo'       => $titulo  . ' | ' . EMPRESA,
                  'menu'         => $this->model_catalogos->get_menus(),
                  'inputs'       => $this->inputs_areas(),
                  'direcciones'  => $this->model_catalogos->get_direcciones(),
                  'view'         => 'configurador/areas/registrar_area'
               );
               break;
            case 'Umbral':
               $titulo = 'Registrar Umbral';
               $data   = array(
                  'titulo'       => $titulo  . ' | ' . EMPRESA,
                  'menu'         => $this->model_catalogos->get_menus(),
                  'inputs'       => $this->inputs_umbral(),
                  'view'         => 'configurador/umbrales/registrar'
               );
               break;
            case 'Firmante':
               $titulo = 'Registrar Firmante';
               $data   = array(
                  'titulo'       => $titulo  . ' | ' . EMPRESA,
                  'menu'         => $this->model_catalogos->get_menus(),
                  'inputs'       => $this->inputs_firmante(),
                  'usuarios'     => $this->model_usuarios->get_usuarios(),
                  'view'         => 'configurador/firmantes/registrar'
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

   public function modal($opcion){
      $json  = array('exito' => TRUE);
      if ( is_string($opcion) ){
         switch ($opcion) {
            case 'proyecto':
               $titulo = 'Proyecto';
               $proyecto_id = $this->input->post('proyecto_id');
               if ( $proyecto_id ){
                  $data   = array(
                     'titulo'    => $titulo  . ' | ' . EMPRESA,
                     'view'      => 'configurador/proyectos/modal',
                     'proyecto'  => $this->model_proyectos->get_proyecto($proyecto_id)
                  );
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el número de Proyecto');
               }
               break;
            case 'programas':
               $titulo = 'Programa Presupuestario';
               $programa_id = $this->input->post('proyecto_id');
               if ( $programa_id ){
                  $data   = array(
                     'titulo'    => $titulo  . ' | ' . EMPRESA,
                     'view'      => 'configurador/programas/modal',
                     'programas' => $this->model_catalogos->get_programas(),
                     'l_accion'  => $this->model_catalogos->get_lineas_accion(),
                     'f_financia'=> $this->model_catalogos->get_fuentes_financiamiento(),
                     'g_benef'   => $this->model_catalogos->get_grupos_beneficiados(),
                     'programa'  => $this->model_catalogos->get_programas(['programa_presupuestario_id' => $programa_id])
                  );
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el número de Programa Presupuestal');
               }
               break;
            case 'usuario':
               $titulo = 'Usuario';
               $usuario_id = $this->input->post('usuario_id');
               if ( $usuario_id ){
                  $data   = array(
                     'titulo'    => $titulo  . ' | ' . EMPRESA,
                     'categorias'=> $this->model_catalogos->get_categorias(),
                     'view'      => 'configurador/usuarios/modal',
                     'usuario'   => $this->model_usuarios->get_usuario($usuario_id)
                  );
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el número de Usuario');
               }
               break;
            case 'ums':
               $titulo = 'Unidad de Medida';
               $medida_id = $this->input->post('medida_id');
               if ( $medida_id ){
                  $data   = array(
                     'titulo'    => $titulo  . ' | ' . EMPRESA,
                     'um'        => $this->model_catalogos->get_unidad_medida_id($medida_id),
                     'view'      => 'configurador/ums/modal',
                  );
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el identificador de UM.');
               }
               break;
            case 'direccion':
               $titulo = 'Dirección';
               $direccion_id = $this->input->post('direccion_id');
               if ( $direccion_id ){
                  $data   = array(
                     'titulo'       => $titulo  . ' | ' . EMPRESA,
                     'direccion'    => $this->model_catalogos->get_direccion_id($direccion_id),
                     'combinaciones'=> $this->model_catalogos->get_areas(['direccion_id' => $direccion_id]),
                     'view'         => 'configurador/areas/modal',
                  );
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el identificador de Dirección.');
               }
               break;
            case 'umbral':
               $titulo = 'Umbral';
               $umbral_id = $this->input->post('umbral_id');
               if ( $umbral_id ){
                  $data   = array(
                     'titulo'       => $titulo  . ' | ' . EMPRESA,
                     'umbral'       => $this->model_catalogos->get_umbral_id($umbral_id),
                     'view'         => 'configurador/umbrales/modal',
                  );
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el identificador de Umbral.');
               }
               break;
            case 'firmantes':
               $titulo = 'Firmante';
               $firmante_id = $this->input->post('firmante_id');
               if ( $firmante_id ){
                  $data   = array(
                     'titulo'    => $titulo  . ' | ' . EMPRESA,
                     'firmante'  => $this->model_catalogos->get_firmante_id($firmante_id),
                     'view'      => 'configurador/firmantes/modal',
                  );
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el identificador del Firmante.');
               }
               break;
            default:
               $opcion = NULL;
               $json   = array('exito' => FALSE, 'error' => 'Se ha recibido una opción inválida');
               break;
         }
         // Abrir la vista
         if ( $opcion ){
            $json['html'] = $this->load->view($data['view'], $data, TRUE);
         }
      } else 
         $json  = array('exito' => FALSE, 'error' => 'Opción inválida.');
      
      return print(json_encode($json));
   }

   public function editar($opcion){
      $json  = array('exito' => TRUE);
      if ( is_string($opcion) ){
         switch ($opcion) {
            case 'proyecto':
               $titulo = 'Editar Proyecto';
               $proyecto_id = $this->input->post('proyecto_actividad_id');
               if ( $proyecto_id ){
                  // Data a editar
                  $datos  = array(
                     'proyecto_nombre'       => $this->input->post('proyecto_nombre'),
                     'techo_financiero'      => $this->input->post('techo_financiero'),
                     'combinacion_area'      => ( $this->input->post('area_responsable') )? 
                                                  $this->input->post('area_responsable')  : null,
                  );

                  $json = $this->model_proyectos->update_proyecto($proyecto_id, $datos);
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el número de Proyecto');
               }
               break;
            case 'programa':
               $titulo = 'Editar Programa Presupuestario';
               $programa_id = $this->input->post('programa_presupuestario_id');
               if ( $programa_id ){
                  // Data a editar
                  $datos = array(
                     'clave'           => $this->input->post('clave'),
                     'nombre'          => $this->input->post('nombre'),
                     'descripcion'     => $this->input->post('descripcion'),
                     'objetivo'        => $this->input->post('objetivo'),
                     'techo_financiero'=> $this->input->post('techo_financiero')
                  );

                  $json = $this->model_programas->update_programa($programa_id, $datos);
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el número de Programa Presupuestal');
               }
               break;
            case 'usuario':
               $titulo = 'Editar Usuario';
               $usuario_id = $this->input->post('usuario_id');
               if ( $usuario_id ){
                  // Data a editar
                  $datos = array(
                     'area_usuaria'       =>  $this->input->post('area_usuaria'),
                     'nombres'            =>  $this->input->post('nombres'),
                     'primer_apellido'    =>  $this->input->post('primer_apellido'),
                     'segundo_apellido'   =>  $this->input->post('segundo_apellido'),
                     'categoria'          =>  $this->input->post('categoria'),
                     'sexo'               =>  $this->input->post('sexo'),
                     'correo'             =>  $this->input->post('correo'),
                     'telefono'           =>  $this->input->post('telefono'),
                     'usuario'            =>  $this->input->post('cuenta'),
                     'cve_cuenta'         =>  $this->input->post('cuenta'),
                  );
                  $json = $this->model_usuarios->update_usuario($usuario_id, $datos);
               } else {
                  $opcion  = NULL;
                  $json    = array('exito' => FALSE, 'error' => 'No se recibió el número de Usuario');
               }
               break;
            default:
               $opcion = NULL;
               $json   = array('exito' => FALSE, 'error' => 'Se ha recibido una opción inválida');
               break;
         }
      } else 
         $json  = array('exito' => FALSE, 'error' => 'Opción inválida.');
      
      return print(json_encode($json));
   }

   /*------------------------------
   * --- DATOS AJAX
   * ---------------------*/

   public function registra_proyecto(){
      $json  = array('exito' => FALSE);

      $proyecto_nombre        = $this->input->post('proyecto_nombre');
      $techo_financiero       = $this->input->post('techo_financiero');
      $area_responsable       = $this->input->post('area_responsable');

      $datos  = array(
         'proyecto_nombre'       => $proyecto_nombre,
         'techo_financiero'      => $techo_financiero,
         'combinacion_area'      => ($area_responsable)? $area_responsable : null,
         'usuario_id'            => $this->session->userdata('uid'),
         'ejercicio'             => date('Y')
      );

      $json = $this->model_proyectos->set_proyecto($datos);
      return print(json_encode($json));
   }

   public function registra_usuario(){
      $json  = array('exito' => FALSE);

      $datos = array(
         'area_usuaria'       =>  $this->input->post('area_usuaria'),
         'nombres'            =>  $this->input->post('nombres'),
         'primer_apellido'    =>  $this->input->post('primer_apellido'),
         'segundo_apellido'   =>  $this->input->post('segundo_apellido'),
         'categoria'          =>  $this->input->post('categoria'),
         'sexo'               =>  $this->input->post('sexo'),
         'correo'             =>  $this->input->post('correo'),
         'telefono'           =>  $this->input->post('telefono'),
         'usuario'            =>  $this->input->post('usuario'),
         'cve_cuenta'         =>  $this->input->post('usuario'),
         'password'           =>  $this->input->post('password')
      );

      $json = $this->model_usuarios->set_usuario($datos);
      return print(json_encode($json));
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
         $json['error'] = 'No se encontraron datos.';

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
         $json['error'] = 'No se encontraron datos.';
      $json['result'] = $resultados;

      return print(json_encode($json));
   }

   // Catálogo de Usuarios - SELECT2
   public function get_usuarios_select2(){
      $json       = array('exito' => FALSE);
      $usuarios   = $this->model_usuarios->get_usuarios();

      if ( $usuarios ){
         $json['exito']  = TRUE;
         $resultados     = [];
         foreach ($usuarios as $key => $usuario) {
            array_push($resultados, array(
               'id'    => $usuario->usuario_id,
               'text'  => $usuario->usuario . ' - ' . $usuario->nombre_completo
            ));
         } 
      } else 
         $json['error'] = 'No se encontraron datos.';

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
      return print(json_encode($this->model_usuarios->get_usuarios()));
   }

   public function datatable_direcciones(){
      return print(json_encode($this->model_catalogos->get_direcciones()));
   }

   public function datatable_umbrales(){
      return print(json_encode($this->model_catalogos->get_umbrales()));
   }

   public function datatable_firmantes(){
      return print(json_encode($this->model_catalogos->get_firmantes()));
   }

   public function datatable_ums(){
      return print(json_encode($this->model_catalogos->get_ums()));
   }

/*--------------------------------------------------------------------------*
* ---- FUNCIONES PRIVADAS 
* --------------------------------------------------*/

   private function inputs_proyecto(){
      return array(
         [
            'nombre'=> 'proyecto_nombre',
            'texto' => 'Nombre del Proyecto',
         ],
         [
            'nombre'=> 'techo_financiero',
            'texto' => 'Techo Financiero'
         ],
         [
            'nombre'=> 'area_responsable',
            'texto' => 'Área Responsable',
            'tipo'  => 'select'
         ]
      );
   }

   private function inputs_programas(){
      return array(
         [
            'nombre'=> 'nombre_programa',
            'texto' => 'Nombre del Programa',
         ],
         [
            'nombre'=> 'clave_programa',
            'texto' => 'Clave del Programa'
         ],
         [
            'nombre'=> 'descripcion',
            'texto' => 'Descripción'
         ],
         [
            'nombre'=> 'objetivo',
            'texto' => 'Objetivo'
         ],
         [
            'nombre'=> 'techo_financiero',
            'texto' => 'Techo Financiero'
         ]
      );
   }

   private function inputs_usuarios(){
      return array(
         [
            'nombre'=> 'area_usuaria',
            'texto' => 'Área Usuaria',
            'tipo'  => 'select'
         ],
         [
            'nombre'=> 'nombres',
            'texto' => 'Nombre(s)',
         ],
         [
            'nombre'=> 'primer_apellido',
            'texto' => 'Primer Apellido'
         ],
         [
            'nombre'=> 'segundo_apellido',
            'texto' => 'Segundo Apellido'
         ],
         [
            'nombre'=> 'sexo',
            'texto' => 'Sexo'
         ],
         [
            'nombre'=> 'usuario',
            'texto' => 'Número de Cuenta'
         ],
         [
            'nombre'=> 'password',
            'texto' => 'Contraseña'
         ],         
         [
            'nombre'=> 'categoria',
            'texto' => 'Categoría'
         ],
         [
            'nombre'=> 'correo',
            'texto' => 'Correo Electrónico'
         ],
         [
            'nombre'=> 'telefono',
            'texto' => 'Teléfono'
         ]
      );
   }

   private function inputs_direccion(){
      return array(
         [
            'nombre'=> 'descripcion',
            'texto' => 'Nombre de la Dirección',
         ],
         [
            'nombre'=> 'clave',
            'texto' => 'Clave de la Dirección',
         ],
      );
   }

   private function inputs_areas(){
      return array(
         [
            'nombre'=> 'direccion_id',
            'texto' => 'Dirección',
            'tipo'  => 'select'
         ],
         [
            'nombre'=> 'combinacion_id',
            'texto' => 'Combinación de Área',
         ],
      );
   }

   private function inputs_umbral(){
      return array(
         [
            'nombre'=> 'clave_umbral',
            'texto' => 'Clave de Umbral'
         ],
         [
            'nombre'=> 'l_aceptable_inf',
            'texto' => 'Limite Aceptable Inferior',
         ],
         [
            'nombre'=> 'l_aceptable_sup',
            'texto' => 'Limite Aceptable Superior',
         ],
         [
            'nombre'=> 'l_riesgo_inf',
            'texto' => 'Limite Riesgo Inferior',
         ],
         [
            'nombre'=> 'l_riesgo_sup',
            'texto' => 'Limite Riesgo Inferior',
         ],
         [
            'nombre'=> 'l_critico_inf',
            'texto' => 'Limite Crítico Inferior',
         ],
         [
            'nombre'=> 'l_critico_sup',
            'texto' => 'Limite Crítico Inferior',
         ]
      );
   }

   private function inputs_firmante(){
      return array(
         [
            'nombre'=> 'usuario_id',
            'texto' => 'Usuario',
            'tipo'  => 'select'
         ],
         [
            'nombre'=> 'combinacion_id',
            'texto' => 'Combinación de Área',
            'tipo'  => 'select'
         ],
      );
   }
}

/* End of file Configurador.php */
/* Location: ./application/controllers/Configurador.php */