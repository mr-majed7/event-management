<?php
include_once("../db_connection.php");

// Check if venue ID is provided in the URL
$venue_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($venue_id) {
    // Fetch venue details, manager details, and average rating using JOINs
    $sql = "SELECT v.id, v.name AS venue_name, v.area, v.city, v.price, v.capacity,
                   m.first_name AS manager_first_name, m.last_name AS manager_last_name,
                   m.email AS manager_email, m.phone AS manager_phone,
                   AVG(r.rating) AS average_rating
            FROM Venue v
            LEFT JOIN Manager m ON v.id = m.ven_id
            LEFT JOIN Review r ON v.id = r.ven_id
            WHERE v.id = ?
            GROUP BY v.id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $venue_id);
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
        <title>Venue Details</title>
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
    
            p {
                margin-bottom: 10px;
            }
    
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
    
            button {
                padding: 10px 20px;
                font-size: 16px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>
    
    <body>
        <div class="container">
HTML;

    if ($result->num_rows > 0) {
        $venueDetails = $result->fetch_assoc();

        // Display venue details, manager details, and average rating
        echo '<h1>Venue Details</h1>';
        echo '<p>ID: ' . $venueDetails['id'] . '</p>';
        echo '<p>Venue Name: ' . $venueDetails['venue_name'] . '</p>';
        echo '<p>Area: ' . $venueDetails['area'] . '</p>';
        echo '<p>City: ' . $venueDetails['city'] . '</p>';
        echo '<p>Price: ' . $venueDetails['price'] . '</p>';
        echo '<p>Capacity: ' . $venueDetails['capacity'] . '</p>';
        echo '<h2>Manager Details</h2>';
        echo '<p>Manager Name: ' . $venueDetails['manager_first_name'] . ' ' . $venueDetails['manager_last_name'] . '</p>';
        echo '<p>Manager Email: ' . $venueDetails['manager_email'] . '</p>';
        echo '<p>Manager Phone: ' . $venueDetails['manager_phone'] . '</p>';
        echo '<h2>Rating</h2>';
        echo '<p>Average Rating: ' . ($venueDetails['average_rating'] ? round($venueDetails['average_rating'], 2) : 'No ratings yet') . '</p>';

        // "Book Now" button and form
        echo '<form action="events.php" method="post">';
        echo '<input type="hidden" name="venue_id" value="' . $venue_id . '">';
        echo '<button type="submit">BOOK NOW!</button>';
        echo '</form>';

    } else {
        echo 'Venue not found.';
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
    echo 'Venue ID not provided.';
}
?>
