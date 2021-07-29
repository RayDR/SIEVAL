<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_estadistica extends CI_Model {

    // Totales

    function get_totales(){
        // Total de actividades
        $this->db->select('count(1) as total');
        $actividades = $this->db->get('actividades');
        // Total de preproyectos
        $this->db->select('count(1) as total');
        $preproyectos = $this->db->get('preproyectos');
        // Total de acuerdos
        $this->db->select('count(1) as total');
        $acuerdos = $this->db->get('acuerdos');

        return array(
            'actividades'   => $actividades->row('total'),
            'preproyectos'  => $actividades->row('total'),
            'acuerdos'      => $actividades->row('total')
        );
    }

}

/* End of file Model_estadistica.php */
/* Location: ./application/models/Model_estadistica.php */