<?php
include_once("../db_connection.php");

// Check if event ID is provided in the URL
$event_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($event_id) {
    // Fetch event details using a query
    $sql = "SELECT e.id, e.name AS event_name, e.type AS event_type, e.description AS event_description,
                   v.name AS venue_name, v.area, v.city, v.price
            FROM Events e
            LEFT JOIN Bookings b ON e.id = b.ev_id
            LEFT JOIN Venue v ON b.ven_id = v.id
            WHERE e.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $event_id);
    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        die("Query execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    // Output HTML with embedded PHP
    echo <<<HTML
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
    
            h1, h2 {
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
    
            p {
                margin-bottom: 10px;
            }
    
            .total {
                font-weight: bold;
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
HTML;

    if ($result->num_rows > 0) {
        $eventDetails = $result->fetch_assoc();

        // Display event and venue details
        echo '<h1>Checkout</h1>';
        echo '<h2>Event Details</h2>';
        echo '<p>ID: ' . $eventDetails['id'] . '</p>';
        echo '<p>Event Name: ' . $eventDetails['event_name'] . '</p>';
        echo '<p>Event Type: ' . $eventDetails['event_type'] . '</p>';
        echo '<p>Event Description: ' . $eventDetails['event_description'] . '</p>';
        echo '<h2>Venue Details</h2>';
        echo '<p>Venue Name: ' . $eventDetails['venue_name'] . '</p>';
        echo '<p>Area: ' . $eventDetails['area'] . '</p>';
        echo '<p>City: ' . $eventDetails['city'] . '</p>';
        echo '<p>Price: ' . $eventDetails['price'] . '</p>';
        echo '<h2>Total Payable Amount</h2>';
        echo '<p class="total">$' . $eventDetails['price'] . '</p>';
        echo '<button type="button">Proceed to Payment</button>';
    } else {
        echo 'Event not found.';
    }

    // Output the rest of HTML
    echo <<<HTML
        </div>
    </body>
    
    </html>
HTML;

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    echo 'Event ID not provided.';
}
?>
