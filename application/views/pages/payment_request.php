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
                            <div class="col-md-12 mt-2 table-responsive" id="result">
                                <table class="table data-table" id="bootstrap-data-table-export" >
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>MEMBER ID</th>
                                        <th>MEMEBR NAME</th>
                                        <th>AMOUNT</th>
                                        <th>DETAILS</th>
                                        <th>UPLOAD FILE</th>
                                        <th>REQUEST DATE</th>
                                        <th>APPROVE STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                     <?php
                                        $requests=$requests;
										// echo PRE;
										// print_r($requests);
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
                                        <td><button class="btn btn-sm btn-success m-1 approve" data-id="<?= $request['id'];?>">Approve</button><button class="btn btn-sm btn-danger approve_cancel" data-id="<?= $request['id'];?>">Cancel</button></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
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
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
<script>
	var table;
	$(document).ready(function(e) {
		// createDatatable();

		$('body').on('click','.imgs',function(){
            var image = $(this).data('image');
			$('.img').attr("src","<?= base_url()?>"+image);
        });


        $('body').on('click','.approve',function(){
            var id = $(this).data('id');
            if(confirm("Are You Sure?")==true){
                $.ajax({
					type:"POST",
					url:"<?php echo base_url('profile/approve_data'); ?>",
					data:{id:id},
					success: function(data){
						location.reload();
						
					},
				});
            }
        });
		
        $('body').on('click','.approve_cancel',function(){
            var id = $(this).data('id');
            if(confirm("Are You Sure?")==true){
                $.ajax({
					type:"POST",
					url:"<?php echo base_url('profile/approve_cancel'); ?>",
					data:{id:id},
					success: function(data){
						location.reload();
					},
				});
            }
        });
    });

	function createDatatable(){
			$('#status').html('');
            table=$('#bootstrap-data-table-export').DataTable();
			table.columns('.select-filter').every(function(){
				var that = this;
				var pos=$('#status');
				// Create the select list and search operation
				var select = $('<select class="form-control" />').appendTo(pos).on('change',function(){
								that.search("^" + $(this).val() + "$", true, false, true).draw();
							});
					select.append('<option value=".+">All</option>');
				// Get the search data for the first column and add to the select list
				this.cache( 'search' ).sort().unique().each(function(d){
						select.append($('<option value="'+d+'">'+d+'</option>') );
				});
			});
			$('#member_id').on('keyup',function(){
				table.columns(1).search( this.value ).draw();
			});
		}
		function validate(){
			if(!confirm("Confirm Activate this Member?")){
				return false;
			}
		}
	
	
	// function validate(){
	// 	var avl=Number($('#avl_balance').val());
	// 	var amount=Number($('#amount').val());
	// 	if($('#type').val()!='request'){
	// 		if(avl<amount){
	// 			alert("Pin Amount Must be less than Available Balance!");
	// 			return false;
	// 		}
	// 	}
	// }
</script>