<?php

require_once("database.php");
global $db;

$name = 'phil';
$ip = '24.148.25.178';

//$test = getPerson($name, $ip);
$personExist = getPerson($name, $ip);
$textEscaped = "Hello";
$date = date('m-d-Y H:i:s');

if ($personExist[1] == true){ //if the person already exists(based on their name and ip), just create the conversation record and link to that person
        addConvo($personExist[0], $textEscaped, $date);
}else{ //otherwise create the person and create the conversation record and link them
        addPerson($name, $date, $ip);
        $person = getPerson($name, $ip);
        addConvo($person[0], $textEscaped, $date);
}
//echo "person name is $test[3] and ip = $test[2], $test[4], $test[0], $test[1] \n";

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

function addPerson($n, $d, $i){
	global $db;
        $queryaddperson = "INSERT INTO people VALUES (NULL, '$n', '$d', '$i')";
        if($db->real_query($queryaddperson)){
                $str = "Added person to db";
                return array($str, true);
        }else{
                $str = "Error occured";
                $error = $db->errno;
                return array($str, false, $error);
        }

}

function addConvo($i, $t, $d){
	global $db;
        $qaddconvo = "INSERT INTO convocache VALUES (NULL, $i, '', '$t', '$d')";
        if ($db->real_query($qaddconvo)){
                $str = "Added Convo to db";
                return array($str, true);
        }else{
                $str = "Error failed";
                $error = $db->errno;
                return array($str, false, $error);
        }
}
