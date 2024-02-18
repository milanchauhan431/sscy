<?php 
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class MY_Controller extends CI_Controller{
	
	public $empRole = ["1"=>"Admin","2"=>"Karigar"];
	public $activeSource = 0;

	public function __construct(){
		parent::__construct();
		//echo '<br><br><hr><h1 style="text-align:center;color:red;">We are sorry!<br>Your Application is Updating New Features</h1><hr><h2 style="text-align:center;color:green;">Thanks For Co-operate</h1>';exit;
		$this->activeSource = $this->session->userdata('is_app');
		$this->isLoggedin();		
		
		$this->data['headData'] = new StdClass;

		$this->load->library('form_validation');
		
		$this->load->model('masterModel');
		$this->load->model("UserMasterModel","userMaster");
		$this->load->model("ItemGroupModel","itemGroup");
		$this->load->model("ItemCategoryModel","itemCategory");
		$this->load->model("ItemMasterModel","item");

		$this->setSessionVariables(["masterModel","userMaster","itemGroup","itemCategory","item"]);
	}

	public function setSessionVariables($modelNames){

		$this->loginId = $this->session->userdata('loginId');
		$this->userCode = $this->session->userdata('user_code');
		$this->userName = $this->session->userdata('user_name');
		$this->userRole = $this->session->userdata('role');
		$this->userRoleName = $this->session->userdata('roleName');
		$this->isApp = $this->session->userdata('is_app');

		$models = $modelNames;
		foreach($models as $modelName):
			$modelName = trim($modelName);

			$this->{$modelName}->loginId = $this->loginId;
			$this->{$modelName}->userCode = $this->userCode;
			$this->{$modelName}->userName = $this->userName;
			$this->{$modelName}->userRole = $this->userRole;
			$this->{$modelName}->userRoleName = $this->userRoleName;
			$this->{$modelName}->isApp = $this->isApp;
		endforeach;
		return true;
	}
	
	
	public function isLoggedin(){
		if(!$this->session->userdata("loginId")):
			$url = (!empty($this->activeSource))?"app/login":"";
			echo '<script>window.location.href="'.base_url($url).'";</script>';
		endif;
		return true;
	}
	
	public function printJson($data){
		print json_encode($data);exit;
	}
	
	public function checkGrants($url){
		$empPer = $this->session->userdata('emp_permission');
		if(!array_key_exists($url,$empPer)):
			redirect(base_url('error_403'));
		endif;
		return true;
	}
}
?>