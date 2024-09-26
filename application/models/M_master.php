<?php 
class M_master extends CI_Model{
	
	function get_name($fld,$tbl,$id){
		$query = $this->db->query("SELECT $fld FROM $tbl WHERE id='$id'");
		$row = $query->row_array();
		if (isset($row)){
			$name = $row[$fld];
		}else{
			$name = "";
		}
		return $name;
	}
}