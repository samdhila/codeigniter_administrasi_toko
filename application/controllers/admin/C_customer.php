<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_customer extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->model('m_customer','customer');
		$this->load->library('template');
	}
	
	public function index(){
		$data['title'] = "Customer";
		$data['modal_customer'] = "modal_customer";
		$this->template->useAsset()->setJs('master/customer',array('customer'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/customer/v_customer',$data);
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
			'm2_7'	=>'active', 
			'm2_8'	=>'', 
			'm2_9'	=>'', 
			'm2_10'	=>'', 
			'm2_11'	=>'', 
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
		$list = $this->customer->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $customer) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$customer->id.'\')"></i>					
					<a class="red" href="#" onclick="rem(1,\''.$customer->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';
			
			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $customer->firstname;
			$row[] 	= $customer->username;
			$row[] 	= $customer->email;
			$row[] 	= $customer->phone_number;
			$row[] 	= $customer->activation_code;
			$row[] 	= $aksi;
			$row[] 	= $customer->id;		
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->customer->count_all(),
						"recordsFiltered" => $this->customer->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	
	function add_data(){
		$url = "c_customer";
		$data = array(
			'id' => strtoupper($this->input->post('fld1')),
			'name' => strtoupper($this->input->post('fld2'))
		);
		$lnew = true;
		if($this->input->post('fld1')!=""){
			$this->db->where('id',$this->input->post('fld1'));
			$this->db->update('user', $data);						
		} else {
			$this->db->insert('user', $data);			
		}
		redirect(base_url("admin/".$url));
	}
	
	
	function delete_data($id,$val) {
		$whr = "id";
		$tbl = "user";
		$url = "c_customer";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }
	
	
	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "name";
		$tbl = "user";
		$prn = "";
		$q 	 = $this->db->query("select $fld as f $prn from $tbl where $whr");		
		$res = array(
			[ 
				"fld"=>"input[name='fld2']",
				"val"=>$q->row()->f
			]
		);
		echo json_encode($res);
	}
}
