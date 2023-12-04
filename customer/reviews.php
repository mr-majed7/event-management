<?php
include_once("../db_connection.php");

$venue_id = isset($_GET['venue_id']) ? $_GET['venue_id'] : null;
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;

if ($venue_id === null || $customer_id === null) {
    die("Venue ID or Customer ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Event Review</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Event Review</h2>

        <form action="submit_review.php" method="post">
            <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
            <input type="hidden" name="venue_id" value="<?php echo htmlspecialchars($venue_id); ?>">

            <div class="form-group">
                <label for="rating">Rating (1-5): </label>
                <input type="number" class="form-control" name="rating" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="comment">Comment: </label>
                <textarea class="form-control" name="comment" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>

        <hr>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849nv0OKIq6pLoKof7ujpYUxMKZlM/3O96E5LOlSkcF/6p3R1dXJK25s9F5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJf8aGiAaxQV85I+Bfx1J8/iN3U6ZaL8f5J3/yvmVz5CBvD+BFbc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WySLA/W555Ddh7zvgFb7EEq8ML4Mjs3Plb" crossorigin="anonymous"></script>
</body>
</html>
