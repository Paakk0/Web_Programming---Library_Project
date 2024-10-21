<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log In</title>
        <link rel="stylesheet" href="./Styles/LoginStyle.css"/>
    </head>
    <body>
        <form method="post">
            <input type="text" name="email" placeholder="Email"/><br>
            <input type="password" name="pass" placeholder="Password"/><br>
            <input type="submit" name="submit" value="Log in"/><br>
            <a href="Sign_up.php">Sign up</a>
        </form>
        <?php
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $pass  = $_POST['pass'];
                if (($email != NULL && $pass != NULL)) {
                    login($email, $password);
                }
                else {
                    echo "<script type='text/javascript'>alert('Please fill all fields!');</script>";
                }
            }
        ?>
    </body>
</html>
