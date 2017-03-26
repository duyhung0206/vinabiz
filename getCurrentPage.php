<?php
/**
 * Created by PhpStorm.
 * User: duyhung
 * Date: 11/03/2017
 * Time: 23:59
 */
//$currentPage = 1;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VINABIZ";
$tablename = "urlCompany";

$conn = new mysqli($servername, $username, $password, 'VINABIZ');
$sql = "SELECT MAX(page)
    FROM urlCompany";
$querry = $conn->query($sql);
$currentPage = $querry->fetch_row();

$querry->free();
$conn->close();
if($currentPage[0] == null){
    echo '0';
}else{
    echo $currentPage[0];
}
?>