<section class="content" >
      <div class="container-fluid" >
    	<div class="row">
        	<div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                    	<h3 class="card-title text-dark">Dashboard</h3>
                    </div>
                    <!-- background: linear-gradient(70deg,#07232e 30%,#68949a 30%); -->
                    
                    <!-- /.card-header -->
                    <!-- http://localhost/Pankaj2022/global_forex/assets/images/bg.jpg -->
                    <div class="card-body">
                      <?php if($this->session->userdata('role')=='admin'){ ?>
                      <div class="row">
                      <div class="col-md-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#18D4DF,#151E83);box-shadow:5px 5px 10px black;">
                          <div class="row">
                            <div class="col-md-5 col-5 ml-3">
                              <div class="inner">
                                <h3><?php echo $total_members;?></h3>
                                  <p>Total Members</p>
                              </div>
                            </div>
                            <div class="col-md-5 col-5 ml-3 text-right">
                              <img src="<?php echo base_url('assets/images/direct_team.png')?>" height="95" width="95" class="imge-fliud">
                                
                              <!-- <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div> -->
                           </div>
                          </div>
                              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>

                        <!-- <div class="col-lg-3 col-12">
                                <div class="small-box " style="background: linear-gradient(302deg,#18D4DF,#151E83);box-shadow:5px 5px 10px black;">
                                <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php if(!empty($total_encome_gen['amount'])){ echo $total_encome_gen['amount']; }else{ echo 0.00;}?></h3>   
                                  <p>E-Wallet</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/wallet123.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                               </div>
                             </div>  -->


                          <div class="col-md-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#3166F4,#5B26D6);box-shadow:5px 5px 10px black;">
                          <div class="row">
                          <div class="col-md-5 col-5 ml-3">
                              <!-- <div class="inner"> -->
                                <h3><?php echo $no_of_members;?></h3>
                                  <p>Total Active Members</p>
                              <!-- </div> -->
                              </div>
                              <div class="col-md-5 col-5 ml-3  text-right">
                                 <img src="<?php echo base_url('assets/images/total_team.png')?>" height="95" width="95" class="imge-fliud">
                                
                              </div>
                            </div>
                              <!-- <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div> -->
                              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>
                       
                        <div class="col-lg-3 col-12">
                            <div class="small-box " style="background: linear-gradient(302deg,#84C648,#14B68E);">
                            <div class="row">
                            <div class="col-md-6 col-6 text-right">
                                <h3><?php echo $no_of_deactivemembers;?></h3>   
                                <p>Total Deactive Members</p>
                              </div>
                              <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/weekly.png')?>" height="95" width="95" class="imge-fliud">
                                  </div>
                            </div>
                              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                            </div>
                        </div> 
                        <div class="col-md-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#FE5C13, #F11D5F);">
                            <div class="inner">
                            <h3><?php  if(!empty($totalturn_over)){ echo $totalturn_over; }else{ echo '0'; };?></h3>
                              <p>Total Turn Over</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-stats-bars"></i>
                            </div>
                            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <div class="small-box "  style="background: linear-gradient(302deg,#11272F, #2B5062);">
                              <div class="inner">
                                <h3><?php  if(!empty($notification_count)){ echo $notification_count; }else{ echo '0'; };?></h3>   
                                <p>KYC Notification</p>
                              </div>
                              <div class="icon">
                                 <i class="ion ion-person-add"></i>
                              </div>
                              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                            </div>
                        </div> 
                        <div class="col-md-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#11272F,#B767DE);">
                            <div class="inner">
                            
                            <h3><?php  if(!empty($current_closing)){ echo $current_closing; }else{ echo '0'; };?></h3>  
                              <p>Current Closing List</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-stats-bars"></i>
                            </div>
                            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>
                      </div>
                      <?php }else{
                          ?>
                            <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="small-box " style="background: linear-gradient(302deg,#18D4DF,#151E83);box-shadow:5px 5px 10px black;">
                                <div class="row text-center">
                                  <div class="col-md-12">
                                    <h2 class="text-uppercase text-bold"><?php echo $member['name'];?>[<?php echo $member['userid'];?>]</h2>
                                  </div>
                                  <div class="col-md-12">
                                    <h5 class=""><span class="text-bold">Rank :</span><?php if($member['status']==1){ echo 'Cordinator';}else{ echo 'Panding'; }?> </h5>
                                  </div>
                                  <div class="col-md-12">
                                    <h5 class=""><span class="text-bold">Joining Date :</span> <?php echo $member['activation_date'];?><?php echo $member['time'];?></h5>
                                  </div>
                                  <div class="col-md-12">
                                    <h5 class=""><span class="text-bold">Sponsor Name :</span> <?php echo $member['sponsor_name'];?>[<?php echo $member['sponsor_id'];?>]</h5>
                                  </div>
                                  <div class="col-md-12">
                                    <h5 class=""><span class="text-bold">Contact No :</span> <?php echo $member['sponsor_mobile'];?></h5>
                                  </div>
                                  <div class="col-md-12" >
                                    <h4 class="text-bold" style="background:linear-gradient(202deg,#2C5163,#091E25);">Total Income : <?php if(!empty($total_encome_gen['amount'])){ echo $total_encome_gen['amount']; }else{ echo '0.00';}?>/-</h4>
                                  </div>
                                </div>
                               </div>
                             </div> 


                              <div class="col-lg-3 col-12">
                                <div class="small-box " style="background: linear-gradient(302deg,#18D4DF,#151E83);box-shadow:5px 5px 10px black;">
                                <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php if(!empty($total_encome_gen['amount'])){ echo $total_encome_gen['amount']; }else{ echo 0.00;}?></h3>   
                                  <p>E-Wallet</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/wallet123.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                               </div>
                             </div> 

                          <div class="col-lg-3 col-12">
                            <div class="small-box " style="background: linear-gradient(302deg,#3166F4,#5B26D6); box-shadow:5px 5px 10px black;">
                            <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php  if(!empty($directbonus['amount'])){ echo $directbonus['amount']; }else{ echo '0.00'; };?></h3>   
                                  <p>Direct Sponsor Income</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/direct.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                              <!-- <div class="inner">
                                <h3><?php  if(!empty($levelincome['amount'])){ echo $levelincome['amount']; }else{ echo '0.00'; };?></h3>   
                                <p>Direct Sponsor Income</p>
                              </div>
                              <div class="icon">
                                  <i class="ion ion-person-add"></i>
                              </div> -->
                              <!-- <a href="<?php echo base_url('wallet/level_income');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                            </div>
                          </div>
                          <div class="col-lg-3 col-12">
                            <div class="small-box " style="background: linear-gradient(302deg,#84C648,#14B68E); box-shadow:5px 5px 10px black;">
                            <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php  if(!empty($levelincome['amount'])){ echo $levelincome['amount']; }else{ echo '0.00'; };?></h3>   
                                  <p>Level Income</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/level.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                              <!-- <div class="inner">
                                <h3><?php  if(!empty($instantincome['amount'])){ echo $instantincome['amount']; }else{ echo '0.00'; };?></h3>   
                                <p>Level Income</p>
                              </div>
                              <div class="icon">
                                  <i class="ion ion-person-add"></i>
                              </div> -->
                              <!-- <a href="<?php echo base_url('wallet/instantreferalincome');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                            </div>
                          </div>
                          <!-- <div class="col-lg-3 col-12">
                            <div class="small-box " style="background-image: url(<?= base_url('assets/images/bg.jpg'); ?>);">
                              <div class="inner">
                                <h3><?php  if(!empty($tripreward['rank'])){ echo $tripreward['rank']; }else{ echo 'No any Trip'; };?></h3>   
                                <p>Trip Reward</p>
                              </div>
                              <div class="icon">
                                  <i class="ion ion-person-add"></i>
                              </div>
                             <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                            <!-- </div>
                          </div>  -->
                        <div class="col-lg-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#FE5C13, #F11D5F); box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php  if(!empty($cashbackamount['amount'])){ echo $cashbackamount['amount']; }else{ echo '0.00'; };?></h3>   
                                  <p>ROI Sponsoring</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/bonus.png')?>" height="95" width="105" class="imge-fliud">
                                
                                  </div>
                                </div>
                            <!-- <div class="inner">
                              <h3><?php  if(!empty($workingincomess['amount'])){ echo $workingincomess['amount']; }else{ echo '0.00'; };?></h3>   
                              <p>Daily Bonus</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div> -->
                            <!-- <a href="<?php echo base_url('wallet/carrewardincome');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>

                        <div class="col-lg-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#2C5163,#091E25);box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php  if(!empty($cashbackamount['amount'])){ echo $cashbackamount['amount']; }else{ echo '0.00'; };?></h3>   
                                  <p>Franchise Income</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/bbc_club_final.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                            <!-- <div class="inner">
                              <h3><?php  if(!empty($workingincomess['amount'])){ echo $workingincomess['amount']; }else{ echo '0.00'; };?></h3>   
                              <p>BBC Club Bonus</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div> -->
                            <!-- <a href="<?php echo base_url('wallet/carrewardincome');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>

                        <div class="col-lg-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#FE5C13, #8E63E6);box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php  if(!empty($cashbackamount['amount'])){ echo $cashbackamount['amount']; }else{ echo '0.00'; };?></h3>   
                                  <p>BBC Royalty Bonus</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/bbs_royalty.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                            <!-- <div class="inner">
                              <h3><?php  if(!empty($workingincomess['amount'])){ echo $workingincomess['amount']; }else{ echo '0.00'; };?></h3>   
                              <p>BBC Royalty Bonus</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div> -->
                            <!-- <a href="<?php echo base_url('wallet/carrewardincome');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>

                        <div class="col-lg-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#B962EA, #F11D5F);box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?php  if(!empty($cashbackamount['amount'])){ echo $cashbackamount['amount']; }else{ echo '0.00'; };?></h3>   
                                  <p>BBC Super Bonus</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/bbs_super.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                            <!-- <div class="inner">
                              <h3><?php  if(!empty($workingincomess['amount'])){ echo $workingincomess['amount']; }else{ echo '0.00'; };?></h3>   
                              <p>BBC Super Bonus</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div> -->
                            <!-- <a href="<?php echo base_url('wallet/carrewardincome');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>

                        <div class="col-lg-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#3262F4, #552AD6);box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?= $directmember['direct_active'];?>/<?= $directmember['direct_total'];?></h3>   
                                  <p>Direct Team</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/direct_team.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                            <!-- <div class="inner">
                              <h3>0/0</h3>   
                              <p>Direct Team</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div> -->
                            <!-- <a href="<?php echo base_url('wallet/carrewardincome');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                          </div>
                        </div>

                        <div class="col-lg-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#88C644,#21B38A);box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3><?= $allmembers['allmember_active'];?>/<?= $allmembers['allmember_total'];?></h3>   
                                  <p>Total Team</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/total_team.png')?>" height="95" width="95" class="imge-fliud">
                                
                                  </div>
                                </div>
                              </div>
                        </div>

                        <div class="col-md-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#D717E4,#241D85);box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                    <h3><?php if(!empty($total_encome_gen['amount'])){ echo $total_encome_gen['amount']; }else{ echo 0.00;}?></h3>   
                                    <p>Total Income Generate</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/total_income.png')?>" height="95" width="95" class="imge-fliud">
                                  </div>
                                </div>
                              </div>
                        </div>

                        <div class="col-md-3 col-12">
                          <div class="small-box " style="background: linear-gradient(302deg,#17252E,#2B5562);box-shadow:5px 5px 10px black;">
                          <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3>0/0</h3>      
                                    <p>Total Weekly Team</p>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                     <img src="<?php echo base_url('assets/images/weekly.png')?>" height="95" width="95" class="imge-fliud">
                                  </div>
                                </div>
                              </div>
                        </div>
                        <!-- <div class="col-lg-3 col-12">
                            <div class="small-box " style="background: linear-gradient(302deg,#FE5C13, #F11D5F);">
                              <div class="inner">
                                <h3><?php echo $active_member;?></h3>   
                                <p>Active Members</p>
                              </div>
                              <div class="icon">
                                <i class="fas fa-gift"></i>
                              </div>
                              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> -->
                        <div class="col-lg-3 col-12 zoom pt-1">
                              <di1v class="small-box"  style="background: linear-gradient(302deg,#11272F,#B767DE);box-shadow:5px 5px 10px black;">
                             
                              <div class="row">
                                  <div class="col-md-5 col-5 ml-3">
                                  <h3 class="">Share Link</h3>  
                                   <a href="#" data-toggle="modal" data-target="#exampleModal" class="small-box-footer"  id="share"  > 
                                    <p class="text-light">Click Here</p>
                                    </a>
                                  </div>
                                  <div class="col-md-6 col-6 text-right">
                                  <?php $regid = $this->session->userdata('user'); ?>
                                  
                                  <a href="https://wa.me/?text=<?php echo base_url('sponsor_register/?sponsor='.$regid);?>" class="ml-1"><img src="<?php echo base_url('assets/images/whatsapp.png')?>" height="30" width="30" class="imge-fliud"></a>
                                  <a href="https://t.me/share/url?url=<?php echo base_url('sponsor_register/?sponsor='.$regid);?>" > <img src="<?php echo base_url('assets/images/telegram.png')?>" height="30" width="30" class="imge-fliud"></a>

                                  </div>
                                </div>
                      
                                <!-- <a href="#" data-toggle="modal" data-target="#exampleModal" class="small-box-footer"  id="share"  >
                                  <div class="inner">
                                    <h3 class="">Share Link</h3>   
                                    <p class="">Click Here</p>
                                    <p>Share Link</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fas fa-gift"></i>
                                  </div>
                                </a> -->
                                <!-- <a href="#" class="small-box-footer ">Share Link <i class="fas fa-arrow-circle-right"></i></a>   -->
                                </a>
                              </div>
                          </div>
                      </div>
                          <?php
                      } ?>
                    </div>
                </div>
            </div>
        </div>
      </div>
      </div> 
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
              <?php $regid = $this->session->userdata('user'); ?>
                <input type="text" class="form-control" id="url" value="<?php echo base_url('sponsor_register/?sponsor='.$regid);?>">
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="Copy();" >Copy Url</button>
            </div>
        </div>
      </div>
  </div>
    <script type="text/javascript">
      //   $(document).ready(function(e){
      //   debugger;
      //   $.ajax({
      //       type:"POST",
      //       url:"<?php echo base_url("home/verifycommission"); ?>",
      //       data:{a:''},
      //       success: function(data){
              
      //       }
      //     });
      // });
     
      function Copy() {
        var Url = document.getElementById("url");
        // Url.innerHTML = window.location.href;
        // console.log(Url.innerHTML)
        Url.select();
        document.execCommand("copy");
      }
    </script>
    
   