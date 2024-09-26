<?php
class M_pengguna extends CI_Model{
	var $table = 'user';
	//set column field database for datatable orderable
	var $column_order = array(
		null,
		'firstname',
		'username',
		'email',
		'phone_number',
		'activation_code'
	);
	//set column field database for datatable searchable
	var $column_search = array('firstname','username', 'email', 'phone_number');
	 // default order
	var $order = array('id' => 'desc');

	public function __construct() {
        parent::__construct();
    }

	private function _get_datatables_query(){
		$this->db->select('id,firstname,username,email,phone_number,activation_code');
		$where = "office_id != '' and staff_id != ''";
		$this->db->from($this->table);
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
		$where = "office_id != '' and staff_id != ''";
		$this->db->from($this->table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}

	function save_data($firstname,$username,$email,$hp,$password,$office_id,$staff_id){
		$hasil= $this->db->query("SELECT * FROM user WHERE username = '$username' OR email='$email'");
		$result = $hasil->result_array();
		$count = count($result);
		if(empty($count)){
			$hasil= $this->db->query("INSERT INTO user (firstname,username,password,email,phone_number,office_id,staff_id)VALUES('$firstname','$username','$password','$email','$hp','$office_id','$staff_id')");
		}
		else{
			$hasil = array('status' => 'terdaftar');
		}
		return $hasil;
	}

	function update_data($id,$firstname,$username,$email,$hp,$password,$office_id,$staff_id){
		$hasil=$this->db->query("UPDATE user SET firstname='$firstname', username='$username', password='$password', email='$email', phone_number='$hp', office_id='$office_id', staff_id='$staff_id' WHERE id='$id'");
		return $hasil;
	}
}
