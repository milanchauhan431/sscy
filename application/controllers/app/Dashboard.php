<?php
class Dashboard extends MY_Controller{
    private $indexPage = "app/dashboard";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->pageName = "Home";
        $this->data['headData']->controller = "dashboard";
    }

    public function index(){
        $this->load->view($this->indexPage,$this->data);
    }
}
?>