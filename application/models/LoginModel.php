<?php
class LoginModel extends CI_Model{

	private $userMaster = "user_master";
    private $empRole = ["-1"=>"Super Admin","1"=>"Admin","2"=>"Karigar"];

	public function checkAuth($data){
		$result = $this->db->where('mobile_no',$data['user_name'])->where('password',md5($data['password']))->where('is_delete',0)->get($this->userMaster);
		
		if($result->num_rows() == 1):
			$resData = $result->row();
			if($resData->is_active == 0):
				return ['status'=>0,'message'=>'Your Account is Inactive. Please Contact Your Admin.'];
			else:									
				//User Data
				$this->session->set_userdata('LoginOk','login success');
				$this->session->set_userdata('loginId',$resData->id);
				$this->session->set_userdata('role',$resData->emp_role);
				$this->session->set_userdata('roleName',$this->empRole[$empRole]);
				$this->session->set_userdata('emp_name',$resData->emp_name);
				
				return ['status'=>1,'message'=>'Login Success.'];
			endif;
		else:
			return ['status'=>0,'message'=>"Invalid Username or Password."];
		endif;
	}
}
?>