<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cart</title>
        <link rel="stylesheet" href="./Styles/CartStyle.css"/>
    </head>
    <body>
        <div class="navigator">
            <h1 class="title"><a href="Main.php">Library</a></h1>
        </div>
        <?php
            require_once '../Database/Handler.php';
            require_once '../Database/UserOperations.php';
            require_once '../Database/BookOperations.php';
            $handler = new Handler();
            $conn    = $handler->getConnection();
            $result  = $handler->getData('librarydb.inventory');

            echo '<ol>';
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['STATUS'] == 0) {
                    $book  = findBook($row['ID_BOOK']);
                    $price = $row['TYPE'] == 1 ? $book->price : $book->price * 0.2;
                    $type  = $row['TYPE'] == 0 ? 'Temporary' : 'Permanent';
                    echo "<li>"
                    . "Title: $book->title<br>"
                    . "Pages: $book->pages<br>"
                    . "Price: $price$<br>"
                    . "Purchase type: $type<br>"
                    . '<form method="post" style="display:inline;">'
                    . '<input type="hidden" name="remove_id" value="' . $row['ID_ROW'] . '"/>'
                    . '<button type="submit" name="remove" class="remove-button">Remove</button>'
                    . '</form>'
                    . "</li>";
                }
            }
            echo '</ol>';

            echo '<form method="post">'
            . '<button type="submit" name="checkout" id="checkout-button">Checkout</button>'
            . '</form>';

            if (isset($_POST['checkout'])) {
                checkout();
                header("Location: Inventory.php");
                exit;
            }

            if (isset($_POST['remove'])) {
                $id = $_POST['remove_id'];
                removeBook($id);
                header("Refresh:0");
                exit;
            }
        ?>
    </body>
</html>
