<?php

    require_once 'Handler.php';
    include 'Model/User.php';
    include 'Model/Book.php';

    function addNewUser($user) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $stmt    = $conn->prepare("INSERT INTO users (name, email, employee, phone, pass) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $user->name, $user->email, $user->employee, $user->phone, $user->pass);
        $stmt->execute() or die("Could not add new user: " . $stmt->error);
        $stmt->close();
    }

    function findUser($email, $pass) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $stmt    = $conn->prepare("SELECT * FROM librarydb.users WHERE EMAIL=? AND PASSWORD=?");
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $result  = $stmt->get_result();
        if ($row     = mysqli_fetch_assoc($result)) {
            $user = new User($row['NAME'], $row['EMAIL'], $row['IS_EMPLOYEE'], $row['PHONE'], $row['PASSWORD']);
            $user->setId($row['ID_USER']);
        }
        $stmt->close();
        return $user;
    }

    function findBook($id) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $stmt    = $conn->prepare("SELECT * FROM librarydb.books WHERE ID_BOOK = ?") or die('Error preparing SQL: ' . $conn->error);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result  = $stmt->get_result();
        if ($row     = mysqli_fetch_assoc($result)) {
            $book = new Book($row['ID_BOOK'],$row['TITLE'], $row['PAGES'], $row['IMAGE'], $row['PRICE'], $row['AVAILABLE_PIECES']);
            return $book;
        }
        else {
            echo 'Book not found';
            return null;
        }

        $stmt->close();
    }

    function getData($table) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $sql     = 'SELECT * FROM ' . $table;
        $result  = mysqli_query($conn, $sql) or die('Could not get data: ' . mysqli_error($conn));
        return $result;
    }
    