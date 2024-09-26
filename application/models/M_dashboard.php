<?php 
class M_dashboard extends CI_Model{
	function purchase_order(){		
		$query = $this->db->query("select count(1) as f from salesorder");
		$row = $query->row_array();
		$jumlah = $row['f'];
		return $jumlah;
	}
	
	function member(){		
		$query = $this->db->query("select count(1) as f from user where activation_code != ''");
		$row = $query->row_array();
		$jumlah = $row['f'];
		return $jumlah;
	}
	
	function tansaksi_baru(){		
		$query = $this->db->query("select count(1) as f from salesorder where status='0'");
		$row = $query->row_array();
		$jumlah = $row['f'];
		return $jumlah;
	}
}