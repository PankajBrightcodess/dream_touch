<?php
	/*echo "<pre>";
	print_r($details);
	die;*/
	$member=$details['member'];
	$acc_details=$details['acc_details'];
?>
<section class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <?php echo form_open_multipart('members/updatemember', 'id="myform"'); ?>
                                    <h3 class="header smaller lighter">
                                        Personal Details 
                                        <button type="button" class="btn btn-sm btn-info" onClick="$('#personalDiv').show();$('#edita,#editu').show();$('#accountDiv,#uploadDiv').hide();$(this).hide();" 
                                                id="editp" style="display:none;">Edit</button>
                                    </h3>
                                    <div id="personalDiv" >
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"name","Placeholder"=>"Full Name","autocomplete"=>"off");
                                                        echo create_form_input("text","name","Name",true,$member['name'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group ">
                                                   <?php
                                                        $attributes=array("id"=>"father","Placeholder"=>"Father's Name","autocomplete"=>"off");
                                                        echo create_form_input("text","father","Father's Name",false,$member['father'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"mobile","Placeholder"=>"Mobile","autocomplete"=>"off","pattern"=>"[0-9]{10}","title"=>"Enter Valid Mobile No.","maxlength"=>"10");
                                                        echo create_form_input("text","mobile","Mobile",true,$member['mobile'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"email","Placeholder"=>"Email","autocomplete"=>"off");
                                                        echo create_form_input("email","email","Email",false,$member['email'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("date","dob","Date Of Birth",false,$member['dob'],array("id"=>"dob"));  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4 hidden">
                                            <div class="form-group">
                                                <?php
                                                    $gender=array(""=>"Select Gender","Male"=>"Male","Female"=>"Female");
                                                    echo create_form_input("select","gender","Gender",false,'',array("id"=>"gender"),$gender); 
                                                ?>
                                            </div>
                                        </div>
                                          
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"address","Placeholder"=>"Address","autocomplete"=>"off","rows"=>"3");
                                                        echo create_form_input("textarea","address","Address",false,$member['address'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        // $attributes=array("id"=>"state","Placeholder"=>"State","autocomplete"=>"off");
                                                        // echo create_form_input("text","state","State",false,$member['state'],$attributes);  
                                                       
                                                        echo create_form_input("select","state","State Name",true,'',array("id"=>"state"),$states); 
                                                        $input=array("id"=>"state-name","Placeholder"=>"State Name","class"=>"form-control hidden mt-2",
                                                                        "autocomplete"=>"off","pattern"=>"[\w\s]+","title"=>"Enter Valid State Name","selected"=>"selected","value"=>$member['state']);
                                                        echo form_input($input);
                                                 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <!-- <?php
                                                        $attributes=array("id"=>"district","Placeholder"=>"District","autocomplete"=>"off");
                                                        echo create_form_input("text","district","District",false,$member['district'],$attributes);  
                                                    ?> -->
                                                        <span class="text-bold p-2 ">District <span class="text-danger">*</span></span>
                                                    <select class="form-control" id="district" name="district" required>
                                                  <option value="">Select Dist.</option>

                                                </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-12">
                                                <?php

                                                    echo create_form_input("hidden","regid","",false,$member['regid']);  
                                                ?>
                                                <button type="submit" class="btn btn-sm btn-success" name="updatemember">Update Personal Details</button>
                                                <a href="<?php echo base_url('members/downline/'); ?>" class="btn btn-sm btn-danger">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?><br>
                             <!--    <h3 class="header smaller lighter">
                                    Account Details <button type="button" class="btn btn-sm btn-info" onClick="$('#accountDiv').show();$('#editp,#editu').show();$('#personalDiv,#uploadDiv').hide();$(this).hide();" id="edita">Edit</button>
                                </h3> -->
                                <?php echo form_open_multipart('members/updatemember', 'id="myform"'); ?>
                                    <div id="accountDiv" style="display:none">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        echo create_form_input("select","bank","Bank Name",false,$acc_details['bank'],array("id"=>"bank"),$banks); 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"branch","Placeholder"=>"Branch","autocomplete"=>"off");
                                                        echo create_form_input("text","branch","Branch",false,$acc_details['branch'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"city","Placeholder"=>"City","autocomplete"=>"off");
                                                        echo create_form_input("text","city","City",false,$acc_details['city'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"account_no","Placeholder"=>"A/C No.","autocomplete"=>"off");
                                                        echo create_form_input("text","account_no","A/C No.",false,$acc_details['account_no'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"account_name","Placeholder"=>"A/C Holder Name","autocomplete"=>"off");
                                                        echo create_form_input("text","account_name","A/C Holder Name",false,$acc_details['account_name'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php
                                                        $attributes=array("id"=>"ifsc","Placeholder"=>"IFSC Code","autocomplete"=>"off");
                                                        echo create_form_input("text","ifsc","IFSC Code",false,$acc_details['ifsc'],$attributes);  
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?php

                                                    echo create_form_input("hidden","regid","",false,$member['regid']);  
                                                ?>
                                                <button type="submit" class="btn btn-sm btn-success" name="updatemember">Update Account Details</button>
                                                <a href="<?php echo base_url('members/downline/'); ?>" class="btn btn-sm btn-danger">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?><br>
                                <?php
                                    if($acc_details['kyc']!=0){
                                ?>
                                <h3 class="header smaller lighter">
                                    Update Documents <button type="button" class="btn btn-sm btn-info" onClick="$('#uploadDiv').show();$('#edita,#editp').show();$('#personalDiv,#accountDiv').hide();$(this).hide();" id="editu">Edit</button>
                                </h3>
                                <?php echo form_open_multipart('members/updatedocs', 'id="myform"'); ?>
                                    <div id="uploadDiv" style="display:none">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                   <?php 
                                                        $attributes=array("id"=>"aadhar1","onChange"=>"getPhoto(this,'aadhar1')","accept"=>"image/*");
                                                        echo create_form_input("file","aadhar1","Upload Aadhar Card Front :",true,'',$attributes); 
                                                        $aadhar1="";
                                                        if($acc_details['aadhar1']!=''){
                                                            $aadhar1="src='".file_url($acc_details['aadhar1'])."'";
                                                        }
                                                    ?>
                                                    <img <?php echo $aadhar1; ?> id="aadhar1preview" style="height:150px; width:250px;" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php 
                                                        $attributes=array("id"=>"aadhar2","onChange"=>"getPhoto(this,'aadhar2')","accept"=>"image/*");
                                                        echo create_form_input("file","aadhar2","Upload Aadhar Card Back:",true,'',$attributes); 
                                                        $aadhar2="";
                                                        if($acc_details['aadhar2']!=''){
                                                            $aadhar2="src='".file_url($acc_details['aadhar2'])."'";
                                                        }
                                                    ?>
                                                    <img <?php echo $aadhar2; ?> id="aadhar2preview" style="height:150px; width:250px;" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php 
                                                        $attributes=array("id"=>"cheque","onChange"=>"getPhoto(this,'cheque')","accept"=>"image/*");
                                                        echo create_form_input("file","cheque","Upload Cancelled Cheque/Passbook:",true,'',$attributes); 
                                                        $cheque="";
                                                        if($acc_details['cheque']!=''){
                                                            $cheque="src='".file_url($acc_details['cheque'])."'";
                                                        }
                                                    ?>
                                                    <img <?php echo $cheque; ?> id="chequepreview" style="height:150px; width:250px;" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php 
                                                        $attributes=array("id"=>"panimg","onChange"=>"getPhoto(this,'panimg')","accept"=>"image/*");
                                                        echo create_form_input("file","pan","Upload PAN Card :",false,'',$attributes); 
                                                        $pan="";
                                                        if($acc_details['pan']!=''){
                                                            $pan="src='".file_url($acc_details['pan'])."'";
                                                        }
                                                    ?>
                                                    <img <?php echo $pan; ?> id="panimgpreview" style="height:150px; width:250px;" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                    echo create_form_input("hidden","name","",false,$member['name']);  
                                                    echo create_form_input("hidden","regid","",false,$member['regid']);  
                                                ?>
                                                <button type="submit" class="btn btn-sm btn-success" name="updatedocs">Update Documents</button>
                                                <a href="<?php echo base_url('members/downline/'); ?>" class="btn btn-sm btn-danger">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>	
                        <div id="dot-loader" class="hidden"><img src="<?php echo file_url('assets/images/dotsloader.gif'); ?>" alt="" height="10"></div>
                    </div>
                </div>
            </div>
        </div>
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
						//console.log(data);
						$('#position-div').html(poslabel);
						data=JSON.parse(data);
						if(data['name']!=''){
							$('#pdiv').html(data['name']);
							$('#parent_id').val(data['id']);
						}
						$('#position-div').append(data['position']);
						var ele=$('#position')
						//setChosenSelect(ele);
						
					}
				});
			});

            $('body').on('change','#state',function(){
               var state_id = $(this).val();
               $.ajax({
					type:"POST",
					url:"<?php echo base_url("members/dist_list"); ?>",
					data:{state_id:state_id},
					success: function(data){
                       $('#district').html(data);
					}
				});
            });
			$('#parent').blur(function(){
				if($('#parent_id').val()==''){
					$('#pdiv').html("Enter Valid Placement ID!");
				}
			});
        });
		<?php /*?>
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
		<?php */?>
        
        function getPhoto(input,field){
            var id="#"+field;
            var preview="#"+field+"preview";
            $(preview).replaceWith('<img id="'+field+'preview" style="height:150px; width:250px;" >');
            if (input.files && input.files[0]) {
                var filename=input.files[0].name;
                var re = /(?:\.([^.]+))?$/;
                var ext = re.exec(filename)[1]; 
                ext=ext.toLowerCase();
                if(ext=='jpg' || ext=='jpeg' || ext=='png'){
                    var size=input.files[0].size;
                    if(size<=10485760 && size>=10240){
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $(preview).attr('src',e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                    else if(size>=10485760){
                        alert("Image size is greater than 10MB");	
                        document.getElementById(field).value= null;
                    }
                    else if(size<=10240){
                        alert("Image size is less than 10KB");	
                        document.getElementById(field).value= null; 
                    }
                }
                else{
                    alert("Select 'jpeg' or 'jpg' or 'png' image file!!");	
                    document.getElementById(field).value= null;
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
    
    	
