<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border bg-info">
                    <div class="card-title"><?php echo $title ;?> </div>
                </div>
                <div class="card-body row">
                    <div class="col-md-12 ">
                        <form action="<?php echo base_url('qsql/goquery');?>" id="myform" enctype="multipart/form-data" method="post" accept-charset="utf-8">                        	
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label class="col-sm-12 col-md-2 col-form-label">Query <span class="text-danger">*</span> </label>
                                <div class="col-sm-12 col-md-6">
                                    <textarea type="text" name="query"  id="query"  class="form-control" required cols="100" rows="10"></textarea>
                                     
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-sm-4">
                                    <input type="hidden" id="id">
                                    <input type="submit"  value="Build" id="submit" class="btn btn-success btn-block btn-sm ">
                                </div>
                                <div class="col-sm-3"> 
                                    <button type="button" class="btn btn-danger btn-sm cancel-edit hidden">Cancel</button>
                                </div>
                            </div>
                        </form>  
                    </div>	
                                      
                 </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#table').DataTable();

    $('body').on('click','.edit-btn',function(){
        $('.cancel-edit').removeClass('hidden');
		$('#id').val($(this).val()); 
        $('#brand').val($(this).closest('tr').children().eq(1).text()).focus(); 
		  var id=$(this).closest('tr').children().eq(0).text();
		//alert(id);
        $('#id').attr('name','id');
        $('#myform').attr('action','<?php echo base_url('master_op/update_brand');?>');
       // $('#submit').attr('name','updateproduct');
		$('#submit').attr('value','Update Class');
    });
    $('body').on('click','.cancel-edit',function(){

        $(this).addClass('hidden');
        $('#brand').val('');
        $('#id').val('');
        $('#id').removeAttr('name');
        $('#myform').attr('action','<?php echo base_url('master_op/add_brand'); ?>');
       // $('#submit').attr('name','addproduct');
        $('#submit').attr('value','Add Product');
    });
});
</script>
