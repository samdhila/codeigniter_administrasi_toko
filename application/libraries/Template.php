<?php
class Template{
	protected $_ci;
    protected $base;
    protected $jsFolder = 'js_data';
    protected $delimiter = array();
    protected $script = array();
	
	function __construct(){
		$this->_ci = &get_instance();
	}
	
	public function useAsset(){
        $this->base = $this->_ci->config->item('asset_base');
        return $this; 
    }
	
    public function getMetadata(){
        $ret = '';
        foreach($this->script as $k => $v){
            $ret .= $v;
        }
        return $ret;
    }
	
    public function setJs($folder = '', $file = ''){
        //Determine if only 1 argument, there should be the name of file
        if(func_num_args() < 2){
            $folder = '';
            $file = func_get_arg(0);
        }else{
            $folder = $folder.'/';
        }
         
        //set delimiter for js
        $pre = '<script language="javascript" type="text/javascript" src="';
        $pre .= base_url().$this->base.$this->jsFolder.'/'.$folder;
        $end = '"></script>';
        $this->_delimiter($pre,$end);
         
        //send to create loop
        $this->_setAsset($file, 'js');
         
        return $this;
    }
	
    private function _delimiter($pre='',$end=''){
        $this->delimiter['pre'] = $pre;
        $this->delimiter['end'] = $end;
        return $this;
    }
     
    private function _setAsset($file,$ext){
        //put the prototype of data into an array
        $output = array();
        if(is_array($file)){
            foreach($file as $k => $filename){
                $output[] = $this->delimiter['pre'].$filename.'.'.$ext.$this->delimiter['end'];
            }
        }else{
            $output[] = $this->delimiter['pre'].$file.'.'.$ext.$this->delimiter['end'];
        }

        //Merge the result of loop into $script
        $this->script = array_merge($this->script,$output);
    }
	
	function template_admins($content,$data=NULL){
		$data['_header']	= $this->_ci->load->view('template/header',$data,true);
		$data['_sidebar']	= $this->_ci->load->view('template/sidebar',$data,true);
		$data['_content']	= $this->_ci->load->view($content,$data,true);
		$data['_footer']	= $this->_ci->load->view('template/footer',$data,true);
		$this->_ci->load->view('template/index',$data);
	}
	
	function template_users($content,$data=NULL){
		$data['_header']	= $this->_ci->load->view('template/header',$data,true);
		$data['_sidebar']	= $this->_ci->load->view('template/sidebar',$data,true);
		$data['_content']	= $this->_ci->load->view($content,$data,true);
		$data['_footer']	= $this->_ci->load->view('template/footer',$data,true);
		$this->_ci->load->view('template/index',$data);
	}
	
	function template_login($content,$data=NULL){
		$data['_header']	= $this->_ci->load->view('login/header',$data,true);
		$data['_content']	= $this->_ci->load->view($content,$data,true);
		$data['_footer']	= $this->_ci->load->view('login/footer',$data,true);
		$this->_ci->load->view('login/index',$data);
	}
	
	function template_print($content,$data=NULL){
		$data['_header'] 	= "";
		$data['_sidebar']	= "";
		$data['_content']	= $this->_ci->load->view($content,$data,true);
		$data['_footer']	= "";
		$this->_ci->load->view('template/index',$data);
	}
}