<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Login extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('LoginModel','login_model');
		$this->load->library('form_validation');		
		$this->form_validation->set_error_delimiters( '<div class="error">', '</div>' );
	}
	
	public function index(){	
		$this->session->set_userdata('is_app',1);
		if($this->session->userdata('LoginOk')):
			redirect(base_url('app/dashboard') );
		else:
			$this->load->view('app/login');
		endif;
	}
	
	public function auth(){
		if($this->session->userdata('LoginOk')):
			redirect( base_url('app/dashboard') );
		else:
			$data = $this->input->post();
		
			$this->form_validation->set_rules('user_name','Username','required|trim');
			$this->form_validation->set_rules('password','Password','required|trim');
			if($this->form_validation->run() == true):
				$result = $this->login_model->checkAuth($data);
				
				if($result['status'] == 1):
					return redirect( base_url('app/dashboard') );
				else:
					$this->session->set_flashdata('loginError',$result['message']);
					redirect( base_url('app/login') , 'refresh');
				endif;
			else:
				$this->load->view('app/login');
			endif;
		endif;
	}
	
	public function logout(){
		$this->session->sess_destroy();
		return redirect(base_url('app/login'));
	}
}
?>