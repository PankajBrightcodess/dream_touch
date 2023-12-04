<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {
	// var $epin_status=false; //false : No E-pin; 1 : E-pin Required; 2 : E-pin Not Required
	// var $tree="position"; //false : No Tree; auto : Auto Position; position : Select Position; pool : Auto pool
	// var $acc_details=false; // Show account details in form
	// var $reject_kyc=true;
	// var $transaction_image=true;
	// var $reject_request=true;

	var $epin_status=false; //false : No E-pin; 1 : E-pin Required; 2 : E-pin Not Required
	var $tree=false; //false : No Tree; auto : Auto Position; position : Select Position; pool : Auto pool
	var $acc_details=false; // Show account details in form
	var $reject_kyc=true;
	
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		if($this->session->user===NULL){
			$this->register();
		}else{
			$this->registration();
		}
	}

	public function check()
	{
		$date=date('Y-m-d',strtotime('-2 day'));
		// echo PRE;
		// print_r($date);die;
		// $date=date('Y-m-d');
		$regid = $this->session->userdata('id');
		$rec = $this->Wallet_model->directsponsor($regid,$date);
		echo PRE;
		print_r($rec);die;
	}

	public function getwalletamount(){
		$wallet = $this->input->post('wallet');
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$wallet_amount = 0;
		if($wallet==1){
		    $wallet_amount=$this->Wallet_model->getwallet($regid);
			$wallet_amount =  $wallet_amount['actualwallet'];

		}elseif($wallet==2){
			$wallet_amount=$this->Wallet_model->getwallet_second($regid);
			$wallet_amount =  $wallet_amount['actualwallet'];
		}else{
			$wallet_amount =  0.00;
		}
		echo $wallet_amount;
	}

	public function levelincomedetails(){
		$id = $this->input->get();
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$date = $id['date'];
		$data = $this->db->get_where('level_income',array('regid'=>$regid))->result_array();
		// echo PRE;
		// print_r($data);die;
					$current_date = new DateTime($date);
					if(!empty($data)){
						$l = $totalamount = array();
						foreach ($data as $key => $value) {
							// echo PRE;
		// print_r($value);die;
							$amount = $this->Wallet_model->packageamount_bydate($value['child_member_id'],$date);
							
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
									$l['child_member_id'] = $value['child_member_id'];
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
						// echo PRE;
						// print_R($totalamount);die;
						$finalarray=$arr= array();
						if(!empty($totalamount)){
						   foreach ($totalamount as $key => $value) {
							$this->db->select('username,name');
							$arr =  $this->db->get_where('users',array('id'=>$value['child_member_id']))->result_array();
							$value['username'] = $arr[0]['username'];
							$value['name'] = $arr[0]['name'];
							$finalarray[] = $value;

						   }
						}
						// echo PRE;
						// print_R($finalarray);die;
						$data['rec'] = $finalarray;
						$data['title']="Level Payment Details";
						$data['datatable']=true;
						$this->template->load("members","levelincomedetails",$data);

						

						
						

					
						
					}
	}
	
	public function registration(){
		checklogin();
		$data['title']="Member Registration";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		
		$data['parent_id']='';
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->Member_model->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$optionss=array(""=>"Select State");
		$states=$this->Member_model->getstate();
		if(is_array($states)){
			foreach($states as $state){
				$optionss[$state['id']]=$state['name'];
			}
		}
		$data['banks']=$options;
		$data['states']=$optionss;
		$data['epin_status']=$this->epin_status;
		$data['tree']=$this->tree;
		$data['acc_details']=$this->acc_details;
		$this->template->load("members","registration",$data);
	}

	public function dist_list(){
		$data = $this->input->post();
		$dist=$this->Member_model->getdist($data);
		if(!empty($dist)){
			$option = "<option value=''>Select Dist</option>";
			foreach ($dist as $key => $value) {
				$option.= '<option value='.$value['id'].'>'.$value['name'].'</option>';
			}
		}
		echo $option;
	}
    	
	public function register(){
		$data['title']="Member Registration";
		$data['parent_id']='';
		$data['user']['username']='';
		$data['user']['id']='';
		$data['user']['name']='';
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->Member_model->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$optionss=array(""=>"Select State");
		$states=$this->Member_model->getstate();
		if(is_array($states)){
			foreach($states as $state){
				$optionss[$state['id']]=$state['name'];
			}
		}
		$data['banks']=$options;
		$data['states']=$optionss;
		$data['epin_status']=$this->epin_status;
		$data['tree']=$this->tree;
		$data['acc_details']=$this->acc_details;
        $this->load->view("includes/top-section",$data);
        $this->load->view("members/register");

		
        // $this->load->view("includes/bottom-section",$data);
	}
    
	public function registered(){
		if($this->session->flashdata('mname')===NULL){
			redirect('members/');
		}
		$data['title']="Registration Details";
		if($this->session->userdata('user')!==NULL){
			$data['breadcrumb']=array("/"=>"Home");
			$this->template->load('members','registered',$data);
		}
		else{
			$this->load->view("members/reg-top",$data);
			$this->load->view("members/registered");
			$this->load->view("members/reg-bottom");
		}
	}
	
	public function downline(){
		checklogin();
		$data['title']="Downline Member List";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$members=$this->Member_model->getallmembers($regid);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','memberlist',$data);
	}
	
	public function editmember($regid=NULL){
		checklogin();
		if($this->session->role!='admin' || $regid===NULL){ redirect('members/downline/'); }
		$data['title']="Edit Member";
		$data['breadcrumb']=array("/"=>"Home",'members/downline/'=>"Downline Members");
		$details=$this->Member_model->getalldetails($regid);
		$options=array(""=>"Select Bank");
		$banks=$this->Member_model->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$optionss=array(""=>"Select State");
		$states=$this->Member_model->getstate();
		if(is_array($states)){
			foreach($states as $state){
				$optionss[$state['id']]=$state['name'];
			}
		}
		$data['banks']=$options;
		$data['states']=$optionss;
		$data['details']=$details;
		$this->template->load('members','editmember',$data);
	}
	public function sponsor_register(){
		$data['title']="Member Registration";
		$data['parent_id']='';
		$data['user']['username']='';
		$data['user']['id']='';
		$data['user']['name']='';
		if(isset($_GET['sponsor'])){
			$id=$_GET['sponsor'];
			$data['user']=$this->Account_model->getuser(array("md5(id)"=>$id));
		}
		// echo PRE;
		// print_r($data['user']);die;
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->Member_model->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		$packages=$this->Package_model->getpackage(array("status"=>1));
		$options=array(""=>"Select Package");
		$package_price=array();
		if(is_array($packages)){
			foreach($packages as $package){
				$options[$package['id']]=$package['package'].' (Rs. '.$package['amount'].')';
				$package_price[$package['id']]=$package['amount'];
			}
		}
		$data['packages']=$options;
		$data['package_price']=json_encode($package_price);
		// echo PRE;
		// print_r($data['packages']);
		$data['epin_status']=$this->epin_status;
		$data['tree']=$this->tree;
		$data['acc_details']=$this->acc_details;
        $this->load->view("includes/top-section",$data);
        $this->load->view("members/registerdata",$data);
	}
	
	public function mydirects(){
		checklogin();
		if($this->session->role=='admin'){
			redirect('members/downline/');
		}
		$data['title']="Direct Sponsors";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$members=$this->Member_model->getdirectmembers($regid);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','memberlist',$data);
	}


	// public function upgrade_ides(){
	// 	checklogin();
	// 	$data['title']="Upgrade Level";
	// 	$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
	// 		$regid=$data['user']['id'];
	// 	$data['requests']=$this->Member_model->getupgradeid(array("t1.regid"=>$regid));
	// 	$options=array(""=>"Select Level","Sun"=>"Sun Level","Gold"=>"Gold Level","Platinum"=>"Platinum Level","Ruby"=>"Ruby Level","Diamond"=>"Diamond Level","White Diamond"=>"White Diamond Level");
	// 	$data['level']=$options;
	// 	$data['transaction_image']=$this->transaction_image;
		
	// }
	public function upgrade_ides(){
		checklogin();
		$data['title']="Upgrade ID";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		
		$data['parent_id']='';
		$packages=$this->Package_model->getpackage(array("status"=>1));
		// echo PRE;
		// print_r($packages);die;
		$options=array(""=>"Select Package");
		$package_price=array();
		if(is_array($packages)){
			foreach($packages as $package){
				$options[$package['id']]=$package['package'].' ('.$package['amount'].'Rs.)';
				    $package_price[$package['id']]=$package['amount'];
			}
		}
		$data['packages']=$options;
		$upgradeidlist=$this->Member_model->getupgradelist();
		$data['upgradelist']=$upgradeidlist;
		$data['package_price']=json_encode($package_price);
		$this->template->load('members','upgradeides',$data);
	}

	public function upgrademember(){
		$data=$this->input->post();
		$res = $this->Member_model->upgrade_id($data);
		if($res){
			$this->session->set_flashdata("msg","ID Upgrade successfully!");
			
		}else{
			$this->session->set_flashdata("err_msg","Something Error!");
		}
		redirect('upgrade-ides');
	}
	public function trip_reward(){
		$data=$this->input->post();
		$res = $this->Member_model->trip_rewards($data);
		if($res){
			$this->session->set_flashdata("msg","ID Upgrade successfully!");
			
		}else{
			$this->session->set_flashdata("err_msg","Something Error!");
		}
		redirect('upgrade-ides');
	}
	public function requestelevel(){
		if($this->input->post('requestelevel')!==NULL){
			$data=$this->input->post();
			unset($data['requestelevel']);
			$name=$this->input->post('name');
			unset($data['name']);
			if($this->transaction_image){
				$upload_path="./assets/uploads/receipt/";
				$allowed_types="jpg|jpeg|png";
				$data['image']=upload_file('image',$upload_path,$allowed_types,$name.'_receipt');
				if($data['image']==''){
					$this->session->set_flashdata("err_msg","Error Uploading Image! Please Try Again!");
					redirect('upgrade-ides');
				}
			}
			$result=$this->Member_model->requesteupgradeides($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg","Level Request Submitted successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['err']['message']);
			}
		}
		redirect('upgrade-ides');
	}

	public function payout_list(){
		if($this->session->role=='admin'){
			$data['title']="Payoutlist";
		    $data['payout_list']=$this->Member_model->payoutlist();
		    $data['datatable']=true;
		    $this->template->load('pages','payoutlist',$data);
		}
	}

	public function payout_list_details_all(){
		$type = $this->input->post('type');
		$where = array();
		if($type==1){
			$where['t1.remarks'] = 'Monthly Income';
		}elseif($type==2){
			$where['t1.remarks'] = 'Direct Sponsor Income';
		}elseif($type==3){
			$where['t1.remarks'] = 'Level Income';
		}
		
		$date = date('Y-m-d');
		if($date<=date('Y-m-10')){
			$where['t1.date<='] = date('Y-m-31', strtotime('-1 month'));
			$where['t1.date>='] = date('Y-m-21', strtotime('-1 month'));
		}elseif($date>=date('Y-m-10') && $date<=date('Y-m-20')){
			$where['t1.date<='] = date('Y-m-10');
			$where['t1.date>='] = date('Y-m-01');
		}elseif($date>=date('Y-m-20') && $date<=date('Y-m-31')){
			$where['t1.date<='] = date('Y-m-20');
			$where['t1.date>='] = date('Y-m-11');
		}
		
		$data = $this->Member_model->sepratepaylist($where);
		$html = '';
		if(!empty($data)){
			
			$i=0;
			$amount = 0;
			foreach ($data as $key => $value) {
				++$i;
				$html.= '<tr>';   
                $html.= '<th>'.$i.'</th>';                                        
                $html.= '<th>'.$value['name'].'</th>';                                        
                $html.= '<th>'.$value['username'].'</th>';                                        
                $html.= '<th>'.date('d-m-Y',strtotime($value['date'])).'</th>';
                $html.= '<th>'.$value['remarks'].'</th>';                       
                $html.= '<th><i class="fa fa-inr"  aria-hidden="true"></i>'.$value['amount'].'</th>';
                $html.= '</tr>';
                $amount = $amount+$value['amount'];

			}
				$html.= '<tr>';   
                $html.= '<th colspan="5"></th>';                        
                $html.= '<th><h5 class="text-bold text-success"><i class="fa fa-inr"  aria-hidden="true"></i>'.$amount.'/-</h5></th>';
                $html.= '</tr>';
			
		}else{
				$html.= "<tr>";   
                $html.= "<th colspan='4' class='text-center'>No Data Found</th>";
                $html.= "</tr>";
		}
		echo $html;
		
	}

	public function payout_list_print_all(){
		$type = $this->input->get('type');
		$where = array();
		if($type==1){
			$where['t1.remarks'] = 'Monthly Income';
		}elseif($type==2){
			$where['t1.remarks'] = 'Direct Sponsor Income';
		}elseif($type==3){
			$where['t1.remarks'] = 'Level Income';
		}
		
		
		$date = date('Y-m-d');
		if($date<=date('Y-m-10')){
			$where['t1.date<='] = date('Y-m-31', strtotime('-1 month'));
			$where['t1.date>='] = date('Y-m-21', strtotime('-1 month'));
		}elseif($date>=date('Y-m-10') && $date<=date('Y-m-20')){
			$where['t1.date<='] = date('Y-m-10');
			$where['t1.date>='] = date('Y-m-01');
		}elseif($date>=date('Y-m-20') && $date<=date('Y-m-31')){
			$where['t1.date<='] = date('Y-m-20');
			$where['t1.date>='] = date('Y-m-11');
		}
		
		$data = $this->Member_model->sepratepaylist($where);
		if(!empty($data)){
			$i=0;
			$pdf = $this->customfpdf->getInstance();$pdf->AliasNbPages();
			$pdf->AddPage();
			 $pdf->Header('Arial');
			$pdf->SetFont('Times','',25);
		   // $row=file('toys.txt');
			   
		   // $pdf->Image("img/logCopy.png",90,10,20,0,"");
		   $pdf->SetFont('Arial','B',15);
		   // $pdf->Cell(190,25,'',0,1,'C');
		   $pdf->SetFont('Arial','B',11);
		   $pdf->Cell(190,7,'GLOBAL FORAX',1,1,'C');
		   $pdf->SetFont('Arial','B',10);
		   $pdf->Cell(190,5,'Payout List Details',1,1,'C');
		   $pdf->SetFont('Arial','B',10);

		   $pdf->Cell(17,5,'Sl. No.',1,0,'C');
		   $pdf->Cell(30,5,'Name',1,0,'C');
		   $pdf->Cell(30,5,'Username',1,0,'C');
		   $pdf->Cell(30,5,'Date',1,0,'C');
		   $pdf->Cell(53,5,'Type',1,0,'C');
		   $pdf->Cell(30,5,'Amount',1,1,'C');

		   $pdf->SetFont('Arial','',10);
		   $amount = 0;
		   foreach ($data as $key => $value) {
			   $i++;
			   $pdf->Cell(17,5,$i,1,0,'C');
			   $pdf->Cell(30,5,$value['name'],1,0,'C');
			   $pdf->Cell(30,5,$value['username'],1,0,'C');
			   $pdf->Cell(30,5,date('d-m-Y',strtotime($value['date'])),1,0,'C');
			   $pdf->Cell(53,5,$value['remarks'],1,0,'C');
			   $pdf->Cell(30,5,$value['amount'],1,1,'C');
			   $amount = $amount+$value['amount'];
		   }
		   
		   $pdf->Cell(160,5,'',1,0,'C');
		   $pdf->Cell(30,5,$amount.'/-',1,1,'C');




		   $pdf->Output();
			}else{
			$pdf = $this->customfpdf->getInstance();
			$pdf->AliasNbPages();
			$pdf->AddPage();
				$pdf->Header('Arial');
			$pdf->SetFont('Times','',25);
			// $row=file('toys.txt');
				
			// $pdf->Image("img/logCopy.png",90,10,20,0,"");
			$pdf->SetFont('Arial','B',15);
			// $pdf->Cell(190,25,'',0,1,'C');
			
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(190,7,'GLOBAL FORAX',1,1,'C');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(190,5,'No Data Found',1,1,'C');
			$pdf->SetFont('Arial','B',10);
			$pdf->Output();

			}
			}

	public function payout_list_print(){
		if($this->session->role=='admin'){
			$regid = $this->input->get('regid');

			$data = $this->Member_model->payoutlist_byid($regid);
		  if(!empty($data)){
		  	$i=0;
		  	$pdf = $this->customfpdf->getInstance();
		     		$pdf->AliasNbPages();
		     		$pdf->AddPage();
		      		$pdf->Header('Arial');
		     		$pdf->SetFont('Times','',25);
					// $row=file('toys.txt');
					    
					// $pdf->Image("img/logCopy.png",90,10,20,0,"");
					$pdf->SetFont('Arial','B',15);
					// $pdf->Cell(190,25,'',0,1,'C');
					$pdf->SetFont('Arial','B',11);
					$pdf->Cell(190,7,'GLOBAL FORAX',1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(190,5,'Payout List Details',1,1,'C');
					$pdf->SetFont('Arial','B',10);

					$pdf->Cell(17,5,'Sl. No.',1,0,'C');
					$pdf->Cell(28,5,'Date',1,0,'C');
					$pdf->Cell(97,5,'Type',1,0,'C');
					$pdf->Cell(48,5,'Amount',1,1,'C');

					$pdf->SetFont('Arial','',10);
					$amount = 0;
					foreach ($data as $key => $value) {
						$i++;
						$pdf->Cell(17,5,$i,1,0,'C');
						$pdf->Cell(28,5,date('d-m-Y',strtotime($value['date'])),1,0,'C');
						$pdf->Cell(97,5,$value['remarks'],1,0,'C');
						$pdf->Cell(48,5,$value['amount'],1,1,'C');
						$amount = $amount+$value['amount'];
					}
					
					$pdf->Cell(142,5,'',1,0,'C');
					$pdf->Cell(48,5,$amount.'/-',1,1,'C');




					$pdf->Output();
		  }else{
			$pdf = $this->customfpdf->getInstance();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			 $pdf->Header('Arial');
			$pdf->SetFont('Times','',25);
		   // $row=file('toys.txt');
			   
		   // $pdf->Image("img/logCopy.png",90,10,20,0,"");
		   $pdf->SetFont('Arial','B',15);
		   // $pdf->Cell(190,25,'',0,1,'C');
		   
		   $pdf->SetFont('Arial','B',11);
		   $pdf->Cell(190,7,'GLOBAL FORAX',1,1,'C');
		   $pdf->SetFont('Arial','B',10);
		   $pdf->Cell(190,5,'No Data Found',1,1,'C');
		   $pdf->SetFont('Arial','B',10);
		   $pdf->Output();

		  }
		}
	}

	public function payout_list_details(){
		$regid = $this->input->post('regid');
		$data['datatable']=true;
		$data = $this->Member_model->payoutlist_byid($regid);
		$html = '';
		if(!empty($data)){
			
			$i=0;
			$amount = 0;
			foreach ($data as $key => $value) {
				++$i;
				$html.= '<tr>';   
                $html.= '<th>'.$i.'</th>';                                        
                $html.= '<th>'.date('d-m-Y',strtotime($value['date'])).'</th>';
                $html.= '<th>'.$value['remarks'].'</th>';                       
                $html.= '<th style="color: #d1dbe6!important;"><i class="fa fa-inr"  aria-hidden="true"></i>'.$value['amount'].'</th>';
                $html.= '</tr>';
                $amount = $amount+$value['amount'];

			}
				$html.= '<tr>';   
                $html.= '<th colspan="3"></th>';                        
                $html.= '<th><h5 class="text-bold text-success"><i class="fa fa-inr"  aria-hidden="true"></i>'.$amount.'/-</h5></th>';
                $html.= '</tr>';
			
		}else{
				$html.= "<tr>";   
                $html.= "<th colspan='4' class='text-center'>No Data Found</th>";
                $html.= "</tr>";
		}
		echo $html;
		
	}

	public function upgradeid_request(){
		checklogin();
		$data['title']="Upgrade ID Request";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['requests']=$this->Member_model->getupgradeid(array("t1.status"=>1));
		$this->template->load('members','upgradeidesrequest',$data);
	}

	public function tripreward(){
		checklogin();
		$data['title']="Trip reward";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$options=array(""=>"Select Trip","3"=>"Goa Self","5"=>"Thailand Self","10"=>"Dubai Self");
		// $package_price=array();
		// if(is_array($packages)){
		// 	foreach($packages as $package){
		// 		$options[$package['id']]=$package['package'].' ('.$package['amount'].'Rs.)';
		// 		    $package_price[$package['id']]=$package['amount'];
		// 	}
		// }
		$data['packages']=$options;
		$data['requests']=$this->Member_model->getupgradeid(array("t1.status"=>1));
		$this->template->load('members','tripreward',$data);
	}

	public function gift_income(){
		checklogin();
		$data['title']="Gift Income";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		// $data['requests']=$this->Member_model->getupgradeid(array("t1.status"=>1));
		$this->template->load('members','gift_income',$data);
	}

	public function award_income(){
		checklogin();
		$data['title']="Award Income";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		// $data['requests']=$this->Member_model->getupgradeid(array("t1.status"=>1));
		$this->template->load('members','award_income',$data);
	}
	public function tour_travel(){
		checklogin();
		$data['title']="Tour & Travel Income";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		// $data['requests']=$this->Member_model->getupgradeid(array("t1.status"=>1));
		$this->template->load('members','tour_travel',$data);
	}
	

	public function approved_upgradeid(){
		checklogin();
		$data['title']="Upgrade ID Request";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
		$data['requests']=$this->Member_model->getupgradeid(array("t1.status"=>2));
		$this->template->load('members','upgradeidesapproved',$data);
	}

	public function levelrequestdetails($id=NULL){
		checklogin();
		if($this->session->role!='admin'){ redirect('/'); }
		
		if($id===NULL){ redirect('upgradeid-request'); }
		
		$data['title']="E-Pin Request Details";
		$data['breadcrumb']=array("/"=>"Home",""=>"Level");
		$data['user']['name']='admin';
		$data['user']['photo']='assets/images/blank.png';
		$where['t1.status']="1";
		$where['t1.id']=$id;
		$details=$this->Member_model->getlevelrequests($where,"single");
		$data['details']=$details;
		// echo PRE;
		// print_r($data['details']);die;
		if(empty($details)){  redirect('upgradeid-request'); }
		
		$data['transaction_image']=$this->transaction_image;
		$data['reject_request']=$this->reject_request;
		$this->template->load('members','levelrequestdetails',$data);
	}

	public function approvelevel(){
		if($this->input->post('approvelevel')!==NULL){
			$data=$this->input->post();
			if($data['approvelevel']=='Approve'){
				$id=$data['id'];
				unset($data['id']);
				unset($data['approvelevel']);
				if(!empty($id)){
					$this->Member_model->updaterequestlevel($id);
					$this->session->set_flashdata("msg","Level Activated successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
			else{
				$id=$data['id'];
				$this->Epin_model->updaterequest($id,3);
				$this->session->set_flashdata("msg","Level Request Rejected!");
			}
		}
		if($this->session->role=='admin'){
			redirect('upgradeid-request');
		}
		redirect('upgradeid-request');
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
	
		
	// public function treeview(){
	// 	checklogin();
	// 	$data['title']="Tree View";
	// 	$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
	// 	$regid=$data['user']['id'];
    //     if($regid>1){
    //         $details=$this->Member_model->getmemberdetails($regid);
    //         $data['user']['photo']=$details['photo'];
    //     }
    //     else{
    //         $data['user']['photo']=file_url("assets/images/male.png");
    //     }
	// 	$regids=generateTree($data['user']['id']);
	// 	$data['packages']=$this->Package_model->getpackage(array("status"=>1));
	// 	$data['tree']=createTree($regids);
	// 	$this->template->load('members','tree',$data);
	// }
	public function treeview(){
		checklogin();
		$data['datatable']=true;
		$data['title']="Downline Active Member List";
		$this->template->load('members','treeviewlist',$data);
	}

	public function treelistshow(){
		$regid = $this->input->post('regid');
		
		if(empty($regid)){
			$rec=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
			$regid=$rec['id'];
		}
		$members=$this->Member_model->getallmembersbytree($regid);
	 	echo json_encode($members);
	}

	

	
	
	public function kyc(){
		checklogin();
		$data['title']="Member KYC Requests";
		$data['breadcrumb']=array("/"=>"Home");
		$members=$this->Member_model->kyclist();
		$data['members']=$members;
		$data['datatable']=true;
		$data['reject_kyc']=$this->reject_kyc;
		$this->template->load('members','kyclist',$data);
	}
	
	public function approvedkyc(){
		checklogin();
		$data['title']="Approved Member KYC";
		$data['breadcrumb']=array("/"=>"Home");
		$members=$this->Member_model->kyclist(1);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','kyclist',$data);
	}

	public function check_dob($dob){
		$today = new DateTime();
		$birthdate = new DateTime($dob);
		$age = $birthdate->diff($today)->y;
		return $age;
	}
	
	public function addmember(){
		if($this->input->post('addmember')!==NULL){
			$data=$this->input->post();
			$userdata=$memberdata=$accountdata=$treedata=array();
			$check =$this->Member_model->check_mobile($data['mobile']);
			$check_email =$this->Member_model->check_email($data['email']);
			$dobcheck = $this->check_dob($data['dob']);
			
			if($data['refid']>0 && $check==0 && $check_email==0 && $dobcheck>=18){
				$userdata['mobile']=$data['mobile'];
				$userdata['name']=$data['name'];
				$userdata['email']=$data['email'];
				$userdata['role']="member";
				$userdata['status']="1";
				
				if(isset($data['epin'])){
					$memberdata['epin']=$data['epin'];
				}
				$memberdata['name']=$data['name'];
				$memberdata['dob']=$data['dob'];
				$memberdata['father']=$data['father'];
				$memberdata['gender']=$data['gender'];
				$memberdata['mstatus']=$data['mstatus'];
				$memberdata['mobile']=$data['mobile'];
				$memberdata['email']=$data['email'];
				$memberdata['aadhar']=$data['aadhar'];
				$memberdata['pan']=$data['pan'];
				$memberdata['address']=$data['address'];
				$memberdata['district']=$data['district'];
				$memberdata['state']=$data['state'];
				$memberdata['pincode']=$data['pincode'];
				$memberdata['refid']=$data['refid'];
				$memberdata['date']=$data['date'];
				$memberdata['time']=date('H:i:s');
				$memberdata['status']=0;
				
				$upload_path="./assets/uploads/members/";
				$allowed_types="jpg|jpeg|png";
				$file_name=$data['name'];
				$memberdata['photo']=upload_file('photo',$upload_path,$allowed_types,$file_name.'_photo');
				
				$accountdata['bank']=$data['bank'];
				$accountdata['branch']=$data['branch'];
				$accountdata['city']=$data['city'];
				$accountdata['account_no']=$data['account_no'];
				$accountdata['account_name']=$data['account_name'];
				$accountdata['ifsc']=$data['ifsc'];
				$emailset['emailset']=$memberdata['email'];
				$this->session->set_userdata($emailset);
				if($this->tree=='position'){
					$treedata['parent_id']=$this->Member_model->findleaf($data['refid'],$data['position']);
					$treedata['position']=$data['position'];
				}
				else{
					$treedata=$this->tree;
				}
				$data=array("userdata"=>$userdata,"memberdata"=>$memberdata,"accountdata"=>$accountdata,"treedata"=>$treedata);
				$result=$this->Member_model->addmember($data);
				
				if($result['status']===true){
					$message = "Welcome $memberdata[name]! Thank you for joining ".PROJECT_NAME."! Your UserID is $result[username] and Password is $result[password] ";
					$message.= "Visit our site ".str_replace('members.','',base_url()).".";
					//$smsdata=array("mobile"=>$memberdata['mobile'],"message"=>$message);
					$email = $_SESSION['emailset'];
					unset($_SESSION['emailset']);
					mail($email,PROJECT_NAME,$message);
					
					
					// send_sms($smsdata);
					$flash=array("mname"=>$memberdata['name'],"uname"=>$result['username'],"pass"=>$result['password']);
					$this->session->set_flashdata($flash);
					$this->session->set_flashdata("msg","Member Added successfully!");
					redirect('members/registered/');
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
			else{
				$this->session->set_flashdata("err_msg","MobileNo Or Email is already registered! OR Your DOB is Below in 18+");
			}
		}
		redirect('members/');
	}

	// public function checkdetails($mobile,$email,$regid){
    //      $this->db->get_where('users',array('id!='=>$regid))
	// }
	
	public function updatemember(){
		if($this->input->post('updatemember')!==NULL){
			$data=$this->input->post();

			// $check =  $this->checkdetails($data['mobile'],$data['email'],$data['regid']);
			// echo PRE;
			// print_r($check);die;
			$regid=$data['regid'];
			$userdata=$memberdata=$accountdata=$treedata=array();
			
			if(isset($data['name'])){ 
				$userdata['mobile']=$data['mobile'];
				$userdata['name']=$data['name'];
				$userdata['email']=$data['email'];
				
				$memberdata['name']=$data['name'];
				$memberdata['dob']=$data['dob'];
				$memberdata['father']=$data['father'];
				$memberdata['gender']=$data['gender'];
				// $memberdata['mstatus']=$data['mstatus'];
				$memberdata['mobile']=$data['mobile'];
				$memberdata['email']=$data['email'];
				// $memberdata['aadhar']=$data['aadhar'];
				// $memberdata['pan']=$data['pan'];
				$memberdata['address']=$data['address'];
				$memberdata['district']=$data['district'];
				$memberdata['state']=$data['state'];
				// $memberdata['country']=$data['country'];
				// $memberdata['pincode']=$data['pincode'];
			}
			if(isset($data['bank'])){
				$accountdata['bank']=$data['bank'];
				$accountdata['branch']=$data['branch'];
				$accountdata['city']=$data['city'];
				$accountdata['account_no']=$data['account_no'];
				$accountdata['account_name']=$data['account_name'];
				$accountdata['ifsc']=$data['ifsc'];
			}
			$data=array("userdata"=>$userdata,"memberdata"=>$memberdata,"accountdata"=>$accountdata);
			
			
			$result=$this->Member_model->updatemember($data,$regid);
			if($result===true){
				$this->session->set_flashdata("msg","Member Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg","Member Not Updated!");
			}
		}
		redirect('members/downline/');
	}
		
	public function updatedocs(){
		if($this->input->post('updatedocs')!==NULL){
			$where['regid']=$this->input->post('regid');
			$name=$this->input->post('name');
			$upload_path="./assets/uploads/documents/";
			$allowed_types="jpg|jpeg|png";
			$file_name=$name;
			$data['pan']=upload_file('pan',$upload_path,$allowed_types,$file_name.'_pan',10000);
			$data['aadhar1']=upload_file('aadhar1',$upload_path,$allowed_types,$file_name.'_aadhar1',10000);
			$data['aadhar2']=upload_file('aadhar2',$upload_path,$allowed_types,$file_name.'_aadhar2',10000);
			$data['cheque']=upload_file('cheque',$upload_path,$allowed_types,$file_name.'_cheque',10000);
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
		}
		redirect('members/downline/');
	}
    
	public function activatemember(){
		if($this->input->post('activatemember')!==NULL){
			$data=$this->input->post();
			unset($data['activatemember']);
			$result=$this->Member_model->activatemember($data);
			if($result===true){
				$memberdata=$this->Account_model->getuser(array("id"=>$data['regid']));
				$message="Hi $memberdata[name]! Your ID has been successfully activated! ";
				$message.= "Visit our site ".str_replace('members.','',base_url()).".";
				$smsdata=array("mobile"=>$memberdata['mobile'],"message"=>$message);
				send_sms($smsdata);
				$this->session->set_flashdata("msg","Member Activated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('epins/unused/');
	}
	
	public function approvekyc(){
		if($this->input->post('kyc')!==NULL){
			$data['kyc']=$this->input->post('kyc');
			$where['regid']=$this->input->post('regid');
			$result=$this->Member_model->approvekyc($data,$where);
			if($result===true){
				if($data['kyc']==3){ $status="Rejected"; }
				elseif($data['kyc']==1){ $status="Approved"; }
				$this->session->set_flashdata("msg","Member KYC $status!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('members/kyc/');
	}
	
	public function getrefid(){
		$username=$this->input->post('username');
		$status=$this->input->post('status');
		$member=$this->Member_model->getmemberid($username,$status);
        
		echo json_encode($member);
	}
	
	public function getpopupdetails(){
		$regid=$this->input->post('regid');
		$array=$this->Member_model->getpopupdetails($regid);
		echo json_encode($array);
	}
	
	public function gettree(){
		$regid=$this->input->post('regid');
		if((int)$regid==0){
			$where['username']=str_replace('a','',$regid);
			$array=$this->Account_model->getuser($where);
			$regid=$array['id'];
			$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
			$user_id=$data['user']['id'];
			$members=$this->Member_model->getallmembers($user_id,array(),"array");
			if(array_search($regid,$members)===false){
				$regid='';
			}
		}
		if($regid!=''){
			$regids=generateTree($regid);
			$tree=createTree($regids);
			echo $tree;
		}
		else{
			echo "invalid";
		}
	}
	
	public function getmemberid(){
		$username=$this->input->post('username');
		$status=$this->input->post('status');
		$member=$this->Member_model->getmemberid($username,$status);
		echo json_encode($member);
	}
	
	/*public function upgrade(){
		checklogin();
		if($this->session->role=='admin'){
			redirect('members/downline/');
		}
		$data['title']="Upgrade";
		$data['user']=$this->Account_model->getuser(array("md5(id)"=>$this->session->userdata('user')));
		$regid=$data['user']['id'];
        $memberdetails=$this->Member_model->getmemberdetails($regid);
        if($memberdetails['upgrade']==1){
			redirect('/');
            
        }
		$options=array(""=>"Select Bank");
		$banks=$this->Member_model->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
        $data['upgrade']=$this->Member_model->getupgraderequests(array("regid"=>$regid),"single");
		$this->template->load('members','request',$data);
	}
	
	public function upgraderequests(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Upgrade Request List";
		$data['breadcrumb']=array("/"=>"Home");
		$members=$this->Member_model->getupgraderequests(array("t1.status"=>"0"));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','requestlist',$data);
	}
	
    public function requestupgrade(){
		if($this->input->post('requestupgrade')!==NULL){
			$data=$this->input->post();
			unset($data['requestupgrade'],$data['paid_amount']);
			$result=$this->Member_model->requestupgrade($data);
			if($result===true){
				$this->session->set_flashdata("msg","Upgrade Request Saved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('members/upgrade/');
    }
    
	public function approveupgrade(){
        $request_id=$this->input->post('request_id');
        $result=$this->Member_model->approveupgrade($request_id);
        if($result===true){
            $this->session->set_flashdata("msg","Member Upgraded successfully!");
        }
        else{
            $this->session->set_flashdata("err_msg",$result['message']);
        }
    }
    */

    // ''''''''''''''''''''''''''''''''''''''PANKAJ MNAI TIWARI'''''''''''''''''''''''''''''''''''''''''''''''''''''''
   

	public function reward_days(){
		checklogin();
		if($this->session->role=='admin'){
			$data['title']="Reward Days Create";
		    $data['list']=$this->Member_model->get_reward_day_list();
		    $data['datatable']=true;
		    $this->template->load('pages','reward_days_master',$data);
		}
	}


	public function reward_days_submit(){
		$data = $this->input->post();
		$data['added_on']=date('Y-m-d');
		$rec=$this->Member_model->reward_days_save($data);
		if($rec===true){
					$this->session->set_flashdata("msg","Document successfully Submitted!");
				}
				else{
					$this->session->set_flashdata("err_msg",$rec['message']);
				}
			redirect('reward-days');
	}

	public function reward_master_update(){
		$data = $this->input->post();
		$rec=$this->Member_model->reward_days_update($data);
		if($rec===true){
					$this->session->set_flashdata("msg","Document successfully Updated!");
				}
				else{
					$this->session->set_flashdata("err_msg",$rec['message']);
				}
			redirect('reward-days');
	}

	public function reward_master_delete(){
		$id=$this->input->post('id');
		$rec=$this->Member_model->reward_days_delete($id);
		echo json_encode($rec);
	}


	public function reward60_master(){
		checklogin();
		if($this->session->role=='admin'){
			$data['title']="Reward Master";
		    $data['list']=$this->Member_model->get_reward_day_list();
		    $data['datatable']=true;
		    $this->template->load('pages','reward_master',$data);
		}	
	}

	public function reward_master_submit(){
		$data = $this->input->post();
		$data['added_on']=date('Y-m-d');
		$rec = $this->Member_model->reward_submit($data);
		if($rec===true){
			$this->session->set_flashdata("msg","Document successfully Submitted!");
		}
		else{
			$this->session->set_flashdata("err_msg",$rec['message']);
		}
		redirect('reward-master');
	}

	public function rewardbonus(){
		$record=$this->Wallet_model->rewardbonus(20);
		print_r($record);die;
	}

	public function product_master(){
		checklogin();
		if($this->session->role=='admin'){
			$data['title']="Product Master";
		    $data['product_list']=$this->Member_model->get_product_master_list();
		    $data['datatable']=true;
		    $this->template->load('pages','product_master',$data);
		}	
	}



	public function product_master_submit(){
		$data = $this->input->post();
		$data['added_on']= date('Y-m-d');
		$rec = $this->Member_model->product_master_submit($data);
		if($rec===true){
			$this->session->set_flashdata("msg","Product Successfully Submitted!");
		}
		else{
			$this->session->set_flashdata("err_msg",$rec['message']);
		}
		redirect('product-master');
		
	}

	public function product_master_update(){
		$data = $this->input->post();
		$rec = $this->Member_model->product_master_update($data);
		if($rec===true){
			$this->session->set_flashdata("msg","Document successfully Updated!");
		}
		else{
			$this->session->set_flashdata("err_msg",$rec['message']);
		}
		redirect('product-master');
	}

	public function product_master_delete()
	{
		$id=$this->input->post('id');

		$rec=$this->Member_model->product_master_delete($id);
		echo json_encode($rec);
	}
	public function purchase_delete()
	{
		$data=$this->input->post();
		$rec=$this->Member_model->purchase_delete_model($data);
		echo json_encode($rec);
	}

	public function purchase(){
		checklogin();
		if($this->session->role=='member'){
			$data['title']="Purchase";
		    $data['product_list']=$this->Member_model->get_product_master_list();
		    $data['purchase_list']=$this->Member_model->get_product_purchase_list();
		    $regid = $this->session->userdata('id');
		    $data['wallet']=$this->Wallet_model->getwallet($regid);
		   
		    $data['datatable']=true;
		    $this->template->load('pages','purchase',$data);
		}
	}




	

	public function product_list_details(){
		$id = $this->input->post('prod_id');
		$record = $this->Member_model->get_purchase_list($id);
		echo json_encode($record);
	}

	public function approvepurchase(){
		$data = $this->input->post();
		$record = $this->Member_model->purcahse_status_update($data);
		if($record===true){
			$this->session->set_flashdata("msg","Approve Successfully!");
		}
		else{
			$this->session->set_flashdata("msg","Approve Successfully!");
			// $this->session->set_flashdata("err_msg",'Something Error');
		}
		redirect('home/purchase_request_list');
	}

	public function rejectpurchase(){
		$data = $this->input->post();
		$record = $this->Member_model->purcahse_status_reject($data);
		if($record===true){
			$this->session->set_flashdata("msg","Approve Cancel!");
		}
		else{
			$this->session->set_flashdata("msg","Approve Cancel!");
			// $this->session->set_flashdata("err_msg",'Something Error');
		}
		redirect('home/purchase_request_list');
	}

	public function purchase_submit(){
		$data = $this->input->post();
		$upload_path="./assets/uploads/purchase/";
		$allowed_types="jpg|jpeg|png";
		$data['purchase_screen_shot']=upload_file('photo',$upload_path,$allowed_types,time().'_photo');
		$data['bv'] = $data['quantity']*$data['bv'];
		$data['member_id'] = $_SESSION['id'];
		$data['added_on'] = date('Y-m-d');

		$record = $this->Member_model->purcahse_save($data);
		if($record===true){
			$this->session->set_flashdata("msg","Purchase successfully Submitted!");
		}
		else{
			$this->session->set_flashdata("err_msg",'Something Error');
		}
		redirect('purchase');
	}

	public function invoicegenerate(){
		$id = $this->uri->segment(3);
		if(!empty($id)){
			$data = $this->Member_model->get_purchase_print($id);
			// echo '<pre>';
			// print_r($data);die;
			if(!empty($data)){
					$pdf = $this->customfpdf->getInstance();
		     		$pdf->AliasNbPages();
		     		$pdf->AddPage();
		      		$pdf->Header('Arial');
		     		$pdf->SetFont('Times','',25);
					// $row=file('toys.txt');
					    
					// $pdf->Image("img/logCopy.png",90,10,20,0,"");
					$pdf->SetFont('Arial','B',15);
					// $pdf->Cell(190,25,'',0,1,'C');
					$pdf->Cell(190,10,'I Mark ',1,1,'C');
					$pdf->SetFont('Arial','B',13);
					$pdf->Cell(190,8,'Invoice',1,1,'C');
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(190,5,'Contact No. : +91-0000000000, Email Id : imark@gmail.com',1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(190,5,'',1,1,'L');
					$pdf->Cell(190,5,'Member Details',1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(95,5,'Member Id :',1,0,'C');
					 $pdf->SetFont('Arial','',10);
					$pdf->Cell(95,5,$data['username'],1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(95,5,'Member Name :',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(95,5,$data['name'],1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(95,5,'Contact No. :',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(95,5,$data['mobile'],1,1,'C');
					$pdf->Cell(190,5,'',1,1,'L');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(190,5,'Purchase Details',1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(45,5,'Date',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(50,5,date('d-m-Y', strtotime($data['added_on'])),1,0,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(45,5,'Invoice No.:',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(50,5,'#IM-'.$data['id'],1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(95,5,'Product Name :',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(95,5,$data['product_name'],1,1,'C'); 
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(95,5,'Quantity:',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(95,5,$data['quantity'],1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(95,5,'Price :',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(95,5,$data['price'].'/-',1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(95,5,'BV :',1,0,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(95,5,$data['bv'],1,1,'C');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(190,10,'Recived By :',1,1,'L');  
					$pdf->Cell(190,100,'',0,1,'L'); 

					$pdf->Output();
			  } 
		}
	}


// '''''every plan'''''''

	public function leadershipbonus(){
		$record=$this->Wallet_model->matchingincome(20);
		
	}

	public function directbonus(){
		$record=$this->Wallet_model->directsponsor(20);
		
	}

	public function repurchase_plan(){
		$record=$this->Wallet_model->repurchaseplan(20);
		
	}	

	public function travel_bonus(){
		$record=$this->Wallet_model->check_tour_bonus(20);
		
		
	}

	public function travel_bonus_distribution(){
		$record=$this->Wallet_model->tour_bonus_distribution();
		
	}

	public function car_bonus(){
		$record=$this->Wallet_model->check_car_bonus(20);
		
	}

	public function car_bonus_distribution(){
		$record=$this->Wallet_model->car_bonus_distribution();
		
	}

	public function house_bonus(){
		$record=$this->Wallet_model->check_house_bonus(20);
		
	}

	public function house_bonus_distribution(){
		$record=$this->Wallet_model->house_bonus_distribution();
		
	}

	public function luxury_bonus(){
		$record=$this->Wallet_model->check_luxury_bonus(20);
		
	}

	public function luxury_bonus_distribution(){
		$record=$this->Wallet_model->luxury_bonus_distribution();
	}

	public function imark_bonus(){
		$record=$this->Wallet_model->check_imark_bonus(20);
	}

	// ''''''''''''''''''''''Power Id Generate''''''''''''''''''''''''''''''
	public function power_id_add(){
		checklogin();
		if($this->session->role=='admin'){
			$data['title']="Power Id ";
		    // $data['product_list']=$this->Member_model->get_product_master_list();
		    $data['power_id_list']=$this->Member_model->get_power_id_list();
		    $data['datatable']=true;
		    $this->template->load('pages','prowerid_create',$data);
		}
	}

	public function add_bv_for_alldata(){
		checklogin();
		if($this->session->role=='admin'){
			$data['title']="Add Power ID For BV";
		    $data['power_id_list']=$this->Member_model->get_power_id_listbybv();
		    $data['datatable']=true;
		    $this->template->load('pages','prowerid_bv',$data);
		}
	}

	public function delete_powerid(){
		$id=$this->input->post('id');
		$rec=$this->Member_model->powerid_delete($id);
		echo json_encode($rec);
	}


	public function getmemberdetails(){
		$member_id = $this->input->post('prod_id');
		$record=$this->Member_model->get_member_detailsby_id($member_id);
		echo json_encode($record);
	}

	public function powerid_submit(){
		$data = $this->input->post();
		$data['added_on']=date('Y-m-d H:i:s');
		if(!empty($data['regid'])){
			$record = $this->Member_model->powerid_save($data);
			if($record==true){
				$this->session->set_flashdata("msg","Power Id successfully Submitted!");
			}
			else{
				$this->session->set_flashdata("err_msg",$rec['message']);
			}

		}else{
			$this->session->set_flashdata("err_msg",'Member Id is Not Correct');
		}
		
		redirect('power_id');
	}

	public function powerid_bv_submit(){
		$data = $this->input->post();
		$data['added_on']=date('Y-m-d H:i:s');

		if(!empty($data['regid'])){
			$record = $this->Member_model->powerid_bv_save($data);

			if($record['status']===true){
				$this->session->set_flashdata("msg","Power Id successfully Submitted!");
			}
			elseif($record['status']=='false'){
				$this->session->set_flashdata("err_msg",$record['error']['message']);
			}

		}else{
			$this->session->set_flashdata("err_msg",'Member Id is Not Correct');
		}
		
		redirect('powerid-bv');
	}
		
}
