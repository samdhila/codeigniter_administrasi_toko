<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_supplier extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->model('m_supplier','supplier');
		$this->load->library('template');
	}
	
	public function index(){
		$data['title'] = "Supplier";
		$data['modal_supplier'] = "modal_supplier";
		$this->template->useAsset()->setJs('master/supplier',array('supplier'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/supplier/v_supplier',$data);
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
			'm2_6'	=>'active', 
			'm2_7'	=>'', 
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
		$list = $this->supplier->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $supplier) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$supplier->id.'\')"></i>					
					<a class="red" href="#" onclick="rem(1,\''.$supplier->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';
			
			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $supplier->name;
			$row[] 	= $aksi;
			$row[] 	= $supplier->id;
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->supplier->count_all(),
						"recordsFiltered" => $this->supplier->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	function add_data(){
		$id 	= $this->input->post('id');
		$name 	= $this->input->post('name');
		
		if($id !=""){
			$data = $this->supplier->update_data($id,$name);
		}else{
			$data = $this->supplier->save_data($name);
		}
		echo json_encode($data);
	}
	
	function delete_data($id,$val) {
		$whr = "id";
		$tbl = "supplier";
		$url = "c_supplier";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }
	
	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "name";
		$tbl = "supplier";
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
