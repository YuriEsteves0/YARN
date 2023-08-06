<?php 

$localhost = 'localhost';
$root = 'root';
$passw = '';
$db = 'yarn';

try{
    $cx = new PDO("mysql:host=$localhost;dbname=$db", $root, $passw);
}catch(PDOException $e){
    $e->getMessage();
}
?>