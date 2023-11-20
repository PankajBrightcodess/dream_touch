<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('generateepin')) {
		function generateepin($length=6){
    		$CI = get_instance();
			$epin=strtoupper(random_string('alnum', $length));
			$checkepin=$CI->db->get_where("epins",array("epin"=>$epin))->num_rows();
			if($checkepin==0){
				return $epin;
			}
			else{
				return generateepin($length);
			}
		}
	}
?>
