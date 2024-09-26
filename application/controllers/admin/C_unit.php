<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_unit extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->model('m_unit','unit');
		$this->load->library('template');
	}
	
	public function index(){
		$data['title'] = "Unit";
		$data['modal_unit'] = "modal_unit";
		$this->template->useAsset()->setJs('master/unit',array('unit'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/unit/v_unit',$data);
	}
	
	function active_menu(){
		$data = array( 
			'm1' 	=> '', 
			'm2'	=>'active open', 
			'm2_1'	=>'', 
			'm2_2'	=>'', 
			'm2_3'	=>'', 
			'm2_4'	=>'active', 
			'm2_5'	=>'', 
			'm2_6'	=>'', 
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
		$list = $this->unit->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $unit) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$unit->id.'\')"></i>					
					<a class="red" href="#" onclick="rem(1,\''.$unit->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';
			
			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $unit->name;
			$row[] 	= $aksi;
			$row[] 	= $unit->id;
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->unit->count_all(),
						"recordsFiltered" => $this->unit->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	
	function add_data(){
		$url = "c_unit";
		$data = array(
			'id' => strtoupper($this->input->post('fld1')),
			'name' => strtoupper($this->input->post('fld2'))
		);
		$lnew = true;
		if($this->input->post('fld1')!=""){
			$this->db->where('id',$this->input->post('fld1'));
			$this->db->update('unit', $data);						
		} else {
			$this->db->insert('unit', $data);			
		}
		redirect(base_url("admin/".$url));
	}
	
	function add_unit(){
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		
		if($id !=""){
			$data = $this->unit->update_data_unit($id,$name);
		}else{
			$data = $this->unit->save_data_unit($name);
		}
		echo json_encode($data);
	}
	
	function delete_data($id,$val) {
		$whr = "id";
		$tbl = "unit";
		$url = "c_unit";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }
	
	
	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "name";
		$tbl = "unit";
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
