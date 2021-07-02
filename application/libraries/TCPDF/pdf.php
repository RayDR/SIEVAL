<?php
/*
* Author: Domodigital
* File:   pdf.php
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf.php';

class PDF extends TCPDF
{
   function __construct()
   {
      parent::__construct();
   }
}

/* End of file pdf.php */
/* Location: ./application/libraries/pdf.php */