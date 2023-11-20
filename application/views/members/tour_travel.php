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
                                <div class="table-responsive" id="result">
                                    <table class="table table-striped data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>SL NO.</th>
                                                <th>LAVEL</th>
                                                <th>ACHEIVMENT RANK</th>
                                                <th class="select-filter">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>1</th>
                                            <th><h5 class="badge badge-lg rounded-pill bg-info p-2">10 Direct + Rank Platinum</h5></th>
                                            <th><span class="badge badge-lg rounded-pill bg-success p-2">National Tour</span></th>
                                            <th class="select-filter text-bold">
                                                 <?php
                                                 if(!empty($list['level1'])){
                                                    if($list['level1']['count']>=10){
                                                        ?><span class="text-success">✔</span><?php
                                                    }else{
                                                        ?><span class="text-danger m-3">✖</span> <?php
                                                    }
                                                 }else{
                                                    ?><span class="text-danger m-3">✖</span> <?php
                                                 }
                                                 ?>
                                        </th>
                                        </tr>

                                        <tr>
                                            <th>2</th>
                                            <th><h5 class="badge badge-lg rounded-pill bg-info p-2">10 Direct + Rank Ruby</h5></th>
                                            <th><span class="badge badge-lg rounded-pill bg-success p-2">National Tour</span></th>
                                            <th class="select-filter text-bold">
                                                 <?php
                                                 if(!empty($list['level2'])){
                                                    if($list['level2']['count']>=100){
                                                        ?><span class="text-success">✔</span><?php
                                                    }else{
                                                        ?><span class="text-danger m-3">✖</span> <?php
                                                    }
                                                 }else{
                                                    ?><span class="text-danger m-3">✖</span> <?php
                                                 }
                                                 ?>
                                        </th>
                                        </tr>

                                        <tr>
                                            <th>3</th>
                                            <th><h5 class="badge badge-lg rounded-pill bg-info p-2">10 Direct + Rank Diamond</h5></th>
                                            <th><span class="badge badge-lg rounded-pill bg-success p-2">Foreign Tour</span></th>
                                            <th class="select-filter text-bold">
                                                 <?php
                                                 if(!empty($list['level3'])){
                                                    if($list['level3']['count']>=1000){
                                                        ?><span class="text-success">✔</span><?php
                                                    }else{
                                                        ?><span class="text-danger m-3">✖</span> <?php
                                                    }
                                                 }else{
                                                    ?><span class="text-danger m-3">✖</span> <?php
                                                 }
                                                 ?>
                                        </th>
                                          
                                        </tr>

                                        <tr>
                                            <th>4</th>
                                            <th><h5 class="badge badge-lg rounded-pill bg-info p-2">10 Direct + Rank White Diamond</h5></th>
                                            <th><span class="badge badge-lg rounded-pill bg-success p-2">Foreign Tour</span></th>
                                            <th class="select-filter text-bold">
                                                 <?php
                                                 if(!empty($list['level4'])){
                                                    if($list['level4']['count']>=10000){
                                                        ?><span class="text-success">✔</span><?php
                                                    }else{
                                                        ?><span class="text-danger m-3">✖</span> <?php
                                                    }
                                                 }else{
                                                    ?><span class="text-danger m-3">✖</span> <?php
                                                 }
                                                 ?>
                                        </th>
                                        </tr>
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