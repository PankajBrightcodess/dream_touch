<?php
class Wallet_model extends CI_Model{
	
	


	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
	public function checkstatus($regid,$date=NULL){
		$where=array("regid"=>$regid,"status"=>1);
		if($date!==NULL){
			$where['activation_date<=']=$date;
		}
		$checkstatus=$this->db->get_where("members",$where)->num_rows();
		

		if($checkstatus==0){
		    return false;
		}
		else{ 
			return true; 
		}
	}

	public function addcommission($regid,$date=NULL){
        $this->directsponsor($regid,$date);




		// $this->cashbackdategenerate($regid,$date);
		// $this->cashbackincome($regid,$date);
		// $this->instant_referal_income($regid,$date);
		// $this->car_reward($regid,$date);
		// $this->level_income($regid,$date);
		
		// $this->cashbackdategenerate($regid,$date);
		// $this->trip_reward($regid,$date);
		// $this->matchingincome($regid,$date);
		// $this->directsponsor($regid,$date);
		// $this->rewardbonus($regid,$date);
		// $this->repurchaseplan($regid,$date);
		// $this->check_tour_bonus($regid,$date);
		// $this->check_car_bonus($regid,$date);
		// $this->check_house_bonus($regid,$date);
		// $this->check_luxury_bonus($regid,$date);
		//$this->addroyaltyincome($regid,$date);
		//$this->addreward($regid,$date);
	}

	// public function generate_income($regid,$date=NULL){
	// 	$this->tour_bonus_distribution();
	// 	$this->car_bonus_distribution();
	// 	$this->house_bonus_distribution();
	// 	$this->luxury_bonus_distribution();
	// }
	public function userslist($start,$limit){
		$this->db->select('id');
		$where="id>1";
		$this->db->limit($limit,$start);
		$query=$this->db->get_where("users",$where);
		$array=$query->result_array();
		return $array;
	}

	public function addallcommission($date=NULL){
		if($date===NULL){
			$date=date('Y-m-d');
		}
		
		$this->db->select('id');
		$where="id>1";
		$query=$this->db->get_where("users",$where);
		$array=$query->result_array();
		if(is_array($array)){
			foreach($array as $user){
				$this->addcommission($user['id'],$date);
			}
			// foreach($array as $user){
			// 	$this->generate_income($user['id'],$date);
			// }
		}
	}
	public function getwallet($regid,$type="ewallet"){
		$result=array();
		$where=array("regid"=>$regid);
		$this->db->select_sum('amount');
		$query=$this->db->get_where("wallet",$where);
		$wallet=$query->row()->amount;
		if($wallet==NULL){ $wallet=0; }
		$result['wallet']=$wallet;
		
		$bankwithdrawal=$wallettransfers=$walletreceived=$epingeneration=$cancelled=0;
		if($type=="ewallet"){
			$where2=array("regid"=>$regid,"status!="=>2);
			$this->db->select_sum('amount','amount');
			$query2=$this->db->get_where("withdrawals",$where2);
			$bankwithdrawal=$query2->row()->amount;
			if($bankwithdrawal==NULL){ $bankwithdrawal=0; }
			
			$where3=array("reg_from"=>$regid);
			$this->db->select_sum('amount');
			$query3=$this->db->get_where("wallet_transfers",$where3);
			$wallettransfers=$query3->row()->amount;
			if($wallettransfers==NULL){ $wallettransfers=0; }
			
			$where4=array("reg_to"=>$regid);
			$this->db->select_sum('amount');
			$query4=$this->db->get_where("wallet_transfers",$where4);
			$walletreceived=$query4->row()->amount;
			if($walletreceived==NULL){ $walletreceived=0; }
			
			$where5=array("regid"=>$regid,"type"=>"ewallet");
			$this->db->select_sum('amount');
			$query5=$this->db->get_where("epin_requests",$where5);
			$epingeneration=$query5->row()->amount;
			if($epingeneration==NULL){ $epingeneration=0; }
			
		}
		$result['bankwithdrawal']=$bankwithdrawal;
		$result['cancelled']=$cancelled;
		$result['wallettransfers']=$wallettransfers;
		$result['walletreceived']=$walletreceived;		
		$result['epingeneration']=$epingeneration;
		$result['actualwallet']=$wallet-$bankwithdrawal-$wallettransfers+$walletreceived+$cancelled-$epingeneration;
		$result['wallet']=$result['actualwallet']-(10*$result['actualwallet'])/100;
		return $result;
	}
	
	public function memberincome($where){
		$this->db->order_by("id");
		// echo PRE;
		// print_r($where);die;
		$array=$this->db->get_where("wallet",$where)->result_array();
		// return $this->db->last_query();
		return $array;
	}
	public function cashbackincomes($regid){
		$this->db->order_by("id");
		$array=$this->db->get_where("wallet",array("regid"=>$regid,"amount>"=>"0","remarks"=>"Monthly Income"))->result_array();
		return $array;
	}
	public function levelincomelist($regid){
		$this->db->order_by("id");
		$array=$this->db->get_where("wallet",array("regid"=>$regid,"amount>"=>"0","remarks"=>"Level Income"))->result_array();
		return $array;
	}
	public function instantreferalincome($regid){
		$this->db->order_by("id");
		$array=$this->db->get_where("wallet",array("regid"=>$regid,"amount>"=>"0","remarks"=>"Direct Sponsor Income"))->result_array();
		return $array;
	}
	public function directsponsor($where){
		$this->db->order_by("id");
		$array=$this->db->get_where("wallet",$where)->result_array();
		return $array;
	}
	public function carrewardincome($regid){
		$this->db->order_by("id");
		$array=$this->db->get_where("wallet",array("regid"=>$regid,"amount>"=>"0","remarks"=>"Car Reward"))->result_array();
		return $array;
	}

	public function levelin($where){
		$this->db->order_by("id");
		return $this->db->get_where("wallet",$where)->result_array();
		// return $this->db->last_query();
		//  $array;
	}
	public function carreward_income($where){
		$this->db->order_by("id");
		$array=$this->db->get_where("wallet",$where)->result_array();
		return $array;
	}

	public function current_month_business($where){
		$this->db->order_by("id");
		// $date = date('Y-m-d');
		// $month = date('m',strtotime($date));
		$array=$this->db->get_where("wallet",$where)->result_array();
		return $array;
	}

	public function direct_sponsor($regid){
		$this->db->order_by("id");
		$date = date('Y-m-d');
		$month = date('m',strtotime($date));
		$array=$this->db->get_where("wallet",array("regid"=>$regid,"amount>"=>"0","month(date)"=>$month,"remarks"=>"Direct Sponsor Income"))->result_array();
		return $array;
	}

	public function car_reward_report($regid){
		$this->db->order_by("id");
		$date = date('Y-m-d');
		$month = date('m',strtotime($date));
		$array=$this->db->get_where("wallet",array("regid"=>$regid,"amount>"=>"0","month(date)"=>$month,"remarks"=>"Car Reward"))->result_array();
		return $array;
	}
	public function transferamount($data){
		if($this->db->insert("wallet_transfers",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function gethistory($regid,$type="register",$wallet="ewallet"){
		if($type=="register"){
			$where=array("reg_from"=>$regid,"type_from"=>$wallet);
		}
		else{
			$where=array("reg_to"=>$regid,"type_to"=>$wallet);
		}
		$array=$this->db->get_where("wallet_transfers",$where)->result_array();
		if(is_array($array)){
			foreach($array as $key=>$value){
				$to=$this->db->get_where("users",array("id"=>$value['reg_to']))->row_array();
				$from=$this->db->get_where("users",array("id"=>$value['reg_from']))->row_array();
				$array[$key]['to_id']=$to["username"];
				$array[$key]['to_name']=$to["name"];
				$array[$key]['from_id']=$from["username"];
				$array[$key]['from_name']=$from["name"];
			}
		}
		return $array;
	}
	
	public function requestpayout($data){
		$regid=$data['regid'];
		$check=$this->db->get_where("withdrawals",array("regid"=>$regid,"status"=>"0"))->num_rows();
		if($check==0){
			if($this->db->insert("withdrawals",$data)){
				return true;
			}
			else{
				return $this->db->error();
			}
		}
		else{
			return array("message"=>"Previous Payout Request is Pending!");
		}
	}


	
	public function getmemberrequests($where){
		$this->db->where($where);
		$query=$this->db->get("withdrawals");
		$array=$query->result_array();
		return $array;
	}
	
	public function getwitdrawalrequest($where=array(),$type='all'){
		if(empty($where)){ $where['t1.status']=0; }
			$this->db->select("t1.*, t2.username,t2.name,t3.account_no,t3.ifsc");
			$this->db->from('withdrawals t1');
			$this->db->join('users t2','t1.regid=t2.id','Left');
			$this->db->join('acc_details t3','t1.regid=t3.regid','Left');
			$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function approvepayout($id){
		$date=date('Y-m-d');
		$updated_on=date('Y-m-d H:i:s');
		if($this->db->update("withdrawals",array("status"=>1,"approve_date"=>$date,"updated_on"=>$updated_on),array("id"=>$id))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function rejectpayout($id)
	{
		$updated_on=date('Y-m-d H:i:s');
		$data=array("status"=>2,"updated_on"=>$updated_on);
		if($this->session->role=='admin'){
			$data['approve_date']=date('Y-m-d');
		}
		if($this->db->update("withdrawals",$data,array("id"=>$id))){
			return true;
		}
		else{ 
			return $this->db->error();
		}
	}


	public function paymentreport($where=array(),$type='all'){
		$where['t1.status']=1;
		$columns="t1.approve_date,t2.username, t2.name,t3.account_no,t3.ifsc,amount,tds,admin_charge,t1.payable as paidamount";
		$this->db->select($columns);
		$this->db->from('withdrawals t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('acc_details t3','t1.regid=t3.regid','Left');
		$this->db->order_by("t1.approve_date");
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function approveallpayout($endtime){
		$where=array("t1.status"=>0,"t1.added_on<"=>$endtime);
		$members=$this->Wallet_model->getwitdrawalrequest($where);
		foreach($members as $member){
			$this->approvepayout($member['id']);
		}
	}
	
	public function dailypaymentreport(){
		$this->db->select("approve_date,sum(payable) as total_amount");
		$this->db->group_by("approve_date");
		$query=$this->db->get_where("withdrawals",array("status"=>1));
		$array=$query->result_array();
		return $array;
	}
	
	public function getmemberrewards(){
		$this->db->select("t2.username,t2.name,t1.*,t3.category");
		$this->db->from("member_rewards t1");
		$this->db->join("users t2","t1.regid=t2.id");
		$this->db->join("rewards t3","t1.reward_id=t3.id");
		$this->db->order_by("t1.status,t1.id");
		//$this->db->where(array("t1.status"=>"0"));
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
		
	
	public function approvereward($id){
		if($this->db->update("member_rewards",array("status"=>1,"approve_date"=>date('Y-m-d')),array("id"=>$id))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function getmembercommission(){
		$this->db->select("t1.regid,t2.username,t2.name,sum(t1.amount) as total");
		$this->db->from("wallet t1");
		$this->db->join("users t2","t1.regid=t2.id");
		$this->db->group_by("t1.regid");
		$array=$this->db->get()->result_array();
		if(is_array($array)){
			foreach($array as $key=>$member){
				$where2=array("regid"=>$member['regid'],"status!="=>2);
				$this->db->select_sum('amount','amount');
				$query2=$this->db->get_where("withdrawals",$where2);
				$bankwithdrawal=$query2->row()->amount;
				if($bankwithdrawal==NULL){ $bankwithdrawal=0; }
				$array[$key]['available']=$member['total']-$bankwithdrawal;
			}
		}
		return $array;
	}

	// ''''''''''''''''''''''''''''''''''PANKAJ MANI TIWARI''''''''''''''''''''''''''''''''''''''''
	public function cashbackdategenerate($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		
		$result=$commission=array();
		if($checkstatus){
			
			$active = $this->db->get_where('members',array('regid'=>$regid))->row('activation_date');
			
			$active = date('Y-m-d', strtotime('+1 month',strtotime($active)));
			if(date('Y-m-10') >= date('Y-m-d',strtotime($active))){
				$active = date('Y-m-10');
				
				$activation[] = $active;
			}
			elseif(date('Y-m-20') >= date('Y-m-d',strtotime($active)) && date('Y-m-10') < date('Y-m-d',strtotime($active))){
				$active = date('Y-m-20');
				$activation[] = $active;
			}
			elseif(date('Y-m-30') >= date('Y-m-d',strtotime($active)) && date('Y-m-20') < date('Y-m-d',strtotime($active))){
				$active = date('Y-m-30');
				$activation[] = $active;
			}
			for($i=0; $i < 24; $i++) { 

				$active = date('Y-m-d',strtotime("$active +1 month"));
				$activation[] = $active;

			}
			
			$activation = json_encode($activation,true);
		    if(!empty($activation)){
				$active = $this->db->get_where('cashback',array('regid'=>$regid))->num_rows();
				if($active==0){ 
					$data['regid'] = $regid;
					$data['total_date'] = $activation;
					$data['added_on'] = date('Y-m-d H:i:s');
					$aa = $this->db->insert("cashback",$data);
					$activation = (array)null;

				}
			}
		}
	}

	public function cashbackincome($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		// $date=date('Y-m-d',strtotime('-8 day'));
		
		$result=$commission=$amount=array();
		if($checkstatus){
			$amount[] = $this->get_amount($regid);
			$amount[] = $this->get_upgradeid_details($regid);
			$amount = array_sum($amount);
			$activedate = $this->db->get_where('cashback',array('regid'=>$regid))->row('total_date');
			
			// $date=date('Y-m-10');
			if(!empty($activedate)){
				 $activedate = json_decode($activedate);
				 
				 if(in_array($date, $activedate) && $amount>0){
					$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Monthly Income");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					
					if($checkvalue==0){
						$amount = $amount/10;
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Monthly Income","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				 } 
			}
		}
	}

	public function get_amount($regid){
		$this->db->where('t1.regid',$regid);
		$this->db->select('t2.amount');
		$this->db->from('members as t1');
		$this->db->join('packages as t2','t1.package_id = t2.id','left');
		return $this->db->get()->row('amount');
	}

	public function get_upgradeid_details($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); } 
		$checkstatus=$this->checkstatus($regid,$date);
		if($checkstatus){
			$this->db->select('t2.amount');
			$this->db->from('tmp_upgrade_ids as t1');
			$this->db->join('tmp_packages as t2','t1.package_id=t2.id','left');
			$this->db->where(array('t1.regid'=>$regid));
			return $this->db->get()->row('amount');
		}
	}

	public function instant_referal_income($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); } 
		$checkstatus=$this->checkstatus($regid,$date);
		$result=$commission=$first=$second=$third=array();
		if($checkstatus){
			$package = $this->db->get_where('members',array('refid'=>$regid,'status!='=>'0'))->result_array();
		
			$arr = array_column($package, 'package_id');
			$activationdate = array_column($package, 'activation_date');
			$register_id = array_column($package, 'regid');
			foreach ($activationdate as $key => $value) {
				$value = date('Y-m-d', strtotime('+1 month',strtotime($value)));
				if(date('Y-m-10')>=date('Y-m-d',strtotime($value))){
					$first['activate_date'][] = $value;
					$first['packageid'][] = $arr[$key];
					$first['register_id'][] = $register_id[$key];
				}elseif(date('Y-m-20')>=date('Y-m-d',strtotime($value)) && date('Y-m-10')<date('Y-m-d',strtotime($value))){
					$second['activate_date'][] = $value;
					$second['packageid'][] = $arr[$key];
					$second['register_id'][] = $register_id[$key];
				}elseif(date('Y-m-30')>=date('Y-m-d',strtotime($value)) && date('Y-m-20')<date('Y-m-d',strtotime($value))){
					$third['activate_date'][] = $value;
					$third['packageid'][] = $arr[$key];
					$third['register_id'][] = $register_id[$key];
				}
			}

			// $date = date('Y-m-10');
			if(date('Y-m-10')==date('Y-m-d',strtotime($date)) && !empty($first['activate_date'])){
				$arr1 = $first['packageid'];
				$amt1 = $first['register_id'];
				if(!empty($arr1)){
					foreach($arr1 as $key => $value) {
						$amt = $this->db->get_where('tmp_packages',array('id'=>$value,'status!='=>'0'))->row('amount');
						$amount[] = $amt;
						$amount[] =$this->get_upgradeid_details($amt1[$key]);
					}
					if(!empty($amount)){
						$total = array_sum($amount);
						$total = $total * 0.05;
						$wallet_list = $this->db->get_where('tmp_wallet',array('regid'=>$regid,'remarks'=>'Direct Sponsor Income'))->result_array();
						// echo PRE;
						// print_r($wallet_list);die;
					
						if(empty($wallet_list)){
							$paid = 0;
						}else{
							$wallet_list = $this->db->get_where('tmp_wallet',array('regid'=>$regid,'remarks'=>'Direct Sponsor Income'))->result_array();
							$paid_arr = array_column($wallet_list, 'amount');
							$paid = array_sum($paid_arr);
							$paid = $paid;
						}
						$amts = $total;
						if($amts>0){
							$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Direct Sponsor Income");
							$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
							$data=array("date"=>date('Y-m-10'),"type"=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Direct Sponsor Income","added_on"=>date('Y-m-d H:i:s'));
							if($checkvalue==0){
							   $this->db->insert("wallet",$data);
							}
						// 	else{
						// 		$this->db->update("wallet",$data,$where2);
						//    }	
							
						}
					}	
				}
			}
			if(date('Y-m-20')==date('Y-m-d',strtotime($date)) && !empty($second['activate_date'])){
				$arr2 = $second['packageid'];
				$amt2 = $second['register_id'];
				
				if(!empty($arr2)){
					foreach($arr2 as $key => $value) {
						$amt = $this->db->get_where('tmp_packages',array('id'=>$value,'status!='=>'0'))->row('amount');
						$amount[] = $amt;
						$amount[] =$this->get_upgradeid_details($amt2[$key]);
					}
					
					if(!empty($amount)){
						$total = array_sum($amount);
					
						$total = $total * 0.05;
						$wallet_list = $this->db->get_where('tmp_wallet',array('regid'=>$regid,'remarks'=>'Direct Sponsor Income'))->result_array();
						// echo PRE;
						// print_r($wallet_list);die;
				
						if(empty($wallet_list)){
							$paid = 0;
						}else{
							// $wallet_list = $this->db->get_where('tmp_wallet',array('regid'=>$regid,'remarks'=>'Direct Sponsor Income'))->result_array();
							$paid_arr = array_column($wallet_list, 'amount');
							$paid = array_sum($paid_arr);
							$paid = $paid;
						}
						
						$amts = $total-$paid;
				
						if($amts>0){
							$where=array("date"=>date('Y-m-20'),"regid"=>$regid,"remarks"=>"Direct Sponsor Income");
							$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
							$data=array("date"=>date('Y-m-20'),"type"=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Direct Sponsor Income","added_on"=>date('Y-m-d H:i:s'));
							
							if($checkvalue==0){
							   $this->db->insert("wallet",$data);
							}
						}
					}	
				}
			}
			if(date('Y-m-30')==date('Y-m-d',strtotime($date)) && !empty($third['activate_date'])){
				$arr3 = $third['packageid'];
				$amt3 = $third['register_id'];
				if(!empty($arr3)){
					foreach($arr3 as $key => $value) {
						$amt = $this->db->get_where('tmp_packages',array('id'=>$value,'status!='=>'0'))->row('amount');
						$amount[] = $amt;
						$amount[] =$this->get_upgradeid_details($amt3[$key]);
					}
					if(!empty($amount)){
						$total = array_sum($amount);
						$total = $total * 0.05;
						$wallet_list = $this->db->get_where('tmp_wallet',array('regid'=>$regid,'remarks'=>'Direct Sponsor Income'))->result_array();
						
						if(empty($wallet_list)){
							$paid = 0;
						}else{
							$wallet_list = $this->db->get_where('tmp_wallet',array('regid'=>$regid,'remarks'=>'Direct Sponsor Income'))->result_array();
							$paid_arr = array_column($wallet_list, 'amount');
							$paid = array_sum($paid_arr);
							$paid = $paid;
						}
						
						$amts = $total;
						if($amts>0){
							$where=array("date"=>date('Y-m-20'),"regid"=>$regid,"remarks"=>"Direct Sponsor Income");
							$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
							$data=array("date"=>date('Y-m-20'),"type"=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Direct Sponsor Income","added_on"=>date('Y-m-d H:i:s'));
							if($checkvalue==0){
							   $this->db->insert("wallet",$data);
							}else{
								$this->db->update("wallet",$data,$where2);
						   }
						}
					}	
				}
			}	
		}
	}

	public function levelincome_date_generate($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
	
		$result=$commission=array();
		if($checkstatus){
			$record = $this->Member_model->levelwisemembers($regid);
		
			foreach ($record as $key => $value) {
				if($value['level']==1){
					$lavel1[] =  $value['member_id'];
				}elseif($value['level']==2){
					$lavel2[] =  $value['member_id'];
				}
			}
			$check1 = $this->db->get_Where('tmp_leveldate',array('regid'=>$regid,'level'=>'1'))->num_rows();
			$activationdate  = array();
			if(!empty($lavel1[0]) && $check1==0){
				$first_id = $lavel1[0];
				$level_1date = $this->db->get_where('members',array('regid'=>$first_id))->row('activation_date');
				if(!empty($level_1date)){
					
					for ($i=1; $i < 24; $i++) { 
						$active = date('Y-m-d',strtotime("$level_1date +$i month"));
						$data['date'] = $active;
						$data['regid'] = $regid;
						$data['level'] = '1';
						$data['added_on'] = date('Y-m-d');
						$activationdate[] = $data;
					}
					
				}
			}
			$check2 = $this->db->get_Where('tmp_leveldate',array('regid'=>$regid,'level'=>'2'))->num_rows();
			if(!empty($lavel2[0]) && $check2==0){
				$second_id = $lavel2[0];
				$level_2date = $this->db->get_where('members',array('regid'=>$second_id))->row('activation_date');
				for ($j=1; $j < 24; $j++) { 
					$active = date('Y-m-d',strtotime("$level_2date +$j month"));
					$data['date'] = $active;
					$data['regid'] = $regid;
					$data['level'] = '2';
					$data['added_on'] = date('Y-m-d');
					$activationdate[] = $data;
				}
			}
			if(!empty($activationdate)){
				foreach ($activationdate as $key => $value) {
					$this->db->insert('tmp_leveldate',$value);
				}
			}
		}
	}

	public function level_income($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		$result=$commission=array();
		if($checkstatus){
			$record = $this->Member_model->levelwisemembers($regid);
		
			foreach ($record as $key => $value) {
				if($value['level']==1){
					$lavel1[] =  $value['amount'];
					$lavel1[] =$this->get_upgradeid_details($value['member_id']);
				}elseif($value['level']==2){
					$lavel2[] =  $value['amount'];
					$lavel2[] =$this->get_upgradeid_details($value['member_id']);
				}
			}
			if(!empty($lavel1)){
				$total = array_sum($lavel1);
				$amount =$total*0.02;
				if(($amount>0) && ((date('Y-m-10')==date('Y-m-d',strtotime($date))) || (date('Y-m-20')==date('Y-m-d',strtotime($date)))|| (date('Y-m-30')==date('Y-m-d',strtotime($date))))){
					
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"1st Level","added_on"=>date('Y-m-d H:i:s'));
						$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"1st Level");
						$checkfirst=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"1st Level","MONTH(date)"=>date('m'));
						$check=$this->db->get_where("wallet",$where2)->num_rows();
						$nocheck=$this->db->get_where("wallet",$checkfirst)->num_rows();
						
						if($check==0 && $nocheck<25){
							 $this->db->insert("wallet",$data);
						}
						// else{
						// 	 $this->db->update("wallet",$data,$where2);
						// }
				}
			}
			if(!empty($lavel2)){
				$total = array_sum($lavel2);
				$amount =$total*0.01;
				if(($amount>0) && ((date('Y-m-10')==date('Y-m-d',strtotime($date))) || (date('Y-m-20')==date('Y-m-d',strtotime($date)))|| (date('Y-m-30')==date('Y-m-d',strtotime($date))))){
					
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"2nd Level","added_on"=>date('Y-m-d H:i:s'));
						$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"2nd Level");
						$check=$this->db->get_where("wallet",$where2)->num_rows();
						$checksecond=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"2nd Level","MONTH(date)"=>date('m'));
						$nochecksec=$this->db->get_where("wallet",$checksecond)->num_rows();
						if($check==0 && $nochecksec<25){
							 $this->db->insert("wallet",$data);
						}
						else{
							 $this->db->update("wallet",$data,$where2);
						}
				}

			}
			// ''''''''Working Mood''''''''''
		}
	}

	

	public function trip_reward($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		
		$result=$commission=array();
		if($checkstatus){
			$direct_member = $this->db->get_where('members',array('refid'=>$regid,'status!='=>'0'))->result_array();
			$arr = array_column($direct_member, 'package_id');
		
			if(!empty($arr)){
				foreach($arr as $key => $value) {
					$amt = $this->db->get_where('tmp_packages',array('id'=>$value,'status!='=>'0'))->row('amount');
					$amount[] = $amt;
				}
			
				if(array_sum($amount)>=300000 && array_sum($amount)< 500000){
					$where=array("regid"=>$regid,"remarks"=>"Trip Reward","rank"=>"Goa Self");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
				
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>0,"remarks"=>"Trip Reward","rank"=>"Goa Self","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				elseif(array_sum($amount)>=500000 && array_sum($amount)< 1000000){
					$where=array("regid"=>$regid,"remarks"=>"Trip Reward","rank"=>"Thailand Self");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>0,"remarks"=>"Trip Reward","rank"=>"Thailand Self","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}elseif(array_sum($amount)>=1000000){
					$where=array("regid"=>$regid,"remarks"=>"Trip Reward","rank"=>"Dubai Self");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>0,"remarks"=>"Trip Reward","rank"=>"Dubai Self","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}	   
			}
		}
	}
	public function treeview(){
		
		checklogin();
		$data['datatable']=true;
		$data['title']="Downline Active Member List";
		$this->template->load('members','treeviewlist',$data);
	}
	public function car_reward($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		$result=$commission=array();
		if($checkstatus){
			$activation_date = $this->db->get_where('members',array('regid'=>$regid,'status!='=>'0'))->row('activation_date');
			$direct_member = $this->db->get_where('members',array('refid'=>$regid,'status!='=>'0'))->result_array();
			$arr = array_column($direct_member, 'package_id');
			
			if(!empty($arr)){
				foreach($arr as $key => $value) {
					$amt = $this->db->get_where('tmp_packages',array('id'=>$value,'status!='=>'0'))->row('amount');
					$amount[] = $amt;
					if($amt=='300000.00'){
						$lakh3[] = $amt;
					}else{
						$lakh3[] = 0;
					}
				}
				
				$total = array_sum($amount);
				$lakh12 = array_sum($lakh3);
				// echo PRE;
			    // print_r($total);
			  
				$days30 = date('Y-m-d',strtotime('+30 days ',strtotime($activation_date)));
				// print_r($date);
				// print_r($days30);die;
				if($total >= 1500000  && $total < 2500000 && $date<=$days30 && $lakh12>=1200000 && $lakh12 < 2400000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"15 Lakh");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>150000,"remarks"=>"Car Reward","rank"=>"15 Lakh","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				if($total >= 2500000 && $date<=$days30 && $lakh12>=2400000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"25 Lakh");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>250000,"remarks"=>"Car Reward","rank"=>"25 Lakh","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days45 = date('Y-m-d',strtotime('+45 days ',strtotime($activation_date)));
				if($total >= 5000000 && $date<=$days45 && $lakh12>=3600000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"50 Lakh");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>400000,"remarks"=>"Car Reward","rank"=>"50 Lakh","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days60 = date('Y-m-d',strtotime('+60 days ',strtotime($activation_date)));
				if($total >= 10000000 && $date<=$days60 && $lakh12>=4800000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"1 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>600000,"remarks"=>"Car Reward","rank"=>"1 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				if($total >= 20000000 && $date<=$days60 && $lakh12>=6000000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"2 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>1000000,"remarks"=>"Car Reward","rank"=>"2 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days70 = date('Y-m-d',strtotime('+70 days ',strtotime($activation_date)));
				if($total >= 30000000 && $date<=$days70 && $lakh12>=7200000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"3 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>1500000,"remarks"=>"Car Reward","rank"=>"3 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days80 = date('Y-m-d',strtotime('+80 days ',strtotime($activation_date)));
				if($total >= 40000000 && $date<=$days80 && $lakh12>=8400000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"4 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>2000000,"remarks"=>"Car Reward","rank"=>"4 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days100 = date('Y-m-d',strtotime('+100 days ',strtotime($activation_date)));
				if($total >= 50000000 && $date<=$days100 && $lakh12>=9600000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"5 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>2500000,"remarks"=>"Car Reward","rank"=>"5 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days120 = date('Y-m-d',strtotime('+120 days ',strtotime($activation_date)));
				if($total >= 70000000 && $date<=$days120 && $lakh12>=10800000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"7 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>3000000,"remarks"=>"Car Reward","rank"=>"7 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days150 = date('Y-m-d',strtotime('+150 days ',strtotime($activation_date)));
				if($total >= 80000000 && $date<=$days150 && $lakh12>=12000000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"8 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>4000000,"remarks"=>"Car Reward","rank"=>"8 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days150 = date('Y-m-d',strtotime('+150 days ',strtotime($activation_date)));
				if($total >= 90000000 && $date<=$days150 && $lakh12>=13200000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"8 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>4000000,"remarks"=>"Car Reward","rank"=>"8 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}
				$days180 = date('Y-m-d',strtotime('+180 days ',strtotime($activation_date)));
				if($total >= 90000000 && $date<=$days180 && $lakh12>=14400000){
					$where=array("regid"=>$regid,"remarks"=>"Car Reward","rank"=>"9 Cr.");
					$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
					if($checkvalue==0){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>5000000,"remarks"=>"Car Reward","rank"=>"9 Cr.","added_on"=>date('Y-m-d H:i:s'));
						$this->db->insert("wallet",$data);
					}
				}

			}	
			
		}
	}

	





	// '''''''working area end''''''''

	// public function working_income($regid,$date=NULL){
    //     if($date==NULL){ $date=date('Y-m-d'); }
	// 	$checkstatus=$this->checkstatus($regid,$date);
	
	// 	$result=$commission=array();
	// 	if($checkstatus){
	// 		$members=$this->Member_model->getactivedirectmembers($regid);
			
	// 		$activationdate = $this->db->get_where('members',array('regid'=>$regid))->row('activation_date');
	// 		$effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($activationdate)));
	// 		echo PRE;

	// 		print_r($activationdate);
	// 		print_r($effectiveDate);die;
	// 		if($date<$effectiveDate){
	// 			if(count($members)>=10 && count($members)<20){
	// 				$where=array("regid"=>$regid,"remarks"=>"Working Income","rank"=>"First Working Income");
	// 				$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
	// 				if($checkvalue==0){
	// 					$amount = 1000;
	// 					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"rank"=>"First Working Income","remarks"=>"Working Income","added_on"=>date('Y-m-d H:i:s'));
	// 					$this->db->insert("wallet",$data);
	// 				}
	// 			}elseif(count($members)>=20 && count($members)<30){
	// 				$where=array("regid"=>$regid,"remarks"=>"Working Income","rank"=>"Second Working Income");
	// 				$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
	// 				if($checkvalue==0){
	// 					$amount = 2200;
	// 					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"rank"=>"Second Working Income","remarks"=>"Working Income","added_on"=>date('Y-m-d H:i:s'));
	// 					$this->db->insert("wallet",$data);
	// 				}
	// 			}elseif(count($members)>=30 && count($members)<40){
	// 				$where=array("regid"=>$regid,"remarks"=>"Working Income","rank"=>"Third Working Income");
	// 				$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
	// 				if($checkvalue==0){
	// 					$amount = 3300;
	// 					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"rank"=>"Third Working Income","remarks"=>"Working Income","added_on"=>date('Y-m-d H:i:s'));
	// 					$this->db->insert("wallet",$data);
	// 				}
	// 			}elseif(count($members)>=40 && count($members)<50){
	// 				$where=array("regid"=>$regid,"remarks"=>"Working Income","rank"=>"Forth Working Income");
	// 				$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
	// 				if($checkvalue==0){
	// 					$amount = 4400;
	// 					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"rank"=>"Forth Working Income","remarks"=>"Working Income","added_on"=>date('Y-m-d H:i:s'));
	// 					$this->db->insert("wallet",$data);
	// 				}
	// 			}elseif(count($members)>=50){
	// 				$where=array("regid"=>$regid,"remarks"=>"Working Income","rank"=>"Fifth Working Income");
	// 				$checkvalue=$this->db->get_where("wallet",$where)->num_rows();
	// 				if($checkvalue==0){
	// 					$amount = 5500;
	// 					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"rank"=>"Fifth Working Income","remarks"=>"Working Income","added_on"=>date('Y-m-d H:i:s'));
	// 					$this->db->insert("wallet",$data);
	// 				}
	// 			}
	// 		}
	// 	}
	// }
// ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

	public function matchingincome($regid,$date=NULL)
	{

        if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		
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
				// echo PRE;
		        // print_r($right);die;	
				
				// ''''''left iv'''''''''
				
				$leftcount=count($left);
				$rightcount=count($right);
				
				$total_amount=0;
				
				if($leftcount==$rightcount){
					$pairs=$leftcount-1;
				}

				elseif($leftcount<$rightcount){ $pairs=$leftcount; }
				else{ $pairs=$rightcount; }
				if($pairs>0){
					$this->db->select("sum(pair) as pairs,sum(amount) as total_amount, sum(iv_match) as addiv");
					$where=array("regid"=>$regid,"remarks"=>"Leadership Bonus");
					$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

					$addedpairs=$added['pairs'];	
					if($addedpairs===NULL){ $addedpairs=0; }
					$addedamount=$added['total_amount'];
					if($addedamount===NULL){ $addedamount=0; }
					$addediv=$added['addiv'];
					if($addediv===NULL){ $addediv=0; }
					$pairs=$pairs-$addedpairs;

					$leftiv=array_column($left,'iv');
					$leftiv=array_sum($leftiv);
					$rightiv=array_column($right,'iv');
					$rightiv=array_sum($rightiv);
					$nr=$this->db->get_where('power_id',array('regid'=>$regid,'status'=>1))->num_rows();
					if($nr>0){
						$d=$this->db->get_where('power_id',array('regid'=>$regid))->row_array();
						if($d['position']=='Left'){
							$leftiv+=$d['iv'];
						}else{
							$rightiv+=$d['iv'];
						}
					}
					  if($leftiv>$rightiv){
					  	$commoniv = $rightiv;	
					  }else{
					  	$commoniv = $leftiv;
					  }
					  $commoniv = $commoniv-$addediv;
					  if($commoniv>0){
					  	$value = $commoniv / 0.5;
					  	$amount = $value * 250;
					  }
					if(!empty($amount)&&($amount>0)){
						$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"pair"=>$pairs,"amount"=>$amount,"iv_match"=>$commoniv,"remarks"=>"Leadership Bonus","added_on"=>date('Y-m-d H:i:s'));
						$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Leadership Bonus");
						$check=$this->db->get_where("wallet",$where2)->num_rows();
						if($check==0){
							 $this->db->insert("wallet",$data);
						}
						else{
							 $this->db->update("wallet",$data,$where2);
						}
					}
					
				}
			}
        
    }
     // '''''''''''''''''''''''''''''''Direct Responser'''''''''''''''''''''''''''''''''''''''''''''

	public function directsponsor0($regid,$date=NULL){
		if($date===NULL){
			$date=date('Y-m-d');
		}
		$checkstatus=$this->checkstatus($regid,$date);
		if($checkstatus){
			$members=$this->Member_model->gettodaydirectmembers($regid,$date);
			$packageamount=array_column($members,'package_amount');
			$packageamount=array_sum($packageamount);
			$amount=$packageamount * 0.1;
			if($amount>0){
				$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Direct Sale Bonus","added_on"=>date('Y-m-d H:i:s'));
				$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Direct Sale Bonus");
				$check=$this->db->get_where("wallet",$where)->num_rows();
					if($check == 0){
				$this->db->insert("wallet",$data);
				}else{
					 $this->db->update("wallet",$data,$where);
				}
			}
		}
	}

 // '''''''''''''''''''''''''''''''Reward Responser'''''''''''''''''''''''''''''''''''''''''''''
	public function rewardbonus($regid,$date=NULL)
	{
        if($date==NULL)
        { 
        	$date=date('Y-m-d'); 
        }
		$checkstatus=$this->checkstatus($regid,$date);
		$result=$commission=array();
		if($checkstatus)
		{	
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
					$where="t1.status='1' and t1.activation_date<='$date' and t1.refid='$regid'";
					$this->db->where($where);
					$leftdirect=$this->db->get()->num_rows();

				}
				if($leftdirect==0){
					return false;
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

				if($rightdirect==0){
					return false;
				}
				
				if(!empty($leftmembers)){
					$this->db->select("t1.regid,t2.amount,t2.iv,t1.activation_date");
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
					$this->db->select("t1.regid,t2.amount,t2.iv,t1.activation_date");
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

				$leftcount=count($left);
				$rightcount=count($right);
				$activation_date = date('Y-m-d',strtotime($left[$leftcount-1]['activation_date']));
				$leftiv=array_column($left,'iv');
				$leftiv=array_sum($leftiv);
				$rightiv=array_column($right,'iv');
				$rightiv=array_sum($rightiv);
					// ''''''''''''''''''''''''''''''''''''''''''''''''550 Days Plan 180days'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
			if(($leftiv>=550) && ($rightiv>=550)){
				  $diffdate = date('Y-m-d', strtotime("-120 days"));
					if($activation_date>$diffdate){
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward Bonus in 180 days package");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 64000;

							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward Bonus in 180 days package","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward Bonus in 180 days package");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						}

						
					}else{
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward Bonus in 180 days package");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 32000;
							if(($amount>0)){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward Bonus in 180 days package","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward Bonus in 180 days package");
								$check=$this->db->get_where("wallet",$where2)->num_rows();
								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						}
					}
			}

			elseif(($leftiv>=250 && $leftiv<550) && ($rightiv>=250 && $rightiv<550)){
				$diffdate = date('Y-m-d', strtotime("-120 days"));
					if($activation_date>$diffdate){
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward Bonus in 120 days package");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 32000;

							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward Bonus in 120 days package","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward Bonus in 120 days package");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
					}else{
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward Bonus in 120 days package");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 16000;
							if(($amount>0)){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward Bonus in 120 days package","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward Bonus in 120 days package");
								$check=$this->db->get_where("wallet",$where2)->num_rows();
								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						}
					}
			}

			elseif(($leftiv>=110 && $leftiv<250) && ($rightiv>=110 && $rightiv<250)){
				$diffdate = date('Y-m-d', strtotime("-60 days"));
					if($activation_date>$diffdate){
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward Bonus in 60 days package");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 16000;

							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward Bonus in 60 days package","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward Bonus in 60 days package");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 

						
					}else{
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward Bonus in 60 days package");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 8000;
							if(($amount>0)){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward Bonus in 60 days package","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward Bonus in 60 days package");
								$check=$this->db->get_where("wallet",$where2)->num_rows();
								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						}
					}
			}

			elseif($leftiv>=50 && $rightiv>=50 ) {
				$diffdate = date('Y-m-d', strtotime("-90 days"));
					if($activation_date>$diffdate){
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward 90days Bonus");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 8000;

							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward 90days Bonus","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward 90days Bonus");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 

						
					}else{
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward 90days Bonus");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 4000;
							if(($amount>0)){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward 90days Bonus","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward 90days Bonus");
								$check=$this->db->get_where("wallet",$where2)->num_rows();
								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						}
					}
			}
			elseif(($leftiv>=22 && $leftiv<50) && ($rightiv>=22 && $rightiv<50)) {
				$diffdate = date('Y-m-d', strtotime("-60 days"));
					if($activation_date>$diffdate){
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward 60days Bonus");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){
							$amount = 4000;

							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward 60days Bonus","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward 60days Bonus");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 

						
					}else{
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward 60days Bonus");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){
							$amount = 2000;
							if(($amount>0)){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward 60days Bonus","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward 60days Bonus");
								$check=$this->db->get_where("wallet",$where2)->num_rows();
								if($check==0){
								     $this->db->insert("wallet",$data);
								}
								else{
									$this->db->update("wallet",$data,$where2);
								}
							}
						}
					}
			}

			elseif(($leftiv>=10 && $leftiv<22) && ($rightiv>=10 && $rightiv<22)){
					$diffdate = date('Y-m-d', strtotime("-30 days"));
					if($activation_date>$diffdate){
						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward 30days  ");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 2000;

							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward 30days Bonus","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward 30days Bonus");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									$this->db->insert("wallet",$data);
								}
								else{
									$this->db->update("wallet",$data,$where2);
								}
							}
						}
					}else{

						$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Reward 30days Bonus");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');

						if(empty($added['total_amount'])){
							$amount = 1000;
						
							if(($amount>0)){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Reward 30days Bonus","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Reward 30days Bonus");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						}
					}
			}	
	    }
    }


    public function  repurchaseplan($regid,$date=NULL){
    	if($date===NULL){
			$date=date('Y-m-d');
		}
		if(date('l')=='Wednesday'){
		$currentdate= date('Y-m-d');
       	$lastdate = date("Y-m-d", strtotime ('-7 days',strtotime ($currentdate)));
		$checkstatus=$this->checkstatus($regid,$date);
			

		if($checkstatus)
		{
			$currentdate= date('Y-m-d');
       		$lastdate = date("Y-m-d", strtotime ('-10 days',strtotime ($currentdate)));
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
				$this->db->where(array('added_on>='=>$lastdate,'added_on<='=>$currentdate,'approve_status'=>1));
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
				$this->db->where(array('added_on>='=>$lastdate,'added_on<='=>$currentdate,'approve_status'=>1));
				$this->db->group_end();
				$this->db->from("tmp_purchase t1");
				$rightdirect=$this->db->get()->result_array();
			}
			$leftbv=array_column($leftdirect,'bv');
			$leftbv=array_sum($leftbv);
			$rightbv=array_column($rightdirect,'bv');
			$rightbv=array_sum($rightbv);
			
			$nr=$this->db->get_where('tmp_powerid_bv',array('regid'=>$regid,'status'=>1))->num_rows();
					if($nr>0){
						$d=$this->db->get_where('tmp_powerid_bv',array('regid'=>$regid))->row_array();
						if($d['position']=='Left'){
							$leftbv+=$d['bv'];
						}else{
							$rightbv+=$d['bv'];
						}
					}
				$leftprice=array_column($leftdirect,'price');
				$leftprice=array_sum($leftprice);
				$rightprice=array_column($rightdirect,'price');
				$rightprice=array_sum($rightprice);
				$total['leftamount'] = $leftprice;
				$total['rightamount'] = $rightprice;
				$total=array_sum($total);
			if(($leftbv>=1000 && $leftbv<2500) && ($rightbv>=1000 && $rightbv<2500)){

				$this->db->select("sum(amount) as total_amount");
					$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level One");
					$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
					if(empty($added['total_amount'])){

						$amount = ($total*13)/100;
						if($amount>0){
							$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level One","added_on"=>date('Y-m-d H:i:s'));
							$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level One");
							$check=$this->db->get_where("wallet",$where2)->num_rows();

							if($check==0){
								$this->db->insert("wallet",$data);
							}
							else{
								$this->db->update("wallet",$data,$where2);
							}
						}
					} 	
			}
			elseif (($leftbv>=2500 && $leftbv<5000) && ($rightbv>=2500 && $rightbv<5000)) {
				$this->db->select("sum(amount) as total_amount");
					$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Two");
					$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
					if(empty($added['total_amount'])){

						$amount = ($total*15)/100;
						if($amount>0){
							$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Two","added_on"=>date('Y-m-d H:i:s'));
							$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Two");
							$check=$this->db->get_where("wallet",$where2)->num_rows();

							if($check==0){
								 $this->db->insert("wallet",$data);
							}
							else{
								 $this->db->update("wallet",$data,$where2);
							}
						}
					} 
					
			}
			elseif (($leftbv>=5000 && $leftbv<10000) && ($rightbv>=5000 && $rightbv<10000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Three");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*17)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Three","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Three");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=10000 && $leftbv<20000) && ($rightbv>=10000 && $rightbv<20000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Forth");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*19)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Forth","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Forth");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=20000 && $leftbv<50000) && ($rightbv>=20000 && $rightbv<50000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Fifth");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*20)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Fifth","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Fifth");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=50000 && $leftbv<110000) && ($rightbv>=50000 && $rightbv<110000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Sixth");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*21)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Sixth","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Sixth");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=110000 && $leftbv<175000) && ($rightbv>=110000 && $rightbv<175000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Seventh");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*22)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Seventh","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Seventh");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=175000 && $leftbv<325000) && ($rightbv>=175000 && $rightbv<325000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Eighth");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*22)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Eighth","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Eighth");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=325000 && $leftbv<525000) && ($rightbv>=325000 && $rightbv<525000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Ninth");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*22)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Ninth","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Ninth");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=525000 && $leftbv<1050000) && ($rightbv>=525000 && $rightbv<1050000)) {
				$this->db->select("sum(amount) as total_amount");
						$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Tenth");
						$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
						if(empty($added['total_amount'])){

							$amount = ($total*25)/100;
							if($amount>0){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Tenth","added_on"=>date('Y-m-d H:i:s'));
								$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Tenth");
								$check=$this->db->get_where("wallet",$where2)->num_rows();

								if($check==0){
									 $this->db->insert("wallet",$data);
								}
								else{
									 $this->db->update("wallet",$data,$where2);
								}
							}
						} 
						
			}
			elseif (($leftbv>=1050000) && ($rightbv>=1050000)){
				$this->db->select("sum(amount) as total_amount");
					$where=array("regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Eleventh");
					$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
					if(empty($added['total_amount'])){

						$amount = ($total*25)/100;
						if($amount>0){
							$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Repurchase Plan For Complete Level Eleventh","added_on"=>date('Y-m-d H:i:s'));
							$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Repurchase Plan For Complete Level Eleventh");
							$check=$this->db->get_where("wallet",$where2)->num_rows();

							if($check==0){
								 $this->db->insert("wallet",$data);
							}
							else{
								 $this->db->update("wallet",$data,$where2);
							}
						}
					} 
					
			}
	}
	}

	}

// .................Travel Bonus''''''''''''''''''''''''''''
    public function check_tour_bonus($regid,$date=NULL){
    	if($date===NULL){
    		$date=date('Y-m-d');
    	}

    	if(date('j')==1){
    	$check=$this->checkstatus($regid, $date);
    	if($check){
    		$allmembers=$this->Member_model->getleftrightmembers($regid);
    		$leftmembers=$allmembers['left'];
    		$rightmembers=$allmembers['right'];
    		if(empty($leftmembers) || empty($rightmembers)){
    			return false;
    		} 

    		$leftbvs=$rightbvs=0;
    		foreach($leftmembers as $l){
    			$rec = $this->monthly_purchase_bv($l['regid'], $date);
    			$leftbvs+=$rec['total_bv'];
    		
    		}

    		foreach($rightmembers as $r){
    			$rec = $this->monthly_purchase_bv($r['regid'], $date);
    			

    			$rightbvs+=$rec['total_bv'];
    		}
    		
    		
    		if($leftbvs >= 40000 && $rightbvs >= 40000){
    			$matchbv=0;
    			if($leftbvs==$rightbvs){
    				$matchbv=$leftbvs;
    			}elseif($leftbvs > $rightbvs){
    				$matchbv=$rightbvs;
    			}else{
    				$matchbv=$leftbvs;
    			}
    			if($matchbv >= 40000){
    				$res['regid']=$regid;
    				$res['totalbv']=$matchbv;
    				$res['date']=date('Y-m-d');
    				$res['added_on']=date('Y-m-d H:i:s');
    				return $this->db->insert('tmp_travel_bonus_members',$res);
    			}
    		}
    	}
    	}
    }


    public function monthly_purchase_bv($regid,$date){
    	$s_date=date('Y-m-01',strtotime('-1 month',strtotime($date)));
    	$e_date=date('Y-m-t',strtotime('-1 month',strtotime($date)));
    	$where=array('member_id'=>$regid,'added_on>='=>$s_date,'added_on<='=>$e_date);
    	$this->db->select("sum(bv) as total_bv,member_id");
    	$added=$this->db->get_where("purchase",$where)->unbuffered_row('array');
    	 return $added;
    }

    public function tour_bonus_distribution($date=NULL){
    	if($date===NULL){
    		$date=date('Y-m-d');
    	}
    	if(date('j')==1){
	    	$where=array('date'=>$date);
	    	$this->db->select('*');
	    	$this->db->from('tmp_travel_bonus_members');
	    	$this->db->where($where);
	    	$query=$this->db->get();
	    	$arr=$query->result_array();
	    	$where=array('date'=>$date);
	    	$this->db->select_sum('totalbv');
	    	$this->db->from('tmp_travel_bonus_members');
	    	$this->db->where($where);
	    	$query1=$this->db->get();
	    	$arr1=$query1->row_array();
	    	$total = $this->total_turnover();
	    	if($arr1 !== NULL){
	    		$cto=($total['bv'] * 0.02)/$arr1['totalbv'];
		    	foreach($arr as $ar){
		    		$amount=$cto*$ar['totalbv'];
		    		if($amount>0){
		    			$regid = $ar['regid'];
		    			$this->db->select("sum(amount) as total_amount");
							$where=array("regid"=>$regid,"remarks"=>"Travel Bonus","date"=>$date);
							$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
							if(empty($added['total_amount'])){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Travel Bonus","added_on"=>date('Y-m-d H:i:s'));
									$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Travel Bonus");
									$check=$this->db->get_where("wallet",$where2)->num_rows();

									if($check==0){
										return $this->db->insert("wallet",$data);
									}
									else{
										return $this->db->update("wallet",$data,$where2);
									}
							} 
							else{
								return false;
						}
		    	}
		    }
	    }
    	}
    }

    public function total_turnover($date=NULL){
    	if($date===NULL){
    		$date=date('Y-m-d');
    	}
    	$s_date=date('Y-m-01',strtotime('-1 month',strtotime($date)));
    	$e_date=date('Y-m-t',strtotime('-1 month',strtotime($date)));
    	$where=array('added_on>='=>$s_date,'added_on<='=>$e_date);
    	$this->db->select_sum('bv');
    	$this->db->from('tmp_purchase');
    	$this->db->where($where);
    	$query1=$this->db->get();
    	return $query1->row_array();
    }
		   

    // '''''''''''''''''''''''''''''''''''''Car Bonus'''''''''''''''''''''''''''''''''''''''''''''''''''''

    public function check_car_bonus($regid,$date=NULL){
    	if($date===NULL){
    		$date=date('Y-m-d');
    	}
    	if(date('j')==1){
    	$check=$this->checkstatus($regid, $date);
    	
    	if($check){
    		$allmembers=$this->Member_model->getleftrightmembers($regid);
    		$leftmembers=$allmembers['left'];
    		$rightmembers=$allmembers['right'];
    		if(empty($leftmembers) || empty($rightmembers)){
    			return false;
    		} 
    		$leftbvs=$rightbvs=0;
    		foreach($leftmembers as $l){
    			$rec = $this->monthly_purchase_bv($l['regid'], $date);
    			$leftbvs+=$rec['total_bv'];
    		
    		}
    		foreach($rightmembers as $r){
    			$rec = $this->monthly_purchase_bv($r['regid'], $date);
    			

    			$rightbvs+=$rec['total_bv'];
    		}

    		if($leftbvs >= 60000 && $rightbvs >= 60000){
    			$matchbv=0;
    			if($leftbvs==$rightbvs){
    				$matchbv=$leftbvs;
    			}elseif($leftbvs > $rightbvs){
    				$matchbv=$rightbvs;
    			}else{
    				$matchbv=$leftbvs;
    			}
    			if($matchbv >= 60000){

    				$res['regid']=$regid;
    				$res['totalbv']=$matchbv;
    				$res['date']=date('Y-m-d');
    				$res['added_on']=date('Y-m-d H:i:s');
    				$data['added_on'] = date('Y-m-d');
    				$check = $this->db->get_where('tmp_car_bonus_members',array('regid'=>$regid,'date'=>$date))->num_rows();
    				if($check==0){
    					$this->db->insert('tmp_car_bonus_members',$res);
    				}
    				// insert (regid,matchbv,date,addexd_on)
    			}
    		}
    	}
    	}
    }

    public function car_bonus_distribution($date=NULL){
    	if($date==NULL){
    		$date=date('Y-m-d');
    	}
    	if(date('j')==1){
	    	$where=array('date'=>$date);
	    	$this->db->select('*');
	    	$this->db->from('tmp_car_bonus_members');
	    	$this->db->where($where);
	    	$query=$this->db->get();
	    	$arr=$query->result_array();
	    	$where=array('date'=>$date);
	    	$this->db->select_sum('totalbv');
	    	$this->db->from('tmp_car_bonus_members');
	    	$this->db->where($where);
	    	$query1=$this->db->get();
	    	$arr1=$query1->row_array();
	    	
	    	$total = $this->total_turnover();
	    	if($arr1 !== NULL){
	    		$cto=($total['bv'] * 0.03)/$arr1['totalbv'];
		    	foreach($arr as $ar){
		    		$amount=$cto*$ar['totalbv'];
		    		if($amount>0){
		    			$regid = $ar['regid'];
		    			$this->db->select("sum(amount) as total_amount");
							$where=array("regid"=>$regid,"remarks"=>"Car Bonus","date"=>$date);
							$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
							if(empty($added['total_amount'])){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Car Bonus","added_on"=>date('Y-m-d H:i:s'));
									$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Car Bonus");
									$check=$this->db->get_where("wallet",$where2)->num_rows();

									if($check==0){
										return $this->db->insert("wallet",$data);
									}
									else{
										return $this->db->update("wallet",$data,$where2);
									}
							} 
							else{
								return false;
							}
		    		}
		    	}
	    	}

    	}
    }

   

    // '''''''''''''''''''''''''''''''''''''House Bonus'''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function check_house_bonus($regid,$date=NULL){
    	if($date===NULL){
    		$date=date('Y-m-d');
    	}
    	if(date('j')==1){	
    	$check=$this->checkstatus($regid, $date);
    	if($check){
    		$allmembers=$this->Member_model->getleftrightmembers($regid);
    		$leftmembers=$allmembers['left'];
    		$rightmembers=$allmembers['right'];
    		if(empty($leftmembers) || empty($rightmembers)){
    			return false;
    		} 
    		$leftbvs=$rightbvs=0;
    		foreach($leftmembers as $l){
    			$rec = $this->monthly_purchase_bv($l['regid'], $date);
    			$leftbvs+=$rec['total_bv'];
    		
    		}
    		foreach($rightmembers as $r){
    			$rec = $this->monthly_purchase_bv($r['regid'], $date);
    			$rightbvs+=$rec['total_bv'];
    		}

    		

    		if($leftbvs >= 120000 && $rightbvs >= 120000){
    			$matchbv=0;
    			if($leftbvs==$rightbvs){
    				$matchbv=$leftbvs;
    			}elseif($leftbvs > $rightbvs){
    				$matchbv=$rightbvs;
    			}else{
    				$matchbv=$leftbvs;
    			}

    			if($matchbv >= 120000){
    				$res['regid']=$regid;
    				$res['totalbv']=$matchbv;
    				$res['date']=date('Y-m-d');
    				$res['added_on']=date('Y-m-d H:i:s');
    				$data['added_on'] = date('Y-m-d');
    				$check = $this->db->get_where('tmp_house_bonus_members',array('regid'=>$regid,'date'=>$date))->num_rows();
    				if($check==0){
    					$this->db->insert('tmp_house_bonus_members',$res);
    				}
    				// insert (regid,matchbv,date,addexd_on)
    			}
    		}
    	}
    	}
    }

    public function house_bonus_distribution($date=NULL){
    	if($date===NULL){
    		$date=date('Y-m-d');
    	}
    	if(date('j')==1){
	    	$where=array('date'=>$date);
	    	$this->db->select('*');
	    	$this->db->from('tmp_house_bonus_members');
	    	$this->db->where($where);
	    	$query=$this->db->get();
	    	$arr=$query->result_array();
	    	$where=array('date'=>$date);
	    	$this->db->select_sum('totalbv');
	    	$this->db->from('tmp_house_bonus_members');
	    	$this->db->where($where);
	    	$query1=$this->db->get();
	    	$arr1=$query1->row_array();
	    	$total = $this->total_turnover();
	    	if($arr1 !== NULL){
	    		$cto=($total['bv'] * 0.03)/$arr1['totalbv'];
		    	foreach($arr as $ar){
		    		$amount=$cto*$ar['totalbv'];
		    		if($amount>0){
		    			$regid = $ar['regid'];
		    			$this->db->select("sum(amount) as total_amount");
							$where=array("regid"=>$regid,"remarks"=>"House Bonus","date"=>$date);
							$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
							if(empty($added['total_amount'])){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"House Bonus","added_on"=>date('Y-m-d H:i:s'));
									$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"House Bonus");
									$check=$this->db->get_where("wallet",$where2)->num_rows();

									if($check==0){
										return $this->db->insert("wallet",$data);
									}
									else{
										return $this->db->update("wallet",$data,$where2);
									}
							} 
							else{
								return false;
							}
		    		}
		    	}
	    	}

    	}
    }
    // '''''''''''''''''''''''''''''''''''''Luxury Bonus'''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function check_luxury_bonus($regid,$date=NULL){
    	if($date===NULL){
    		$date=date('Y-m-d');
    	}

    	if(date('j')==1){
    	$check=$this->checkstatus($regid, $date);
    	
    	if($check){
    		$allmembers=$this->Member_model->getleftrightmembers($regid);
    		$leftmembers=$allmembers['left'];
    		$rightmembers=$allmembers['right'];
    		if(empty($leftmembers) || empty($rightmembers)){
    			return false;
    		} 
    		$leftbvs=$rightbvs=0;
    		foreach($leftmembers as $l){
    			$rec = $this->monthly_purchase_bv($l['regid'], $date);
    			$leftbvs+=$rec['total_bv'];
    		}

    		foreach($rightmembers as $r){
    			$rec = $this->monthly_purchase_bv($r['regid'], $date);
    			$rightbvs+=$rec['total_bv'];
    		}


    		if($leftbvs >= 525000 && $rightbvs >= 525000){
    			$matchbv=0;
    			if($leftbvs==$rightbvs){
    				$matchbv=$leftbvs;
    			}elseif($leftbvs > $rightbvs){
    				$matchbv=$rightbvs;
    			}else{
    				$matchbv=$leftbvs;
    			}

    			if($matchbv >= 525000){
    				$res['regid']=$regid;
    				$res['totalbv']=$matchbv;
    				$res['date']=date('Y-m-d');
    				$res['added_on']=date('Y-m-d H:i:s');
    				$data['added_on'] = date('Y-m-d');
    				$check = $this->db->get_where('tmp_luxury_bonus_members',array('regid'=>$regid,'date'=>$date))->num_rows();
    				if($check==0){
    					$this->db->insert('tmp_luxury_bonus_members',$res);
    				}
    				// insert (regid,matchbv,date,addexd_on)
    			}
    		}
    	}
    	}
    }

    public function luxury_bonus_distribution($date=NULL){
	    	if($date===NULL){
	    		$date=date('Y-m-d');
	    	}
	    	if(date('j')==1){
	    	$where=array('date'=>$date);
	    	$this->db->select('*');
	    	$this->db->from('tmp_luxury_bonus_members');
	    	$this->db->where($where);
	    	$query=$this->db->get();
	    	$arr=$query->result_array();
	    	$where=array('date'=>$date);
	    	$this->db->select_sum('totalbv');
	    	$this->db->from('tmp_luxury_bonus_members');
	    	$this->db->where($where);
	    	$query1=$this->db->get();
	    	$arr1=$query1->row_array();

	    	$total = $this->total_turnover();
	    	if($arr1 !== NULL){
	    		$cto=($total['bv'] * 0.04)/$arr1['totalbv'];
		    	foreach($arr as $ar){
		    		$amount=$cto*$ar['totalbv'];
		
		    		if($amount>0){
		    			$regid = $ar['regid'];
		    			$this->db->select("sum(amount) as total_amount");
							$where=array("regid"=>$regid,"remarks"=>"Luxury Bonus","date"=>$date);
							$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
							if(empty($added['total_amount'])){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Luxury Bonus","added_on"=>date('Y-m-d H:i:s'));
									$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Luxury Bonus");
									$check=$this->db->get_where("wallet",$where2)->num_rows();

									if($check==0){
										return $this->db->insert("wallet",$data);
									}
									else{
										return $this->db->update("wallet",$data,$where2);
									}
							} 
							else{
								return false;
							}
		    		}
		    	}
	    	}
	    	}
   		}

   		  // '''''''''''''''''''''''''''''''''''''I Mark Bonus'''''''''''''''''''''''''''''''''''''''''''''''''''''

   		public function check_imark_bonus($regid,$date=NULL){
	    	if($date===NULL){
	    		$date=date('Y-m-d');
	    	}
	    	if(date('j')==1){
	    	$check=$this->checkstatus($regid, $date);
	    	if($check){
	    		$this->db->where('regid',$regid);
	    		$this->db->select('activation_date');
	    		$this->db->from('tmp_members');
	    		$query = $this->db->get();
	    		$rec = $query->unbuffered_row('array');
	    		$start_date = $rec['activation_date'];
	    		$last_date=date('Y-m-d',strtotime('+365 days',strtotime($rec['activation_date'])));

	    		if(!empty($last_date)){
	    			$where = array('remarks'=>'Repurchase Plan For Complete Level Eleventh','regid'=>$regid);
	    			$this->db->where($where);
	    			$this->db->select('id');
	    			$this->db->from('tmp_wallet');
	    			$qry = $this->db->get()->num_rows();
	    			if($qry==2){
	    				$where2=array("added_on>="=>$start_date,"added_on<="=>$last_date);
	    				$this->db->select_sum('bv');
				    	$this->db->from('tmp_purchase');
				    	$this->db->where($where2);
				    	$total=$this->db->get()->unbuffered_row('array');	
				    	$amount=($total['bv'] * 0.01);
				    	if($amount>0){
		    			$this->db->select("sum(amount) as total_amount");
							$where=array("regid"=>$regid,"remarks"=>"I Mark Bonus","date"=>$date);
							$added=$this->db->get_where("wallet",$where)->unbuffered_row('array');
							if(empty($added['total_amount'])){
								$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"I Mark Bonus","added_on"=>date('Y-m-d H:i:s'));
									$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"I Mark Bonus");
									$check=$this->db->get_where("wallet",$where2)->num_rows();

									if($check==0){
										return $this->db->insert("wallet",$data);
									}
									else{
										return $this->db->update("wallet",$data,$where2);
									}
							} 
							else{
								return false;
							}
		    		}

	    			}

	    		}
	    		
	    	}
	    	}
    	}

}
?>