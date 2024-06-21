<?php
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up | Maharashtra Medical</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./images/hands.png">
    <link rel="stylesheet" href="CSS/signupp.css">
    <style>
        #chech-btn {
            padding: 7px 5px 7px 5px;
            margin: 2px;
            background-color: white;
            border: 1px solid white;
            border-radius: 3px;
            cursor: pointer;
        }

        .lab1 {
            background: linear-gradient(skyblue, lightgreen);
            font-weight: bold;
            color: black;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h1>Sign Up</h1>
            <div class="lab">
                <label for="name">First Name/Username:</label><br>
                <input type="text" id="Name" name="firname" placeholder="Enter your First Name/Username" required style="width: 64%;">
                <button id="chech-btn" type="button" onclick="checkName()">Check Username</button>
                <span class="lab1" id="nameStatus"></span><br><br>
            </div>
            <div class="lab">
                <label for="surname">Surname</label><br>
            </div>
            <input type="text" id="Surname" name="surname" placeholder="Enter your Surname" required><br><br>
            <div class="lab">
                <label for="email">Email:</label><br>
            </div>
            <input type="email" id="Email" name="email" placeholder="Enter your Email" required><br><br>
            <div class="lab">
                <label for="phone">Phone:</label><br>
            </div>
            <input type="text" id="Phone" name="phone" placeholder="Enter your phone number" maxlength="10" required><br><br>
            <div class="lab">
                <label for="gender">Gender:</label><br>
            </div>
            <select name="gender" id="Gender" required>
                <option disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select><br><br>
            <div class="lab">
                <label for="dob" id="DOB">Date of Birth:</label><br>
            </div>
            <input type="date" id="DOB" name="dob"><br><br>
            <div class="lab">
                <label for="qualification" id="Qualification">Qualification:</label><br>
            </div>
            <select name="qualification" id="Qualification" required>
                <option disabled selected>Select Qualification</option>
                <option value="10p">10th Pass</option>
                <option value="12p">12th Pass</option>
                <option value="BSPS">Bachelor in Pharmaceutical Studies</option>
                <option value="Phd">Masters in Pharmaceutical Studies</option>
            </select><br><br>
            <div class="lab">
                <label for="password">Enter Password:</label><br>
            </div>
            <input type="password" id="pwd" name="password" minlength="8" placeholder="Enter Password" required><br>
            <div>
                <input id="pass" type="checkbox" onclick="myFunction()" placeholder="Show Password">
                <label for="showpass">Show Password</label>
            </div>
            <script>
                function myFunction() {
                    var x = document.getElementById("pwd");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
            </script>
            <br><br>
            <input type="submit" value="Submit" name="submit">
            <input type="reset" value="Reset">
        </form>
    </div>

    <script>
        function checkName() {
            var name = document.getElementById("Name").value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_name.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    var status = document.getElementById("nameStatus");
                    if (response == "empty") {
                        status.innerHTML = "Please enter a Username.";
                        status.style.color = "red";
                    } else if (response == "taken") {
                        status.innerHTML = "Username already taken.";
                        status.style.color = "red";
                    } else if (response == "available") {
                        status.innerHTML = "Username available.";
                        status.style.color = "green";
                    }
                }
            };
            xhr.send("firname=" + encodeURIComponent(name));
        }
    </script>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = filter_input(INPUT_POST, "firname", FILTER_SANITIZE_SPECIAL_CHARS);
    $sname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $qualification = $_POST["qualification"];
    $password = $_POST["password"];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO STAFF (FName, SName, Email, Phone, gender, DOB, Qualification, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssissss", $fname, $sname, $email, $phone, $gender, $dob, $qualification, $hash);

    try {
        mysqli_stmt_execute($stmt);
        echo "<script>alert('User Created Successfully!');</script>";
        echo "<script>alert('You can now Login.');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: {$e->getMessage()}');</script>";
    } finally {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>