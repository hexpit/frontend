<?php
	
//This function is used to echo error or success message.
    function printstatus() {
	    global $error, $success;
	    if (@($error)) {
		    foreach ($error as $err) {
			    echo '<div class="alert alert-warning fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-warning"></i><strong>Error </strong>'. $err .'.</div>';
		    }
	    }
	    if (@($success)) {
		    foreach ($success as $suc) {
			    echo '<div class="alert alert-success fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-thumb"></i><strong>Success </strong>'. $suc .'.</div>';
		    }
	    }
    }
	
	
	
	//Sanitize Inputs
	function sanitize_input ($input) {
		$r=trim($input);
		$r=strip_tags($input);
		$r=stripslashes($input);
		$r=htmlentities($input);
		global $conn;
		$r=mysqli_real_escape_string($conn, $input);
		return $input;
	}
	
	
	
	
	//This function is used to generate desired length salt or random number
	function getsalt($saltlength=8) {
	  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	  $charactersLength = strlen($characters);
	  $randomString = '';
	  for ($i = 0; $i < $saltlength; $i++) {
	   $randomString .= $characters[rand(0, $charactersLength - 1)];
	 }
	 return $randomString;
	}
	
	function computehash($plaintext, $saltbytes) {
	  $input = $saltbytes . $plaintext . $saltbytes;
	  $hash = hash('md5', $input);
	  return $hash;
	}
	
	function generateNumber($numlength) {
  	$number="";
	  while ( strlen($number) < $numlength) {
	    $number=$number.rand(0,9);
	  }
		return $number;
	}
	
	function getprofilepic() {
		if (@($_SESSION['profilepic'])) {
			echo ASSETS_URL . $_SESSION['profilepic'];
		}else{
			echo ASSETS_URL . 'img/avatars/male.png';
		}
	}
	
	function validate_email($address) {
  	return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? FALSE : TRUE;
	}
	
	function generate_random_string($type = 'alnum', $len = 8) {
	  switch($type)
	  {
		  case 'basic'	: return mt_rand();
			  break;
		  case 'alnum'	:
		  case 'numeric'	:
		  case 'nozero'	:
		  case 'alpha'	:
	
				  switch ($type)
				  {
					  case 'alpha'	:	$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						  break;
					  case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						  break;
					  case 'numeric'	:	$pool = '0123456789';
						  break;
					  case 'nozero'	:	$pool = '123456789';
						  break;
				  }
	
				  $str = '';
				  for ($i=0; $i < $len; $i++)
				  {
					  $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
				  }
				  return $str;
			  break;
		  case 'unique'	:
		  case 'md5'		:
	
					  return md5(uniqid(mt_rand()));
			  break;
	  }
	}
	
	function find_days_in_month($month = 0, $year = '') {
	  if ($month < 1 OR $month > 12)
	  {
		  return 0;
	  }
	
	  if ( ! is_numeric($year) OR strlen($year) != 4)
	  {
		  $year = date('Y');
	  }
	
	  if ($month == 2)
	  {
		  if ($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0))
		  {
			  return 29;
		  }
	  }
	
	  $days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	  return $days_in_month[$month - 1];
	}
	
	function local_to_gmt($time = '') {
	  if ($time == '')
		  $time = time();
	
	  return mktime( gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
	}
	
	function ordinal($cdnl) { 
    $test_c = abs($cdnl) % 10; 
    $ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th' 
            : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1) 
            ? 'th' : 'st' : 'nd' : 'rd' : 'th')); 
    return $cdnl.$ext; 
	}
	
	
	function send_mail($to,$subject,$body) {
		$headers = "From: Attrix Technologies\r\n";
		$headers .= "Reply-To: hello@attrixtech.com\r\n";
		$headers .= "Return-Path: admin@attrixtech.com\r\n";
		$headers .= "X-Mailer: PHP5\n";
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to,$subject,$body,$headers);
	}
	
	function secsToStr($secs) {
    if($secs>=86400){$days=floor($secs/86400);$secs=$secs%86400;$r=$days.' day';if($days<>1){$r.='s';}if($secs>0){$r.=', ';}}
    if($secs>=3600){$hours=floor($secs/3600);$secs=$secs%3600;$r.=$hours.' hour';if($hours<>1){$r.='s';}if($secs>0){$r.=', ';}}
    if($secs>=60){$minutes=floor($secs/60);$secs=$secs%60;$r.=$minutes.' minute';if($minutes<>1){$r.='s';}if($secs>0){$r.=', ';}}
    $r.=$secs.' second';if($secs<>1){$r.='s';}
    return $r;
	}
	
	
	function current_url() {
		$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$validURL = str_replace("&", "&amp;", $url);
		return validURL;
	}
	
	
	function highlighter_text($text, $words) {
	    $split_words = explode( " " , $words );
	    foreach($split_words as $word)
	    {
	        $color = "#4285F4";
	        $text = preg_replace("|($word)|Ui" ,
	            "<span style=\"color:".$color.";\"><b>$1</b></span>" , $text );
	    }
	    return $text;
	}
	
	function remote_filesize($url, $user = "", $pw = "") {
		ob_start();
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	
		if(!empty($user) && !empty($pw))
		{
			$headers = array('Authorization: Basic ' .  base64_encode("$user:$pw"));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
	
		$ok = curl_exec($ch);
		curl_close($ch);
		$head = ob_get_contents();
		ob_end_clean();
	
		$regex = '/Content-Length:\s([0-9].+?)\s/';
		$count = preg_match($regex, $head, $matches);
	
		return isset($matches[1]) ? $matches[1] : "unknown";
	}
	
	
	function get_tiny_url($url) {  
		$ch = curl_init();  
		$timeout = 5;  
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
		$data = curl_exec($ch);  
		curl_close($ch);  
		return $data;  
	}
	

	
	function nicetime($date) {
	    if(empty($date)) {
	        return "No date provided";
	    }
	    
	    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	    $lengths         = array("60","60","24","7","4.35","12","10");
	    
	    $now             = time();
	    $unix_date         = strtotime($date);
	    
	       // check validity of date
	    if(empty($unix_date)) {    
	        return "Bad date";
	    }
	
	    // is it future date or past date
	    if($now > $unix_date) {    
	        $difference     = $now - $unix_date;
	        $tense         = "ago";
	        
	    } else {
	        $difference     = $unix_date - $now;
	        $tense         = "from now";
	    }
	    
	    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	        $difference /= $lengths[$j];
	    }
	    
	    $difference = round($difference);
	    
	    if($difference != 1) {
	        $periods[$j].= "s";
	    }
	    
	    return "$difference $periods[$j] {$tense}";
	}
	
	function getAge($birthdate = '0000-00-00') {
		if ($birthdate == '0000-00-00') return 'Unknown';
		$bits = explode('-', $birthdate);
		$age = date('Y') - $bits[0] - 1;
		$arr[1] = 'm';
		$arr[2] = 'd';
		for ($i = 1; $arr[$i]; $i++) {
		$n = date($arr[$i]);
		if ($n < $bits[$i])
		break;
		if ($n > $bits[$i]) {
		++$age;
		break;
		}
		}
		return $age;
	}

	// Admin Panel based functions.
	function printpic() {
		
	}	
	
/**
 * set document type
 * @param string $type type of document
 */
function set_content_type($type = 'application/json') {
    header('Content-Type: '.$type);
}

/**
 * Read CSV from URL or File
 * @param  string $filename  Filename
 * @param  string $delimiter Delimiter
 * @return array            [description]
 */
function read_csv($filename, $delimiter = ",") {
    $file_data = array();
    $handle = @fopen($filename, "r") or false;
    if ($handle !== FALSE) {
        while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            $file_data[] = $data;
        }
        fclose($handle);
    }
    return $file_data;
}

/**
 * Print Log to the page
 * @param  mixed  $var    Mixed Input
 * @param  boolean $pre    Append <pre> tag
 * @param  boolean $return Return Output
 * @return string/void     Dependent on the $return input
 */
function plog($var, $pre=true, $return=false) {
    $info = print_r($var, true);
    $result = $pre ? "<pre>$info</pre>" : $info;
    if ($return) return $result;
    else echo $result;
}

/**
 * Log to file
 * @param  string $log Log
 * @return void
 */
function elog($log, $fn = "debug.log") {
    $fp = fopen($fn, "a");
    fputs($fp, "[".date("d-m-Y h:i:s")."][Log] $log\r\n");
    fclose($fp); 
}


?>