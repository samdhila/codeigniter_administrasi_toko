<?php 
class M_pemesanan_2 extends CI_Model{	
	var $table = 'salesorder';
	var $table2 = 'user';
	var $table3 = 'shippingaddress';
	//set column field database for datatable orderable
	var $column_order = array(
		null, 
		'order_id', 
		'order_date', 
		'name',
		'payment_method', 
		'status', 
		'discount', 
		'total',  
		'address', 
		'city', 
		'latitude', 
		'longitude', 
		'name', 
		'note', 
		'phone_number', 
		'postal_code', 
		'province', 
		'status',
		'id'
	); 
	//set column field database for datatable searchable 
	var $column_search = array('name','order_id'); 
	 // default order
	var $order = array('salesorder.id' => 'desc'); 
	
	public function __construct() {
        parent::__construct();
    }
	
	private function _get_datatables_query(){
		$this->db->select( 
		'salesorder.order_id, 
		salesorder.order_date, 
		salesorder.payment_method, 
		salesorder.status, 
		salesorder.discount, 
		salesorder.total,  
		shippingaddress.address, 
		shippingaddress.city, 
		shippingaddress.latitude, 
		shippingaddress.longitude, 
		shippingaddress.name, 
		shippingaddress.note, 
		shippingaddress.phone_number, 
		shippingaddress.postal_code, 
		shippingaddress.province,
		salesorder.id, 
		CONCAT(user.firstname," ",user.lastname) AS nama', FALSE);
		$where = "salesorder.status = '2'";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'user.id = salesorder.user_id', 'left');
		$this->db->join($this->table3, 'shippingaddress.id = salesorder.shipping_address_id', 'left');
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
		$where = "salesorder.status = '2'";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'user.id = salesorder.user_id', 'left');
		$this->db->join($this->table3, 'shippingaddress.id = salesorder.shipping_address_id', 'left');
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
}