<?php
class M_promo extends CI_Model{
	var $table  = 'promo';
	var $table2 = 'productcategory';
	//set column field database for datatable orderable
	var $column_order = array(
		null,
		'name',
		'start_date',
		'end_date',
		'category_product',
		'discount_type'
	);
	//set column field database for datatable searchable
	var $column_search = array('name','category_product','discount_type');
	 // default order
	var $order = array('promo.id' => 'desc');

	public function __construct() {
        parent::__construct();
    }

	private function _get_datatables_query(){
		$this->db->select(
		'
		promo.name,
		promo.start_date,
		promo.end_date,
		promo.quantity,
		productcategory.name as category_product,
		promo.discount_type,
		promo.id as aksi,
		promo.id'
		);
		$where = "promo.id is not null";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'productcategory.id = promo.product_category_id', 'left');
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
		$where = "promo.id is not null";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'productcategory.id = promo.product_category_id', 'left');
		$this->db->where($where);
		return $this->db->count_all_results();
	}

	function save_data($id,$name,$type,$syarat,$size,$kategori,$allproduk,$mulai,$akhir,$diskon,$quantity,$peritem){
		$hasil= $this->db->query("SELECT * FROM promo WHERE name = '$name' AND discount_type='$type'");
		$result = $hasil->result_array();
		$count = count($result);
		if(empty($count)){
			$qry = $this->db->query("INSERT INTO promo (id,end_date,image_size,name,all_product,start_date,product_category_id,term,discount,discount_per_item,discount_type,quantity)
			VALUES('$id','$akhir','$size','$name','$allproduk','$mulai','$kategori','$syarat','$diskon','$peritem','$type','$quantity')");
			if($qry){
				$q = $this->db->query("select max(id) as cnt from promo");
				$id = $q->row()->cnt;
				$hasil = array(
					'id' => $id,
					'status' => 'insert success'
				);
			}
		}else{
			$hasil = array(
				'id' => '',
				'status' => 'terdaftar'
			);
		}
		return $hasil;
	}
	function update_data($id,$name,$type,$syarat,$size,$kategori,$allproduk,$mulai,$akhir,$diskon,$quantity,$peritem){
		$qry = $this->db->query("UPDATE promo SET end_date = '$akhir', image_size = '$size', name = '$name', all_product = '$allproduk', start_date = '$mulai',
			product_category_id = '$kategori', term = '$syarat', discount = '$diskon', discount_per_item = '$peritem',
			 discount_type = '$type', quantity = '$quantity' WHERE id='$id'");
			 $hasil = array(
 				'id'	=> $id,
				'status' => 'update success'
			);
		return $hasil;
	}
}
