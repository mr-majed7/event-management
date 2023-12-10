<?php
// Include database connection
include_once("../db_connection.php");

// Get manager_id from the URL parameter
$manager_id = isset($_GET['manager_id']) ? $_GET['manager_id'] : null;

if ($manager_id) {
    // Prepare the SQL query to retrieve bookings information for the provided manager_id
    $query = "SELECT Bookings.ven_id, Venue.name AS venue_name, Bookings.cust_id, Customer.first_name AS customer_name, 
              Bookings.ev_id, Events.name AS event_name, Bookings.supp_id, Supplier.name AS supplier_name 
              FROM Bookings 
              LEFT JOIN Venue ON Bookings.ven_id = Venue.id 
              LEFT JOIN Customer ON Bookings.cust_id = Customer.id 
              LEFT JOIN Events ON Bookings.ev_id = Events.id 
              LEFT JOIN Supplier ON Bookings.supp_id = Supplier.id 
              WHERE Venue.id = (SELECT ven_id FROM Manager WHERE id = ?)";

    // Prepare and bind the statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $manager_id);
        
        // Execute the query
        $stmt->execute();
        
        // Get result
        $result = $stmt->get_result();
        
        // Check if any bookings found
        if ($result->num_rows > 0) {
            // Initialize $bookings array
            $bookings = array();
            
            // Loop through each row and store data in array
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
        } else {
            echo "<p>No bookings found for the manager!</p>";
        }

        // Close prepared statement
        $stmt->close();
    } else {
        echo "<p>Failed to prepare the statement!</p>";
    }
} else {
    echo "<p>Manager ID is not provided!</p>";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookings | Event Management</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Bookings List</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              
              <th>Venue ID</th>
              <th>Venue Name</th>
              <th>Customer ID</th>
              <th>Customer Name</th>
              <th>Event ID</th>
              <th>Event Name</th>
              <th>Supplier ID</th>
              <th>Supplier Name</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($bookings as $booking) : ?>
              <tr>
                
                <td><?php echo $booking['ven_id']; ?></td>
                <td><?php echo $booking['venue_name']; ?></td>
                <td><?php echo $booking['cust_id']; ?></td>
                <td><?php echo $booking['customer_name']; ?></td>
                <td><?php echo $booking['ev_id']; ?></td>
                <td><?php echo $booking['event_name']; ?></td>
                <td><?php echo $booking['supp_id']; ?></td>
                <td><?php echo $booking['supplier_name']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
