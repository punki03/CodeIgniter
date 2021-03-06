<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dia_Model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}	
	public function getAll(){
		$sql = "SELECT * FROM dia";
		$data = $this->db->query($sql);
		return $data->result_array();		
	}

	public function horario_dia($data){// cdoc, hini, hfin, nom(usuario), apppat, apmat //le enviamos en data el cve_doc y el cve_dia
		$sql="select horario.cve_doc AS cdoc, horario.hora_inicio AS hini, horario.hora_fin AS hfin, usuario.nombre AS nom, usuario.ap_paterno AS appat, usuario.ap_materno AS apmat from horario inner join doctor on horario.cve_doc=doctor.cve inner join usuario on usuario.cve=doctor.cve_usu where cve_doc = '".$data['doc']."' and cve_dia =  '".$data['dia']."';";

		$data = $this->db->query($sql);
		if ($data->num_rows() > 0){
			return $data->result_array();	
		}
		return FALSE;		
	}
}
?>