<?php
class Package_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
	
	public function getpackage($where=array(),$type='all'){
		
		$this->db->where($where);
		$query=$this->db->get("packages");
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function getpackagerequests($where=array(),$type='all'){
		$this->db->select("t1.*, t2.username,t2.name,t3.package,t3.amount as package_amount,t3.pv");
		$this->db->from('package_request t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('packages t3','t1.package_id=t3.id','Left');
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function requestpackage($data){
		if($this->db->insert("package_request",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function approvepackage($data,$where=array()){
		$checkpackage=$this->db->get_where("members",array("regid"=>$data['regid'],"package_id"=>"0"))->num_rows();
		if(isset($data['epin'])){
			$updata['epin']=$data['epin'];
			unset($data['epin']);
		}
		$updata['package_id']=$data['package_id'];
		$updata['status']=1;
		if($checkpackage==1){
			$updata['activation_date']=date('Y-m-d');
		}
		$where2['regid']=$data['regid'];
		if($this->db->insert("member_package",$data)){
			if(!empty($where)){
				$this->db->update("package_request",array("status"=>"1"),$where);
			}
			$this->db->update("members",$updata,$where2);
			return true;
		}
		else{
			return $this->db->error();
		}
	}
}