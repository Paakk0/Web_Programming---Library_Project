<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventory</title>
        <link rel="stylesheet" href="./Styles/InventoryStyle.css"/>
    </head>
    <body>
        <div class="navigator">
            <h1 class="title"><a href="Main.php">Library</a></h1>
        </div>
        <div class="inventory-container">
            <h2>Your Inventory</h2>
            <?php
                require_once '../Database/Handler.php';
                require_once '../Database/UserOperations.php';
                require_once '../Database/BookOperations.php';

                $handler = new Handler();
                $conn    = $handler->getConnection();
                $result  = $handler->getData('librarydb.inventory');

                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="inventory-list">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['STATUS'] == 1 && $row['ID_USER'] == getUserInfo()['id']) {
                            $book    = findBook($row['ID_BOOK']);
                            $price   = $row['TYPE'] == 1 ? $book->price : $book->price * 0.2;
                            $type    = $row['TYPE'] == 0 ? 'Temporary' : 'Permanent';
                            $bgColor = $row['TYPE'] == 0 ? '#fcebbd' : '#d9fdd3';

                            echo '<div class="inventory-card" style="background-color:' . $bgColor . ';">';
                            echo '<h3>' . htmlspecialchars($book->title) . '</h3>';
                            echo '<p><strong>Pages:</strong> ' . htmlspecialchars($book->pages) . '</p>';
                            echo '<p><strong>Price:</strong> ' . htmlspecialchars($price) . '$</p>';
                            echo '<p><strong>Purchase Type:</strong> ' . htmlspecialchars($type) . '</p>';
                            echo '<p><strong>Purchase Date:</strong> ' . htmlspecialchars($row['START_DATE']) . '</p>';

                            if ($row['TYPE'] == 0) {
                                echo '<p><strong>Return Date:</strong> ' . htmlspecialchars($row['END_DATE']) . '</p>';

                                echo '<form method="POST">';
                                echo '<input type="hidden" name="inventory_id" value="' . htmlspecialchars($row['ID_ROW']) . '">';
                                echo '<button type="submit" class="return-button">Return</button>';
                                echo '</form>';
                            }

                            echo '</div>';
                        }
                    }
                    echo '</div>';
                }
                else {
                    echo '<p>No items in inventory.</p>';
                }
                if (isset($_POST['inventory_id'])) {
                    $inventoryId = $_POST['inventory_id'];

                    $handler = new Handler();
                    $conn    = $handler->getConnection();
                    $sql     = "UPDATE INVENTORY SET STATUS = 0 WHERE ID_ROW = $inventoryId";
                    $result  = mysqli_query($conn, $sql) or die("Error returning book: " . mysqli_error($conn));
                    if ($result) {
                        echo "<script>alert('Book returned successfully!'); window.location.href='Inventory.php';</script>";
                    }
                    $conn->close();
                }
            ?>
        </div>
    </body>
</html>
