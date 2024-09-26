<?php
class Gvars{
	protected $_ci;
	protected $gvar;
	function __construct(){
		$this->_ci = &get_instance();
	}
	
	function var_index(){
		$lk_index = $this->gvar = 'index.php';
		return $lk_index;
	}
}