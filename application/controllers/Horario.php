
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horario extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('horario_model');
	}

	public function view($titulo = 'home', $arg)
	{
        if ( ! file_exists(APPPATH.'views/'.$arg['page'].'.php'))
        {
                // Whoops, we don't have a page for that!
                show_404();
        }
        $data['title'] = ucfirst($titulo);
        $this->load->view('base/head', $data);
        //$this->load->view('base/menu');        
        session_start();
		if($_SESSION['tipo'] == '0'){
			$this->load->view('base/menu');     
		}elseif ($_SESSION['tipo'] == '1') {
			$this->load->view('base/menu2');     
		}elseif ($_SESSION['tipo'] == '2') {
			$this->load->view('base/menu3');     
		}        
        $this->load->view($arg['page'], $arg);
        $this->load->view('base/foot');
	}
	/*Obteemos los horarios de un doctor en especifico,
	regresa una tabla si lo logra hacer. De otro modo regresa un false*/
	public function get_horario_cve(){
		$valor = $this->input->get('cve_doc');
		$cont = $this->horario_model->get_all_by_cve($valor);
		if($cont==FALSE){
			$arrayName = array(
				'edo' => false				
				);
		}else{
			$arrayName =$cont;
			//Convertir result array to json
		}
		echo json_encode($arrayName);
	}
	/*Creamos un nuevo horario que se asocia en la vista /Doctor/ver_horario*/
	public function crear_nuevo(){
		//var_dump($_POST);
		foreach ($_POST as $index => $value){
			//echo $index."=".$value."<br>";
			if (strpos($index, 'ini') !== false) {//valor <ini> esta dentro del <$index>
				$split= preg_split("[_]", $index);
				$pos = $split[1];
				$data2 = array(
					'fec_ini' => $this->input->post('ini_'.$pos),
					'fec_fin' => $this->input->post('fin_'.$pos),
					'cve_dia' => $pos,
					'doc' => $this->input->post('cvedoc')
				);
				$this->horario_model->insert_horario($data2);
			}
		}
		redirect(base_url("index.php/Doctor/ver_horario"));

	}
	/*Ejecutar el update del horario de un doctor en especifico*/
	public function update_horario(){
		//Eliminamos los datos ya existentes
		$data1 = array('doc' => $this->input->post('cvedoc'));
		$this->horario_model->delete_horario_by_cve($data1);
		//re-insert valores del horario
		$this->crear_nuevo();
		redirect(base_url("index.php/Doctor/ver_update_horario"));
		
	}
}
?>