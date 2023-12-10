<?php
// Include database connection
include_once("../db_connection.php");

// Get manager_id from the URL parameter
$manager_id = isset($_GET['manager_id']) ? $_GET['manager_id'] : null;

// Initialize variables
$bookings = array();

// Check if manager_id is provided
if ($manager_id !== null) {
    // SQL query to fetch bookings for the specific manager_id
    $query = "SELECT b.*, v.name AS venue_name, c.first_name, c.last_name AS customer_name, e.name AS event_name, s.name AS supplier_name
              FROM Bookings b
              INNER JOIN Venue v ON b.ven_id = v.id
              INNER JOIN Customer c ON b.cust_id = c.id
              INNER JOIN Events e ON b.ev_id = e.id
              INNER JOIN Supplier s ON b.supp_id = s.id
              INNER JOIN Manager m ON v.id = m.ven_id
              WHERE m.id = ?";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $manager_id);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if any bookings found
    if ($result->num_rows > 0) {
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
