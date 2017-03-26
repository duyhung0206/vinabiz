<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VINABIZ";
$tablename = "urlCompany";

$conn = new mysqli($servername, $username, $password, 'VINABIZ');
$sql = "SELECT count(*)
    FROM urlCompany";
$querry = $conn->query($sql);
$maxPage = $querry->fetch_row();
$querry->free();
$conn->close();
if($maxPage[0]==null){
    echo 0;
}else{
    echo $maxPage[0];
}
?>