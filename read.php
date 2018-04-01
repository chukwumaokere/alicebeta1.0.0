<?php
require_once("database.php");
//include_once("functions.php");

global $db;

$name = $_GET["username"];
$personip = $_GET["ip"];

$person = getPerson($name, $personip);


getConvo($person[0]);

function getConvo($pid) {
	global $db;
	$q = "SELECT * FROM convocache
	INNER JOIN people ON people.id = convocache.personid 
	WHERE personid = $pid";
	if ($db->real_query($q)){
		$res = $db->use_result();
		while($row = $res->fetch_assoc()){
			$username = $row["name"];
			$text = $row["content"];
			$time = $row["date"];
			$fromalice = $row["fromalice"];
			if ($fromalice == 0){
				$str = "<p class=\"usertext border border-primary rounded-left\"> $time | <b>$username</b>: $text</p> \n";
			}else{
				$username = "Alice";
				$str = "<p class=\"alicetext border border-secondary rounded-right\"> $time | <b>$username</b>: $text</p> \n";
			}
			echo $str;
		}
	}else{
		//query failed
		echo "Please enter a username to start chatting with Alice";
	//	echo "An error occured oh noey $db->errno";
		
	}
}

function getPerson($n, $i){
        global $db;
        $qgetperson = "SELECT * FROM people WHERE name = '$n' AND ip = '$i'";
        $check = $db->query($qgetperson);
        if ($check->num_rows > 0 ){
                $res = $check->fetch_row();
                $id = $res[0];
                $name = $res[1];
                $metond = $res[2];
                $ipad = $res[3];
                return array($id, true, $ipad, $name, $metond);
        }else{
                $str = "No one with the name and ip before";
                $error = $db->errno;
                return array($str, false, $error);
        }
}
