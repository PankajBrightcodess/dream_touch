<section class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <?php echo form_open_multipart('profile/requestepayment', 'id="myform" onSubmit="return validate();"'); ?>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input("date","date","Date",true,date('Y-m-d')); 
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input("text","","Member ID",false,$user['username'],array("readonly"=>"true")); 
                                        ?>
                                    </div>
                                  
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input("number","amount","Amount",true,'',array("id"=>"amount")); 
                                        ?>
                                    </div>
                                    <div class="form-group request">
                                        <?php
                                            echo create_form_input("textarea","details","Transaction Details",true,'',array("id"=>"details","rows"=>"2")); 
                                        ?>
                                    </div>
                                    
                                    
                                 <?php
									if($transaction_image===true){
									?>
                                    <div class="form-group request">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <?php 
                                                        $attributes=array("id"=>"image","onChange"=>"getPhotos(this,'image')");
                                                        echo create_form_input("file","image","Upload Receipt:",true,'',$attributes); 
                                                    ?>
                                                </div>
                                            <div class="col-xs-6">
                                                <img  id="imagepreview" style="height:150px; width:250px;" >
                                            </div>
                                        </div>
                                    </div>
                                    <?php
									}
                                        echo create_form_input("hidden","","",false,'',array("id"=>"price")); 
                                        // echo create_form_input("hidden","","",false,$package_price,array("id"=>"package_price")); 
                                        echo create_form_input("hidden","regid","",false,$user['id']); 
                                    ?>
                                    <button type="submit" class="btn btn-sm btn-success" name="requestepin" value="Request">Request E-Pin</button>
                                <?php echo form_close(); ?>
                            </div>	
                            <div class="col-md-7 text-center">
                                <div class="form-group request">
                                  <img   src="<?= base_url('assets/images/upi.png');?>" class="img-fluid" height="350" width="350">
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <table class="table table-condensed table-hover table-striped">
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>MEMBER ID</th>
                                        <th>MEMEBR NAME</th>
                                        <th>AMOUNT</th>
                                        <th>DETAILS</th>
                                        <th>REQUEST DATE</th>
                                        <th>APPROVE STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                     <?php
                                        $requests=$requests;
                                        if(is_array($requests)){ $i=0;
                                            foreach($requests as $request){ $i++;
												if($request['approve_status']==1){
													$approve_date="<span class='text-danger'>Request Pending</span>";
												}
												elseif($request['approve_status']==0){
													$approve_date="<span class='text-danger'>Request Rejected</span>";
												}
												else{
													$approve_date="<span class='text-success'>Request Approved</span>";
												}
                                                
                                               
                                    ?> 
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $request['userid']; ?></td>
                                        <td><?php echo $request['name']; ?></td>
                                        <td><?php echo $this->amount->toDecimal($request['amount']); ?></td>
                                        <td><?php echo $request['details']; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($request['date'])); ?></td>
                                        <td><?php echo $approve_date; ?></td>
                                        <td><button class="btn btn-sm btn-danger delete" data-id="<?= $request['id'];?>">Delete</button></td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function getPhotos(input,field){
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
				if(size<=2097152 && size>=20480){
					var reader = new FileReader();
					
					reader.onload = function (e) {
						$(preview).attr('src',e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
				else if(size>=2097152){
					document.getElementById(field).value= null;
					alert("Image size is greater than 2MB");	
				}
				else if(size<=20480){
					document.getElementById(field).value= null; 
					alert("Image size is less than 20KB");	
				}
			}
			else{
				document.getElementById(field).value= null;
				alert("Select 'jpeg' or 'jpg' or 'png' image file!!");	
			}
		}
	}
	$(document).ready(function(e) {
        $('body').on('click','.delete',function(){
            var id = $(this).data('id');
            if(confirm("Are You Sure?")==true){
                $.ajax({
					type:"POST",
					url:"<?php echo base_url('profile/deletepayment'); ?>",
					data:{id:id},
					// beforeSend: function(data){
					// 	$('#pdiv').html($('#dot-loader').html());
					// },
					success: function(data){
						location.reload();
						
					},
				});
            }
            
        });
        
		$('#quantity').keyup(function(){
			if($('#package_id').val()==''){
				alert("First select Package!");
				$(this).val('');
				return false;
			}
			var quantity=$(this).val();
			quantity=quantity.replace(/[^\d\.]+/,'');
			$(this).val(quantity);
			var price=Number($('#price').val());
			if(isNaN(price)){ price=0; $('#price').val(price); }
			var total_amount=quantity*price;
			$('#amount').val(total_amount);
		});
		$('#type').change(function(){
			var type=$(this).val();
			if(type=='request'){
				$('.wallet').addClass('hidden');
				$('.request').removeClass('hidden');
				$('#details,#image').attr("required",true);
			}
			else{
				var id="#"+type;
				//$('#avl_balance').val($(id).val());
				$('.request').addClass('hidden');
				$('.wallet').removeClass('hidden');
				$('#details,#image').removeAttr("required");
			}
		});
    });
	
	
	function validate(){
		var avl=Number($('#avl_balance').val());
		var amount=Number($('#amount').val());
		if($('#type').val()!='request'){
			if(avl<amount){
				alert("Pin Amount Must be less than Available Balance!");
				return false;
			}
		}
	}
</script>