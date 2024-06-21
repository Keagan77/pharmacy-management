<?php
ob_start();
include "database.php";
session_start();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = validate($_POST["fname"]);
    $pass = $_POST["password"];

    $sql = "SELECT * FROM staff WHERE fname='$fname'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row["Password"])) {
            $_SESSION["username"] = $fname;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Maharashtra Medical</title>
    <link rel="icon" href="./images/hands.png">
    <link rel="stylesheet" href="CSS/login.css">
    <style>
        h1 {
            text-align: center;
        }

        .wrapper {
            padding: 35px;
        }
    </style>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <form action="login.php" method="post">
            <h1>Login</h1>
            <label>Username:</label><br>
            <div class="input-box">
                <input type="text" name="fname" placeholder="Enter Username/First Name" required><br>
            </div>

            <label>Password:</label><br>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Enter Password" required><br>
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </div>
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>