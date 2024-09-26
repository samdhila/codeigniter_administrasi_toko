<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_pemesanan extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->model('m_pemesanan','salesorder');
		$this->load->library('template'); 
	}
	
	public function index(){
		$data['title'] = "Pemesanan";
		$data['modal_pemesanan'] = "modal_pemesanan";
		$this->template->useAsset()->setJs('transaksi/pemesanan',array('pemesanan'));
		$data['data_js'] = $this->template->getMetadata();
		$this->active_menu();
		$this->template->template_admins('transaksi/pemesanan/v_pemesanan',$data);
	}
	
	function active_menu(){
		$data = array( 
			'm1' 	=>'', 
			'm2'	=>'', 
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
			'm2_11'	=>'', 
			'm3'	=>'active open', 
			'm3_1'	=>'active', 
			'm3_2'	=>'',
			'm3_3'	=>'',
			'm4'	=>'', 
			'm4_1'	=>'', 
			'm4_2'	=>''
		);
		$menu = $this->load->vars($data);
		return $menu;
	}
	
	function get_data_pemesanan(){
		$list = $this->salesorder->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		foreach ($list as $salesorder) {
			if($salesorder->status == 0){
				$status = '<span class="label label-sm label-warning arrowed-in">Open</span>';
			}
			
			if($salesorder->status == 1){
				$status = '<span class="label label-sm label-inverse arrowed-in">Flagged</span>';
			}
			
			if($salesorder->status == 2){
				$status = '<span class="label label-sm label-success arrowed-in">Close</span>';
			}
			
			//Button Aksi
			$aksi = '
				<div class="action-buttons">
					<i class="ace-icon fa fa-print bigger-130 green" id="cetak_pemesanan" data-toggle="modal" href="#modal_print_preview" onclick="update(10,\''.$salesorder->id.'\')"></i>
					<!--<a class="green" href="#" data-toggle="modal" title="Print" data-target="#modal_add_new" onclick="update(10,\''.$salesorder->id.'\')">
						<i class="ace-icon fa fa-print bigger-130"></i>
					 </a>-->
					<!--
					<a class="red" href="#" onclick="rem(10,\''.$salesorder->id.'\')">
						<i class="ace-icon fa fa-trash-o bigger-130"></i>
					</a>
					-->
				</div>';
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $salesorder->order_id;
			$row[] = $salesorder->order_date;
			$row[] = $salesorder->nama;
			$row[] = $salesorder->payment_method;
			$row[] = $status;
			$row[] = $salesorder->discount;
			$row[] = $salesorder->total;
			$row[] = $aksi;
			$row[] = $salesorder->id;
			$data[] = $row;
		}

		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $this->salesorder->count_all(),
						"recordsFiltered" => $this->salesorder->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	
	function update_status($id,$act){
		$str = "";
		$str_c = "";
		if($act == 'cek'){
			$st = '1';
			$qs = $this->db->query("select status from salesorder where order_id = '$id'");
			$stta = $qs->row()->status;
			if($stta == 1){
				$ms = 1;
			}else{
				$q = $this->db->query("update salesorder set status= '$st' where order_id = '$id'");
				$ms = 2;
			}
		}
		else if($act == 'batal'){
			$st = '0';
			$q = $this->db->query("update salesorder set status= '$st' where order_id = '$id'");
			if($q){
				$str = "Success";
			}else{
				$str = "Gagal";
			}
		}
		
		else if($act == 'cetak'){
			$st = '2';
			$q = $this->db->query("update salesorder set status= '$st' where order_id = '$id'");
			if($q){
				$str_c = "Success";
			}else{
				$str_c = "Gagal";
			}
		}
		
		if($qs){
			$s = $stta;
		}else{
			$s = $stta;
		}
		$data = array(
			"status" 	=> $s,
			"st_batal"	=> $str,
			"st_cetak"	=> $str_c,
			"st_ambil"	=> $ms
		);
		echo json_encode($data);
	}
	
	public function cek_notif(){
		$data = $this->salesorder->cek_notif();
		echo json_encode($data);
	}
	
	public function Delete_Data(){
		
	}
	
	
	function cari_rec(){
		$id 	= $_GET['id'];
		$frm 	= $_GET['frm'];
		
		$whr 	= "a.id = '$id'";
		$fld	= "a.order_id";
		$tbl 	= "salesorder a LEFT JOIN user b ON b.id=a.user_id LEFT JOIN shippingaddress c ON c.id=a.shipping_address_id";
		$prn 	= ', a.order_date, concat(b.firstname," ",b.lastname) as nm, a.payment_method, a.discount, a.total, c.address, c.city, c.latitude, c.longitude, c.name, c.note, c.phone_number, c.postal_code, c.province';
		$url 	= "pemesanan";
		
		$q = $this->db->query("select $fld as f $prn from $tbl where $whr");
		$thead = "<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<th>Qty</th>
						<th>Harga</th>
						<th>Diskon</th>
						<th>Total</th>
					</tr>
				  </thead>";
			$qchild = $this->db->query("select ssoi.sales_order_items_id, soi.product_id, p.name, soi.quantity, soi.unit_price, soi.discount, (soi.quantity*soi.unit_price)-soi.discount as subtotal, s.order_id from salesorder s, salesorder_sales_order_items ssoi, salesorderitems soi, product p where s.id=ssoi.sales_order_id AND ssoi.sales_order_items_id=soi.id AND soi.product_id=p.id and s.id=$id ORDER BY ssoi.sales_order_items_id");
			$tbody="";
			$i=1;
			$total=0;
			foreach($qchild->result_array() as $r){
				$tbody.='<tr><td>'.$i++.'</td><td>'.$r['name'].'</td><td align="right">'.$r['quantity'].'</td><td align="right">'.number_format($r['unit_price'],0).'</td><td align="right">'.number_format($r['discount'],0).'</td><td align="right">'.number_format($r['subtotal'],0).'</td></tr>';
				$total+=$r['subtotal'];
			}
			$ttotal='<table><tr style="font-weight:bold;"><td colspan="5" align="right">Total Pemesanan</td><td align="right">'.number_format($total,0).'</td></tr></table>';
			$res = array(
				[ 
				"fld"=>"input[name='fld2']",
				"val"=>$q->row()->nm
				],
				[ 
				"fld"=>"input[name='fld3']",
				"val"=>$q->row()->name
				],
				[ 
				"fld"=>"textarea[name='fld4']",
				"val"=>$q->row()->address.", ".$q->row()->city." ".$q->row()->province." ".$q->row()->postal_code
				],
				[ 
				"fld"=>"input[name='fld5']",
				"val"=>$q->row()->phone_number
				],
				[ 
				"fld"=>"textarea[name='fld6']",
				"val"=>$q->row()->note
				],
				[ 
				"fld"=>"span[id='fld7']",
				"val"=>$q->row()->f
				],
				[ 
				"fld"=>"table[id='child-table']",
				"val"=>"<table>".$thead.$tbody."</table>".$ttotal
				],
				[ 
				"fld"=>"span[id='fld2']",
				"val"=>$q->row()->nm
				],
				[ 
				"fld"=>"span[id='fld3']",
				"val"=>$q->row()->name
				],
				[ 
				"fld"=>"span[id='fld4']",
				"val"=>$q->row()->address.", ".$q->row()->city." ".$q->row()->province." ".$q->row()->postal_code
				],
				[ 
				"fld"=>"span[id='fld5']",
				"val"=>$q->row()->phone_number
				]
			);					
		echo json_encode($res);
	}
	
	function update_pemesanan_shipped(){
		$id = $this->input->post('fld1');
		$ongkir = $this->input->post('ongkir');
		$lnew = true;
		if($id!=""){
			$data = array(
				'status' => '2',
				'shipping_charges' => $ongkir
			);
			$this->db->where('id',$id);
			$this->db->update('salesorder', $data);						
		}
		redirect(base_url('admin/c_pemesanan_2'));
	}
	
	function update_pemesanan_done(){
		$id = $this->input->post('fld1');
		$ongkir = $this->input->post('ongkir');
		$lnew = true;
		if($id!=""){
			$data = array(
			'status' => '3',
			'shipping_charges' => $ongkir
			);
			$this->db->where('id',$id);
			$this->db->update('salesorder', $data);						
		}
		redirect(base_url('admin/c_pemesanan_3'));
	}
	
	function get_dataprint(){
		
	}
	
}
