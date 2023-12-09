<?php
// Include database connection
include_once("../db_connection.php");

// Initialize variables
$bookings = array();

// SQL query to fetch all bookings
$query = "SELECT * FROM Bookings";
$result = $conn->query($query);

// Check if any bookings found
if ($result->num_rows > 0) {
  // Loop through each row and store data in array
  while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
  }
} else {
  echo "<p>No bookings found!</p>";
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
  <div class="container
 
mt-5">
    <div
 
class="card">
      <div
 
class="card-header">
        <h3>Bookings List</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Ven_ID</th>
              <th>Ev_ID</th>
              <th>Cust_ID</th>
              <th>Supp_ID</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($bookings as $booking) : ?>
              <tr>
                <td><?php echo $booking['ven_id']; ?></td>
                <td><?php echo $booking['ev_id']; ?></td>
                <td><?php echo $booking['cust_id']; ?></td>
                <td><?php echo $booking['supp_id']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>