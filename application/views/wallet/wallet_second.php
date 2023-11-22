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
                                <!--latest product info start-->
                                <section class="panel">
                                    <h3>
                                    	Total Income : <span class="text-success"><i class="fa fa-inr"></i> <?php echo $this->amount->toDecimal($wallet['actualwallet']); ?></span>
                                    </h3>
                                    <!-- <p class="text-danger">* 5% TDS and 5% Admin Charge Will be deducted</p> -->
                                </section>
                            </div>
                            <!-- <div class="col-md-4 col-12">
                            <button type="button" class="btn btn-sm btn-success form-control listdetails" data-check="1" data-toggle="modal" data-target=".bd-example-modal-lg">Total Monthly Income</button>
                            </div>
                            <div class="col-md-4 col-12">
                                <button type="button" class="btn btn-sm btn-success form-control listdetails" data-check="2" data-toggle="modal" data-target=".bd-example-modal-lg">Total Direct Sponser Income</button>
                            </div>
                            <div class="col-md-4 col-12">
                                <button type="button" class="btn btn-sm btn-success form-control listdetails" data-check="3" data-toggle="modal" data-target=".bd-example-modal-lg">Total Level Income</button>
                            </div> -->
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <div class="revenue-head">
                                        <!-- <h3>OUR WORKING (TRADING)</h3> -->
                                    </div>
                                    <div class="row">
                                        <!-- <div class="col-md-12">
                                            <p class="text-danger mb-1">Note :</p>
                                            <ol class="pl-3 ">
                                            	<li class="text-danger">Forex works 22 Days in a Month (30 DAYS)</li>
                                            	<li class="text-danger">Per Day Profit Target 1.5% - 1%</li>
                                            	<li class="text-danger">In Monthly Profit Average -25%</li>
                                            	<li class="text-danger">Amount Withdrawal requested after 6 P.M. will be approved next day. </li>
                                            	<li class="text-danger">After change of withdrawal status to 'Approved', Please wait 24 Hours to get amount in your Account.</li>
                                            	<li class="text-danger">After 24 Hours to Approved status, If amount is not credited in your Account then you can claim in next 7 working days.</li>
                                            </ol>
                                        </div> -->
                                         <div class="col-md-12 table-responsive"> 
                                            <table class="table table-striped data-table" id="bootstrap-data-table-export">
                                                <thead>
                                                    <tr>
                                                        <th>Sl No.</th>
                                                        <th>Request Date</th>
                                                        <th>Amount</th>
                                                        <th>TDS</th>
                                                        <th>Admin Charge</th>
                                                        <th>Payable Amount</th>
                                                        <th>Approve Date</th>
                                                        <th>Status</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $members=$members;
                                                        if(is_array($members)){$i=0;
                                                            foreach($members as $member){
                                                                $i++;
                                                                $status="<span class='text-danger'>Not Approved</span>";
                                                                if($member['status']==1){
                                                                    $status="<span class='text-success'>Approved</span>";
                                                                }elseif($member['status']==2 && $member['approve_date']===NULL){
                                                                    $status="<span class='text-danger'>Request Cancelled</span>";
                                                                }elseif($member['status']==2){
                                                                    $status="<span class='text-danger'>Request Rejected By Admin</span>";
                                                                }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo date('d-m-Y',strtotime($member['date'])); ?></td>
                                                        <td><?php echo $this->amount->toDecimal($member['amount']); ?></td>
                                                        <td><?php echo $this->amount->toDecimal($member['tds']); ?></td>
                                                        <td><?php echo $this->amount->toDecimal($member['admin_charge']); ?></td>
                                                        <td><?php echo $this->amount->toDecimal($member['payable']); ?></td>
                                                        <td>
														<?php 
															if($member['approve_date']!='0000-00-00' && $member['approve_date']!==NULL && $member['status']!=2){
																echo date('d-m-Y',strtotime($member['approve_date'])); 
															}
														?>
                                                        </td>
                                                        <td><?php echo $status; ?></td>
                                                        <td><?php echo $member['remarks']; ?></td>
                                                        <td>
                                                        	<?php
                                                            	if($member['status']==0){
															?>
                                                            <form action="<?php echo base_url('wallet/rejectpayout'); ?>" method="post" onSubmit="return validate('reject');" class="float-left">
                                                                <button type="submit" value="<?php echo $member['id'] ?>" name="request_id" class="btn btn-sm btn-danger">Cancel</button>
                                                            </form>
                                                            <?php
																}
															?>
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
                                </section>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">List Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="col-md-12 table-responsive">
        <table class="table table-striped data-table" id="bootstrap-data-table-export">
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody id="recs">
            
        </tbody>
        </table>
        </div>
      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    // MODAL AREA
    
    // MODAL AREA
	$(document).ready(function(e) {
        createDatatable();
        $('body').on('click','.listdetails',function(){
             var id = $(this).data('check');
             $.ajax({
                url:"<?php echo base_url('wallet/walletlist') ;?>",
                method:"POST",
                data:{id:id},
                success:function(data){
                    $('#recs').html(data);
                    // alert(data);
                    // console.log(data);
                }
             });
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
	}
</script>