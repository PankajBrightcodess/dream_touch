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
                        	<div class="col-md-4 col-sm-12 col-lg-3">
                                <?php echo form_open_multipart('powerid-submit-bv');?>
                                 <div class="form-group row">
                                    <div class="col-sm-12 col-lg-12 col-md-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'memberid','id'=>'memberid','class'=>'form-control','placeholder'=>'Member Id','required'=>'true'));?>
                                    </div>                                    
                                </div>
                               
                                <div class="form-group row">
                                    <div class="col-sm-12 col-lg-12 col-md-12">
                                        <select class="form-control" name="position" required="true" id="positions">
                                            <option value="">Position</option>
                                            <option value="Left">Left</option>
                                            <option value="Right">Right</option>
                                        </select>
                                    </div>                                   
                                </div>
                                 <div class="form-group row">
                                    <div class="col-sm-12 col-lg-12 col-md-12">
                                        <?php echo form_input(array('type'=>'number','name'=>'bv','id'=>'bv','class'=>'form-control','placeholder'=>'Enter BV','required'=>'true'));?>
                                        <?php echo form_input(array('type'=>'hidden','name'=>'regid','id'=>'regid','class'=>'form-control','placeholder'=>'Reg Id','required'=>'true','readonly'=>'true'));?>
                                    </div>                                   
                                </div>
                                 <div class="form-group row">
                                    <div class="col-sm-12 col-lg-12 col-md-12">
                                        <?php echo form_input(array('type'=>'date','name'=>'date','id'=>'date','value'=>date('Y-m-d'),'class'=>'form-control','placeholder'=>'Date','required'=>'true'));?>
                                    </div>                                   
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <?php echo form_submit(array('value'=>'Submit','class'=>'form-control btn btn-success powersubmit'));?>
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
                                            <th>Member Id</th>                        
                                            <th>Position</th>                        
                                            <th>BV</th>                     
                                            <th>Date </th>                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(!empty($power_id_list)){
                                                $i=0;
                                                foreach ($power_id_list as $key => $value) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $value['memberid'];?></td> 
                                                        <td><?php echo $value['position'];?></td> 
                                                        <td><?php echo $value['bv'];?></td> 
                                                        <td><?php echo date('d-m-Y',strtotime($value['date']));?></td> 
                                                       
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


        $('body').on('keyup','#memberid',function(){
            debugger;
            let prod_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('getmemberdetails');?>",
                data: {prod_id:prod_id},
                dataType: 'JSON',
                success: function(result){
                    $('#regid').val(result.id);
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

        $('body').on('click','.powersubmit',function(){
            let checkid = $('#regid').val();
            if(checkid==''){
                alert('Please Enter Correct Member Id');
                location.reload();
            }
        });

        $('body').on('click','.dlt',function(){
            var id = $(this).data('id');
            var check = confirm('Are You Sure?');
            if(check==true){
                $.ajax({
                    type:"POST",
                    url:"<?php echo base_url('delete-powerid');?>",
                    data: {id:id},
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