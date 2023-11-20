-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2022 at 02:11 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_imark_mlm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tmp_acc_details`
--

CREATE TABLE `tmp_acc_details` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `ifsc` varchar(11) NOT NULL,
  `micr` varchar(30) NOT NULL,
  `aadhar1` varchar(100) NOT NULL,
  `aadhar2` varchar(100) NOT NULL,
  `pan` varchar(100) NOT NULL,
  `cheque` varchar(100) NOT NULL,
  `kyc` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_acc_details`
--

INSERT INTO `tmp_acc_details` (`id`, `regid`, `bank`, `branch`, `city`, `account_no`, `account_name`, `ifsc`, `micr`, `aadhar1`, `aadhar2`, `pan`, `cheque`, `kyc`) VALUES
(19, 20, 'Allahabad Bank', 'Ranchi', 'Ranchi', '58480001000111500', 'Member 1', 'PUNB0005485', '', '', '', '', '', 0),
(20, 21, 'Bank of Baroda', 'Ranchi', 'Ranchi', '7458000584711625', 'Member 2', 'PUNB584768', '', '', '', '', '', 0),
(21, 22, 'Bandhan Bank', 'Ranchi', 'Ranchi', '789456254158', 'Member 3', 'BAND5487585', '', '', '', '', '', 0),
(22, 23, '', '', '', '', '', '', '', '', '', '', '', 0),
(23, 24, '', '', '', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_banks`
--

CREATE TABLE `tmp_banks` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_banks`
--

INSERT INTO `tmp_banks` (`id`, `name`) VALUES
(1, 'Allahabad Bank'),
(2, 'Andhra Bank'),
(3, 'Axis Bank'),
(4, 'Bandhan Bank'),
(5, 'Bank of Baroda'),
(6, 'Bank of India'),
(7, 'Bank of Maharashtra'),
(8, 'Canara Bank'),
(9, 'Catholic Syrian Bank'),
(10, 'Central Bank of India'),
(11, 'City Union Bank'),
(12, 'Corporation Bank'),
(13, 'DCB Bank'),
(14, 'Dena Bank'),
(15, 'Dhanlaxmi Bank'),
(16, 'Federal Bank'),
(17, 'HDFC Bank'),
(18, 'ICICI Bank'),
(19, 'IDBI Bank'),
(20, 'IDFC Bank'),
(21, 'Indian Bank'),
(22, 'Indian Overseas Bank'),
(23, 'IndusInd Bank'),
(24, 'Jammu and Kashmir Bank'),
(25, 'Karnataka Bank'),
(26, 'Karur Vysya Bank'),
(27, 'Kotak Mahindra Bank'),
(28, 'Lakshmi Vilas Bank'),
(29, 'Nainital Bank'),
(30, 'Oriental Bank of Commerce'),
(31, 'Punjab & Sindh Bank'),
(32, 'Punjab National Bank'),
(33, 'RBL Bank'),
(34, 'South Indian Bank'),
(35, 'State Bank of India'),
(36, 'Syndicate Bank'),
(37, 'Tamilnad Mercantile Bank'),
(38, 'UCO Bank'),
(39, 'Union Bank of India'),
(40, 'United Bank of India'),
(41, 'Vijaya Bank'),
(42, 'YES Bank');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_epins`
--

CREATE TABLE `tmp_epins` (
  `id` int(11) NOT NULL,
  `epin` varchar(20) NOT NULL,
  `regid` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_epins`
--

INSERT INTO `tmp_epins` (`id`, `epin`, `regid`, `package_id`, `status`, `added_on`) VALUES
(3, 'OKNHAY', 1, 1, 1, '2022-11-17 11:21:23'),
(4, 'JCEYSK', 1, 2, 1, '2022-11-17 11:33:05'),
(5, 'HT9SIZ', 1, 1, 1, '2022-11-17 11:36:19'),
(6, '94KLNQ', 20, 1, 1, '2022-11-17 11:50:44'),
(7, 'R4ZREY', 20, 1, 1, '2022-11-17 11:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_epin_requests`
--

CREATE TABLE `tmp_epin_requests` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `amount` float(14,2) NOT NULL,
  `date` date NOT NULL,
  `details` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `approve_date` date DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_epin_requests`
--

INSERT INTO `tmp_epin_requests` (`id`, `regid`, `quantity`, `package_id`, `type`, `amount`, `date`, `details`, `image`, `approve_date`, `status`) VALUES
(2, 20, 2, 1, 'request', 4000.00, '2022-11-17', 'Transaction Type : UPI\r\nTransaction No. : TXR0006856547777567', '/assets/uploads/receipt/member-1-receipt.jpg', '2022-11-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_epin_transfer`
--

CREATE TABLE `tmp_epin_transfer` (
  `id` int(11) NOT NULL,
  `reg_from` int(11) NOT NULL,
  `reg_to` int(11) NOT NULL,
  `epin_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_epin_transfer`
--

INSERT INTO `tmp_epin_transfer` (`id`, `reg_from`, `reg_to`, `epin_id`, `added_on`) VALUES
(3, 0, 1, 3, '2022-11-17 11:21:23'),
(4, 0, 1, 4, '2022-11-17 11:33:05'),
(5, 0, 1, 5, '2022-11-17 11:36:19'),
(6, 0, 20, 6, '2022-11-17 11:50:44'),
(7, 0, 20, 7, '2022-11-17 11:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_epin_used`
--

CREATE TABLE `tmp_epin_used` (
  `id` int(11) NOT NULL,
  `epin_id` int(11) NOT NULL,
  `used_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_epin_used`
--

INSERT INTO `tmp_epin_used` (`id`, `epin_id`, `used_by`, `added_on`) VALUES
(3, 3, 20, '2022-11-17 11:22:02'),
(4, 4, 21, '2022-11-17 11:35:44'),
(5, 5, 22, '2022-11-17 11:36:45'),
(6, 6, 23, '2022-11-17 11:52:28'),
(7, 7, 24, '2022-11-17 11:54:38');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_level_members`
--

CREATE TABLE `tmp_level_members` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_members`
--

CREATE TABLE `tmp_members` (
  `id` int(11) NOT NULL,
  `epin` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `father` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `mstatus` varchar(10) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `aadhar` varchar(12) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `district` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(50) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `regid` int(11) NOT NULL,
  `refid` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `package_id` int(11) NOT NULL,
  `activation_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `franchise` tinyint(1) NOT NULL DEFAULT 0,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_members`
--

INSERT INTO `tmp_members` (`id`, `epin`, `name`, `dob`, `father`, `occupation`, `gender`, `mstatus`, `mobile`, `email`, `aadhar`, `pan`, `address`, `district`, `state`, `country`, `pincode`, `photo`, `regid`, `refid`, `date`, `time`, `package_id`, `activation_date`, `status`, `franchise`, `added_on`) VALUES
(7, 'OKNHAY', 'Member 1', '2022-11-17', 'Member\'s Father', '', 'Male', 'Unmarried', '7845692541', 'member@gmail.com', '748596365241', 'PHIOB9876N', 'Ranchi Jharkhand 850251', 'Ranchi', 'Jharkhand', 'India', '925406', '', 20, 1, '2022-11-18', '11:00:06', 1, '2022-11-18', 1, 0, '2022-11-18 11:00:07'),
(8, 'JCEYSK', 'Member 2', '2022-11-17', 'Member\'s Father', '', 'Male', 'Unmarried', '7845692541', 'member2@gmail.com', '784569582541', 'BVHUY8758A', 'Ranchi Jharkhand', 'Ranchi', 'Jharkhand', 'India', '784525', '', 21, 1, '2022-11-18', '11:27:02', 2, '2022-11-18', 1, 0, '2022-11-17 11:27:03'),
(9, 'HT9SIZ', 'Member 3', '2022-11-16', 'Member\'s 3 Father', '', 'Female', 'Married', '2345678958', 'member3@gmail.com', '748525146925', 'LKJHU8457D', 'Ranchi Jharkhand 854658', 'Ranchi', 'Jharkhand', 'India', '584695', '', 22, 20, '2022-11-18', '11:30:21', 1, '2022-11-18', 1, 0, '2022-11-17 11:30:21'),
(10, '94KLNQ', 'Member 4', '1996-01-12', 'Member\'s 4 Father', '', '', '', '7854258457', '', '', '', 'Ranchi Jharkhand', 'Ranchi ', 'Jharkhand', '', '', '', 23, 20, '2022-11-18', '11:46:26', 1, '2022-11-18', 1, 0, '2022-11-17 11:46:27'),
(11, 'R4ZREY', 'Member 5', '2022-11-17', 'Member\'s5 Father', '', '', '', '7854521569', '', '', '', 'Ranchi Jharkhand', 'Ranchi', 'Jharkhand', '', '', '', 24, 20, '2022-11-18', '11:53:58', 1, '2022-11-18', 1, 0, '2022-11-17 11:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_member_tree`
--

CREATE TABLE `tmp_member_tree` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `position` varchar(1) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_member_tree`
--

INSERT INTO `tmp_member_tree` (`id`, `regid`, `parent_id`, `position`, `added_on`) VALUES
(1, 1, 0, 'F', '2020-09-24 12:31:26'),
(20, 20, 1, 'L', '2022-11-17 11:00:07'),
(21, 21, 1, 'R', '2022-11-17 11:27:03'),
(22, 22, 20, 'L', '2022-11-17 11:30:21'),
(23, 23, 20, 'R', '2022-11-17 11:46:27'),
(24, 24, 22, 'L', '2022-11-17 11:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_nominee`
--

CREATE TABLE `tmp_nominee` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `relation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_nominee`
--

INSERT INTO `tmp_nominee` (`id`, `regid`, `name`, `mobile`, `dob`, `relation`) VALUES
(19, 20, '', '', '0000-00-00', ''),
(20, 21, '', '', '0000-00-00', ''),
(21, 22, '', '', '0000-00-00', ''),
(22, 23, '', '', '0000-00-00', ''),
(23, 24, '', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_packages`
--

CREATE TABLE `tmp_packages` (
  `id` int(11) NOT NULL,
  `package` varchar(50) NOT NULL,
  `amount` float(14,2) NOT NULL,
  `bv` float NOT NULL,
  `iv` float DEFAULT NULL,
  `direct` float NOT NULL,
  `capping` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_packages`
--

INSERT INTO `tmp_packages` (`id`, `package`, `amount`, `bv`, `iv`, `direct`, `capping`, `status`) VALUES
(1, 'P-2000', 2000.00, 2, 0.5, 105, 15000, 1),
(2, 'P-4000', 4000.00, 5, 1, 255, 30000, 1),
(4, 'P-6000', 6000.00, 11, 1.5, 550, 45000, 1),
(5, 'P-40000', 40000.00, 11, 10, 550, 300000, 1),
(6, 'P-200000', 200000.00, 11, 50, 550, 1500000, 1),
(7, 'P-280000', 280000.00, 11, 70, 550, 2100000, 1),
(8, 'P-400000', 400000.00, 11, 100, 550, 3000000, 1),
(9, 'P-2000000', 2000000.00, 11, 500, 550, 15000000, 1),
(10, 'P-4000000', 4000000.00, 11, 1000, 550, 30000000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_sidebar`
--

CREATE TABLE `tmp_sidebar` (
  `id` int(11) NOT NULL,
  `activate_menu` varchar(255) NOT NULL,
  `activate_not` varchar(255) NOT NULL,
  `base_url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `role_id` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_sidebar`
--

INSERT INTO `tmp_sidebar` (`id`, `activate_menu`, `activate_not`, `base_url`, `icon`, `name`, `parent`, `position`, `role_id`, `status`) VALUES
(1, 'home', '{\"0\":\"\"}', 'home/', '<i class=\"nav-icon  fa fa-home\"></i>', 'Dashboard', 0, 17, '\"admin\",\"member\"', 1),
(2, 'profile', '{\"0\":\"\"}', '#', '<i class=\"nav-icon far fa-user\"></i>', 'Member Details', 0, 13, '\"\"member\"\"', 1),
(3, 'profile', '{\"0\":\"\"}', '#', '<i class=\"nav-icon far fa-user\"></i>', 'Member Details', 0, 8, '\"\"member\"\"', 0),
(4, 'profile/changepassword', '{\"0\":\"\"}', 'profile/changepassword/', '<i class=\"far fa-circle nav-icon\"></i>', 'Change Password', 2, 14, '\"\"member\"\"', 1),
(5, 'profile/accdetails', '{\"0\":\"\"}', 'profile/accdetails/', '<i class=\"far fa-circle nav-icon\"></i>', 'Account Details', 2, 16, '\"\"member\"\"', 1),
(6, 'profile/kyc', '{\"0\":\"\"}', 'profile/kyc/', '<i class=\"far fa-circle nav-icon\"></i>', 'KYC Upload', 2, 18, '\"\"member\"\"', 1),
(7, 'profile/changepassword', '{\"0\":\"\"}', 'profile/changepassword/', '<i class=\"nav-icon fas fa-key\"></i>', 'Change Password', 0, 27, '\"admin\"', 1),
(8, 'members', '{\"0\":\"\"}', '#', '<i class=\"nav-icon fas fa-sitemap\"></i>', 'Genealogy', 0, 30, '\"admin\"|\"member\"', 1),
(9, 'members', '{\"0\":\"\"}', 'members/', '<i class=\"far fa-circle nav-icon\"></i>', 'Member Registration', 8, 21, '\"admin\",\"member\"', 1),
(10, 'members/mydirects', '{\"0\":\"\"}', 'members/mydirects/', '<i class=\"far fa-circle nav-icon\"></i>', 'Direct Sponsor', 8, 22, '\"\"member\"\"', 1),
(11, 'members/downline', '{\"0\":\"\"}', 'members/downline/', '<i class=\"far fa-circle nav-icon\"></i>', 'Downline', 8, 28, '\"admin\",\"member\"', 1),
(12, 'members/treeview', '{\"0\":\"\"}', 'members/treeview/', '<i class=\"far fa-circle nav-icon\"></i>', 'Treeview', 8, 29, '\"\"admin\",\"member\"\"', 1),
(13, 'members/kyc', '{\"0\":\"\"}', 'members/kyc/', '<i class=\"far fa-circle nav-icon\"></i>', 'KYC Requests', 8, 31, '\"\"admin\"\"', 1),
(14, 'members/approvedkyc', '{\"0\":\"\"}', 'members/approvedkyc/', '<i class=\"far fa-circle nav-icon\"></i>', 'Approved KYC', 8, 32, '\"\"admin\"\"', 1),
(15, 'epins', '{\"0\":\"\"}', '#', '<i class=\"nav-icon fas fa-key\"></i>', 'E-Pin Management', 0, 20, '\"\"admin\",\"member\"\"', 1),
(16, 'epins', '{\"0\":\"\"}', '#', '<i class=\"nav-icon fas fa-key\"></i>', 'E-Pin Management', 0, 1, '\"\"admin\",\"member\"\"', 0),
(17, 'epins/used', '{\"0\":\"\"}', 'epins/used/', '<i class=\"far fa-circle nav-icon\"></i>', 'Used E-Pin', 15, 9, '\"\"admin\",\"member\"\"', 1),
(18, 'epins/unused', '{\"0\":\"\"}', 'epins/unused/', '<i class=\"far fa-circle nav-icon\"></i>', 'Fresh E-Pin', 15, 12, '\"\"admin\",\"member\"\"', 1),
(19, 'epins/transfer', '{\"0\":\"\"}', 'epins/transfer/', '<i class=\"far fa-circle nav-icon\"></i>', 'E-Pin Transfer', 15, 19, '\"\"admin\",\"member\"\"', 1),
(20, 'epins/transferhistory', '{\"0\":\"\"}', 'epins/transferhistory/', '<i class=\"far fa-circle nav-icon\"></i>', 'E-Pin Transfer History', 15, 23, '\"\"admin\",\"member\"\"', 1),
(21, 'epins', '{\"0\":\"\"}', 'epins/', '<i class=\"far fa-circle nav-icon\"></i>', 'E-Pin Generation', 15, 24, '\"\"admin\",\"member\"\"', 1),
(22, 'epins/generationhistory', '{\"0\":\"\"}', 'epins/generationhistory/', '<i class=\"far fa-circle nav-icon\"></i>', 'E-Pin Generation History', 15, 25, '\"\"admin\",\"member\"\"', 1),
(23, 'epins/approvedlist', '{\"0\":\"\"}', 'epins/approvedlist/', '<i class=\"far fa-circle nav-icon\"></i>', 'E-Pin Approved Requests', 15, 26, '\"\"admin\"\"', 1),
(24, 'wallet/incomes', '{\"0\":\"\"}', 'wallet/incomes/', '<i class=\"far fa-money-bill-alt nav-icon\"></i>', 'My Incomes', 0, 34, '\"\"member\"\"', 1),
(25, 'wallet', '[\"incomes\"]', '#', '<i class=\"nav-icon fas fa-wallet\"></i>', 'Wallet', 0, 15, '\"\"member\"\"', 1),
(26, 'wallet', '[\"incomes\"]', '#', '<i class=\"nav-icon fas fa-wallet\"></i>', 'Wallet', 0, 33, '\"\"member\"\"', 0),
(27, 'wallet/wallettransfer', '{\"0\":\"\"}', 'wallet/wallettransfer/', '<i class=\"far fa-circle nav-icon\"></i>', 'Wallet Transfer', 25, 3, '\"\"member\"\"', 1),
(28, 'wallet/walletreceived', '{\"0\":\"\"}', 'wallet/walletreceived/', '<i class=\"far fa-circle nav-icon\"></i>', 'Wallet Received', 25, 6, '\"\"member\"\"', 1),
(29, 'wallet/withdrawal', '{\"0\":\"\"}', 'wallet/withdrawal/', '<i class=\"far fa-circle nav-icon\"></i>', 'Request Withdrawal', 25, 11, '\"\"member\"\"', 1),
(30, 'wallet/wallettransfer', '{\"0\":\"\"}', 'wallet/wallettransfer/', '<i class=\"nav-icon fas fa-money-bill-alt\"></i>', 'Fund Transfer', 0, 36, '\"admin\"', 1),
(31, 'wallet', '{\"0\":\"\"}', '#', '<i class=\"nav-icon fas fa-wallet\"></i>', 'Member Payment', 0, 10, '\"\"admin\"\"', 1),
(32, 'wallet', '{\"0\":\"\"}', '#', '<i class=\"nav-icon fas fa-wallet\"></i>', 'Member Payment', 0, 35, '\"\"admin\"\"', 0),
(33, 'wallet/memberrewards', '{\"0\":\"\"}', 'wallet/memberrewards/', '<i class=\"far fa-circle nav-icon\"></i>', 'Member Rewards', 31, 2, '\"\"admin\"\"', 1),
(34, 'wallet/requestlist', '{\"0\":\"\"}', 'wallet/requestlist/', '<i class=\"far fa-circle nav-icon\"></i>', 'Withdrawal Request', 31, 4, '\"\"admin\"\"', 1),
(35, 'wallet/dailypaymentreport', '{\"0\":\"\"}', 'wallet/dailypaymentreport/', '<i class=\"far fa-circle nav-icon\"></i>', 'Daily Payment List', 31, 5, '\"\"admin\"\"', 1),
(36, 'wallet/paymentreport', '{\"0\":\"\"}', 'wallet/paymentreport/', '<i class=\"far fa-circle nav-icon\"></i>', 'Payment Report', 31, 7, '\"\"admin\"\"', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_users`
--

CREATE TABLE `tmp_users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `vp` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `otp` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_users`
--

INSERT INTO `tmp_users` (`id`, `username`, `mobile`, `name`, `email`, `password`, `vp`, `role`, `salt`, `otp`, `token`, `status`, `created_on`, `updated_on`) VALUES
(1, 'admin', '9297827636', 'Admin', 'pankaj.tiwari@brightcodess.com', 'bdd3b9e843f4a077d9ff8c3c73657843', '12345', 'admin', 'Og9Fph8Nb2BJCExw', '', '', 1, '2020-09-24 15:19:59', '2020-09-24 15:19:59'),
(20, 'MT100001', '7845692541', 'Member 1', 'member@gmail.com', 'e66ab3a468ae9efe1a89fadc70336331', '05478', 'member', 'avJmDnh1fbEqXFx8', '', '', 1, '2022-11-17 11:00:07', '2022-11-17 11:00:07'),
(21, 'MT100002', '7845692541', 'Member 2', 'member2@gmail.com', 'd2ce77bdce953ae25b792f8833520ab4', '56493', 'member', 'fgke83MQBWPEXsur', '', '', 1, '2022-11-17 11:27:02', '2022-11-17 11:27:02'),
(22, 'MT100003', '2345678958', 'Member 3', 'member3@gmail.com', 'f807b148b3e7b4596e785e74c4ee2e8a', '79654', 'member', 'dbBVrC2tKFo96OQE', '', '', 1, '2022-11-17 11:30:21', '2022-11-17 11:30:21'),
(23, 'MT100004', '7854258457', 'Member 4', '', '1df6b7de4d4978ecad13d8d1af2facf4', '12573', 'member', '61TIupMDCU4fVASO', '', '', 1, '2022-11-17 11:46:26', '2022-11-17 11:46:26'),
(24, 'MT100005', '7854521569', 'Member 5', '', '4442d26e390ba39800ff9a43035970ed', '51987', 'member', 'QnXTlVSFYRxD9sWd', '', '', 1, '2022-11-17 11:53:58', '2022-11-17 11:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_wallet`
--

CREATE TABLE `tmp_wallet` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `regid` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `member_id` int(11) NOT NULL,
  `pair` varchar(200) DEFAULT '0',
  `purchase` float(16,2) NOT NULL,
  `percent` float NOT NULL,
  `royalty_id` int(11) NOT NULL,
  `reward_id` int(11) NOT NULL,
  `amount` float(16,2) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_wallet`
--

INSERT INTO `tmp_wallet` (`id`, `date`, `regid`, `type`, `member_id`, `pair`, `purchase`, `percent`, `royalty_id`, `reward_id`, `amount`, `remarks`, `added_on`) VALUES
(3, '2022-11-18', 20, 'ewallet', 0, '0', 0.00, 0, 0, 0, 600.00, 'Direct Sale Bonus', '2022-11-18 16:27:07'),
(4, '2022-11-18', 20, 'ewallet', 0, '1', 0.00, 0, 0, 0, 500.00, 'Leadership Bonus', '2022-11-18 16:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_wallet_transfers`
--

CREATE TABLE `tmp_wallet_transfers` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reg_from` int(11) NOT NULL,
  `reg_to` int(11) NOT NULL,
  `type_from` varchar(10) NOT NULL,
  `type_to` varchar(10) NOT NULL,
  `amount` float(16,2) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_withdrawals`
--

CREATE TABLE `tmp_withdrawals` (
  `id` int(11) NOT NULL,
  `regid` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` float(16,2) NOT NULL,
  `tds` float(16,2) NOT NULL,
  `admin_charge` float(16,2) NOT NULL,
  `payable` float(16,2) NOT NULL,
  `approve_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `updated_on` datetime NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tmp_acc_details`
--
ALTER TABLE `tmp_acc_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_accreg` (`regid`);

--
-- Indexes for table `tmp_banks`
--
ALTER TABLE `tmp_banks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tmp_epins`
--
ALTER TABLE `tmp_epins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epin` (`epin`);

--
-- Indexes for table `tmp_epin_requests`
--
ALTER TABLE `tmp_epin_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_epin_transfer`
--
ALTER TABLE `tmp_epin_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_epin_used`
--
ALTER TABLE `tmp_epin_used`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `used_by` (`used_by`);

--
-- Indexes for table `tmp_level_members`
--
ALTER TABLE `tmp_level_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lmregid` (`regid`),
  ADD KEY `fk_lmmid` (`member_id`);

--
-- Indexes for table `tmp_members`
--
ALTER TABLE `tmp_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regid` (`regid`),
  ADD KEY `FK_ref` (`refid`);

--
-- Indexes for table `tmp_member_tree`
--
ALTER TABLE `tmp_member_tree`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regid` (`regid`);

--
-- Indexes for table `tmp_nominee`
--
ALTER TABLE `tmp_nominee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nregid` (`regid`);

--
-- Indexes for table `tmp_packages`
--
ALTER TABLE `tmp_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package` (`package`);

--
-- Indexes for table `tmp_sidebar`
--
ALTER TABLE `tmp_sidebar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_users`
--
ALTER TABLE `tmp_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tmp_wallet`
--
ALTER TABLE `tmp_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_wallet_transfers`
--
ALTER TABLE `tmp_wallet_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_withdrawals`
--
ALTER TABLE `tmp_withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tmp_acc_details`
--
ALTER TABLE `tmp_acc_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tmp_banks`
--
ALTER TABLE `tmp_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tmp_epins`
--
ALTER TABLE `tmp_epins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tmp_epin_requests`
--
ALTER TABLE `tmp_epin_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tmp_epin_transfer`
--
ALTER TABLE `tmp_epin_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tmp_epin_used`
--
ALTER TABLE `tmp_epin_used`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tmp_level_members`
--
ALTER TABLE `tmp_level_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_members`
--
ALTER TABLE `tmp_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tmp_member_tree`
--
ALTER TABLE `tmp_member_tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tmp_nominee`
--
ALTER TABLE `tmp_nominee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tmp_packages`
--
ALTER TABLE `tmp_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tmp_sidebar`
--
ALTER TABLE `tmp_sidebar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tmp_users`
--
ALTER TABLE `tmp_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tmp_wallet`
--
ALTER TABLE `tmp_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tmp_wallet_transfers`
--
ALTER TABLE `tmp_wallet_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_withdrawals`
--
ALTER TABLE `tmp_withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tmp_acc_details`
--
ALTER TABLE `tmp_acc_details`
  ADD CONSTRAINT `FK_accreg` FOREIGN KEY (`regid`) REFERENCES `tmp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_level_members`
--
ALTER TABLE `tmp_level_members`
  ADD CONSTRAINT `fk_lmmid` FOREIGN KEY (`member_id`) REFERENCES `tmp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lmregid` FOREIGN KEY (`regid`) REFERENCES `tmp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_members`
--
ALTER TABLE `tmp_members`
  ADD CONSTRAINT `FK_ref` FOREIGN KEY (`refid`) REFERENCES `tmp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_reg` FOREIGN KEY (`regid`) REFERENCES `tmp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_member_tree`
--
ALTER TABLE `tmp_member_tree`
  ADD CONSTRAINT `FK_treeregid` FOREIGN KEY (`regid`) REFERENCES `tmp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_nominee`
--
ALTER TABLE `tmp_nominee`
  ADD CONSTRAINT `fk_nregid` FOREIGN KEY (`regid`) REFERENCES `tmp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
