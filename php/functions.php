<?php
include("config.php");



function checkIfLoggedIn(){
global $conn;
if(isset($_SERVER['HTTP_TOKEN'])){
$token = $_SERVER['HTTP_TOKEN'];
$result = $conn->prepare("SELECT * FROM users WHERE token=?");
$result->bind_param("s",$token);
$result->execute();
$result->store_result();
$num_rows = $result->num_rows;
if($num_rows > 0)
{
return true;
}
else{
return false;
}
}
else{
return false;
}
}
function login($username, $password){
global $conn;
$rarray = array();
if(checkLogin($username,$password)){
$id = sha1(uniqid());
$result2 = $conn->prepare("UPDATE users SET token=? WHERE username=?");
$result2->bind_param("ss",$id,$username);
$result2->execute();
$rarray['token'] = $id;
} else{
header('HTTP/1.1 401 Unauthorized');
$rarray['error'] = "Invalid username/password";
}
return json_encode($rarray);
}

function checkLogin($username, $password){
global $conn;
$password = md5($password);
$result = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
$result->bind_param("ss",$username,$password);
$result->execute();
$result->store_result();
$num_rows = $result->num_rows;
if($num_rows > 0)
{
return true;
}
else{
return false;
}
}



function singup($firstname, $lastname, $username, $password){
	global $conn;
	$ar = array();
	$errors = "";
	if(checkIfUserExists($username)){
		$errors .= "Korisnicko ime zauzeto!";
	}
	if($errors == ""){
		$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username,password) VALUES (?, ?, ?, ?)");
		$pass =md5($password);
		$stmt->bind_param("ssss", $firstname, $lastname, $username, $pass);
		if($stmt->execute()){
			$id = sha1(uniqid());
			$result2 = $conn->prepare("UPDATE users SET token=? WHERE username=?");
			$result2->bind_param("ss",$id,$username);
			$result2->execute();
			$ar['token'] = $id;
		}else{
			header('HTTP/1.1 400 Bad request');
			$ar['error'] = "Greska!";
		}
	} else{
		header('HTTP/1.1 400 Bad request');
		$ar['error'] = json_encode($errors);
	}

	return json_encode($ar);
}


function checkIfUserExists($username){
global $conn;
$result = $conn->prepare("SELECT * FROM users WHERE username=?");
$result->bind_param("s",$username);
$result->execute();
$result->store_result();
$num_rows = $result->num_rows;
if($num_rows > 0)
{
return true;
}
else{
return false;
}
}

function getRooms(){
global $conn;
$rarray = array();

$result = mysqli_query($conn, "SELECT * FROM rooms");
$num_rows = mysqli_num_rows($result);
$rooms = array();
if($num_rows > 0)
{
while($row = mysqli_fetch_assoc($result)) {
$one_room = array();
$one_room['id'] = $row['id'];
$one_room['roomname'] = $row['roomname'];
$one_room['tv'] = $row['tv'];
$one_room['beds'] = $row['beds'];
$one_room['kvadratura'] = $row['kvadratura'];
array_push($rooms,$one_room);
}
}
$rarray['rooms'] = $rooms;
return json_encode($rarray);
}

function addHotel($naziv, $zvezdice, $komentar){
	global $conn;
	$rarray = array();
	$stmt = $conn->prepare("INSERT INTO hoteli (naziv, zvezdice, komentar) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $naziv, $zvezdice, $komentar);
	if($stmt->execute()){
		$rarray['sucess'] = "ok";
	}else{
		$rarray['error'] = "Database connection error";
	}
	return json_encode($rarray);
}

?>
