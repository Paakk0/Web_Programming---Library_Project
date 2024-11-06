<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';

    class Notifier {

        private $conn;

        function __construct($conn) {
            $this->conn = $conn;
        }

        private function getExpiringBooks() {
            $sql = "SELECT i.ID_USER, u.EMAIL, b.TITLE, i.END_DATE
            FROM INVENTORY i
            JOIN USERS u ON i.ID_USER = u.ID_USER
            JOIN BOOKS b ON i.ID_BOOK = b.ID_BOOK
            WHERE i.END_DATE BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY)";

            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        private function sendExpirationEmail($email, $bookTitle, $endDate) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Debugoutput = 2;
                $mail->Host        = 'smtp.abv.bg';
                $mail->SMTPAuth    = true;
                $mail->Username    = 'beko1972@abv.bg';
                $mail->Password    = '12031971';
                $mail->SMTPSecure  = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port        = 465;

                $mail->setFrom('beko1972@abv.bg', 'Library Notification');
                $mail->addAddress($email);

                $mail->isHTML(false);
                $mail->Subject = "Book Expiration Reminder";
                $mail->Body    = "Dear User,\n\nThis is a reminder that your book '$bookTitle' is due to be returned by $endDate.\n\nPlease return it on time.\n\nThank you!";

                $mail->send();
            } catch (Exception $e) {
                if (getUserInfo()['employee']) {
                    echo "<script type='text/javascript'>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
                }
            }
        }

        function notifyExpiringBooks() {
            $expiringBooks = $this->getExpiringBooks();
            if (mysqli_num_rows($expiringBooks) > 0) {
                while ($row = mysqli_fetch_assoc($expiringBooks)) {
                    if ($row['ID_USER'] == getUserInfo()['id']) {
                        $this->sendExpirationEmail($row['EMAIL'], $row['TITLE'], $row['END_DATE']);
                    }
                }
            }
        }

    }
    