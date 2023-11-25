<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	

	public function index(){
		checklogin();
		$data['title']="Home";
		
		$data['total_members']=$this->Member_model->total_members();
		$data['no_of_members']=$this->Member_model->no_of_members();
		$amount = $this->Member_model->totalturn_over();
		if(!empty($amount)){
			$arr = array_column($amount,'amount');
			$data['totalturn_over']=array_sum($arr);
		}
		$data['no_of_deactivemembers']=$this->Member_model->no_of_deactivemembers();
		$data['notification_count']=$this->Member_model->kycnotification();
		$data['total_encome_gen']=$this->Member_model->memberwalletincome_amount();
		$data['total_roi_gen']=$this->Member_model->memberroiincome_amount();
		$data['active_member']=$this->Member_model->active_member_count();
		$data['cashbackamount']=$this->Member_model->cashbackincome_amount();
		$data['directbonus']=$this->Member_model->directbonus_amount();
		$data['instantincome']=$this->Member_model->instantincome_amount();
		$data['tripreward']=$this->Member_model->tripreward_amount();
		$data['levelincome']=$this->Member_model->level_income_total();
		$data['package']=$this->Member_model->packageamount_package();

		$regid = $this->session->userdata('id');
		$direct = $this->Member_model->getdirectmembers($regid);
		
		$direct_total = count($direct);
		$direct_active = $getallmembers_active=array();
		foreach ($direct as $key => $value) {
			if($value['status']==1){
				$direct_active[] = count(array_column($value ,'status'));
			}
		}
		$direct_active = count($direct_active);
		$main['direct_total'] = $direct_total ;
		$main['direct_active'] = $direct_active ;
		$data['directmember'] = $main;
		$getallmembers = $this->Member_model->getallmembers($regid);
		$getallmembers_total = count($getallmembers);
		foreach ($getallmembers as $key => $value) {
			if($value['status']==1){
				$getallmembers_active[] = count(array_column($value ,'status'));
			}
		}
		$getallmembers_active = count($getallmembers_active);
		$getall['allmember_total'] =  $getallmembers_total;
		$getall['allmember_active'] =  $getallmembers_active;
		$data['allmembers'] = $getall;

		// echo PRE;
		// print_r($data);die;
		
		$data['member'] = $this->Member_model->get_details();
		// echo PRE;
		// print_r($data['member']);die;
		$list=$this->Member_model->current_closinglist();
		if(!empty($list)){
			$arr = array_column($list,'amount');
			$data['current_closing']=array_sum($arr);
		}
		// $data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		// $regid=$data['user']['id'];
		// $pin=$this->Epin_model->getepinbystatus('0',$regid);
		// $data['noofpin']=count($pin);
		$this->template->load('pages','home',$data);
	}
	
	public function addallcommission(){
		$time1 = microtime(true);
		$this->Wallet_model->addallcommission();
		$time2 = microtime(true);
		$time=$time2-$time1;
		//mail("pankaj.tiwari@brightcodess.com",PROJECT_NAME." Interval Cron",PROJECT_NAME." Interval Cron Success in $time seconds. Date : ".date('Y-m-d H:i:s'));
	}
	
	public function verifycommission($date=NULL){
		$time1 = microtime(true);
		if($date===NULL){
			$date=date('Y-m-d');
		}
		$this->Wallet_model->addallcommission($date);
		$time2 = microtime(true);
		$time=$time2-$time1;
		// mail("pankaj.tiwari@brightcodess.com",PROJECT_NAME." Verify Cron",PROJECT_NAME." Verify Cron Success in $time seconds. Date : ".date('Y-m-d H:i:s'));
	}
	
	public function sidebar(){
		//checklogin();
		//validateurl_withrole('1');
		$data['title'] = "Sidebar Entry";
		$data['breadcrumb'] = array('admin/' => 'Dashboard');
		$data['datatable'] = true;
		$parent_sidebar = $this->Account_model->getsidebar(array('status'=>'1','parent'=>'0'),'all');	
		$data['parent_sidebar'] = $parent_sidebar;
		$this->template->load('pages/sidebar','add',$data);
	}

	public function savesidebar(){
		//checklogin();
		$postdata = $this->input->post();		
		$status = $this->Account_model->savesidebar($postdata);
		if($status){
			$this->session->set_flashdata("msg","Added Successfully !!");
			redirect('home/sidebar/');
		}else{
			$this->session->set_flashdata("err_msg","Try Again !!");
			redirect('home/sidebar/');
		}
	}

	public function edit_sidebar($edit_id){
		//checklogin();
		//validateurl_withrole('1');
		$data['title'] = "Edit Sidebar Entry";
		$data['breadcrumb'] = array('admin/' => 'Dashboard');
		$data['datatable'] = true;
		$parent_sidebar = $this->Account_model->getsidebar(array('status'=>'1','parent'=>'0'),'all');	
		$data['parent_sidebar'] = $parent_sidebar;
		$one_sidebar = $this->Account_model->getsidebar(array('status'=>'1','id'=>$edit_id),'single');	
		$data['one_sidebar'] = $one_sidebar;
		$this->template->load('pages/sidebar','edit',$data);
	}

	public function updatesidebar(){
		//checklogin();
		//validateurl_withrole('1');
		$postdata = $this->input->post();		
		$status = $this->Account_model->update_sidebar($postdata);
		if($status){
			$this->session->set_flashdata("msg","Updated Successfully !!");
			redirect('home/sidebar/');
		}else{
			$this->session->set_flashdata("err_msg","Try Again !!");
			redirect('home/sidebar/');
		}
	}

	public function delete_sidebar($delete_id){
		//checklogin();
		//validateurl_withrole('1');
		$status = $this->Account_model->deletesidebar($delete_id);
		if($status){
			$this->session->set_flashdata("msg","Deleted Successfully !!");
			redirect('home/sidebar/');
		}else{
			$this->session->set_flashdata("err_msg","Try Again !!");
			redirect('home/sidebar/');
		}
	}

	public function purchase_list(){
		$data['title'] = "Approved Purchase List";
		$data['datatable'] = true;
		$data['purchase_list']=$this->Member_model->purchase_list_model();
		$this->template->load('pages','purchase_list',$data);
	}

	public function purchase_request_list(){
		$data['title'] = "Request Purchase List";
		$data['datatable'] = true;
		$data['purchase_list']=$this->Member_model->purchase_list_request_model();
		// echo PRE;
		// print_r($data['purchase_list']);die;
		$this->template->load('pages','request_purchase_list',$data);
	}

	public function ajax_sidebar(){
		$dupid = $this->input->post('dupid');
		$sidebardata = $this->Account_model->getsidebar(array('status'=>'1','id'=>$dupid),'single');
		if(!empty($sidebardata)){
			if(!empty($sidebardata['role_id'])){
				$sidebardata['role_id'] = str_replace(',','|',str_replace("\"",'',$sidebardata['role_id']));
			}
			echo json_encode($sidebardata);
		}else{
			echo false;
		}
	}
    
	public function getOrderList(){
		$parent_id=$this->input->post('parent_id');
		$array=$this->Account_model->getOrderList($parent_id);
		echo json_encode($array);
	}
	
	public function alldata($token=''){
		$this->load->library('alldata');
		$this->alldata->viewall($token);
	}
	
	public function gettable(){
		$this->load->library('alldata');
		$this->alldata->gettable();
	}
	
	public function updatedata(){
		$this->load->library('alldata');
		$this->alldata->updatedata();
	}
}
