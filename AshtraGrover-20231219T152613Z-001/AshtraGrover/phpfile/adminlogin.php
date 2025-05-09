<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ashtragroverdb";

$conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE adminuser = '$enteredUsername' AND adminpass = '$enteredPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: ../adminmenu.html");
        exit();
    } else {
        echo "Invalid username or password";
    }
}

$conn->close();
?>