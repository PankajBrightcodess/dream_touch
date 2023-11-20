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
                            <div class="col-md-12">
                                <div class="table-responsive" id="result">
                                    <table class="table data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>E-Pin</th>
                                                <th>Approved Date</th>
                                                <th>Package</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $epins=$epins;
                                                if(is_array($epins)){$i=0;
                                                    foreach($epins as $epin){
                                                        $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $epin['epin']; ?></td>
                                                <td><?php echo date('d-m-Y',strtotime($epin['added_on'])); ?></td>
                                                <td><?php echo $epin['package']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs activate-btn" data-toggle="modal" data-target="#modal-default" data-package="<?php echo $epin['package_id'] ?>"
                                                            value="<?php echo $epin['epin'] ?>" onClick="$('#username').val('').trigger('keyup');" >Activate</button>
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
    </div>
</section>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
        	<?php echo form_open('members/activatemember', 'id="myform" onSubmit="return validate()"'); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Activate Member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                	<div class="row">
                    	<div class="col-md-12">
                        	<div class="form-group">
								<?php
                                    echo create_form_input('text','epin','E-Pin',true,'',array("id"=>"epin","readonly"=>"true"));
                                ?>
                            </div>
                        	<div class="form-group">
								<?php
                                    echo create_form_input("text","","Member ID",true,'',array("id"=>"username")); 
                                    echo create_form_input("hidden","regid","",false,'0',array("id"=>"regid")); 
                                ?>
                                <div id="name" class="lead"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
					<?php
                        echo create_form_input('hidden','package_id','',false,'',array("id"=>"package_id"));
                    ?>
                	<button type="submit" class="btn btn-success" name="activatemember" value="Activate" id="savebtn">Activate Member</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
    <script>
	
		var table;
		$(document).ready(function(e) {
			createDatatable();
			$('#username').keyup(function(){
				$('#name').html('');
				$('#regid').val('');
				$('#savebtn').attr('disabled',true);
			});
			$('#username').blur(function(){
				var username=$(this).val();
				var status='downline,not activated';
				if(username!=''){
					$.ajax({
						type:"POST",
						url:"<?php echo base_url("members/getmemberid/"); ?>",
						data:{username:username,status:status},
						success: function(data){
							//console.log(data);
							data=JSON.parse(data);
							if(data['regid']!=0){
								$('#name').html("<span class='text-success'>"+data['name']+"</span>");
								$('#regid').val(data['regid']);
								$('#savebtn').prop("disabled",false);
							}
							else{$('#name').html("<span class='text-danger'>"+data['name']+"</span>");}
						}
					});
				}
			});
			$('body').on('click','.activate-btn',function(){
				$('#epin').val($(this).val());
				$('#package_id').val($(this).data('package'));
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
	</script>
    
    	
