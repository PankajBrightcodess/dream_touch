<section class="content">
      <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-6">
                                <h3 class="card-title"><?php echo $title; ?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="row">
                        	<div class="col-md-4 col-lg-3">
                                <?php echo form_open_multipart('product-master-submit');?>
                                 <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'text','name'=>'product','id'=>'product','class'=>'form-control','placeholder'=>'Name Of product','required'=>'true'));?>
                                    </div>                                    
                                </div>
                               
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'number','name'=>'mrp','id'=>'mrp','class'=>'form-control','placeholder'=>'MRP per Unit','required'=>'true'));?>
                                    </div>                                   
                                </div>    
                               

                                 <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'number','name'=>'price','id'=>'price','class'=>'form-control','placeholder'=>'DP per Unit','required'=>'true'));?>
                                    </div>                                   
                                </div>
                                 
                                 
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'number','name'=>'bv','id'=>'bv','class'=>'form-control','placeholder'=>'Bv','required'=>'true'));?>
                                    </div>                                   
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php echo form_input(array('type'=>'date','name'=>'date','id'=>'date','class'=>'form-control','placeholder'=>'Date','required'=>'true'));?>
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
                                            <th>Product Name</th>                   
                                            <th>MRP </th>                     
                                            <th>DP</th>                     
                                            <th>Bv </th>                     
                                            <th>Date </th>                     
                                            <th>Action</th>                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(!empty($product_list)){
                                                $i=0;
                                                foreach ($product_list as $key => $value) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $value['product'];?></td> 
                                                        <td><?php echo $value['mrp'];?></td> 
                                                        <td><?php echo $value['price'];?></td> 
                                                        <td><?php echo $value['bv'];?></td> 
                                                        <td><?php echo date('d-m-Y',strtotime($value['date']));?></td>  
                                                    <td><button type="button"  class="btn btn-sm btn-info updt" data-id="<?php echo $value['id'];?>"  data-product="<?php echo $value['product'];?>" data-mrp="<?php echo $value['mrp'];?>" data-price="<?php echo $value['price'];?>" data-bv="<?php echo $value['bv'];?>" data-date="<?php echo $value['date'];?>" data-toggle="modal" data-target="#exampleModal" title="Group Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button type="button" data-id="<?php echo $value['id'];?>" class="btn btn-sm btn-danger ml-3 dlt" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
                             <?php echo form_input(array('type'=>'number','name'=>'mrp','id'=>'upd_mrp','class'=>'form-control','placeholder'=>'MRP per Unit','required'=>'true'));?>
                       </div>  
                    <div class="col-sm-12 col-md-12 mb-3">
                        <?php echo form_input(array('type'=>'number','name'=>'price','id'=>'upd_price','class'=>'form-control','placeholder'=>'DP','required'=>'true'));?>
                        <?php echo form_input(array('type'=>'hidden','name'=>'id','id'=>'id','class'=>'form-control','placeholder'=>'id','required'=>'true'));?>
                    </div>  
                    <div class="col-sm-12 col-md-12 mb-3">
                        <?php echo form_input(array('type'=>'date','name'=>'date','id'=>'upd_date','class'=>'form-control','placeholder'=>'Date','required'=>'true'));?>
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
          var mrp = $(this).data('mrp');
          var price = $(this).data('price');
          var date = $(this).data('date');
          var bv = $(this).data('bv');
         
         
          $('#id').val(id);
          $('#upd_product').val(product);
          $('#upd_mrp').val(mrp);
          $('#upd_price').val(price);
          $('#upd_date').val(date);
          $('#upd_bv').val(bv);
          

        });	

        $('body').on('click','.dlt',function(){
            var id = $(this).data('id');
            var check = confirm('Are You Sure?');
            if(check==true){
                $.ajax({
                    type:"POST",
                    url:"<?php echo base_url('product-master-delete');?>",
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