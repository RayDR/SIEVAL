<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_estadistica extends CI_Model {

    // Totales

    function get_totales(){
        // Total de actividades
        $this->db->where('estatus', 1);
        $this->db->select('count(1) as total');
        $actividades = $this->db->get('actividades');
        // Total de preproyectos
        $this->db->where('estatus_id <>', 5);
        $this->db->select('count(1) as total');
        $preproyectos = $this->db->get('preproyectos');
        // Total de acuerdos
        $this->db->where('estatus', 1);
        $this->db->select('count(1) as total');
        $acuerdos = $this->db->get('acuerdos');

        return array(
            'actividades'   => $actividades->row('total'),
            'preproyectos'  => $preproyectos->row('total'),
            'acuerdos'      => $acuerdos->row('total')
        );
    }

}

/* End of file Model_estadistica.php */
/* Location: ./application/models/Model_estadistica.php */