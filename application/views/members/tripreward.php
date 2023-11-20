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
                            <div class="col-6">
                                 <?php echo form_open_multipart('members/upgrademember', 'id="myform" onsubmit="return validate()"'); ?>
                                    <h3 class="header smaller lighter">Trip Reward</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"ref","Placeholder"=>"Sponsor Id","autocomplete"=>"off");
                                                    echo create_form_input("text","","Sponsor ID",true,'',$attributes); 
                                                    echo create_form_input("hidden","refid","",false,$user['id'],array("id"=>"refid")); 
                                                ?>
                                                <div style="padding:0 10px; font-size:16px; font-weight:600" id="refdiv"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"refname","Placeholder"=>"Sponsor Name","autocomplete"=>"off","readonly"=>true);
                                                    echo create_form_input("text","","Sponsor Name",true,'',$attributes); 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                <?php
                                                    echo create_form_input('select','package_id','Package',true,'',array("id"=>"package_id"),$packages);
                                                ?>
                                            </div>
                                        </div>
                                       
                                      
                                      
                                     
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                           
                                            <a href="<?= str_replace('members.','',base_url()); ?>" class="btn btn-sm btn-danger">Cancel</a>
                                            <button type="submit" class="btn btn-sm btn-success" id="savebtn" name="addmember" disabled>Submit</button>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="col-6">
                            <div class="table-responsive" id="result">
                                    <table class="table table-striped data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>SL NO.</th>
                                                <th>USERNAME</th>
                                                <th>NAME</th>
                                                <th>DATE</th>
                                                <th>PACKAGE AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              if(!empty($upgradelist)){
                                                 $i=0;
                                                foreach ($upgradelist as $key => $value) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?= $i;?></td>
                                                        <td><?= $value['username']?></td>
                                                        <td><?= $value['name']?></td>
                                                        <td><?= date('d-m-Y',strtotime($value['added_on']));?></td>
                                                        <td><?= $value['amount']?></td>

                                                    </tr>
                                                    <?php
                                                }
                                              }
                                            ?>
                                        
                                        
                                           
                                        </tbody>
                                    </table>
                                </div>






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
			$('#ref').keyup(function(){
				getrefid();
			}); 
			$('#ref').blur(function(){
				getrefid();
			});
			$.ajax({
            type:"POST",
            url:"<?php echo base_url("home/verifycommission"); ?>",
            data:{a:''},
            success: function(data){
              
            }
          });
			$('#parent').keyup(function(){
				var username=$(this).val();
				var poslabel=$('#position-div').find("label");
				$('#parent_id').val('');
			});
			$('#parent').blur(function(){
				if($('#parent_id').val()==''){
					$('#pdiv').html("Enter Valid Placement ID!");
				}
			});
			$('body').on('keyup','#epin',function(){
				var epin=$(this).val();
				var regid=$('#refid').val();
                if(regid=='' || regid==0){ alert("Enter Sponsor ID First!"); $(this).val('');$('#ref').focus(); return false;}
				$('#epinstatus').removeClass('text-danger').removeClass('text-success');
				$('#savebtn').attr("disabled",true);
				
				elen=epin.length;
				epin=epin.trim();
				enewlen=epin.length;
				if(elen!=enewlen){
					$(this).val(epin);
				}
				
				if(epin==''){
					$('#epinstatus').text('');
					$('#savebtn').removeAttr("disabled");
					return false;
				}
				$.ajax({
					type:"POST",
					url:"<?php echo base_url("epins/checkepin"); ?>",
					data:{epin:epin,regid:regid},
					success: function(data){
						if(data=='1'){
							$('#epinstatus').addClass('text-success').text('E-Pin Available');
							$('#savebtn').removeAttr("disabled");
						}
						else{
							$('#epinstatus').addClass('text-danger').text('E-Pin Not Available');
						}
					}
				});
			});
			if($('#ref').val()!=''){
				$('#ref').trigger('keyup');
			}
			$('body').on('change','#bank',function(){
				var bank=$(this).val();
				if(bank=='xyz'){
					$('#bank-name').removeClass('hidden').attr('name','bank');
				}
				else{
					$('#bank-name').addClass('hidden').removeAttr('name');
				}
			});
        });
		
		function getrefid(){
			var username=$('#ref').val();
				$('#epin,#refid,#refname').val('');
                $('#refdiv').removeClass('text-danger').removeClass('text-success').html('');
                //$('#position-div').html('');
                $('#savebtn').attr("disabled",true);
				if(username=='admin'){ return false; }
				$.ajax({
					type:"POST",
					url:"<?php echo base_url("members/getrefid/"); ?>",
					data:{username:username,status:'all'},
					beforeSend: function(data){
						$('#refdiv').html($('#dot-loader').html());
					},
					success: function(data){
						data=JSON.parse(data);
                        if(data['regid']=='' || data['regid']==0){
							$('#refdiv').html(data['name']).addClass('text-danger');
                        }else{
							$('#refid').val(data['regid']);
							$('#refname').val(data['name']);
							$('#refdiv').html('').addClass('text-success');
                            $('#savebtn').removeAttr("disabled");
                        }
						
					}
				});
		}
		
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
		
		function validate(){
			if($('#refid').val()=='0'){
				alert("Member ID Not Available");
				return false;
			}
			$('button[name="addmember"]').hide();
		}
	</script>
    
    	
