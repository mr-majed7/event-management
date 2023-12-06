<?php
include_once("../db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manager_id = $_POST['manager_id'];
    $venue_name = $_POST['venue_name'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];

    // Update query for the Venue associated with the manager_id
    $update_query = "UPDATE Venue 
                     SET name = '$venue_name', area = '$area', city = '$city', price = '$price', capacity = '$capacity' 
                     WHERE id IN (SELECT ven_id FROM Manager WHERE id = '$manager_id')";

    if ($conn->query($update_query) === TRUE) {
        // Successful update, redirect to seller_home.php with the manager_id
        header("Location: seller_home.php?manager_id=$manager_id");
        exit();
    } else {
        // Error in update query
        echo "Error updating venue: " . $conn->error;
    }
} else {
    // Redirect if accessed without POST method
    header("Location: ../index.html");
    exit();
}
?>
