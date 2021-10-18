<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicadores extends CI_Controller {

   private $rootPathRemoto = 'C:/SvrArchivos/sieval/Actividades/'; // PATH a archivos locales ( Dentro de la app )
   private $rootPathLocal  = FCPATH . 'uploads/Actividades/';      // PATH para guardarlo en otro directorio ( Fuera de la app )

   public function __construct()
   {
      parent::__construct();
      $this->load->model('model_catalogos');
      $this->load->model('model_indicadores');
        
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
         'titulo'        => 'Indicadores ' . APLICACION  . ' | ' . EMPRESA,
         'menu'          => $this->model_catalogos->get_menus(),
         'view'          => 'indicadores/index'
      );
      $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
   }

   // Vista de Registro
   public function registrar()
   {
      $json = array('exito' => TRUE);
                   
      $data = array(
         'titulo'        => 'Registrar',
         'inputs'        => $this->inputs_indicador(),
         'view'          => 'indicadores/registrar'
      );
      $json['html'] = $this->load->view( $data['view'], $data, TRUE );
      return print(json_encode($json));    
   }

   // Vista de Edición de Actividad
   public function editar()
   {
      $json = array('exito' => TRUE);
                   
      $data = array(
         'titulo'        => 'Editar',
         'inputs'        => $this->inputs_indicador(),
         'view'          => 'indicadores/editar'
      );
      $json['html'] = $this->load->view( $data['view'], $data, TRUE );
      return print(json_encode($json));    
   }


//  ------- FIN DE VISTAS ------

/*--------------------------------------------------------------------------*
* ---- FUNCIONES AJAX 
* --------------------------------------------------*/

   /*------------------------------
   * -- VISTAS AJAX
   * ---------------------*/

   public function detalle_indicador(){
      $json = array('exito' => TRUE);
      return print(json_encode($json));
   }

   /*------------------------------
   * --- DATOS AJAX
   * ---------------------*/

   // Datatable
   public function datatable_indicadores(){
      $condicion = NULL;
      return print(json_encode( $this->model_indicadores->get_indicadores($condicion) ));
   }

/*--------------------------------------------------------------------------*
* ---- FUNCIONES PRIVADAS 
* --------------------------------------------------*/

   private function inputs_indicador(){
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
}

/* End of file Indicadores.php */
/* Location: ./application/controllers/Indicadores.php */