<?php
include_once("../db_connection.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlGetMaxID = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) AS max_id FROM Review";
$resultMaxID = $conn->query($sqlGetMaxID);

if ($resultMaxID && $resultMaxID->num_rows > 0) {
    $row = $resultMaxID->fetch_assoc();
    $maxID = $row["max_id"];
    $newID = "R" . ($maxID + 1);
} else {
    $newID = "R1"; 
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $customer_id = $_POST["customer_id"];
    $venue_id = $_POST["venue_id"];  
    
    // Prepare and execute the SQL statement to insert the review data
    $sql = "INSERT INTO `Review` (`id`, `cust_id`, `ven_id`, `rating`, `comment`, `date`) VALUES ('$newID', '$customer_id', '$venue_id', '$rating', '$comment', current_timestamp())";

    if ($conn->query($sql) === TRUE) {
        header("Location: customer_home.php?customer_id=$customer_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
