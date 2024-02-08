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

    public function save(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['user_code']))
            $errorMessage['user_code'] = "Kariger Code is required.";
        if(empty($data['user_name']))
            $errorMessage['user_name'] = "Kariger Name is required.";
        if(empty($data['mobile_no']))
            $errorMessage['mobile_no'] = "Mobile No. is required.";
        if(empty($data['id'])):
            if(empty($data['password'])):
                $errorMessage['password'] = "Password is required.";
            else:
                if($data['password'] != $data['pass_code']):
                    $errorMessage['pass_code'] = "Confirm password does not match.";
                endif;
            endif;
        endif;

        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            $this->printJson($this->userMaster->save($data));
        endif;
    }

    public function edit(){
        $data = $this->input->post();
        $this->data['dataRow'] = $this->userMaster->getUser($data);
        $this->load->view($this->form,$this->data);
    }

    public function delete(){
        $id = $this->input->post('id');
        if(empty($id)):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->userMaster->delete($id));
        endif;
    }

    public function changeStatus(){
        $data = $this->input->post();
        if(empty($data['id'])):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->userMaster->changeStatus($data));
        endif;
    }
}
?>