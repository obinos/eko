<?php

class DateUtils {

    public static $month_name = array("","January","February","March","April","May","June","July","August","September","October","November","December");

	public static $month_name_short = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep", "Oct","Nov","Dec");

	public static $day_name = array("Sunday","Monday","Tuesday","Wednesday","Thursday", "Friday", "Saturday", "Sunday");

	public static $day_name_with_locale = array(
										'Sunday' => 'Minggu',
										'Monday' => 'Senin',
										'Tuesday' => 'Selasa',
										'Wednesday' => 'Rabu',
										'Thursday' => 'Kamis',
										'Friday' => 'Jumat',
										'Saturday' => 'Sabtu'
									);

	public static function getLocalDayName($day)
	{
		return self::$day_name_with_locale[$day];
	}

	public static function mongoToDate($mongo_date, $format = 'Y-m-d', $time_zone = null){		
		if(!$time_zone) $time_zone = new \DateTimeZone('Asia/Jakarta');
		return $mongo_date->toDateTime()->setTimeZone($time_zone)->format($format);
	}

	public static function convertObjDate($obj_date, $format = "Y-m-d")
	{
		return date($format, ($obj_date['$date']['$numberLong']/1000));
	}
	/*
	 * @param mktime
	 */
	public static function timeToMongo($time = null){
		if(!$time) $time = time();
		return new \MongoDB\BSON\UTCDateTime($time * 1000);
	}

	public static function dateToObj($start_date, $end_date)
	{
		$new_date = [
			'start_date' => date('Y-m-d', $start_date->__toString() / 1000),
			'end_date' => date('Y-m-d', $end_date->__toString() / 1000)
		];

		return $new_date;
	}
	public static function dateToString($date)
	{
		return date('Y-m-d', $date->__toString() / 1000);
	}
	/*
	 * @param dd-mm-yyyy
	 */
	public static function dateToMongo($date = null){
		if(!$date) {
			$time = time();
		} else {
			list($day, $month, $year) = explode ("-", $date);
			$time = mktime(0, 0, 0, $month, $day, $year);

		}
		return new \MongoDB\BSON\UTCDateTime($time*1000);
	}

	public static function dateDB($date) {
	    if ($date) {
		   list ($day, $month, $year,) = explode ('-', $date);
		   return $year."-".$month."-".$day;
	    } else {
		   return "";
	    }
	}

	public static function formatDate($date, $delim = "-", $yeard = 4) {
		if ($date) {
		   list ($year, $month, $day,) = explode ('-', $date);
		   return $day.$delim.$month.$delim.substr($year,($yeard*-1));
		} else {
		   return "";
		}
	}

	public static function format_date_short($date) {

		if ($date) {
			list ($year, $month, $day,) = explode ('-', $date);
			return $day." ".self::$monthNameShort[intval($month)]." ".$year;
		} else {
			return "";
		}
	}

	/*
	 * @param gmt time
	 */ 
	public static function gmt_to_local($gmt){
		return intval($gmt-(date('Z')));
	}
	
	public static function local_to_gmt($local,$time_zone=null){
		$dt = new DateTime();
		if($time_zone) $dt->setTimeZone($time_zone);
		return intval($local+($dt->format('Z')));
	}

	/*
	 * @param date time serial number
	 */ 
	public static function excel_to_monggo($number){
		$t = ($number-25568);
		return mktime(0, 0, 0, 1  , ($t), 1970);
	}

	public static function mongo_to_excel($time){
		return ($time)? intval($time+25568) : "";
	}

	/*
	 * @param dd-mm-yyyy
	 */ 
	public static function mongoDate($date,$delim='-',$f24=false,$_hour=0,$_min=0){
		list ($day,$month,$year) = explode ($delim, $date);
		if($f24==false)
			return mktime($_hour,$_min,0,$month,$day,$year);
		else 
			return mktime(23,59,59,$month,$day,$year);
	}
	

	public static function mongo_date_add($sec,$interval,$period){

		$tstr = date('Y-m-d',$sec);
		$date = new DateTime($tstr);

		
		if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
			$si = 'P'.$interval.'M';
			$date->add(new DateInterval($si));
		} else {
			$si = '+'.$interval.' months';
			$date->modify($si);
		}

		
		return intval($date->format('U'));
	}
	
	public static function format_date_mongo($_sec,$delim='/',$yeard=4) {
		$digit[2] = 'y';
		$digit[4] = 'Y';
		
		$format = 'd'.$delim.'m'.$delim.$digit[$yeard];

		if ($_sec) {
			return date($format,floatval($_sec));
		} else {
			return "";
		}
	}
	
	public static function format_date_long($date) {
		if ($date) {
			list ($year, $month, $day,) = explode ('-', $date);
			return $day." ".self::$monthName[intval($month)]." ".$year;
		} else {
			return "";
		}
	}	

	public static function get_week($in_tgl)
	{
		$tanggal = explode("-",$in_tgl);
		$hari =  date("W",mktime(0,0,0,$tanggal[1],$tanggal[2],$tanggal[0]));
		return $hari;
	}

	public static function get_week_day($in_tgl)
	{
		$tanggal = explode("-",$in_tgl);
		$hari =  date("w",mktime(0,0,0,$tanggal[1],$tanggal[2],$tanggal[0]));
		return $hari;
	}	


	public static function form_date($date,$format){
		switch($format){
			case 'DD/MM/YY':
				$res = self::_form_date_1($date);
				break;
			case 'DD/MM/YYYY':
				$res = self::_form_date_2($date);
				break;
			case 'DD-MM-YY':
				$res = self::_form_date_3($date);
				break;
			case 'DD-MM-YYYY':
				$res = self::_form_date_4($date);
				break;
			case 'MM/DD/YY':
				$res = self::_form_date_5($date);
				break;
			case 'MM/DD/YYYY':
				$res = self::_form_date_6($date);
				break;
			case 'MM-DD-YY':
				$res = self::_form_date_7($date);
				break;
			case 'MM-DD-YYYY':
				$res = self::_form_date_8($date);
				break;
			case 'MMM D, YY':
				$res = self::_form_date_9($date);
				break;
			case 'MMM D, YYYY':
				$res = self::_form_date_10($date);
				break;
			case 'MMMM D, YYYY':
				$res = self::_form_date_11($date);
				break;
			default:
				break;
		}
		return $res;
	}

	private static function _form_date_1($date){
		//'DD/MM/YY':
		if ($date) {
			list ($day, $month, $year,) = explode ('/', $date);
			$year  = '20'.$year;
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	private static function _form_date_2($date){
		//'DD/MM/YYYY':
		if ($date) {
			list ($day, $month, $year,) = explode ('/', $date);
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	private static function _form_date_3($date){
		//'DD-MM-YY':
		if ($date) {
			list ($day, $month, $year,) = explode ('-', $date);
			$year  = '20'.$year;
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	private static function _form_date_4($date){
		//'DD-MM-YYYY':
		if ($date) {
			list ($day, $month, $year,) = explode ('-', $date);
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}


	private static function _form_date_5($date){
		//'MM/DD/YY':
		if ($date) {
			list ($month, $day, $year,) = explode ('/', $date);
			$year  = '20'.$year;
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	private static function _form_date_6($date){
		//'MM/DD/YYYY':
		if ($date) {
			list ($month, $day, $year,) = explode ('/', $date);
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}


	private static function _form_date_7($date){
		//'MM-DD-YY':
		if ($date) {
			list ($month, $day, $year,) = explode ('-', $date);
			$year  = '20'.$year;
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	private static function _form_date_8($date){
		//'MM-DD-YYYY':
		if ($date) {
			list ($month, $day, $year,) = explode ('-', $date);
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	private static function _form_date_9($date){
		$_short = array(
					'jan' => '01',
					'feb' => '02',
					'mar' => '03',
					'apr' => '04',
					'may' => '05',
					'jun' => '06',
					'jul' => '07',
					'aug' => '08',
					'sep' => '09',
					'oct' => '10',
					'nov' => '11',
					'dec' => '12',
				);
				
		//'MMM D, YY':
		if ($date) {
			list ($md, $year,) = explode (',', $date);
			list ($month,$day) = explode (' ', $date);
			$month = $_short[strtolower($month)];
			$year  = '20'.trim($year);
			$day = trim($day);
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	private static function _form_date_10($date){
		$_short = array(
					'jan' => '01',
					'feb' => '02',
					'mar' => '03',
					'apr' => '04',
					'may' => '05',
					'jun' => '06',
					'jul' => '07',
					'aug' => '08',
					'sep' => '09',
					'oct' => '10',
					'nov' => '11',
					'dec' => '12',
				);
				
		//'MMM D, YYYY':
		if ($date) {
			list ($md, $year,) = explode (',', $date);
			list ($month,$day) = explode (' ', $date);
			$month = $_short[strtolower($month)];
			$year = trim($year);
			$day = trim($day);
			
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}


	private static function _form_date_11($date){
		$_long = array(
					'january' => '01',
					'february' => '02',
					'march' => '03',
					'april' => '04',
					'may' => '05',
					'june' => '06',
					'july' => '07',
					'august' => '08',
					'september' => '09',
					'october' => '10',
					'november' => '11',
					'december' => '12',
				);
				
		//'MMMM D, YYYY':
		if ($date) {
			list ($md, $year,) = explode (',', $date);
			list ($month,$day) = explode (' ', $date);
			$month = $_long[strtolower($month)];
			$year = trim($year);
			$day = trim($day);
			
			if(@checkdate($month,$day,$year)) return $year."-".$month."-".$day;
			else return null;
		} 
	}

	public static function ago($time)
	{
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
	
	   $now = time();
	
		$difference     = $now - $time;
		$tense         = "ago";
	
	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		   $difference /= $lengths[$j];
	   }
	
	   $difference = round($difference);
	
	   if($difference != 1) {
		   $periods[$j].= "s";
	   }
	
	   return "$difference $periods[$j] ago ";
	}

}