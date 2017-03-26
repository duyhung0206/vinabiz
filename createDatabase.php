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
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE VINABIZ";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
$conn->close();


/*-----------------------------------------------------------------*/
$conn = new mysqli($servername, $username, $password, 'VINABIZ');
echo '<br/>&#13';
// Create table
$sql = "
CREATE TABLE urlCompany (
    `url_id` INT UNSIGNED AUTO_INCREMENT,
    `page` int(255) NOT NULL,
    `url` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`url_id`)
)";
if ($conn->multi_query($sql) === TRUE) {
    echo "Table urlCompany successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

echo '<br/>&#13';
$sql = "
CREATE TABLE conpanyInfo (
    `conpany_id` INT UNSIGNED AUTO_INCREMENT,
    `url_id` INT UNSIGNED,
    `name` VARCHAR(255) NOT NULL,
    `director` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`conpany_id`),
    FOREIGN KEY (`url_id`) REFERENCES urlCompany(url_id) ON DELETE CASCADE ON UPDATE CASCADE
) DEFAULT CHARSET=utf8";
if ($conn->multi_query($sql) === TRUE) {
    echo "Table conpanyInfo successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
echo '<br/>&#13';


$conn->close();
?>