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
            <input type="text" name="name" placeholder="Name"/><br>
            <input type="text" name="email" placeholder="Email"/><br>
            <input type="text" name="phone" placeholder="Phone number"/><br>
            <input type="password" name="pass" placeholder="Password"/><br>
            <input type="submit" name="submit" value="Sign up"/><br>
            <a href="Login.php">Log in</a>
        </form>
        <?php
            include_once 'Validation/Authentification.php';
            include_once '../Database/Operations.php';
            if (isset($_POST['submit'])) {
                $name  = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $pass  = $_POST['pass'];
                if (checkAllFields($name, $email, $phone, $pass)) {
                    addNewUser(new User($name, $email, 0, $phone, $pass));
                    login($email, $password);
                }
            }
        ?>
    </body>
</html>
