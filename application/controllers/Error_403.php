<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Error_403 extends CI_controller
{
  public function __construct(){
    parent::__construct();
    $this->data['headData'] = new stdClass();
    $this->data['headData']->pageTitle = "Error 403";
  }

  public function index(){
    $this->output->set_status_header('403');
    $page = (!empty($this->session->userdata('is_app')))?"app/app-403":"page-403";
    $this->load->view($page,$this->data);
  }
}
?>