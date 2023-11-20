<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('exporttoexcel')) {
  		function exporttoexcel($array,$date) {
			$filename="Payment-List-".date('d-m-Y',strtotime($date));
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			
			$sep = "\t";
			$fieldinfo=array("Sl No","Date","Member ID","Name","Account No","IFSC Code","Amount","TDS","Admin Charge","Total Amount");
			foreach ($fieldinfo as $val){
				printf($val . "\t");
			}
			print("\n");   
			if(!empty($array)){ 
				foreach($array as $val){
					$schema_insert = "";
					for($j=0; $j<count($fieldinfo);$j++)
					{
						if(!isset($val[$j]))
							$schema_insert .= "NULL".$sep;
						elseif ($val[$j] != "")
							$schema_insert .= "$val[$j]".$sep;
						else
							$schema_insert .= "".$sep;
					}
					$schema_insert = str_replace($sep."$", "", $schema_insert);
					$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
					$schema_insert .= "\t";
					print(trim($schema_insert));
					print "\n";
				}   
			}
		}
	}
	if(!function_exists('exportpaymentreport')) {
  		function exportpaymentreport($array,$filename,$colnames,$skip=array()) {
			
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			
			$sep = "\t";
			if(array_search("SL No",$colnames)===false){
				printf("SL No\t");
			}
			foreach ($colnames as $val){
				printf($val . "\t");
			}
			print("\n");   
			if(!empty($array)){ $slno=0;
				foreach($array as $row){ $slno++;
					$schema_insert = "";
					$schema_insert .= "$slno".$sep;
					foreach($row as $key=>$val){
						if(array_search($key,$skip)!==false){ continue; }
						if(!isset($val))
							$schema_insert .= "NULL".$sep;
						elseif ($val != "")
							$schema_insert .= "$val".$sep;
						else
							$schema_insert .= "".$sep;
					}
					$schema_insert = str_replace($sep."$", "", $schema_insert);
					$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
					$schema_insert .= "\t";
					print(trim($schema_insert));
					print "\n";
				}   
			}
		}
	}
	if(!function_exists('exportmembers')) {
  		function exportmembers($array,$filename,$colnames,$skip=array()) {
			
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			
			$sep = "\t";
			if(array_search("SL No",$colnames)===false){
				printf("SL No\t");
			}
			foreach ($colnames as $val){
				printf($val . "\t");
			}
			print("\n");   
			if(!empty($array)){ $slno=0;
				foreach($array as $row){ $slno++;
					$schema_insert = "";
					$schema_insert .= "$slno".$sep;
					foreach($row as $key=>$val){
						if(array_search($key,$skip)!==false){ continue; }
						if(!isset($val))
							$schema_insert .= "NULL".$sep;
						elseif ($val != "")
							$schema_insert .= "$val".$sep;
						else
							$schema_insert .= "".$sep;
					}
					$schema_insert = str_replace($sep."$", "", $schema_insert);
					$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
					$schema_insert .= "\t";
					print(trim($schema_insert));
					print "\n";
				}   
			}
		}
	}
?>