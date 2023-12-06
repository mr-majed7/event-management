<?php
include_once("../db_connection.php");
$manager_id = isset($_GET['manager_id']) ? $_GET['manager_id'] : null;
$sql = "SELECT * FROM Venue WHERE id IN (SELECT ven_id FROM Manager WHERE id = '$manager_id')";
$result = $conn->query($sql);

$venue_name = '';
$area = '';
$city = '';
$price = '';
$capacity = '';

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $venue_name = $row['name'];
    $area = $row['area'];
    $city = $row['city'];
    $price = $row['price'];
    $capacity = $row['capacity'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Venue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark-subtle justify-content-between">
        <a href="seller_home.php?manager_id=<?php echo $manager_id; ?>" class="btn btn-outline-primary my-2 my-sm-0" role="button">Back to Dashboard</a>
        <a href="../index.html" class="btn btn-outline-secondary my-2 my-sm-0" role="button">Logout</a>
    </nav>
    <div class="container mt-4">
        <h2>Edit Venue</h2>
        <form action="edit_venue.php" method="post">
            <input type="hidden" name="manager_id" value="<?php echo $manager_id; ?>">
            <div class="mb-3">
                <label for="inputVenueName" class="form-label">Venue Name</label>
                <input type="text" class="form-control" id="inputVenueName" name="venue_name" placeholder="Enter Venue Name" value="<?php echo $venue_name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="inputArea" class="form-label">Area</label>
                <input type="text" class="form-control" id="inputArea" name="area" placeholder="Enter Area" value="<?php echo $area; ?>" required>
            </div>
            <div class="mb-3">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity" name="city" placeholder="Enter City" value="<?php echo $city; ?>" required>
            </div>
            <div class="mb-3">
                <label for="inputPrice" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="inputPrice" name="price" placeholder="Enter Price" value="<?php echo $price; ?>" required>
            </div>
            <div class="mb-3">
                <label for="inputCapacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="inputCapacity" name="capacity" placeholder="Enter Capacity" value="<?php echo $capacity; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Edit Venue</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
