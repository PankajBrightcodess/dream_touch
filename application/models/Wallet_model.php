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
		 $this->roi_income($regid,$date);
		 $this->directsponsor($regid,$date);
		 $this->level_income($regid,$date);
		 $this->generate_level_income($regid,$date);
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

			$where6=array("sender_id"=>$regid,"type"=>"level_fund");
			$this->db->select_sum('amount');
			$query5=$this->db->get_where("tmp_fund_transfer",$where6);
			$transamount=$query5->row()->amount;
			if($transamount==NULL){ $transamount=0; }

			$memberid = $this->db->get_where('users',array('id'=>$regid))->row('username');
			$where7=array("receiver_id"=>$memberid,"type"=>"roi_fund");
			$this->db->select_sum('amount');
			$query6=$this->db->get_where("tmp_fund_transfer",$where7);
			$getamount=$query6->row()->amount;
			if($getamount==NULL){ $getamount=0; }
			
		}
		$result['bankwithdrawal']=$bankwithdrawal;
		$result['cancelled']=$cancelled;
		$result['wallettransfers']=$wallettransfers;
		$result['walletreceived']=$walletreceived;		
		$result['epingeneration']=$epingeneration;
		$result['actualwallet']=$wallet-$bankwithdrawal-$wallettransfers+$walletreceived+$getamount+$cancelled-$epingeneration;
		$result['wallet']=$result['actualwallet']-(10*$result['actualwallet'])/100;
		return $result;
	}

	public function getwallet_second($regid,$type="ewallet"){
		$result=array();
		$where=array("regid"=>$regid);
		$this->db->select_sum('amount');
		$query=$this->db->get_where("wallet_second",$where);
		$wallet=$query->row()->amount;
		if($wallet==NULL){ $wallet=0; }
		$result['wallet']=$wallet;
		
		$bankwithdrawal=$wallettransfers=$walletreceived=$epingeneration=$cancelled=$transamount=$getamount=0;
		if($type=="ewallet"){
			$where2=array("regid"=>$regid,"status!="=>2);
			$this->db->select_sum('amount','amount');
			$query2=$this->db->get_where("withdrawals_second",$where2);
			$bankwithdrawal=$query2->row()->amount;
			if($bankwithdrawal==NULL){ $bankwithdrawal=0; }
			
			$where3=array("reg_from"=>$regid);
			$this->db->select_sum('amount');
			$query3=$this->db->get_where("tmp_wallet_transfers_double",$where3);
			$wallettransfers=$query3->row()->amount;
			if($wallettransfers==NULL){ $wallettransfers=0; }
			
			$where4=array("reg_to"=>$regid);
			$this->db->select_sum('amount');
			$query4=$this->db->get_where("tmp_wallet_transfers_double",$where4);
			$walletreceived=$query4->row()->amount;
			if($walletreceived==NULL){ $walletreceived=0; }
			
			$where5=array("regid"=>$regid,"type"=>"ewallet");
			$this->db->select_sum('amount');
			$query5=$this->db->get_where("epin_requests",$where5);
			$epingeneration=$query5->row()->amount;
			if($epingeneration==NULL){ $epingeneration=0; }

			$where6=array("sender_id"=>$regid,"type"=>"roi_fund");
			$this->db->select_sum('amount');
			$query5=$this->db->get_where("tmp_fund_transfer",$where6);
			$transamount=$query5->row()->amount;
			if($transamount==NULL){ $transamount=0; }

			$memberid = $this->db->get_where('users',array('id'=>$regid))->row('username');
			$where7=array("receiver_id"=>$memberid,"type"=>"roi_fund");
			$this->db->select_sum('amount');
			$query6=$this->db->get_where("tmp_fund_transfer",$where7);
			$getamount=$query6->row()->amount;
			if($getamount==NULL){ $getamount=0; }
			
			// $this->db->where(array('sender_id'=>$regid,'type'=>""));
			// $this->db->select_sum('amount');
			// $this->db->from('');
			// $query6 = $this->db->get();
			// $transamount =  $query6->unbuffered_row('array');
			// if($transamount==NULL){ $transamount=0; }
			
			
		}
		$result['bankwithdrawal']=$bankwithdrawal;
		$result['cancelled']=$cancelled;
		$result['wallettransfers']=$wallettransfers;
		$result['walletreceived']=$walletreceived;		
		$result['epingeneration']=$epingeneration;
		$result['actualwallet']=$wallet-$bankwithdrawal-$wallettransfers+$walletreceived+$getamount+$cancelled-$epingeneration-$transamount;
		$result['wallet']=$result['actualwallet'];
		
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
	// 
	public function levelin($where){
		// echo PRE;
		// print_r($where);die;
		$this->db->order_by("id");
		// return $this->db->get_where("wallet",$where)->result_array();
		$rec =  $this->db->get_where("wallet",$where)->result_array();
		$rec_date = array_column($rec,'date');
		$regid = $this->session->userdata('id');
		
		foreach ($rec as $key => $value) {
			$level1 = $level2 = $level3 = $level4 =$level5=$level6=$level7=$level8=$level9=$level10=array();
			$amt = 0;
			$record = $this->Member_model->levelwisemembers($regid,$value['date']);
			if(!empty($record)){
				foreach($record as $key1 => $value1) {
					if($value1['level']=='1'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.5;
						}elseif($amount==1999.00){
							$amt = 20*0.5;
						}elseif($amount==4999.00){
							$amt = 50*0.5;
						}
						$level1[] = $amt;
					}elseif($value1['level']=='2'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.3;
						}elseif($amount==1999.00){
							$amt = 20*0.3;
						}elseif($amount==4999.00){
							$amt = 50*0.3;
						}
						$level2[] = $amt;
					}elseif($value1['level']=='3'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.2;
						}elseif($amount==1999.00){
							$amt = 20*0.2;
						}elseif($amount==4999.00){
							$amt = 50*0.2;
						}
						$level3[] = $amt;
					}elseif($value1['level']=='4'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.1;
						}elseif($amount==1999.00){
							$amt = 20*0.1;
						}elseif($amount==4999.00){
							$amt = 50*0.1;
						}
						$level4[] = $amt;
					}elseif($value1['level']=='5'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.1;
						}elseif($amount==1999.00){
							$amt = 20*0.1;
						}elseif($amount==4999.00){
							$amt = 50*0.1;
						}
						$level5[] = $amt;
					}elseif($value1['level']=='6'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.1;
						}elseif($amount==1999.00){
							$amt = 20*0.1;
						}elseif($amount==4999.00){
							$amt = 50*0.1;
						}
						$level6[] = $amt;
					}elseif($value1['level']=='7'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.1;
						}elseif($amount==1999.00){
							$amt = 20*0.1;
						}elseif($amount==4999.00){
							$amt = 50*0.1;
						}
						$level7[] = $amt;
					}elseif($value1['level']=='8'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.1;
						}elseif($amount==1999.00){
							$amt = 20*0.1;
						}elseif($amount==4999.00){
							$amt = 50*0.1;
						}
						$level8[] = $amt;
					}elseif($value1['level']=='9'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.1;
						}elseif($amount==1999.00){
							$amt = 20*0.1;
						}elseif($amount==4999.00){
							$amt = 50*0.1;
						}
						$level9[] = $amt;
					}elseif($value1['level']=='10'){
						$amount = $value1['amount'];
						if($amount==999.00){
							$amt = 10*0.1;
						}elseif($amount==1999.00){
							$amt = 20*0.1;
						}elseif($amount==4999.00){
							$amt = 50*0.1;
						}
						$level10[] = $amt;
					}
				}
			}
			if($value['rank']=="1st Level"){
				$rec[$key]['total_amount'] = array_sum($level1);
				$rec[$key]['persentage'] = "50%";
			}elseif($value['rank']=="2nd Level"){
				$rec[$key]['total_amount'] = array_sum($level2);
				$rec[$key]['persentage'] = "30%";
			}elseif($value['rank']=="3rd Level"){
				$rec[$key]['total_amount'] = array_sum($level3);
				$rec[$key]['persentage'] = "20%";
			}elseif($value['rank']=="4th Level"){
				$rec[$key]['total_amount'] = array_sum($level4);
				$rec[$key]['persentage'] = "10%";
			}elseif($value['rank']=="5th Level"){
				$rec[$key]['total_amount'] = array_sum($level5);
				$rec[$key]['persentage'] = "10%";
			}elseif($value['rank']=="6th Level"){
				$rec[$key]['total_amount'] = array_sum($level6);
				$rec[$key]['persentage'] = "10%";
			}elseif($value['rank']=="7th Level"){
				$rec[$key]['total_amount'] = array_sum($level7);
				$rec[$key]['persentage'] = "10%";
			}elseif($value['rank']=="8th Level"){
				$rec[$key]['total_amount'] = array_sum($level8);
				$rec[$key]['persentage'] = "10%";
			}elseif($value['rank']=="9th Level"){
				$rec[$key]['total_amount'] = array_sum($level9);
				$rec[$key]['persentage'] = "10%";
			}elseif($value['rank']=="10th Level"){
				$rec[$key]['total_amount'] = array_sum($level10);
				$rec[$key]['persentage'] = "10%";
			}
		}
		echo PRE;
		print_r($rec);die;
		// return $this->db->last_query();
		//  $array;
	}
	public function roiin($where){
		$this->db->order_by("id","DESC");
		return $this->db->get_where("wallet_second",$where)->result_array();
	// $this->db->last_query();
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

	public function roi_fund_transfer(){
		
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
	public function getmemberrequests_second($where){
		$this->db->where($where);
		$query=$this->db->get("withdrawals_second");
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

	public function getwitdrawalrequest_second($where=array(),$type='all'){
		if(empty($where)){ $where['t1.status']=0; }
			$this->db->select("t1.*, t2.username,t2.name,t3.account_no,t3.ifsc");
			$this->db->from('withdrawals_second t1');
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

	public function approvepayout_second($id){
		$date=date('Y-m-d');
		$updated_on=date('Y-m-d H:i:s');
		if($this->db->update("withdrawals_second",array("status"=>1,"approve_date"=>$date,"updated_on"=>$updated_on),array("id"=>$id))){
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

	public function rejectpayout_second($id)
	{
		$updated_on=date('Y-m-d H:i:s');
		$data=array("status"=>2,"updated_on"=>$updated_on);
		if($this->session->role=='admin'){
			$data['approve_date']=date('Y-m-d');
		}
		if($this->db->update("withdrawals_second",$data,array("id"=>$id))){
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
		$checkstatus=$this->checkstatus($regid,$date);
	
		if($checkstatus){
			$members=$this->Member_model->getdirectativemembers($regid,$date);
			$activation_date = $this->db->get_where('members',array('regid'=>$regid))->row('activation_date');
			$amount = 0;
			$lastdate = date('Y-m-d',strtotime("$activation_date +10 days"));
			$countmember = $this->db->get_where('members',array('refid'=>$regid,'activation_date<='=>$lastdate,'status'=>1))->num_rows();
			$packageamount = $this->packageamount($regid);
			if($countmember>=10 && $countmember<20){
				
				if($packageamount==999.00){
					$amount = 10; 
				}elseif($packageamount==1999.00){
					$amount = 20; 
				}elseif($packageamount==4999.00){
					$amount = 25;
				}
				
			}elseif($countmember>=20 && $countmember<30){
				if($packageamount==999.00){
					$amount = 20; 
				}elseif($packageamount==1999.00){
					$amount = 40; 
				}elseif($packageamount==4999.00){
					$amount = 50;
				}
			}

			$lastdate = date('Y-m-d',strtotime("$activation_date +30 days"));
			$countmember = $this->db->get_where('members',array('refid'=>$regid,'activation_date<='=>$lastdate,'status'=>1))->num_rows();
			if($countmember>=25){
				if($packageamount==999.00){
					$amount = 50; 
				}elseif($packageamount==1999.00){
					$amount = 70; 
				}elseif($packageamount==4999.00){
					$amount = 80;
				} 
			}
			$where=array("regid"=>$regid,"remarks"=>"ROI Sponsoring Bonanza");
				$saveamount=$this->db->get_where("tmp_wallet_second",$where)->result_array();
				if(!empty($saveamount)){
					$post_amount = array_column($saveamount,'amount');
					$post_amount = array_sum($post_amount);
					$amount = $amount-$post_amount;
				}else{
					$amount = $amount-0;
				}
			if($amount>0){
				$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"ROI Sponsoring Bonanza","added_on"=>date('Y-m-d H:i:s'));
				$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"ROI Sponsoring Bonanza");
				$check=$this->db->get_where("tmp_wallet_second",$where)->num_rows();
				if($check == 0){
				    $this->db->insert("tmp_wallet_second",$data);
				}
			}
		}
	}
	// public function get_upgradeid_details($regid,$date=NULL){
	// 	if($date==NULL){ $date=date('Y-m-d'); } 
	// 	$checkstatus=$this->checkstatus($regid,$date);
	// 	if($checkstatus){
	// 		$this->db->select('t2.amount');
	// 		$this->db->from('tmp_upgrade_ids as t1');
	// 		$this->db->join('tmp_packages as t2','t1.package_id=t2.id','left');
	// 		$this->db->where(array('t1.regid'=>$regid));
	// 		return $this->db->get()->row('amount');
	// 	}
	// }
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
					$lavel1[] =  $value;
				}elseif($value['level']==2){
					$lavel2[] =  $value;
				}elseif($value['level']==3){
					$lavel3[] =  $value;
				}elseif($value['level']==4){
					$lavel4[] =  $value;
				}elseif($value['level']==5){
					$lavel5[] =  $value;
				}elseif($value['level']==6){
					$lavel6[] =  $value;
				}elseif($value['level']==7){
					$lavel7[] =  $value;
				}elseif($value['level']==8){
					$lavel8[] =  $value;
				}elseif($value['level']==9){
					$lavel9[] =  $value;
				}elseif($value['level']==10){
					$lavel10[] =  $value;
				}elseif($value['level']==11){
					$lavel11[] =  $value;
				}
			}
			$members=$this->Member_model->getdirectativemembers($regid,$date);
			
		
			if(!empty($lavel1) && count($members)>=2){
				$date1 = $members[1]['activation_date'];
				$datesave =  $members[1]['activation_date'];
				$date1 = new DateTime($date1);
				foreach($members as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['regid'],"total_days"=>$days,"remarks"=>$days,"level"=>"1");
					$check['regid']=$regid;
					$check['child_member_id']=$value['regid'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}
			if(!empty($lavel2) && count($members)>=4){
				
				$date1 = $members[3]['activation_date'];
				$datesave =  $members[3]['activation_date'];
				$date1 = new DateTime($date1);
				
				foreach ($lavel2 as $key => $value) {
				    $date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					// $date=date('Y-m-d',strtotime($value['activation_date'], '-1 day'));
				
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"2");
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}
			if(!empty($lavel3) && count($members)>=6){
				$date1 = $members[5]['activation_date'];
				$datesave =  $members[5]['activation_date'];
				$date1 = new DateTime($date1);
				foreach ($lavel3 as $key => $value) {

					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"3");
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}
			if(!empty($lavel4) && count($members)>=8){
				$date1 = $members[7]['activation_date'];
				$datesave =  $members[7]['activation_date'];
				$date1 = new DateTime($date1);
				foreach ($lavel4 as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"4");
					
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}
			if(!empty($lavel5) && count($members)>=10){
				$date1 = $members[9]['activation_date'];
				$datesave =  $members[9]['activation_date'];
				$date1 = new DateTime($date1);
				foreach ($lavel5 as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"5");
					
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}
			if(!empty($lavel6) && count($members)>=12){
				$date1 = $members[11]['activation_date'];
				$datesave =  $members[11]['activation_date'];
				$date1 = new DateTime($date1);
				foreach ($lavel6 as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"6");
					
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}

			if(!empty($lavel7) && count($members)>=14){
				$date1 = $members[13]['activation_date'];
				$datesave =  $members[13]['activation_date'];
				$date1 = new DateTime($date1);
				
				foreach ($lavel7 as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"7");
					
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}
			if(!empty($lavel8)&& count($members)>=16){
				$date1 = $members[15]['activation_date'];
				$datesave =  $members[15]['activation_date'];
				$date1 = new DateTime($date1);
				foreach ($lavel8 as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"8");
					
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}

			if(!empty($lavel9) && count($members)>=18){
				$date1 = $members[17]['activation_date'];
				$datesave =  $members[17]['activation_date'];
				$date1 = new DateTime($date1);
				foreach ($lavel9 as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"9");
					
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}

			if(!empty($lavel10) && count($members)>=20){
				$date1 = $members[19]['activation_date'];
				$datesave =  $members[19]['activation_date'];
				$date1 = new DateTime($date1);
				foreach ($lavel10 as $key => $value) {
					$date2 = new DateTime($value['activation_date']);
					$diff=date_diff($date1,$date2);
				    $diff = $diff->format('%a');
					if($date1>$date2){
						$days = 300-$diff;
					}else{
						$days = 300;
					}
					$act_date = $value['activation_date'];
					$lastdate = date('Y-m-d',strtotime("$act_date +$days days"));
					$data=array("date"=>$datesave,"activation_date"=>$value['activation_date'],"last_date"=>$lastdate,"regid"=>$regid,"child_member_id"=>$value['member_id'],"total_days"=>$days,"remarks"=>$days,"level"=>"10");
					$check['regid']=$regid;
					$check['child_member_id']=$value['member_id'];
					$res = $this->db->get_where("level_income",$check)->num_rows();
					if($res==0){
						$this->db->insert('level_income',$data);
					}
				}
			}
		}
			// ''''''''Working Mood''''''''''
		}
		public function getdetailsstate(){
			$data = $this->db->get_where('area')->result_array();
			echo PRE;
			print_r($data);die;

		}

		public function addfund($data){
			$this->db->insert("tmp_fund_transfer",$data);
		}


		public function packageamount($regid){
			$this->db->select('t2.amount');
			$this->db->from('members as t1');
			$this->db->join('packages as t2','t1.package_id=t2.id','left');
			$this->db->where(array('t1.regid'=>$regid));
			return $this->db->get()->row('amount');

		}
		public function packageamount_bydate($regid,$date){
			$this->db->select('t2.amount');
			$this->db->from('members as t1');
			$this->db->join('packages as t2','t1.package_id=t2.id','left');
			$this->db->where(array('t1.regid'=>$regid,'t1.activation_date<'=>$date));
			return $this->db->get()->row('amount');

		}
		public function generate_level_income($regid,$date=NULL){
				if($date==NULL){ $date=date('Y-m-d'); }
				$checkstatus=$this->checkstatus($regid,$date);
				
				$result=$commission=array();
				if($checkstatus){
					$data = $this->db->get_where('level_income',array('regid'=>$regid))->result_array();
					$current_date = new DateTime($date);
					if(!empty($data)){
						$l = $totalamount = array();
						foreach ($data as $key => $value) {
							$amount = $this->packageamount($value['child_member_id']);
							if($value['level']==1){
								if($amount==999.00){
									$amt = 10*0.5;
								}elseif($amount==1999.00){
									$amt = 20*0.5;
								}elseif($amount==4999.00){
									$amt = 50*0.5;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level1'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==2){
								if($amount==999.00){
									$amt = 10*0.3;
								}elseif($amount==1999.00){
									$amt = 20*0.3;
								}elseif($amount==4999.00){
									$amt = 50*0.3;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level2'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==3){
								if($amount==999.00){
									$amt = 10*0.2;
								}elseif($amount==1999.00){
									$amt = 20*0.2;
								}elseif($amount==4999.00){
									$amt = 50*0.2;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level3'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==4){
								if($amount==999.00){
									$amt = 10*0.1;
								}elseif($amount==1999.00){
									$amt = 20*0.1;
								}elseif($amount==4999.00){
									$amt = 50*0.1;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level4'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==5){
								if($amount==999.00){
									$amt = 10*0.1;
								}elseif($amount==1999.00){
									$amt = 20*0.1;
								}elseif($amount==4999.00){
									$amt = 50*0.1;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level5'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==6){
								if($amount==999.00){
									$amt = 10*0.1;
								}elseif($amount==1999.00){
									$amt = 20*0.1;
								}elseif($amount==4999.00){
									$amt = 50*0.1;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level6'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==7){
								if($amount==999.00){
									$amt = 10*0.1;
								}elseif($amount==1999.00){
									$amt = 20*0.1;
								}elseif($amount==4999.00){
									$amt = 50*0.1;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level7'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==8){
								if($amount==999.00){
									$amt = 10*0.1;
								}elseif($amount==1999.00){
									$amt = 20*0.1;
								}elseif($amount==4999.00){
									$amt = 50*0.1;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level8'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==9){
								if($amount==999.00){
									$amt = 10*0.1;
								}elseif($amount==1999.00){
									$amt = 20*0.1;
								}elseif($amount==4999.00){
									$amt = 50*0.1;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level9'] = $amt;
									$totalamount[] = $l;
								}
							}elseif($value['level']==10){
								if($amount==999.00){
									$amt = 10*0.1;
								}elseif($amount==1999.00){
									$amt = 20*0.1;
								}elseif($amount==4999.00){
									$amt = 50*0.1;
								}
								$last_date = $value['last_date'];
								$last_date = new DateTime($last_date);
								if($current_date < $last_date){
									$l['level10'] = $amt;
									$totalamount[] = $l;
								}
							}
						}
						$level1 = array_column($totalamount,'level1');
						$level2 = array_column($totalamount,'level2');
						$level3 = array_column($totalamount,'level3');
						$level4 = array_column($totalamount,'level4');
						$level5 = array_column($totalamount,'level5');
						$level6 = array_column($totalamount,'level6');
						$level7 = array_column($totalamount,'level7');
						$level8 = array_column($totalamount,'level8');
						$level9 = array_column($totalamount,'level9');
						$level10 = array_column($totalamount,'level10');

						if(!empty($level1)){
							$amts = array_sum($level1);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"1st Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"1st Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level2)){
							$amts = array_sum($level2);
							
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"2nd Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"2nd Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level3)){
							$amts = array_sum($level3);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"3rd Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"3rd Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level4)){
							$amts = array_sum($level4);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"4th Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"4th Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level5)){
							$amts = array_sum($level5);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"5th Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"5th Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level6)){
							$amts = array_sum($level6);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"6th Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"6th Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level7)){
							$amts = array_sum($level7);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"7th Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"7th Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level8)){
							$amts = array_sum($level8);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"8th Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"8th Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level9)){
							$amts = array_sum($level9);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"9th Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"9th Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

						if(!empty($level10)){
							$amts = array_sum($level10);
							if($amts>0){
								$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amts,"remarks"=>"Level Income","rank"=>"10th Level","added_on"=>date('Y-m-d H:i:s'));
								$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"Level Income","rank"=>"10th Level");
								$check=$this->db->get_where("wallet",$where)->num_rows();
								if($check == 0){
									$this->db->insert("wallet",$data);
								}
							}
						}

					
						
					}
				}
		}

		public function roi_income($regid,$date=NULL){
			if($date==NULL){ $date=date('Y-m-d'); }
				$checkstatus=$this->checkstatus($regid,$date);
				
				$result=$commission=array();
				if($checkstatus){
					$activation_date = $this->db->get_where('members',array('regid'=>$regid))->row("activation_date");
					$lastdate = date('Y-m-d',strtotime("$activation_date +300 days"));
					$current_date = new DateTime($date);
					$lastdate = new DateTime($lastdate);
					if($lastdate>$current_date){
						$amount = $this->packageamount($regid);
						if($amount==999.00){
							$amount = 10;
						}elseif($amount==1999.00){
							$amount = 20;
						}elseif($amount==4999.00){
							$amount = 50;
						}
						if($amount>0){
							$data=array("date"=>$date,'type'=>"ewallet","regid"=>$regid,"amount"=>$amount,"remarks"=>"ROI Income","added_on"=>date('Y-m-d H:i:s'));
							$where=array("date"=>$date,"regid"=>$regid,"remarks"=>"ROI Income");
							$check=$this->db->get_where("wallet_second",$where)->num_rows();
							if($check == 0){
								$this->db->insert("wallet_second",$data);
							}
						}
					}
				}
		}
	}
	

?>