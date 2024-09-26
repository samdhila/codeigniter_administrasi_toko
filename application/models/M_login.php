<?php
class M_login extends CI_Model{
	function cek_login($table,$where){
		//$this->db->get_where($table,$where);
		$query = $this->db->get_where($table,$where);
		$cek_row = $query->num_rows();
		if($cek_row > 0){
			$row = $query->row_array();
			$data = array(
				'id_user'		=> $row['id'],
				'username'	=> $row['username'],
				'password'	=> $row['password'],
				'office_id'	=> $row['office_id'],
				'staff_id'	=> $row['staff_id']
			);
		}else{
			$data = array(
				'id_user'	  => "",
				'username'	=> "",
				'password'	=> "",
				'office_id'	=> "",
				'staff_id'	=> ""
			);
		}
		return $data;
	}
//
// 	function cek_user()
// 	{
// 		$username = $this->input->post('username');
// 		$password = $this->input->post('password');
//
// 		$query = $this->db->where('username',$username)
// 											->where('password',$password)
// 											->get('user');
//
// 		if ($query->num_rows > 0) {
//
// 				$data_login = $query->row();
//
// 				$data = array(
// 								'id' =>$data_login->id ,
// 			 					'username'=>$data_login->username,
// 								'logged_in' => TRUE
// 							);
//
// 				$this->session->set_userdata($data);
//
// 				return TRUE;
// 		} else {
// 			return FALSE;
// 		}
// 		$username = $this->input->post('username');
// 		$password = $this->input->post('password');
// 		$query = $this->db->query("SELECT * FROM user WHERE username='$username' AND password='$password'");
// 		foreach ($query->result() as $row) {
// 			echo $row->username;
// 			echo $row->password;
// 		}
// 		return $query;
// 	}
}
