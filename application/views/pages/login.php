<?php
   if(isset($_GET['amt']))  {
      $_SESSION['amts'] = $_GET['amt'];
   }
?>
<style type="text/css">
        /* .login-page{
                background-image: url(<?php echo base_url('assets/images/loginbg.jpg'); ?>);
                width: 100%;
                background-repeat: no-repeat;
                background-position: cover;
          
        } */
        .login-page{
            /* background: linear-gradient(302deg,#ff963c78,#fff,#6ccda0,#8bb4fe); */
            background: linear-gradient(64deg,#53b9fa 25%,#694eb0 70%,#C13A3C 5%);
            box-shadow:5px 5px 10px black;
        }
    </style>
        <div class="login-box">
            <div class="login-logo">
                 <a href="#"> <img src="<?php echo base_url('assets/images/icon.png');?>" style="border-radius: 50%;box-shadow:5px 5px 10px black" width="50%"> </a>
                
            </div>
           
           
            <!-- /.login-logo -->
            <div class="card" style="box-shadow:5px 5px 10px black">
                <div class="card-body login-card-body" style="border-radius: 15px;">
                    <h4 class="text-center text-uppercase mb-3">LOGIN</h4>
                <!-- <p class="login-box-msg">Sign in to start your session</p> -->
                
                    <?php echo form_open('login/validateLogin'); ?>
                        <div class="input-group mb-3">
                            <input type="username" class="form-control" name="username" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-danger form-group">
                            <?php if($this->session->flashdata("logerr")!==NULL){ echo $this->session->flashdata("logerr");} ?>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                 <a href="<?php echo base_url('Members/register');?>" class="btn btn-block text-light btn-primary">Register</a>
                                <!-- <div class="icheck-primary" >
                                   
                                    <input type="checkbox" id="remember">
                                    <label for="remember">Remember Me</label>
                                </div> --> 
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-block  btn-primary text-light">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    <?php echo form_close(); ?>
                
                
                    <p class="mb-1">
                        <a href="<?php echo base_url('forgotpassword/'); ?>">I forgot my password</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
      
</body>