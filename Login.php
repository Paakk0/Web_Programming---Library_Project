<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log In</title>
        <link rel="stylesheet" href="./Styles/LoginStyle.css"/>
    </head>
    <body>
        <div class="navigator">
            <h1 class="title"><a href="Main.php">Library</a></h1>
        </div>
        <form method="post">
            <input type="text" name="email" placeholder="Email" required/><br>
            <input type="password" name="pass" placeholder="Password" required/><br>
            <input type="submit" name="submit" value="Log in"/><br>
            <a href="Sign_up.php">Sign up</a>
        </form>
        <?php
            include_once 'Validation/Authentication.php';
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $pass  = $_POST['pass'];
                if (($email != NULL && $pass != NULL)) {
                    if (login($email, $pass)) {
                        echo "<script type='text/javascript'>window.location.href='Main.php';</script>";
                    }
                    else {
                        echo "<script type='text/javascript'>alert('User not found!');</script>";
                    }
                }
                else {
                    echo "<script type='text/javascript'>alert('Please fill all fields!');</script>";
                }
            }
        ?>
    </body>
</html>
