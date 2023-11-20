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
                        	<div class="col-md-4 col-lg-4 col-12 mb-3"><buton type="button"   class="btn btn-sm btn-info form-control payoutlist" data-id = "1" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-list-alt" aria-hidden="true"></i><span class="ml-2">Closing Monthly Income</span></buton></div>
                        	<div class="col-md-4 col-lg-4 col-12 mb-3"><buton type="button"   class="btn btn-sm btn-info form-control payoutlist" data-id = "2" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-list-alt" aria-hidden="true"></i><span class="ml-2">Closing Direct Sponsor Income</span></buton></div>
                        	<div class="col-md-4 col-lg-4 col-12 mb-3"><buton type="button"   class="btn btn-sm btn-info form-control payoutlist" data-id = "3" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-list-alt" aria-hidden="true"></i><span class="ml-2">Closing Level Income</span></buton></div>
                        	
                        	<div class="col-md-12 col-lg-12 table-responsive">
                            	<table class="table data-table stripe hover nowrap table-bordered">
                                    <thead class="" style="background-color: #344f69; color: white;">
                                        <tr>    
                                            <th>#</th>                                         
                                            <th>Username</th>                        
                                            <th>Member Name</th>                        
                                            <th>Activation Date</th>                        
                                            <th>Amount</th>                        
                                                               
                                            <th>Action </th>                                          
                                        </tr>
                                    </thead>
                                    <tbody class="text-bold">
                                        <?php
                                            if(!empty($payout_list)){
                                                $i=0;
                                                foreach ($payout_list as $key => $value) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $value['username'];?></td> 
                                                        <td><?php echo $value['name'];?></td> 
                                                        <td><?php echo date('d-m-Y',strtotime($value['activation_date']));?></td>
                                                        <td><i class="fa fa-inr"  aria-hidden="true"></i><span class="text-dark"> <?php if(!empty($value['amount'])){ echo $value['amount']; }else{ echo '0.00';} ?></span> </td> 
                                                        <td><buton type="button" data-regid="<?php echo $value['regid'];?>"  class="btn btn-sm btn-info paylist" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-list-alt" aria-hidden="true"></i><span class="ml-2">View Details</span></buton></td> 

                                                     
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
    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PayOut List Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="row">
                            
                            <div class="col-md-12 col-lg-12 text-right"><a href="" class="btn btn-xl btn-success  mb-3" id="payoutprint">Print</a> </div>
                            <div class="col-md-12 col-lg-12 table-responsive">
                                <table class="table data-table  table-bordered">
                                    <thead >
                                        <tr>    
                                            <th>#</th>                                         
                                            <th>Date</th>                        
                                            <th>Type</th>                        
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-bold addlist">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    <!-- -------------------------MODEL AREA END---------------------------------- -->
    <div class="modal fade " id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">PayOut List Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="row">
                            
         <div class="col-md-12 col-lg-12 text-right"><a href="" class="btn btn-xl btn-success  mb-3" id="payoutprint1">Print</a> <a id="downloadLink"  class="btn btn-xl btn-secondary  mb-3" onclick="exportF(this)">Export to excel</a> </div>
                            <div class="col-md-12 col-lg-12 table-responsive">
                                <table class="table data-table stripe hover nowrap table-bordered" id="tables">
                                    <thead >
                                        <tr>    
                                            <th>#</th>                                         
                                            <th>Name</th>                                         
                                            <th>Username</th>                                         
                                            <th>Date</th>                        
                                            <th>Type</th>                        
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-bold addlist1">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    function exportF(elem) {
    var table = document.getElementById("tables");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "excelfile.xls"); // Choose the file name
    return false;
}
	
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

        $('body').on('click','.paylist',function(){
           var regid = $(this).data('regid');
           $.ajax({
                type: "POST",
                url: "<?php echo base_url('payout-list-details');?>",
                data: {regid:regid},
                // dataType: 'JSON',
                success: function(result){
                    $('.addlist').html(result);
                    $('#payoutprint').attr('href','<?php echo base_url('members/payout_list_print?regid=');?>'+regid);


                    // alert(result);
                    // console.log(result);
                }

            });
                
        });

        $('body').on('click','.payoutlist',function(){
           var type = $(this).data('id');
           $.ajax({
                type: "POST",
                url: "<?php echo base_url('payout-list-details-all');?>",
                data: {type:type},
                // dataType: 'JSON',
                success: function(result){
                    console.log(result);
                    $('.addlist1').html(result);
                   $('#payoutprint1').attr('href','<?php echo base_url('members/payout_list_print_all?type=');?>'+type);


                    // alert(result);
                    // console.log(result);
                }

            });
                
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