<?php

    require_once 'Handler.php';
    require_once '../Pages/Validation/Authentication.php';
    include 'Model/User.php';
    include 'Model/Book.php';

    function addNewUser($user) {
        $image    = '../Images/default_user_image.png';
        $employee = 0;
        $handler  = new Handler();
        $conn     = $handler->getConnection();
        if (!findUser($user->email, $user->pass)) {
            $stmt = $conn->prepare("INSERT INTO librarydb.users (NAME, PROFILE_IMAGE, IS_EMPLOYEE, EMAIL, PHONE, PASSWORD) VALUES (?, ?, ?, ?, ?, ?)") or die("Prepare failed: " . mysqli_error($conn));
            $stmt->bind_param("ssisss", $user->name, $image, $employee, $user->email, $user->phone, $user->pass);
            $stmt->execute() or die("Execute failed: " . mysqli_error($conn));
            $stmt->close();
            return true;
        }
        else {
            echo "<script type='text/javascript'>alert('Email already taken!');</script>";
            return false;
        }
    }

    function updateUser($sets, $email) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $user    = getUserInfo();
        if (findUser($email, $user['password']) == NULL) {
            $sql    = "UPDATE librarydb.users SET $sets WHERE ID_USER=" . $user['id'];
            $reuslt = mysqli_query($conn, $sql) or die("Execute failed: " . mysqli_error($conn));
            logout();
        }
        else {
            echo "<script type='text/javascript'>alert('Email already taken!');</script>";
        }
        $conn->close();
    }

    function findUser($email, $pass) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $stmt    = $conn->prepare("SELECT * FROM librarydb.users WHERE EMAIL=? AND PASSWORD=?");
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute() or die('User not found: ' . mysqli_error($conn));
        $result  = $stmt->get_result();
        $user    = NULL;
        if ($row     = mysqli_fetch_assoc($result)) {
            $user = new User($row['NAME'], $row['EMAIL'], $row['PHONE'], $row['PASSWORD']);
            $user->setEmployee($row['IS_EMPLOYEE']);
            $user->setImage($row['PROFILE_IMAGE']);
            $user->setId($row['ID_USER']);
        }
        $stmt->close();
        return $user;
    }
    