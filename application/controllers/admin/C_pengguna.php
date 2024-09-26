<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_pengguna extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->model('m_pengguna','pengguna');
		$this->load->library('template');
		$this->load->library('bcrypt');
	}
	
	public function index(){
		$data['title'] = "Pengguna";
		$data['modal_pengguna'] = "modal_pengguna";
		$this->template->useAsset()->setJs('master/pengguna',array('pengguna'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/pengguna/v_pengguna',$data);
	}
	
	function active_menu(){
		$data = array( 
			'm1' 	=> '', 
			'm2'	=>'active open', 
			'm2_1'	=>'', 
			'm2_2'	=>'', 
			'm2_3'	=>'', 
			'm2_4'	=>'', 
			'm2_5'	=>'', 
			'm2_6'	=>'', 
			'm2_7'	=>'', 
			'm2_8'	=>'', 
			'm2_9'	=>'', 
			'm2_10'	=>'', 
			'm2_11'	=>'active', 
			'm3'	=>'', 
			'm3_1'	=>'', 
			'm3_2'	=>'',
			'm3_3'	=>'',
			'm4'	=>'', 
			'm4_1'	=>'', 
			'm4_2'	=>''
		);
		$menu = $this->load->vars($data);
		return $menu;
	}
	
	function get_json_data(){
		$list = $this->pengguna->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $pengguna) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$pengguna->id.'\')"></i>					
					<a class="red" href="#" onclick="rem(1,\''.$pengguna->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';
			
			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $pengguna->firstname;
			$row[] 	= $pengguna->username;
			$row[] 	= $pengguna->email;
			$row[] 	= $pengguna->phone_number;
			$row[] 	= $pengguna->activation_code;
			$row[] 	= $aksi;
			$row[] 	= $pengguna->id;		
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->pengguna->count_all(),
						"recordsFiltered" => $this->pengguna->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	
	function add_data(){
		$id 	   = $this->input->post('id');
		$firstname = $this->input->post('name');
		$username  = $this->input->post('username');
		$password  = $this->bcrypt->hash_password($this->input->post('password'));
		$email     = $this->input->post('email');
		$hp  	   = $this->input->post('hp');
		$office_id = "1";
		$staff_id  = "1";
		
		if($id !=""){
			$data = $this->pengguna->update_data($id,$firstname,$username,$email,$hp,$password,$office_id,$staff_id);
		}else{
			$data = $this->pengguna->save_data($firstname,$username,$email,$hp,$password,$office_id,$staff_id);
		}
		echo json_encode($data);
	}
	
	
	function delete_data($id,$val) {
		$whr = "id";
		$tbl = "user";
		$url = "c_pengguna";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }
	
	
	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "firstname";
		$tbl = "user";
		$prn = ", user.*";
		$q 	 = $this->db->query("select $fld as f $prn from $tbl where $whr");		
		$res = array(
			[ 
				"fld"=>"input[name='fld1']",
				"val"=>$q->row()->id
			],
			[ 
				"fld"=>"input[name='fld2']",
				"val"=>$q->row()->f
			],
			[ 
				"fld"=>"input[name='fld3']",
				"val"=>$q->row()->username
			],
			
			/* [ 
				"fld"=>"input[name='fld4']",
				"val"=>$q->row()->password
			], */
			
			[ 
				"fld"=>"input[name='fld5']",
				"val"=>$q->row()->email
			],
			[ 
				"fld"=>"input[name='fld6']",
				"val"=>$q->row()->phone_number
			]
		);
		echo json_encode($res);
	}
}
