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
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <?php echo form_open_multipart('members/approvelevel', 'id="myform" onSubmit="return validate();"'); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("text","","Member ID",false,$details['username'],array("readonly"=>"true")); 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("text","","Name",false,$details['name'],array("readonly"=>"true")); 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("date","","Request Date",false,$details['date'],array("readonly"=>"true")); 
                                                ?>
                                                
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("text","amount","Paid Amount",false,$details['amount'],array("readonly"=>"true")); 
													if($transaction_image===true){ 
												?><br>
                                    			
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("textarea","","Transaction Details",false,$details['details'],array("readonly"=>"true","rows"=>"4")); 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("text","","level",false,$details['levels'],array("readonly"=>"true","rows"=>"4")); 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <button type="button" class="btn btn-sm btn-info mt-5" data-toggle="modal" data-target="#mediumModal">View Transaction Details</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row">
                                       
                                        <div class="col-md-12">
                                            <?php
                                                echo create_form_input("hidden","regid","",false,$details['regid']); 
                                                echo create_form_input("hidden","id","",false,$details['id']); 
                                            	echo create_form_input("hidden","","",false,"",array("id"=>"type")); 
											?>
											<button type="submit" class="btn btn-sm btn-success action" name="approvelevel" value="Approve">Approve Level Request</button>
											<?php if($reject_request===true){ ?>
											<button type="submit" class="btn btn-sm btn-danger action" name="approvelevel" value="Reject">Reject Level Request</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if($transaction_image===true){ ?>
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="mediumModalLabel"></h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="<?php echo file_url($details['image']); ?>" alt="" id="img-popup" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script>
	$(document).ready(function(e) {
        $('body').on('click','.action',function(){
			var type=$(this).val();
			$('#type').val(type);
		});
    });
	function validate(){
		var type=$('#type').val();
		if(!confirm(type+" Level Request for this member?")){
			return false;
		}
	}
</script>