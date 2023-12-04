<?php
include_once("../db_connection.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $manager_id = $_GET['manager_id'];
    $ven_id = $_GET['ven_id'];

    $sqlGetStatus = "SELECT booking_status FROM Venue WHERE id = '$ven_id'";
    $result = $conn->query($sqlGetStatus);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentStatus = $row['booking_status'];

        $newStatus = ($currentStatus == 1) ? 0 : 1;

        $sqlUpdateStatus = "UPDATE Venue SET booking_status = $newStatus WHERE id = '$ven_id'";
        if ($conn->query($sqlUpdateStatus) === TRUE) {
            header("Location: seller_home.php?manager_id=" . $manager_id);
            exit();
        } else {
            echo "Error updating status: " . $conn->error;
        }
    } else {
        echo "Status not found.";
    }
}
?>