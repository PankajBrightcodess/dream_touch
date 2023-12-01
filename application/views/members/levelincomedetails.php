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
                            <?php if($title=='Downline Member List'){  ?>
                            <div class="col-3 hidden">
                                <select id="position" class="form-control">
                                    <option value="">All</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="col-3 hidden">
                                <input type="date" id="from" class="form-control">
                            </div>
                            <div class="col-3 hidden">
                                <input type="date" id="to" class="form-control">
                            </div>
                            <div class="col-md-3" id="status"></div>
                        </div><br>
                        <div class="row">
                            <div class="col-12">                            
                                <div class="table-responsive" id="result">
                                    
<table class="table data-table table-bordered" id="bootstrap-data-table-export">
    <thead>
        <tr>
            <th>Sl No.</th>
            <th>Member ID</th>
            <th>Member Name</th>
            <th>Amount</th>
           
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($rec)){ $i=0;
                foreach($rec as $key => $value) { $i++;
                    ?>
                    <tr>
                        <th><?= $i;?></th>
                        <th><?= $value['username'];?></th>
                        <th><?= $value['name'];?></th>
                        <th><?= $value['level1'];?></th>
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
			// createDatatable();
			$('#position,#from,#to').change(function(){
				getResult();
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
		
        function getResult(){
            var position=$('#position').val();
            var from=$('#from').val();
            var to=$('#to').val();
            $('#member_id').val('');
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('members/getmembertable'); ?>",
                data:{position:position,from:from,to:to},
                beforeSend: function(){
                    $('#loading').show();
                },
                success: function(data){
                    $('#result').html(data);
                    createDatatable();
                    $('#loading').hide();
                },
                error: function(data){
                    alert(JSON.stringify(data))
                }
            });
        }
                
		// function createDatatable(){
		// 	$('#status').html('');
        //     table=$('#bootstrap-data-table-export').DataTable();
		// 	table.columns('.select-filter').every(function(){
		// 		var that = this;
		// 		var pos=$('#status');
		// 		// Create the select list and search operation
		// 		var select = $('<select class="form-control" />').appendTo(pos).on('change',function(){
		// 						that.search("^" + $(this).val() + "$", true, false, true).draw();
		// 					});
		// 			select.append('<option value=".+">All</option>');
		// 		// Get the search data for the first column and add to the select list
		// 		this.cache( 'search' ).sort().unique().each(function(d){
		// 				select.append($('<option value="'+d+'">'+d+'</option>') );
		// 		});
		// 	});
		// 	$('#member_id').on('keyup',function(){
		// 		table.columns(1).search( this.value ).draw();
		// 	});
		// }
		function validate(){
			if(!confirm("Confirm Activate this Member?")){
				return false;
			}
		}
	</script>
    
    	
