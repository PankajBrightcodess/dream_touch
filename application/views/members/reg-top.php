<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- <title><php echo $title.' | I MARK'; ?></title> -->
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo file_url("includes/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo file_url("includes/dist/css/adminlte.min.css"); ?>">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?php echo file_url("includes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"); ?>">
         
        <!-- Custom style -->
        <link rel="stylesheet" href="<?php echo file_url('includes/custom/custom.css'); ?>">     
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <script src="https://kit.fontawesome.com/512e5abe13.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style type="text/css">
        .login-page{
          background: linear-gradient(180deg,#2e0727,#9a8a68);
        }
</style>
		
    </head>
    <body class="text-dark" >
    	<?php if(empty($body_class)){?>
        <div class="wrapper">
        <?php } ?>