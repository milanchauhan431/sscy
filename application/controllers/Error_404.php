<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Error_404 extends CI_controller
{
  public function __construct(){
    parent::__construct();
    $this->data['headData'] = new stdClass();
    $this->data['headData']->pageTitle = "Error 404";
  }

  public function index(){
    $this->output->set_status_header('404');
    $page = (!empty($this->session->userdata('is_app')))?"app/app-404":"page-404";
    $this->load->view($page,$this->data);
  }
}
?>