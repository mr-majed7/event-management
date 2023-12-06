<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark-subtle justify-content-between">
        <?php
        $manager_id = isset($_GET['manager_id']) ? $_GET['manager_id'] : null;
        ?>

        <form class="form-inline" action="sale_history.php" method="get">
            <input type="hidden" name="manager_id" value="<?php echo $manager_id; ?>">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Bookings</button>
        </form>

        <a href="../index.html" class="btn btn-outline-secondary my-2 my-sm-0" role="button">Logout</a>
    </nav>
    
    <div class="container mt-4">
        <?php
        include_once("../db_connection.php");
        $manager_id = isset($_GET['manager_id']) ? $_GET['manager_id'] : null;
        $sql = "SELECT Venue.id AS ven_id, Venue.name AS venue_name, Venue.area, Venue.city, Venue.price, Venue.capacity, Venue.booking_status 
                  FROM Venue 
                  INNER JOIN Manager ON Venue.id = Manager.ven_id 
                  WHERE Manager.id = '$manager_id'";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '<h2>Your Venue</h2>';
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th scope="col">Venue Name</th>
                        <th scope="col">Area</th>
                        <th scope="col">City</th>
                        <th scope="col">Price</th>
                        <th scope="col">Capacity</th>
                        <th scope="col">Booking Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['venue_name'] . '</td>';
                echo '<td>' . $row['area'] . '</td>';
                echo '<td>' . $row['city'] . '</td>';
                echo '<td>' . $row['price'] . '</td>';
                echo '<td>' . $row['capacity'] . '</td>';
                echo '<td>' . ($row['booking_status'] == 1 ? 'Booked' : 'Available') . '</td>';
                echo '<td>';
                echo '<form action="change_status.php" method="get">';
                echo '<input type="hidden" name="manager_id" value="' . $manager_id . '">';
                echo '<input type="hidden" name="ven_id" value="' . $row['ven_id'] . '">';
                echo '<button type="submit" class="btn btn-secondary btn-sm">Change Status</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';

            echo '<div class="d-flex justify-content-center mt-3">';
            echo '<div class="text-center">';
            echo '<a href="edit_venueForm.php?manager_id=' . $manager_id . '" class="btn btn-info btn-lg btn-block">Edit</a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="text-center mt-3">';
            echo '<a href="add_venueForm.php?manager_id=' . $manager_id . '" class="btn btn-success btn-lg" role="button">Add Venue</a>';
            echo '</div>';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
