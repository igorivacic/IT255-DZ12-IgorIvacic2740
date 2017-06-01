<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST');
include("functions.php");
include("config.php")

if(isset($_POST['firstName']) && isset($_POST['lastName']) &&
isset($_POST['username']) && isset($_POST['password'])){
$firstname = $_POST['firstName'];
$lastname = $_POST['lastName'];
$username = $_POST['username'];
$password = $_POST['password'];
echo singup($firstnam,$lastname,$username,$password);
}

}
?>
