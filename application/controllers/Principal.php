
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {
        function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function inicio($titulo = 'home'){
                if ( ! file_exists(APPPATH.'views/'.$titulo.'.php')){
                        // Whoops, we don't have a page for that!
                        show_404();
                }
                $this->load->view('base/head');
                $this->load->view('base/menu');        
                $this->load->view($titulo);
                $this->load->view('base/foot');
	}
}	
?>