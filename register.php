<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match. Please enter matching passwords.";
        echo '<script>
                setTimeout(function() {
                    window.location.href = "register.html";
                }, 1000); // 1000 milliseconds = 1 seconds
              </script>';
        exit();
    }

    // Database connection
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "auth";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed" . $conn->connect_error);
    }

    // If the username is not taken and passwords match, proceed with registration
    $checkQuery = "SELECT * FROM login WHERE username = '$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Username already exists
        echo "Username already taken. Please choose a different one.";
        echo '<script>
                setTimeout(function() {
                    window.location.href = "register.html";
                }, 1000); // 1000 milliseconds = 1 seconds
              </script>';
        exit();
    }

    // If the username is not taken, proceed with registration
    $insertQuery = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
    
    if ($conn->query($insertQuery) === TRUE) {
        // Registration successful
        header("Location: regSuccess.html");
        exit();
    } else {
        // Registration failed
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
        exit();
    }

    $conn->close();
}

?>
