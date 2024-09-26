<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_warna extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->model('m_warna','warna');
		$this->load->library('template');
	}
	
	public function index(){
		$data['title'] = "Warna";
		$data['modal_warna'] = "modal_warna";
		$this->template->useAsset()->setJs('master/warna',array('warna'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/warna/v_warna',$data);
	}
	
	function active_menu(){
		$data = array( 
			'm1' 	=> '', 
			'm2'	=>'active open', 
			'm2_1'	=>'', 
			'm2_2'	=>'active', 
			'm2_3'	=>'', 
			'm2_4'	=>'', 
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
		$list = $this->warna->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $warna) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(2,\''.$warna->id.'\')"></i>					
					<a class="red" href="#" onclick="rem(2,\''.$warna->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';
			
			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $warna->name;
			$row[] 	= $aksi;
			$row[] 	= $warna->id;
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->warna->count_all(),
						"recordsFiltered" => $this->warna->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	
	function add_data(){
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		
		if($id != "")
		{
			$data = $this->warna->update_data_warna($id,$name);
		}else{
			$data = $this->warna->save_data_warna($name);
		}
		echo json_encode($data);
	}
	
	
	function delete_row($id,$val) {
		$whr = "id";
		$tbl = "color";
		$url = "c_warna";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }
	
	
	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "name";
		$tbl = "color";
		$q = $this->db->query("select $fld as f from $tbl where $whr");
		$res = array([ 
			"fld"=>"input[name='fld2']",
			"val"=>$q->row()->f
		]);
		echo json_encode($res);
	}
}
