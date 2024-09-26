<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_outlet extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}
		$this->load->model('m_outlet','outlet');
		$this->load->library('template');
	}

	public function index(){
		$data['title'] = "Outlet";
		$data['modal_outlet'] = "modal_outlet";
		$this->template->useAsset()->setJs('master/outlet',array('outlet'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/outlet/v_outlet',$data);
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
			'm2_10'	=>'active',
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
		$list = $this->outlet->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $outlet) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$outlet->id.'\')"></i>
					<a class="red" href="#" onclick="rem(1,\''.$outlet->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';

			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $outlet->name;
			$row[] 	= $outlet->address;
			$row[] 	= $outlet->phone_number;
			$row[] 	= $outlet->kota;
			$row[] 	= $outlet->provinsi;
			$row[] 	= $outlet->area_kantor;
			$row[] 	= $aksi;
			$row[] 	= $outlet->id;
			$data[] = $row;
		}
		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->outlet->count_all(),
						"recordsFiltered" => $this->outlet->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	function add_data(){
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$alamat = $this->input->post('alamat');
		$area = $this->input->post('area');
		$provinsi = $this->input->post('provinsi');
		$kota = $this->input->post('kota');
		$pos = $this->input->post('pos');
		$telepon = $this->input->post('telepon');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$type = "2";
		if($id !=""){
			$data = $this->outlet->update_data_outlet($id,$name,$alamat,$area,$provinsi,$kota,$pos,$telepon,$latitude,$longitude,$type);
		}else{
			$data = $this->outlet->save_data_outlet($name,$alamat,$area,$provinsi,$kota,$pos,$telepon,$latitude,$longitude,$type);
		}
		echo json_encode($data);
	}


	function delete_data($id,$val){
		$whr = "id";
		$tbl = "office";
		$url = "c_outlet";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }


	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "name";
		$tbl = "office";
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
