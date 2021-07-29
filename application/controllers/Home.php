<?php
/* ================================================================================================================
 *  @Filename:  Controllers/Actividades.php
 * ================================================================================================================
 *  @author:    Domodigital 
 *  @version:   V1.0
 *  @revision:  06-2021
 * =====================================================================*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_catalogos');
        $this->load->model('model_usuarios');
    }

/*--------------------------------------------------------------------------*
* ---- VISTAS 
* --------------------------------------------------*/

    public function index()
    {
        if ( !$this->session->estatus_usuario_sesion() ){
            redirect(base_url('index.php/Home/login'),'refresh');
            print(json_encode(array('estatus' => 'sess_expired', 'mensaje' => 'Su sesión ha caducado. Por favor, recargue la página.')));
        }
        
        $this->load->model('model_estadistica');
        
        $data = array(
            'titulo'    => 'Home ' . APLICACION  . ' | ' . EMPRESA,
            'menu'      => $this->model_catalogos->get_menus(),
            'totales'   => $this->model_estadistica->get_totales(),
            'view'      => 'index'
        );
        $this->load->view( RUTA_TEMA . 'body', $data, FALSE );
    }

    public function login()
    {
        $data = array(
            'titulo'    => 'Acceso ' . APLICACION  . ' | ' . EMPRESA,
            'view'      => 'login'
        );
        $this->load->view( RUTA_TEMA_ALT . 'body', $data, FALSE );
    }

    public function recovery()
    {
        $data = array(
            'titulo'    => 'Recuperar Contraseña ' . APLICACION  . ' | ' . EMPRESA,
            'view'      => 'recovery'
        );
        $this->load->view( RUTA_TEMA_ALT . 'body', $data, FALSE );
    }

/*--------------------------------------------------------------------------*
* ---- FUNCIONES AJAX 
* --------------------------------------------------*/

    // ----------------- VISTAS
    public function modales(){
        $json = array('exito' => TRUE);
        $tipo = $this->input->post('tipo');
        switch ($tipo) {
            case 'login':
                $json['html'] = $this->load->view(RUTA_TEMA_EXTRAS .'/modales/modal_login', NULL, TRUE);
                break;
            case 'notificacion':
                $json['html'] = $this->load->view(RUTA_TEMA_EXTRAS .'/modales/modal_notificacion', NULL, TRUE);
                break;
            case 'exito':
                $json['html'] = $this->load->view(RUTA_TEMA_EXTRAS .'/modales/modal_exito', NULL, TRUE);
                break;
            default:
                $json['html'] = $this->load->view(RUTA_TEMA_EXTRAS .'/modales/modal_generico', NULL, TRUE);
                break;
        }
        return print(json_encode($json));
    }

    // Función para verificar usuario y contraseña del login
    public function do_login(){
        $usuario    = $this->input->post('usuario');
        $password   = base64_decode($this->input->post('password'));

        $respuesta = array(
            'exito'     =>  FALSE
        );

        if ( ! $usuario || ! $password )
            $db_usuario = NULL;
        else
            $db_usuario = $this->model_usuarios->get_usuarios( array('usuario' => $usuario) );
        if ( $db_usuario ) 
            {  // Comprobación de usuario
            if ( $db_usuario->estatus != 1 )
            {  // Usuario no Activo
                switch ( $db_usuario->estatus ) 
                {
                    case 2:  // Usuario no inactivo
                        $respuesta["mensaje"] = "<b>El usuario está inactivo.</b><br><small>Pongase en contacto con la administración para reactivar su cuenta.</small>";
                        break;
                    case 3:  // Usuario bloqueado
                        $respuesta["mensaje"] = "<b>El usuario ha sido bloqueado.</b><br><small>Por favor, solicite la ayuda de la administración para desbloquearlo.</small>";
                        break;
                    default:  // Opción no controlada
                        $respuesta["mensaje"] = "<b>No se pudo obtener el estatus de su usuario. </b><br><small>Por favor, solicite asistencia al administrador del sistema.</small>";
                        break;
                }
            } 
            else if ( password_verify( $password, $db_usuario->contrasena ) )
            {  // Todo correcto - Permitir Login
                if ( $this->session->establecer_sesion($db_usuario) )
                {
                    $respuesta["exito"]     =   TRUE;
                    $respuesta["usuario"]   =   array(  'value' =>  $db_usuario->usuario_id, 
                                                        'name'  =>  'usuario_id' );
                    $respuesta["mensaje"]   =   "<b>Acceso concedido.</b>";
                } else 
                    $respuesta["mensaje"]   =   "<b>No fue posible crear la sesión del usuario</b>. Intente nuevamente.";
            } 
            else
            {
                $respuesta["mensaje"]   =   "<b>La combinación de usuario y contraseña no son correctas.</b>";                        
                //$respuesta["intentos"]  =   $this->session->intentos_conexion($db_usuario->usuario_id);
            }
        } else
            $respuesta["mensaje"]   =   "<b>El usuario ingresado no existe.</b>";
        return print( json_encode($respuesta) );
    }

    // Función para verificar que el usuario y contrato matcheen para el recovery
    public function do_recovery(){

    }

    // Función de cierre de sesión
    public function logout(){
        session_destroy();
        redirect(base_url('index.php/Home/login'),'refresh');
    }


/*
|--------------------------------------------------------------------------
| FUNCIONES RESERVADAS PARA EL SISTEMA
|--------------------------------------------------------------------------
*/ 

    public function crypt_decrypt($encrypt = 'localhost'){
        $this->load->library('encryption');
        $encriptado =  $this->encryption->encrypt($encrypt);
        echo $encriptado . '<hr>';
    }


        public function pdfTEST(){
        $this->load->library('TCPDF/pdf');
        $tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
        // set document information
        $tcpdf->SetCreator(PDF_CREATOR);
        $tcpdf->SetAuthor('Muhammad Saqlain Arif');
        $tcpdf->SetTitle('TCPDF Example 001');
        $tcpdf->SetSubject('TCPDF Tutorial');
        $tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
         
        //set default header information
         
        $tcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,65,256), array(0,65,127));
        $tcpdf->setFooterData(array(0,65,0), array(0,65,127));
         
        //set header  textual styles
        $tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //set footer textual styles
        $tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
         
        //set default monospaced textual style
        $tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
         
        // set default margins
        $tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // Set Header Margin
        $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        // Set Footer Margin
        $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
         
        // set auto for page breaks
        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
         
        // set image for scale factor
        $tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
         
        // it is optional :: set some language-dependent strings
        if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
        {
        // optional
        require_once(dirname(__FILE__).'/lang/eng.php');
        // optional
        $tcpdf->setLanguageArray($l);
        }
         
        // set default font for subsetting mode
        $tcpdf->setFontSubsetting(true);
         
        // Set textual style
        // dejavusans is an UTF-8 Unicode textual style, on the off chance that you just need to
        // print standard ASCII roasts, you can utilize center text styles like
        // helvetica or times to lessen record estimate.
        $tcpdf->SetFont('dejavusans', '', 14, '', true);
         
        // Add a new page
        // This technique has a few choices, check the source code documentation for more data.
        $tcpdf->AddPage();
         
        // set text shadow for effect
        $tcpdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,197,198), 'opacity'=>1, 'blend_mode'=>'Normal'));
         
        //Set some substance to print
         
        $set_html = <<<EOD
         
        <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0001;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF Example</span>&nbsp;</a>!</h1>
        <i>This is the principal case of TCPDF library.</i>
        <p>This content is printed utilizing the <i>writeHTMLCell()</i> strategy however you can likewise utilize: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
        <p>Please check the source code documentation and different cases for further information.</p>
         
        EOD;
         
        //Print content utilizing writeHTMLCell()
        $tcpdf->writeHTMLCell(0, 0, '', '', $set_html, 0, 1, 0, true, '', true);
         
        // Close and yield PDF record
        // This technique has a few choices, check the source code documentation for more data.
        $tcpdf->Output('tcpdfexample-onlinecode.pdf', 'I');
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */