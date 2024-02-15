<?php

// Start the session: to use _SESSION superglobal var
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // database connection

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "auth";


    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if($conn->connect_error){
        die("Connection failed" . $conn->connect_error);
    }

    // validate login authentication
    $query = "SELECT *FROM login WHERE username= '$username' AND password= '$password'";

    $result = $conn->query($query);

    if($result->num_rows == 1){
        // loggin success
        // echo "Login successful!";

        // Store the username in the session
        $_SESSION['username'] = $username;

        header("Location: success.html");
        exit();
    }
    else{
        //login failed
        echo "Login failed. Please check your username and password.";
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.html";
                }, 500); //wait 500 miliseconds
              </script>';
        // header("Location: failed.html");
        exit();
    }

    $conn->close();
}

?>