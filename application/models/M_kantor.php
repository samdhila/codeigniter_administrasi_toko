<?php
class M_kantor extends CI_Model{
	var $table = 'office';
	var $table2 = 'area';
	var $table3 = 'city';
	var $table4 = 'province';
	//set column field database for datatable orderable
	var $column_order = array(
		null,
		'name',
		'address',
		'phone_number',
		'kota',
		'provinsi',
		'area_kantor',
		'id'
	);
	//set column field database for datatable searchable
	var $column_search = array('name','order_id','address','phone_number');
	 // default order
	var $order = array('office.id' => 'desc');

	public function __construct() {
        parent::__construct();
    }

	private function _get_datatables_query(){
		$this->db->select(
		'office.name,
		office.address,
		office.phone_number,
		city.name as kota,
		province.name as provinsi,
		area.name as area_kantor,
		office.id'
		);
		$where = "office.id is not null and office.type ='1'";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'area.id = office.area_id', 'left');
		$this->db->join($this->table3, 'city.id = office.city_id', 'left');
		$this->db->join($this->table4, 'province.id = office.province_id', 'left');
		$this->db->where($where);
		$i = 0;
		// loop column
		foreach ($this->column_search as $item){
			// if datatable send POST for search
			if(isset($_POST['search']['value'])) {
				// first loop
				if($i===0) {
					// open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				//last loop
				if(count($this->column_search) - 1 == $i)
				$this->db->group_end(); //close bracket
			}
			$i++;
		}
		// here order processing
		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables(){
		$this->_get_datatables_query();
		//if($_POST['length'] != -1)
		if (isset($_POST['length']) && $_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered(){
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all(){
		$where = "office.id is not null and office.type ='1'";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'area.id = office.area_id', 'left');
		$this->db->join($this->table3, 'city.id = area.city_id', 'left');
		$this->db->join($this->table4, 'province.id = area.province_id', 'left');
		$this->db->where($where);
		return $this->db->count_all_results();
	}

	function save_data($name,$alamat,$area,$provinsi,$kota,$pos,$telepon,$latitude,$longitude,$type){
		$hasil= $this->db->query("SELECT * FROM office WHERE name = '$name' AND phone_number='$telepon'");
		$result = $hasil->result_array();
		$count = count($result);
		if(empty($count)){
			$hasil= $this->db->query("INSERT INTO office (name,address,area_id,province_id,city_id,postal_code,phone_number,latitude,longitude,type)
			VALUES('$name','$alamat','$area','$provinsi','$kota','$pos','$telepon','$latitude','$longitude','$type')");
		}
		else{
			$hasil = array('status' => 'terdaftar');
		}
		return $hasil;
	}

	function update_data($id,$name,$alamat,$area,$provinsi,$kota,$pos,$telepon,$latitude,$longitude,$type){
		$hasil=$this->db->query("UPDATE office SET name = '$name',address = '$alamat',area_id = '$area',province_id = '$provinsi',city_id = '$kota',postal_code = '$pos',phone_number = '$telepon',latitude = '$latitude',longitude = '$longitude',type = '$type'
			WHERE id='$id'");
		return $hasil;
	}
}
