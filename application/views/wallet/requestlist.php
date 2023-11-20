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
                            <div class="col-md-4 col-12"><p>From Date</p><input type="date" id="from_date" class="form-control mb-2" name="from_date"> </div>
                            <div class="col-md-4 col-12"><p>To Date</p><input type="date" class="form-control mb-2" id="to_date" name="to_date"></div>
                            <div class="col-md-4 col-12 mt-4"  style="padding-top: 10px;"><button type="button" class="btn btn-lg btn-success text-center find">Search</button></div>
                            <div class="col-md-12">  
                                <div id="loader" class="text-center hidden">
                                    <h4>Please Wait.. Processing Payment. Do not Reload Page.</h4>
                                    <img src="<?php echo file_url('assets/images/loader-2.gif'); ?>" alt="loader">
                                </div>   
                                <div class='text-center text-success hidden' id="success">
                                    <h2>Payment Processed Successfully!</h2>
                                    <span style='font-size:100px;'><i class='fa fa-check-circle'></i></span>
                                </div>                     
                                <div class="table-responsive" id="result">
                                    <table class="table data-table" id="bootstrap-data-table-export">  
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <?php
                                                    if($this->session->role=='admin'){
                                                ?>
                                                <th>Member ID</th>
                                                <th>Member Name</th>
                                                <th>Account No</th>
                                                <th>IFSC Code</th>
                                                <?php } ?>
                                                <th>Request Date</th>
                                                <th>Amount</th>
                                                <?php
                                                    if($this->session->role=='admin'){
                                                        if(!isset($register)){
                                                ?>
                                                <th>Action</th>
                                                <?php 
                                                        } 
                                                        else{
                                                ?>
                                                <th>Approve Date</th>
                                                <?php 
                                                        }
                                                    }else{ 
                                                ?>
                                                <th>Approve Date</th>
                                                <th>Status</th>
                                                <?php } ?>
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
                                                        }
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <?php
                                                    if($this->session->role=='admin'){
                                                ?>
                                                <td><?php echo $member['username']; ?></td>
                                                <td><?php echo $member['name']; ?></td>
                                                <td><?php echo $member['account_no']; ?></td>
                                                <td><?php echo $member['ifsc']; ?></td>
                                                <?php } ?>
                                                <td><?php echo date('d-m-Y',strtotime($member['date'])); ?></td>
                                                <td><?php echo $this->amount->toDecimal($member['payable']); ?></td>
                                                <?php
                                                    if($this->session->role=='admin'){
                                                        if(!isset($register)){
                                                ?>
                                                <td>
                                                    <form action="<?php echo base_url('wallet/approvepayout'); ?>" method="post" onSubmit="return validate('accept');" class="float-left" style="margin-right:5px;">
                                                        <button type="submit" value="<?php echo $member['id'] ?>" name="request_id" class="btn btn-sm btn-success">Approve</button>
                                                    </form>
                                                    <form action="<?php echo base_url('wallet/rejectpayout'); ?>" method="post" onSubmit="return validate('reject');" class="float-left">
                                                        <button type="submit" value="<?php echo $member['id'] ?>" name="request_id" class="btn btn-sm btn-danger">Reject</button>
                                                    </form>
                                                </td>
                                                <?php 
                                                        } 
                                                        else{
                                                ?>
                                                <td><?php if($member['approve_date']!='')echo date('d-m-Y',strtotime($member['approve_date'])); ?></td>
                                                <?php 
                                                        }
                                                    }else{ 
                                                ?>
                                                <td><?php if($member['approve_date']!='')echo date('d-m-Y',strtotime($member['approve_date'])); ?></td>
                                                <td><?php echo $status; ?></td>
                                                <?php } ?>
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
    </div>
</section>

                
    <script>
	
		var table;
		$(document).ready(function(e) {
			
			$('#position').change(function(){
				var position=$(this).val();
				$('#member_id').val('');
				$.ajax({
					type:"POST",
					url:"<?php echo base_url('members/getmembertable'); ?>",
					data:{position:position},
					success: function(data){
						$('#result').html(data);
						createDatatable();
					}
				});
			});

            var table=$('.data-table').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
               dom: 'Bfrtip',
                 buttons: [
                       'excel','print'
             ],
             // ,'pdf'
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


		$('body').on('click','.approve-all',function(){
			$.ajax({
				type:"POST",
				url:"<?php echo base_url("wallet/approveallpayout"); ?>",
				beforeSend: function(data){
					$('#details,#result').hide();
					$('#loader').removeClass('hidden');
				},
				success: function(data){
					$('#loader').addClass('hidden');
					$('#success').removeClass('hidden');
					window.location="<?php echo base_url('wallet/exportpaymentreport/?from='); ?>"+data+"&to="+data+"&type=pay";
				}
			});
		});

        $('body').on('click','.find',function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url("wallet/findrequestlist"); ?>",
                data:{from_date:from_date,to_date:to_date},
                success: function(data){
                        $('#result').html(data);
                        createDatatable();
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
			$('#result').find('table').parent().addClass('table-responsive');
		}
		function validate(type){
			if(type=='accept'){
				msg="Confirm Payout of this Member?";
			}
			else{
				msg="Confirm Reject Payment of this Member?";
			}
			if(!confirm(msg)){
				return false;
			}
		}
	</script>
    
    	
