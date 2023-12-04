<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {
	function __construct(){
		parent::__construct();
		checklogin();
	}
	
	public function index(){
		$data['title']="Total Income";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$amount=$this->Member_model->memberwalletincome_amount();
		$amt['actualwallet'] = $amount['amount'];
		$data['wallet'] = $amt;
		$members=$this->Wallet_model->getmemberrequests(array("regid"=>$regid));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','wallet',$data);
	}

	public function second_wallet(){
		$data['title']="ROI Total Income";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		// $this->Wallet_model->addcommission($regid);
		$data['wallet']=$this->Wallet_model->getwallet_second($regid);
		$members=$this->Wallet_model->getmemberrequests_second(array("regid"=>$regid));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','wallet_second',$data);
	}
	
	
	public function incomes(){
		$rec = $this->input->get();
		$where = array();
		if(isset($rec['year']) && !empty($rec['year'])){
			$where['YEAR(date)'] = $rec['year'];
		}else{
			$where['YEAR(date)'] = date("Y");
		}
		if(isset($rec['month']) && !empty($rec['month'])){
			$where['MONTH(date)'] = $rec['month'];
		}else{
			$where['MONTH(date)'] = date("n");
		}
		if(isset($rec['closing']) && !empty($rec['closing'])){
			if($rec['closing']==1){
				$where['DAY(date)'] = '10';
			}elseif($rec['closing']==2){
				$where['DAY(date)'] = '20';
			}
			if($rec['closing']==3){
				$where['DAY(date)'] = '30';
			}
		}
	
		
		// if(isset($rec['from_date']) && !empty($rec['from_date']) && isset($rec['to_date']) && !empty($rec['to_date'])){
		// 	$where['date>='] = $rec['from_date'];
		// 	$where['date<='] = $rec['to_date'];
		// }else{
		// 	$date = date('Y-m-d');
		// 	if($date<=date('Y-m-10')){
		// 		$where['date<='] = date('Y-m-10');
		// 		$where['date>='] = date('Y-m-01');
		// 	}elseif($date>=date('Y-m-10') && $date<=date('Y-m-20')){
		// 		$where['date<='] = date('Y-m-20');
		// 		$where['date>='] = date('Y-m-11');
		// 	}elseif($date>=date('Y-m-10') && $date<=date('Y-m-31')){
		// 		$where['date<='] = date('Y-m-31');
		// 		$where['date>='] = date('Y-m-21');
		// 	}
		// }
		
		$data['title']="My Incomes";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['regid'] = $regid;
		$where['amount>'] = 0;
		$where['remarks'] ='Monthly Income';
		
		$data['incomes']=$this->Wallet_model->memberincome($where);
		// echo PRE;
		// print_r($data['incomes']);die;
		$data['datatable']=true;
		$this->template->load('wallet','monthlyincome',$data);
	}

	public function walletlist(){

		$rec = $this->input->post();
		
		$where = array();
		if(isset($rec['id']) && !empty($rec['id']) && $rec['id']=='1'){
			$where['remarks'] ='Monthly Income';
		}elseif(isset($rec['id']) && !empty($rec['id']) && $rec['id']=='2'){
			$where['remarks'] ='Direct Sponsor Income';
		}elseif(isset($rec['id']) && !empty($rec['id']) && $rec['id']=='3'){
			$where['remarks'] ='Level Income';
		}
		// 	echo PRE;
		// print_r($where);die;
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['regid'] = $regid;
		$where['amount>'] = 0;
		
		$data=$this->Wallet_model->memberincome($where);
		if(!empty($data)){
			$html = '';
			$total = 0;
			$i = 0;
			foreach ($data as $key => $value) { $i++;
				$total = $total + $value['amount'];
				$html.='<tr class=text-bold>';
				$html.='<td>'.$i.'</td>';
				$html.='<td><i class="fa fa-inr"></i> '.$value['amount'].'</td>';
				$html.='<td>'.$value['date'].'</td>';
				if(!empty($value['rank'])){
					$html.='<td>'.$value['remarks'].'('.$value['rank'].')'.'</td>';
				}else{
					$html.='<td>'.$value['remarks'].'</td>';
				}
				
				$html.='</tr>';
			}
			$html.='<tr class=text-bold>';
				$html.='<td colspan=2 class=text-center><i class="fa fa-inr"></i> '.$total.'/-</td>';
				$html.='<td></td>';
				$html.='<td></td>';
				$html.='</tr>';
				
		}else{
			$html ='<tr class=text-bold>';
			$html.='<td colspan=4 class=text-center>No Record</td>';
			
			$html.='</tr>';
		}
		echo $html;
	}



	public function cashbackincome(){
		$data['title']="Monthly Income";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['incomes']=$this->Wallet_model->cashbackincomes($regid);
		$data['datatable']=true;
		$this->template->load('wallet','incomes',$data);
	}
	// public function level_income(){
	// 	$data['title']="Level Income";
	// 	$data['breadcrumb']=array("/"=>"Home");
	// 	$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
	// 	$regid=$data['user']['id'];
	// 	$data['incomes']=$this->Wallet_model->levelincomelist($regid);
	// 	$data['datatable']=true;
	// 	$this->template->load('wallet','incomes',$data);
	// }
	public function instantreferalincome(){
		$data['title']="Direct Sponsor Income";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['incomes']=$this->Wallet_model->instantreferalincome($regid);
		$data['datatable']=true;
		$this->template->load('wallet','incomes',$data);
	}
	public function carrewardincome(){
		$data['title']="Car Reward Income";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['incomes']=$this->Wallet_model->carrewardincome($regid);
		$data['datatable']=true;
		$this->template->load('wallet','incomes',$data);
	}
	public function directsponsor_income(){
		$rec = $this->input->get();
		$where = array();
		if(isset($rec['year']) && !empty($rec['year'])){
			$where['YEAR(date)'] = $rec['year'];
		}else{
			$where['YEAR(date)'] = date('Y');
		}
		
		if(isset($rec['month']) && !empty($rec['month'])){
			$where['MONTH(date)'] = $rec['month'];
		}else{
			$where['MONTH(date)'] = date('m');
		}
		if(isset($rec['closing']) && !empty($rec['closing'])){
			if($rec['closing']==1){
				$where['DAY(date)'] = '10';
			}elseif($rec['closing']==2){
				$where['DAY(date)'] = '20';
			}
			if($rec['closing']==3){
				$where['DAY(date)'] = '30';
			}
		}
		
		$data['title']="Direct Sponsor Incomes";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['regid'] = $regid;
		$where['amount>'] = 0;
		$where['remarks'] ='Direct Sponsor Income';
		$data['incomes']=$this->Wallet_model->directsponsor($where);
		$data['datatable']=true;
		$this->template->load('wallet','directsponsorincome',$data);
	}

	public function level_income(){
		$rec = $this->input->get();
		$where = array();
		if(isset($rec['year']) && !empty($rec['year'])){
			$where['YEAR(date)'] = $rec['year'];
		}
		else{
			$where['YEAR(date)'] = date('Y');
		}
		
		if(isset($rec['month']) && !empty($rec['month'])){
			$where['MONTH(date)'] = $rec['month'];
		}else{
			$where['MONTH(date)'] = date('m');
		}
		// if(isset($rec['closing']) && !empty($rec['closing'])){
		// 	if($rec['closing']==1){
		// 		$where['DAY(date)'] = '10';
		// 	}elseif($rec['closing']==2){
		// 		$where['DAY(date)'] = '20';
		// 	}
		// 	if($rec['closing']==3){
		// 		$where['DAY(date)'] = '30';
		// 	}
		// }
		// if(isset($rec['level']) && !empty($rec['level'])){
		// 	if($rec['level']==1){
		// 		$where['rank'] = "1st Level";
		// 	}elseif($rec['level']==2){
		// 		$where['rank'] = "2nd Level";
		// 	}
		// }
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['regid'] = $regid;
		$where['amount>'] = 0;
		$where['remarks'] ='Level Income';
		$data['title']="Level Incomes";
		$data['breadcrumb']=array("/"=>"Home");
		$data['incomes']=$this->Wallet_model->levelin($where);
		// 	 echo PRE;
		// print_r($data['incomes']);die;
		$data['datatable']=true;
		$this->template->load('wallet','levelincome',$data);
	}

	public function roi_fund_trans(){
		$data['title']="ROI Fund Transfer";
		$data['breadcrumb']=array("/"=>"Home");
		$data['incomes']=$this->Member_model->memberroiincome_amount();
		$data['fundtranslist'] = $this->Member_model->getfundtransgferlist();
		$data['datatable']=true;
		$this->template->load('wallet','roi_fund_trans',$data);
	}

	public function fund_receive(){
		$data['title']="ROI Fund Transfer";
		$data['breadcrumb']=array("/"=>"Home");
		$data['incomes']=$this->Member_model->memberroiincome_amount();
		$data['fundtranslist'] = $this->Member_model->getfundreceivelist();
		// echo PRE;
		// print_r($data['fundtranslist']);die;
		$data['datatable']=true;
		$this->template->load('wallet','fund_receive',$data);
	}
	public function level_fund_trans(){
		$data['title']="Level Fund Transfer";
		$data['breadcrumb']=array("/"=>"Home");
		$data['incomes']=$this->Member_model->memberlevelincome_amount();
		// echo PRE;
		// print_r($data['incomes']);die;
		$data['fundtranslist'] = $this->Member_model->getfundtransgferlistforlevel();
		$data['datatable']=true;
		$this->template->load('wallet','level_fund_trans',$data);
	}
	public function addfund(){
		$regid = $this->session->userdata('id');
		$memberid = $this->db->get_where('users',array('id'=>$regid))->row('username');
		$data = $this->input->post();
		
		if($memberid!=$data['sponsor_id']){
			$send['sender_id'] = $this->session->userdata('id');
			$send['receiver_id'] =  $data['sponsor_id'];
			$send['amount'] = $data['transfer_amount'];
			$send['type'] = $data['type'];
			$send['added_on'] = date('Y-m-d');
			$result=$this->Wallet_model->addfund($send);
			if($result===true){
				$this->session->set_flashdata("msg","Amount Transferred successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg","Something Error");
			}
		}else{
			$this->session->set_flashdata("err_msg","Sorry! You can't transfer money yourself.");
		}
		
		
			redirect($_SERVER['HTTP_REFERER']);
	}

	public function roiincome(){
		$rec = $this->input->get();
		$where = array();
		// if(isset($rec['year']) && !empty($rec['year'])){
		// 	$where['YEAR(date)'] = $rec['year'];
		// }
		// else{
		// 	$where['YEAR(date)'] = date('Y');
		// }
		
		// if(isset($rec['month']) && !empty($rec['month'])){
		// 	$where['MONTH(date)'] = $rec['month'];
		// }else{
		// 	$where['MONTH(date)'] = date('m');
		// }
		// if(isset($rec['closing']) && !empty($rec['closing'])){
		// 	if($rec['closing']==1){
		// 		$where['DAY(date)'] = '10';
		// 	}elseif($rec['closing']==2){
		// 		$where['DAY(date)'] = '20';
		// 	}
		// 	if($rec['closing']==3){
		// 		$where['DAY(date)'] = '30';
		// 	}
		// }
		
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['regid'] = $regid;
		$where['amount>'] = 0;
		// $where['remarks'] ='ROI Income';
		$data['title']="ROI Incomes";
		$data['breadcrumb']=array("/"=>"Home");
		$data['incomes']=$this->Wallet_model->roiin($where);
		// echo PRE;
		// print_r($data['incomes']);die;
		$data['datatable']=true;
		$this->template->load('wallet','roiincome',$data);

	}

	public function carreward_offers(){
		$rec = $this->input->get();
		$where = array();
		if(isset($rec['year']) && !empty($rec['year'])){
			$where['YEAR(date)'] = $rec['year'];
		}else{
			$where['YEAR(date)'] = date('Y');
		}
		if(isset($rec['month']) && !empty($rec['month'])){
			$where['MONTH(date)'] = $rec['month'];
		}else{
			$where['MONTH(date)'] = date('m');
		}
		if(isset($rec['from_date']) && !empty($rec['from_date']) && isset($rec['to_date']) && !empty($rec['to_date'])){
			$where['date>='] = $rec['from_date'];
			$where['date<='] = $rec['to_date'];
		}
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['regid'] = $regid;
		$where['amount>'] = 0;
		$where['remarks'] ='Car Reward';
		$data['title']="Car Reward Incomes";
		$data['breadcrumb']=array("/"=>"Home");
	
		$data['incomes']=$this->Wallet_model->carreward_income($where);
		$data['datatable']=true;
		$this->template->load('wallet','carreward_offers',$data);
	}

	public function current_month_business(){
		$rec = $this->input->get();
		$data['title']="Current Month Business";
		$data['breadcrumb']=array("/"=>"Home");
		$where = array();
		if(isset($rec['year']) && !empty($rec['year'])){
			$where['YEAR(t2.activation_date)'] = $rec['year'];
		}else{
			$where['YEAR(t2.activation_date)'] =date('Y',strtotime(date('Y-m-d')));
		}
		if(isset($rec['month']) && !empty($rec['month'])){
			$where['MONTH(t2.activation_date)'] = $rec['month'];
		}else{
			$where['MONTH(t2.activation_date)'] =date('m',strtotime(date('Y-m-d')));
		}
		if(isset($rec['from_date']) && !empty($rec['from_date']) && isset($rec['to_date']) && !empty($rec['to_date'])){
			$where['t2.date>='] = $rec['from_date'];
			$where['t2.date<='] = $rec['to_date'];
			$where['YEAR(t2.activation_date)'] =date('Y',strtotime($rec['from_date']));
			$where['MONTH(t2.activation_date)'] =date('m',strtotime($rec['from_date']));
		}
		// echo PRE;
		// print_r($where);die;
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['t2.status'] = "1";
		
		// $where['t2.status!='] ='0';
		// $where['remarks'] ='Car Reward';
		// echo PRE;
		// print_r($where);die;
		$rec=$this->Member_model->getmonthlyreport($regid,$type="all",$where);
		$data['members'] = $rec['active'];
		// echo PRE;
		// print_r($data['members']);die;
		$data['datatable']=true;
		$this->template->load('wallet','currentmonth_business',$data);
	}
	
		
	public function direct_sponsor_report(){
		$rec = $this->input->get();
		
		$data['title']="Current Month Business";
		$data['breadcrumb']=array("/"=>"Home");
		$where = array();
		if(isset($rec['year']) && !empty($rec['year'])){
			$where['YEAR(t2.activation_date)'] = $rec['year'];
		}
		if(isset($rec['month']) && !empty($rec['month'])){
			$where['MONTH(t2.activation_date)'] = $rec['month'];
		}else{
			$where['MONTH(t2.activation_date)'] =date('m',strtotime(date('Y-m-d')));
		}
		if(isset($rec['from_date']) && !empty($rec['from_date']) && isset($rec['to_date']) && !empty($rec['to_date'])){
			$where['t2.date>='] = $rec['from_date'];
			$where['t2.date<='] = $rec['to_date'];
			$where['YEAR(t2.activation_date)'] =date('Y',strtotime($rec['from_date']));
			$where['MONTH(t2.activation_date)'] =date('m',strtotime($rec['from_date']));
		}
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['t2.status'] = "1";
	
		
		$data['title']="Direct Sponsor Report Current Month";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$where['t2.refid'] = $regid;
		// $data['incomes']=$this->Wallet_model->direct_sponsor($regid);
		$data['members']=$this->Member_model->getdirectmembersreports($where);
		// echo PRE;
		// print_r($data['members']);die;
		$data['datatable']=true;
		// $this->template->load('wallet','incomes',$data);
		$this->template->load('wallet','currentmonth_business_report',$data);
	}



	public function car_reward_reports(){
		$data['title']="Car Reward Report Current Month";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['incomes']=$this->Wallet_model->car_reward_report($regid);
		$data['datatable']=true;
		$this->template->load('wallet','incomes',$data);
	}
	
	public function membercommission(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Member Commission";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$data['memberincomes']=$this->Wallet_model->getmembercommission();
		$data['datatable']=true;
		$this->template->load('wallet','membercommission',$data);
	}
	
	public function memberincome($regid=NULL){
		if($this->session->role!='admin'){ redirect('/'); }
		if($regid===NULL){ redirect("wallet/membercommission/"); }
		$data['title']="Member Income";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$data['incomes']=$this->Wallet_model->memberincome($regid);
		$data['datatable']=true;
		$this->template->load('wallet','incomes',$data);
	}
	
	public function wallettransfer(){
		$data['breadcrumb']=array("/"=>"Home",""=>"Wallet");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
        if($this->session->role=='admin'){
            $data['avl_balance']=false;
			$data['title']="Fund Transfer";
        }
        else{
            $wallet=$this->Wallet_model->getwallet($regid);
            $data['avl_balance']=$wallet['actualwallet'];
			$data['title']="Wallet Transfer";
        }
		$data['transfers']=$this->Wallet_model->gethistory($regid);
		$data['datatable']=true;
		
		$data['type_from']="ewallet";
		$data['type_to']="ewallet";
		$this->template->load('wallet','transfer',$data);
	}
	
	public function walletreceived(){
		$data['title']="Wallet Received History";
		$data['breadcrumb']=array("/"=>"Home",""=>"Wallet");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		
		$data['transfers']=$this->Wallet_model->gethistory($regid,"received","ewallet");
		$data['datatable']=true;
		$this->template->load('wallet','transferhistory',$data);
	}
	
	public function withdrawal(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="Witdrawal";
		$data['breadcrumb']=array("/"=>"Home","wallet/"=>"Wallet");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$acc_details=$this->Member_model->getaccdetails($regid);
		$data['acc_details']=$acc_details;
		$wallet=$this->Wallet_model->getwallet($regid);
		$avl_balance=$wallet['actualwallet'];
		$data['datatable']=true;
		$data['avl_balance']=$avl_balance;
		$this->template->load('wallet','request',$data);
	}

	public function withdrawal_second(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="ROI Witdrawal";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$acc_details=$this->Member_model->getaccdetails($regid);
		$data['acc_details']=$acc_details;
		$wallet=$this->Wallet_model->getwallet_second($regid);
		$avl_balance=$wallet['actualwallet'];
		$data['datatable']=true;
		$data['avl_balance']=$avl_balance;
		$this->template->load('wallet','request_second',$data);
	}
	
	public function memberrewards(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Member Rewards";
		$members=$this->Wallet_model->getmemberrewards();
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','memberrewards',$data);
	}
	
	public function requestlist(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Withdrawal Requests";
		$endtime=date('Y-m-d 18:00:00');
		$today=date('Y-m-d');
		$where=array("t1.status"=>0);
		// $where="(t1.status=0 and t1.added_on<'$endtime') or (t1.status=1 and t1.approve_date='$today') ";
		$members=$this->Wallet_model->getwitdrawalrequest($where);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','requestlist',$data);
	}

	public function requestlist_second(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="ROI Withdrawal Requests";
		$endtime=date('Y-m-d 18:00:00');
		$today=date('Y-m-d');
		$where=array("t1.status"=>0);
		// $where="(t1.status=0 and t1.added_on<'$endtime') or (t1.status=1 and t1.approve_date='$today') ";
		$members=$this->Wallet_model->getwitdrawalrequest_second($where);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','requestlist_second',$data);
	}
	
	public function dailypaymentreport(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Daily Payment List";
		$payments=$this->Wallet_model->dailypaymentreport();
		$data['payments']=$payments;
		$data['datatable']=true;
		$this->template->load('wallet','dailypaymentreport',$data);
	}
	
	public function paymentreport(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Payment Report";
		$members=$this->Wallet_model->paymentreport();
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','report',$data);
	}
	



	
	
	public function getpaylist(){
		$from=$this->input->post('from');
		$to=$this->input->post('to');
		$where=array();
		if($from!='' && $to!=''){
			$where['t1.approve_date>=']=$from;
			$where['t1.approve_date<=']=$to;
		}elseif($from!='' && $to==''){
			$where['t1.approve_date=']=$from;
		}
		elseif($from=='' && $to!=''){
			$where['t1.approve_date=']=$to;
		}
		
		$members=$this->Wallet_model->paymentreport($where);
		$data['members']=$members;
		$this->load->view("wallet/paylist",$data);
	}
	
	public function transferamount(){
		if($this->input->post('transferamount')!==NULL){
			$data=$this->input->post();
			if($data['otp']==$this->session->transfer_otp){
				$this->session->unset_userdata('transfer_otp');
				unset($data['otp']);
				unset($data['transferamount']);
				$data['date']=date('Y-m-d');
				$data['added_on']=date('Y-m-d H:i:s');
				$result=$this->Wallet_model->transferamount($data);
				if($result===true){
					$this->session->set_flashdata("msg","Amount Transferred successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
			else{
				$this->session->set_flashdata("err_msg","Invalid OTP!");
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function requestpayout(){
		if($this->input->post('requestpayout')!==NULL){
			$data=$this->input->post();

			$regid = $data['regid'];  //by PANKAJ
			$wallet=$this->Wallet_model->getwallet($regid);
		    $avl_balance=$wallet['actualwallet'];
		    if($avl_balance>=$data['amount']){
		    	unset($data['requestpayout']);
				$data['tds']=0.05*$data['amount'];
				$data['admin_charge']=0.05*$data['amount'];
				$data['payable']=$data['amount']-(0.1*$data['amount']);
				$data['updated_on']=$data['added_on']=date('Y-m-d H:i:s');
			
				$result=$this->Wallet_model->requestpayout($data);
				if($result===true){
					$this->session->set_flashdata("msg","Withdrawal Request Submitted successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
		    }else{
		    	$this->session->set_flashdata("err_msg",'No Sufficient balance');
		    }
			
		}
		redirect('wallet/withdrawal/');
	}
	
	public function approvepayout(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->Wallet_model->approvepayout($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Payout Approved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/requestlist/');
	}

	public function approvepayout_second(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->Wallet_model->approvepayout_second($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Payout Approved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/requestlist/');
	}
	
	public function approveallpayout(){
		$endtime=date('Y-m-d 18:00:00');
		$result=$this->Wallet_model->approveallpayout($endtime);
		echo date('Y-m-d');
	}
	
	public function rejectpayout(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->Wallet_model->rejectpayout($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Payout Request Rejected!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/requestlist/');
	}

	public function rejectpayout_second(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->Wallet_model->rejectpayout_second($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Payout Request Rejected!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/requestlist/');
	}
	
	public function approvereward(){
		if($this->input->post('request_id')!==NULL){
			$id=$this->input->post('request_id');
			$result=$this->Wallet_model->approvereward($id);
			if($result===true){
				$this->session->set_flashdata("msg","Member Reward Approved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/memberrewards/');
	}
	
	public function upgradeautopool(){
		if($this->input->post('upgradeautopool')!==NULL){
			$data=$this->input->post();
			unset($data['upgradeautopool']);
			$result=$this->Wallet_model->upgradeautopool($data);
			if($result===true){
				$this->session->set_flashdata("msg","Auto Pool Upgraded Successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('members/upgrade/');
	}
	

	public function generateotp(){
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$mobile=$data['user']['mobile'];
		$username=$this->input->post('username');
		$amount=$this->input->post('amount');
		$otp=rand(001213,999999);
		$this->session->set_userdata("transfer_otp",$otp);
		$message="$otp is your OTP to transfer Rs. $amount to $username. ASR Hub";
		$smsdata=array("mobile"=>$mobile,"message"=>$message);
		send_sms($smsdata);
	}

	public function findrequestlist(){
		$data = $this->input->post();
		$where=array("t1.status"=>0,"t1.date>="=>$data['from_date'],"t1.date<="=>$data['to_date']);
		// $where="(t1.status=0 and t1.added_on<'$endtime') or (t1.status=1 and t1.approve_date='$today') ";
		$members=$this->Wallet_model->getwitdrawalrequest($where);

		$html = '<table class="table data-table" id="bootstrap-data-table-export">';
        $html.='<thead>';
        $html.='<tr>';
        $html.='<th>Sl No.</th>';
        if($this->session->role=='admin'){
            $html.='<th>Member ID</th>';
            $html.='<th>Member Name</th>';
            $html.='<th>Account No</th>';
            $html.='<th>IFSC Code</th>';
        } 
        $html.='<th>Request Date</th>';
        $html.='<th>Amount</th>';
        if($this->session->role=='admin'){
            if(!isset($register)){
                $html.='<th>Action</th>';
            } 
            else{
                $html.='<th>Approve Date</th>';
            }
            }else{ 
                $html.='<th>Approve Date</th>';
                $html.='<th>Status</th>';
            }
            $html.='</tr>';
            $html.='</thead>';
            $html.='<tbody>';
            $members=$members;
            if(is_array($members)){  $i=0;
                foreach($members as $member){
                    $i++;
                    $status="<span class='text-danger'>Not Approved</span>";
                    if($member['status']==1){
                        $status="<span class='text-success'>Approved</span>";
                    }
                    $html.='<tr>';
                    $html.='<td>'.$i.'</td>';
                    if($this->session->role=='admin'){
                        $html.='<td>'.$member['username'].'</td>';
                        $html.='<td>'.$member['name'].'</td>';
                        $html.='<td>'.$member['account_no'].'</td>';
                        $html.='<td>'.$member['ifsc'].'</td>';
                    }
                    $html.='<td>'.date('d-m-Y',strtotime($member['date'])).'</td>';
                    $html.='<td>'.$this->amount->toDecimal($member['payable']).'</td>';
                    if($this->session->role=='admin'){
                        if(!isset($register)){
                            $html.='<td>';
                            $html.='<form action="'.base_url('wallet/approvepayout').'" method="post" onSubmit="return validate("accept");" class="float-left" style="margin-right:5px;">';
                            $html.='<button type="submit" value="'.$member['id'].'" name="request_id" class="btn btn-sm btn-success">Approve</button>';
                            $html.='</form>';
                            $html.='<form action="'.base_url('wallet/rejectpayout').'" method="post" onSubmit="return validate("reject");" class="float-left">';
                            $html.='<button type="submit" value="'.$member['id'].'" name="request_id" class="btn btn-sm btn-danger">Reject</button>';
                            $html.='</form>';
                            $html.='</td>';
                        } 
                        else{
                        	
                        	 $html.='<td>'.($member['approve_date']!='') ? (date('d-m-Y',strtotime($member['approve_date']))) : ('').'</td>';
                        }
                    }else{ 
                    	 $html.='<td>'.($member['approve_date']!='') ? (date('d-m-Y',strtotime($member['approve_date']))) : ('').'</td>';
                        $html.='<td>'.$status.'</td>';
                    }
                     $html.='</tr>';
                }
            }
            $html.='</tbody>';
        $html.='</table>';
        echo $html;
	}
	
	public function resendotp(){
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$mobile=$data['user']['mobile'];
		$username=$this->input->post('username');
		$amount=$this->input->post('amount');
		$otp=$this->session->transfer_otp;
		$this->session->set_userdata("transfer_otp",$otp);
		$message="$otp is your OTP to transfer Rs. $amount to $username. ASR Hub";
		$smsdata=array("mobile"=>$mobile,"message"=>$message);
		send_sms($smsdata);
	}
	
	public function exportpaymentreport(){
		$from=$this->input->get('from');
		$to=$this->input->get('to');
		$type=$this->input->get('type');
		$where=array();
		$date="all";
		if($from!='' && $to!=''){
			$where['t1.approve_date>=']=$from;
			$where['t1.approve_date<=']=$to;
			$date=date('d-m-Y',strtotime($from))."-to-".date('d-m-Y',strtotime($to));
		}elseif($from!='' && $to==''){
			$where['t1.approve_date=']=$from;
			$date=date('d-m-Y',strtotime($from));
		}
		elseif($from=='' && $to!=''){
			$where['t1.approve_date=']=$to;
			$date=date('d-m-Y',strtotime($to));
		}
		$members=$this->Wallet_model->paymentreport($where);
		$skip=array();
		$colnames=array("Date","Member ID","Name","Account No","IFSC Code","Amount","TDS","Admin Charge","Payable");
		$filename="Payment-Report-".$date;
		if($type=='pay'){
			$filename="Payment-list-".$date;
			$colnames=array("Date","Member ID","Name","Account No","IFSC Code","Amount");
			$skip=array("amount","tds","admin_charge");
		}
		exporttoexcel($members,$filename,$colnames,$skip);
	}
	
}
