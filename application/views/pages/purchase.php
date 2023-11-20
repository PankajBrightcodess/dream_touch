<section class="content">
      <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-6">
                                <h3 class="card-title"><?php echo $title;?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="row">
                        	<div class="col-md-4 col-lg-3">
                                <?php echo form_open_multipart('purchase-submit');?>
                                 <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label>Product <span class="text-danger">*</span></label>
                                        <select class="form-control" name="product" id="prod">
                                            <option value="">Select Product</option>
                                            <?php 
                                                if(!empty($product_list)){
                                                    foreach ($product_list as $key => $value) {
                                                       ?><option value="<?php echo $value['id'];?>"><?php echo $value['product'];?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div> 

                                    <div class="col-sm-12">
                                        <label>Quantity <span class="text-danger">*</span></label>
                                        <?php echo form_input(array('type'=>'number','name'=>'quantity','id'=>'qnty','class'=>'form-control','placeholder'=>'Quantity','required'=>'true'));?>
                                    </div>  
                                    <div class="col-sm-12">
                                        <label>Price <span class="text-danger">*</span></label>
                                        <?php echo form_input(array('type'=>'number','name'=>'price','id'=>'price','class'=>'form-control price','readonly'=>'true','placeholder'=>'Price(Rs.) per Unit','required'=>'true'));?>
                                        <?php echo form_input(array('type'=>'hidden','id'=>'firstprice','class'=>'form-control','readonly'=>'true','required'=>'true'));?>
                                        <input type="hidden" id="total_wallet_amount" value="<?php echo $this->amount->toDecimal($wallet['actualwallet']); ?>">
                                    </div>  
                                    
                                    <div class="col-sm-12">
                                        <label>Payment Mode <span class="text-danger">*</span></label>
                                        <select class="form-control" name="payment_mode" id="payment_mode">
                                            <option value="">Select Payment Mode</option>
                                            <option value="Wallet" id="sel_wallet">Wallet</option>
                                            <option value="Online" >Online</option>
                                        </select>
                                    </div>
                                     <div class="col-sm-12 upload">
                                          <label>Upload Payment Details <span class="text-danger">*</span></label>
                                        <?php echo form_input(array('type'=>'file','name'=>'photo','id'=>'photo','class'=>'form-control'));?>
                                    </div>  

                                    <div class="col-sm-12 ">
                                          <label>Payment Details <span class="text-danger">*</span></label>
                                          <textarea class="form-control" name="payment_details" id="pay_details" rows="4" placeholder="Payment Details"></textarea>
                                    </div>                               
                                </div>
                               
                                
                               
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'hidden','name'=>'bv','id'=>'bv','class'=>'form-control','placeholder'=>'Bv','required'=>'true'));?>
                                    </div>                                   
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <?php echo form_submit(array('value'=>'Submit','class'=>'form-control btn btn-success'));?>
                                    </div>
                                    <div class="col-md-4"></div>                                    
                                </div>
                                <?php echo form_close();?>
                            </div>
                            <div class="col-md-1 col-lg-1"></div>
                        	<div class="col-md-8 col-lg-8 table-responsive">
                            	<table class="table data-table stripe hover nowrap table-bordered">
                                    <thead class="bg-success">
                                        <tr>    
                                            <th>#</th>                                         
                                            <th>Invoice No.</th>                                         
                                            <th>Product Name</th>                        
                                            <th>Quantity</th>                        
                                            <th>Price </th>                     
                                            <th>Bv </th>                     
                                            <th>Payment Mode </th>                     
                                            <th>Payment Status </th>                     
                                            <th>Date </th>                     
                                            <th>Approve Status </th>                     
                                            <th>Action</th>                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(!empty($purchase_list)){
                                                $i=0;
                                                foreach ($purchase_list as $key => $value) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td>#IM-<?php echo $value['id'];?></td> 
                                                        <td><?php echo $value['product_name'];?></td> 
                                                        <td><?php echo $value['quantity'];?></td> 
                                                        <td><?php echo $value['price'];?></td> 
                                                        <td><?php echo $value['bv'];?></td> 
                                                        <td><?php echo $value['payment_mode'];?></td> 
                                                        <td><?php echo $value['payment_details'];?></td> 
                                                        <td><?php echo date('d-m-Y',strtotime($value['added_on']));?></td>  
                                                        <td><?php if($value['approve_status']==0){ echo '<span class="text-warning text-bold">Panding</span>'; }elseif($value['approve_status']==1) { echo '<span class="text-success text-bold">Success</span>'; }else{ echo '<span class="text-danger text-bold">Cancel</span>'; } ?></td>  
                                                    <td><?php if($value['approve_status']!=1){ ?> <button type="button" data-id="<?php echo $value['id'];?>" data-payment_mode="<?php echo $value['payment_mode'];?>" class="btn btn-sm btn-danger ml-3 dlt" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button> <?php }?>
                                                        <a href="<?= base_url('members/invoicegenerate/'.$value['id']);?>" class="btn btn-sm btn-info" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                    </td>  
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
                </div>
            </div>
        </div>
        </div>
    </section>   
    <!-- -------------------------MODEL AREA START-------------------------------- -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #48b8a0;color: #fff;">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <?php echo form_open_multipart('product-master-update');?>
           <div class="row">
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 mb-3">
                        <?php echo form_input(array('type'=>'text','name'=>'product','id'=>'upd_product','class'=>'form-control','placeholder'=>'Name Of product','required'=>'true'));?>
                    </div>  
                    <div class="col-sm-12 col-md-12 mb-3">
                       <select class="form-control" name="unit" id="upd_unit">
                           <option value="">Select Unit</option>
                           <option value="lit">lit.</option>
                           <option value="ml">ml</option>
                           <option value="Kg">Kg</option>
                           <option value="Gram">Gram</option>
                           <option value="Piece">Piece</option>
                       </select>
                    </div>     
                    <div class="col-sm-12 col-md-12 mb-3">
                        <?php echo form_input(array('type'=>'number','name'=>'price','id'=>'upd_price','class'=>'form-control','placeholder'=>'Price(Rs.)','required'=>'true'));?>
                        <?php echo form_input(array('type'=>'hidden','name'=>'id','id'=>'id','class'=>'form-control','placeholder'=>'id','required'=>'true'));?>
                    </div>  
                    <div class="col-sm-12 col-md-12 mb-3">
                        <?php echo form_input(array('type'=>'date','name'=>'date','id'=>'upd_date','class'=>'form-control','placeholder'=>'Date','required'=>'true'));?>
                    </div>  
                    <div class="col-sm-12 col-md-12 mb-3">
                       <select class="form-control" name="gst" id="upd_gst">
                           <option value="">Select GST</option>
                           <option value="5%">5%</option>
                           <option value="12%">12%</option>
                           <option value="18%">18%</option>
                           <option value="28%">28%</option>
                       </select>
                    </div>   
                    <div class="col-sm-12 col-md-12 mb-3">
                        <?php echo form_input(array('type'=>'number','name'=>'bv','id'=>'upd_bv','class'=>'form-control','placeholder'=>'Bv','required'=>'true'));?>
                    </div>
                </div>                
           </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <?php echo form_submit(array('type'=>'submit','class'=>'btn btn-sm btn-success','value'=>'Update'));?>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    <!-- -------------------------MODEL AREA END---------------------------------- -->

<script>
	
	$(document).ready(function(e) {
        $('.upload').hide();
        $('.hoverable').mouseenter(function(){
            //$('[data-toggle="popover"]').popover();
            $(this).popover('show');                    
        }); 

        $('.hoverable').mouseleave(function(){
            $(this).popover('hide');
        });

        

        $('.duplicate').click(function(){
            var dupid = $(this).data('dupid');
            $.ajax({
                url:"<?php echo base_url('home/ajax_sidebar') ;?>",
                method:"POST",
                data:{dupid:dupid},
                success:function(data){
                    //console.log(data);
                    var setdata = JSON.parse(data);
                    //console.log(setdata);
                    $('#activate_menu').val(setdata.activate_menu);
                    $('#activate_not').val(setdata.activate_not);
                    $('#base_url').val(setdata.base_url);
                    $('#icon').val(setdata.icon);
                    $('#parent_id').val(setdata.parent).trigger('change');
                    $('#position').val(setdata.position);
                    var role_text = setdata.role_id;                    
                    $('#roles').val(role_text);
                    $('#status').val(setdata.status);
                }
            });
        });
        
		var table=$('.data-table').DataTable({
			scrollCollapse: true,
			autoWidth: false,
			responsive: true,
			columnDefs: [{
				targets: "no-sort",
				orderable: false,
			}],
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		});	

        $('body').on('click','.updt',function(){
          var id = $(this).data('id');
          var product = $(this).data('product');
          var unit = $(this).data('unit');
          var price = $(this).data('price');
          var date = $(this).data('date');
          var bv = $(this).data('bv');
          var gst = $(this).data('gst');
         
          $('#id').val(id);
          $('#upd_product').val(product);
          $('#upd_unit').val(unit);
          $('#upd_price').val(price);
          $('#upd_date').val(date);
          $('#upd_gst').val(gst);
          $('#upd_bv').val(bv);
          

        });	

        $('body').on('keyup','#qnty',function(){
            debugger;
            var pro_amount = $('#price').val();
            var wallet_amount = $('#total_wallet_amount').val();
            if(wallet_amount>=pro_amount){
                $('#sel_wallet').show();
            }else{
                 $('#sel_wallet').hide();
            }
        });


        $('body').on('change','#prod',function(){
            let prod_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('product-list-details');?>",
                data: {prod_id:prod_id},
                dataType: 'JSON',
                success: function(result){
                    $('#price').val(result.price);
                    $('#bv').val(result.bv);
                    $('#firstprice').val(result.price);
                    $('#qnty').val(1);
                     $('#qnty').trigger('keyup');
                }
            });
        });

        $('body').on('keyup','#qnty',function(){
            let qty = $(this).val();
            let price = $('#price').val();
            let firstprice = $('#firstprice').val();
            if(price!='' && qty!=''){
                price = parseFloat(firstprice)*parseInt(qty);
                 $('#price').val( price);

            }else{
               $('#price').val(firstprice);
            }
        });

        $('body').on('change','#payment_mode',function(){
            let shw = $(this).val();
            if(shw=='Online'){
                $('.upload').show();
            }else{
                $('.upload').hide();
            }
        });

        $('body').on('click','.dlt',function(){
            var id = $(this).data('id');
            var payment_mode = $(this).data('payment_mode');

            var check = confirm('Are You Sure?');
            if(check==true){
                $.ajax({
                    type:"POST",
                    url:"<?php echo base_url('purchase-delete');?>",
                    data: {id:id,payment_mode:payment_mode},
                    dataType:'JSON',
                    success: function(result){
                       if(result.status==true){
                        alert(result.msg);
                       }else{
                        alert(result.msg);
                       }
                       location.reload();
                    }
                });
            }
        });

        $('body').on('change','#product',function(){
            debugger;
            var id = $(this).val();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('check-group-member')?>",
                data:{id:id},
                success: function(result){
                   if(result>=10){
                    alert('10 Member Completed, Please Select Another Group !');
                    location.reload();
                   } else{

                   }
                }
            });
        });
        
		$('body').on('change','#parent_id',function(){
			var parent_id=$(this).val();
			var option="<select name='position' id='position' class='form-control' required>";
			option+="<option value=''>Select </option>";
			option+="<option value='0'>Top</option>";
			$.ajax({
				type:"POST",
				url:"<?php echo base_url("home/getOrderList"); ?>",
				data:{parent_id:parent_id},
				dataType:"json",
				beforeSend: function(){
					
				},
				success: function(data){
					$(data).each(function(i, val) {
						option+="<option value='"+val['position']+"'>After "+val['name']+"</option>";
					});
					option+='</select>';
					$('#position').replaceWith(option);
					$('.box-overlay').hide();
				}
			});
		});
        $('#parent_id').trigger('change');
    });
</script>