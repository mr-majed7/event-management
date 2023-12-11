<?php
include_once("../db_connection.php");

// Assuming you get the venue_id from the previous page or another source
$venue_id = isset($_GET['venue_id']) ? $_GET['venue_id'] : null;

// Prepare SQL query with JOIN statements
$sql = "
    SELECT
        v.id AS venue_id,
        v.name AS venue_name,
        v.area,
        v.city,
        v.price AS venue_price,
        m.id AS manager_id,
        m.first_name AS manager_name,
        e.id AS event_id,
        e.name AS event_name,
        e.type AS event_type,
        e.description AS event_description
    FROM
        venue v, manager m, events e, bookings b
    WHERE
        v.id = m.ven_id AND v.id = b.ven_id AND b.ev_id = e.id
";

// Prepare and bind parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $venue_id);

// Execute the query
if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch data
        $row = $result->fetch_assoc();

        // Display venue information
        echo "<h2>Venue Information</h2>";
        echo "Venue ID: " . $row['venue_id'] . "<br>";
        echo "Venue Name: " . $row['venue_name'] . "<br>";
        echo "Area: " . $row['area'] . "<br>";
        echo "City: " . $row['city'] . "<br>";
        echo "Venue Price: " . $row['venue_price'] . "<br>";

        // Display manager information
        echo "<h2>Manager Information</h2>";
        echo "Manager ID: " . $row['manager_id'] . "<br>";
        echo "Manager Name: " . $row['manager_name'] . "<br>";

        // Display event information (if available)
        if (!empty($row['event_id'])) {
            echo "<h2>Event Information</h2>";
            echo "Event ID: " . $row['event_id'] . "<br>";
            echo "Event Name: " . $row['event_name'] . "<br>";
            echo "Event Type: " . $row['event_type'] . "<br>";
            echo "Event Description: " . $row['event_description'] . "<br>";
        }

        // Add your total payable amount calculation here

        // Display checkout button
        echo "<button onclick=\"window.location.href='proceed_to_checkout.php?venue_id=" . $venue_id . "';\">Proceed to Checkout</button>";
    } else {
        echo "No data found for the given venue ID.";
    }
} else {
    echo "Error executing the query: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .details {
            text-align: left;
            margin-bottom: 20px;
        }

        .total {
            font-weight: bold;
            color: red;
            text-align: right;
            margin-top: 20px;
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
        <h1>Checkout</h1>

        <div class="details">
            <h2>Event Details</h2>
            <p><strong>Name:</strong> <?php echo $event['name']; ?></p>
            <p><strong>Type:</strong> <?php echo $event['type']; ?></p>
            <p><strong>Description:</strong> <?php echo $event['description']; ?></p>
        </div>

        <div class="details">
            <h2>Venue Details</h2>
            <p><strong>Name:</strong> <?php echo $venue['name']; ?></p>
            <p><strong>Area:</strong> <?php echo $venue['area']; ?></p>
            <p><strong>City:</strong> <?php echo $venue['city']; ?></p>
            <p><strong>Price:</strong> <?php echo $venue['price']; ?></p>
        </div>

        <div class="details">
            <h2>Manager Details</h2>
            <p><strong>Name:</strong> <?php echo $manager['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $manager['email']; ?></p>
        </div>

        <div class="total">
            <h2>Total Payable Amount: $<?php echo $venue['price']; ?></h2>
        </div>

        <button type="submit">Proceed to Checkout</button>
    </div>
</body>

</html>