<?php
include_once("../db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manager_id = $_POST['manager_id'];
    $venue_name = $_POST['venue_name'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];

    $sqlGetMaxID = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) AS max_id FROM Venue";
    $resultMaxID = $conn->query($sqlGetMaxID);

    if ($resultMaxID && $resultMaxID->num_rows > 0) {
        $row = $resultMaxID->fetch_assoc();
        $maxID = $row["max_id"];
        $newID = "V" . ($maxID + 1);
    } else {
        $newID = "V1";
    }

    $sql = "INSERT INTO Venue (id, name, area, city, price, capacity, booking_status)
            VALUES ('$newID', '$venue_name', '$area', '$city', $price, $capacity, 0)";

    if ($conn->query($sql) === TRUE) {
        $sqlUpdateManager = "UPDATE Manager SET ven_id = '$newID' WHERE id = '$manager_id'";
        if ($conn->query($sqlUpdateManager) === TRUE) {
            header("Location: seller_home.php?manager_id=$manager_id");
            exit();
        } else {
            echo "Error updating Manager table: " . $conn->error;
        }
    } else {
        echo "Error creating venue: " . $conn->error;
    }
}
?>
