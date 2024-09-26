<?php
class M_produk extends CI_Model{
	var $table  = 'product';
	var $table2 = 'brand';
	var $table3 = 'color';
	var $table4 = 'productcategory';
	var $table5 = 'supplier';
	var $table6 = 'unit';
	//set column field database for datatable orderable
	var $column_order = array(
		null,
		'barcode',
		'name',
		'size',
		'brand',
		'warna',
		'kategori',
		'supplier',
		'unit',
		'purchase_price',
		'selling_price',
		'description'
	);
	//set column field database for datatable searchable
	var $column_search = array('name','supplier','brand');
	 // default order
	var $order = array('product.id' => 'desc');

	public function __construct() {
        parent::__construct();
    }

	private function _get_datatables_query(){
		$this->db->select(
		'product.barcode,
		product.name,
		product.size,
		brand.name as brand,
		color.name as warna,
		productcategory.name as kategori,
		supplier.name as supplier,
		unit.name as unit,
		product.purchase_price,
		product.selling_price,
		product.description,
		product.id as aksi,
		product.id'
		);
		$where = "product.id is not null";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'brand.id = product.brand_id', 'left');
		$this->db->join($this->table3, 'color.id = product.color_id', 'left');
		$this->db->join($this->table4, 'productcategory.id = product.product_category_id', 'left');
		$this->db->join($this->table5, 'supplier.id = product.supplier_id', 'left');
		$this->db->join($this->table6, 'unit.id = product.unit_id', 'left');
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
		$where = "product.id is not null";
		$this->db->from($this->table);
		$this->db->join($this->table2, 'brand.id = product.brand_id', 'left');
		$this->db->join($this->table3, 'color.id = product.color_id', 'left');
		$this->db->join($this->table4, 'productcategory.id = product.product_category_id', 'left');
		$this->db->join($this->table5, 'supplier.id = product.supplier_id', 'left');
		$this->db->join($this->table6, 'unit.id = product.unit_id', 'left');
		$this->db->where($where);
		return $this->db->count_all_results();
	}

	function save_produk($barcode,$name,$ukuran,$brand,$warna,$kategori,$unit,$keterangan,$supplier,$beli,$jual,$short_name){
		$hasil = $this->db->query("SELECT * FROM product WHERE barcode = '$barcode' AND name = '$name'");
		$result = $hasil->result_array();
		$count = count($result);
		if(empty($count)){
			$hasil = $this->db->query("INSERT INTO product (barcode,description,name,purchase_price,selling_price,short_name,size,brand_id,color_id,product_category_id,supplier_id,unit_id)
			VALUES ('$barcode','$keterangan','$name','$beli','$jual','$short_name','$ukuran','$brand','$warna','$kategori','$supplier','$unit')");
		} else{
			$hasil = array('status' => 'terdaftar' );
		}
		return $hasil;
	}

	function update_produk($id,$barcode,$name,$ukuran,$brand,$warna,$kategori,$unit,$keterangan,$supplier,$beli,$jual,$short_name,$tanggal){
		$hasil = $this->db->query("UPDATE product SET barcode = '$barcode', description = '$keterangan', name = '$name', purchase_price = '$beli', selling_price = '$jual',
		short_name = '$short_name',size = '$ukuran', brand_id = '$brand', color_id = '$warna', product_category_id = '$kategori', supplier_id = '$supplier', unit_id = '$unit', tanggal = '$tanggal' WHERE id = '$id' ");
		return $hasil;
	}
}
