<?php
include_once("../db_connection.php");
$event_name = $event_type = $event_description = "";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event_name = isset($_POST['event_name']) ? $_POST['event_name'] : "";
    $event_type = isset($_POST['event_type']) ? $_POST['event_type'] : "";
    $event_description = isset($_POST['event_description']) ? $_POST['event_description'] : "";

    $venue_id = isset($_POST['venue_id']) ? $_POST['venue_id'] : "";
    $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : "";

    // Check if all fields are not empty
    if (!empty($event_name) && !empty($event_type) && !empty($event_description)) {

        // Query to get the maximum existing event ID with non-empty values
        $sqlGetMaxID = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) AS max_id FROM Events WHERE name IS NOT NULL AND type IS NOT NULL AND description IS NOT NULL";
        $resultMaxID = $conn->query($sqlGetMaxID);

        if ($resultMaxID && $resultMaxID->num_rows > 0) {
            $row = $resultMaxID->fetch_assoc();
            $maxID = $row["max_id"];
            $newID = "E" . ($maxID + 1);
        } else {
            $newID = "E1";
        }

        // Insert the new event into the Events table
        $sqlInsertEvent = "INSERT INTO Events (id, name, type, description) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlInsertEvent);
        $stmt->bind_param("ssss", $newID, $event_name, $event_type, $event_description);

        // Execute the statement
        if ($stmt->execute()) {
            // Retrieve the generated event ID
            $ev_id = $newID;

            // Insert into the bookings table using venue_id and customer_id
            $supp_id = null;

            $sqlInsertBooking = "INSERT INTO bookings (ven_id, ev_id, cust_id, supp_id) VALUES (?, ?, ?, ?)";
            $stmtBooking = $conn->prepare($sqlInsertBooking);
            $stmtBooking->bind_param("ssss", $venue_id, $ev_id, $customer_id, $supp_id);

            // Execute the booking statement
            if ($stmtBooking->execute()) {
                echo "Event added successfully! Added to Cart Successfully!";

            } else {
                echo "Error adding booking: " . $stmtBooking->error;
            }

            // Close the booking statement
            $stmtBooking->close();
        } else {
            echo "Error adding event: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill in all the fields.";
    }
}

// Close the database connection
$conn->close();
?>