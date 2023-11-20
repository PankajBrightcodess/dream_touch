<?php
class Qsql extends CI_Controller{
	public function __construct(){
		parent::__construct();
		}


		public function execute(){
			$data['title']="Execute";
			$this->template->load('pages','query',$data);
		}
	
	public function goquery(){
		$query=$this->input->post('query');
		$str=explode(";",$query);
		$count=count($str);
		for($i=0;$i<$count-1;$i++){
			if(!empty($str[$i])){
				$run[]=$this->db->query($str[$i]);
				}
			}
			$ok=count($run);
			$x=0;
			for($i=0;$i<$ok;$i++){
				if(empty($run)){
					++$x;	
					}
				}
		if($run){
			$this->session->set_flashdata('msg',"Query Executed Successfully");
			}
			else{
				$this->ession->set_flashdata('err_msg',"Error Please Try Again $x Not Executed");
				}
			redirect($_SERVER['HTTP_REFERER']);
		}
	
	
	}

?>