<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epins extends CI_Controller {
	var $transaction_image=true;
	var $reject_request=true;
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		checklogin();
		$data['title']="Generate E-Pin";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		
		$packages=$this->Package_model->getpackage(array("status"=>1));
		$options=array(""=>"Select Package");
		$package_price=array();
		if(is_array($packages)){
			foreach($packages as $package){
				$options[$package['id']]=$package['package'].' ('.$package['amount'].'Rs.)';
				$package_price[$package['id']]=$package['amount'];
			}
		}
		$data['packages']=$options;
		$data['package_price']=json_encode($package_price);
		if($this->session->role=='admin'){
			$this->template->load('epins','generate',$data);
		}
		else{
			$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
			$regid=$data['user']['id'];
			$data['requests']=$this->Epin_model->getmemberrequests(array("t1.regid"=>$regid));
			$data['transaction_image']=$this->transaction_image;
		
			$this->template->load('epins','request',$data);
		}
	}
	
	public function used(){
		checklogin();
		$data['title']="Used E-Pin";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$epins=$this->Epin_model->getepinbystatus('1',$regid);
		$data['epins']=$epins;
		$data['datatable']=true;
		$this->template->load('epins','usedlist',$data);
	}
	
	public function unused(){
		checklogin();
		$data['title']="Fresh E-Pin";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$epins=$this->Epin_model->getepinbystatus('0',$regid);
		$data['epins']=$epins;
		$data['datatable']=true;
		$this->template->load('epins','freshlist',$data);
	}
	
	public function transfer(){
		checklogin();
		$data['title']="Transfer E-Pin";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$packages=$this->Package_model->getpackage(array("status"=>1));
		$options=array(""=>"Select Package");
		if(is_array($packages)){
			foreach($packages as $package){
				$options[$package['id']]=$package['package'];
			}
		}
		$data['packages']=$options;
		$this->template->load('epins','transfer',$data);
	}
	
	public function transferhistory(){
		checklogin();
		$data['title']="Transfer History";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$data['datatable']=true;
		$regid='';
		if($this->session->role!='admin'){
			$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
			$regid=$data['user']['id'];
		}
		$data['transfers']=$this->Epin_model->gethistory($regid);
		$this->template->load('epins','transferhistory',$data);
	}
	
	public function generationhistory(){
		checklogin();
		$data['title']="Generation E-Pin";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$data['datatable']=true;
		$regid='';
		if($this->session->role!='admin'){
			$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
			$regid=$data['user']['id'];
			$data['transfers']=$this->Epin_model->gethistory($regid,"generate");
		}
		else{
			$data['transfers']=$this->Epin_model->gethistory('',"generate");
		}
		$this->template->load('epins','generationhistory',$data);
	}
	
	public function requestlist(){
		checklogin();
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="E-Pin Request List";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$members=$this->Epin_model->getepinrequests(array("t1.status"=>"0"));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('epins','requestlist',$data);
	}
	
	public function approvedlist(){
		checklogin();
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="E-Pin Approved List";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$members=$this->Epin_model->getepinrequests(array("t1.status"=>"1"));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('epins','approvedlist',$data);
	}
	
	public function requestdetails($id=NULL){
		checklogin();
		if($this->session->role!='admin'){ redirect('/'); }
		if($id===NULL){ redirect('epins/requestlist/'); }
		$data['title']="E-Pin Request Details";
		$data['breadcrumb']=array("/"=>"Home",""=>"E-Pins");
		$data['user']['name']='admin';
		$data['user']['photo']='assets/images/blank.png';
		$where['t1.status']="0";
		$where['t1.id']=$id;
		$details=$this->Epin_model->getepinrequests($where,"single");
		if(empty($details)){ redirect('epins/requestlist/'); }
		$data['details']=$details;
		$data['transaction_image']=$this->transaction_image;
		$data['reject_request']=$this->reject_request;
		$this->template->load('epins','requestdetails',$data);
	}
	
	public function generateepin(){
		checklogin();
		if($this->input->post('generateepin')!==NULL){
			$data=$this->input->post();
			unset($data['generateepin']);
			$result=$this->Epin_model->generateepin($data);
			if($result===true){
				$this->session->set_flashdata("msg","E-Pins generated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('epins/');
	}

	public function approveepin(){
		if($this->input->post('approveepin')!==NULL){
			$data=$this->input->post();
			if($data['approveepin']=='Approve'){
				$request_id=$data['request_id'];
				unset($data['request_id']);
				unset($data['approveepin']);
				$result=$this->Epin_model->generateepin($data);
				if($result===true){
					$this->Epin_model->updaterequest($request_id);
					$this->session->set_flashdata("msg","E-Pins generated successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
			else{
				$request_id=$data['request_id'];
				$this->Epin_model->updaterequest($request_id,2);
				$this->session->set_flashdata("msg","E-Pins Request Rejected!");
			}
		}
		if($this->session->role=='admin'){
			redirect('epins/requestlist/');
		}else{
			redirect('epins/');
		}
	}

	public function requestepin(){
		if($this->input->post('requestepin')!==NULL){
			$data=$this->input->post();
			unset($data['requestepin']);
			$name=$this->input->post('name');
			unset($data['name']);
			if($this->transaction_image){
				$upload_path="./assets/uploads/receipt/";
				$allowed_types="jpg|jpeg|png";
				$data['image']=upload_file('image',$upload_path,$allowed_types,$name.'_receipt');
				if($data['image']==''){
					$this->session->set_flashdata("err_msg","Error Uploading Image! Please Try Again!");
					redirect('epins/');
				}
			}
			$result=$this->Epin_model->requestepin($data);
			
			if($result['status']===true){
				if($data['type']!='request'){
					$_POST=array();
					$_POST['approveepin']='Approve';
					$_POST['regid']=$data['regid'];
					$_POST['package_id']=$data['package_id'];
					$_POST['quantity']=$data['quantity'];
					$_POST['amount']=$data['amount'];
					$_POST['request_id']=$result['request_id'];
					$this->approveepin();
				}
				$this->session->set_flashdata("msg","E-Pin Request Submitted successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['err']['message']);
			}
		}
		redirect('epins/');
	}
	
	public function transferepin(){
		if($this->input->post('transferepin')!==NULL){
			$data=$this->input->post();
			unset($data['transferepin']);
			$result=$this->Epin_model->transferepin($data);
			if($result===true){
				$this->session->set_flashdata("msg","E-Pins Transferred successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('epins/transfer/');
	}

	public function getepinquantity(){
		$package_id=$this->input->post('package_id');
		$user=$this->session->userdata('user');
		$where['md5(t1.regid)']=$user;
		$where["t1.package_id"]=$package_id;
		$where["t1.status"]=0;
		$array=$this->Epin_model->getepin($where);
		if(empty($array)){
			echo 0;
		}
		else{
			echo count($array);
		}
	}
	
	public function checkepin(){
        if($this->session->userdata('user')!==NULL){
            $data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
            $regid=$data['user']['id'];
        }
        else{
		  	$regid=$this->input->post('regid');
        }
		$epin=trim($this->input->post('epin'));
		$checkepin=$this->Epin_model->getepin(array("t1.epin"=>$epin,"t1.regid"=>$regid,"t1.status"=>0),"Single");
		if(is_array($checkepin)){
			echo 1;
		}else{
			echo 0;
		}
	}	
}
