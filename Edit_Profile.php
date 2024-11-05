<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Editor</title>
    <link rel="stylesheet" href="./Styles/EditProfileStyle.css"/>
</head>
<body>
    <div class="navigator">
        <h1 class="title"><a href="Main.php">Library</a></h1>
    </div>
    <?php
        include_once 'Validation/Authentication.php';
        include_once '../Database/UserOperations.php';
        $user     = getUserInfo();
        $employee = $user['employee'] == 1 ? 'Yes' : 'No';
        echo '<form method="post" enctype="multipart/form-data" class="profile-info">'
        . '<div class="profile-image">'
        . '<img src="' . $user['image'] . '" class="profile-pic"/>'
        . '<input type="file" name="image" class="image-input"/>'
        . '</div>'
        . '<div class="profile-details">'
        . '<input type="text" name="name" placeholder="' . $user['name'] . '"/>'
        . '<input type="text" name="email" placeholder="' . $user['email'] . '"/>'
        . '<input type="text" name="phone" placeholder="' . $user['phone'] . '"/>'
        . '</div>'
        . '<input type="submit" name="save" value="Save changes">'
        . '</form>';
        if (isset($_POST['save'])) {
            $password = $user['password'];
            $sets     = array();
            $name     = $_POST['name'];
            $email    = $_POST['email'];
            $phone    = $_POST['phone'];
            $image    = NULL;
            if ($name != NULL) {
                $sets[count($sets)] = "NAME='" . $name . "'";
            }
            if ($email != NULL) {
                $sets[count($sets)] = "EMAIL='" . $email . "'";
            }
            if ($phone != NULL) {
                $sets[count($sets)] = "PHONE='" . $phone . "'";
            }
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image_path         = move_uploaded_file($_FILES['image']['tmp_name'], "../Images/" . $_FILES['image']['name']);
                $sets[count($sets)] = "PROFILE_IMAGE='../Images/" . $_FILES['image']['name'] . "'";
            }
            if (count($sets) > 0) {
                updateUser(implode(', ', $sets), $email);
                echo "<script>window.location.href = 'Main.php';</script>";
            }
            echo "<script>window.location.href = 'Profile.php';</script>";
        }
    ?>
</body>
</html>
