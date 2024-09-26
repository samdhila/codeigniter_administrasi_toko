<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_kategori_produk extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}
		$this->load->model('m_kategori_produk','kategori');
		$this->load->library('template');
	}

	public function index(){
		$data['title'] = "Kategori Produk";
		$data['modal_kategori'] = "modal_kategori";
		$this->template->useAsset()->setJs('master/kategori_produk',array('kategori_produk'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/kategori_produk/v_kategori_produk',$data);
	}

	function active_menu(){
		$data = array(
			'm1' 	=> '',
			'm2'	=>'active open',
			'm2_1'	=>'',
			'm2_2'	=>'',
			'm2_3'	=>'active',
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
		$list = $this->kategori->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $kategori) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$kategori->id.'\')"></i>
					<a class="red" href="#" onclick="rem(1,\''.$kategori->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';

			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $kategori->name;
			$row[] 	= $aksi;
			$row[] 	= $kategori->id;
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->kategori->count_all(),
						"recordsFiltered" => $this->kategori->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


function add_data(){
	$id 	   = $this->input->post('id');
	$name 	= $this->input->post('category');
	$parent  = $this->input->post('parent');

	if($id !=""){
		$data = $this->kategori->update_data($id,$name,$parent);
	}else{
		$data = $this->kategori->save_data($name,$parent);
	}
	echo json_encode($data);
}


	function delete_data($id,$val) {
		$whr = "id";
		$tbl = "productcategory";
		$url = "c_kategori_produk";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }


	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "name";
		$tbl = "productcategory";
		$prn = ",parent_product_category_id as prn";
		$q 	 = $this->db->query("select $fld as f $prn from $tbl where $whr");
		$res = array(
			[
				"fld"=>"input[name='fld2']",
				"val"=>$q->row()->f
			],
			[
				"fld"=>"select[name='fld3']",
				"val"=>$q->row()->prn
			]
		);
		echo json_encode($res);
	}
}
