<?php
/**
 * Created by PhpStorm.
 * User: duyhung
 * Date: 11/03/2017
 * Time: 23:59
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VINABIZ_OLD";
$tablename = "conpanyInfo";

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT *
    FROM conpanyInfo;
";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row =  $result->fetch_assoc()){
        $name = html_entity_decode($row['name'],ENT_QUOTES);
        $director = html_entity_decode($row['director'],ENT_QUOTES);

        $conn->query("SET NAMES 'utf8'");
        $sqlupdate = "UPDATE conpanyInfo
SET name='".$name."',director='".$director."'
WHERE url_id=".$row['url_id'].";";
        $conn->query($sqlupdate);
        echo html_entity_decode($row['name'],ENT_QUOTES);
//        die();
        echo '<br/>';
    }
} else {
    echo 'error';
}
$conn->close();


?>