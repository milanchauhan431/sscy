<?php
class Dashboard extends MY_Controller{
    private $indexPage = "dashboard";

    public function __construct(){
        parent::__construct();
        $this->data['pageName'] = "Dashboard";
    }

    public function index(){
        $this->load->view($this->indexPage,$this->data);
    }
}
?>