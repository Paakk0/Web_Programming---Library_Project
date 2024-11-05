<?php

    class Notifier {

        private $conn;

        function __construct($conn) {
            $this->conn = $conn;
        }

        private function getExpiringBooks() {
            $sql = "SELECT u.EMAIL, b.TITLE, i.END_DATE
            FROM INVENTORY i
            JOIN USERS u ON i.ID_USER = u.ID_USER
            JOIN BOOKS b ON i.ID_BOOK = b.ID_BOOK
            WHERE i.END_DATE BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY)";

            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        private function sendExpirationEmail($email, $bookTitle, $endDate) {
            $subject = "Book Expiration Reminder";
            $message = "Dear User,\n\nThis is a reminder that your book '$bookTitle' is due to be returned by $endDate.\n\nPlease return it on time.\n\nThank you!";
            $headers = "From: library@example.com";
            return mail($email, $subject, $message, $headers);
        }

        function notifyExpiringBooks() {
            $expiringBooks = $this->getExpiringBooks();

            if (mysqli_num_rows($expiringBooks) > 0) {
                while ($row = mysqli_fetch_assoc($expiringBooks)) {
                    $this->sendExpirationEmail($row['EMAIL'], $row['TITLE'], $row['END_DATE']);
                }
            }
        }

    }
    