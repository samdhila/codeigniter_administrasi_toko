<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_promo extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}
		$this->load->model('m_promo','promo');
		$this->load->model('m_produk','produk');
		$this->load->library('template');
	}

	public function index(){
		$data['title'] = "Promo";
		$data['modal_promo'] = "modal_promo";
		$this->template->useAsset()->setJs('master/promo',array('promo'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/promo/v_promo',$data);
	}

	function active_menu(){
		$data = array(
			'm1' 	=>'',
			'm2'	=>'active open',
			'm2_1'	=>'',
			'm2_2'	=>'',
			'm2_3'	=>'',
			'm2_4'	=>'',
			'm2_5'	=>'active',
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
		$list = $this->promo->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $promo) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$promo->id.'\')"></i> |
					<a class="red" href="#" onclick="rem(1,\''.$promo->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';

			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $promo->name;
			$row[] 	= $promo->start_date;
			$row[] 	= $promo->end_date;
			$row[] 	= $promo->quantity;
			$row[] 	= $promo->discount_type;
			$row[] 	= $promo->category_product;
			$row[] 	= $aksi;
			$row[] 	= $promo->id;
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->promo->count_all(),
						"recordsFiltered" => $this->promo->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	function get_json_data_item(){
		$list = $this->produk->get_datatables();
		$dataitem = array();
		$no = $this->input->post('start');
		foreach ($list as $produk) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_items" href="#" onclick="update(1,\''.$produk->id.'\')"></i> |
					<a class="red" href="#" onclick="rem(1,\''.$produk->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';

			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $produk->name;
			$row[] 	= $produk->id;
			$dataitem[] = $row;
		}

		$outputitem = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->produk->count_all(),
						"recordsFiltered" => $this->produk->count_filtered(),
						"data" => $dataitem,
				);
		//output to json format
		echo json_encode($outputitem);
	}

	function add_data(){
		$res_promo  = $this->input->post('data_promo');
		// $res_item  	= $this->input->post('data_item');
		// $res_bonus  = $this->input->post('data_bonus');
		$user_id 	= $this->session->userdata('user_id');

		foreach ($res_promo as $promo) {
			$id = $promo['fld1'];
			$type = $promo['fld3'];
			$qty = $promo['fld8'];
			$disc = $promo['fld9'];
			$term_type = $promo['fld10'];
			$diskon_item = $promo['fld11'];
			$kelipatan = $promo['fld12'];
			$max_kelipatan = $promo['fld13'];
			$gbr = $promo['fld14'];
			$all_produk = $promo['fld15'];

			if($diskon_item == '1'){
				$dsk_itm = 1;
			}else if($diskon_item == '0'){
				$dsk_itm = 0;
			}
			if($kelipatan == '1'){
				$klp = 1;
			}else if($kelipatan == '0'){
				$klp = 0;
			}
			if($all_produk == '1'){
				$a_product = 1;
			}else if($all_produk == '0'){
				$a_product = 0;
			}

			if($id!=""){
				$data = array(
					"name" 					=> $promo['fld2'],
					"discount_type" 		=> $type,
					"start_date" 			=> date('Y-m-d',strtotime(substr($promo['fld4'],0,10))),
					"end_date" 				=> date('Y-m-d',strtotime(substr($promo['fld5'],0,10))),
					"image_size" 			=> $promo['fld6'],
					"product_category_id" 	=> $promo['fld7'],
					"applies_multiply"		=> $klp,
					"quantity" 				=> $qty,
					"discount" 				=> $disc,
					"discount_per_item"		=> $dsk_itm,
					"user_id" 				=> $user_id,
					"max_multiples"			=> $max_kelipatan,
					"term_type"				=> $term_type,
					"modified_time"			=> date('Y-m-d H:i:s'),
					"all_product"			=> $a_product
				);
				$this->db->where('id',$id);
				$this->db->update('promo', $data);

				//delete detail promo item
				$q 	 = $this->db->query("SELECT promo_item_id from promo_promo_item where promo_id='$id'");
				$this->db->where('promo_id',$id);
				$this->db->delete('promo_promo_item');
				foreach ($q->result() as $promo1) {
					$rid = $promo1->promo_item_id;
					$this->db->where('id',$rid);
					$this->db->delete('promoitem');
				}
				//delete detail promo bonus
				$q 	 = $this->db->query("SELECT promo_bonus_id from promo_promo_bonus where promo_id='$id'");
				$this->db->where('promo_id',$id);
				$this->db->delete('promo_promo_bonus');
				foreach ($q->result() as $promo2) {
					$rid = $promo2->promo_bonus_id;
					$this->db->where('id',$rid);
					$this->db->delete('promobonus');
				}
			} else {
				$q 	 = $this->db->query("select IF(MAX(id)>0,MAX(id)+1,1) as id, IF(MAX(sort_order)>0,MAX(sort_order)+1,1) as nid from promo");
				$id = $q->row()->id;
				$sid = $q->row()->nid;
				$data = array(
					"id"					=> $id,
					"name" 					=> $promo['fld2'],
					"discount_type" 		=> $type,
					"start_date" 			=> date('Y-m-d',strtotime(substr($promo['fld4'],0,10))),
					"end_date" 				=> date('Y-m-d',strtotime(substr($promo['fld5'],0,10))),
					"image_size" 			=> $promo['fld6'],
					"product_category_id" 	=> $promo['fld7'],
					"applies_multiply"		=> $klp,
					"quantity" 				=> $qty,
					"discount" 				=> $disc,
					"discount_per_item"		=> $dsk_itm,
					"sort_order" 			=> $sid,
					"user_id" 				=> $user_id,
					"max_multiples"			=> $max_kelipatan,
					"term_type"				=> $term_type,
					"modified_time"			=> date('Y-m-d H:i:s'),
					"all_product"			=> $a_product
				);
				$this->db->insert('promo', $data);
			}
		}
	}


	function delete_data($id,$val){
		$whr = "id";
		$tbl = "promo";
		$url = "c_promo";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		redirect(base_url("admin/".$url));
    }

	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		//$frm = "frm_promo";
		$whr = "id = '$id'";
		$tbl = "promo";
		$prn = "promo.*";
		$url = "c_promo";
		$q 	 = $this->db->query("select $prn from $tbl where $whr");
		$res = array(
				[
				"fld"=>"input[name='fld1']",
				"val"=>$q->row()->id
				],
				[
				"fld"=>"textarea[name='fld2']",
				"val"=>$q->row()->name
				],[
				"fld"=>"select[name='fld3']",
				"val"=>$q->row()->discount_type
				],[
				"fld"=>"select[name='fld4']",
				"val"=>$q->row()->term
				],[
				"fld"=>"select[name='fld5']",
				"val"=>$q->row()->image_size
				],[
				"fld"=>"select[name='fld6']",
				"val"=>$q->row()->product_category_id
				],[
				"fld"=>"chk1[name='fld7']",
				"val"=>$q->row()->all_product
				],[
				"fld"=>"input[name='fld8']",
				"val"=>$q->row()->start_date
				],[
				"fld"=>"input[name='fld9']",
				"val"=>$q->row()->end_date
				],[
				"fld"=>"input[name='fld10']",
				"val"=>$q->row()->discount
				],[
				"fld"=>"input[name='fld11']",
				"val"=>$q->row()->quantity
				],[
				"fld"=>"chk2[name='fld12']",
				"val"=>$q->row()->discount_per_item
				],[
				// "fld"=>"chk3[name='if_kelipatan']",
				// "val"=>$q->row()->applies_multiply
				// ],[
				// "fld"=>"input[name='fld13']",
				// "val"=>$q->row()->max_multiples
				// ],[
				"fld"=>"img[id='img1_output']",
				"val"=>base_url()."images/"."promo_".$q->row()->id.".jpg?param=".md5(date('YmdHis'))
				]
			);
		echo json_encode($res);
	}

	function get_id(){
		$q = $this->db->query("select max(id)+1 as cnt from promo");
		$id = $q->row()->cnt;
		echo json_encode (array(
				'id' => $id
		));
	}

	function upload_gambar(){
		$id = $this->input->get('id');
		if($_FILES['fld14']['name']){
			$this->load->library('image_lib');
			$config = array(
				'upload_path' => './images/',
				'allowed_types' => 'jpg',
				'overwrite' => TRUE,
				'max_size' => 0,
				'max_height' => 0,
				'max_width' => 0,
				'file_name' => "promo_".$id
			);

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('fld14')){
                $error = array('error' => $this->upload->display_errors());
				$dvar = array("err" => "1", "msg" => $error);
				$this->load->vars($dvar);
			} else {
                $image_data = $this->upload->data();
				$configer =  array(
					'image_library'   => 'gd2',
					'source_image'    =>  $image_data['full_path'],
					'maintain_ratio'  =>  TRUE,
					'width'           =>  250,
					'height'          =>  250,
				);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();

                $error = array('error' => $this->upload->display_errors());
				$dvar = array("err" => "1", "msg" => "Upload gambar sukses...");
				$this->load->vars($dvar);
			}
		}
	}

}
?>
