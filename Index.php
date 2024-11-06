<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book Information</title>
        <link rel="stylesheet" href="./Styles/IndexStyle.css"/>
    </head>
    <body>
        <div class="infoScreen">
            <?php
                include_once '../Database/BookOperations.php';
                include_once './Validation/Authentication.php';
                $book = findBook($_GET['id']);
                echo '<img src="' . $book->image . '"/>'
                . '<div class="secondary">'
                . '<div class="info">'
                . '<h1>Title: ' . $book->title . '</h1>'
                . '<p>'
                . 'Pages: ' . $book->pages . '<br>'
                . 'Full Price: ' . $book->price . '$<br>'
                . 'Borrow Price: ' . number_format(($book->price * 0.20), 2, '.', '') . '$<br>'
                . 'Available pieces: ' . $book->available_pieces
                . '</p>'
                . '</div>'
                . '<form method="post">'
                . '<input type="submit" name="borrow" value="Borrow"/>'
                . '<input type="submit" name="buy" value="Buy"/>'
                . '</form>'
                . '</div>';

                if (isset($_POST['buy'])) {
                    if (isLoggedIn()) {
                        if ($book->available_pieces > 0) {
                            addBook($book->id, 1);
                            header("Location: Main.php");
                            exit;
                        }
                    }
                    else {
                        header("Location: Login.php");
                        exit;
                    }
                }
                else if (isset($_POST['borrow'])) {
                    if (isLoggedIn()) {
                        if ($book->available_pieces > 0) {
                            addBook($book->id, 0);
                            header("Location: Main.php");
                            exit;
                        }
                    }
                    else {
                        header("Location: Login.php");
                        exit;
                    }
                }
            ?>
        </div>
    </body>
</html>