<?php
include_once("../db_connection.php");

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;

$sql = "SELECT Bookings.ev_id, Bookings.ven_id, Bookings.cust_id, Bookings.supp_id, Events.name AS event_name, Events.description AS event_description, Events.type AS event_type, Venue.name AS venue_name
        FROM Bookings 
        INNER JOIN Events ON Bookings.ev_id = Events.id 
        INNER JOIN Venue ON Bookings.ven_id = Venue.id 
        WHERE Bookings.cust_id = '$customer_id'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Customer Bookings</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark-subtle justify-content-between">
    <form class="form-inline" action="filter.php" method="get">
        <div class="d-flex">
            <input class="form-control mr-sm-2" type="search" name="city" placeholder="City" aria-label="City">
            <input class="form-control mr-sm-2" type="search" name="price" placeholder="Maximum Price" aria-label="Price">
            <input class="form-control mr-sm-2" type="search" name="capacity" placeholder="Minimum Capacity" aria-label="Capacity">
            <button class="btn btn-outline-success my-2 my-sm-0 ml-2" type="submit">Filter</button>
        </div>
    </form>
    <a href="customer_home.php?customer_id=<?php echo $customer_id; ?>" class="btn btn-outline-info my-2 my-sm-0" role="button">Home</a>
    <a href="../index.html" class="btn btn-outline-primary my-2 my-sm-0" role="button">Logout</a>
</nav>
<div class="container mt-5">
    <h2 class="mb-4">Customer Bookings</h2>

    <?php if ($result && $result->num_rows > 0) : ?>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Venue Name: <?php echo $row['venue_name']; ?></h5>
                    <p class="card-text">Event Name: <?php echo $row['event_name']; ?></p>
                    <p class="card-text">Event Description: <?php echo $row['event_description']; ?></p>
                    <p class="card-text">Event Type: <?php echo $row['event_type']; ?></p>
                    <a href='reviews.php?venue_id=<?php echo $row['ven_id']; ?>&customer_id=<?php echo $customer_id; ?>' class="btn btn-primary">Review</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No events found for this customer</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849nv0OKIq6pLoKof7ujpYUxMKZlM/3O96E5LOlSkcF/6p3R1dXJK25s9F5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJf8aGiAaxQV85I+Bfx1J8/iN3U6ZaL8f5J3/yvmVz5CBvD+BFbc" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WySLA/W555Ddh7zvgFb7EEq8ML4Mjs3Plb" crossorigin="anonymous"></script>
</body>
</html>
