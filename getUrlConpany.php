<?php
$currentPage = $_POST['currentpage'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VINABIZ";
$tablename = "urlCompany";

$conn = new mysqli($servername, $username, $password, 'VINABIZ');
$sql = "SELECT MAX(page)
    FROM urlCompany";
$querry = $conn->query($sql);
$maxPage = $querry->fetch_row();



if($maxPage[0] != null){
    if($maxPage[0] >= $currentPage){
        $sql = "DELETE FROM urlCompany
WHERE page=".$currentPage.";";
        $conn->query($sql);
    }
}
$querry->free();
$conn->close();
$url = 'https://vinabiz.org/company/'.$currentPage;
//// create a new cURL resource
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

curl_setopt($curl, CURLOPT_PUT, FALSE);
curl_setopt($curl, CURLOPT_POST, FALSE);
$homepage = curl_exec($curl);
$homepage = getStringBetween($homepage,'row margin-right-15 margin-left-10','pagination-container');

preg_match_all("<a href=\x22(.+?)\x22>", $homepage, $matches);
// delete redundant parts
$matches = str_replace("a href=", "", $matches); // remove a href=
$matches = str_replace("\"", "", $matches); // remove "
// output all matches
/*insert table*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VINABIZ";
$tablename = "urlCompany";

$conn = new mysqli($servername, $username, $password, 'VINABIZ');
$value = '';
foreach ($matches[1] as $item){
    $value.="(".$currentPage.",'https://vinabiz.org".$item."'),";
}
$value = substr($value,0,-1);

$sql = "INSERT INTO urlCompany(page, url)
VALUES $value;";
if ($conn->query($sql) === TRUE) {
    echo "Insert database successfully: page ".$currentPage.", number url: ". count($matches[1]);
} else {
    echo "Error insert database page ".$currentPage.": " . $conn->error;
}
echo '<br/>&#13';

$conn->close();


function getStringBetween($str,$from,$to)
{
    $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
    return substr($sub,0,strpos($sub,$to));
}
?>