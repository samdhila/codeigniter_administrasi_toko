<?php
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_login');
		$this->load->model('m_master');
		$this->load->library('bcrypt');
	}

	function index(){
		$this->template->useAsset()->setJs('login',array('auth'));
		$data['data_js'] = $this->template->getMetadata();
		$this->template->template_login('login/content',$data);
	}

	function aksi_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		//$username = "admin";
		//$password = "password";
		$where 	= array("username" => $username);
		$cek 	= $this->m_login->cek_login("user",$where);
		//Data Users
		$pass 		= $cek['password'];
		$id_user 	= $cek['id_user'];
		$uaname 	= $cek['username'];
		$staff_id 	= $cek['staff_id'];
		$office_id 	= $cek['office_id'];
		$office_name 	= $this->m_master->get_name('name','office',$office_id);
		$staff_name 	= $this->m_master->get_name('display_name','staff',$staff_id);

		if ($this->bcrypt->check_password($password, $pass)){
			$data = array(
				'user_id'		=> $id_user,
				'nama' 			=> $uaname,
				'office_id'		=> $office_id,
				'office_name' 	=> $office_name,
				'staff_id'		=> $staff_id,
				'staff_name' 	=> $staff_name,
				'status' 		=> '0',
				'msg'			=> 'Login Success'
			);
			$this->session->set_userdata($data);
			echo json_encode($data);
		}else{
			$data = array(
				'user_id'		=> $id_user,
				'nama' 			=> $uaname,
				'office_id'		=> $office_id,
				'office_name' 	=> $office_name,
				'staff_id'		=> $staff_id,
				'staff_name' 	=> $staff_name,
				'status' 		=> '1',
				'msg'			=> 'Username atau password salah !'
			);
			echo json_encode($data);
		}
	}

	function logout(){
		$array_items = array('nama' => '', 'status' => '');
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
		redirect(base_url());
	}

}
