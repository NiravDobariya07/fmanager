<?php
include('connection.php');
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    print_r($username);

    $password = $_POST['pass'];
    print_r($password);

    //to prevent from mysqli injection  
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $sql = "select *from users where username = '$username' and password = '$password'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $user_id = $row['id'];
    $count = mysqli_num_rows($result);

    if ($count == 1) {
          /* Success: Set session variables and redirect to Protected page  */
                        if (!empty($_POST["remember"])) {

                            setcookie("username", $_POST["username"], time() + 3600);
                            setcookie("password", $_POST["password"], time() + 3600);
                            echo "Cookies Set Successfuly";
                        } else {
                            setcookie("username", "");
                            setcookie("password", "");
                            echo "Cookie is not set";
                        }

                        
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['username'] = $username;
                        header('location:index.php');
                        exit;
    } else {
        echo "<h1> Login failed. Invalid username or password.</h1>";
    }
}
?>
<html>

<head>
    <title>PHP login system</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div id="frm">
        <h1>Login</h1>
        <form name="f1" action="" onsubmit="return validation()" method="POST">
            <p>
                <label> UserName: </label>
                <input type="text" id="user" name="user" />
            </p>
            <p>
                <label> Password: </label>
                <input type="password" id="pass" name="pass" />
            </p>
             <tr><td><input type="checkbox" name="remember" class="Input"/> Remember me</td>
        </tr>
            <p>
                <input type="submit" id="btn" name="submit" value="Login" />
            </p>
        </form>
    </div>

    <script>
        function validation() {
            var id = document.f1.user.value;
            var ps = document.f1.pass.value;
            if (id.length == "" && ps.length == "") {
                alert("User Name and Password fields are empty");
                return false;
            } else {
                if (id.length == "") {
                    alert("User Name is empty");
                    return false;
                }
                if (ps.length == "") {
                    alert("Password field is empty");
                    return false;
                }
            }
        }
    </script>
</body>

</html>