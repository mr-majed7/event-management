<?php
include_once("../db_connection.php");

// Initialize variables to store form data
$event_name = $event_type = $event_description = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event_name = isset($_POST['event_name']) ? $_POST['event_name'] : "";
    $event_type = isset($_POST['event_type']) ? $_POST['event_type'] : "";
    $event_description = isset($_POST['event_description']) ? $_POST['event_description'] : "";

    // Query to get the maximum existing event ID
    $sqlGetMaxID = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) AS max_id FROM Events";
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
        echo "Event added successfully!";
    } else {
        echo "Error adding event: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }

        h1 {
            color: #007bff;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Event</h1>
        <form action="" method="post">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" required>

            <label for="event_type">Event Type:</label>
            <input type="text" name="event_type" required>

            <label for="event_description">Event Description:</label>
            <input type="text" name="event_description" required>

            <button type="submit">Add Event</button>
        </form>
    </div>
</body>

</html>
