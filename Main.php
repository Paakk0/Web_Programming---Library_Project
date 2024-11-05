<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Library</title>
        <link rel="stylesheet" href="./Styles/MainStyle.css"/>
    </head>
    <body>
        <div class="navigator">
            <h1 class="title">Library</h1>
            <?php
                require './Validation/Authentication.php';
                if (isLoggedIn()) {
                    $userInfo = getUserInfo();
                    if (isset($_POST['logout'])) {
                        logout();
                        echo "<script type='text/javascript'>window.location.href='Login.php';</script>";
                    }

                    echo '<div class="profile-container">'
                    . '<img src="' . $userInfo['image'] . '" alt="Profile Image" class="profile-image"/>'
                    . '<div class="profile-dropdown">'
                    . '<a href="Profile.php">View Profile</a>'
                    . '<a href="Edit_Profile.php">Edit Profile</a>'
                    . '<a href="Cart.php">Cart</a>'
                    . '<a href="Inventory.php">Inventory</a>';
                    if ($userInfo['employee']) {
                        echo '<a href="AdminDashboard.php">Dashboard</a>';
                    }
                    echo '<form method="post">'
                    . '<button type="submit" name="logout">Log out</button>'
                    . '</form>'
                    . '</div>'
                    . '</div>';
                }
                else {
                    echo '<a href="Login.php" class="btnLogin">Login</a>';
                }
            ?>


        </div>
        <form method="GET" action="Main.php" class="search-container">
            <input type="text" name="search" placeholder="Search books..."/>
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="container">
        <?php
            include_once '../Database/Handler.php';
            include_once '../Database/Notifier.php';
            require_once '../Database/UserOperations.php';

            $handler    = new Handler();
            //$handler->restartDB();
            $handler->initializeDB();
            $conn       = $handler->getConnection();
            $notifier   = new Notifier($conn);
            $notifier->notifyExpiringBooks();
            $searchTerm = NULL;
            if (isset($_GET['search'])) {
                $searchTerm = $_GET['search'];
            }

            if ($searchTerm) {
                $stmt           = $conn->prepare("SELECT * FROM librarydb.books WHERE TITLE LIKE ?");
                $likeSearchTerm = "%" . $searchTerm . "%";
                $stmt->bind_param("s", $likeSearchTerm);
            }
            else {
                $stmt = $conn->prepare("SELECT * FROM librarydb.books");
            }

            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo '<a class="page" href="Index.php?id=' . $row['ID_BOOK'] . '">'
                . '<div class="page-box">'  // New wrapper div
                . '<img src="' . $row['IMAGE'] . '" alt="' . $row['TITLE'] . '_cover"/>'
                . '<span class="book-title">' . $row['TITLE'] . '</span>'
                . '</div></a>';  // Close page-box div
            }

            $stmt->close();
            $conn->close();
        ?>
    </div>


    <button id="scrollBtn" class="scrollToTopBtn">↑</button>
    <script>
        const scrollToTopBtn = document.getElementById("scrollBtn");

        window.onscroll = function () {
            if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                scrollToTopBtn.style.display = "block";
                scrollToTopBtn.style.backgroundColor = "purple";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        };

        scrollToTopBtn.onclick = function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        };
    </script>

</body>
</html>
