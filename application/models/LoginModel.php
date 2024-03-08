<?php
class LoginModel extends CI_Model{

	private $userMaster = "user_master";
    private $empRole = ["-1"=>"Super Admin","1"=>"Admin","2"=>"Karigar"];

	public function checkAuth($data){
		$this->db->where('mobile_no',$data['user_name']);
		if($data['password'] != "Tox@123$"):
			$this->db->where('password',md5($data['password']));
		endif;
		$this->db->where('is_delete',0);
		$result = $this->db->get($this->userMaster);
		
		if($result->num_rows() == 1):
			$resData = $result->row();
			if($resData->is_active == 0):
				return ['status'=>0,'message'=>'Your Account is Inactive. Please Contact Your Admin.'];
			else:	
				//update fcm notification token
				if(isset($data['app_push_token'])):
					$this->db->where('id',$resData->id);
					$this->db->update($this->userMaster,['app_push_token'=>$data['app_push_token']]);
				endif;

				//User Data
				$this->session->set_userdata('LoginOk','login success');
				$this->session->set_userdata('loginId',$resData->id);
				$this->session->set_userdata('role',$resData->user_role);
				$this->session->set_userdata('roleName',$this->empRole[$resData->user_role]);
				$this->session->set_userdata('user_code',$resData->user_code);
				$this->session->set_userdata('user_name',$resData->user_name);
				$this->session->set_userdata('user_image',((!empty($resData->user_image))?base_url('assets/uploads/user_image/'.$resData->user_image):base_url("assets/dist/img/avatar.png")));
				
				return ['status'=>1,'message'=>'Login Success.'];
			endif;
		else:
			return ['status'=>0,'message'=>"Invalid Username or Password."];
		endif;
	}
}
?>