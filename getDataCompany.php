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
$dbname = "VINABIZ";
$tablename = "conpanyInfo";

$conn = new mysqli($servername, $username, $password, 'VINABIZ');
$sql = "SELECT *,urlCompany.url_id as url_id_1
    FROM urlCompany
    LEFT JOIN conpanyInfo
    ON conpanyInfo.url_id = urlCompany.url_id
    WHERE conpanyInfo.conpany_id IS NULL ;
";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $firstItem = $result->fetch_assoc();
    $url_id = $firstItem['url_id_1'];
    $urlCompany = $firstItem['url'];
} else {
    $message = array(
        'success' => 3,
        'message' => "Đã lấy hết dữ liệu !",
    );

    $output = json_encode($message);
    echo $output;
    die();
}
$conn->close();

/*get content*/
//// create a new cURL resource
$curl = curl_init($urlCompany);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 20);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($curl, CURLOPT_AUTOREFERER, true);

curl_setopt($curl, CURLOPT_PUT, FALSE);
curl_setopt($curl, CURLOPT_POST, FALSE);
$homepage = curl_exec($curl);
curl_close($curl);
$homepage = getStringBetween($homepage,'<table class="table table-bordered"','</table>');
$name = str_replace('<td>', '' , getStringBetween($homepage,'<td class="bg_table_td">Tên chính thức</td>','</td>'));
$email = str_replace('<td>', '' ,getStringBetween($homepage,'<td class="bg_table_td">Email</td>','</td>'));
$director = str_replace('<td>', '' ,getStringBetween($homepage,'<td class="bg_table_td">Giám đốc</td>','</td>'));
//echo htmlentities($email);
if(strpos($email,'data-cfemail=')){
    $data_cfemail = str_replace('<td>', '' ,getStringBetween($email,"data-cfemail=\"","\""));
    $data_cfhash = str_replace('<td>', '' ,getStringBetween($email,'data-cfhash=\'','\''));

    $email = decod($data_cfemail,$data_cfhash);
}

/*insert table*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VINABIZ";
$tablename = "conpanyInfo";

$conn = new mysqli($servername, $username, $password, 'VINABIZ');

$email = $conn->real_escape_string($email);
$name = html_entity_decode(($name),ENT_QUOTES);
$director = html_entity_decode(($director),ENT_QUOTES);
$conn->query("SET NAMES 'utf8'");

$sql = "INSERT INTO conpanyInfo(url_id, name, director, email)
VALUES ($url_id, '$name', '$director' ,'$email');";
if ($conn->query($sql) === TRUE) {
    $sql = "SELECT count(*)
        FROM conpanyInfo;
    ";
    $result = $conn->query($sql);
    $numbercompany = $result->fetch_row();
    $message = array(
        'success' => 1,
        'message' => " Insert dữ liệu công ty ". substr($name,1) . " thành công",
        'numbercompany' => $numbercompany[0]
    );
} else {
    $message = array(
        'success' => 0,
        'message' => "Lỗi khi insert dữ liệu " . $conn->error,
    );

}

$output = json_encode($message);
echo $output;

$conn->close();

function getStringBetween($str,$from,$to)
{
    $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
    return substr($sub,0,strpos($sub,$to));
}

function decod($cfemail, $cfhash) {
    $e = '';
    for($r = hexdec(substr($cfemail, 0, 2)), $n = 2; strlen($cfemail) - $n; $n+=2 ){
        //$s = substr($cfemail, $n, 2);
        //$s = dechex(hexdec($s) ^ $r);
        //$s = "0" . $s;
        //$s = substr($s, -2);
        //$e .= chr(hexdec($s));
        $e .= chr(hexdec(substr("0" . dechex(hexdec(substr($cfemail, $n, 2)) ^ $r), -2)));
    }
    return $e;
}


?>