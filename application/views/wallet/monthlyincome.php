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
                        	<div class="col-md-4">
                            	<div id="staus"></div>
                            </div>
                        </div><br>
                        <div class="row">
                        <div class="col-md-12">
                            <form method="get" action="<?= base_url('wallet/incomes/')?>">
                                <div class="row">
                                <div class="col-md-2 col-12">
                                    <p>Year</p>
                                    <select class="form-control" name="year" id="year" >
                                        <option value="">--Year--</option>
                                        <?php
                                        $year = 2030;
                                        for($i=2020; $i<=$year; $i++){
                                            ?><option value="<?= $i;?>"><?= $i;?></option><?php
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="col-md-2 col-12">
                                    <p>Month</p>
                                    
                                    <select class="form-control" name="month" id="Month" >
                                        <option value="">--Month--</option>
                                        <?php
                                       $month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                                        $c = 1;
                                        for($i=0; $i<count($month); $i++){
                                            ?><option value="<?= $c;?>"><?= $month[$i];?></option><?php
                                            $c++;
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="col-md-2 col-12">
                                    <p>Closing</p>
                                        <select class="form-control" name="closing" id="closing">
                                         <option value="">Select</option>
                                         <option value="1">First Closing</option>
                                         <option value="2">Second Closing</option>
                                         <option value="3">Third Closing</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-md-2 col-12">
                                        <p>From Date</p>
                                        <input type="date" name="from_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-2 col-12">
                                    <p>To Date</p>
                                    <input type="date" name="to_date" class="form-control">
                                    </div> -->
                                    <div class="col-md-2 col-12 mb-5">
                                         <p></p>
                                    <input type="submit" class="btn btn-sm btn-success mt-4" value="Search" required>
                                    </div>

                                </div>
                               </form> 
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive" id="result">
                                    <table class="table table-striped data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Date</th>
                                                <th>Income</th>
                                                <th class="select-filter">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $incomes=$incomes;
                                                if(is_array($incomes)){$i=0;
                                                    foreach($incomes as $income){
                                                        $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php if($income['date']!=''){echo date('d-m-Y',strtotime($income['date']));} ?></td>
                                                <td><?php echo $this->amount->toDecimal($income['amount']); ?></td>
                                                <td><?php echo $income['remarks']; ?></td>
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
		createDatatable();
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
				},
				error: function(data){
					alert(JSON.stringify(data))
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
</script>