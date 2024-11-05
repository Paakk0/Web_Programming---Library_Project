<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="./Styles/ProfileStyle.css">
</head>
<body>
    <div class="navigator">
        <h1 class="title"><a href="Main.php">Library</a></h1>
    </div>
    <?php
        require 'Validation/Authentication.php';
        $user     = getUserInfo();
        $employee = $user['employee'] == 1 ? 'Yes' : 'No';
        echo '<form method="post" class="profile-info">'
        . '<div class="profile-image">'
        . '<img src="' . $user['image'] . '" alt="Profile Image"/>'
        . '</div>'
        . '<div class="profile-details">'
        . '<h1 class="Name">' . $user['name'] . '</h1>'
        . '<p>'
        . '<strong>Email:</strong> ' . $user['email'] . '<br>'
        . '<strong>Phone number:</strong> ' . $user['phone'] . '<br>'
        . '<strong>Employee:</strong> ' . $employee
        . '</p>'
        . '</div>'
        . '</form>';
    ?>
</body>
</html>
