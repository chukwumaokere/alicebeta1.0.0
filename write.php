<?php

require_once("database.php");
global $db;

//get user-input from url
$username=substr($_GET["username"], 0, 64);
$text=substr($_GET["text"], 0, 256);
$ip = $_GET["ip"];
$date = date('m-d-Y H:i:s');
$nameEscaped = htmlentities(mysqli_real_escape_string($db,$username)); //escape username and limit it to 64 chars
$textEscaped = htmlentities(mysqli_real_escape_string($db, $text)); //escape text and limit it to 256 chars
$input = strtolower($textEscaped);

$inputTextChar = strlen($input);
$inputTextWord = str_word_count($input);
$readSpeed = rand(3.16666, 3.33333);
$readTime = $inputTextWord / $readSpeed; //the time (in seconds) it takes for her to read a message is how long the message (in words) is and how many words per second shes reading.

//Should only run if that username with IP didnt previously exist

$personExist = getPerson($nameEscaped, $ip);


if ($personExist[1] == true){ //if the person already exists(based on their name and ip), just create the conversation record and link to that person
	addConvo($personExist[0], $textEscaped, $date);
}else{ //otherwise create the person and create the conversation record and link them
	addPerson($nameEscaped, $date, $ip);
	$person = getPerson($nameEscaped, $ip);
	addConvo($person[0], $textEscaped, $date);
}

if(strpos($input, "hi") !== false){
	$randomGreeting = randomGreeting();
	
//	sleep(2);
	aliceResponse($personExist[0], $randomGreeting, $date);
}

if(preg_match('/^(?=.*your)(?=.*name)/i', $input) === 1) {
//	sleep(3);
        aliceResponse($personExist[0], "My name is Alice, $personExist[3].", $date);
}
if(preg_match('/^(?=.*my)(?=.*name)/i', $input) === 1) {
//	sleep(3);
	aliceResponse($personExist[0], "I thought your name was $personExist[3]... Isn\'t it?", $date);
	
}

//FUNCTION DEFINITIONS

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
//SELECT * FROM convocache WHERE personid = $
function addConvo($i, $t, $d){
        global $db;
        $qaddconvo = "INSERT INTO convocache VALUES (NULL, $i, NULL, '', '$t', '$d', 0)";
        if ($db->real_query($qaddconvo)){
                $str = "Added Convo to db";
                return array($str, true);
        }else{
                $str = "Error failed";
                $error = $db->errno;
                return array($str, false, $error);
        }
}

function aliceResponse($i, $t, $d){
        global $db;
	global $readTime;

	$length = strlen($t);
	$typeSpeed = rand(3.166666, 3.33333);
	$typeTime = $length / $typeSpeed; //the time (in seconds) it takes for her to type is how many characters there are / how fast she types between 3.166 and 3.33 (human average) characters per second	

        $qaddconvo = "INSERT INTO convocache VALUES (NULL, $i, NULL, '', '$t', '$d', 1)";
        if ($db->real_query($qaddconvo)){
                $str = "Added response to db";
                return array($str, true);
        }else{
                $str = "Error failed";
                $error = $db->errno;
                return array($str, false, $error);
        }
	sleep($readTime);
	sleep($typeTime);
	
	file_put_contents("./export.txt", "$d - \"$t\" - it took $typeTime seconds \n", FILE_APPEND);
//	echo "<script>console.log(\"$typeTime\")</script>";
	echo "retrieveMessages();"; 
//	echo "scrollToBottom();";

}

function randomGreeting(){
	function randomArrayVar($array){
		if (!is_array($array)){
		return $array;
	}
		return $array[array_rand($array)];
	}
	//list of grettings as arary
 
	$greeting= array(
             "aloha"=>"Aloha",
             "ahoy"=>"Ahoy",
             "bonjour"=>"Bonjour",
             "gday"=>"G'day",
             "hello"=>"Hello",
             "hey"=>"Hey",
             "hi"=>"Hi",
             "hola"=>"Hola",
             "howdy"=>"Howdy",
             "rawr"=>"Rawr",
             "salutations"=>"Salutations",
             "sup"=>"Sup",
             "whatsup"=>"What's up",
             "yo"=>"Yo");
	return (randomArrayVar($greeting));

}
