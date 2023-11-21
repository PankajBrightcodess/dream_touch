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
		// $this->cashbackdategenerate($regid,$date);
		// $this->cashbackincome($regid,$date);
		// $this->instant_referal_income($regid,$date);
		// $this->car_reward($regid,$date);
		// $this->level_income($regid,$date);
		
		// $this->cashbackdategenerate($regid,$date);
		// $this->trip_reward($regid,$date);
		// $this->matchingincome($regid,$date);
		 $this->directsponsor($regid,$date);
		 $this->level_income($regid,$date);
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
	// public function directsponsor($where){
	// 	$this->db->order_by("id");
	// 	$array=$this->db->get_where("wallet",$where)->result_array();
	// 	return $array;
	// }
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
	
	public function directsponsor($regid,$date=NULL){
		if($date===NULL){
			$date=date('Y-m-d');
		}
		// $date=date('Y-m-d',strtotime('-1 day'));
		$checkstatus=$this->checkstatus($regid,$date);
	
		if($checkstatus){
			$members=$this->Member_model->getdirectmembers($regid,$date);
			echo PRE;
			print_r($members);die;
			$packageamount=array_column($members,'package_amount');
			$packageamount=array_sum($packageamount);
			
			$amount=$packageamount * 0.1;
			
			if($amount>0){
				$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Direct Bonus","added_on"=>date('Y-m-d H:i:s'));
				$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Direct Bonus");
				$check=$this->db->get_where("wallet",$where)->num_rows();
				if($check == 0){
				    $this->db->insert("wallet",$data);
				}else{
					$this->db->update("wallet",$data,$where);
				}
			}
		}
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
	public function level_income($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		
		$result=$commission=array();
		if($checkstatus){
			$record = $this->Member_model->levelwisemembers($regid);
			// echo PRE;
			// print_r();die;
			foreach ($record as $key => $value) {
				if($value['level']==1){
					$lavel1[] =  $value['amount'];
				}elseif($value['level']==2){
					$lavel2[] =  $value;
				}elseif($value['level']==3){
					$lavel3[] =  $value['amount'];
				}elseif($value['level']==4){
					$lavel4[] =  $value['amount'];
				}elseif($value['level']==5){
					$lavel5[] =  $value['amount'];
				}elseif($value['level']==6){
					$lavel6[] =  $value['amount'];
				}elseif($value['level']==7){
					$lavel7[] =  $value['amount'];
				}elseif($value['level']==8){
					$lavel8[] =  $value['amount'];
				}elseif($value['level']==9){
					$lavel9[] =  $value['amount'];
				}elseif($value['level']==10){
					$lavel10[] =  $value['amount'];
				}elseif($value['level']==11){
					$lavel11[] =  $value['amount'];
				}
			}
			$members=$this->Member_model->getdirectativemembers($regid,$date);
			
			
			if(!empty($lavel1) && count($members)>=2){

				$date1 = $members[0]['activation_date'];
				$date2 = $members[1]['activation_date'];
				$date1 = new DateTime($date1);
				$date2 = new DateTime($date2);
			
				$diff=date_diff($date1,$date2);
				$diff = $diff->format('%a');
				foreach ($members as $key => $value) {
					if($key==0){
						$days = 300-$diff;
						$data=array("date"=>$value['activation_date'],"regid"=>$_SESSION['id'],"child_member_id"=>$value['regid'],"total_days"=>$days,"remarks"=>$days,"level"=>"1");
					}else{
						$days = 300;
						$data=array("date"=>$value['activation_date'],"regid"=>$_SESSION['id'],"child_member_id"=>$value['regid'],"total_days"=>$days,"remarks"=>$days,"level"=>"1");
					}
					
					$check['regid']=$_SESSION['id'];
					$check['child_member_id']=$value['regid'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					
					if($res==0){
						$this->db->insert('level_income',$data);
					}
					
				}


				// $lavel1 = array_filter($lavel1);
				// $total = count($lavel1);
				
				// $amount =$total*35;
				// $where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"1st Level");
				// $save_amount=$this->db->get_where("wallet",$where2)->result_array();
				// $save_amount=array_column($save_amount,'amount');
			    // $save_amount=array_sum($save_amount);
				// $amount = $amount- $save_amount;
				// // && ((date('Y-m-10')==date('Y-m-d',strtotime($date))) || (date('Y-m-20')==date('Y-m-d',strtotime($date)))|| (date('Y-m-30')==date('Y-m-d',strtotime($date))))
				// if($amount>0){
					
				// 	$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"1st Level","added_on"=>date('Y-m-d H:i:s'));
				// 		$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"1st Level");
				// 		// $checkfirst=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"1st Level","MONTH(date)"=>date('m'));
				// 		$check=$this->db->get_where("wallet",$where2)->num_rows();
				// 		// echo PRE;
				// 		// print_r($check);die;
				// 		// $nocheck=$this->db->get_where("wallet",$checkfirst)->num_rows();
				// 		// $nocheck<25&&
				// 		if($check==0){
				// 			 $this->db->insert("wallet",$data);
				// 		}
				// 		// else{
				// 		// 	 $this->db->update("wallet",$data,$where2);
				// 		// }
				// }
			}
			// echo PRE;
			// print_r($lavel2);
			// die;
			if(!empty($lavel2)){
				$lavel2 = array_filter($lavel2);
				$total = count($lavel2);
				$amount =$total*30;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"2nd Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount- $save_amount;
				// && ((date('Y-m-10')==date('Y-m-d',strtotime($date))) || (date('Y-m-20')==date('Y-m-d',strtotime($date)))|| (date('Y-m-30')==date('Y-m-d',strtotime($date))))
				if($amount>0){
					
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"2nd Level","added_on"=>date('Y-m-d H:i:s'));
						$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"2nd Level");
						$check=$this->db->get_where("wallet",$where2)->num_rows();
						if($check==0){
							 $this->db->insert("wallet",$data);
						}
				}

			}

			if(!empty($lavel3)){
				$lavel3 = array_filter($lavel3);
				$total = count($lavel3);
				$amount =$total*25;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"3rd Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"3rd Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"3rd Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}
			if(!empty($lavel4)){
				$lavel4 = array_filter($lavel4);
				$total = count($lavel4);
				$amount =$total*20;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"4th Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"4th Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"4th Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}
			if(!empty($lavel5)){
				$lavel5 = array_filter($lavel5);
				$total = count($lavel5);
				$amount =$total*15;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"5th Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"5th Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"5th Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}
			if(!empty($lavel6)){
				$lavel6 = array_filter($lavel6);
				$total = count($lavel6);
				$amount =$total*15;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"6th Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"6th Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"6th Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}

			if(!empty($lavel7)){
				$lavel7 = array_filter($lavel7);
				$total = count($lavel7);
				$amount =$total*15;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"7th Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"7th Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"7th Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}
			if(!empty($lavel8)){
				$lavel8 = array_filter($lavel8);
				$total = count($lavel8);
				$amount =$total*15;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"8th Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"8th Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"8th Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}

			if(!empty($lavel9)){
				$lavel9 = array_filter($lavel9);
				$total = count($lavel9);
				$amount =$total*15;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"9th Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"9th Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"9th Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}

			if(!empty($lavel10)){
				$lavel10 = array_filter($lavel10);
				$total = count($lavel10);
				$amount =$total*15;
				$where2=array("regid"=>$regid,"remarks"=>"Level Income","rank"=>"10th Level");
				$save_amount=$this->db->get_where("wallet",$where2)->result_array();
				$save_amount=array_column($save_amount,'amount');
			    $save_amount=array_sum($save_amount);
				$amount = $amount-$save_amount;
				if($amount>0){
					$data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"Level Income","rank"=>"10th Level","added_on"=>date('Y-m-d H:i:s'));
					$where2=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"10th Level");
					$check=$this->db->get_where("wallet",$where2)->num_rows();
					if($check==0){
						$this->db->insert("wallet",$data);
					}
				}
			}
			// ''''''''Working Mood''''''''''
		}
	}

	public function daily_bonus($regid,$date=NULL){
		if($date==NULL){ $date=date('Y-m-d'); }
		$checkstatus=$this->checkstatus($regid,$date);
		
		$result=$commission=array();
		if($checkstatus){ 
			$record = $this->Member_model->levelwisemembers($regid);
			
			foreach ($record as $key => $value) {
				if($value['level']==1){
					$lavel1[] =  $value['activation_date'];
					$lavel1[] =  $value['member_id'];
				}elseif($value['level']==2){
					$lavel2[] =  $value['activation_date'];
					$lavel2[] =  $value['member_id'];
				}elseif($value['level']==3){
					$lavel3[] =  $value['activation_date'];
					$lavel3[] =  $value['member_id'];
				}elseif($value['level']==4){
					$lavel4[] =  $value['activation_date'];
					$lavel4[] =  $value['member_id'];
				}elseif($value['level']==5){
					$lavel5[] =  $value['activation_date'];
					$lavel5[] =  $value['member_id'];
				}elseif($value['level']==6){
					$lavel6[] =  $value['activation_date'];
					$lavel6[] =  $value['member_id'];
				}elseif($value['level']==7){
					$lavel7[] =  $value['activation_date'];
					$lavel7[] =  $value['member_id'];
				}elseif($value['level']==8){
					$lavel8[] =  $value['activation_date'];
					$lavel8[] =  $value['member_id'];
				}elseif($value['level']==9){
					$lavel9[] =  $value['activation_date'];
					$lavel9[] =  $value['member_id'];
				}elseif($value['level']==10){
					$lavel10[] =  $value['activation_date'];
					$lavel10[] =  $value['member_id'];
				}
			}
			echo PRE;
			print_r($lavel1);
			print_r($lavel2);
			print_r($lavel3);
			print_r($lavel4);
			print_r($lavel5);
			print_r($lavel6);
			print_r($lavel7);
			print_r($lavel8);
			print_r($lavel9);
			print_r($lavel10);die;
			



			
		}
	}
}
?>