<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book Information</title>
        <link rel="stylesheet" href="IndexStyle.css"/>
    </head>
    <body>
        <div class="infoScreen">
            <?php
                include_once '../Database/Operations.php';
                $book = findBook($_GET['id']);
                echo '<img src="' . $book->image . '"/>'
                . '<div class="info">'
                . '<h1>Title: ' . $book->title . '</h1>'
                . '<p>Pages: ' . $book->pages . '<br>'
                . 'Price: ' . $book->price . '$<br>'
                . 'Available pieces: ' . $book->available_pieces . '</p>'
                . '</div>';
            ?>
        </div>
    </body>
</html>