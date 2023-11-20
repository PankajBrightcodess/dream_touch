<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	var $transaction_image=true;
	public function __construct(){
		parent::__construct();
		checklogin();
	}
	
	public function index(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="My Profile";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$memberdetails=$this->Member_model->getalldetails($regid);
		$data=array_merge($data,$memberdetails);
		// echo PRE;
		// print_r($data);die;
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->Member_model->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		$data['profile']=true;
		$this->template->load('profile','profile',$data);
	}
	
	public function accdetails(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="Account Details";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$memberdetails=$this->Member_model->getalldetails($regid);
		$data['sponsor']=$this->Account_model->getuser(array("id"=>$memberdetails['member']['refid']));
		$data=array_merge($data,$memberdetails);
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->Member_model->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		$this->template->load('profile','profile',$data);
	}
	
	public function changepassword(){
		$data['title']="Change Password";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$details=$this->Member_model->getmemberdetails($regid);
		//$data['user']['photo']=$details['photo'];
		$this->template->load('profile','changepassword',$data);
	}

	public function change_trans_pass(){
		$data['title']="Change Password";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$details=$this->Member_model->getmemberdetails($regid);
		//$data['user']['photo']=$details['photo'];
		$this->template->load('profile','changetranspassword',$data);
	}
	
	public function kyc(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="Upload KYC";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['acc_details']=$this->Member_model->getaccdetails($regid);
		
		$this->template->load('profile','kyc',$data);
	}
	
	public function kycdocuments(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="View Documents";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['acc_details']=$this->Member_model->getaccdetails($regid);
		$this->template->load('profile','documents',$data);
	}
	
	public function updatepassword(){
		if($this->input->post('updatepassword')!==NULL){
			$data=$this->input->post();
			$result=$this->Member_model->updatepassword($data);
			if($result===true){
				$this->session->set_flashdata('msg',"Password Changed!");
			}
			else{
				$this->session->set_flashdata('err_msg',"Password Not Changed!");
			}
			redirect('profile/changepassword/');
		}
	}

	public function updatetranspassword(){
		if($this->input->post('updatepassword')!==NULL){
			$data=$this->input->post();
		
			$result=$this->Member_model->updatetranspassword($data);
			if($result===true){
				$this->session->set_flashdata('msg',"Password Changed!");
			}
			else{
				$this->session->set_flashdata('err_msg',"Password Not Changed!");
			}
			redirect('profile/changepassword/');
		}
	}
	
	public function updatephoto(){
		if($this->input->post('updatephoto')!==NULL){
			$where['regid']=$this->input->post('regid');
			$upload_path="./assets/uploads/members/";
			$allowed_types="jpg|jpeg|png";
			$file_name=$this->input->post('name');
			$data['photo']=upload_file('photo',$upload_path,$allowed_types,$file_name.'_photo');
			if($data['photo']!=''){
				$result=$this->Member_model->updatephoto($data,$where);
				if($result===true){
					$this->session->set_flashdata("msg","Photo Updated successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
		}
		redirect('profile/');
	}
	

	public function updatepersonaldetails(){
		if($this->input->post('updatepersonaldetails')!==NULL){
			$data=$this->input->post();
		    if(!empty($data['aadhar']) || !empty($data['pan'])){
				$where1 =array();
				if(!empty($data['aadhar'])){
					$where1['aadhar'] = $data['aadhar'];
				}
				if(!empty($data['pan'])){
					$where1['pan'] = $data['pan'];
				}
				$rec = $this->db->get_where('tmp_members',$where1)->num_rows();
			}
			if($rec==0){
				$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updatepersonaldetails']);
			$result=$this->Member_model->updatepersonaldetails($data,$where);
			if($result===true){
				$this->session->set_flashdata("msg","Personal Details Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
			}else{
				$this->session->set_flashdata("msg","Already Exist");
			}
			
			
		}
		redirect('profile/');
	}
	
	public function updatecontactinfo(){
		if($this->input->post('updatecontactinfo')!==NULL){
			$data=$this->input->post();
			
			$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updatecontactinfo']);
			$result=$this->Member_model->updatecontactinfo($data,$where);
			if($result===true){
				$this->session->set_flashdata("msg","Contact Details Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('profile/');
	}
	
	public function updatenomineedetails(){
		if($this->input->post('updatenomineedetails')!==NULL){
			$data=$this->input->post();
			$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updatenomineedetails']);
			$result=$this->Member_model->updatenomineedetails($data,$where);
			if($result===true){
				$this->session->set_flashdata("msg","Nominee Details Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('profile/');
	}
	
	public function updateaccdetails(){
		if($this->input->post('updateaccdetails')!==NULL){
			$data=$this->input->post();
			$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updateaccdetails']);
			$result=$this->Member_model->updateaccdetails($data,$where);
			if($result===true){
				$this->session->set_flashdata("msg","Bank Details Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('profile/accdetails/');
	}
	

	public function checktrasnpass($trans_password){
		return $this->db->get_where('users',array('trasn_password'=>$trans_password))->num_rows();
	}

	public function payment(){
		// if($this->session->role=='member'){ redirect('/'); }
		$data['title']="Payment";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['transaction_image']=$this->transaction_image;
		$data['requests']=$this->Member_model->get_payment_list($regid);
		// echo PRE;
		// print_r($data['requests']);die;
		$this->template->load('profile','payment',$data);
	}

	public function payment_request(){
		$data['title']="Payment";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['datatable']=true;
		$data['transaction_image']=$this->transaction_image;
		$data['requests']=$this->Member_model->get_payment_request_list();
		// echo PRE;
		// print_r($data['requests']);die;
		$this->template->load('pages','payment_request',$data);
	}

	public function approved_payment(){
		$data['title']="Payment";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['datatable']=true;
		$data['transaction_image']=$this->transaction_image;
		$data['requests']=$this->Member_model->get_approvedpayment_request_list();
		// echo PRE;
		// print_r($data['requests']);die;
		$this->template->load('pages','approved_payment',$data);
	}

	public function requestepayment(){
		$data = $this->input->post();
		
		$upload_path="./assets/uploads/members/";
			$allowed_types="jpg|jpeg|png";
			$file_name=$this->input->post('name');
			$data['image']=upload_file('image',$upload_path,$allowed_types,$file_name.'_image');
			
			$result=$this->Member_model->insertpayment($data);
				if($result===true){
					$this->session->set_flashdata("msg","Payment Request Send successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
				redirect('profile/payment/');
	}

	public function deletepayment(){
		$id=$this->input->post('id');
		$rec=$this->Member_model->delete_payment($id);
		
		if($rec===true){
			$this->session->set_flashdata("msg","Delete successfully!");
		}
		else{
			$this->session->set_flashdata("err_msg","Something Error");
		}
		echo $rec;
		// echo json_encode($rec);
	}

	public function approve_data(){
		$id=$this->input->post('id');
		$rec=$this->Member_model->approve_id($id);
		
		if($rec===true){
			$this->session->set_flashdata("msg","Approve successfully!");
		}
		else{
			$this->session->set_flashdata("err_msg","Something Error");
		}
		echo $rec;
		// echo json_encode($rec);
	}

	public function approve_cancel(){
		$id=$this->input->post('id');
		$rec=$this->Member_model->approve_cancel_id($id);
		
		if($rec===true){
			$this->session->set_flashdata("msg","Approve Cancel!");
		}
		else{
			$this->session->set_flashdata("err_msg","Something Error");
		}
		echo $rec;
		// echo json_encode($rec);
	}

	public function uploaddocs(){
		if($this->input->post('uploaddocuments')!==NULL){
			$trans_password = $this->input->post('trans_password');
			if(!empty($trans_password)){
				$check = $this->checktrasnpass($trans_password);
				if($check>0){
					$where['regid']=$this->input->post('regid');
					$name=$this->input->post('name');
					$upload_path="./assets/uploads/documents/";
					$allowed_types="jpg|jpeg|png";
					$file_name=$name;
					$data['pan']=upload_file('pan',$upload_path,$allowed_types,$file_name.'_pan',10000);
					$data['aadhar1']=upload_file('aadhar1',$upload_path,$allowed_types,$file_name.'_aadhar1',10000);
					$data['aadhar2']=upload_file('aadhar2',$upload_path,$allowed_types,$file_name.'_aadhar2',10000);
					$data['cheque']=upload_file('cheque',$upload_path,$allowed_types,$file_name.'_cheque',10000);
					$data['receipt']=upload_file('receipt',$upload_path,$allowed_types,$file_name.'_receipt',10000);
					foreach($data as $key=>$value){
						if(empty($value)){ unset($data[$key]); }
					}
					if(!empty($data)){
						$result=$this->Member_model->updateaccdetails($data,$where);
						if($result===true){
							$this->session->set_flashdata("msg","Document successfully!");
						}
						else{
							$this->session->set_flashdata("err_msg",$result['message']);
						}
					}

				}else{
					$this->session->set_flashdata("err_msg","Your Trasncation Password is not Correct!");
				}
				

			}
			
		}
		redirect('profile/kyc/');
	}
	
}
