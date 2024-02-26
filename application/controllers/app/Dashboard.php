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

    public function getTopOrderItems(){
        $topItemList = $this->dashboard->getTopOrderItems();
        $this->printJson(['status'=>1,'topItemList'=>$topItemList]);
    }

    public function getPendingOrderList(){
        $pendingOrderList = $this->dashboard->getPendingOrderList();
        $this->printJson(['status'=>1,'pendingOrderList'=>$pendingOrderList]);
    }
}
?>