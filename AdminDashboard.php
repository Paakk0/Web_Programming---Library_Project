<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="./Styles/AdminDashboardStyle.css">
    </head>
    <body>
        <div class="navigator">
            <h1 class="title"><a href="Main.php">Library Admin Dashboard</a></h1>
        </div>
        <div class="admin-container">

            <!-- Add New Book Form -->
            <section class="admin-section">
                <h2>Add New Book</h2>
                <form method="post" class="add-book-form">
                    <label>Title: <input type="text" name="new_title" required></label>
                    <label>Pages: <input type="number" name="new_pages" required></label>
                    <label>Image URL: <input type="text" name="new_image"></label>
                    <label>Price: <input type="number" name="new_price" required></label>
                    <label>Available Pieces: <input type="number" name="new_available_pieces" required></label>
                    <button type="submit" name="add_book">Add Book</button>
                </form>
            </section>

            <!-- Books Table Section -->
            <section class="admin-section">
                <h2>Books Management</h2>
                <form method="post">
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
                            require_once '../Database/Handler.php';
                            $handler = new Handler();
                            $conn    = $handler->getConnection();
                            $sql     = "SELECT * FROM BOOKS";
                            $result  = mysqli_query($conn, $sql);
                            while ($book    = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                <td>{$book['ID_BOOK']}</td>
                                <td><input type='text' name='books[{$book['ID_BOOK']}][title]' value='{$book['TITLE']}' required></td>
                                <td><input type='number' name='books[{$book['ID_BOOK']}][pages]' value='{$book['PAGES']}' required></td>
                                <td><input type='text' name='books[{$book['ID_BOOK']}][image]' value='{$book['IMAGE']}'></td>
                                <td><input type='number' name='books[{$book['ID_BOOK']}][price]' value='{$book['PRICE']}' step='0.01' required></td>
                                <td><input type='number' name='books[{$book['ID_BOOK']}][available_pieces]' value='{$book['AVAILABLE_PIECES']}' required></td>
                                <td>
                                    <input type='hidden' name='books[{$book['ID_BOOK']}][id]' value='{$book['ID_BOOK']}'>
                                    <button type='submit' name='update_books'>Update</button>
                                    <button type='submit' name='delete_book' value='{$book['ID_BOOK']}'>Delete</button>
                                </td>
                            </tr>";
                            }
                        ?>
                    </table>
                    <button type="submit" name="update_books">Update All Books</button>
                </form>
            </section>

            <!-- Users Table Section -->
            <section class="admin-section">
                <h2>Users Management</h2>
                <form method="post">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Profile Image</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                            $sql    = "SELECT * FROM USERS";
                            $result = mysqli_query($conn, $sql);
                            while ($user   = mysqli_fetch_assoc($result)) {
                                $role = ($user['IS_EMPLOYEE'] == 1) ? 'Employee' : 'Customer';
                                echo "<tr>
                    <td>{$user['ID_USER']}</td>
                    <td><input type='text' name='users[{$user['ID_USER']}][name]' value='{$user['NAME']}' required></td>
                    <td><input type='text' name='users[{$user['ID_USER']}][profile_image]' value='{$user['PROFILE_IMAGE']}'></td>
                    <td><input type='email' name='users[{$user['ID_USER']}][email]' value='{$user['EMAIL']}' required></td>
                    <td><input type='text' name='users[{$user['ID_USER']}][phone]' value='{$user['PHONE']}'></td>
                    <td>
                        <select name='users[{$user['ID_USER']}][role]'>
                            <option value='1'" . ($role == 'Employee' ? ' selected' : '') . ">Employee</option>
                            <option value='0'" . ($role == 'Customer' ? ' selected' : '') . ">Customer</option>
                        </select>
                    </td>
                    <td>
                        <input type='hidden' name='users[{$user['ID_USER']}][id]' value='{$user['ID_USER']}'>
                        <button type='submit' name='update_users'>Update</button>
                        <button type='submit' name='delete_user' value='{$user['ID_USER']}'>Delete</button>
                    </td>
                </tr>";
                            }
                        ?>
                    </table>
                    <button type="submit" name="update_users">Update All Users</button>
                </form>
            </section>


            <!-- Inventory Table Section -->
            <section class="admin-section">
                <h2>Inventory Management</h2>
                <form method="post">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Book ID</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                            $sql    = "SELECT * FROM INVENTORY";
                            $result = mysqli_query($conn, $sql);
                            while ($item   = mysqli_fetch_assoc($result)) {
                                $status = ($item['STATUS'] == 1) ? 'Purchased' : 'In cart';
                                $type   = ($item['TYPE'] == 1) ? 'Permanent' : 'Temporary';

                                echo "<tr>
                    <td>{$item['ID_ROW']}</td>
                    <td><input type='number' name='inventory[{$item['ID_ROW']}][user_id]' value='{$item['ID_USER']}' required></td>
                    <td><input type='number' name='inventory[{$item['ID_ROW']}][book_id]' value='{$item['ID_BOOK']}' required></td>
                    <td>
                        <select name='inventory[{$item['ID_ROW']}][status]'>
                            <option value='1'" . ($status == 'Purchased' ? ' selected' : '') . ">Purchased</option>
                            <option value='0'" . ($status == 'In cart' ? ' selected' : '') . ">In cart</option>
                        </select>
                    </td>
                    <td>
                        <select name='inventory[{$item['ID_ROW']}][type]'>
                            <option value='1'" . ($type == 'Permanent' ? ' selected' : '') . ">Permanent</option>
                            <option value='0'" . ($type == 'Temporary' ? ' selected' : '') . ">Temporary</option>
                        </select>
                    </td>
                    <td><input type='date' name='inventory[{$item['ID_ROW']}][start_date]' value='{$item['START_DATE']}' required></td>
                    <td><input type='date' name='inventory[{$item['ID_ROW']}][end_date]' value='{$item['END_DATE']}'></td>
                    <td>
                        <input type='hidden' name='inventory[{$item['ID_ROW']}][id]' value='{$item['ID_ROW']}'>
                        <button type='submit' name='update_inventory'>Update</button>
                        <button type='submit' name='delete_inventory' value='{$item['ID_ROW']}'>Delete</button>
                    </td>
                </tr>";
                            }
                        ?>
                    </table>
                    <button type="submit" name="update_inventory">Update All Inventory</button>
                </form>
            </section>


        </div>
        <?php
            require_once '../Database/Handler.php';
            $handler = new Handler();
            $conn    = $handler->getConnection();

            if (isset($_POST['add_book'])) {
                $title            = mysqli_real_escape_string($conn, $_POST['new_title']);
                $pages            = (int) $_POST['new_pages'];
                $image            = mysqli_real_escape_string($conn, $_POST['new_image']);
                $price            = (float) $_POST['new_price'];
                $available_pieces = (int) $_POST['new_available_pieces'];

                $query = "INSERT INTO BOOKS (TITLE, PAGES, IMAGE, PRICE, AVAILABLE_PIECES) 
              VALUES ('$title', '$pages', '$image', '$price', '$available_pieces')";

                if (mysqli_query($conn, $query)) {
                    echo "New book added successfully!";
                }
                else {
                    echo "Error adding book: " . mysqli_error($conn);
                }
            }

            if (isset($_POST['update_books'])) {
                if (!empty($_POST['books'])) {
                    foreach ($_POST['books'] as $id => $bookData) {
                        $title            = mysqli_real_escape_string($conn, $bookData['title']);
                        $pages            = (int) $bookData['pages'];
                        $image            = mysqli_real_escape_string($conn, $bookData['image']);
                        $price            = (float) $bookData['price'];
                        $available_pieces = (int) $bookData['available_pieces'];

                        $query = "UPDATE BOOKS SET TITLE = '$title', PAGES = '$pages', IMAGE = '$image', 
                      PRICE = '$price', AVAILABLE_PIECES = '$available_pieces' WHERE ID_BOOK = '$id'";

                        if (!mysqli_query($conn, $query)) {
                            echo "Error updating book: " . mysqli_error($conn);
                        }
                    }
                    echo "Books updated successfully!";
                }
            }

            if (isset($_POST['delete_book'])) {
                $bookId = (int) $_POST['delete_book'];

                $query = "DELETE FROM BOOKS WHERE ID_BOOK = '$bookId'";

                if (mysqli_query($conn, $query)) {
                    echo "Book deleted successfully!";
                }
                else {
                    echo "Error deleting book: " . mysqli_error($conn);
                }
            }

            if (isset($_POST['add_user'])) {
                $name          = mysqli_real_escape_string($conn, $_POST['new_name']);
                $profile_image = mysqli_real_escape_string($conn, $_POST['new_profile_image']);
                $is_employee   = (int) $_POST['new_is_employee'];
                $email         = mysqli_real_escape_string($conn, $_POST['new_email']);
                $phone         = mysqli_real_escape_string($conn, $_POST['new_phone']);
                $password      = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                $query = "INSERT INTO USERS (NAME, PROFILE_IMAGE, IS_EMPLOYEE, EMAIL, PHONE, PASSWORD) 
              VALUES ('$name', '$profile_image', '$is_employee', '$email', '$phone', '$password')";

                if (mysqli_query($conn, $query)) {
                    echo "New user added successfully!";
                }
                else {
                    echo "Error adding user: " . mysqli_error($conn);
                }
            }

            if (isset($_POST['update_users'])) {
                if (!empty($_POST['users'])) {
                    foreach ($_POST['users'] as $id => $userData) {
                        $name          = mysqli_real_escape_string($conn, $userData['name']);
                        $profile_image = mysqli_real_escape_string($conn, $userData['profile_image']);
                        $email         = mysqli_real_escape_string($conn, $userData['email']);
                        $phone         = mysqli_real_escape_string($conn, $userData['phone']);
                        $role          = $userData['role']; // Employee or Customer, you may want to update this too

                        $query = "UPDATE USERS SET NAME = '$name', PROFILE_IMAGE = '$profile_image', 
                      EMAIL = '$email', PHONE = '$phone', IS_EMPLOYEE = '$role' WHERE ID_USER = '$id'";

                        if (!mysqli_query($conn, $query)) {
                            echo "Error updating user: " . mysqli_error($conn);
                        }
                    }
                    echo "Users updated successfully!";
                }
            }


            if (isset($_POST['delete_user'])) {
                $userId = (int) $_POST['delete_user'];

                $query = "DELETE FROM USERS WHERE ID_USER = '$userId'";

                if (mysqli_query($conn, $query)) {
                    echo "User deleted successfully!";
                }
                else {
                    echo "Error deleting user: " . mysqli_error($conn);
                }
            }

            if (isset($_POST['update_inventory'])) {
                if (!empty($_POST['inventory'])) {
                    foreach ($_POST['inventory'] as $id => $inventoryData) {
                        $user_id    = (int) $inventoryData['user_id'];
                        $book_id    = (int) $inventoryData['book_id'];
                        $status     = (int) $inventoryData['status'];
                        $type       = (int) $inventoryData['type'];
                        $start_date = mysqli_real_escape_string($conn, $inventoryData['start_date']);
                        $end_date   = mysqli_real_escape_string($conn, $inventoryData['end_date']);

                        $query = "UPDATE INVENTORY SET ID_USER = '$user_id', ID_BOOK = '$book_id', STATUS = '$status', 
                      TYPE = '$type', START_DATE = '$start_date', END_DATE = '$end_date' WHERE ID_ROW = '$id'";

                        if (!mysqli_query($conn, $query)) {
                            echo "Error updating inventory: " . mysqli_error($conn);
                        }
                    }
                    echo "Inventory updated successfully!";
                }
            }

            if (isset($_POST['delete_inventory'])) {
                $inventoryId = (int) $_POST['delete_inventory'];

                $query = "DELETE FROM INVENTORY WHERE ID_ROW = '$inventoryId'";

                if (mysqli_query($conn, $query)) {
                    echo "Inventory item deleted successfully!";
                }
                else {
                    echo "Error deleting inventory item: " . mysqli_error($conn);
                }
            }
        ?>

    </body>
</html>
