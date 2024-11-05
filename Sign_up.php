<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>
        <link rel="stylesheet" href="./Styles/LoginStyle.css"/>
    </head>
    <body>
        <div class="navigator">
            <h1 class="title"><a href="Main.php">Library</a></h1>
        </div>
        <form method="post">
            <input type="text" name="name" placeholder="Name" required/><br>
            <input type="text" name="email" placeholder="Email" required/><br>
            <input type="text" name="phone" placeholder="Phone number" required/><br>
            <input type="password" name="pass" placeholder="Password" required/><br>
            <input type="submit" name="submit" value="Sign up"/><br>
            <a href="Login.php">Log in</a>
        </form>
        <?php
            include_once 'Validation/Authentication.php';
            include_once '../Database/UserOperations.php';
            if (isset($_POST['submit'])) {
                $name  = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $pass  = $_POST['pass'];
                if (checkSignUp($name, $email, $phone, $pass)) {
                    if (addNewUser(new User($name, $email, $phone, $pass))) {
                        login($email, $pass);
                        echo "<script type='text/javascript'>window.location.href='Main.php';</script>";
                    }
                }
            }
        ?>
    </body>
</html>
