<?php
include_once("../db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM manager WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user["password"]) {
            echo "Login successful!";
            header("Location: seller_home.php?manager_id=" . $user["id"]);
            exit(); 
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User does not exist!";
    }
}
?>
    } else {
        echo "User does not exist!";
    }

}


?>