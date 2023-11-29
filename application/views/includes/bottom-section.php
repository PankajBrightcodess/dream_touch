</div>
            <!-- /.content-wrapper -->
            <footer class="main-footer text-light" >
                <strong>Copyright &copy; <?php echo SESSION_YEAR; ?> <a href="http://adminlte.io" class="hidden">AdminLTE.io</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    
                </div>
            </footer>
            
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo file_url("includes/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo file_url("includes/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
        <!-- overlayScrollbars -->
        <script src="<?php echo file_url("includes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo file_url("includes/dist/js/adminlte.js"); ?>"></script>
        
        <?php
		if(!empty($bottom_script)){
		  foreach($bottom_script as $key=>$script){
			  if($key=="link"){
					if(is_array($script)){
						foreach($script as $single_script){
							echo "<script src='$single_script'></script>\n\t\t";
						}
					}
					else{
						echo "<script src='$script'></script>\n\t\t";
					}
			  }
			  elseif($key=="file"){
				if(is_array($script)){
					foreach($script as $single_script){
						echo "<script src='".file_url("$single_script")."'></script>\n\t\t";
					}
				}
				else{
					echo "<script src='".file_url("$script")."'></script>\n\t\t";
				}
			  }
		  }
		}
		?>
        
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo file_url("includes/dist/js/demo.js"); ?>"></script>
        <script src="<?php echo file_url("includes/custom/custom.js"); ?>"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
    

    <script type="text/javascript">
        google.load("visualization", "1", { packages: ["orgchart"] });
        google.setOnLoadCallback(drawtree);
        function drawChart(memberid) {          
            drawtree(memberid);
        }

        function drawtree(memberid) {
            debugger;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('members/treelistshow') ;?>",
                data: {regid: memberid},
                // contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(r) {
                  console.log(r);
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Entity');
                    data.addColumn('string', 'ParentEntity');
                    data.addColumn('string', 'ToolTip');
                 
                    for (var i = 0; i < r.length; i++) {
                 
                        var memberId = r[i]['username'];
                        var regid = r[i]['regid'];
                        var memberName = r[i]['name'];
                        var parentId = r[i]['ref'] != null ? r[i]['ref'].toString() : '';
                        // var position = r.d[i][3];
                        var sponsorid = r[i]['ref'];
                        var Isactive = r[i]['package'];
                        
                        if(Isactive!= '--'){
                            var check = true;
                        }else{
                            var check = false;
                        }
                        var activedate = r[i]['activation_date'];
                      
                            
                        //create static div
                        var div = null;
                        if (check == true) {
                            div = '<div onclick="gettree(\'' + regid + '\')">';
                        } else {
                            div = '<div style="background-color:red;"  onclick="gettree(\'' + memberId + '\')">';
                        }
                        // <img src = "<?php echo base_url('assets/images/image.png') ;?>"/>
                        div += memberName + ' <br/><span>' + memberId + '</span>'+ '<div></div>'  + '<div style="width: 80px;">' + activedate + '</div>';
                        data.addRows([[{
                            v: memberId,
                            //f: memberName + ' <br/><span>' + memberId + '</span>' + '<div><img src = "<?php echo base_url('assets/images/image.png') ;?>" /></div>'
                             f: div
                        }, parentId, memberName]]);
                    }
                    var chart = new google.visualization.OrgChart($("#chart")[0]);
                    chart.draw(data, { allowHtml: true });
                    $('.google-visualization-orgchart-node').addClass('treediv').css('border', '0');
                }
                // failure: function (r) {
                //     alert(r);
                // },
                // error: function (r) {
                //     alert(r);
                // }
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
        
		// var table=$('.data-table').DataTable({
		// 	scrollCollapse: true,
		// 	autoWidth: false,
		// 	responsive: true,
		// 	columnDefs: [{
		// 		targets: "no-sort",
		// 		orderable: false,
		// 	}],
		// 	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		// 	"language": {
		// 		"info": "_START_-_END_ of _TOTAL_ entries",
		// 		searchPlaceholder: "Search"
		// 	},
		// });	

      
       
        $('#parent_id').trigger('change');
    });
    </script>
    </body>
</html>