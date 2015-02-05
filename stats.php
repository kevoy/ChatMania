<?php
include 'startdb.php';
	session_start();
	if(isset($_REQUEST['getdate'])){
		if($_REQUEST['getcount'] == "today"){
			getTodaysCount();
		}else if($_REQUEST['getcount'] == "yesterday"){
			getYesterdaysCount();
		}else if($_REQUEST['getcount'] == "thismonth"){
			getCurrentMonthsCount();
		}else if($_REQUEST['getcount'] == "all"){
			getTotalCount();
		}
	}else if(isset($_REQUEST['addcount']) && !isset($_SESSION['admin'])){
		addCount();

	}
	function addCount(){
		$today = date("Y-m-d");
		$result = startDB("SELECT * FROM stats WHERE Date = '$today' LIMIT 0,1;");
		if(mysql_num_rows($result)<1){
			$insertNew = startDB("INSERT INTO stats VALUES ('$today', '1')");
			//echo'yes';
		}else{
			while($row = mysql_fetch_array($result)){
				$count = $row['Count'] + 1;
				$insertIncrement = startDB("UPDATE stats SET Count = '$count' WHERE Date = '$today'; ");
			}
			//echo'no';
		}
	}
	function getTodaysCount(){
		$today = date("Y-m-d");
		$total = 0;
		$result = startDB("SELECT * FROM stats WHERE Date = '$today' LIMIT 0,1;");
		while($row = mysql_fetch_array($result)){
			$total = $row['Count'];
		}
		echo $total;
	}
	function getYesterdaysCount(){
		$yesterday = mktime(0,0,0,date("m"), date("d")-1, date("Y"));
		$date = date("Y-m-d", $yesterday);
		$total = 0;
		$result = startDB("SELECT * FROM stats WHERE Date = '$date' LIMIT 0,1;");
		while($row = mysql_fetch_array($result)){
			$total = $row['Count'];
		}
		echo $total;
	}
	function getCurrentMonthsCount(){
		$curmonth = mktime(0,0,0,date("m"), "01", date("Y"));
		$date = date("Y-m-d", $curmonth);
		$total = 0;
		$result = startDB("SELECT * FROM stats WHERE Date >= '$date';");
		while($row = mysql_fetch_array($result)){
			$total += $row['Count'];

		}
		echo $total;
	}
	function getTotalCount(){
		$total = 0;
		$result = startDB("SELECT * FROM stats;");
		while($row = mysql_fetch_array($result)){
			$total += $row['Count'];

		}
		echo $total;
	}

?>