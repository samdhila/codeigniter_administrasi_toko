<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_print extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->library('template');
		$this->load->model('m_pemesanan','salesorder');
	}
	
	public function index(){
		$data['title'] = "Print";
		$this->template->useAsset()->setJs('',array('print'));
		$data['data_js'] = $this->template->getMetadata();
		$data['data_order'] = $this->data_order();
		$this->template->template_print('print',$data);
	}
	
	function direct_print(){
		$data['cPrinterName']		= 'EPSON LX-310';
		$data['msPrinterType'] 		= 'Epson-LX';
		$data['PrintServer_Host'] 	= '';
		$data['PrintServer_Port'] 	= '1551';
	}
	
	function data_order(){
		$qchild = $this->db->query("select ssoi.sales_order_items_id, soi.product_id, p.name, soi.quantity, soi.unit_price, soi.discount, (soi.quantity*soi.unit_price)-soi.discount as subtotal, s.order_id from salesorder s, salesorder_sales_order_items ssoi, salesorderitems soi, product p where s.id=ssoi.sales_order_id AND ssoi.sales_order_items_id=soi.id AND soi.product_id=p.id and s.id='6' ORDER BY ssoi.sales_order_items_id");
		$data = $qchild->result_array();
		return $data;
	}
	
}
