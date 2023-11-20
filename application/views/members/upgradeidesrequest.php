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
                         	
                            <div class="col-md-12">
                                <table class="table table-condensed table-hover table-striped">
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Member ID</th>
                                        <th>Member Name</th>
                                        <th>Level</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                        $requests=$requests;
                                        if(is_array($requests)){ $i=0;
                                            foreach($requests as $request){ $i++;
												
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $request['username']; ?></td>
                                        <td><?php echo $request['name']; ?></td>
                                        <td><?php echo $request['levels']; ?></td>
                                        <td><?php echo $this->amount->toDecimal($request['amount']); ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($request['date'])); ?></td>
                                        <td>
                                            <a href="<?php echo base_url('members/levelrequestdetails/'.$request['id']); ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View Details</a>
                                        </td>
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
	$(document).ready(function(e) {
        $('#levels').change(function(){
			var package_id=$(this).val();
			// var package_price=$('#package_price').val();
            // alert(package_id);
			var price='';
			if(package_id!=''){
				if(package_id=='Sun'){
                    price = '1300';
                }else if(package_id=='Gold'){
                    price = 3900;
                }else if(package_id=='Platinum'){
                    price = 15600;
                }else if(package_id=='Ruby'){
                    price = 78000;
                }else if(package_id=='Diamond'){
                    price = 468000;
                }else if(package_id=='White Diamond'){
                    price = 3276000;
                }
                // alert(price);
                $('#amount').val(price);
			}
			
			$('#quantity').trigger('keyup');
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