<?php
include_once("../db_connection.php");

// Retrieve venue_id and customer_id from the URL parameters
$venue_id = isset($_GET['venue_id']) ? $_GET['venue_id'] : null;
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
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
        <form action="eventsSubmit.php" method="post">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" required>

            <label for="event_type">Event Type:</label>
            <input type="text" name="event_type" required>

            <label for="event_description">Event Description:</label>
            <input type="text" name="event_description" required>
            <input type="hidden" name="venue_id" value="<?php echo $venue_id; ?>">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

            <button type="submit">Add Event</button>
        </form>
    </div>
</body>

</html>
