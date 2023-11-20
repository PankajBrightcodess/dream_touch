<style type="text/css">
        .login-page{
          /* background: linear-gradient(180deg,#2e0727,#9a8a68); */
          background-image: url(<?php echo base_url('assets/images/loginbg.jpg'); ?>);
          background-repeat: no-repeat; 
          background-size: cover;
        }
</style>
<section class="content <?php if($this->session->userdata('user')===NULL){  echo "contact-us"; } ?> login-page">
	<div class="container-fluid">
        <div class="row">
            <?php
                if($this->session->userdata('user')===NULL){ 
            ?>
            <div class="col-md-3"></div>
            <div class="col-md-6"><br><br><br>
            <?php
                }
                else{
            ?>
            <div class="col-md-12">
            <?php
                }
            ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <h3 class="header smaller lighter green">Successfully Registered!</h3>
                                <h4>Welcome <?php echo $this->session->flashdata('mname'); ?>,</h4><br>
                                <ul style="list-style:none;">
                                    <li><h4>User ID : <?php echo $this->session->flashdata('uname');?></h4><br></li>
                                    <li><h4>Password : <?php echo $this->session->flashdata('pass');?></h4></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><br><br><br>
            </div>
                
        </div>
    </div>
</section>