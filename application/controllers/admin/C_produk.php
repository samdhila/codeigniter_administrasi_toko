<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_produk extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}
		$this->load->model('m_produk','produk');
		$this->load->library('template');
	}

	public function index(){
		$data['title'] = "Produk / Barang";
		$data['modal_produk'] = "modal_produk";
		$this->template->useAsset()->setJs('master/produk_barang',array('produk'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('master/produk_barang/v_produk',$data);
	}

	function active_menu(){
		$data = array(
			'm1' 	=>'',
			'm2'	=>'active open',
			'm2_1'	=>'',
			'm2_2'	=>'',
			'm2_3'	=>'',
			'm2_4'	=>'',
			'm2_5'	=>'',
			'm2_6'	=>'',
			'm2_7'	=>'',
			'm2_8'	=>'active',
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
		$list = $this->produk->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $produk) {
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-pencil bigger-130 green" data-toggle="modal" data-target="#modal_add_new" href="#" onclick="update(1,\''.$produk->id.'\')"></i>
					<a class="red" href="#" onclick="rem(1,\''.$produk->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
				</div>';

			$no++;
			$row = array();
			$row[] 	= $no;
			$row[] 	= $produk->barcode;
			$row[] 	= $produk->name;
			$row[] 	= $produk->size;
			$row[] 	= $produk->brand;
			$row[] 	= $produk->warna;
			$row[] 	= $produk->kategori;
			$row[] 	= $produk->supplier;
			$row[] 	= $produk->unit;
			$row[] 	= $produk->purchase_price;
			$row[] 	= $produk->selling_price;
			$row[] 	= $produk->description;
			$row[] 	= $aksi;
			$row[] 	= $produk->id;
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->produk->count_all(),
						"recordsFiltered" => $this->produk->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function add_data(){
		$url = "c_produk";
		$id = $this->input->post('fld1');
		if($id==""){
			$q = $this->db->query("select max(id)+1 as cnt from product");
			$id = $q->row()->cnt;
		}
		$data = array(
			'id' 				=> strtoupper($id),
			'barcode' 			=> strtoupper($this->input->post('fld2')),
			'name' 				=> $this->input->post('fld3'),
			'size' 				=> strtoupper($this->input->post('fld4')),
			'brand_id' 			=> strtoupper($this->input->post('fld5')),
			'color_id'			=> strtoupper($this->input->post('fld6')),
			'product_category_id' => strtoupper($this->input->post('fld7')),
			'unit_id' 			=> strtoupper($this->input->post('fld71')),
			'supplier_id' 		=> strtoupper($this->input->post('fld8')),
			'purchase_price' 	=> strtoupper($this->input->post('fld9')),
			'selling_price' 	=> strtoupper($this->input->post('fld10')),
			'description' 		=> $this->input->post('fld72'),
			'short_name' 		=> $this->input->post('fld3')
			/* $data = array (
				'id'	=> $id,
			 	'name'	=> $name,
			 	'discount_type'	=> $type,
			 	'image_size'	=> $size,
			 	'product_category_id'	=> $kategori,
			 	'start_date'	=> $mulai,
			 	'end_date'	=> $akhir,
			 	'quantity'	=> $quantity
			); */
		);
		$lnew = true;


		if($this->input->post('fld1')!=""){
			$this->db->where('id',$this->input->post('fld1'));
			$this->db->update('product', $data);
		} else {
			$this->db->insert('product', $data);
		}
		redirect(base_url("admin/".$url));
	}

	function add_produk() {
		$id = $this->input->post('id');
		if($id==""){
			$q = $this->db->query("select max(id)+1 as cnt from product");
			$id = $q->row()->cnt;
		}
		$barcode = $this->input->post('barcode');
		$name = $this->input->post('name');
		$ukuran = $this->input->post('ukuran');
		$brand = $this->input->post('brand');
		$warna = $this->input->post('warna');
		$kategori = $this->input->post('kategori');
		$unit = $this->input->post('unit');
		$keterangan = $this->input->post('keterangan');
		$supplier = $this->input->post('supplier');
		$beli = $this->input->post('beli');
		$jual = $this->input->post('jual');
		$short_name = $this->input->post('short_name');
		$tanggal = date('Y-m-d H:i:s');

		/* $data = array (
			'id'	=> $id,
		 	'barcode'	=> $barcode,
		 	'name'	=> $name,
		 	'ukuran'	=> $ukuran,
		 	'brand'	=> $brand,
		 	'warna'	=> $warna,
		 	'kategori'	=> $kategori,
		 	'unit'	=> $unit,
		 	'keterangan'	=> $keterangan,
		 	'supplier'	=> $supplier,
		 	'beli'	=> $beli,
		 	'jual'	=> $jual,
		 	'short_name'	=> $short_name
		 ); */
		if($this->input->post('id')!=""){
			$data = $this->produk->update_produk($id,$barcode,$name,$ukuran,$brand,$warna,$kategori,$unit,$keterangan,$supplier,$beli,$jual,$short_name,$tanggal);
		}else{
			$data = $this->produk->save_produk($barcode,$name,$ukuran,$brand,$warna,$kategori,$unit,$keterangan,$supplier,$beli,$jual,$short_name);
		}
		echo json_encode($data);
	}


	function delete_data($id,$val) {
		$whr = "id";
		$tbl = "product";
		$url = "c_produk";
		$this -> db -> where($whr, $val);
		$this -> db -> delete($tbl);
		$nm_file = $val.".jpg";
		$this->file_delete($nm_file);
		redirect(base_url("admin/".$url));
    }

	function file_delete($fl) {
		$path = FCPATH.'images/'.$fl;
		unlink($path);
		//echo $path;
	}


	function cari_rec(){
		$id  = $this->input->get('id');
		$frm = $this->input->get('frm');
		$whr = "id = '$id'";
		$fld = "barcode";
		$tbl = "product";
		$prn = ", product.*";
		$url = "c_produk";
		$q 	 = $this->db->query("select $fld as f $prn from $tbl where $whr");
		$res = array(
				[
				"fld"=>"input[name='fld2']",
				"val"=>$q->row()->f
				],[
				"fld"=>"input[name='fld3']",
				"val"=>$q->row()->name
				],[
				"fld"=>"input[name='fld4']",
				"val"=>$q->row()->size
				],[
				"fld"=>"select[name='fld5']",
				"val"=>$q->row()->brand_id
				],[
				"fld"=>"select[name='fld6']",
				"val"=>$q->row()->color_id
				],[
				"fld"=>"select[name='fld7']",
				"val"=>$q->row()->product_category_id
				],[
				"fld"=>"select[name='fld71']",
				"val"=>$q->row()->unit_id
				],[
				"fld"=>"select[name='fld8']",
				"val"=>$q->row()->supplier_id
				],[
				"fld"=>"input[name='fld9']",
				"val"=>$q->row()->purchase_price
				],[
				"fld"=>"input[name='fld10']",
				"val"=>$q->row()->selling_price
				],[
				"fld"=>"textarea[name='fld72']",
				"val"=>$q->row()->description
				],[
				"fld"=>"img[id='img1_output']",
				"val"=>base_url()."images/".$id.".jpg?idfile=".md5($q->row()->tanggal)
				]
			);
		echo json_encode($res);
	}

	function upload_gambar(){
		$id = $this->input->get('id');
		if($_FILES['fld12']['name']){
			$this->load->library('image_lib');
			$config = array(
				'upload_path' => './images/',
				'allowed_types' => 'jpg',
				'overwrite' => TRUE,
				'max_size' => 0,
				'max_height' => 0,
				'max_width' => 0,
				'file_name' => $id
			);

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('fld12'))        {
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
