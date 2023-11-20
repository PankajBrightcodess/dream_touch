<section class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    	<h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                            if(isset($profile) && $profile==true){
                        ?>
                        <div class="row profile">
                            <div class="col-md-6">
                                <legend>Personal Details</legend>
                                <table class="table" id="personal-details">
                                    <tr>
                                        <td colspan="2">
                                            <img src="<?php if($member['photo']!=''){echo file_url($member['photo']);}else{echo file_url('assets/images/blank.png');} ?>" 
                                                    style="height:135px; width:120px;" alt="User Image" id="view_photo"><br>
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    onClick="$(this).hide();$('#photoform').show();">Change Photo <i class="fa fa-camera"></i></button>
                                                    
                                            <?php echo form_open_multipart('profile/updatephoto', 'id="photoform"'); ?>
                                                <input type="file" name="photo" id="photo" onChange="getPhoto(this)" required/><br>
                                                <?php
                                                    $input=array("type"=>"hidden","name"=>"name","value"=>$user['name']);
                                                    echo form_input($input);
                                                    $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                                    echo form_input($input);
                                                ?>
                                                <button type="submit" class="btn btn-sm btn-success" name="updatephoto" value="Update">Update</button>
                                                <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                            <?php echo form_close(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sponsor ID</th>
                                        <td><?php echo $member['susername']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sponsor Name</th>
                                        <td><?php echo $member['sname']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Member ID</th>
                                        <td><?php echo $user['username']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo $member['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td><?php if($member['dob']!='0000-00-00')echo date('d-m-Y',strtotime($member['dob'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Father's Name</th>
                                        <td><?php echo $member['father']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td><?php echo $member['gender']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Marital Status</th>
                                        <td><?php echo $member['mstatus']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Aadhar No.</th>
                                        <td><?php echo $member['aadhar']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pan No.</th>
                                        <td><?php echo $member['pan']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Joining Date</th>
                                        <td><?php echo date('d-m-Y',strtotime($member['date'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Activation Date</th>
                                        <td><?php if($member['activation_date']!='0000-00-00')echo date('d-m-Y',strtotime($member['activation_date'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Activation Amount</th>
                                        <td><?php if(!empty($member['package'])){ echo $member['package'].'('.$member['amount'].')'; }else{ echo 'No Any Package'; }  ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onClick="$('#personal-details').hide();$('#personalform').show().find('input').first().focus();">Edit Personal Info <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </table>
                                <?php echo form_open('profile/updatepersonaldetails', 'id="personalform"'); ?>
                                    <div class="form-group">
                                        <label for="father" class=" form-control-label">Father's Name</label>
                                        <?php
                                            $input=array("name"=>"father","id"=>"father","Placeholder"=>"Father's Name","class"=>"form-control",
                                                    "autocomplete"=>"off","value"=>$member['father'],"readonly"=>"true");
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <?php
                                            $input=array("type"=>"date","name"=>"dob","readonly"=>"true","class"=>"form-control", "autocomplete"=>"off","value"=>$member['dob']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" class=" form-control-label">Gender</label>
                                        <?php 

                                            if(empty($member['gender'])){
                                                $gender=array(""=>"Select Gender","Male"=>"Male","Female"=>"Female");
                                                $attrs=array("id"=>"gender","class"=>"form-control form-control-select", "tabindex"=>"1");
                                                echo form_dropdown('gender',$gender,$member['gender'],$attrs);
                                            }else{
                                                $input=array("type"=>"text","name"=>"gender","readonly"=>"true","class"=>"form-control", "autocomplete"=>"off","value"=>$member['gender']);
                                                echo form_input($input);
                                            }
                                            
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="mstatus">Marital Status</label>
                                        <?php
                                         if(empty($member['mstatus'])){
                                            $mstatus=array(""=>"Select","Married"=>"Married","Unmarried"=>"Unmarried");
                                            $attrs=array("id"=>"mstatus","class"=>"form-control form-control-select", "tabindex"=>"1");
                                            echo form_dropdown('mstatus',$mstatus,$member['mstatus'],$attrs);
                                         }else{
                                            $input=array("type"=>"text","name"=>"gender","readonly"=>"true","class"=>"form-control", "autocomplete"=>"off","value"=>$member['mstatus']);
                                            echo form_input($input);
                                         }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="aadhar" class=" form-control-label">Aadhar No.</label>
                                        <?php
                                        if(empty($member['aadhar'])){
                                            $input=array("name"=>"aadhar","id"=>"aadhar","Placeholder"=>"Aadhar No.","class"=>"form-control",
                                            "pattern"=>"[0-9]{12}","title"=>"Enter Valid Aadhar No.","autocomplete"=>"off","maxlength"=>"12","value"=>$member['aadhar']);
                                            echo form_input($input);
                                        }else{
                                            $input=array("name"=>"aadhar","id"=>"aadhar","Placeholder"=>"Aadhar No.","class"=>"form-control",
                                            "pattern"=>"[0-9]{12}","title"=>"Enter Valid Aadhar No.","readonly"=>"true","autocomplete"=>"off","maxlength"=>"12","value"=>$member['aadhar']);
                                             echo form_input($input);
                                        }
                                           
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="pan" class=" form-control-label">PAN No.</label>
                                        <?php
                                         if(empty($member['aadhar'])){
                                            $input=array("name"=>"pan","id"=>"pan","Placeholder"=>"PAN No.","class"=>"form-control",
                                                            "pattern"=>"[A-Za-z0-9]{10}","title"=>"Enter Valid Pan No.","autocomplete"=>"off","maxlength"=>"10","value"=>$member['pan']);
                                            echo form_input($input);
                                         }else{
                                            $input=array("name"=>"pan","id"=>"pan","Placeholder"=>"PAN No.","class"=>"form-control",
                                                            "pattern"=>"[A-Za-z0-9]{10}","readonly"=>"true","title"=>"Enter Valid Pan No.","autocomplete"=>"off","maxlength"=>"10","value"=>$member['pan']);
                                            echo form_input($input);
                                         }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                        <button type="submit" class="btn btn-sm btn-success" name="updatepersonaldetails" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="col-md-6">
                                <legend>Contact Information</legend>
                                <table class="table" id="contact-details">
                                    <tr>
                                        <th>Address</th>
                                        <td><?php echo $member['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>District</th>
                                        <td><?php echo $member['districtname']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td><?php echo $member['statename']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td><?php echo $member['country']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pincode</th>
                                        <td><?php echo $member['pincode']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td><?php echo $member['mobile']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo $member['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onClick="$('#contact-details').hide();$('#contactform').show().find('textarea').first().focus();">Edit Contact Info <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </table>
                                <?php echo form_open('profile/updatecontactinfo', 'id="contactform"'); ?>
                                    <div class="form-group">
                                        <label for="address" class=" form-control-label">Address</label>
                                        <?php
                                        if(empty($member['address'])){
                                            $input=array("name"=>"address","id"=>"address","Placeholder"=>"Address","class"=>"form-control",
                                                            "autocomplete"=>"off","rows"=>"3","value"=>$member['address']);
                                            echo form_textarea($input);
                                        }else{
                                            $input=array("name"=>"address","id"=>"address","readonly"=>"true","Placeholder"=>"Address","class"=>"form-control",
                                                            "autocomplete"=>"off","rows"=>"3","value"=>$member['address']);
                                            echo form_textarea($input);
                                        }
                                            
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <?php
                                        if(empty($member['district'])){
                                            $input=array("name"=>"district","id"=>"district","Placeholder"=>"District","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$member['district']);
                                            echo form_input($input);
                                        }else{
                                            $input=array("name"=>"district","id"=>"district","readonly"=>"true","Placeholder"=>"District","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$member['districtname']);
                                            echo form_input($input);
                                        }
                                            
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <?php
                                        if(empty($member['state'])){
                                            $input=array("name"=>"state","id"=>"state","Placeholder"=>"State","class"=>"form-control",
                                            "autocomplete"=>"off","value"=>$member['state']);
                                            echo form_input($input);
                                        }else{
                                             $input=array("name"=>"state","id"=>"state","readonly"=>"true","Placeholder"=>"State","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$member['statename']);
                                            echo form_input($input);
                                        }
                                           
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <?php
                                        if(empty($member['country'])){
                                            $input=array("name"=>"country","id"=>"country","Placeholder"=>"Country","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$member['country']);
                                            echo form_input($input);
                                        }else{
                                            $input=array("name"=>"country","id"=>"country","readonly"=>"true","Placeholder"=>"Country","class"=>"form-control",
                                            "autocomplete"=>"off","value"=>$member['country']);
                                             echo form_input($input);
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">Pincode</label>
                                        <?php
                                          if(empty($member['pincode'])){
                                            $input=array("name"=>"pincode","id"=>"pincode","Placeholder"=>"Pincode","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$member['pincode']);
                                            echo form_input($input);
                                          }else{
                                            $input=array("name"=>"pincode","readonly"=>"true","id"=>"pincode","Placeholder"=>"Pincode","class"=>"form-control", 
                                            "autocomplete"=>"off","value"=>$member['pincode']);
                                                  echo form_input($input);
                                          }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <?php
                                            $input=array("name"=>"mobile","id"=>"mobile","Placeholder"=>"Mobile","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$member['mobile'],"readonly"=>"true");
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <?php
                                            $input=array("type"=>"email","name"=>"email","id"=>"email","Placeholder"=>"Email","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$member['email'],"readonly"=>"true");
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                        <button type="submit" class="btn btn-sm btn-success" name="updatecontactinfo" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                                
                            	<legend>Nominee Information</legend>
                                <table class="table" id="nominee-details">
                                	<tr>
                                    	<th>Nominee Name</th>
                                        <td><?php echo $nominee_details['name']; ?></td>
                                    </tr>
                                	<tr>
                                    	<th>Nominee Mobile</th>
                                        <td><?php echo $nominee_details['mobile']; ?></td>
                                    </tr>
                                	<tr>
                                    	<th>Relation With Applicant</th>
                                        <td><?php echo $nominee_details['relation']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2">
                                        	<button type="button" class="btn btn-primary btn-sm" 
                                            		onClick="$('#nominee-details').hide();$('#nomineeform').show().find('input').first().focus();">Edit Nominee <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </table>
								<?php echo form_open('profile/updatenomineedetails', 'id="nomineeform"'); ?>
                                    <div class="form-group">
                                        <label for="branch">Nominee Name</label>
                                        <?php
                                        if(empty($nominee_details['name'])){
                                            $input=array("name"=>"name","Placeholder"=>"Nominee Name","class"=>"form-control", "autocomplete"=>"off","value"=>$nominee_details['name']);
                                            echo form_input($input);
                                        }else{
                                            $input=array("name"=>"name","readonly"=>"true","Placeholder"=>"Nominee Name","class"=>"form-control", "autocomplete"=>"off","value"=>$nominee_details['name']);
                                            echo form_input($input);
                                        }
                                            
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifsc">Nominee Mobile</label>
                                        <?php
                                         if(empty($nominee_details['name'])){
                                            $input=array("name"=>"mobile","class"=>"form-control","Placeholder"=>"Nominee Mobile", "autocomplete"=>"off","value"=>$nominee_details['mobile']);
                                            echo form_input($input);
                                        }else{
                                            $input=array("name"=>"mobile","class"=>"form-control","readonly"=>"true","Placeholder"=>"Nominee Mobile", "autocomplete"=>"off","value"=>$nominee_details['mobile']);
                                            echo form_input($input);
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch">Relation With Applicant</label>
                                        <?php
                                        if(empty($nominee_details['relation'])){
                                            $input=array("name"=>"relation","Placeholder"=>"Relation With Applicant","class"=>"form-control", "autocomplete"=>"off",
														"value"=>$nominee_details['relation']);
                                            echo form_input($input);
                                        }else{
                                            $input=array("name"=>"relation","readonly"=>"true","Placeholder"=>"Relation With Applicant","class"=>"form-control", "autocomplete"=>"off",
                                            "value"=>$nominee_details['relation']);
                                             echo form_input($input);
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                    	<button type="submit" class="btn btn-sm btn-success" name="updatenomineedetails" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <?php
                            }
                            elseif($member['dob']=='0000-00-00' || $member['aadhar']=='' || $member['pan']==''){
								echo "<div class='text-center'><h2 class='text-danger'>Please Complete You Profile Before Adding Account Details!</h2>";
								echo "<a href='".base_url('profile/')."' class='btn btn-sm btn-info'>Edit Profile</a></div>";
							}
                            else{
                        ?>
                        <div class="row profile">
                            <div class="col-md-6">
                                <legend>Bank Information</legend>
                                <table class="table" id="bank-details">
                                    <tr>
                                        <th>A/C Holder Name</th>
                                        <td><?php echo $acc_details['account_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bank Name</th>
                                        <td><?php echo $acc_details['bank'];  ?></td>
                                    </tr>
                                    <tr>
                                        <th>Account Number</th>
                                        <td><?php echo $acc_details['account_no']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Branch</th>
                                        <td><?php echo $acc_details['branch']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>IFSC Code</th>
                                        <td><?php echo $acc_details['ifsc']; ?></td>
                                    </tr>
                                    <?php if($acc_details['kyc']!=1){ ?>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onClick="$('#bank-details').hide();$('#accform').show().find('input').first().focus();">Edit Bank Details <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <?php echo form_open('profile/updateaccdetails', 'id="accform"'); ?>
                                    <div class="form-group">
                                        <label for="account_name">A/C Holder Name</label>
                                        <?php
                                            $input=array("name"=>"account_name","id"=>"account_name","Placeholder"=>"Account Holder Name","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$acc_details['account_name']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank">Bank Name</label>
                                        <?php
											$bank="";
											if($acc_details['bank']!=''){
												if(in_array($acc_details['bank'],$banks)){
													$bank=$acc_details['bank'];
												}
												else{
													$bank='xyz';
												}
											}
                                            $attrs=array("id"=>"bank","class"=>"form-control form-control-select", "tabindex"=>"1");
                                            echo form_dropdown('bank',$banks,$bank,$attrs);
                                            $input=array("id"=>"bank-name","Placeholder"=>"Bank Name","class"=>"form-control hidden mt-2",
                                                            "autocomplete"=>"off","pattern"=>"[\w\s]+","title"=>"Enter Valid Bank Name","value"=>$acc_details['bank']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="account_no">A/C No.</label>
                                        <?php
                                            $input=array("name"=>"account_no","id"=>"account_no","Placeholder"=>"Account No","class"=>"form-control",
                                                            "autocomplete"=>"off","pattern"=>"[0-9]{9,}","title"=>"Enter Valid Account No.","value"=>$acc_details['account_no']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <?php
                                            $input=array("name"=>"branch","id"=>"branch","Placeholder"=>"Branch","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$acc_details['branch']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifsc">IFSC Code</label>
                                        <?php
                                            $input=array("name"=>"ifsc","id"=>"ifsc","Placeholder"=>"IFSC Code","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$acc_details['ifsc']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                        <button type="submit" class="btn btn-sm btn-success" name="updateaccdetails" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>	
        <div id="dot-loader" class="hidden"><img src="<?php echo file_url('assets/images/dotsloader.gif'); ?>" alt="" height="10"></div>
   	</div>
</section>
    <script>
		$(document).ready(function(e) {  
			$('#parent').keyup(function(){
				var username=$(this).val();
				var poslabel=$('#position-div').find("label");
				$('#parent_id').val('');
				$.ajax({
					type:"POST",
					url:"<?php echo base_url('members/getpositions'); ?>",
					data:{username:username},
					beforeSend: function(data){
						$('#pdiv').html($('#dot-loader').html());
					},
					success: function(data){
						$('#position-div').html(poslabel);
						data=JSON.parse(data);
						if(data['name']!=null){
							$('#pdiv').html(data['name']);
							$('#parent_id').val(data['id']);
						}
						$('#position-div').append(data['position']);
						var ele=$('#position')
						setChosenSelect(ele);
						
					}
				});
			});
			$('#parent').blur(function(){
				if($('#parent_id').val()==''){
					$('#pdiv').html("Enter Valid Placement ID!");
				}
			});
			$('body').on('change','#bank',function(){
				var bank=$(this).val();
				if(bank=='xyz'){
					$('#bank-name').removeClass('hidden').attr('name','bank').attr('required',true);;
				}
				else{
					$('#bank-name').addClass('hidden').removeAttr('name').removeAttr('required');
				}
			});
			$('#bank').trigger('change');
        });
		
		function getPhoto(input){
			$('#view_photo').replaceWith(' <img id="view_photo" style="height:135px; width:120px;" >');
			if (input.files && input.files[0]) {
				var filename=input.files[0].name;
				var re = /(?:\.([^.]+))?$/;
				var ext = re.exec(filename)[1]; 
				ext=ext.toLowerCase();
				if(ext=='jpg' || ext=='jpeg' || ext=='png'){
					var size=input.files[0].size;
					if(size<=2097152 && size>=20480){
						var reader = new FileReader();
						
						reader.onload = function (e) {
							$('#view_photo').attr('src',e.target.result);
						}
						reader.readAsDataURL(input.files[0]);
					}
					else if(size>=2097152){
						document.getElementById('photo').value= null;
						alert("Image size is greater than 2MB");	
					}
					else if(size<=20480){
						document.getElementById('photo').value= null; 
						alert("Image size is less than 20KB");	
					}
				}
				else{
					document.getElementById('photo').value= null;
					alert("Select 'jpeg' or 'jpg' or 'png' image file!!");	
				}
			}
		}
		
		function setChosenSelect(ele){
			ele.chosen({
				disable_search_threshold: 10,
				no_results_text: "Oops, nothing found!",
				width: "100%"
			});
		}
	</script>
    
    	
