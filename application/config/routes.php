<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['forgotpassword'] = 'login/forgotpassword';
$route['enterotp'] = 'login/enterotp';
$route['resetpassword'] = 'login/resetpassword';
$route['logout'] = 'login/logout';
$route['register'] = 'members/register';
$route['sidebar'] = 'home/sidebar';

// '''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''


$route['reward-master'] = 'members/reward60_master';
$route['reward-master-submit'] = 'members/reward_master_submit';
$route['reward-days'] = 'members/reward_days';
$route['reward-days-submit'] = 'members/reward_days_submit';
$route['reward-master-update'] = 'members/reward_master_update';
$route['reward-master-delete'] = 'members/reward_master_delete';
$route['product-master'] = 'members/product_master';
$route['product-master-submit'] = 'members/product_master_submit';
$route['product-master-update'] = 'members/product_master_update';
$route['product-master-delete'] = 'members/product_master_delete';
$route['purchase'] = 'members/purchase';
$route['product-list-details'] = 'members/product_list_details';
$route['purchase-submit'] = 'members/purchase_submit';
$route['invoice-generate'] = 'members/invoicegenerate';
$route['purchase-delete'] = 'members/purchase_delete';

//...................................................................
$route['leadership'] = 'members/leadershipbonus';
$route['direct'] = 'members/directbonus';
$route['reward'] = 'members/rewardbonus';
// $route['reward-bonus'] = 'members/rewardbonus';
$route['repurchase-plan'] = 'members/repurchase_plan';
// travel
$route['travelbonus'] = 'members/travel_bonus';
// $route['travelbonus-distribution'] = 'members/travel_bonus_distribution';
// car
$route['carbonus'] = 'members/car_bonus';
// $route['carbonus-distribution'] = 'members/car_bonus_distribution';
// House
$route['housebonus'] = 'members/house_bonus';
// $route['housebonus-distribution'] = 'members/house_bonus_distribution';
// Luxury
$route['luxurybonus'] = 'members/luxury_bonus';
// $route['luxurybonus-distribution'] = 'members/luxury_bonus_distribution';
// I Mark Bonus
$route['imark-bonus'] = 'members/imark_bonus';





$route['getmemberdetails'] = 'members/getmemberdetails';
$route['power_id'] = 'members/power_id_add';
$route['powerid-submit'] = 'members/powerid_submit';
$route['delete-powerid'] = 'members/delete_powerid';
$route['powerid-bv'] = 'members/add_bv_for_alldata';
$route['powerid-submit-bv'] = 'members/powerid_bv_submit';

$route['upgrade-ides'] = 'members/upgrade_ides';
$route['upgradeid-request'] = 'members/upgradeid_request';
$route['approved-upgradeid'] = 'members/approved_upgradeid';
$route['gift-income'] = 'members/gift_income';
$route['award-income'] = 'members/award_income';
$route['tour-travel'] = 'members/tour_travel';
$route['sponsor_register'] = 'members/sponsor_register';
$route['directsponsor-income'] = 'wallet/directsponsor_income';
$route['level-income'] = 'wallet/level_income';
$route['car-reward-offers'] = 'wallet/carreward_offers';
$route['current-month-business'] = 'wallet/current_month_business';
$route['direct-sponsor-report'] = 'wallet/direct_sponsor_report';
$route['car-reward-reports'] = 'wallet/car_reward_reports';
$route['tripreward'] = 'members/tripreward';
$route['payout-list'] = 'members/payout_list';
$route['payout-list-details'] = 'members/payout_list_details';
$route['payout-list-details-all'] = 'members/payout_list_details_all';
$route['change_trans_pass'] = 'profile/change_trans_pass';
$route['payment'] = 'profile/payment';
$route['payment_request'] = 'profile/payment_request';
$route['approved_payment'] = 'profile/approved_payment';

// $route['total-business'] = 'wallet/';
// $route['total-business'] = 'wallet/';


