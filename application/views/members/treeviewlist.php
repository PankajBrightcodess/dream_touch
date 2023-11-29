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
                                                <div class="col-md-4 col-sm-12">
                                                    <input type="text" id="txtsearchmember" class="form-control" placeholder="Enter Member ID" />
                                                </div>
                                                <div class="col-md-2 col-sm-12">
                                                    <input type="button" class="btn btn-primary" value="Search" onclick="SearchTreedata();" />
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="text-center">
                                                        <a onclick="drawChart();" class="btn btn-success"><i class="fa fa-arrow-up"></i> Top</a>
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
    

<!-- </div> -->
    

