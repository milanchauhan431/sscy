<?php
class UserMaster extends MY_Controller{
    private $index = "app/user_master/index";
    private $form = "app/user_master/form";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "userMaster";
        $this->data['headData']->pageName = "Kariger";
    }

    public function index(){
        /* for($i=2;$i<=100;$i++):
            $this->db->insert('user_master',['user_role'=>2,'user_code'=>"K-".$i,'user_name'=>"User ".$i,'mobile_no'=>rand(0000000000,9999999999),'city'=>'City '.$i,'password'=>md5(123456),'pass_code'=>'123456','is_active'=>1]);
        endfor; */
        $this->load->view($this->index,$this->data);
    }

    public function getDTRows($is_active = 1){
        $data = $this->input->post();
        $data['is_active'] = $is_active;
        $result = $this->userMaster->getDTRows($data);
        $this->printJson($result);
    }

    public function addUser(){
        $this->load->view($this->form,$this->data);
    }
}
?>