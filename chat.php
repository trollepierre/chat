<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
/*$nom = $_POST['nom'];*/
$nom =  $_SESSION['username'];
$message = $_POST['message'];
$arrayToAppend['nom']=$nom;
$arrayToAppend['when']="03/03/2016 23:59";
$arrayToAppend['message']=$message;

$filename='conversation.json';


$jsonString = file_get_contents($filename);
$data=json_decode($jsonString,true);
array_push($data, $arrayToAppend);
$jsonData=json_encode($data);
file_put_contents($filename, $jsonData);

?>
