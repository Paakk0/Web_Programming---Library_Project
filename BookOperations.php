<?php

    function removeBook($id) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $stmt    = $conn->prepare("DELETE FROM librarydb.inventory WHERE ID_ROW=?") or die('Error preparing SQL: ' . $conn->error);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    function addBook($bookId, $type) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $status  = 0;
        $stmt    = $conn->prepare("INSERT INTO librarydb.inventory (ID_USER, ID_BOOK, STATUS, TYPE) VALUES (?, ?, ?, ?)") or die("Prepare failed: " . mysqli_error($conn));
        $stmt->bind_param("iiii", getUserInfo()['id'], $bookId, $status, $type);
        $stmt->execute() or die("Execute failed: " . mysqli_error($conn));
        echo "<script type='text/javascript'>alert('Succesfuly added book!');</script>";
    }

    function findBook($id) {
        $handler = new Handler();
        $conn    = $handler->getConnection();
        $stmt    = $conn->prepare("SELECT * FROM librarydb.books WHERE ID_BOOK = ?") or die('Error preparing SQL: ' . $conn->error);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result  = $stmt->get_result();
        if ($row     = mysqli_fetch_assoc($result)) {
            $book = new Book($row['ID_BOOK'], $row['TITLE'], $row['PAGES'], $row['IMAGE'], $row['PRICE'], $row['AVAILABLE_PIECES']);
            return $book;
        }
        else {
            echo 'Book not found';
            return null;
        }

        $stmt->close();
    }

    function checkout() {
        $handler   = new Handler();
        $conn      = $handler->getConnection();
        $status    = 1;
        $startDate = date('Y-m-d');
        $stmt      = $conn->prepare("UPDATE librarydb.inventory SET STATUS=?, START_DATE=? WHERE ID_USER=? AND STATUS=0") or die("Prepare failed: " . mysqli_error($conn));
        $stmt->bind_param("isi", $status, $startDate, getUserInfo()['id']);
        $stmt->execute() or die("Execute failed: " . mysqli_error($conn));
        updateEndDateForTemporaryBooks($conn, getUserInfo()['id'], $startDate);
    }

    function updateEndDateForTemporaryBooks($conn, $userId, $startDate) {
        $endDate = date('Y-m-d', strtotime($startDate . ' + 30 days'));
        $stmt    = $conn->prepare("UPDATE librarydb.inventory SET END_DATE = ? WHERE ID_USER = ? AND STATUS = 1 AND TYPE = 0") or die("Prepare failed: " . mysqli_error($conn));
        $stmt->bind_param("si", $endDate, $userId);
        $stmt->execute() or die("Execute failed: " . mysqli_error($conn));
        $stmt->close();
    }
    