<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){    
		parent::__construct();
		$ses = $this->session->userdata('nama');
		if(empty($ses)){
			redirect(base_url());
		}		
		$this->load->library('template');
		$this->load->model('m_dashboard');
	}
	
	public function index(){
		//default variable load data js
		$data['data_js'] = '';
		$data['title'] = "Dashboard";
		$data['po']	= $this->jumlah_order();
		$data['member'] = $this->jumlah_member();
		$data['trans_new'] = $this->jumlah_transaksi_baru();
		$this->active_menu();
		$this->template->template_admins('Dashboard',$data);
	}
	
	function active_menu(){
		$data = array( 
			'm1' 	=> 'active', 
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
	
	public function jumlah_order(){
		$data = $this->m_dashboard->purchase_order();
		return $data;
	}
	
	public function jumlah_member(){
		$data = $this->m_dashboard->member();
		return $data;
	}
	
	public function jumlah_transaksi_baru(){
		$data = $this->m_dashboard->tansaksi_baru();
		return $data;
	}
}
