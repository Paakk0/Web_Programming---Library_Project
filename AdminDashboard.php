<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="AdminDashboardStyle.css">
    </head>
    <body>
        <div class="navigator">
            <h1 class="title"><a href="Main.php">Library Admin Dashboard</a></h1>
        </div>
        <div class="admin-container">

            <?php
                require_once '../Database/Handler.php';
                $handler = new Handler();
                $conn    = $handler->getConnection();

                if (isset($_POST['delete_book'])) {
                    $id = $_POST['book_id'];
                    $handler->deleteRecord('books', 'ID_BOOK', $id);
                }
                if (isset($_POST['delete_user'])) {
                    $id = $_POST['user_id'];
                    $handler->deleteRecord('users', 'ID_USER', $id);
                }
                if (isset($_POST['delete_inventory'])) {
                    $id = $_POST['row_id'];
                    $handler->deleteRecord('inventory', 'ID_ROW', $id);
                }

                if (isset($_POST['update_book'])) {
                    $id               = $_POST['book_id'];
                    $title            = $_POST['title'];
                    $pages            = $_POST['pages'];
                    $image            = $_POST['image'];
                    $price            = $_POST['price'];
                    $available_pieces = $_POST['available_pieces'];
                    $handler->updateRecord('books', $id, [
                        'TITLE' => $title,
                        'PAGES' => $pages,
                        'IMAGE' => $image,
                        'PRICE' => $price,
                        'AVAILABLE_PIECES' => $available_pieces
                    ]);
                }

                if (isset($_POST['update_user'])) {
                    $id            = $_POST['user_id'];
                    $name          = $_POST['name'];
                    $profile_image = $_POST['profile_image'];
                    $is_employee   = $_POST['is_employee'];
                    $email         = $_POST['email'];
                    $phone         = $_POST['phone'];
                    $handler->updateRecord('users', $id, [
                        'NAME' => $name,
                        'PROFILE_IMAGE' => $profile_image,
                        'IS_EMPLOYEE' => $is_employee,
                        'EMAIL' => $email,
                        'PHONE' => $phone
                    ]);
                }

                if (isset($_POST['update_inventory'])) {
                    $id         = $_POST['row_id'];
                    $status     = $_POST['status'];
                    $type       = $_POST['type'];
                    $start_date = $_POST['start_date'];
                    $end_date   = $_POST['end_date'];
                    $handler->updateRecord('inventory', $id, [
                        'STATUS' => $status,
                        'TYPE' => $type,
                        'START_DATE' => $start_date,
                        'END_DATE' => $end_date
                    ]);
                }
            ?>

            <!-- BOOKS Table Section -->
            <section class="admin-section">
                <h2>Books Management</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Pages</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Available Pieces</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $books = $handler->getData('librarydb.books');

                        while ($book = mysqli_fetch_assoc($books)) {
                            echo "<tr>
                            <form method='post' class='inline-form'>
                                <td>{$book['ID_BOOK']}</td>
                                <td><input type='text' name='title' value='{$book['TITLE']}' required/></td>
                                <td><input type='number' name='pages' value='{$book['PAGES']}' required/></td>
                                <td><input type='text' name='image' value='{$book['IMAGE']}' required/></td>
                                <td><input type='number' name='price' value='{$book['PRICE']}' step='0.01' required/></td>
                                <td><input type='number' name='available_pieces' value='{$book['AVAILABLE_PIECES']}' required/></td>
                                <td>
                                    <input type='hidden' name='book_id' value='{$book['ID_BOOK']}'/>
                                    <button type='submit' name='update_book'>Update</button>
                                    <button type='submit' name='delete_book'>Delete</button>
                                </td>
                            </form>
                        </tr>";
                        }
                    ?>
                </table>
            </section>

            <!-- USERS Table Section -->
            <section class="admin-section">
                <h2>Users Management</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Profile Image</th>
                        <th>Employee</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $users = $handler->getData('librarydb.users');

                        while ($user = mysqli_fetch_assoc($users)) {
                            $is_employee = $user['IS_EMPLOYEE'] ? 'Yes' : 'No';
                            echo "<tr>
                            <form method='post' class='inline-form'>
                                <td>{$user['ID_USER']}</td>
                                <td><input type='text' name='name' value='{$user['NAME']}' required/></td>
                                <td><input type='text' name='profile_image' value='{$user['PROFILE_IMAGE']}' required/></td>
                                <td>
                                    <select name='is_employee'>
                                        <option value='1' " . ($user['IS_EMPLOYEE'] ? 'selected' : '') . ">Yes</option>
                                        <option value='0' " . (!$user['IS_EMPLOYEE'] ? 'selected' : '') . ">No</option>
                                    </select>
                                </td>
                                <td><input type='email' name='email' value='{$user['EMAIL']}' required/></td>
                                <td><input type='text' name='phone' value='{$user['PHONE']}' required/></td>
                                <td>
                                    <input type='hidden' name='user_id' value='{$user['ID_USER']}'/>
                                    <button type='submit' name='update_user'>Update</button>
                                    <button type='submit' name='delete_user'>Delete</button>
                                </td>
                            </form>
                        </tr>";
                        }
                    ?>
                </table>
            </section>

            <!-- INVENTORY Table Section -->
            <section class="admin-section">
                <h2>Inventory Management</h2>
                <table>
                    <tr>
                        <th>Row ID</th>
                        <th>User ID</th>
                        <th>Book ID</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $inventory = $handler->getData('librarydb.inventory');

                        while ($item = mysqli_fetch_assoc($inventory)) {
                            $status = $item['STATUS'] ? 'Purchased' : 'In Cart';
                            $type   = $item['TYPE'] ? 'Permanent' : 'Temporary';
                            echo "<tr>
                            <form method='post' class='inline-form'>
                                <td>{$item['ID_ROW']}</td>
                                <td>{$item['ID_USER']}</td>
                                <td>{$item['ID_BOOK']}</td>
                                <td>
                                    <select name='status'>
                                        <option value='1' " . ($item['STATUS'] ? 'selected' : '') . ">Purchased</option>
                                        <option value='0' " . (!$item['STATUS'] ? 'selected' : '') . ">In Cart</option>
                                    </select>
                                </td>
                                <td>
                                    <select name='type'>
                                        <option value='1' " . ($item['TYPE'] ? 'selected' : '') . ">Permanent</option>
                                        <option value='0' " . (!$item['TYPE'] ? 'selected' : '') . ">Temporary</option>
                                    </select>
                                </td>
                                <td><input type='date' name='start_date' value='{$item['START_DATE']}'/></td>
                                <td><input type='date' name='end_date' value='{$item['END_DATE']}'/></td>
                                <td>
                                    <input type='hidden' name='row_id' value='{$item['ID_ROW']}'/>
                                    <button type='submit' name='update_inventory'>Update</button>
                                    <button type='submit' name='delete_inventory'>Delete</button>
                                </td>
                            </form>
                        </tr>";
                        }
                    ?>
                </table>
            </section>
        </div>
    </body>
</html>
