<?php
class UserMaster extends MY_Controller{
    private $index = "app/user_master/index";
    private $form = "app/user_master/form";
    private $myProfile = "app/user_master/user_profile";
    private $changePswForm = "app/user_master/change_password";

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

                $data['password'] = md5($data['password']);
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

    public function userProfile(){
        $this->data['headData']->controller = "myProfile";
        $this->data['headData']->pageName = "MY PROFILE";
        $this->data['dataRow'] = $this->userMaster->getUser(['id'=>$this->loginId]);
        //print_r($this->data);exit;
        $this->load->view($this->myProfile,$this->data);
    }

    public function uploadProfile(){
        $data = $this->input->post();

        if($_FILES['user_image']['name'] != null || !empty($_FILES['user_image']['name'])):
            $this->load->library('upload');
            $_FILES['userfile']['name']     = $_FILES['user_image']['name'];
            $_FILES['userfile']['type']     = $_FILES['user_image']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['user_image']['tmp_name'];
            $_FILES['userfile']['error']    = $_FILES['user_image']['error'];
            $_FILES['userfile']['size']     = $_FILES['user_image']['size'];
            
            $imagePath = realpath(APPPATH . '../assets/uploads/user_image/');
            $ext = pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);

            $config = ['file_name' => $data['id'].'.'.$ext,'allowed_types' => '*','max_size' => 10240,'overwrite' => FALSE, 'upload_path' => $imagePath];

            if(file_exists($config['upload_path'].'/'.$config['file_name'])) unlink($config['upload_path'].'/'.$config['file_name']);

            $this->upload->initialize($config);
            if (!$this->upload->do_upload()):
                $errorMessage['newProfilePhoto'] = $this->upload->display_errors();
            else:
                $uploadData = $this->upload->data();
                $data['user_image'] = $uploadData['file_name'];
            endif;
        else:
            $this->printJson(['status'=>0,'message'=>"Image not found."]);exit;
        endif;

        $this->printJson($this->userMaster->save($data));
    }

    public function changePassword(){
        $this->load->view($this->changePswForm,$this->data);
    }

    public function saveChangePassword(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['old_password']))
            $errorMessage['old_password'] = "Old Password is required.";
        if(empty($data['password'])):
            $errorMessage['password'] = "New Password is required.";
        else:
            if($data['password'] != $data['pass_code']):
                $errorMessage['pass_code'] = "Confirm password does not match.";
            endif;
            $data['password'] = md5($data['password']);
        endif;

        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            $this->printJson($this->userMaster->saveChangePassword($data));
        endif;
    }
}
?>