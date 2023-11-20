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
                           	
                           
                            <div class="col-md-12 mt-2">
                                <table class="table table-condensed table-hover table-striped">
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>MEMBER ID</th>
                                        <th>MEMEBR NAME</th>
                                        <th>AMOUNT</th>
                                        <th>DETAILS</th>
										<th>UPLOAD FILE</th>
                                        <th>REQUEST DATE</th>
                                        <th>APPROVE STATUS</th>
                                        <!-- <th>ACTION</th> -->
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
										<td><button type="button" class="btn btn-primary imgs" data-toggle="modal" data-target="#exampleModal" data-image ="<?php echo $request['image']; ?>" >View</button></td>
                                        <td><?php echo date('d-m-Y',strtotime($request['date'])); ?></td>
                                        <td><?php echo $approve_date; ?></td>
                                        <!-- <td><button class="btn btn-sm btn-success m-1 approve" data-id="<?= $request['id'];?>">Approve</button><button class="btn btn-sm btn-danger approve_cancel" data-id="<?= $request['id'];?>">Cancel</button></td> -->
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
			<div class="col-md-12">
				<img src="" class="img-fluid img">
			</div>
		</div>
      </div>
      
    </div>
  </div>
</div>
<script>
    function getPhotos(input,field){
		var id="#"+field;
		var preview="#"+field+"preview";
        alert(field);
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
        $('body').on('click','.approve',function(){
            var id = $(this).data('id');
            if(confirm("Are You Sure?")==true){
                $.ajax({
					type:"POST",
					url:"<?php echo base_url('profile/approve_data'); ?>",
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

		$('body').on('click','.imgs',function(){
            var image = $(this).data('image');
			$('.img').attr("src","<?= base_url()?>"+image);
            
        });

        $('body').on('click','.approve_cancel',function(){
            var id = $(this).data('id');
            if(confirm("Are You Sure?")==true){
                $.ajax({
					type:"POST",
					url:"<?php echo base_url('profile/approve_cancel'); ?>",
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