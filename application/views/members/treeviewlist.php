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
                        <div class="col-md-12 col-lg-12">
                        <div class="right_col" role="main">
                            <div class="">
                                <div class="clearfix"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2 style="font-size:16px;"><i class="fa fa-sitemap"></i> Genealogy Tree</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">                   
                                            <div class="form-group row">
                                                <div class="col-md-3"></div>
                                                <!-- <div class="col-md-4 col-sm-12">
                                                    <input type="text" id="txtsearchmember" class="form-control" placeholder="Enter Member ID" />
                                                    <input type="hidden" id="member_id" value="<?php echo $_SESSION['id'];?>" class="form-control" placeholder="Enter Member ID" />
                                                </div>
                                                <div class="col-md-2 col-sm-12">
                                                    <input type="button" class="btn btn-primary" value="Search" onclick="SearchTreedata();" />
                                                </div> -->
                                                <div class="col-md-3"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="text-center">
                                                        <!-- <a onclick="drawChart();" class="btn btn-success"><i class="fa fa-arrow-up"></i> Top</a> -->
                                                    </div>
                                                    <div id="chart" style="overflow-x: auto;">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- <script type="text/javascript">
        google.load("visualization", "1", { packages: ["orgchart"] });
        google.setOnLoadCallback(drawtree);
        function drawChart(memberid) {          
            drawtree(memberid);
        }
       var memberid =  $('#member_id').val();
        function drawtree(memberid) {
            $.ajax({
                type: "POST",
                url: "members/treeviews",
                data: { memberid: memberid},
                dataType: "json",
                success: function (r) {
                 alert(JSON.stringify(r));
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Entity');
                    data.addColumn('string', 'ParentEntity');
                    data.addColumn('string', 'ToolTip');
                    for (var i = 0; i < r.d.length; i++) {
                        var memberId = r.d[i][0].toString();
                        var memberName = r.d[i][1];
                        var parentId = r.d[i][2] != null ? r.d[i][2].toString() : '';
                        var position = r.d[i][3];
                        var sponsorid = r.d[i][4];
                        var Isactive = r.d[i][5];
                        var activedate = r.d[i][6];


                        //create static div
                        var div = null;
                        if (Isactive == true) {
                            div = '<div onclick="gettree(\'' + memberId + '\')">';
                        } else {
                            div = '<div style="background-color:red;"  onclick="gettree(\'' + memberId + '\')">';
                        }
                        div += memberName + ' <br/><span>' + memberId + '</span>' + '<div><img src = "/Content/images/image.png"/></div> <div>' + position + '</div>' + '<div> ' + sponsorid + '</div >' + '<div style="width: 80px;"> ' + activedate + '</div >';
                        data.addRows([[{
                            v: memberId,
                           
                            f: div
                        }, parentId, memberName]]);
                    }
                    var chart = new google.visualization.OrgChart($("#chart")[0]);
                    chart.draw(data, { allowHtml: true });
                    $('.google-visualization-orgchart-node').addClass('treediv').css('border', '0');
                },
                failure: function (r) {
                    alert(r.d);
                },
                error: function (r) {
                    alert(r.d);
                }
            });
        }

        function gettree(memberid) {
           // alert(memberid);
            drawtree(memberid)
        }
        function SearchTreedata() {
            var memid = $("#txtsearchmember").val();
            if (memid == "" || memid == null) {
                alert('Please Enter Member ID');
            }
            else {
                drawtree(memid)
            }
        }
    </script> -->

<!-- </div> -->
    

