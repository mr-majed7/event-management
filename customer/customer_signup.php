<?php
include_once("../db_connection.php");


$sqlGetMaxID = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) AS max_id FROM Customer";
$resultMaxID = $conn->query($sqlGetMaxID);

if ($resultMaxID && $resultMaxID->num_rows > 0) {
    $row = $resultMaxID->fetch_assoc();
    $maxID = $row["max_id"];
    $newID = "C" . ($maxID + 1);
} else {
    $newID = "C1"; 
}

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phoneNumber'];
$password = $_POST['password'];

$sqlInsert = "INSERT INTO Customer (id, first_name, last_name, email, phone, password)
              VALUES ('$newID', '$firstName', '$lastName', '$email', '$phone', '$password')";

if ($conn->query($sqlInsert) === TRUE) {
    header("Location: customer_home.php?customer_id=" . $newID);
    exit();
} else {
    echo "Error: " . $sqlInsert . "<br>" . $conn->error;
}

$conn->close();
?>

