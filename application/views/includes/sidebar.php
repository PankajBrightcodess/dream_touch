<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-no-expand <?php echo SIDEBAR_COLOR; ?>">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>" class="brand-link <?php echo BRAND_COLOR; ?>" style="color:white;">
        <img src="<?php echo file_url("assets/images/icon.png"); ?>" alt="Foodoo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light "><b><?php echo PROJECT_NAME; ?></b></span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            	<img src="<?php echo $user['photo']; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            	<a href="#" class="d-block text-bold"><?= $this->session->name; ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
         <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">                
            <?php 
            if(!empty($sidebarmenu)){
                foreach($sidebarmenu as $sidebarlist){
                //echo $sidebarlist['id'];
                if(empty($sidebarlist['submenu'])){?>
            <li class="nav-item">
                <a class="<?php echo activate_menu($sidebarlist['activate_menu']); ?> nav-link" href="<?php echo base_url($sidebarlist['base_url']); ?>">
                    <?php echo $sidebarlist['icon'];?>
                    <p><?php echo $sidebarlist['name'];?></p>
                </a>
            </li>
            <?php }else{ $not = json_decode($sidebarlist['activate_not'],true);?>
            <li class="nav-item has-treeview   <?php echo activate_dropdown($sidebarlist['activate_menu'],'li',$not); ?>">
                <a class="nav-link <?php echo activate_dropdown($sidebarlist['activate_menu'],'a',$not); ?>" href="#" data-toggle="treeview">
                    <?php echo $sidebarlist['icon'];?>
                    <p><?php echo $sidebarlist['name'];?> <i class="right fas fa-angle-left"></i></p>
                </a>
                <!-- nav nav-treeview -->
                <ul class="nav nav-treeview">
            <?php foreach($sidebarlist['submenu'] as $submenu){?>    
                
                    <li class='nav-item'>
                        <a class="nav-link <?php echo activate_menu($submenu['activate_menu']); ?>" href="<?php echo base_url($submenu['base_url']); ?>">
            <?php if(!empty($submenu['icon'])){ echo "$submenu[icon]"; }else{?><i class="nav-icon fa fa-plus"></i><?php } ?> 
                            <p><?php echo $submenu['name'];?></p>
                        </a>
                    </li>
                
            <?php } ?>       
                </ul>
            </li>
            <?php       }
                }
            }else{

            }
            ?>
            </ul>
        </nav> 
        <!-- /.sidebar-menu -->
        <!-- Sidebar Menu -->
        <nav class="mt-2 hidden">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>" class="nav-link <?php echo activate_menu('dashboard'); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
				<?php
				if($this->session->role!='admin'){
				?>
                <li class="nav-item has-treeview <?php echo activate_dropdown('profile'); ?>">
                    <a href="#" class="nav-link <?php echo activate_dropdown('profile','a'); ?>">
                        <i class="nav-icon far fa-user"></i>
                        <p>Member Details <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url("profile/"); ?>" class="nav-link <?php echo activate_menu('profile'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("profile/changepassword/"); ?>" class="nav-link <?php echo activate_menu('profile/changepassword'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("profile/accdetails/"); ?>" class="nav-link <?php echo activate_menu('profile/accdetails'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("profile/kyc/"); ?>" class="nav-link <?php echo activate_menu('profile/kyc'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Upload KYC</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php 
					}else{
				?>
                <li class="nav-item">
                    <a href="<?php echo base_url('profile/changepassword/'); ?>" class="nav-link <?php echo activate_menu('profile/changepassword'); ?>">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Change Password</p>
                    </a>
                </li>
                <?php
					} 
				?>
                <li class="nav-item has-treeview <?php echo activate_dropdown('members'); ?>">
                	<a href="#" class="nav-link <?php echo activate_dropdown('members','a'); ?>">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>Genealogy <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url("members/"); ?>" class="nav-link <?php echo activate_menu("members"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Member Registration</p>
                            </a>
                        </li>
                        <?php if($this->session->role=='member'){ ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url("members/mydirects/"); ?>" class="nav-link <?php echo activate_menu("members/mydirects"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Direct Sponsor</p>
                            </a>
                        </li>
						<?php } ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url("members/downline/"); ?>" class="nav-link <?php echo activate_menu("members/downline"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Downline</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("members/treeview/"); ?>" class="nav-link <?php echo activate_menu("members/treeview"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Treeview</p>
                            </a>
                        </li>
                        <?php if($this->session->role=='admin'){ ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url("members/kyc/"); ?>" class="nav-link <?php echo activate_menu("members/kyc"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>KYC Requests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("members/approvedkyc/"); ?>" class="nav-link <?php echo activate_menu("members/approvedkyc"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Approved KYC</p>
                            </a>
                        </li>
						<?php } ?>
                   	</ul>
               	</li>
                <li class="nav-item has-treeview <?php echo activate_dropdown('epins'); ?>">
                	<a href="#" class="nav-link <?php echo activate_dropdown('epins','a'); ?>">
                        <i class="nav-icon fas fa-key"></i>
                        <p>E-Pin Management <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if($this->session->role=='admin'){ ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/requestlist/"); ?>" class="nav-link <?php echo activate_menu("epins/requestlist"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-Pin Requests</p>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/used/"); ?>" class="nav-link <?php echo activate_menu("epins/used"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Used E-Pin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/unused/"); ?>" class="nav-link <?php echo activate_menu("epins/unused"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fresh E-Pin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/transfer/"); ?>" class="nav-link <?php echo activate_menu("epins/transfer"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-Pin Transfer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/transferhistory/"); ?>" class="nav-link <?php echo activate_menu("epins/transferhistory"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-Pin Transfer History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/"); ?>" class="nav-link <?php echo activate_menu("epins"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-Pin Generation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/generationhistory/"); ?>" class="nav-link <?php echo activate_menu("epins/generationhistory"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-Pin Generation History</p>
                            </a>
                        </li>
                        <?php if($this->session->role=='admin'){ ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url("epins/approvedlist/"); ?>" class="nav-link <?php echo activate_menu("epins/approvedlist"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-Pin Approved Requests</p>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if($this->session->role=='member'){  ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('wallet/incomes/'); ?>" class="nav-link <?php echo activate_menu('wallet/incomes'); ?>">
                        <i class="nav-icon fas fa-money-bill-alt"></i>
                        <p>My Incomes</p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo activate_dropdown('wallet','li',array('incomes')); ?>">
                    <a href="#" class="nav-link <?php echo activate_dropdown('wallet','a',array('incomes')); ?>">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Wallet <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url("wallet/"); ?>" class="nav-link <?php echo activate_menu("wallet"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Wallet</p>
                            </a>
                        </li>
                        <li class="nav-item hidden">
                            <a href="<?php echo base_url("wallet/wallettransfer/"); ?>" class="nav-link <?php echo activate_menu("wallet/wallettransfer"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wallet Transfer</p>
                            </a>
                        </li>
                        <li class="nav-item hidden">
                            <a href="<?php echo base_url("wallet/walletreceived/"); ?>" class="nav-link <?php echo activate_menu("wallet/walletreceived"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wallet Received</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("wallet/withdrawal/"); ?>" class="nav-link <?php echo activate_menu("wallet/withdrawal"); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Request Withdrawal</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
				}else{
				?>
                <li class="nav-item hidden">
                    <a href="<?php echo base_url('wallet/wallettransfer/'); ?>" class="nav-link <?php echo activate_menu('wallet/wallettransfer'); ?>">
                        <i class="nav-icon fas fa-money-bill-alt"></i>
                        <p>Fund Transfer</p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo activate_dropdown('wallet','li',array('wallettransfer')); ?>">
                    <a href="#" class="nav-link <?php echo activate_dropdown('wallet','a',array('wallettransfer')); ?>">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Member Payment <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url("wallet/membercommission/"); ?>" class="nav-link <?php echo activate_menu('wallet/membercommission'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Member Commission</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("wallet/memberrewards/"); ?>" class="nav-link <?php echo activate_menu('wallet/memberrewards'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Member Rewards</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("wallet/requestlist/"); ?>" class="nav-link <?php echo activate_menu('wallet/requestlist'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Withdrawal Request</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("wallet/dailypaymentreport/"); ?>" class="nav-link <?php echo activate_menu('wallet/dailypaymentreport'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daily Payment List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("wallet/paymentreport/"); ?>" class="nav-link <?php echo activate_menu('wallet/paymentreport'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payment Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
           	</ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="content-wrapper" >
    <?php /*?><div class="overlay" id="loading">
        <i class="fa fa-3x fa-refresh fa-spin"></i>
    </div><?php */?>
	<?php
    	$this->load->view('includes/breadcrumb');
	?>
    <!-- Main content -->
    