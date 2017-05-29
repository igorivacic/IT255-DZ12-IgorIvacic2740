<?php
include("config.php");


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

function addRoom($roomname, $tv, $beds, $kvadratura){
	global $conn;
	$rarray = array();
	$stmt = $conn->prepare("INSERT INTO rooms (roomname, tv, beds, kvadratura) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss", $roomanem, $tv, $beds, $kvadratura);
	if($stmt->execute()){
		$rarray['sucess'] = "ok";
	}else{
		$rarray['error'] = "Database connection error";
	}
	return json_encode($rarray);
}

?>
