<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }
        </style>
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
                <a href="customer_home.php" class="btn btn-outline-info my-2 my-sm-0" role="button">Home</a>
                <a href="../index.html" class="btn btn-outline-primary my-2 my-sm-0" role="button">Logout</a>
            </nav>
        <?php
        include_once("../db_connection.php");
        $city = isset($_GET['city']) ? $_GET['city'] : null;
        $price = isset($_GET['price']) ? $_GET['price'] : null;
        $capacity = isset($_GET['capacity']) ? $_GET['capacity'] : null;


        $sql = "SELECT id, name, area, city, price, capacity FROM Venue WHERE 1=1";

        if ($city !== null && !empty($city)) {
            $sql .= " AND city = '$city'";
        }

        if ($price !== null && !empty($price)) {
            $sql .= " AND price <= $price";
        }

        if ($capacity !== null && !empty($capacity)) {
            $sql .= " AND capacity >= $capacity";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                echo '<div class="card" style="width: 18rem; margin: 10px; display: inline-block;">';
                echo '<ul class="list-group list-group-flush">';
                echo '<li class="list-group-item">Name: ' . $row["name"] . '</li>';
                echo '<li class="list-group-item">Location: ' . $row["area"] . ', ' . $row["city"] . '</li>';
                echo '<li class="list-group-item">Price: ' . $row["price"] . '</li>';
                echo '<li class="list-group-item">Capacity: ' . $row["capacity"] . '</li>';
                echo '</ul>';
                echo '<div class="card-body">';
                echo '<a href="details.php?id=' . $row["id"] . '" class="btn btn-primary">View</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }

        $conn->close();

        ?>
      
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>