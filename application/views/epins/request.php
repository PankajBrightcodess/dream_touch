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
                                <?php echo form_open_multipart('epins/requestepin', 'id="myform" onSubmit="return validate();"'); ?>
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
                                            echo create_form_input("text","name","Name",false,$user['name'],array("readonly"=>"true")); 
                                        ?>
                                    </div>
                                    <div class="form-group hidden">
                                        <?php
                                            $type=array("request"=>"Cash");
											//$type['ewallet']="E-Wallet";
                                            echo create_form_input("select","type","Type",false,'',array("id"=>"type"),$type); 
                                        ?>
                                    </div>
                                    <div class="form-group wallet hidden">
                                        <?php
                                            echo create_form_input("text","","Available Balance",false,'',array("id"=>"avl_balance","readonly"=>"true")); 
                                        ?>
                                    </div>
                                    <div class="form-group">
                                    <?php
                                            echo create_form_input('select','package_id','Package',true,'',array("id"=>"package_id"),$packages);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input('number','quantity','No of E-Pins',true,'',array("id"=>"quantity","Placeholder"=>"No of E-Pins","autocomplete"=>"off"));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input("text","amount","Pin Amount",true,'',array("id"=>"amount","readonly"=>"true")); 
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
                                                        $attributes=array("id"=>"image","onChange"=>"getPhoto(this,'image')");
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
                                        echo create_form_input("hidden","","",false,$package_price,array("id"=>"package_price")); 
                                        echo create_form_input("hidden","regid","",false,$user['id']); 
                                    ?>
                                    <button type="submit" class="btn btn-sm btn-success" name="requestepin" value="Request">Request E-Pin</button>
                                <?php echo form_close(); ?>
                            </div>	
                            <div class="col-md-7">
                                <table class="table table-condensed table-hover table-striped">
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Request Date</th>
                                        <th>Type</th>
                                        <th>No of E-Pins</th>
                                        <th>Amount</th>
                                        <th>Approved Date</th>
                                    </tr>
                                    <?php
                                        $requests=$requests;
                                        if(is_array($requests)){ $i=0;
                                            foreach($requests as $request){ $i++;
												if($request['approve_date']===NULL){
													$approve_date="<span class='text-danger'>Request Pending</span>";
												}
												elseif($request['status']==2){
													$approve_date="<span class='text-danger'>Request Rejected</span>";
												}
												else{
													$approve_date=date('d-m-Y',strtotime($request['approve_date']));
												}
                                                
                                                if($request['type']=='request'){ $type="Cash"; }
                                                elseif($request['type']=='ewallet'){ $type="E-Wallet"; }
                                                else{ $type=" Pin Wallet"; }
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($request['date'])); ?></td>
                                        <td><?php echo $type; ?></td>
                                        <td><?php echo $request['quantity']; ?></td>
                                        <td><?php echo $this->amount->toDecimal($request['amount']); ?></td>
                                        <td><?php echo $approve_date; ?></td>
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
        $('#package_id').change(function(){
			var package_id=$(this).val();
			var package_price=$('#package_price').val();
			var price='';
			if(package_id!=''){
				package_price=JSON.parse(package_price);
				price=package_price[package_id];
			}
			$('#price').val(price);
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