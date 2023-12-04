<?php
class Member_model extends CI_Model{
	// var $user_prefix="RKM";
	// var $random_user=false;
	// var $pool_size=2; // pool count
	// var $downline_table="member_tree";
	// var $downline_order="parent_id, position";
	// var $downline_parent="parent_id";

	var $user_prefix="DT";
	var $random_user=false;
	var $pool_size=3; 
	var $downline_table="members";
	var $downline_order="refid";
	var $downline_parent="refid";

	
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
    
	public function getallusers(){	
		$query=$this->db->get("users");
		$array=$query->result_array();
		return $array;
	}
	
	public function getbanks(){	
		$query=$this->db->get("banks");
		$array=$query->result_array();
		return $array;
	}
	public function getstate(){
		$this->db->where(array('type'=>'State','status!='=>0));
		$query=$this->db->get("area");
		$array=$query->result_array();
		return $array;
	}
	public function getdist($data){
		$this->db->where(array('type'=>'District','status!='=>0,'parent_id'=>$data['state_id']));
		$query=$this->db->get("area");
		$array=$query->result_array();
		return $array;
	}
	
	public function addmember($data){
		$userdata=$data['userdata'];
		$memberdata=$data['memberdata'];
		$accountdata=$data['accountdata'];
		$treedata=$data['treedata'];
		$user=$this->adduser($userdata);
		
		if(is_array($user) && $user['status']===true){
			$regid=$user['regid'];
			$username=$user['username'];
			$password=$user['password'];
			$memberdata['regid']=$regid;
			$accountdata['regid']=$regid;
			$memberdata['added_on']=date('Y-m-d H:i:s');
			
			$this->db->insert("members",$memberdata);
			$this->db->insert("acc_details",$accountdata);
			$this->db->insert("nominee",array("regid"=>$regid));
			if(is_array($treedata) && isset($treedata['position'])){
				$treedata['regid']=$regid;
				$this->addintree($treedata);
			}
			elseif($treedata=="auto"){
				$this->addinautotree($regid);
			}
			elseif($treedata=="pool"){
				$this->addinpool($regid);
			}
			if($memberdata['epin']!=''){
				$package=$this->Package_model->getpackage("id in (SELECT package_id from ".TP."epins where epin='$memberdata[epin]')","single");
				$activatedata['package_id']=$package['id'];
				$activatedata['epin']=$memberdata['epin'];
				$activatedata['regid']=$regid;
				$this->activatemember($activatedata);
			}
			if(!empty($_SESSION['role'])){
				if($_SESSION['role']=="member"){
					$this->addlevel($regid);
				}
			}else{
				$this->addlevel($regid);
			}
			
			
		}
		return $user;
	}

	public function no_of_members(){
		$where = array('status'=>1);
		return $this->db->get_where('tmp_members',$where)->num_rows();
	}
	public function total_members(){
		$where = array('regid!='=>1);
		return $this->db->get_where('tmp_members',$where)->num_rows();
	}
	
	public function totalturn_over(){
		$where = array('t1.status'=>1);
		$this->db->where($where);
		$this->db->select('t2.amount');
		$this->db->from('tmp_members as t1');
		$this->db->join('tmp_packages t2','t1.package_id=t2.id','left');
		$qry = $this->db->get();
		$amount =  $qry->result_array();
		return $amount;

	}

	public function no_of_deactivemembers(){
		$where = array('status'=>0);
		return $this->db->get_where('tmp_members',$where)->num_rows();
	}

	public function kycnotification(){
		$where = array('kyc'=>0);
		return $this->db->get_where('tmp_acc_details',$where)->num_rows();
	}

	public function current_closinglist(){
		$where = array();
		$date = date('Y-m-d');
		if($date<=date('Y-m-10')){
			$where['date<='] = date('Y-m-10');
			$where['date>='] = date('Y-m-01');
		}elseif($date>=date('Y-m-10') && $date<=date('Y-m-20')){
			$where['date<='] = date('Y-m-20');
			$where['date>='] = date('Y-m-11');
		}elseif($date>=date('Y-m-10') && $date<=date('Y-m-31')){
			$where['date<='] = date('Y-m-31');
			$where['date>='] = date('Y-m-21');
		}
		$rec = $this->Wallet_model->memberincome($where);
		return $rec;
		// echo PRE;
		// print_r($rec);die;


	}

	public function powerid(){
		$regid = $this->session->userdata('id');
		$where = array('status'=>1,'regid'=>$regid);
		return $this->db->get_where('tmp_power_id',$where)->unbuffered_row('array');
			
	}

	public function no_of_products(){
		$where = array('status'=>1);
		return $this->db->get_where('tmp_product_master',$where)->num_rows();
	}

	public function purchase_amount(){
		$date = date('Y-m-d');
		$where = array('added_on'=>$date);
		$this->db->where($where);
		$this->db->select_sum('price');
		$this->db->from('tmp_purchase');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');

	}

	public function memberpurchase_amount(){
		$regid = $this->session->userdata('id');
		$where = array('member_id'=>$regid);
		$this->db->where($where);
		$this->db->select_sum('price');
		$this->db->from('tmp_purchase');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}
	public function packageamount_package(){
		$regid = $this->session->userdata('id');
		$this->db->select('t2.package');
		$this->db->from('members as t1');
		$this->db->join('packages as t2','t1.package_id=t2.id','left');
		$this->db->where(array('t1.regid'=>$regid));
		return $this->db->get()->row('package');

	}

	public function memberwalletincome_amount(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid);
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		$amount = $qry->unbuffered_row('array');
		$transamount = 0;
		if($amount>0){
			$this->db->where(array('sender_id'=>$regid,'type'=>'level_fund'));
			$this->db->select_sum('amount');
			$this->db->from('tmp_fund_transfer');
			$qrya = $this->db->get();
			$transamount =  $qrya->unbuffered_row('array');
		}

		$memberid = $this->db->get_where('users',array('id'=>$regid))->row('username');
		$where7=array("receiver_id"=>$memberid,"type"=>"level_fund");
		$this->db->select_sum('amount');
		$query6=$this->db->get_where("tmp_fund_transfer",$where7);
		$getamount=$query6->row()->amount;
		if($getamount==NULL){ $getamount=0; }



		$amount['amount'] = $amount['amount']-$transamount['amount']+$getamount;
		return $amount;
	}

	public function getfundtransgferlist(){
		$regid = $this->session->userdata('id');
		$where = array('sender_id'=>$regid,'type'=>'roi_fund');
		return $this->db->get_where('tmp_fund_transfer',$where)->result_array();
	}

	public function getfundtransgferlistforlevel(){
		$regid = $this->session->userdata('id');
		$where = array('sender_id'=>$regid,'type'=>'level_fund');
		return $this->db->get_where('tmp_fund_transfer',$where)->result_array();
	}

	public function memberroiincome_amount(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid);
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet_second');
		$qry = $this->db->get();
		$amount =  $qry->unbuffered_row('array');
		$transamount = 0;
		if($amount>0){
			$this->db->where(array('sender_id'=>$regid,'type'=>'roi_fund'));
			$this->db->select_sum('amount');
			$this->db->from('tmp_fund_transfer');
			$qrya = $this->db->get();
			$transamount =  $qrya->unbuffered_row('array');
		}

		$memberid = $this->db->get_where('users',array('id'=>$regid))->row('username');
		$where7=array("receiver_id"=>$memberid,"type"=>"roi_fund");
		$this->db->select_sum('amount');
		$query6=$this->db->get_where("tmp_fund_transfer",$where7);
		$getamount=$query6->row()->amount;
		if($getamount==NULL){ $getamount=0; }



		$amount['amount'] = $amount['amount']-$transamount['amount']+$getamount;
		return $amount;
	}

	public function memberlevelincome_amount(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid);
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		$amount =  $qry->unbuffered_row('array');
		$transamount = 0;
		if($amount>0){
			$this->db->where(array('sender_id'=>$regid,'type'=>'level_fund'));
			$this->db->select_sum('amount');
			$this->db->from('tmp_fund_transfer');
			$qrya = $this->db->get();
			$transamount =  $qrya->unbuffered_row('array');
		}
		$memberid = $this->db->get_where('users',array('id'=>$regid))->row('username');
		$where7=array("receiver_id"=>$memberid,"type"=>"roi_fund");
		$this->db->select_sum('amount');
		$query6=$this->db->get_where("tmp_fund_transfer",$where7);
		$getamount=$query6->row()->amount;
		if($getamount==NULL){ $getamount=0; }
		$amount['amount'] = $amount['amount']-$transamount['amount']+$getamount ;
		return $amount;
	}

	public function left_member_count(){
		$regid = $this->session->userdata('id');
		$leftright=$this->Member_model->getleftrightmembers($regid,NULL,"regids");
          	$leftmembers=$leftright['left'];
          	return count($leftmembers);
	}

	public function right_member_count(){
		$regid = $this->session->userdata('id');
		$leftright=$this->Member_model->getleftrightmembers($regid,NULL,"regids");
          	$rightmembers=$leftright['right'];
          	return count($rightmembers);
	}


	public function active_member_count(){
		$regid = $this->session->userdata('id');
		$leftright=$this->Member_model->getallmembers($regid,$type="active");
			if(!empty($leftright)){

          	 return count($leftright['active']);
			}else{
				return 0;
			}
	}

	public function getfundreceivelist(){
		$regid = $this->session->userdata('id');
		$memberid = $this->db->get_where('users',array('id'=>$regid))->row('username');
			$where7=array("t1.receiver_id"=>$memberid);
			$this->db->where($where7);
			$this->db->select('t1.*,t2.username,t2.name');
			$this->db->from('tmp_fund_transfer as t1');
			$this->db->join('users as t2','t1.sender_id=t2.id','left');
			return $this->db->get()->result_array();


			return $this->db->get_where("tmp_fund_transfer",$where7)->result_array();
	}

	public function leadership_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Leadership Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function direct_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Direct Sale Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function reward_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid);
		$where1 = array('remarks'=>'Reward Bonus in 180 days package');
		$where2 = array('remarks'=>'Reward Bonus in 120 days package');
		$where3 = array('remarks'=>'Reward Bonus in 60 days package');
		$where4 = array('remarks'=>'Reward 90days Bonus');
		$where5 = array('remarks'=>'Reward 60days Bonus');
		$where6 = array('remarks'=>'Reward 30days Bonus');
		$this->db->where($where);
		$this->db->where($where1);
		$this->db->or_where($where6);
		$this->db->or_where($where5);
		$this->db->or_where($where4);
		$this->db->or_where($where3);
		$this->db->or_where($where2);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function repurchase_bonus()
	{
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid);
		$where1 = array('remarks'=>'Repurchase Plan For Complete Level One');
		$where2 = array('remarks'=>'Repurchase Plan For Complete Level Two');
		$where3 = array('remarks'=>'Repurchase Plan For Complete Level Three');
		$where4 = array('remarks'=>'Repurchase Plan For Complete Level Forth');
		$where5 = array('remarks'=>'Repurchase Plan For Complete Level Fifth');
		$where6 = array('remarks'=>'Repurchase Plan For Complete Level Sixth');
		$where7 = array('remarks'=>'Repurchase Plan For Complete Level Seventh');
		$where8 = array('remarks'=>'Repurchase Plan For Complete Level Eighth');
		$where9 = array('remarks'=>'Repurchase Plan For Complete Level Ninth');
		$where10 = array('remarks'=>'Repurchase Plan For Complete Level Tenth');
		$where11 = array('remarks'=>'Repurchase Plan For Complete Level Eleventh');
		$this->db->where($where);
		$this->db->where($where1);
		$this->db->or_where($where2);
		$this->db->or_where($where3);
		$this->db->or_where($where4);
		$this->db->or_where($where5);
		$this->db->or_where($where6);
		$this->db->or_where($where7);
		$this->db->or_where($where8);
		$this->db->or_where($where9);
		$this->db->or_where($where10);
		$this->db->or_where($where11);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function travel_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Travel Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function car_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Car Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function house_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'House Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function luxury_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Luxury Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function imark_bonus(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'I Mark Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}
	
	public function adduser($userdata){
		$this->db->order_by('id desc');
		$username=$this->generateusername();
		$userdata['username']=$username;
		$password=random_string('numeric', 5);
		$trans_password=random_string('numeric', 5);
		$userdata['vp']=$password;
		$salt=random_string('alnum', 16);
		$encpassword=md5($password.SITE_SALT.$salt);
		$userdata['salt']=$salt;
		$userdata['password']=$encpassword;
		$userdata['trans_password']=$trans_password;
		$userdata['created_on']=date('Y-m-d H:i:s');
		$userdata['updated_on']=date('Y-m-d H:i:s');
		if($this->db->insert("users",$userdata)){
			$regid=$this->db->insert_id();
			$result=array("status"=>true,"regid"=>$regid,"username"=>$username,"password"=>$password,"trans_password"=>$trans_password);
			return $result;
		}
		else{
			$error= $this->db->error();
			$error['status']=false;
			return $error;
		}
	}
	
	public function check_mobile($mobile){
	    return  $this->db->get_where('users',array('mobile'=>$mobile))->num_rows();
	}
	public function check_email($email){
	    return  $this->db->get_where('users',array('email'=>$email))->num_rows();
	}

	public function generateusername($username=''){
		if($this->random_user===false){
			if($username!=''){
				$username++;
			}
			else{
				$this->db->order_by("id desc");
				$array=$this->db->get_where("users",array("role"=>"member"))->unbuffered_row('array');
				if(!empty($array)){
					$usrname = array_column($array, 'username');
					$userid = random_string('numeric',5);
					$name=$this->user_prefix.$userid;
					if(!in_array($name, $usrname)){
						$username = $name;
					}else{
						$userid = random_string('numeric',5);
					    $username=$this->user_prefix.$userid;
					}
				}
				else{
					$userid = random_string('numeric',5);
					$username=$this->user_prefix.$userid;
				}
				// if(!empty($array)){
				// 	$username=$array['username'];
				// 	$username++;
				// }
				// else{
				// 	$username=$this->user_prefix."100001";
				// }
			}
		}
		else{
			$userid=random_string('numeric',6);
			$username=$this->user_prefix.$userid;
		}
		$where="username='$username'";
		$query=$this->db->get_where("users",$where);
		$checkuser=$query->num_rows();
		if($checkuser!=0){
			return $this->generateusername($username);
		}
		else{
			return $username;
		}
	}
	
	public function addintree($treedata){
		$where['parent_id']=$treedata['parent_id'];
		$where['position']=$treedata['position'];
		$treedata['added_on']=date('Y-m-d H:i:s');
		$this->db->insert("member_tree",$treedata);
	}
	
	public function findleaf($parent_id,$position){
		$where="position='$position' and parent_id='$parent_id'";
		$query=$this->db->get_where("member_tree",$where);
		$checkposition=$query->num_rows();
		if($checkposition!=0){
			$newparent_id=$query->row()->regid; 
			return $this->findleaf($newparent_id,$position);
		}
		else{
			return $parent_id;
		}
	}

	public function purcahse_status_update($data){
		$where =array('id'=>$data['request_id']);
		$query=$this->db->get_where("tmp_purchase",$where)->unbuffered_row('array');
		if(!empty($query['member_id'])){
			$where=array('id'=>$data['request_id']);
			$this->db->where($where);
			$rec = $this->db->update("tmp_purchase",array("approve_status"=>1));
			if($rec){
				$regid = $query['member_id'];
				return $this->wallet_purchase_update($regid);
				
			}
		}
	}

	public function self_bv(){
		$regid = $this->session->userdata('id');
		$this->db->where(array('approve_status'=>1,'member_id'=>$regid));
				// $this->db->group_end();
				$this->db->from("tmp_purchase t1");
				$selfdirect=$this->db->get()->result_array();
				$totalselfbv=array_column($selfdirect,'bv');
				$totalselfbv=array_sum($totalselfbv);
				return $totalselfbv;


	}
	public function direct_business(){
		$regid = $this->session->userdata('id');
		$rec = $this->getdirectmembers($regid);
		$rec = array_column($rec,'package_amount');
		$rec = array_sum($rec);
		return $rec;
	}

	public function total_business(){
		$regid = $this->session->userdata('id');
		$rec = $this->getallmembers($regid);
		$rec = array_column($rec,'package_amount');
		$rec = array_sum($rec);
		return $rec;
	}

	public function  both_bv($date=NULL){
		$regid = $this->session->userdata('id');
    	if($date===NULL){
			$date=date('Y-m-d');
		}
		$currentdate= date('Y-m-d');
       	$lastdate = date("Y-m-d", strtotime ('-7 days',strtotime ($currentdate)));
		$checkstatus=$this->Wallet_model->checkstatus($regid,$date);

		if($checkstatus)
		{
			$currentdate= date('Y-m-d');
       		$lastdate = date("Y-m-d", strtotime ('-7 days',strtotime ($currentdate)));
			$leftright=$this->Member_model->getleftrightmembers($regid,NULL,"regids");
          	$leftmembers=$leftright['left'];
            $rightmembers=$leftright['right'];

       		if(empty($leftmembers) || empty($rightmembers)){
                return false;
            }
            if(!empty($leftmembers)){
				$this->db->group_start();
				$left_chunks = array_chunk($leftmembers,25);
				foreach($left_chunks as $left_chunk){
					$this->db->or_where_in('t1.member_id', $left_chunk);
				}
				$this->db->where(array('approve_status'=>1));
				$this->db->group_end();
				$this->db->from("tmp_purchase t1");

				$leftdirect=$this->db->get()->result_array();
			}

			if(!empty($rightmembers)){
				$this->db->group_start();
				$right_chunks = array_chunk($rightmembers,25);
				foreach($right_chunks as $right_chunk){
					$this->db->or_where_in('t1.member_id', $right_chunk);
				}
				$this->db->where(array('approve_status'=>1));
				$this->db->group_end();
				$this->db->from("tmp_purchase t1");
				$rightdirect=$this->db->get()->result_array();
			}			
			$leftbv=array_column($leftdirect,'bv');
			$leftbv=array_sum($leftbv);
			$rightbv=array_column($rightdirect,'bv');
			$rightbv=array_sum($rightbv);
			$both_bv = array();
			$both_bv['leftbv'] = $leftbv;
			$both_bv['rightbv'] = $rightbv;
			return $both_bv;

			}	
		}


		public function both_iv($date=NULL){
			 $regid = $this->session->userdata('id');
    	if($date===NULL){
			$date=date('Y-m-d');
		}
		$checkstatus=$this->Wallet_model->checkstatus($regid,$date);
		$result=$commission=array();
		if($checkstatus){	
            $leftright=$this->Member_model->getleftrightmembers($regid,NULL,"regids");
          	$leftmembers=$leftright['left'];
            $rightmembers=$leftright['right'];	
	            if(empty($leftmembers) || empty($rightmembers)){
	                return false;
	            }

				if(!empty($leftmembers)){

					$this->db->group_start();
					$left_chunks = array_chunk($leftmembers,25);
					foreach($left_chunks as $left_chunk){
						$this->db->or_where_in('t1.regid', $left_chunk);
					}
					$this->db->group_end();
					$this->db->from("members t1");
					$where="t1.status='1' AND t1.activation_date<='$date' AND t1.refid='$regid'";
					$this->db->where($where);
					$leftdirect=$this->db->get()->num_rows();
					
				}
				
				if(!empty($rightmembers)){
					$this->db->group_start();
					$right_chunks = array_chunk($rightmembers,25);
					foreach($right_chunks as $right_chunk){
						$this->db->or_where_in('t1.regid', $right_chunk);
					}
					$this->db->group_end();
					$this->db->from("members t1");
					$where="t1.status='1' and t1.activation_date<='$date' and t1.refid='$regid'";
					$this->db->where($where);
					$rightdirect=$this->db->get()->num_rows();
				}


				if(!empty($leftmembers)){
					$this->db->select("t1.regid,t2.amount,t2.iv");
					$this->db->group_start();
					$left_chunks = array_chunk($leftmembers,25);
					foreach($left_chunks as $left_chunk){
						$this->db->or_where_in('t1.regid', $left_chunk);
					}
					$this->db->group_end();
					$this->db->order_by(" t1.activation_date");
					$this->db->from("members t1");
					$this->db->join("packages t2","t1.package_id=t2.id");
					$where="t1.status='1' and t1.activation_date<='$date'";
					$this->db->where($where);
					$left=$this->db->get()->result_array();
				}

				
				if(!empty($rightmembers)){
					$this->db->select("t1.regid,t2.amount,t2.iv");
					$this->db->group_start();
					$right_chunks = array_chunk($rightmembers,25);
					foreach($right_chunks as $right_chunk){
						$this->db->or_where_in('t1.regid', $right_chunk);
					}
					$this->db->group_end();
					$this->db->order_by(" t1.activation_date");
					$this->db->from("members t1");
					$this->db->join("packages t2","t1.package_id=t2.id");
					$where="t1.status='1' and t1.activation_date<='$date'";
					$this->db->where($where);
					$right=$this->db->get()->result_array();
				}
				$leftiv=array_column($left,'iv');
				$leftiv=array_sum($leftiv);
				$rightiv=array_column($right,'iv');
				$rightiv=array_sum($rightiv);
				$both_iv['leftiv'] = $leftiv;
				$both_iv['rightiv'] = $rightiv;
				return $both_iv;
			}
		}






	public function purcahse_status_reject($data){
		$where =array('id'=>$data['request_id']);
		$query=$this->db->get_where("tmp_purchase",$where)->unbuffered_row('array');
		if(!empty($query['member_id'])){
			$where=array('id'=>$data['request_id']);
			$this->db->where($where);
			$rec = $this->db->update("tmp_purchase",array("approve_status"=>2));
			if($rec){
				$regid = $query['member_id'];
				return $this->wallet_purchase_cancel($regid);
				
			}
		}
	}

	public function wallet_purchase_update($regid){
		$where = array('remarks'=>'Purchase','regid'=>$regid,'status'=>0);
		$this->db->Select('id');
		$this->db->from('withdrawals');
		$this->db->where($where);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$res = $this->db->get()->unbuffered_row('array');
		if(!empty($res)){
			$wh = array('id'=>$res['id']);
			$rec['approve_date'] = date('Y-m-d');
			$rec['status'] = 1;
			$this->db->where($wh);
			 return $this->db->update("withdrawals",$rec);
		}
	}

	public function wallet_purchase_cancel($regid){
		$where = array('remarks'=>'Purchase','regid'=>$regid,'status'=>0);
		$this->db->Select('id');
		$this->db->from('withdrawals');
		$this->db->where($where);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$res = $this->db->get()->unbuffered_row('array');
		if(!empty($res)){
			$wh = array('id'=>$res['id']);
			$rec['approve_date'] = date('Y-m-d');
			$rec['status'] = 2;
			$this->db->where($wh);
			 return $this->db->update("withdrawals",$rec);
		}
	}


	
	public function purchase_list_model(){
		$this->db->where(array('t1.approve_status'=>1));
		$this->db->select('t1.*,t2.product as product_name,t3.username');
		$this->db->from('tmp_purchase t1');
		$this->db->join('tmp_product_master t2','t1.product=t2.id','left');
		$this->db->join('tmp_users t3','t1.member_id=t3.id','left');
		$this->db->order_by('t1.added_on','DESC');
		return $this->db->get()->result_array();
	}

	public function purchase_list_request_model(){
		$this->db->where(array('t1.approve_status'=>0));
		$this->db->select('t1.*,t2.product as product_name,t3.username');
		$this->db->from('tmp_purchase t1');
		$this->db->join('tmp_product_master t2','t1.product=t2.id','left');
		$this->db->join('tmp_users t3','t1.member_id=t3.id','left');
		$this->db->order_by('t1.added_on','DESC');
		return $this->db->get()->result_array();
	}
	
	public function addinautotree($regid){
		$treedata=$this->autofindleaf($regid);
		$treedata['regid']=$regid;
		$treedata['added_on']=date('Y-m-d H:i:s');
		$this->db->insert("member_tree",$treedata);
	}
	
	public function autofindleaf($regids){
		if(!is_array($regids)){ 
			$refid=$this->db->get_where("members",array("regid"=>$regids))->unbuffered_row()->refid;
			$regids=array($refid);
		}
		$newregids=array();
		foreach($regids as $regid){
			$this->db->order_by("position");
			$where="parent_id='$regid'";
			$query=$this->db->get_where("member_tree",$where);
			$count=$query->num_rows();
			if($count<2){
				if($count==0){ $position="L"; }
				else{ $position="R"; }
				return array("parent_id"=>$regid,"position"=>$position);
			}
			else{
				$children=$query->result_array();
				$newregids=array_column($children,'regid');
			}
		}
		if(!empty($newregids)){
			return $this->autofindleaf($newregids);
		}
	}
	
	public function addinpool($regid){
		$data['regid']=$regid;
		$data['added_on']=date('Y-m-d H:i:s');
		$this->db->order_by("id desc");
		$query=$this->db->get("member_tree");
		$count=$query->num_rows();
		if($count>0){
			$last=$query->unbuffered_row('array');
			$lastposition=$last['position'];
			if($lastposition=='F'){
				$position='L';
				$parent_id=$last['regid'];
			}
			elseif($lastposition=='L'){
				$parent_id=$last['parent_id'];
				if($this->pool_size==3){ $position='M'; }
				elseif($this->pool_size==4){ $position='ML'; }
				else{ $position="R"; }
			}
			elseif($lastposition=='ML'){
				$parent_id=$last['parent_id'];
				$position="MR";
			}
			elseif($lastposition=='M' || $lastposition=='MR'){
				$parent_id=$last['parent_id'];
				$position="R";
			}
			else{
				$position='L';
				$id=ceil($count/$this->pool_size);
				$parent_id=$this->db->get_where("member_tree",array("id"=>$id))->unbuffered_row()->regid;
			}
		}
		else{
			$parent_id=0;
			$position='F';
		}
		$data['parent_id']=$parent_id;
		$data['position']=$position;
		$this->db->insert("member_tree",$data);
	}
	
	public function addlevel($regid){
		$leveldata=array();
		$this->db->select("regid,GetAncestry(regid) as ancestors");
		$ancestors=$this->db->get_where("members",array("regid"=>$regid))->unbuffered_row()->ancestors;
		$ancestors=explode(',',$ancestors);
		
		if(is_array($ancestors)){
			foreach($ancestors as $key=>$ancestor){
				$level_id=$key+1;
				if($level_id>28){ continue; }
				$single['regid']=$ancestor;
				$single['level_id']=$level_id;
				$single['member_id']=$regid;
				$single['added_on']=date('Y-m-d H:i:s');
				$leveldata[]=$single;
			}
		}
		if(!empty($leveldata)){
			 $this->db->insert_batch("level_members",$leveldata);
			
		}
	}

	
		
	public function getalldetails($regid){
		$member=$this->getmemberdetails($regid);
		$member['password']=$this->db->get_where("users",array("id"=>$regid))->unbuffered_row()->vp;
		$sponsor=$this->Account_model->getuser(array("id"=>$member['refid']));
		$member['susername']=$sponsor['username'];
		$member['sname']=$sponsor['name'];
		$acc_details=$this->getaccdetails($regid);
		$nominee_details=$this->getnomineedetails($regid);
		$result=array("member"=>$member,"acc_details"=>$acc_details,"nominee_details"=>$nominee_details);
		return $result;
	}

	public function insertpayment($data){
		$data['added_on'] = date('Y-m-d H:i:s');
		unset($data['requestepin']);
		return $this->db->insert("tmp_payment",$data);
	}

	public function get_payment_list($regid){
		$this->db->where(array('t1.regid'=>$regid,'t1.status'=>1));
		$this->db->select('t1.*,t2.username as userid,t2.name');
		$this->db->from('tmp_payment as t1');
		$this->db->join('users as t2','t1.regid=t2.id','left');
		return $this->db->get()->result_array();
	}

	public function get_payment_request_list(){
		$this->db->where(array('t1.status'=>1,'t1.approve_status'=>1));
		$this->db->select('t1.*,t2.username as userid,t2.name');
		$this->db->from('tmp_payment as t1');
		$this->db->join('users as t2','t1.regid=t2.id','left');
		return $this->db->get()->result_array();
	}
	public function get_approvedpayment_request_list(){
		$this->db->where(array('t1.status'=>1,'t1.approve_status'=>2));
		$this->db->select('t1.*,t2.username as userid,t2.name');
		$this->db->from('tmp_payment as t1');
		$this->db->join('users as t2','t1.regid=t2.id','left');
		return $this->db->get()->result_array();
	}

	public function approve_id($id){
		$data = array('approve_status'=>2);
		return $this->db->update("tmp_payment",$data ,array("id"=>$id));
	}

	public function approve_cancel_id($id){
		$data = array('approve_status'=>0);
		return $this->db->update("tmp_payment",$data ,array("id"=>$id));
	}
	
	public function getmemberdetails($regid){
		$this->db->select('t1.*,t2.package,t2.amount,t5.name as districtname, t6.name as statename');
		$this->db->from('members as t1');
		$this->db->join('packages as t2','t1.package_id=t2.id','left');
		$this->db->join('area t5','t1.district=t5.id','Left');
				$this->db->join('area t6','t1.state=t6.id','Left');
		$this->db->where(array("t1.regid"=>$regid));
		return $this->db->get()->unbuffered_row('array');
		// return $this->db->get_where("members",array("regid"=>$regid))->unbuffered_row('array');
	}
	
	public function getaccdetails($regid){
		return $this->db->get_where("acc_details",array("regid"=>$regid))->unbuffered_row('array');
	}
	
	public function getnomineedetails($regid){
		return $this->db->get_where("nominee",array("regid"=>$regid))->unbuffered_row('array');
	}
	
	public function getphoto(){
		$user=$this->session->user;
		$this->db->select('photo');
		$array=$this->db->get_where("members",array("md5(regid)"=>$user))->unbuffered_row('array');
		if(!is_array($array) || $array['photo']==''){
			$array['photo']	="assets/images/blank.png";
		}
		$photo=file_url($array['photo']);
		return $photo;
	}
	
	public function updatepassword($data){
		$oldpass=$data['oldpass'];
		$password=$data['password'];
		$user=$data['user'];
		$where="md5(id)='$user'";
		$query = $this->db->get_where("users",$where);
		$result=$query->unbuffered_row('array');
		$checkpass=false;
		if(!empty($result)){
			$salt=$result['salt'];
			$oldpass=md5($oldpass.SITE_SALT.$salt);
			$hashpassword=$result['password'];
			if($oldpass==$hashpassword){
				$checkpass=true;
				$vp=$password;
				$password=md5($password.SITE_SALT.$salt);
				$this->db->where($where);
				$this->db->update("users",array("password"=>$password,"vp"=>$vp));
			}
		}
		return $checkpass;
	}

	public function updatetranspassword($data){
		// echo PRE;
		// print_r($data);die;
		$oldpass=$data['oldpass'];
		$password=$data['password'];
		$user=$data['user'];
		$where="md5(id)='$user'";
		$query = $this->db->get_where("users",$where);
		$result=$query->unbuffered_row('array');
		$checkpass=false;
		if(!empty($result)){
			$hashpassword=$result['trans_password'];
			if($oldpass==$hashpassword){
				$checkpass=true;
				$this->db->where($where);
				$this->db->update("users",array("trans_password"=>$password));
			}
			elseif(empty($result['trans_password'])){
				$checkpass=true;
				$this->db->where($where);
				$this->db->update("users",array("trans_password"=>$password));
			}
		}
		return $checkpass;
	}
	
	public function updatephoto($data,$where){
		if($this->db->update("members",$data,$where)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updatemember($data,$regid){
		$where1['id']=$regid;
		$where2['regid']=$regid;
		if(!empty($data['userdata'])){
			$this->db->update("users",$data['userdata'],$where1);
			$result=$this->updatepersonaldetails($data['memberdata'],$where2);
		}
		if(!empty($data['accountdata'])){
			$result=$this->updateaccdetails($data['accountdata'],$where2);
		}
		if($result===true){
			return true;
		}
		else{
			return $result;
		}
	}
	
	
	public function updatepersonaldetails($data,$where){
		if($this->db->update("members",$data,$where)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updatecontactinfo($data,$where){
		if($this->db->update("members",$data,$where)){
			$userdata['mobile']=$data['mobile'];
			$userdata['email']=$data['email'];
			$where2=array("id"=>$where['regid']);
			$this->db->update("users",$userdata,$where2);
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updatenomineedetails($data,$where){
		$checknominee=$this->db->get_where("nominee",$where)->num_rows();
		if($checknominee==0){
			$data['regid']=$where['regid'];
			$result=$this->db->insert("nominee",$data);
		}
		else{
			$result=$this->db->update("nominee",$data,$where);
		}
		if($result){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updateaccdetails($data,$where){
		$checknominee=$this->db->get_where("acc_details",$where)->num_rows();
		if($checknominee==0){
			$data['regid']=$where['regid'];
			$result=$this->db->insert("acc_details",$data);
		}
		else{
			$result=$this->db->update("acc_details",$data,$where);
		}
		if($result){
			$where2=$where;
			$where2['account_no!=']='';
			$where2['ifsc!=']='';
			$where2['aadhar1!=']='';
			$where2['aadhar2!=']='';
			$where2['cheque!=']='';
			$where2['kyc!=']='1';
			$check=$this->db->get_where("acc_details",$where2)->num_rows();
			if($check!=0){
				$this->db->update("acc_details",array("kyc"=>"2"),$where);
			}
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function getpopupdetails($regid){
		if($regid!=1){
			$columns="t1.username,t1.name,t3.username as ref,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
			$this->db->select($columns);
			$this->db->from('users t1');
			$this->db->join('members t2','t2.regid=t1.id','Left');
			$this->db->join('users t3','t2.refid=t3.id','Left');
			$this->db->join('packages t4','t2.package_id=t4.id','Left');
			$this->db->where("t1.id",$regid);
			$query=$this->db->get();
			if($query->num_rows()==1){
				$array=$query->row_array();
				$array['date']=date('d-m-Y',strtotime($array['date']));
				if($array['activation_date']!='0000-00-00'){ $array['activation_date']=date('d-m-Y',strtotime($array['activation_date'])); }
				else{ $array['activation_date']='--/--/----'; }
				$leftright=$this->countleftrightmembers($regid);	
				$array['left']=$leftright['left'];
				$array['right']=$leftright['right'];
                $this->db->order_by('id desc');
                //$getrank=$this->db->get_where("rewards","id in (SELECT reward_id from `mr_reward_members` where regid='$regid')");
                $rank='--';
                /*if($getrank->num_rows()>0){
                    $rank=$getrank->unbuffered_row()->rank;
                }*/
                $array['rank']=$rank;
				return $array;
			}
			else{
				return false;
			}
		}
		else{
			$array=array("name"=>"Admin","date"=>"--/--/----","activation_date"=>"--/--/----","sponsor"=>"--");
			$leftright=$this->countleftrightmembers($regid);	
			$array['left']=$leftright['left'];
			$array['right']=$leftright['right'];
			$array['package']='--';
			return $array;
		}
	}
	public function getallmembersbytree($regid,$type="all"){
		$table=TP.$this->downline_table;
		$regids=NULL;
		$array=$result=array();
		$inclimit=$this->db->query("SET SESSION group_concat_max_len = 1000000;");
		$sql="select GROUP_CONCAT(regid SEPARATOR ',') as regids from 
				(select * from $table order by ".$this->downline_order.") level_members, 
				(select @pv := $regid) initialisation 
				where find_in_set(".$this->downline_parent.", @pv) > 0 and @pv := concat(@pv, ',', regid) ";
				// $this->db->join('level_members','members.regid=level_members.member_id','left');
				// $this->db->where(array('level_members.level_id<'=>3));
				// $this->db->limit(50);
			
		$exe=$this->db->query($sql);
		$regids=$exe->row()->regids;
		$list_id = $this->db->get_Where('level_members',array('regid'=>$regid,'level_id<'=>4))->result_array();
		$list_id = array_column($list_id,'member_id');
		$regids=explode(',',$regids);
		$regids = array_intersect($regids, $list_id);
		if($regids!==NULL){
			if($type=="all" || $type=="active"){
				$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
							t3.username as ref,t3.name as refname,t2.date,t2.activation_date,t2.time,ifnull(t4.package,'--') as package,t2.status";
				
				$this->db->group_start();
				$regid_chunks = array_chunk($regids,25);
				foreach($regid_chunks as $regid_chunk){
					$this->db->or_where_in('t1.id', $regid_chunk);
				}
				$this->db->group_end();
				
				$this->db->select($columns);
				$this->db->from('users t1');
				$this->db->join('members t2','t2.regid=t1.id','Left');
				$this->db->join('users t3','t2.refid=t3.id','Left');
				$this->db->join('packages t4','t2.package_id=t4.id','Left');
				if($type=="active"){
					$this->db->where("t2.status","1");
					$query=$this->db->get();
					$array=$query->result_array();
					$result['active']=$array;
					
					$this->db->group_start();
					$regid_chunks = array_chunk($regids,25);
					foreach($regid_chunks as $regid_chunk){
						$this->db->or_where_in('t1.id', $regid_chunk);
					}
					$this->db->group_end();
					
					$this->db->select($columns);
					$this->db->from('users t1');
					$this->db->join('members t2','t2.regid=t1.id','Left');
					$this->db->join('users t3','t2.refid=t3.id','Left');
					$this->db->join('packages t4','t2.package_id=t4.id','Left');
					$this->db->where("t2.status","0");
					$query=$this->db->get();
					$array=$query->result_array();
					$result['inactive']=$array;
				}
				else{
					$query=$this->db->get();
					$array=$query->result_array();
					$result=$array;
				}
			}
			else{
				$result=$regids;
			}
		}
		// return $this->db->last_query();
		return $result;
	}
	
	public function getallmembers($regid,$type="all"){
		$table=TP.$this->downline_table;
		$regids=NULL;
		$array=$result=array();
		$inclimit=$this->db->query("SET SESSION group_concat_max_len = 1000000;");
		$sql="select GROUP_CONCAT(regid SEPARATOR ',') as regids from 
				(select * from $table order by ".$this->downline_order.") member_tree, 
				(select @pv := '$regid') initialisation 
				where find_in_set(".$this->downline_parent.", @pv) > 0 and @pv := concat(@pv, ',', regid)";

				
		$exe=$this->db->query($sql);
		$regids=$exe->row()->regids;
		if($regids!==NULL){
			$regids=explode(',',$regids);
			if($type=="all" || $type=="active"){
				$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
							t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t4.amount as package_amount,t2.status, t5.name as distname,t6.name as statename";
				
				$this->db->group_start();
				$regid_chunks = array_chunk($regids,25);
				foreach($regid_chunks as $regid_chunk){
					$this->db->or_where_in('t1.id', $regid_chunk);
				}
				$this->db->group_end();
				
				$this->db->select($columns);
				$this->db->from('users t1');
				$this->db->join('members t2','t2.regid=t1.id','Left');
				$this->db->join('users t3','t2.refid=t3.id','Left');
				$this->db->join('packages t4','t2.package_id=t4.id','Left');
				$this->db->join('area t5','t2.district=t5.id','Left');
				$this->db->join('area t6','t2.state=t6.id','Left');
				if($type=="active"){
					$this->db->where("t2.status","1");
					$query=$this->db->get();
					$array=$query->result_array();
					$result['active']=$array;
					
					$this->db->group_start();
					$regid_chunks = array_chunk($regids,25);
					foreach($regid_chunks as $regid_chunk){
						$this->db->or_where_in('t1.id', $regid_chunk);
					}
					$this->db->group_end();
					
					$this->db->select($columns);
					$this->db->from('users t1');
					$this->db->join('members t2','t2.regid=t1.id','Left');
					$this->db->join('users t3','t2.refid=t3.id','Left');
					$this->db->join('packages t4','t2.package_id=t4.id','Left');
					
					$this->db->join('area t5','t2.district=t5.id','Left');
					$this->db->join('area t6','t2.state=t6.id','Left');
					$this->db->where("t2.status","0");
					$query=$this->db->get();
					$array=$query->result_array();
					
					$result['inactive']=$array;
				}
				else{
					$query=$this->db->get();
					$array=$query->result_array();
					$result=$array;
				}
			}
			else{
				$result=$regids;
			}
		}
		return $result;
	}

	public function getmonthlyreport($regid,$type,$where){
		// echo PRE;
		// print_r($where);die;
		$table=TP.$this->downline_table;
		$regids=NULL;
		$array=$result=array();
		$inclimit=$this->db->query("SET SESSION group_concat_max_len = 1000000;");
		$sql="select GROUP_CONCAT(regid SEPARATOR ',') as regids from 
				(select * from $table order by ".$this->downline_order.") member_tree, 
				(select @pv := '$regid') initialisation 
				where find_in_set(".$this->downline_parent.", @pv) > 0 and @pv := concat(@pv, ',', regid)";
		$exe=$this->db->query($sql);
		$regids=$exe->row()->regids;
		if($regids!==NULL){
			$regids=explode(',',$regids);
			if($type=="all" || $type=="active"){
				$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
							t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
				
				$this->db->group_start();
				$regid_chunks = array_chunk($regids,25);
				foreach($regid_chunks as $regid_chunk){
					$this->db->or_where_in('t1.id', $regid_chunk);
				}
				$this->db->group_end();
				
				$this->db->select($columns);
				$this->db->from('users t1');
				$this->db->join('members t2','t2.regid=t1.id','Left');
				$this->db->join('users t3','t2.refid=t3.id','Left');
				$this->db->join('packages t4','t2.package_id=t4.id','Left');
				if($type=="active" || $type=="all"){
					$this->db->where($where);
					$query=$this->db->get();
					// return $this->db->last_query();
					$array=$query->result_array();
					$result['active']=$array;
					
					$this->db->group_start();
					$regid_chunks = array_chunk($regids,25);
					foreach($regid_chunks as $regid_chunk){
						$this->db->or_where_in('t1.id', $regid_chunk);
					}
					$this->db->group_end();
					
					$this->db->select($columns);
					$this->db->from('users t1');
					$this->db->join('members t2','t2.regid=t1.id','Left');
					$this->db->join('users t3','t2.refid=t3.id','Left');
					$this->db->join('packages t4','t2.package_id=t4.id','Left');
					$this->db->where("t2.status","0");
					$query=$this->db->get();
					$array=$query->result_array();
					$result['inactive']=$array;
				}
				else{
					$query=$this->db->get();
					$array=$query->result_array();
					$result=$array;
				}
			}
			else{
				$result=$regids;
			}
		}
		return $result;
	}
	
	public function countallmembers($regid){
		$table=TP.$this->downline_table;
		$sql="select count(regid) as members from 
				(select * from $table order by ".$this->downline_order.") member_tree, 
				(select @pv := '$regid') initialisation 
				where find_in_set(".$this->downline_parent.", @pv) > 0 and @pv := concat(@pv, ',', regid)";
		return $this->db->query($sql)->row()->members;
	}
	
	public function getfirstmember($regid){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		$this->db->where("t1.id",$regid);
		$query=$this->db->get();
		$array=$query->row_array();
		return $array;
	}
	
	public function getleftrightmembers($regid,$position=NULL,$type='all'){
		$left=$right=array();
		$where['parent_id']=$regid;
		$query=$this->db->get_where("member_tree",$where);
		if($query->num_rows()>0){
			$array=$query->result_array();
			
			foreach($array as $member){

				if($member['position']=='L' && ($position===NULL || $position=='left' )){
				
					$left=$this->getallmembers($member['regid'],$type);
					
					if($type=="all"){
						$first=$this->getfirstmember($member['regid']);
					}
					else{
						$first=$member['regid'];
					}
					array_unshift($left,$first);
				}
				if($member['position']=='R' && ($position===NULL || $position=='right' )){
					$right=$this->getallmembers($member['regid'],$type);
					if($type=="all"){
						$first=$this->getfirstmember($member['regid']);
					}
					else{
						$first=$member['regid'];
					}
					array_unshift($right,$first);
				}
			}
		}
		if($position=='left'){ $result=$left;  }
		elseif($position=='right'){ $result=$right;  }
		else{
			$result=array("left"=>$left,"right"=>$right);
		}
		return $result;
	}
	
	public function countleftrightmembers($regid,$position=NULL){
		$left=$right=0;
		$where['parent_id']=$regid;
		$query=$this->db->get_where("member_tree",$where);
		if($query->num_rows()>0){
			$array=$query->result_array();
			foreach($array as $member){
				if($member['position']=='L' && ($position===NULL || $position=='left' )){
					$left=$this->countallmembers($member['regid']);
					$left++;
				}
				if($member['position']=='R' && ($position===NULL || $position=='right' )){
					$right=$this->countallmembers($member['regid']);
					$right++;
				}
			}
		}
		if($position=='left'){ $result=$left;  }
		elseif($position=='right'){ $result=$right;  }
		else{
			$result=array("left"=>$left,"right"=>$right);
		}
		return $result;
	}

	
	
	public function getdirectmembers($regid){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t4.amount as package_amount,t2.status,t5.name as distname,t6.name as statename";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		$this->db->join('area t5','t2.district=t5.id','Left');
		$this->db->join('area t6','t2.state=t6.id','Left');
		
		$this->db->where("t2.refid",$regid);
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}

	public function getdirectativemembers($regid){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t4.amount as package_amount,t2.status,t5.name as distname,t6.name as statename";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		$this->db->join('area t5','t2.district=t5.id','Left');
		$this->db->join('area t6','t2.state=t6.id','Left');
		$this->db->order_by('t2.activation_date','ASC');	
		
		$this->db->where(array("t2.refid"=>$regid,"t2.status"=>'1'));
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	public function getdirectmembersreports($where){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status,t5.name as distname,t6.name as statename";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		$this->db->join('area t5','t2.district=t5.id','Left');
		$this->db->join('area t6','t2.state=t6.id','Left');
		
		$this->db->where($where);
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	public function getactivedirectmembers($regid){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		
		$this->db->where(array("t2.refid"=>$regid,"t2.status!="=>'0'));
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
	public function getmemberid($username,$status="activated"){
		$where="username='$username'";
		$query=$this->db->get_where("users",$where);
		if($query->num_rows()==1){
			$array=$query->row_array();
			$regid=$array['id'];
			$name=$array['name'];
			$statusarr=explode(',',$status);
			$status=array_shift($statusarr);
			if($status=='downline' && $regid!=0 && $this->session->role=='member'){
				$downline=false;
				$refid=$this->db->get_where("members",array("regid"=>$regid))->unbuffered_row()->refid;
				while($refid>1){
					if(md5($refid)==$this->session->user){ $downline=true; break; }
					$refid=$this->db->get_where("members",array("regid"=>$refid))->unbuffered_row()->refid;
				}
				if($downline===false){$regid=0;$name="Enter different Member ID!";}
				$status=array_shift($statusarr);
			}
			elseif($status=='downline' && $this->session->role=='admin'){
				$status=array_shift($statusarr);
			}
			if($status=='not self' && $regid!=0){
				if(md5($regid)==$this->session->user){$regid=0;$name="Enter different Member ID!";}
				$status=array_shift($statusarr);
			}
			if($status=='activated' && $regid!=0){
				$check=$this->db->get_where("members",array("regid"=>$regid,"status"=>"1"))->num_rows();
				if($check!=1){$regid=0;$name="Member ID not Activated!";}
				$status=array_shift($statusarr);
			}
			if($status=='not activated' && $regid!=0){
				$check=$this->db->get_where("members",array("regid"=>$regid,"status"=>"0"))->num_rows();
				if($check!=1){$regid=0;$name="Member ID Already Activated!";}
				$status=array_shift($statusarr);
			}
			if($status=='day limit' && $regid!=0){
				$daylimit=date("Y-m-d",strtotime("-10 days"));
				$check=$this->db->get_where("members",array("regid"=>$regid,"date<"=>$daylimit))->num_rows();
				if($check==1){$regid=0;$name="You cannot activate this ID!";}
				$status=array_shift($statusarr);
			}
		}
		else{$regid=0;$name="Member ID not Available!";}
		$result=array("regid"=>$regid,"name"=>$name);
		return $result;
	}
	
	public function activatemember($data){
		$regid=$data['regid'];
		$updata['activation_date']=date('Y-m-d');
		$updata['epin']=$data['epin'];
		$updata['package_id']=$data['package_id'];
		$updata['status']=1;
		$data['date']=date('Y-m-d');
		if($this->db->update("members",$updata,array("regid"=>$regid))){
			$added_on=$this->Epin_model->updatepinstatus($data['epin'],$regid);
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
    public function gethomedata($regid){
        $result=array();
        $leftright=$this->countleftrightmembers($regid);
        $result['leftmembers']=$leftright['left'];
        $result['rightmembers']=$leftright['right'];
        $result['newmembers']=$leftright['left']+$leftright['right'];
        $result['totalmembers']=$leftright['left']+$leftright['right'];
        
        $directmembers=$this->getdirectmembers($regid);
        $result['directmembers']=count($directmembers);
        
        $this->db->select_sum("total_amount","payable");
        $income=$this->db->get_where("payment",array("regid"=>$regid))->unbuffered_row()->payable;
        if($income===NULL){$income=0;}
        $result['income']=$income;
        $packagewise=$this->packagewise();
        $result['packagewise']=$packagewise;
        return $result;
    }
    
    public function packagewise(){
        $result=array();
        $packages=$this->Package_model->getpackage();
        $this->db->order_by('id desc');
        $lastpayday=$this->db->get_where("payment")->unbuffered_row()->date;
        foreach($packages as $package){
            $allcount=$this->db->get_where("members",array("package_id"=>$package['id']))->num_rows();
            $newcount=$this->db->get_where("members",array("package_id"=>$package['id'],"activation_date>="=>$lastpayday))->num_rows();
            $todaycount=$this->db->get_where("members",array("package_id"=>$package['id'],"activation_date="=>date('Y-m-d')))->num_rows();
            $result[]=array("package"=>$package['package'],"allcount"=>$allcount,"newcount"=>$newcount,"todaycount"=>$todaycount);
        }
		
		$allcount=$this->db->get_where("renewal",array("status>"=>0))->num_rows();
		$newcount=$this->db->get_where("renewal",array("status>"=>0,"approve_date>="=>$lastpayday))->num_rows();
		$todaycount=$this->db->get_where("renewal",array("status>"=>0,"approve_date="=>date('Y-m-d')))->num_rows();
		$result[]=array("package"=>"Renewal","allcount"=>$allcount,"newcount"=>$newcount,"todaycount"=>$todaycount);
		
        return $result;
    }
    
	public function requestupgrade($data){
		if($this->db->insert("upgrade",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function getupgraderequests($where=array(),$type='all'){
		$this->db->select("t1.*, t2.username,t2.name");
		$this->db->from('upgrade t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->unbuffered_row('array'); }
		return $array;
	}
	
	public function approveupgrade($request_id){
		$updata['approve_date']=date('Y-m-d');
		$updata['status']=1;
		if($this->db->update("upgrade",$updata,array("id"=>$request_id))){
            $regid=$this->db->get_where("upgrade",array("id"=>$request_id))->unbuffered_row()->regid;
            $this->db->update("members",array("upgrade"=>1),array("regid"=>$regid));
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function kyclist($status=2){
		$where['t1.kyc']=$status;
		$this->db->select("t1.*, t2.username,t3.name");
		$this->db->from('acc_details t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('members t3','t1.regid=t3.regid','Left');
		$this->db->where($where);
		$query=$this->db->get();
		 $array=$query->result_array(); 
		return $array;
	}
	
	public function approvekyc($data,$where){
		if($this->db->update("acc_details",$data,$where)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function countlevelwisemembers($regid,$date=NULL){
		$where=array("regid"=>$regid);
		if($date!==NULL){
			$where['date(added_on)<=']=$date;
		}
		$this->db->select("level_id as level,count(*) as levelcount");
		$this->db->from("level_members");
		$this->db->where($where);
		$this->db->group_by("level_id");
		$this->db->order_by("level_id");
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
	public function countlevelwiseactivemembers($regid,$date=NULL){
		$where=array("t1.regid"=>$regid);
		if($date!==NULL){
			$where['date(t1.added_on)<=']=$date;
		}
		$this->db->select("t1.level_id as level,count(*) as levelcount");
		$this->db->from("level_members t1");
		$this->db->join("(Select * from ".TP."members where status=1 ) t2","t2.regid=t1.member_id");
		$this->db->where($where);
		$this->db->group_by("t1.level_id");
		$this->db->order_by("t1.level_id");
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
	public function levelwisemembers($regid,$date=NULL){
		$where=array("t1.regid"=>$regid,"amount!="=>"");
		if($date!==NULL){
			$where['date(t1.added_on)<=']=$date;
		}
		$this->db->select("t1.member_id,t1.level_id as level,t2.username,t2.name,t4.amount,t3.activation_date");
		$this->db->from("level_members t1");
		$this->db->join("users t2","t1.member_id=t2.id");
		$this->db->join('members t3','t1.member_id=t3.regid','Left');
		$this->db->join('packages t4','t3.package_id=t4.id','Left');
		$this->db->where($where);
		$this->db->order_by("t1.level_id");
		$query=$this->db->get()->result_array();
		// return $this->db->last_query();
		// $array=$query->result_array();
		return $query;
	}

	///////////////////////Pankaj///////////////////////////////////
	public function gettodaydirectmembers($regid,$date){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,t1.mobile, concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status,t4.amount as package_amount";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		$this->db->where(array("t2.refid"=>$regid));
		$query=$this->db->get();
		$array=$query->result_array();
		// $array=$query->num_rows();
		// print_r($array); die;
		return $array;
	}

	public function get_reward_day_list(){
		return $this->db->get_where('tmp_reward_master_days',array('status'=>1))->result_array();
	}

	public function levelincome(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Star Level Income');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function cashbackincome_amount(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Monthly Income');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function directbonus_amount(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Direct Bonus');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}
	public function instantincome_amount(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Direct Sponsor Income');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}
	public function getupgradelist(){
		$this->db->select('t1.*,t2.username,t2.name,t3.amount');
		$this->db->from('tmp_upgrade_ids t1');
		$this->db->join('users t2','t1.regid=t2.id','left');
		$this->db->join('packages t3','t1.package_id=t3.id','left');
		return $this->db->get()->result_array();
	}
	public function upgrade_id($data){
	
		if(!empty($data['refid'])){
			$check = $this->packageidcheck($data);
			if($check>0){
				$ins['added_on']= date('Y-m-d');
				$ins['regid']= $data['refid'];
				$ins['package_id']= $data['package_id'];
				return $this->db->insert('tmp_upgrade_ids',$ins);
			}else{
				return false;
			}
		}
	}

	public function payoutlist_byid($regid){
		return $this->db->get_where('tmp_wallet',array('regid'=>$regid))->result_array();	
	}

	public function sepratepaylist($where){
	
	
		$this->db->select('t1.*,t2.name,t2.username');
		$this->db->from('tmp_wallet as t1');
		$this->db->join('users as t2','t1.regid=t2.id','left');
		$this->db->where($where);
		$data =  $this->db->get()->result_array();
	    return  $data;
	}

	public function payoutlist(){
		$where = array('t1.activation_date!='=>'0000-00-00');
		$this->db->where($where);
		$this->db->select('t1.name,t1.activation_date,t2.username,t2.id as regid');
		$this->db->from('members as t1');
		$this->db->join('users as t2','t1.regid=t2.id','left');
		$data =  $this->db->get()->result_array();
		if(!empty($data)){
			$realdata = $data;
			foreach ($data as $key => $value) {
				$where = array('regid'=>$value['regid']);
				$this->db->where($where);
				$this->db->select_sum('amount');
				$this->db->from('wallet');
				$qry = $this->db->get()->unbuffered_row('array');
				$realdata[$key]['amount'] = $qry['amount'];

				
			}
			return $realdata;
		}
	}
	public function trip_rewards($data){
	
		if(!empty($data['refid'])){
			$check = $this->packageidcheck($data);
			if($check>0){
				$ins['added_on']= date('Y-m-d');
				$ins['regid']= $data['refid'];
				$ins['package_id']= $data['package_id'];
				return $this->db->insert('tmp_upgrade_ids',$ins);
			}else{
				return false;
			}
		}
	}
	public function packageidcheck($id){
		return $this->db->get_where('members',array('regid'=>$id['refid'],'status'=>1,'package_id!='=>$id['package_id']))->num_rows();
	}
	public function tripreward_amount(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Trip Reward');
		$this->db->where($where);
		$this->db->select('rank');
		$this->db->order_by('id','desc');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}
	public function workingincomess(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Working Income');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}
	public function level_income_total(){
		$regid = $this->session->userdata('id');
		$where = array('regid'=>$regid,'remarks'=>'Level Income');
		$this->db->where($where);
		$this->db->select_sum('amount');
		$this->db->from('tmp_wallet');
		$qry = $this->db->get();
		return $qry->unbuffered_row('array');
	}

	public function get_details(){
		$final = array();
		$regid = $this->session->userdata('id');
		$this->db->select('t1.*,t2.username as userid');
		$this->db->from('members as t1');
		$this->db->join('tmp_users as t2','t1.regid=t2.id','left');
		$this->db->where(array("t1.regid"=>$regid));
		$rec= $this->db->get()->row_array();
		// echo PRE;
		// print_r($rec);die;
		// $rec = $this->db->get_where('members',array("regid"=>$regid))->row_array();
		if(!empty($rec['refid']))
		$refid = $rec['refid'];
		$final[] = $rec;
		if(!empty($refid )){
			$this->db->where(array('id'=>$refid));
			$this->db->select('name as sponsor_name,username as sponsor_id, mobile as sponsor_mobile');
			$this->db->from('tmp_users');
			$final[] = $this->db->get()->row_array();
			$final = call_user_func_array("array_merge", $final);
			return $final;
		}
	}
	public function requesteupgradeides($data){
		$checklevel = $this->checklevelstatus($data);
		if($checklevel==0){
			$result=array();
			if($this->db->insert("tmp_levelupgrade",$data)){
				$result['status']= true;
			}
			else{
				$result['status']= true;
				$result['err']= $this->db->error();
			}
			
		}else{
			$result['status']= true;
			$result['msg']= "Already Submitted";
		}
		return $result;
	}
	public function getupgradeid($where){
		$this->db->select("t1.*, t2.username,t2.name");
		$this->db->from('tmp_levelupgrade t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->where($where);
		$query=$this->db->get();
		$array=$query->result_array(); 
		return $array;
	}
	public function getlevelrequests($where=array(),$type='all'){
		$this->db->select("t1.*, t2.username,t2.name");
		$this->db->from('tmp_levelupgrade t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->unbuffered_row('array'); }
		return $array;
	}

	public function updaterequestlevel($id,$status=2){
		$date=date('Y-m-d');
		if($this->db->update("tmp_levelupgrade",array("status"=>$status,"approve_date"=>$date),array("id"=>$id))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	

	public function checklevelstatus($data){
		if(!empty($data)){
			return $this->db->get_where('tmp_levelupgrade',array('regid'=>$data['regid'],'levels'=>$data['levels']))->num_rows();
		}
	}


	public function reward_days_save($data){
		if($this->db->insert("tmp_reward_master_days",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}

	public function reward_days_update($data){
		if($this->db->update("tmp_reward_master_days",$data,array("id"=>$data['id']))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}

	public function reward_days_delete($id){
		$data = array('status'=>0);
		if($this->db->update("tmp_reward_master_days",$data ,array("id"=>$id))){
			$rec['msg'] = "Delete Successfully";
			$rec['status'] = 1;
		}
		else{
			$rec['msg'] = $this->db->error();
			$rec['status'] = false;
			
		}
		return $rec;
	}

	public function delete_payment($id){
		$data = array('status'=>0);
		return $this->db->update("tmp_payment",$data ,array("id"=>$id));
	}

	public function powerid_delete($id){
		$data = array('status'=>0);
		if($this->db->delete("tmp_power_id",array("id"=>$id))){
			$rec['msg'] = "Delete Successfully";
			$rec['status'] = 1;
		}
		else{
			$rec['msg'] = $this->db->error();
			$rec['status'] = false;
			
		}
		return $rec;
	}

	public function reward_submit($data){
		if($this->db->insert("tmp_reward_master",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}

	public function product_master_submit($data){
		if($this->db->insert("tmp_product_master",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}

	public function get_product_master_list(){
		return $this->db->get_where('tmp_product_master',array('status'=>1))->result_array();
	}

	public function product_master_update($data){
		if($this->db->update("tmp_product_master",$data,array("id"=>$data['id']))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}

	public function product_master_delete($id){
		$data = array('status'=>0);
		if($this->db->update("tmp_product_master",$data ,array("id"=>$id))){
			$rec['msg'] = "Delete Successfully";
			$rec['status'] = 1;
		}
		else{
			$rec['msg'] = $this->db->error();
			$rec['status'] = false;
		}
		return $rec;
	}

	public function purchase_delete_model($data)
	{
		$id = $data['id'];
		$payment_mode = $data['payment_mode'];
		if($payment_mode==="Wallet"){
			$regid = $this->session->userdata('id');
			$ids=$this->db->get_where("withdrawals",array("regid"=>$regid,"status"=>"0","remarks"=>"Purchase","approve_date"=>Null))->row('id');
			if(!empty($ids)){
				$w = array('id'=>$ids);
				$updt['status']=2;
				$res = $this->db->update("tmp_withdrawals",$updt ,$w);
				if($res){
					$record = array('status'=>0);
					if($this->db->update("tmp_purchase",$record ,array("id"=>$id))){
						$rec['msg'] = "Delete Successfully";
						$rec['status'] = 1;
					}
					else{
						$rec['msg'] = $this->db->error();
						$rec['status'] = false;
					}
					return $rec;
				}
			}
		}else{
			$record = array('status'=>0);
			if($this->db->update("tmp_purchase",$record ,array("id"=>$id))){
				$rec['msg'] = "Delete Successfully";
				$rec['status'] = 1;
			}
			else{
				$rec['msg'] = $this->db->error();
				$rec['status'] = false;
			}
			return $rec;
		}
		
		
		
	}

	public function get_purchase_list($id){
		return $this->db->get_where('tmp_product_master',array('id'=>$id))->row_array();
	}

	public function purcahse_save($data)
	{
		if($data['payment_mode']=='Wallet'){
			$payble['amount'] = $data['price'];
			$payble['regid'] = $data['member_id'];
			$payble['date'] = date('Y-m-d');
			$payble['remarks'] = 'Purchase';
			$payble['status'] = 0;
			$payble['updated_on'] = date('Y-m-d H:i:s');
			
			$regid = $data['member_id'];
			$check=$this->db->get_where("withdrawals",array("regid"=>$regid,"status"=>"0","remarks"=>"Purchase"))->num_rows();

			if($check==0){
				if($this->db->insert("withdrawals",$payble)){
					if($this->db->insert("tmp_purchase",$data)){
							return true;
						}
						else{
							return $this->db->error();
						}
				}
				else{
					return $this->db->error();
				}
			}

		}else{
			if($this->db->insert("tmp_purchase",$data)){
			return true;
			}
			else{
				return $this->db->error();
			}
		}
		

		


		
	}

	public function get_product_purchase_list(){
		$member_id = $_SESSION['id'];
		$this->db->select('t1.*,t2.product as product_name');
		$this->db->from('tmp_purchase t1');
		$this->db->join('tmp_product_master t2','t1.product=t2.id','left');
		$this->db->where(array('t1.member_id'=>$member_id,'t1.status'=>1));
		$qry = $this->db->get()->result_array();
		return $qry;
	}

	public function get_purchase_print($id){
		$this->db->select('t1.*,t2.product as product_name,t3.username,t3.mobile,t3.name');
		$this->db->from('tmp_purchase t1');
		$this->db->join('tmp_product_master t2','t1.product=t2.id','left');
		$this->db->join('tmp_users t3','t1.member_id=t3.id','left');
		$this->db->where(array('t1.id'=>$id));
		$qry = $this->db->get()->row_array();
		return $qry;

	}

	public function get_member_detailsby_id($member_id){
		$where = array('username'=>$member_id);
	  return $this->db->get_where('tmp_users',$where)->unbuffered_row('array');
	}

	public function powerid_save($data){
		if($this->db->insert("tmp_power_id",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}

	public function powerid_bv_save($data){
		$rec = $this->db->insert("tmp_powerid_bv",$data);
		$result = array();
		if($rec){
			$result['status']=true;
		}
		else{
			$result['status']='false';
			$result['error']=$this->db->error();
			
		}
		return $result;
	}

	public function get_power_id_list(){
		$where = array('status'=>1);
		return $this->db->get_where('tmp_power_id',$where)->result_array();
	}

	public function get_power_id_listbybv(){
		$where = array('status'=>1);
		return $this->db->get_where('tmp_powerid_bv',$where)->result_array();
	}









	
}