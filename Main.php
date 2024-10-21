<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Library Project</title>
        <link rel="stylesheet" href="./Styles/MainStyle.css"/>
    </head>
    <body>
        <div class="navigator">
            <a href="Login.php">Login</a>
        </div>

        <div class="container">
            <?php
                include_once '../Database/Handler.php';
                require_once '../Database/Operations.php';

                $handler = new Handler();
                $handler->restartDB();
                $handler->initializeDB();

                $result = getData('librarydb.books');
                while ($row    = mysqli_fetch_assoc($result)) {
                    echo'<a class="page" href="Index.php?id=' . $row['ID_BOOK'] . '">'
                    . '<img src="' . $row['IMAGE'] . '" alt="' . $row['TITLE'] . '_cover"/>'
                    . '<span>' . $row['TITLE'] . '</span>'
                    . '</a>';
                }
            ?>
        </div>

        <?php
            if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_name']) && isset($_COOKIE['user_email']) && isset($_COOKIE['user_phone'])) {
                $userName = htmlspecialchars($_COOKIE['user_name']);
                echo "Welcome, " . $userName;
            }
        ?>
    </body>
</html>
