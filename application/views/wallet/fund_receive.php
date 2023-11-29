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
                                <?php echo form_open_multipart('wallet/addfund', 'id="myform" onsubmit="return validate()"'); ?>
                                    <h3 class="header smaller lighter">Level Fund Transfer</h3>
                                    <div class="row">
                                       
                                       <div class="col-md-12">
									   <div class="table-responsive" id="result">
                                    <table class="table table-striped data-table" id="bootstrap-data-table-export">
                                        <div class="Got it, that's why you seem all physically and mentally on point."
                                        <thead>
                                            <tr>
                                                <th>SL NO.</th>
                                                <th>MEMBER ID</th>
                                                <!-- <th>NO OF MEMBERS</th> -->
                                                <th>TRANSFER AMOUNT</th>
                                                <th class="select-filter">DATE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
												if(!empty($fundtranslist)){ $i=0;
													foreach ($fundtranslist as $key => $value) { $i++;
														?>
														<tr>
															<td><?php echo $i;?></td>
															<td><?php echo $value['receiver_id'];?></td>
															<td><?php echo $value['amount'];?></td>
															<td><?php echo date('d-m-Y',strtotime($value['added_on']));?></td>
														</tr>
														<?php
													}
												}
											?>
										</tbody>
                                    </table>
									   </div>
                                  
                                        
                                    </div>
                                  
                                    
                                  
                                   
                                  
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-sm btn-success" id="savebtn" name="addmember" disabled>Submit</button>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
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
            $('body').on('keyup','#trans_amount',function(){
                var wallet_amount = $('#wallet_amount').val();
                var trans_amount = $(this).val();
			
				wallet_amount = parseFloat(wallet_amount);
				trans_amount = parseFloat(trans_amount);
				// trans_amount = parsefloat(trans_amount);
                if(wallet_amount<trans_amount){
                    alert("Your Wallet Amount is Too Low");
                    $(this).val("");
                }
            });
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
		
		function getrefid(){
			
			var username=$('#ref').val();
			$('#epin,#refid,#refname').val('');
			$('#refdiv').removeClass('text-danger').removeClass('text-success').html('');
			//$('#position-div').html('');
			$('#savebtn').attr("disabled",true);
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
		
		function setChosenSelect(ele){
			ele.chosen({
				disable_search_threshold: 10,
				no_results_text: "Oops, nothing found!",
				width: "100%"
			});
		}
		
		function validate(){
			$('#savebtn').hide();
		}
	</script>
    
    	
